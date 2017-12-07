<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/7/21
 * Time: 下午5:00
 */
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');

$verify_type = isset($_POST["verify_type"]) ? $_POST["verify_type"] : "";
$group_id = isset($_POST["group_id"]) ? $_POST["group_id"] : '';
$user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';
$apply_time = isset($_POST["apply_time"]) ? $_POST["apply_time"] : '';

if ($verify_type == 'verifyjoin') {
    //有几个字段
    $field_num = isset($_POST["field_num"]) ? $_POST["field_num"] : 0;
    $verify_info_tmp = array();
    if ($field_num != 0) {
        for ($i = 0; $i < $field_num; $i++) {
            //连接成为字符串 $verify_content = implode(",",$verify_content);   //数组
            $field_name = 'verify_' . $i;
            $field_content = isset($_POST[$field_name]) ? $_POST[$field_name] : '';
            array_push($verify_info_tmp, $field_content);
        }
        $verify_info = implode(",", $verify_info_tmp);
    }
} else {
    //获取验证信息
    $verify_info = isset($_POST['verify_info']) ? $_POST['verify_info'] : '';
}
//存入tmp里等待审核
$sql_insert_tmp = "INSERT INTO wp_gp_member_verify_tmp VALUES ('',$user_id,$group_id,'$apply_time','$verify_info')";
$sql_update_tmp = "UPDATE wp_gp_member_verify_tmp SET apply_time = '$apply_time', verify_info='$verify_info' WHERE user_id=$user_id and group_id=$group_id";
if ($group_id != "" && $user_id != "" && $apply_time != "") {
    if (in_member_tmp($user_id, $group_id)) { //tmp表中有这个user和groupid的信息
        $wpdb->get_results($sql_update_tmp);
    } else {
        $wpdb->get_results($sql_insert_tmp);
    }
}
//==============notice================
$admin_id_arr =get_group_member($group_id)['admin'];
foreach($admin_id_arr as $admin){
    $admin_id = $admin['user_id'];
    $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$admin_id,$group_id,3,'$user_id',0,'$apply_time')";
    $wpdb->get_results($sql_add_notice);
}
?>
<script>
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
    parent.layer.msg("申请已发送,等待管理员审核", {time: 2000, icon: 1});
</script>
