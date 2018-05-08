<?php
global  $wpdb;
require_once( dirname( __FILE__ ) . '/admin.php' );
$page_address = get_page_address('personal');
$current_user = wp_get_current_user();
$user_description = get_user_meta($current_user->ID,'description',true);

//email更改
$newemail = isset($_POST["email"]) ? $_POST["email"] : '';
if(!empty($newemail)){
    $sql = "UPDATE $wpdb->users SET user_email ='".$newemail."' WHERE ID ='".$current_user->ID."'";
    $wpdb->get_results($sql);
}

// 签名更改
$description = isset($_POST["description"]) ? $_POST["description"] : '';
$sql = "UPDATE $wpdb->usermeta SET meta_value ='".$description."' WHERE meta_key='description' AND user_id ='".$current_user->ID."'";
$wpdb->get_results($sql);

//学校填写
$school=isset($_POST["school_select"]) ? $_POST["school_select"] : '';
$sno = isset($_POST["Sno"]) ? $_POST["Sno"] : '';

//判断当前的用户写没写过学校、学号
if ($school!=''){
    //角色和学校相对应
    $modified_time = date('Y-m-d H:i:s',time()+8*3600);
    //取出新学校名称
    $sname = $wpdb->get_results("select uvs_name from wp_ms WHERE ID = $school")[0]->uvs_name;
    $role_id = $wpdb->get_results("SELECT ID from wp_rbac_role WHERE role_name = '$sname'")[0]->ID;
    if(hasSinfo('University')){
        //取出旧学校的角色id
        $old_sid = get_user_meta($current_user->ID, 'University', true);
        $old_sname = $wpdb->get_results("select uvs_name from wp_ms WHERE ID = $old_sid")[0]->uvs_name;
        $old_role_id = $wpdb->get_results("SELECT ID from wp_rbac_role WHERE role_name = '$old_sname'")[0]->ID;
        $sql = "UPDATE $wpdb->usermeta SET meta_value =$school WHERE meta_key='University' AND user_id =$current_user->ID";
        $wpdb->get_results($sql);
        //更新角色
        $sql_ur = "UPDATE wp_rbac_ur SET role_id=$role_id,modified_time ='$modified_time' WHERE user_id = $current_user->ID and role_id = $old_role_id";
        $wpdb->get_results($sql_ur);
    }else{
        $sql = "INSERT INTO $wpdb->usermeta VALUES ('',$current_user->ID,'University','$school')";
        $wpdb->get_results($sql);
        //插入角色
        $sql_ur = "INSERT INTO wp_rbac_ur VALUES ('',$current_user->ID,$role_id,$current_user->ID,'$modified_time')";
        $wpdb->get_results($sql_ur);
    }
}
if ($sno!=''){
    if(hasSinfo('Sno')){
        $sql = "UPDATE $wpdb->usermeta SET meta_value ='".$sno."' WHERE meta_key='Sno' AND user_id ='".$current_user->ID."'";
        $wpdb->get_results($sql);
    }else{
        $sql = "INSERT INTO $wpdb->usermeta VALUES ('',$current_user->ID,'Sno','$sno')";
        $wpdb->get_results($sql);
    }
}

$url= site_url().$page_address.'&tab=profile';
?>
<script language="javascript">
    location.replace("<?=$url?>");
</script>


