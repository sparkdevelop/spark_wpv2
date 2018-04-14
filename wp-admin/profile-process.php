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
    if(hasSinfo('University')){
        $sql = "UPDATE $wpdb->usermeta SET meta_value ='".$school."' WHERE meta_key='University' AND user_id ='".$current_user->ID."'";
        $wpdb->get_results($sql);
    }else{
        $sql = "INSERT INTO $wpdb->usermeta VALUES ('',$current_user->ID,'University','$school')";
        $wpdb->get_results($sql);
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


