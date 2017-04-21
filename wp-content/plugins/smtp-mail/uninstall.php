<?php
if(!defined('WP_UNINSTALL_PLUGIN')){
    die;
}   //禁止非法卸载

delete_option('lf_smtp_opts');  //删除保存的数据

