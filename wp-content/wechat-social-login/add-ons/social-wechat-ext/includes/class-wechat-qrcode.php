<?php 
if (! defined ( 'ABSPATH' ))
    exit (); // Exit if accessed directly

require_once 'class-wechat-token.php';   
require_once 'class-wechat-error.php';

class XH_Social_Wechat_Qrcode{
    /**
     * @var XH_Social_Wechat_Token
     */
    private $wechat_token;
    public function __construct($appid,$appsecret){
        $this ->wechat_token = new XH_Social_Wechat_Token($appid,$appsecret);
    }
    
    public function create($wp_user_id,&$retry=2){
        try {
            $access_token = $this->wechat_token->access_token();
            if($access_token instanceof XH_Social_Error){
                return $access_token;
            }
            
            global $wpdb;
            $wpdb->insert("{$wpdb->prefix}xh_social_channel_wechat_queue", array(
                'created_date'=>date_i18n('Y-m-d H:i:s'),
                'ip'=>$_SERVER["REMOTE_ADDR"],
                'user_id'=>$wp_user_id
            ));
            
            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error,500);
            }
            
            $queue_id = $wpdb->insert_id;
            if($queue_id<=0){
                throw new Exception(XH_Social_Error::error_unknow()->errmsg,500);
            }
            
            //{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}
            $response =XH_Social_Helper_Http::http_post(
                "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}",
                json_encode(array(
                    'expire_seconds'=>259200,//3天
                    'action_name'=>'QR_SCENE',
                    'action_info'=>array(
                        'scene'=>array(
                            'scene_id'=>$queue_id
                        )
                    )
                )));
            
            $error = new XH_Social_Wechat_Error($this ->wechat_token->appid,$this ->wechat_token->appsecret);
           
            $obj = $error->validate($response);
            //{"ticket":"gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==","expire_seconds":60,"url":"http:\/\/weixin.qq.com\/q\/kZgfwMTm72WWPkovabbI"}
            return array(
                'uid'=>$queue_id,
                'url'=>"http://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($obj['ticket'])
            );
        } catch (Exception $e) {
            XH_Social_Log::error($e);
            if($e->getCode()==500){
                return new XH_Social_Error($e->getCode(),$e->getMessage());
            }
            if($retry-->0){
                return $this->create($wp_user_id,$retry);
            }
        }
        
        return XH_Social_Error::error_unknow();
    }
}
?>