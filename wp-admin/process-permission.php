<?php
/*        ID int AUTO_INCREMENT PRIMARY KEY,
          group_name text NOT NULL,
          group_author int NOT NULL,
          group_abstract longtext NOT NULL,
          group_status text NOT NULL,
          group_cover text NOT NULL,
          join_permission text NOT NULL,
          task_permission text NOT NULL,
          create_date datetime NOT NULL,
          member_count int NOT NULL
  * */
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');

//处理一般的数据
$permission_name = isset($_POST["pname"]) ? $_POST["pname"] : '';

$author = isset($_POST["pauthor"]) ? $_POST["pauthor"] : '';

$illstration = isset($_POST["pabstract"]) ? $_POST["pabstract"] : '';

$create_date = isset($_POST["pcreatedate"]) ? $_POST["pcreatedate"] : '';

$relative_post = isset($_POST['checkItem']) ? $_POST["checkItem"] : '';


//处理加入方式
//首先获取最后一个role_id;
$sql_fun = "select ID from wp_rbac_permission ORDER BY ID DESC LIMIT 0,1";
$result = $wpdb->get_results($sql_fun);
$permission_id = $result[0]->ID + 1;


$sql_permission = "INSERT INTO wp_rbac_permission VALUES ($permission_id,'$permission_name',
                                              '$illstration','$author',
                                              '$create_date')";
if ($permission_name != "" && $illstration != "") {
    $wpdb->query($sql_permission);
}
if(sizeof($relative_post)!=0){
    foreach ($relative_post as $p){
        $sql="INSERT INTO wp_rbac_post VALUES ('',$permission_id,$p,$author,'$create_date')";
        $wpdb->query($sql);
    }
}



?>
<script>
    window.close();
</script>

