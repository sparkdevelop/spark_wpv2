<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/25/025
 * Time: 11:26
 */

//require_once( "D:/wamp/www/wordpress/wp-blog-header.php");
//require_once( "D:/wamp/www/wordpress/wp-load.php");
//require_once( "D:/wamp/www/wordpress/wp-config.php");
global $wpdb;

$url = $_GET['url'];
$page= $_GET['page'];
$time = date('Y-m-d H:i:s');
$id= get_current_user_id();

$do=$wpdb->insert( 'chain_log', array('url'=>$url, 'time' => $time,'user_id' => $id,'page' => $page ) );


header("location: http://$url");