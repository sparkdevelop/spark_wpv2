<?php
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');

//提交内容
$task_content = isset($_POST["task_other_editor"]) ? $_POST["task_other_editor"] : '';

//隐藏信息
$task_id = isset($_POST["task_id"]) ? $_POST["task_id"] : '';
$id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';

$time = date('Y-m-d H:i:s', time() + 8 * 3600);

$sql_update_tm = "update wp_gp_task_member set completion = 0,complete_time = '$time',apply_content ='$task_content'
                      WHERE user_id = $id and task_id = $task_id";

if ($id != "" && $task_id != "" && $task_content != "") {
    $wpdb->query($sql_update_tm);
}

$url= site_url().get_page_address('single_task').'&id='.$task_id;
?>
<script>
    location.replace("<?=$url?>");
</script>