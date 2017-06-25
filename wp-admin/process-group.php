<?php
global  $wpdb;
require_once( dirname( __FILE__ ) . '/admin.php' );
$page_address = get_page_address('creategroup');
$current_user = wp_get_current_user();
$user_description = get_user_meta($current_user->ID,'description',true);

//email更改
$newemail = isset($_POST["email"]) ? $_POST["email"] : '';
if(empty($newemail)){
    echo "error";
}
else{
    $sql = "UPDATE $wpdb->users SET user_email ='".$newemail."' WHERE ID ='".$current_user->ID."'";
    $wpdb->get_results($sql);
}

// 签名更改
$description = isset($_POST["description"]) ? $_POST["description"] : '';
if(empty($description)){
    echo "error";
}
else{
    $sql = "UPDATE $wpdb->usermeta SET meta_value ='".$description."' WHERE meta_key='description' AND user_id ='".$current_user->ID."'";
    $wpdb->get_results($sql);
}

$url= site_url().$page_address.'&tab=profile';
?>
<script language="javascript">
    location.replace("<?=$url?>");
</script>


