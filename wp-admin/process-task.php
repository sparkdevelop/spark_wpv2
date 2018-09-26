<?php
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');

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

$task_author = isset($_POST["tauthor"]) ? $_POST["tauthor"] : '';

$belong_to = isset($_POST['belong_to']) ? $_POST['belong_to'] : '';
//echo $belong_to;
$task_content = isset($_POST["tabstract"]) ? $_POST["tabstract"] : '';

$task_type = isset($_POST["ttype"]) ? $_POST["ttype"] : '';

$create_date = isset($_POST["tcreatedate"]) ? $_POST["tcreatedate"] : "";

$deadline = isset($_POST["tdeadline"]) ? $_POST["tdeadline"] : "";

$sql_fun = "select ID from wp_gp_task ORDER BY ID DESC LIMIT 0,1";
$result = $wpdb->get_results($sql_fun);
$task_id = $result[0]->ID + 1;

if ($task_type == "tread") {
    $verify_content = $_POST['tlink'];
    if (sizeof($verify_content) != 0) {
        $verify_content = implode(",", $verify_content);
        $sql_verify = "INSERT INTO wp_gp_verify VALUES ('','$task_id','task','$verify_content')";
        $wpdb->query($sql_verify);
    }
}

$sql = "INSERT INTO wp_gp_task VALUES ($task_id,'$task_name',$task_author,$belong_to,
                                          '$task_content','publish','$task_type',
                                          '$create_date','$deadline',0)";

if ($task_name != "" && $task_author != "" && $belong_to != "" &&
    $task_type != "" && $create_date != "" && $deadline != "") {
    $wpdb->query($sql);
    //notice
    $member = get_group_member_id($belong_to);
    foreach ($member as $value) {
        $notice_id = $value->user_id;   //被通知人ID
        $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$notice_id,$belong_to,4,'$task_id',0,'$create_date')";
        $wpdb->get_results($sql_add_notice);
    }
    $url= site_url().get_page_address('single_task').'&id='.$task_id;
    ?>
    <script>
        location.replace("<?=$url?>");
    </script>
<?php } ?>
