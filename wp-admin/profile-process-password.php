<?php
global  $wpdb;
require_once( dirname( __FILE__ ) . '/admin.php' );
$current_user = wp_get_current_user();

//密码更改
$newPassword = isset($_POST["newPassword"]) ? $_POST["newPassword"] : '';
if(empty($newPassword)){
    echo "error";
}
else{
    $newPassword = wp_hash_password($newPassword);
    $sql = "UPDATE $wpdb->users SET user_pass ='".$newPassword."' WHERE ID ='".$current_user->ID."'";
    $wpdb->get_results($sql);
}
$url= site_url().$page_address;
?>
<script language="javascript">
    location.replace("<?=$url?>");
</script>