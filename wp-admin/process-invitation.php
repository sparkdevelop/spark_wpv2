<?php
//处理邀请
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');

$group_id = isset($_POST["group_id"]) ? $_POST["group_id"] : '';
$invitation_member = isset($_POST["invitation_member"]) ? $_POST["invitation_member"] : [];
$invitation_member = array_filter($invitation_member);

foreach ($invitation_member as $value){
    $id = get_the_ID_by_name($value);
    invitation_join_the_group($id,$group_id);
}

function invitation_join_the_group($user_id,$group_id){
    global $wpdb;
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    //判断验证方式
    if ($group_id != "") {
        $verify_type = get_verify_type($group_id);
        if($verify_type == "freejoin"){
            //看这个人是第几次加入了,初次加入,执行insert,退出又加入,执行update
            $sql_count ="Select * From wp_gp_member WHERE user_id=$user_id and group_id=$group_id";
            $col = $wpdb->query($sql_count);
            if($col == 0){
                $sql_member = "INSERT INTO wp_gp_member VALUES ('',$user_id,$group_id,'member','$current_time','',0)";
                $wpdb->get_results($sql_member);
            }else{
                $sql_member = "update wp_gp_member set member_status = 0 WHERE user_id = $user_id and group_id = $group_id";
                $wpdb->get_results($sql_member);
            }
            $sql_add_count = "update wp_gp set member_count = (member_count+1) WHERE ID = $group_id";
            $wpdb->get_results($sql_add_count);
        }elseif ($verify_type == "verify"){
            //等待验证即可,将其存入tmp表
            $sql_member = "INSERT INTO wp_gp_member_verify_tmp VALUES ('',$user_id,$group_id,'$current_time','')";
            $wpdb->get_results($sql_member);
        }else{
            //先弹出框框,填写好字段,然后将字段值存入tmp表
            $response = "verifyjoin";
        }
    }
}
?>
<script>
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
    parent.layer.msg("已成功邀请", {time: 2000, icon: 1});
    parent.location.reload();
</script>