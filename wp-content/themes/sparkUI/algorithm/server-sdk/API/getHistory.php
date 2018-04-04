<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2018/3/27
 * Time: 10:19
 */
include_once 'rongcloud.php';
$appKey = '82hegw5u8y3bx';
$appSecret= '3xiNmMC4VLWKr7';
$jsonPath = "jsonsource/";
$RongCloud = new RongCloud($appKey,$appSecret);
$date = date("Ymd");
$hours = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");
for($x=0;$x<24;$x++)
{
    $dates = $date.$hours[$x];
    echo $dates;
    echo "<br>";
    // 消息历史记录下载地址获取 方法消息历史记录下载地址获取方法。获取 APP 内指定某天某小时内的所有会话消息记录的下载地址。
    $result = $RongCloud->message()->getHistory($dates);
    echo "getHistory    ";
    print_r($result);
    echo "<br>";
    //使用json_decode函数解释成数组
    $output = json_decode($result,true);
    $url = $output['url'];
    if($url){
        echo "URL    ";
        echo $url;
        echo "<br>";
    }

}
