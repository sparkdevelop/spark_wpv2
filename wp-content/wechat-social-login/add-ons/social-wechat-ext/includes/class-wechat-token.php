<?php 
if (! defined ( 'ABSPATH' ))
    exit (); // Exit if accessed directly

require_once 'class-wechat-error.php'; 

class XH_Social_Wechat_Token{
    public $appid,$appsecret;

    public function __construct($appid,$appsecret){
       $this->appid =$appid;
       $this->appsecret = $appsecret;
       do_action('xh_social_wechat_token');
    }
    
    private function get($id){
        $token = get_option('wechat_token',array());
        if(!$token||!is_array($token)){
            $token=array();
        }
        
        $token = isset($token[$id])?$token[$id]:null;
        if(!$token
            ||!is_array($token)
            ||!isset($token['expire'])
            ||$token['expire']<time()){
            return null;
        }
        
        return isset($token['data'])?$token['data']:null;
    }
    
    private function set($id,$data){
        $token = get_option('wechat_token',array());
        if(!$token||!is_array($token)){
            $token=array();
        }
        
        $token[$id]=array(
               'expire'=>time()+6000,
               'data'=>$data
        );
        
        return update_option('wechat_token', $token,true);
    }
    
    /**
     *
     * @param number $retry
     * @param string $refresh
     * @return NULL
     * @since 1.0.2
     */
    public function jsapi_ticket(&$retry = 2,$refresh=false){
        if(empty($this->appid)||empty($this->appid)){
            return XH_Social_Error::error_custom('unknow APPID');
        }
        if(!$refresh){
            $cached_jsapi_ticket = $this->get('jsapi_ticket');
            if($cached_jsapi_ticket){
                return $cached_jsapi_ticket;
            }
        }
    
        try {
            $accessToken = $this->access_token();
            if($accessToken instanceof XH_Social_Error){
                return $accessToken;
            }
            $response =XH_Social_Helper_Http::http_get ( "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken" );
            $error = new XH_Social_Wechat_Error($this->appid,$this ->appsecret);
        
            $obj = $error->validate($response);
            $this->set('jsapi_ticket', $obj['ticket']);
            return $obj['ticket'];
        } catch (Exception $e) {
            XH_Social_Log::error($e);
            if($e->getCode()==500){
                return new XH_Social_Error($e->getCode(),$e->getMessage());
            }
            if($retry-->0){
                return $this->jsapi_ticket($retry);
            }
        }
    
        return XH_Social_Error::error_unknow();
    }
    
    public function access_token(&$retry = 2,$refresh=false){
        if(empty($this->appid)||empty($this->appid)){
            return XH_Social_Error::error_custom('unknow APPID');
        }
        
        if(!$refresh){
            $cached_access_token = $this->get('access_token');
            if(!empty($cached_access_token)){
                return $cached_access_token;
            }
        }
        
        try {
            $response = XH_Social_Helper_Http::http_get("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}");
            $error = new XH_Social_Wechat_Error($this->appid,$this->appsecret);
            $c=0;
            $obj = $error->validate($response,$c);
            $this->set('access_token', $obj['access_token']);
            return $obj['access_token'];
        } catch (Exception $e) {
            XH_Social_Log::error($e);
            if($e->getCode()==500){
                return new XH_Social_Error($e->getCode(),$e->getMessage());
            }
            
            if($retry-->0){
                return $this->access_token($retry);
            }
        }
        
        return XH_Social_Error::error_unknow();
    }
}