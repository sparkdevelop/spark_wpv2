<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2018/3/27
 * Time: 10:19
 * 弃用，以\wp-admin\SparkgetHistory.php替代
 */
function getFile($url, $save_dir = '', $filename = '', $type = 0) {
    if (trim($url) == '') {
        return false;
    }
    if (trim($save_dir) == '') {
        $save_dir = './';
    }
    if (0 !== strrpos($save_dir, '/')) {
        $save_dir.= '/';
    }
    //创建保存目录
    if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
        return false;
    }
    //获取远程文件所采用的方法
    if ($type) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $content = curl_exec($ch);
        curl_close($ch);
    } else {
        ob_start();
        readfile($url);
        $content = ob_get_contents();
        ob_end_clean();
    }
    //echo $content;
    $size = strlen($content);
    //文件大小
    $fp2 = @fopen($save_dir . $filename, 'a');
    fwrite($fp2, $content);
    fclose($fp2);
    unset($content, $url);
    return array(
        'file_name' => $filename,
        'save_path' => $save_dir . $filename,
        'file_size' => $size
    );
}
function id_classify($filePath){
    $str = file_get_contents($filePath);
    $str = explode(PHP_EOL, $str);    //分割为数组，每行为一个数组元素
    $str=array_filter($str);
    $c=count($str);$i=0;
    while($c>0){
        $array=explode('"',$str[$i]);
        $id=$array[11];             //提取每句话的小组id
        $id=$id."1";
        $myfile = fopen('wp-content/themes/sparkUI/algorithm/server-sdk/API/history/id/'.$id.'.txt', "a") or die("Unable to open file!");   //打开id.txt
        $txt = $str[$i];
        fwrite($myfile, $txt."\r\n");          //把这句话写入id.txt文件
        fclose($myfile);
        $i++;
        $c--;
    }
}
WP_Filesystem();
include_once 'rongcloud.php';
$appKey = '82hegw5u8y3bx';
$appSecret= '3xiNmMC4VLWKr7';
$jsonPath = "jsonsource/";
$RongCloud = new RongCloud($appKey,$appSecret);
$date = date("Ymd",strtotime("-1 day"));
$hours = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");
//消息记录下载保存地址
$save_dir = "wp-content/themes/sparkUI/algorithm/server-sdk/API/history";
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
        $filename = $dates.'.zip';
        $res = getFile($url, $save_dir, $filename,1);//0  1 皆可
        //var_dump($res);
        //解压文件
        $txt_name = date("Y-m-d",strtotime("-1 day")).'-'.$hours[$x];
        $zip = 'wp-content/themes/sparkUI/algorithm/server-sdk/API/history/'.$dates.'.zip';
        $unzip_file = unzip_file($zip,'wp-content/themes/sparkUI/algorithm/server-sdk/API/history/txt/');
        if ( is_wp_error( $unzip_file ) ) {
            echo 'There was an error unzipping the file.';
        } else {
            echo 'Successfully unzipped the file!';
            echo "<br>";
        }
        id_classify('wp-content/themes/sparkUI/algorithm/server-sdk/API/history/txt/'.$txt_name);
    }

}
