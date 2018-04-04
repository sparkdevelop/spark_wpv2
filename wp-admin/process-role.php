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
$role_name = isset($_POST["rname"]) ? $_POST["rname"] : '';

$author = isset($_POST["rauthor"]) ? $_POST["rauthor"] : '';

$illstration = isset($_POST["rabstract"]) ? $_POST["rabstract"] : '';

$create_date = isset($_POST["rcreatedate"]) ? $_POST["rcreatedate"] : '';

//处理加入方式
//首先获取最后一个role_id;
$sql_fun = "select ID from wp_rbac_role ORDER BY ID DESC LIMIT 0,1";
$result = $wpdb->get_results($sql_fun);
$role_id = $result[0]->ID+1;


$sql_role = "INSERT INTO wp_rbac_role VALUES ($role_id,'$role_name',
                                              '$illstration','$author',
                                              '$create_date')";

if($role_name!="" && $illstration!=""){
    $wpdb->query($sql_role);
}
?>
<script>
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
    parent.layer.msg("成功创建", {time: 2000, icon: 1});
</script>

