<?php
/**
 * code
 *      1**     权限类型
 *      200     成功
 */


// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit; // finish preflight CORS requests here
}


if (!empty($_REQUEST['debug'])) {
    $random = rand(0, intval($_REQUEST['debug']));
    if ($random === 0) {
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    }
}

@set_time_limit(5 * 60);

$targetDir = '../runtime/upload_tmp';
$uploadDir = 'assets/upload';

$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds

if (!file_exists($targetDir)) {
    @mkdir($targetDir);
}

if (!file_exists($uploadDir)) {
    @mkdir($uploadDir);
}

// Get a file name
//if (isset($_REQUEST["name"])) {
//    $fileName = $_REQUEST["name"];
//} elseif (!empty($_FILES)) {
//    $fileName = $_FILES["file"]["name"];
//} else {
//    $fileName = uniqid("file_");
//}

//文件名格式
if (isset($_REQUEST["name"])) {
    //$fileName = $_REQUEST["name"];
    $fileName = date("YmdHis") . "_" . rand("1000", "9999") . "." . pathinfo($_REQUEST["name"],PATHINFO_EXTENSION);
} elseif (!empty($_FILES)) {
    //$fileName = $_FILES["file"]["name"];
    $fileName = date("YmdHis") . "_" . rand("1000", "9999") . "." . pathinfo($_FILES['files']['name'],PATHINFO_EXTENSION);
} else {
    $fileName = uniqid("file_");
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
$uploadPath = $uploadDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;

$response = [];
// Remove old temp files
if ($cleanupTargetDir) {
    if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
//        die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
        $response['code'] = 100;
        $response['msg'] = '打开temp目录失败！';//目录没有权限
        $response['data'] = (object)NULL;
        die(json_encode($response));
    }

    while (($file = readdir($dir)) !== false) {
        $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

        // If temp file is current file proceed to the next
        if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
            continue;
        }

        // Remove temp file if it is older than the max age and is not the current file
        if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
            @unlink($tmpfilePath);
        }
    }
    closedir($dir);
}


// Open temp file
if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
//    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
    $response['code'] = 101;
    $response['msg'] = '写入文件失败！';//目录没有权限
    $response['data'] = (object)NULL;
    die(json_encode($response));
}

if (!empty($_FILES)) {
    if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
//        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
        $response['code'] = 102;
        $response['msg'] = '移动文件失败！';//目录没有权限
        $response['data'] = (object)NULL;
        die(json_encode($response));
    }

    // Read binary input stream and append it to temp file
    if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
//        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        $response['code'] = 103;
        $response['msg'] = '打开文件失败！';//目录没有权限
        $response['data'] = (object)NULL;
        die(json_encode($response));
    }
} else {
    if (!$in = @fopen("php://input", "rb")) {
//        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
        $response['code'] = 104;
        $response['msg'] = '打开文件失败！';//目录没有权限
        $response['data'] = (object)NULL;
        die(json_encode($response));
    }
}

while ($buff = fread($in, 4096)) {
    fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

$index = 0;
$done = true;
for ($index = 0; $index < $chunks; $index++) {
    if (!file_exists("{$filePath}_{$index}.part")) {
        $done = false;
        break;
    }
}
if ($done) {
    if (!$out = @fopen($uploadPath, "wb")) {
//        die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        $response['code'] = 105;
        $response['msg'] = '打开文件失败！';//目录没有权限
        $response['data'] = (object)NULL;
        die(json_encode($response));
    }

    if (flock($out, LOCK_EX)) {
        for ($index = 0; $index < $chunks; $index++) {
            if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                break;
            }

            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }

            @fclose($in);
            @unlink("{$filePath}_{$index}.part");
        }

        flock($out, LOCK_UN);
    }
    @fclose($out);
}

$response['code'] = 200;
$response['msg'] = '上传成功！';
$response['data'] = ['uploadPath' => str_replace('\\', "/", $uploadPath)];//返回的是服务器相对路径。前台拼装路径
die(json_encode($response));
