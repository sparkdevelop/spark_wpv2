<?php
if (! defined('ABSPATH'))
    exit();
 // Exit if accessed directly
class XH_Social_Wechat_Hash
{

    private $appid, $token, $encodingAesKey;

    public function __construct($appid,$appsecret,$token,$EncodingAESKey)
    {
        $this->encodingAesKey = $EncodingAESKey;
        $this->token = $token;
        
        $this->appid = $appid;
    }

    public function decrypt($xml)
    {
        $encrypt_type = (isset($_GET['encrypt_type']) && ($_GET['encrypt_type'] == 'aes')) ? "aes" : "raw";
        $msg = '';
        
        if ($encrypt_type == 'aes') {
            include_once "hash/wxBizMsgCrypt.php";
            $pc = new WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->appid);
            $errCode = $pc->decryptMsg($_GET['msg_signature'], $_GET['timestamp'], $_GET['nonce'], $xml, $msg);
            if ($errCode != 0) {
                return null;
            }
        } else {
            $msg = $xml;
        }
        
        return get_object_vars(simplexml_load_string($msg, 'SimpleXMLElement', LIBXML_NOCDATA));
    }
}