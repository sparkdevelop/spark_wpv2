<?php 
if (! defined ( 'ABSPATH' ))
    exit (); // Exit if accessed directly

require_once 'class-wechat-token.php';   
require_once 'class-wechat-error.php';

class XH_Social_Wechat_User{
    /**
     * @var XH_Social_Wechat_Token
     */
    private $wechat_token;
    public function __construct($appid,$appsecret){
       $this ->wechat_token = new XH_Social_Wechat_Token($appid,$appsecret);
    }
    
    public function get_user($openid,&$retry=2){
        try {
            $c=2;
            $access_token = $this->wechat_token->access_token($c);
            if($access_token instanceof XH_Social_Error){
                return $access_token;
            }
           
            $response =XH_Social_Helper_Http::http_get("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN");
            $error = new XH_Social_Wechat_Error($this ->wechat_token->appid,$this ->wechat_token->appsecret);
            return $error->validate($response);
        } catch (Exception $e) {
            XH_Social_Log::error($e);
            if($e->getCode()==500){
                return new XH_Social_Error($e->getCode(),$e->getMessage());
            }
            if($retry-->0){
                return $this->get_user($openid,$retry);
            }
        }
        
        return XH_Social_Error::error_unknow();
    }
}
?>