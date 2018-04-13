<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/19/019
 * Time: 11:11
 */
function cut($array){
    $c=count($array);$i=0;
    while($c>0){
        if($array[$i]=="." or strlen($array[$i])==0)
            unset($array[$i]);
        $c--;
        $i++;
    }
    return $array;
}
function get($array){
    $token = '24.968984eba6476f10a1b4cb9fd5caeec0.2592000.1525831768.282335-10900177';
    $url = 'https://aip.baidubce.com/rpc/2.0/nlp/v1/sentiment_classify?access_token=' . $token;
    $c=count($array);
    $i = 0;
    $a = 0;
    while ($c > 0) {
//    echo $text[$i];
        $bodys1 = "{\"text\":\"$array[$i]\"}";
        $bodys1= @iconv('UTF-8', 'GBK', $bodys1);//转换GBK编码
        $res1 = request_post($url, $bodys1);
        $res1 = @iconv('GBK', 'UTF-8', $res1);//转换GBK编码
        $array1 = explode(':', $res1);
        if (count($array1) > 5) {
            $str1 = $array1[4];//positive
            $str1 = explode(',', $str1);
//        echo "pos.  ".$str1[0];
            $posi1[$a] = $str1[0];
            $str1 = $array1[5];
            $str1 = explode(',', $str1);
            $sens1[$a] = $str1[0];
//        echo "sen.  ".$str1[0];
            $str1 = $array1[6];
            $str1 = explode(',', $str1);
            $nega1[$a] = $str1[0];
//        echo "neg.  ".$str1[0];
        }
        $score[$i] = ($posi1[$a] - $nega1[$a]) * $sens1[$a] * 100;
        $i++;
        $a++;
        $c--;
    }
    return $score;
}
function merge_text($array){
    $c=count($array[1]);$i=0;
    while($c>0){
        if($array[1][$i]==$array[1][$i+1]){
            unset($array[1][$i]);
            $array[2][$i+1]=$array[2][$i].".".$array[2][$i+1];
            unset($array[2][$i]);
        }
        if($i==0){
            unset($array[1][$i]);
            $array[2][$i+1]=$array[2][$i].".".$array[2][$i+1];
            unset($array[2][$i]);
        }
        $i++;
        $c--;
    }
    $array[1]=array_merge($array[1]);
    $array[2]=array_merge($array[2]);

    $array[1]=cut($array[1]);
    $array[2]=cut($array[2]);
    return $array;
}
function request_post($url = '', $param = '')
{
    if (empty($url) || empty($param)) {
        return false;
    }

    $postUrl = $url;
    $curlPost = $param;
    // 初始化curl
    $curl = curl_init();
    // 抓取指定网页
    curl_setopt($curl, CURLOPT_URL, $postUrl);
    // 设置header
    curl_setopt($curl, CURLOPT_HEADER, 0);
    // 要求结果为字符串且输出到屏幕上
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    // post提交方式
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
    // 运行curl
    $data = curl_exec($curl);
    curl_close($curl);

    return $data;
}
function get_method($team)
{
    global $wpdb;

    $filePath = $_SERVER["DOCUMENT_ROOT"] . "/spark_wpv2/wp-content/themes/sparkUI/algorithm/server-sdk/API/history/$team.txt";
    $str = file_get_contents($filePath);
    $str = explode(PHP_EOL, $str);    //分割为数组，每行为一个数组元素
//    if(count($str)==0)
//        echo "<script>alert('无此组信息')</script>";
    $str=array_filter($str);
    $c=count($str);$i=0;
    while($c>0){
        if($i==0)
            $time[$i]=substr($str[$i],0,13);
        else
            $time[$i]=substr($str[$i],0,10);
        $i++;
        $c--;
    }
    $c=count($str);$i=0;
    while($c>0){
        $array=explode(",",$str[$i]);
        $user[$i]=$array[1];
        $array=explode('"',$user[$i]);
        $user[$i]=$array[3];
        $i++;
        $c--;
    }
    $c=count($str);$i=0;
    while($c>0){
        $array=explode('"',$str[$i]);
        $text[$i]=$array[27];
        $i++;
        $c--;
    }

    $user_num= array_unique($user);
    $user_num=array_merge($user_num);
    $num=count($user_num);
    //0是num,1是time,2是text,3是score
    if ($num==4){
        $c=count($text);$i=0;$i1=0;$i2=0;$i3=0;$i4=0;
        while($c>0) {
            if ($user[$i] == $user_num[0]) {
                $user1[0]=$user_num[0];
                $user1[1][$i1]=$time[$i];
                $user1[2][$i1] = $text[$i];
                $i1++;
            }
            else if($user[$i] == $user_num[1]){
                $user2[0]=$user_num[1];
                $user2[1][$i2] = $time[$i];
                $user2[2][$i2] = $text[$i];
                $i2++;
            }
            else if($user[$i] == $user_num[2]){
                $user3[0]=$user_num[2];
                $user3[1][$i3] = $time[$i];
                $user3[2][$i3] = $text[$i];
                $i3++;
            }
            else if($user[$i] == $user_num[3]){
                $user4[0]=$user_num[3];
                $user4[1][$i4] = $time[$i];
                $user4[2][$i4] = $text[$i];
                $i4++;
            }
            $c--;
            $i++;
        }
        $user1=merge_text($user1);
        $user2=merge_text($user2);
        $user3=merge_text($user3);
        $user4=merge_text($user4);


        $c=count($user1[2]);$i=0;
        while($c>0){
            $user1_text[$i]=$user1[2][$i];
            $c--;
            $i++;
        }
        $c=count($user2[2]);$i=0;
        while($c>0){
            $user2_text[$i]=$user2[2][$i];
            $c--;
            $i++;
        }
        $c=count($user3[2]);$i=0;
        while($c>0){
            $user3_text[$i]=$user3[2][$i];
            $c--;
            $i++;
        }
        $c=count($user4[2]);$i=0;
        while($c>0){
            $user4_text[$i]=$user4[2][$i];
            $c--;
            $i++;
        }
//    print_r($zhang1);
//    print_r($song1);
        $user1[3]=get($user1_text);
        $user2[3]=get($user2_text);
        $user3[3]=get($user3_text);
        $user4[3]=get($user4_text);
//    print_r($song[3]);
//    print_r($zhang[3]);
        $user1[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user1[0]");
        $user2[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user2[0]");
        $user3[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user3[0]");
        $user4[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user4[0]");
        return $time_score=[$user1[0],$user1[1],$user1[3],$user2[0],$user2[1],$user2[3],$user3[0],$user3[1],$user3[3],$user4[0],$user4[1],$user4[3]];
    }
    if ($num==3){
        $c=count($text);$i=0;$i1=0;$i2=0;$i3=0;
        while($c>0) {
            if ($user[$i] == $user_num[0]) {
                $user1[0]=$user_num[0];
                $user1[1][$i1]=$time[$i];
                $user1[2][$i1] = $text[$i];
                $i1++;
            }
            else if($user[$i] == $user_num[1]){
                $user2[0]=$user_num[1];
                $user2[1][$i2] = $time[$i];
                $user2[2][$i2] = $text[$i];
                $i2++;
            }
            else if($user[$i] == $user_num[2]){
                $user3[0]=$user_num[2];
                $user3[1][$i3] = $time[$i];
                $user3[2][$i3] = $text[$i];
                $i3++;
            }
            $c--;
            $i++;
        }
        $user1=merge_text($user1);
        $user2=merge_text($user2);
        $user3=merge_text($user3);


        $c=count($user1[2]);$i=0;
        while($c>0){
            $user1_text[$i]=$user1[2][$i];
            $c--;
            $i++;
        }
        $c=count($user2[2]);$i=0;
        while($c>0){
            $user2_text[$i]=$user2[2][$i];
            $c--;
            $i++;
        }
        $c=count($user3[2]);$i=0;
        while($c>0){
            $user3_text[$i]=$user3[2][$i];
            $c--;
            $i++;
        }

//    print_r($zhang1);
//    print_r($song1);
        $user1[3]=get($user1_text);
        $user2[3]=get($user2_text);
        $user3[3]=get($user3_text);
//    print_r($song[3]);
//    print_r($zhang[3]);
        $user1[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user1[0]");
        $user2[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user2[0]");
        $user3[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user3[0]");
        return $time_score=[$user1[0],$user1[1],$user1[3],$user2[0],$user2[1],$user2[3],$user3[0],$user3[1],$user3[3]];
    }
    if ($num==5){
        $c=count($text);$i=0;$i1=0;$i2=0;$i3=0;$i4=0;$i5=0;
        while($c>0) {
            if ($user[$i] == $user_num[0]) {
                $user1[0]=$user_num[0];
                $user1[1][$i1]=$time[$i];
                $user1[2][$i1] = $text[$i];
                $i1++;
            }
            else if($user[$i] == $user_num[1]){
                $user2[0]=$user_num[1];
                $user2[1][$i2] = $time[$i];
                $user2[2][$i2] = $text[$i];
                $i2++;
            }
            else if($user[$i] == $user_num[2]){
                $user3[0]=$user_num[2];
                $user3[1][$i3] = $time[$i];
                $user3[2][$i3] = $text[$i];
                $i3++;
            }
            else if($user[$i] == $user_num[3]){
                $user4[0]=$user_num[3];
                $user4[1][$i4] = $time[$i];
                $user4[2][$i4] = $text[$i];
                $i4++;
            }
            else if($user[$i] == $user_num[4]){
                $user5[0]=$user_num[4];
                $user5[1][$i5] = $time[$i];
                $user5[2][$i5] = $text[$i];
                $i5++;
            }
            $c--;
            $i++;
        }
        $user1=merge_text($user1);
        $user2=merge_text($user2);
        $user3=merge_text($user3);
        $user4=merge_text($user4);
        $user5=merge_text($user5);


        $c=count($user1[2]);$i=0;
        while($c>0){
            $user1_text[$i]=$user1[2][$i];
            $c--;
            $i++;
        }
        $c=count($user2[2]);$i=0;
        while($c>0){
            $user2_text[$i]=$user2[2][$i];
            $c--;
            $i++;
        }
        $c=count($user3[2]);$i=0;
        while($c>0){
            $user3_text[$i]=$user3[2][$i];
            $c--;
            $i++;
        }
        $c=count($user4[2]);$i=0;
        while($c>0){
            $user4_text[$i]=$user4[2][$i];
            $c--;
            $i++;
        }
        $c=count($user5[2]);$i=0;
        while($c>0){
            $user5_text[$i]=$user5[2][$i];
            $c--;
            $i++;
        }
//    print_r($zhang1);
//    print_r($song1);
        $user1[3]=get($user1_text);
        $user2[3]=get($user2_text);
        $user3[3]=get($user3_text);
        $user4[3]=get($user4_text);
        $user5[3]=get($user5_text);
//    print_r($song[3]);
//    print_r($zhang[3]);
        $user1[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user1[0]");
        $user2[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user2[0]");
        $user3[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user3[0]");
        $user4[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user4[0]");
        $user5[0]=$wpdb->get_var("SELECT user_login FROM `$wpdb->users` where ID=$user5[0]");
        return $time_score=[$user1[0],$user1[1],$user1[3],$user2[0],$user2[1],$user2[3],$user3[0],$user3[1],$user3[3],$user4[0],$user4[1],$user4[3],$user5[0],$user5[1],$user5[3]];
    }

}
//function
?>