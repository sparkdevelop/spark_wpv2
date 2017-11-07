<?php
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');

//提交内容
$task_content = isset($_POST["task_other_editor"]) ? $_POST["task_other_editor"] : '';

//隐藏信息
$task_id = isset($_POST["task_id"]) ? $_POST["task_id"] : '';
$id = isset($_POST["user_id"]) ? $_POST["user_id"] : '';

$time = date('Y-m-d H:i:s', time() + 8 * 3600);

$sql_insert_tm = "INSERT INTO wp_gp_task_member VALUES ('',$id,$task_id,0,'$time','$task_content',0,'')";

if ($id != "" && $task_id != "" && $task_content != "") {
    $wpdb->query($sql_insert_tm);
}

$url= site_url().get_page_address('single_task').'&id='.$task_id;
?>
<script>
    location.replace("<?=$url?>");
</script>