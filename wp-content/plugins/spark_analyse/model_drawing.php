<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/25
 * Time: 19:37
 */

function model(){
    global $wpdb;

    $con = mysqli_connect("localhost", "root", "qingfeng");
    if (!$con)
    {
        die('连接失败: ' . mysqli_error());
    }

    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");


    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts`WHERE `post_author` = '$sql'and post_status='publish' and post_type='post'");
    $c = $articulnum;
    //$c; 编辑总次数
    // 分词预定义
    ini_set('display_errors', 'On');
    ini_set('memory_limit', '64M');
    error_reporting(E_ALL);

    function print_memory($rc, &$infostr)
    {
        global $ntime;
        $cutime = microtime(true);
        $etime = sprintf('%0.4f', $cutime - $ntime);
        $m = sprintf('%0.2f', memory_get_usage()/1024/1024);
        $infostr .= "{$rc}: &nbsp;{$m} MB 用时：{$etime} 秒<br />\n";
        $ntime = $cutime;
    }
//初始化类
    $pri_dict = empty($_POST['pri_dict']) ? false : true;
    require_once 'phpanalysis.class.php';
    PhpAnalysis::$loadInit = false;
    $pa = new PhpAnalysis('utf-8', 'utf-8', $pri_dict);
    print_memory('初始化对象', $memory_info);
//载入词典
    $pa->LoadDict();
    print_memory('载入基本词典', $memory_info);
    global $m;
    global $textlist2;
    global $textlist3;
    global $draw1, $draw2, $draw3, $draw4, $draw5, $draw6, $draw7,$draw8,$draw9,$draw10;
    $draw1=0;
    $draw2=0;
    $draw3=0;
    $draw4=0;
    $draw5=0;
    $draw6=0;
    $draw7=0;$draw8=0;$draw9=0;$draw10=0;
    $m=0;
    $textid=$wpdb->get_results("SELECT ID FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type='post'");
    foreach($textid as $a){
        $textlist2[$m]=$a->ID;
        $m++;
    }
    $m=0;
    global $textlist3;
    global $articul;
    $articul=0;
    while($c>0)  //$c是该用户一共有多少条编辑次数
    {
        $articul.= $wpdb->get_var("SELECT post_content FROM `$wpdb->posts` WHERE `ID` ='$textlist2[$m]'");
        //echo $articultext;
        $m++;
        $c--;
    }
        $str=$articul;
        $do_fork = $do_unit = true;
        $do_multi = $do_prop = $pri_dict = false;
        $pa->SetSource($str);
        $pa->differMax = $do_multi;
        $pa->unitWord = $do_unit;

        $pa->StartAnalysis( $do_fork );
        print_memory('执行分词', $memory_info);

        $okresult = $pa->GetFinallyResult(' ');
        $line = explode(" ", $okresult);
        $a=array_count_values($line);
        arsort($a);
        foreach ($a as $key => $value)
            if(preg_match("/[\'.,。，_的:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$key))
                unset($a[$key]);
        $textlist4=array_slice($a,0,10,true);
       $textlist3=array_keys($textlist4);
    $draw1=$textlist3[0];
    $draw2=$textlist3[1];
    $draw3=$textlist3[2];
    $draw4=$textlist3[3];
    $draw5=$textlist3[4];
    $draw6=$textlist3[5];
    $draw7=$textlist3[6];
    $draw8=$textlist3[7];
    $draw9=$textlist3[8];
    $draw10=$textlist3[9];

    return $time="$draw1 $draw2 $draw3 $draw4 $draw5 $draw6 $draw7 $draw8 $draw9 $draw10";
}
function draw1(){
    global $draw1;
    echo $draw1;
}
function draw2(){
    global $draw2;
    echo $draw2;
}
function draw3(){
    global $draw3;
    echo $draw3;
}
function draw4(){
    global $draw4;
    echo $draw4;
}
function draw5(){
    global $draw5;
    echo $draw5;
}
function draw6(){
    global $draw6;
    echo $draw6;
}
function draw7(){
    global $draw7;
    echo $draw7;
}
function draw8(){
    global $draw8;
    echo $draw8;
}
function draw9(){
    global $draw9;
    echo $draw9;
}
function draw10(){
    global $draw10;
    echo $draw10;
}