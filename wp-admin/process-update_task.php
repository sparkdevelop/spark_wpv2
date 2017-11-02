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

if($task_name!="" && $task_content!="" && $belong_to !=""){
    $wpdb->query($sql_update);
}
$url= site_url().get_page_address('single_group').'&id='.$belong_to;
?>
<script>
    location.replace("<?=$url?>");
</script>