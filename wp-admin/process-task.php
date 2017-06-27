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
          deadline datetime NOT NULL
 * */
$task_name = isset($_POST["tname"]) ? $_POST["tname"] : '';

$task_author = isset($_POST["tauthor"]) ? $_POST["tauthor"] : '';

$task_content = isset($_POST["tabstract"]) ? $_POST["tabstract"] : '';

$task_status  = isset($_POST["tstatus"]) ? $_POST["tstatus"] : "publish";

$task_type  = isset($_POST["ttype"]) ? $_POST["ttype"] : "";

$create_date = isset($_POST["tcreatedate"]) ? $_POST["tcreatedate"] : "";

$deadline = isset($_POST["tdeadline"]) ? $_POST["tdeadline"] : "";

echo "task_name: ".$task_name."<br>";
echo "task_author: ".$task_author."<br>";
echo "task_content: ".$task_content."<br>";
echo "task_status: ".$task_status."<br>";
echo "task_type: ".$task_type ."<br>";
echo "create_date: ".$create_date ."<br>";
echo "deadline: ".$deadline ."<br>";