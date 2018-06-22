<?php 
if (! defined ( 'ABSPATH' ))
    exit (); // Exit if accessed directly

require_once 'class-wechat-error.php';   
require_once 'class-wechat-user.php';

class XH_Social_Wechat_Event{ 
    protected $data;
    public function __construct($appid,$appsecret,$token,$EncodingAESKey){
        $xml = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
        if (empty($xml)) {
            $xml = file_get_contents("php://input");
        }
        
        if(empty($xml)){
            return;
        }
        
        $xml_parser = xml_parser_create();
        if(!xml_parse($xml_parser,$xml,true)){
            xml_parser_free($xml_parser);
            return;
        }
        
        
        
        require_once 'class-wechat-hash.php';
        $api = new XH_Social_Wechat_Hash($appid,$appsecret,$token,$EncodingAESKey);
        $this->data =$api->decrypt($xml);
    }
    
    public function hook(){
        $this->hook_event();
        $this->hook_msg();
        
        echo '';
        exit;
    }
    
    public function response($content=''){
        if(!$this->data){
            return;
        }
        
        if(empty($content)){
            echo '';
            exit;
        }
        $xmlTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                </xml>";
        
       echo sprintf($xmlTpl,$this->data['FromUserName'], $this->data['ToUserName'], time(), $content);
       exit;
    }
    
    private function hook_msg(){
        if(!$this->data){
            return;
        }
    
        if(!isset($this->data['MsgType'])||!in_array($this->data['MsgType'], array(
            'text',
            'image',
            'voice',
            'video',
            'location',
            'link'
        ))){
            return;
        }
    
        do_action('xh_social_channel_wechat_receive_msg',$this->data,$this);
    }
    
    private function hook_event(){
        if(!$this->data){
            return;
        }
        
        if(!isset($this->data['MsgType'])||$this->data['MsgType']!='event'){
            return;
        }
        
        do_action('xh_social_channel_wechat_receive_event',$this->data,$this);
    }
  
}