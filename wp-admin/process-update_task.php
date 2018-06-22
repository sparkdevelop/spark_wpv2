<?php
global  $wpdb;
require_once( dirname( __FILE__ ) . '/admin.php' );

/*        ID int AUTO_INCREMENT PRIMARY KEY,
          task_name text NOT NULL,
          task_author int NOT NULL,
          belong_to int NOT NULL,
          task_content longtext NOT NULL,
          task_status text NOT NULL,
          task_type text NOT NULL,
          create_date datetime NOT NULL,
          deadline datetime NOT NULL,
          complete_count int NOT NULL
 * */


$task_name = isset($_POST["tname"]) ? $_POST["tname"] : '';

$task_content = isset($_POST["tabstract"]) ? $_POST["tabstract"] : '';

$deadline = isset($_POST["tdeadline"]) ? $_POST["tdeadline"] : "";

$belong_to = isset($_POST['belong_to']) ? $_POST['belong_to'] : '';

$task_id = isset($_POST["task_id"]) ? $_POST["task_id"] : "";

$sql_update = "UPDATE wp_gp_task SET task_name = '$task_name',
                                     task_content = '$task_content',
                                     deadline = '$deadline'
                                 WHERE ID = $task_id and belong_to = $belong_to";

if($task_name!="" && $task_content!="" && $belong_to !="" && $deadline != ""){
    $wpdb->query($sql_update);
}

//notice
$member = get_group_member_id($belong_to);
foreach ($member as $value) {
    $notice_id = $value->user_id;   //被通知人ID
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    //判断是否有这个通知
    $sql_has_notice = "SELECT ID FROM wp_gp_notice WHERE user_id = $notice_id and group_id = $belong_to
                        and notice_type = 9 and notice_content = '$task_id'";
    $col =  $wpdb->query($sql_has_notice);
    if($col==0){
        $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$notice_id,$belong_to,9,'$task_id',0,'$current_time')";
        $wpdb->get_results($sql_add_notice);
    }else{
        $sql_update_notice = "update wp_gp_notice set modified_time = '$current_time',notice_status = 0 WHERE user_id = $notice_id and group_id = $belong_to
                        and notice_type = 9 and notice_content = '$task_id'";
        $wpdb->get_results($sql_update_notice);
    }
}

$url= site_url().get_page_address('single_group').'&id='.$belong_to;
?>
<script>
    location.replace("<?=$url?>");
</script>