<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2019/3/22
 * Time: 14:18
 */
global  $wpdb;
$file_url = get_template_directory_uri()."/template/test/test.txt";
$content = file_get_contents($file_url);//源文件地址
$contents= explode("\n",$content);//每行
$length=count($contents);
for($i = 0;$i < $length;$i++){
    $row = explode("|",$contents[$i]);//分隔符
    $chapter = $row[0];
    $link = $row[1];
    $level = $row[2];
    $sql = "INSERT INTO wp_test_chapter VALUES ('','$chapter','$link','$level')";
    $res = $wpdb->get_results($sql);
}