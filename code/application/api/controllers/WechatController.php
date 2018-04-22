<?php

namespace api\controllers;

use Yii;
use library\wechat\Wechat;
use library\wechat\WechatAuth;
use common\services\WechatConfigService;
use common\services\WechatKeywordService;
use common\services\WechatArticlesService;
use common\services\WechatArticleService;
use common\controllers\BaseController;

/**
 * 接收微信推送处理
 */
class WechatController extends BaseController
{

	public $enableCsrfValidation = false;

    /**
     * 微信消息接口入口
     * 所有发送到微信的消息都会推送到该操作
     * 所以，微信公众平台后台填写的api地址则为该操作的访问地址
     */
    public function actionHandle($id = ''){
        //调试
        try{
			$config = WechatConfigService::getConfigById($id, 'token,appid,encodingaeskey');

            /* 加载微信SDK */
            $wechat = new Wechat($config['token'], $config['appid'], $config['encodingaeskey']);
            
            /* 获取请求信息 */
            $data = $wechat->request();

            if($data && is_array($data)){
                /**
                 * 你可以在这里分析数据，决定要返回给用户什么样的信息
                 * 接受到的信息类型有10种，分别使用下面10个常量标识
                 * Wechat::MSG_TYPE_TEXT       //文本消息
                 * Wechat::MSG_TYPE_IMAGE      //图片消息
                 * Wechat::MSG_TYPE_VOICE      //音频消息
                 * Wechat::MSG_TYPE_VIDEO      //视频消息
                 * Wechat::MSG_TYPE_SHORTVIDEO //视频消息
                 * Wechat::MSG_TYPE_MUSIC      //音乐消息
                 * Wechat::MSG_TYPE_NEWS       //图文消息（推送过来的应该不存在这种类型，但是可以给用户回复该类型消息）
                 * Wechat::MSG_TYPE_LOCATION   //位置消息
                 * Wechat::MSG_TYPE_LINK       //连接消息
                 * Wechat::MSG_TYPE_EVENT      //事件消息
                 *
                 * 事件消息又分为下面五种
                 * Wechat::MSG_EVENT_SUBSCRIBE    //订阅
                 * Wechat::MSG_EVENT_UNSUBSCRIBE  //取消订阅
                 * Wechat::MSG_EVENT_SCAN         //二维码扫描
                 * Wechat::MSG_EVENT_LOCATION     //报告位置
                 * Wechat::MSG_EVENT_CLICK        //菜单点击
                 */

                //记录微信推送过来的数据
                file_put_contents(Yii::$app->getRuntimePath() . DIRECTORY_SEPARATOR . 'data.json', json_encode($data));

                /* 响应当前请求(自动回复) */
                //$wechat->response($content, $type);

                /**
                 * 响应当前请求还有以下方法可以使用
                 * 具体参数格式说明请参考文档
                 * 
                 * $wechat->replyText($text); //回复文本消息
                 * $wechat->replyImage($media_id); //回复图片消息
                 * $wechat->replyVoice($media_id); //回复音频消息
                 * $wechat->replyVideo($media_id, $title, $discription); //回复视频消息
                 * $wechat->replyMusic($title, $discription, $musicurl, $hqmusicurl, $thumb_media_id); //回复音乐消息
                 * $wechat->replyNews($news, $news1, $news2, $news3); //回复多条图文消息
                 * $wechat->replyNewsOnce($title, $discription, $url, $picurl); //回复单条图文消息
                 * 
                 */
                
                $this->demo($wechat, $data);
            }
        } catch(\Exception $e){
            file_put_contents(Yii::$app->getRuntimePath() . DIRECTORY_SEPARATOR . 'error.json', json_encode($e->getMessage()) . PHP_EOL, FILE_APPEND);
        }
        
    }

    /**
     * DEMO
     * @param  Object $wechat Wechat对象
     * @param  array  $data   接受到微信推送的消息
     */
    private function demo($wechat, $data){
        switch ($data['MsgType']) {
            case Wechat::MSG_TYPE_EVENT:
                switch ($data['Event']) {
                    case Wechat::MSG_EVENT_SUBSCRIBE:
						$this->handleReply('subscribe', $data, $wechat);
                        break;

                    case Wechat::MSG_EVENT_UNSUBSCRIBE:
                        //取消关注，记录日志
                        break;

                    default:
                        return 'success';
//                        $wechat->replyText("您的事件类型：{$data['Event']}，EventKey：{$data['EventKey']}");
                        break;
                }
                break;

            case Wechat::MSG_TYPE_TEXT:
                switch ($data['Content']) {
                    /*case '文本':
                        $wechat->replyText('欢迎访问麦当苗儿公众平台，这是文本回复的内容！');
                        break;

                    case '图片':
                        //$media_id = $this->upload('image');
                        $media_id = '1J03FqvqN_jWX6xe8F-VJr7QHVTQsJBS6x4uwKuzyLE';
                        $wechat->replyImage($media_id);
                        break;

                    case '语音':
                        //$media_id = $this->upload('voice');
                        $media_id = '1J03FqvqN_jWX6xe8F-VJgisW3vE28MpNljNnUeD3Pc';
                        $wechat->replyVoice($media_id);
                        break;

                    case '视频':
                        //$media_id = $this->upload('video');
                        $media_id = '1J03FqvqN_jWX6xe8F-VJn9Qv0O96rcQgITYPxEIXiQ';
                        $wechat->replyVideo($media_id, '视频标题', '视频描述信息。。。');
                        break;

                    case '音乐':
                        //$thumb_media_id = $this->upload('thumb');
                        $thumb_media_id = '1J03FqvqN_jWX6xe8F-VJrjYzcBAhhglm48EhwNoBLA';
                        $wechat->replyMusic(
                            'Wakawaka!', 
                            'Shakira - Waka Waka, MaxRNB - Your first R/Hiphop source', 
                            'http://wechat.zjzit.cn/Public/music.mp3', 
                            'http://wechat.zjzit.cn/Public/music.mp3', 
                            $thumb_media_id
                        ); //回复音乐消息
                        break;

                    case '图文':
                        $wechat->replyNewsOnce(
                            "全民创业蒙的就是你，来一盆冷水吧！",
                            "全民创业已经如火如荼，然而创业是一个非常自我的过程，它是一种生活方式的选择。从外部的推动有助于提高创业的存活率，但是未必能够提高创新的成功率。第一次创业的人，至少90%以上都会以失败而告终。创业成功者大部分年龄在30岁到38岁之间，而且创业成功最高的概率是第三次创业。", 
                            "http://www.topthink.com/topic/11991.html",
                            "http://yun.topthink.com/Uploads/Editor/2015-07-30/55b991cad4c48.jpg"
                        ); //回复单条图文消息
                        break;

                    case '多图文':
                        $news = array(
                            "全民创业蒙的就是你，来一盆冷水吧！",
                            "全民创业已经如火如荼，然而创业是一个非常自我的过程，它是一种生活方式的选择。从外部的推动有助于提高创业的存活率，但是未必能够提高创新的成功率。第一次创业的人，至少90%以上都会以失败而告终。创业成功者大部分年龄在30岁到38岁之间，而且创业成功最高的概率是第三次创业。", 
                            "http://www.topthink.com/topic/11991.html",
                            "http://yun.topthink.com/Uploads/Editor/2015-07-30/55b991cad4c48.jpg"
                        ); //回复单条图文消息

                        $wechat->replyNews($news, $news, $news, $news, $news);
                        break;*/
                    
                    default:
//						$this->handleReply('subscribe', $data, $wechat);exit;
                        return 'success';
//                        $wechat->replyText("您输入的内容是：{$data['Content']}");
                        break;
                }
                break;
            
            default:
				# code
                break;
        }
    }

	private function handleReply($key, $data, $wechat) {
		$info = WechatKeywordService::getByKey($key);
		if ($info['status'] == 1) {
			if ($info['type'] == 'text') {
				$config = WechatConfigService::getConfigById(Yii::$app->request->get('id'), 'appid,appsecret');
				if (strpos($info['content'], '{{nickname}}') !== false) {
					$wechat_auth = new WechatAuth($config['appid'], $config['appsecret']);
					$user_info = $wechat_auth->userInfo($data['FromUserName']);
					$info['content'] = str_replace('{{nickname}}', $user_info['nickname'], $info['content']);
				}
				$wechat->replyText($info['content']);
				exit();
			} else if ($info['type'] == 'news') {
				$article_info = WechatArticlesService::getDetailById($info['news_id'], 'id,title,local_url,digest,content_source_url');
				if (!empty($article_info['articles'])) {
					$config = WechatConfigService::getConfigById(Yii::$app->request->get('id'), 'appid,appsecret');
					$wechat_auth = new WechatAuth($config['appid'], $config['appsecret']);
					$user_info = $wechat_auth->userInfo($data['FromUserName']);
					$data = array();
					foreach($article_info['articles'] as $one){
						$one['title'] = str_replace('{{nickname}}', $user_info['nickname'], $one['title']);
						$one['content_source_url'] = WechatArticleService::getDetailUrl($one);
						$data[] = array($one['title'], $one['digest'], $one['content_source_url'], $one['local_url']);
					}
					call_user_func_array(array($wechat, 'replyNews'), $data);
					exit();
				}
			}
		}
		exit('success');
	}

    /**
     * 资源文件上传方法
     * @param  string $type 上传的资源类型
     * @return string       媒体资源ID
     */
    private function upload($type){
        $appid     = 'wx58aebef2023e68cd';
        $appsecret = 'bf818ec2fb49c20a478bbefe9dc88c60';

        $token = session("token");

        if($token){
            $auth = new WechatAuth($appid, $appsecret, $token);
        } else {
            $auth  = new WechatAuth($appid, $appsecret);
            $token = $auth->getAccessToken();

            session(array('expire' => $token['expires_in']));
            session("token", $token['access_token']);
        }

        switch ($type) {
            case 'image':
                $filename = './Public/image.jpg';
                $media    = $auth->materialAddMaterial($filename, $type);
                break;

            case 'voice':
                $filename = './Public/voice.mp3';
                $media    = $auth->materialAddMaterial($filename, $type);
                break;

            case 'video':
                $filename    = './Public/video.mp4';
                $discription = array('title' => '视频标题', 'introduction' => '视频描述');
                $media       = $auth->materialAddMaterial($filename, $type, $discription);
                break;

            case 'thumb':
                $filename = './Public/music.jpg';
                $media    = $auth->materialAddMaterial($filename, $type);
                break;
            
            default:
                return '';
        }

        if($media["errcode"] == 42001){ //access_token expired
            session("token", null);
            $this->upload($type);
        }

        return $media['media_id'];
    }

}
