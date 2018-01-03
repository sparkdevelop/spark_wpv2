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
$group_id = isset($_POST['group_id']) ? $_POST['group_id'] : 0;
$group = get_group($group_id);

$group_name = isset($_POST["gname"]) ? $_POST["gname"] : '';

$group_abstract = isset($_POST["gabstract"]) ? $_POST["gabstract"] : '';

$group_status = isset($_POST["gstatus"]) ? $_POST["gstatus"] : '';  //群组是否开放 value=open、close

$join_permission = isset($_POST["gjoin"]) ? $_POST["gjoin"] : '';   //freejoin、verifyjoin、verify

$task_permission = isset($_POST["gstatustask"]) ? $_POST["gstatustask"] : ''; //all、admin

//处理上传的图片
$upload_path = wp_upload_dir();  //获取wordpress的上传路径。

if(!empty($_FILES['gava']["name"])){
    $group_cover_address = $upload_path['url'] . "/" . $_FILES['gava']["name"];
    $new_upload_path = $upload_path['path'] . "/" . $_FILES['gava']["name"];  //本文件的上传路径,精确到文件名
    if (is_uploaded_file($_FILES['gava']['tmp_name'])) {   //判断文件时候是通过http_post上传的
        move_uploaded_file($_FILES['gava']['tmp_name'], $new_upload_path);
    }
}else{
    $group_cover_address = $group[0]['group_cover'];
}

/*对于加入方式的变更
 * 1、自由加入变为审核加入 1-》3       只更新gp表
 * 2、自由加入变为检验审核加入  1》2    更新gp表      审核表加入字段
 * 3、检验审核加入变为自由加入 2-》1    更新gp表     审核表删除字段
 * 4、检验审核变为审核加入 2-》3       更新gp表      审核表删除字段
 * 5、审核加入变为自由加入 3-》1       只更新gp表不用管
 * 6、审核加入变为检验审核加入 3-》2    更新gp表      审核表加入字段
 * 7、不变                          更新gp表    检验审核加入 总之就是更新一次
 * */

if(($group[0]['join_permission'] =='freejoin' && $join_permission == 'verifyjoin')
    ||$group[0]['join_permission'] == 'verify' && $join_permission =='verifyjoin'){
    //加入字段
    $verify_content = $_POST['g-ver-info'];
    if(sizeof($verify_content)!=0){
        $verify_content = implode(",",$verify_content);
        $sql_verify = "INSERT INTO wp_gp_verify VALUES ('','$group_id','group','$verify_content')";
        $wpdb->query($sql_verify);
    }
}elseif(($group[0]['join_permission'] =='verifyjoin' && $join_permission == 'verify')
    ||($group[0]['join_permission'] =='verifyjoin' && $join_permission == 'freejoin')){
    //删除字段
    $sql_verify = "DELETE FROM wp_gp_verify WHERE verify_id=$group_id and verify_type='group'";
    $wpdb->query($sql_verify);
}elseif($group[0]['join_permission'] == $join_permission && $join_permission == 'verifyjoin'){
    //更新字段
    $verify_content = $_POST['g-ver-info'];
    if(sizeof($verify_content)!=0){
        $verify_content = implode(",",$verify_content);
        $sql_verify = "UPDATE wp_gp_verify SET verify_content='$verify_content' WHERE verify_id=$group_id and verify_type='group'";
        $wpdb->query($sql_verify);
    }
}

$sql = "UPDATE wp_gp SET group_name='$group_name',group_abstract = '$group_abstract',
                          group_status='$group_status',group_cover='$group_cover_address',
                          join_permission='$join_permission',task_permission='$task_permission'
                    WHERE ID=$group_id";

if($group_name!="" && $group_abstract!="" && $group_status!="" &&
    $join_permission!="" && $task_permission!=""){
    $wpdb->query($sql);
}

//notice
$member = get_group_member_id($group_id);
foreach ($member as $value) {
    $notice_id = $value->user_id;   //被通知人ID
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    $user_id = get_current_user_id();
    //判断是否有这个通知
    $sql_has_notice = "SELECT ID FROM wp_gp_notice WHERE user_id = $notice_id and group_id = $group_id
                        and notice_type = 8 and notice_content = '$user_id'";
    $col =  $wpdb->query($sql_has_notice);
    if($col==0){
        $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$notice_id,$group_id,8,'$user_id',0,'$current_time')";
        $wpdb->get_results($sql_add_notice);
    }else{
        $sql_update_notice = "update wp_gp_notice set modified_time = '$current_time',notice_status = 0 WHERE user_id = $notice_id and group_id = $group_id
                        and notice_type = 8 and notice_content = '$user_id'";
        $wpdb->get_results($sql_update_notice);
    }
}

$url= site_url().get_page_address('single_group')."&id=".$group_id;
?>
<script>
    location.replace("<?=$url?>");
</script>

