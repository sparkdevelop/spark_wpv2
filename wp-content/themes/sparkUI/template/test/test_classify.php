<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2019/3/22
 * Time: 10:50
 */

$user_id = get_current_user_id();
$chapter = $_GET['chapter'];
if(isset($chapter)){
    $chapter_link = get_chapter($chapter,'');
    if(isset($chapter_link)){
        //获取永用户level信息
        $level = user_test_level($user_id);
        if(isset($level)){
            //根据level和chapter选择test
            $chapter_link = get_chapter($chapter,$level);
            if($chapter_link){
                echo "<script language='javascript' type='text/javascript'>";
                echo "window.location.href='$chapter_link'";
                echo "</script>";
            }else{
                echo "无测试信息";
                echo"<script>history.go(-1);</script>";
            }
        }else{
        //分配level
            $level = user_classify($user_id);
            //根据level和chapter选择test
            $chapter_link = get_chapter($chapter,$level);
            if($chapter_link){
                echo "<script language='javascript' type='text/javascript'>";
                echo "window.location.href='$chapter_link'";
                echo "</script>";
            }else{
                echo "无测试信息";
                echo"<script>history.go(-1);</script>";
            }
        }
    }else{
        echo "无测试信息";
        echo"<script>history.go(-1);</script>";
    }
}else{
    echo "无测试信息";
    echo"<script>history.go(-1);</script>";
}

