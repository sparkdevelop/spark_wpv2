<?php
global  $wpdb;
require_once( dirname( __FILE__ ) . '/admin.php' );

$conn = new mysqli('localhost','root','spark123456','spark_wp') ;
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
echo "连接成功";
echo "<br>";
$name= $_GET["name"];
$separator= $_GET["separator"];
$conn -> set_charset('utf8mb4');
$file_url = get_template_directory_uri()."/template/wiki/wiki_uploads/".$name;
$content = file_get_contents($file_url);//源文件地址
$a_content = addslashes($content);//使用反斜线引用字符串
$date= date('Y-m-d H:i:s');//获取日期
echo $date;
echo "<br>";
$authors=array("1"=>"1","19"=>"19","22"=>"22","958"=>"958","1124"=>"1124");//可用作者spark_admin 1,YANSHUAI 19,cherie 22,zyl 958,Normcore 1142

$contents= explode("\n",$a_content);//explode()函数以$separator为标识符进行拆分
$arrlength=count($contents);

//获取site_url和起始ID
$sql="SELECT option_value from wp_options WHERE option_name='siteurl'";
$result = $conn->query($sql);
$url = $result->fetch_assoc();
$site_url= $url['option_value'];
$sql="select ID from wp_posts where ID=(select MAX(ID) from wp_posts )";
$result = $conn->query($sql);
$ID_MAX = $result->fetch_assoc();
$id_max= $ID_MAX['ID'];
for($x=0;$x<$arrlength;$x++) {
    echo $x;
    $title= explode("$separator",$contents[$x]);//分隔符
    $sql="SELECT post_title from wp_posts WHERE post_title='$title[0]'";
    $result = $conn->query($sql);
    $res = $result->fetch_assoc();
    if (!empty($res)){
        echo '该词条已存在';
        echo "<br>";
    } else {
        $lower=strtolower($title[0]);//标题转为小写
        $str1 = trim($lower);
        $str2= preg_replace("/\s+/",' ',$str1);//替换多个空格为一个
        $str3 = str_replace(' ', '-', $str2);//替换空格为-
        $post_name = urlencode($str3);//postname编码
        $author = array_rand($authors, 1);//随机选取作者
        $id = $x + $id_max + 1;
        $sql = "INSERT INTO wp_posts (ID,post_author,post_date,post_date_gmt,post_content,post_title,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,guid,menu_order,post_type,post_mime_type,comment_count)
      VALUES('$id','$author','$date','$date','$contents[$x]','$title[0]','','publish','open','closed','','$post_name','','','$date','$date','','0','$site_url/?post_type=yada_wiki&p=$id','0','yada_wiki','','0')";
        if ($conn->query($sql) === TRUE) {
            echo "插入成功";
            echo "<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>
