<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/19
 * Time: 17:08
 */
//include_once('../../../wp-config.php');
header("Content-type:text/html;charset=utf-8");
function history()
{
    global $wpdb;
//    $con=mysqli_connect('localhost', 'root', 'qingfeng','test') ;
////if (!$con){ die('Could not connect: ' . mysql_error());}
//
//    mysqli_query($con,"set names 'gbk'");//输出中文
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $history = $wpdb->get_results("SELECT action_post_id FROM `wp_user_history` WHERE `user_id` = '$sql'");
    $m = 0;
    foreach ($history as $a) {
        $historylist[$m] = $a->action_post_id;
        $m++;
    }
    global $sql;
    $a=0;
    $his_tag=array(
        "数据不足","数据不足","数据不足","数据不足","数据不足","数据不足","数据不足","数据不足","数据不足","数据不足"
    );
    $c=count($historylist);
    $m=0;

    while($c>0){

        $sql[$a] =$wpdb->get_var( "SELECT class1 FROM `new_wiki` WHERE `wiki_id` = '$historylist[$m]'");
        $his_tag[$a]=$sql[$a];

//        $his_tag[$a] = mb_convert_encoding($his_tag[$a], 'utf-8', 'gbk');
        $m++;
        $a++;
        $c--;
    }
    $m=0;
    $c=count($historylist);
    while($c>0) {
        if ($historylist[$m]==0 or $his_tag[$m]==null){
            unset ($his_tag[$m]);
        }
        $m++;
        $c--;
    }
    $a=array_count_values($his_tag);
    arsort($a);
    $key=array(null,null,null,null,null);
    $value=array(null,null,null,null,null);
    $key=array_keys($a);
    $key=array_slice($key,0,5);
    $value=array_values($a);
    $value=array_slice($value,0,5);
//    echo "用户最喜欢的内容是 ".$key[0]." 共看了相关知识 ".$value[0]."次".
//          "其次为 ".$key[1]." 共看了相关知识 ".$value[1]."次";
//    echo  '</br>';
   return array_merge($key,$value);
}
function history_value()
{
    global $wpdb;
//    $con=mysqli_connect('localhost', 'root', 'qingfeng','test') ;
////if (!$con){ die('Could not connect: ' . mysql_error());}
//
//    mysqli_query($con,"set names 'gbk'");//输出中文
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $history = $wpdb->get_results("SELECT action_post_id ,action_time FROM `wp_user_history` WHERE `user_id` = '$sql'");
    $m = 0;
    foreach ($history as $a) {
        $historylist[$m] = $a->action_post_id;
        $historytime[$m]=$a->action_time;
        $m++;
    }

    global $sql;
    $a=0;
    $his_tag=array(
        "数据不足","数据不足","数据不足","数据不足","数据不足","数据不足","数据不足","数据不足","数据不足","数据不足"
    );
    $c=count($historylist);
    $m=0;

    while($c>0){

        $sql[$a] =$wpdb->get_var( "SELECT class1 FROM `new_wiki` WHERE `wiki_id` = '$historylist[$m]'");
        $his_tag[$a]=$sql[$a];
//        $his_tag[$a] = mb_convert_encoding($his_tag[$a], 'utf-8', 'gbk');
        $m++;
        $a++;
        $c--;
    }
    $c=count($historylist);
    $m=0;
    while($c>0) {
        if ($historylist[$m]==0 or $his_tag[$m]==null){
            unset ($his_tag[$m]);
            unset ($historytime[$m]);
        }
        $m++;
        $c--;
    }
    $his_tag=array_merge($his_tag);
    $historytime=array_merge($historytime);
   $c=count($his_tag)-1;
//        $result_array=array_combine($his_tag,$historytime);
//    print_r($his_tag);
    echo '</br>';
    $c=count($historytime);
    $m=0;
    $time0=strtotime(20170601);
    while($c>0){
        $historytime[$m]=date("Ymd",strtotime($historytime[$m]));
        $historytime[$m]=strtotime($historytime[$m]);
        $historytime[$m]=($historytime[$m]-$time0)/86400;
        $m++;
        $c--;
    }
//    print_r($historytime); // 输出用户的浏览wiki的分类与时间，二者相对应



//    echo "用户最近的兴趣为".$his_tag[$c];
    $c=count($his_tag);
    $m=0;
    while ($c>0){
        switch($his_tag[$m]){
            case "推荐系统":
                $his_num[$m]=1.1;
                break;
            case "信息检索":
                $his_num[$m]=1.2;
                break;
            case "计算机视觉":
                $his_num[$m]=1.3;
                break;
            case "自然语言处理":
                $his_num[$m]=1.4;
                break;
            case "搜索引擎":
                $his_num[$m]=1.5;
                break;
            case "知识图谱":
                $his_num[$m]=1.6;
                break;
            case "机器学习":
                $his_num[$m]=1.7;
                break;
            case "工程框架":
                $his_num[$m]=1.8;
                break;
            case "单片机":
                $his_num[$m]=2.1;
                break;
            case "电路仿真":
                $his_num[$m]=2.2;
                break;
            case "微机原理":
                $his_num[$m]=2.3;
                break;
            case "电路分析":
                $his_num[$m]=2.4;
                break;
            case "模拟电路":
                $his_num[$m]=2.5;
                break;
            case "数字电路":
                $his_num[$m]=2.6;
                break;
            case "嵌入式系统":
                $his_num[$m]=2.7;
                break;
            case "通信电子电路":
                $his_num[$m]=2.8;
                break;
            case "物联网":
                $his_num[$m]=2.9;
                break;
            case "信息论":
                $his_num[$m]=3.1;
                break;
            case "随机信号分析":
                $his_num[$m]=3.2;
                break;
            case "信号与系统":
                $his_num[$m]=3.3;
                break;
            case "通信网理论基础":
                $his_num[$m]=3.4;
                break;
            case "数字信号处理":
                $his_num[$m]=3.5;
                break;
            case "通信原理":
                $his_num[$m]=3.6;
                break;
            case "电磁场与电磁波":
                $his_num[$m]=3.7;
                break;
            case "射频与微波技术":
                $his_num[$m]=3.8;
                break;
            case "宽带接入技术":
                $his_num[$m]=3.9;
                break;
            case "移动通信":
                $his_num[$m]=3.0;
                break;
            case "光纤通信":
                $his_num[$m]=3.0;
                break;
            case "数据结构与算法":
                $his_num[$m]=4.1;
                break;
            case "计算机网络":
                $his_num[$m]=4.2;
                break;
            case "网络安全":
                $his_num[$m]=4.3;
                break;
            case "数据库技术与应用":
                $his_num[$m]=4.4;
                break;
            case "计算机组成原理":
                $his_num[$m]=4.5;
                break;
            case "操作系统":
                $his_num[$m]=4.6;
                break;
            case "编程语言":
                $his_num[$m]=4.7;
                break;
            case "软件定义网络":
                $his_num[$m]=4.8;
                break;
            default:
                $his_num[$m]=0;
        }
        $m++;
        $c--;
    }//人工智能是1，电子是2，通信是3，计算机是4

//    print_r($his_num) ;//输出用户浏览记录的分类情况，以数字代表

    $c=count($his_num);
    $m=0;
    while($c>0){
        $his_num_f[$m]=floor($his_num[$m]);
        $m++;
        $c--;
    }
//    print_r($his_num_f);//输出用户浏览记录的分类情况，以数字代表，只显示个位
    $c=count($historytime);
    $a=$historytime[$c-1];
    $timelong=array(0);
    $timelong1=array_pad($timelong,$a+1,0);
    $timelong2=array_pad($timelong,$a+1,0);
    $timelong3=array_pad($timelong,$a+1,0);
    $timelong4=array_pad($timelong,$a+1,0);
    $m=0;
    $flag1=0;$flag2=0;$flag3=0;$flag4=0;
    while($c>0){
//         $timelong[$historytime[$m]]=$his_num_f[$m];
//        $m++;01234
//        $c--;
        if ($his_num_f[$m]==1){
            $flag1++;
            $timelong1=arr($historytime[$m],$a+1,$flag1,$timelong1);
//            $timelong1[$historytime[$m]]=$flag1;
        }
        else if($his_num_f[$m]==2){
            $flag2++;
            $timelong2=arr($historytime[$m],$a+1,$flag2,$timelong2);
        }
        else if($his_num_f[$m]==3){
            $flag3++;
            $timelong3=arr($historytime[$m],$a+1,$flag3,$timelong3);
        }
        else if($his_num_f[$m]==4){
            $flag4++;
            $timelong4=arr($historytime[$m],$a+1,$flag4,$timelong4);
//            $timelong4[$historytime[$m]]=$flag4;
        }
        $m++;
        $c--;
    }
//    print_r($timelong1);echo '</br>';print_r($timelong2);echo '</br>';print_r($timelong3);echo '</br>';print_r($timelong4);
//    print_r($timelong4);
    //timelong1是人工智能  timelong2是电子  timelong3是通信  timelong4计算机
//    $c=count($his_num);
//    $avg=array_sum($his_num_f)/$c;
//    $var=getVariance($avg,$his_num_f);
//    echo $var;//方差
//    echo '</br>';
    return $timelong=array($timelong1,$timelong2,$timelong3,$timelong4);
}
function arr($start,$long,$value,$array){
    $m=0;
    $long=$long-$start;
    while ($long>0){
        $array[$start+$m]=$value;
        $m++;
        $long--;
    }
    return $array;
}