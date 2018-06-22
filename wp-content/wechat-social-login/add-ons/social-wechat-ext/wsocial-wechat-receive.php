<?php 
define('WP_USE_THEMES', false);
require_once './wp-load.php';

if(!class_exists('XH_Social_Add_On_Social_Wechat_Ext')){
    wp_die('未安装微信高级扩展!');
}

XH_Social_Add_On_Social_Wechat_Ext::instance()->on_wechat_service_load();
?>