<?php
/**
 * Copyright (c) 2012-2017 MemberSystem
 * MemberSystem Electronic Commerce Technology Team
 * created by Wenjie·Chen <glart_c@bbmmarin.com> at 2017/09/19 17:25
 */

namespace Upload;

class UploadPic
{
    public $errorMsg;

    public $thumbPrefix = "thumb_";

    public $quality = 90; //jpeg quality

    public $destinationDirectory;

    public $thumbSquareSize = 200;//Thumbnail will be 200x200

    /**
     * @param $file 将FILE保存到这个变量
     * @param string $imageName post过来的_POST['ImageName']
     * @param int $containerWidth post过来的_POST['w']
     * @param int $containerHeight post过来的_POST['h']
     */
    public function save($file, $imageName, $containerWidth, $containerHeight)
    {
        $destinationDirectory = getcwd() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
        // Random number will be added after image name
        $randomNumber = rand(0, 9999999999);

        $imageNameStr = str_replace(' ', '-', strtolower($file[$imageName]['name'])); //get image name
        $imageSize = $file[$imageName]['size']; // get original image size
        $tempSrc = $file[$imageName]['tmp_name']; // Temp name of image file stored in PHP tmp folder
        $imageType = $file[$imageName]['type']; //get file type, returns "image/png", image/jpeg, text/plain etc.
        //Let's check allowed $ImageType, we use PHP SWITCH statement here
        switch (strtolower($imageType)) {
            case 'image/png':
                //Create a new image from file
                $createdImage = imagecreatefrompng($file[$imageName]['tmp_name']);
                break;
            case 'image/gif':
                $createdImage = imagecreatefromgif($file[$imageName]['tmp_name']);
                break;
            case 'image/jpeg':
            case 'image/pjpeg':
                $createdImage = imagecreatefromjpeg($file[$imageName]['tmp_name']);
                break;
            default:
                die('Unsupported File!'); //output error and exit
        }

        //PHP getimagesize() function returns height/width from image file stored in PHP tmp folder.
        //Get first two values from image, width and height.
        //list assign svalues to $CurWidth,$CurHeight
        list($curWidth, $curHeight) = getimagesize($tempSrc);
        $imageRatio = $curWidth / $curHeight;

        $srcWidth = $curWidth;
        $srcHeight = $curHeight;
        // Resize image proportionally according to the size of container
        if ($curWidth > $containerWidth) {
            $curWidth = $containerWidth;
            $curHeight = $curWidth / $imageRatio;
        }
        if ($curHeight > $containerHeight) {
            $curHeight = $containerHeight;
            $curWidth = $curHeight / $imageRatio;
        }

        if ($curWidth < $containerWidth) {
            $curWidth = $containerWidth;
            $curHeight = $curWidth / $imageRatio;
        }
        if ($curHeight < $containerHeight) {
            $curHeight = $containerHeight;
            $curWidth = $curHeight * $imageRatio;
        }

        //Get file extension from Image name, this will be added after random name
        $imageExt = substr($imageNameStr, strrpos($imageNameStr, '.'));
        $imageExt = str_replace('.', '', $imageExt);

        //remove extension from filename
        $imageNameStr = preg_replace("/\\.[^.\\s]{3,4}$/", "", $imageNameStr);

        //Construct a new name with random number and extension.
        $newImageName = $imageNameStr . '-' . $randomNumber . '.' . $imageExt;

        //set the Destination Image
        $thumbDestRandImageName = $destinationDirectory . $this->thumbPrefix . $newImageName; //Thumbnail name with destination directory
        $destRandImageName = $destinationDirectory . $newImageName; // Image with destination directory

        //Resize image to Specified Size by calling resizeImage function.
        if ($this->resizeImage($curWidth, $curHeight, $destRandImageName, $createdImage, $this->quality, $imageType,
            $srcWidth,
            $srcHeight)) {
            //Create a square Thumbnail right after, this time we are using cropImage() function
            if (!$this->cropImage($curWidth, $curHeight, $this->thumbSquareSize, $thumbDestRandImageName, $createdImage,
                $this->quality,
                $imageType)) {
                echo 'Error Creating thumbnail';
            }
            /*
            We have succesfully resized and created thumbnail image
            We can now output image to user's browser or store information in the database
            */
            $json = array(
                "imgSrc" => ("uploads/" . $newImageName),
                "thumbSrc" => ("uploads/" . $this->thumbPrefix . $newImageName)
            );

            echo json_encode($json);

            /****************************************************/
            /****************************************************/
            /*
            // Insert info into database table!
            mysql_query("INSERT INTO myImageTable (ImageName, ThumbName, ImgPath)
            VALUES ($DestRandImageName, $thumb_DestRandImageName, 'uploads/')");
            /****************************************************/
            /****************************************************/

        } else {
            die('Resize Error'); //output error
        }
    }

    /**
     * This function will proportionally resize image
     * @param $CurWidth
     * @param $CurHeight
     * @param $DestFolder
     * @param $SrcImage
     * @param $Quality
     * @param $ImageType
     * @param $src_width
     * @param $src_height
     * @return bool
     */
    function resizeImage($CurWidth, $CurHeight, $DestFolder, $SrcImage, $Quality, $ImageType, $src_width, $src_height)
    {
        //Check Image size is not 0
        if ($CurWidth <= 0 || $CurHeight <= 0) {
            return false;
        }

        $NewWidth = ceil($CurWidth);
        $NewHeight = ceil($CurHeight);

        //Construct a proportional size of new image
        $NewCanves = imagecreatetruecolor($NewWidth, $NewHeight);

        // Resize Image
        if (imagecopyresized($NewCanves, $SrcImage, 0, 0, 0, 0, $NewWidth, $NewHeight, $src_width, $src_height)) {
            switch (strtolower($ImageType)) {
                case 'image/png':
                    imagepng($NewCanves, $DestFolder);
                    break;
                case 'image/gif':
                    imagegif($NewCanves, $DestFolder);
                    break;
                case 'image/jpeg':
                case 'image/pjpeg':
                    imagejpeg($NewCanves, $DestFolder, $Quality);
                    break;
                default:
                    return false;
            }
            //Destroy image, frees memory
            if (is_resource($NewCanves)) {
                imagedestroy($NewCanves);
            }

            return true;
        }

    }

    /**
     * This function corps image to create exact square images, no matter what its original size!
     * @param $CurWidth
     * @param $CurHeight
     * @param $iSize
     * @param $DestFolder
     * @param $SrcImage
     * @param $Quality
     * @param $ImageType
     * @return bool
     */
    function cropImage($CurWidth, $CurHeight, $iSize, $DestFolder, $SrcImage, $Quality, $ImageType)
    {
        //Check Image size is not 0
        if ($CurWidth <= 0 || $CurHeight <= 0) {
            return false;
        }

        //abeautifulsite.net has excellent article about "Cropping an Image to Make Square bit.ly/1gTwXW9
        if ($CurWidth > $CurHeight) {
            $y_offset = 0;
            $x_offset = ($CurWidth - $CurHeight) / 2;
            $square_size = $CurWidth - ($x_offset * 2);
        } else {
            $x_offset = 0;
            $y_offset = ($CurHeight - $CurWidth) / 2;
            $square_size = $CurHeight - ($y_offset * 2);
        }

        $NewCanves = imagecreatetruecolor($iSize, $iSize);
        if (imagecopyresampled($NewCanves, $SrcImage, 0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size,
            $square_size)) {
            switch (strtolower($ImageType)) {
                case 'image/png':
                    imagepng($NewCanves, $DestFolder);
                    break;
                case 'image/gif':
                    imagegif($NewCanves, $DestFolder);
                    break;
                case 'image/jpeg':
                case 'image/pjpeg':
                    imagejpeg($NewCanves, $DestFolder, $Quality);
                    break;
                default:
                    return false;
            }
            //Destroy image, frees memory
            if (is_resource($NewCanves)) {
                imagedestroy($NewCanves);
            }

            return true;

        }
    }
}