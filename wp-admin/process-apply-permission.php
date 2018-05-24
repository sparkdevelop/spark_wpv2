<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 2018/5/2
 * Time: 下午4:32
 */
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');

$user_id = isset($_POST["applyer"]) ? $_POST["applyer"] : '';
$choosen_pms_id_arr = isset($_POST["pcheckItem"]) ? $_POST["pcheckItem"] : [];
$choosen_role_id_arr = isset($_POST["rcheckItem"]) ? $_POST["rcheckItem"] : [];
$state =0;
$reason = isset($_POST["reason"]) ? $_POST["reason"] : '';
$modified_time = isset($_POST["pcreatedate"]) ? $_POST["pcreatedate"] : '';
$operator = '';


if ($choosen_pms_id_arr!=[]){   //如果申请了权限
    foreach ($choosen_pms_id_arr as $pid){
        $sql_check = "SELECT user_id FROM wp_rbac_apply_tmp WHERE user_id=$user_id and source_type=0 and source_id=$pid and state IN (0,2) ";
        $col = $wpdb->query($sql_check);
        if($col==0){
            $sql_pinsert = "INSERT INTO wp_rbac_apply_tmp VALUES ('',$user_id,0,$pid,0,'$reason','$operator','$modified_time')";
            $wpdb->get_results($sql_pinsert);
        }else{
            $sql_pupdate ="UPDATE wp_rbac_apply_tmp SET state = 0,reason='$reason',operator='',modified_time = '$modified_time' WHERE user_id=$user_id and source_type=0 and source_id=$pid";
            $wpdb->get_results($sql_pupdate);
        }

    }
}
if($choosen_role_id_arr!=[]){
    foreach ($choosen_role_id_arr as $rid){
        $sql_check = "SELECT user_id FROM wp_rbac_apply_tmp WHERE user_id=$user_id and source_type=1 and source_id=$rid and state IN (0,2) ";
        $col = $wpdb->query($sql_check);
        if($col==0){
            $sql_rinsert = "INSERT INTO wp_rbac_apply_tmp VALUES ('',$user_id,1,$rid,0,'$reason','$operator','$modified_time')";
            $wpdb->get_results($sql_rinsert);
        }else{
            $sql_rupdate ="UPDATE wp_rbac_apply_tmp SET state = 0,reason='$reason',operator='',modified_time = '$modified_time' WHERE user_id=$user_id and source_type=1 and source_id=$rid";
            $wpdb->get_results($sql_rupdate);
        }
    }
}
?>
<script>
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
    parent.layer.msg("已申请,等待管理员审核", {time: 2000, icon: 1});
</script>