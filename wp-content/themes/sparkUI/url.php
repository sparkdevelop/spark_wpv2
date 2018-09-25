<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/25/025
 * Time: 11:26
 */

//require_once( "D:/wamp/www/wordpress/wp-blog-header.php");
//global $wpdb;

$url = $_GET['url'];
$time = date('Y-m-d H:i:s');
$file = "chain_log.txt";
$id= get_current_user_id();
//$name =$wpdb->get_var( "SELECT user_login FROM `$wpdb->users` WHERE `user` = '$id'");
$handle =fopen($file,'a');
fwrite($handle,"\r\n");
fwrite($handle,"URL:");
fwrite($handle,"$url" . ",");
fwrite($handle,"time:");
fwrite($handle,"$time" . ",");
fwrite($handle,"id:");
fwrite($handle,"$id" . ",");


fclose($handle);


//$wpdb->insert( $wpdb->prefix .'chain_log', array('url'=>$url, 'time' => $time, 'user_id' => $id));

header("location: http://$url");  // http://localhost/wordpress/?page_id=15103