<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/7/21
 * Time: 下午5:00
 */
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');

//有几个字段
$field_num = isset($_POST["field_num"]) ? $_POST["field_num"] : 0;
$verify_info_tmp= array();
if ($field_num!=0){
    for($i=0;$i<$field_num;$i++){
        //连接成为字符串 $verify_content = implode(",",$verify_content);   //数组
        $field_name = 'verify_'.$i;
        $field_content = isset($_POST[$field_name]) ? $_POST[$field_name] : '';
        array_push($verify_info_tmp,$field_content);
    }
    $verify_info = implode(",",$verify_info_tmp);
}
$group_id = isset($_POST["group_id"]) ? $_POST["group_id"] : '';
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';
$apply_time = isset($_POST["apply_time"]) ? $_POST["apply_time"] : '';

//存入tmp里等待审核
if($field_num!=0 && $group_id!="" && $user_id!="" && $apply_time!=""){
    $sql_insert_tmp = "INSERT INTO wp_gp_member_verify_tmp VALUES ('',$user_id,$group_id,'$apply_time','$verify_info')";
    $wpdb->get_results($sql_insert_tmp);
}
?>
<script>
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
    parent.layer.msg("申请已发送,等待管理员审核", {time: 2000, icon: 1});
</script>
