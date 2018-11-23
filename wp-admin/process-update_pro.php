<?php
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');
?>

<?php
//项目名称
$pro_name = isset($_POST["proname"]) ? $_POST["proname"] : '';
//项目链接
$pro_link = isset($_POST["prolink"]) ? $_POST["prolink"] : '';
//拼接名称和链接
$apply_content = $pro_name.",".$pro_link;
//成员数组
$team_member = isset($_POST["team_member"]) ? $_POST["team_member"] : [];
//隐藏信息
$task_id = isset($_POST["task_id"]) ? $_POST["task_id"] : '';
$team_id = isset($_POST["team_id"]) ? $_POST["team_id"] : '';

//先把原来的表中的信息删除
if($team_id != '' && $task_id != ''){
    $sql_delete_mt = "DELETE FROM wp_gp_member_team WHERE task_id = $task_id and team_id = $team_id";
    $sql_delete_tm = "DELETE FROM wp_gp_task_member WHERE task_id = $task_id and team_id = $team_id";
    $wpdb->query($sql_delete_mt);
    $wpdb->query($sql_delete_tm);
}

//再更新内容。
//在把member传过来的时候已经检查过是否在member表中或者是否组队了
$team_member = array_unique($team_member);
foreach ($team_member as $value){
    $id = get_the_ID_by_name($value);
    $time = date('Y-m-d H:i:s', time() + 8 * 3600);
    $sql_insert_mt = "INSERT INTO wp_gp_member_team VALUES ('',$id,$task_id,$team_id)";
    $sql_insert_tm = "INSERT INTO wp_gp_task_member VALUES ('',$id,$task_id,0,'$time','$apply_content',$team_id,'')";

    if ($id != "" && $task_id != "" && $team_id != "" && $apply_content != "") {
        $wpdb->query($sql_insert_mt);
        $wpdb->query($sql_insert_tm);
    }
}

//step3:
$url= site_url().get_page_address('single_task').'&id='.$task_id;
?>
<script>
    location.replace("<?=$url?>");
</script>