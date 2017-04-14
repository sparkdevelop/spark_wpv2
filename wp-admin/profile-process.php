<?php
global  $wpdb;
require_once( dirname( __FILE__ ) . '/admin.php' );
$page_address = get_page_address('personal');
$current_user = wp_get_current_user();
$user_description = get_user_meta($current_user->ID,'description',true);

//email验证
$newemail = isset($_POST["email"]) ? $_POST["email"] : '';
if(empty($newemail)){
    //echo "error";
}
else{
    $sql = "UPDATE $wpdb->users SET user_email ='".$newemail."' WHERE ID ='".$current_user->ID."'";
    $wpdb->get_results($sql);
}

//密码验证

$password = isset($_POST["password"]) ? $_POST["password"] :'';
if(empty($password)){
    //$imageadd = bloginfo('template_url').'/img/ERROR.png';
    //$innerHtml=
    $response = '<img src="http://localhost/wordpress/wp-content/themes/sparkUI/img/ERROR.png"/>';
}
else {
    $response = "good";
}
echo $response;








//$url= site_url().$page_address.'&tab=profile';
?>
<!--<script language="javascript">-->
<!--    location.href= "--><?//=$url?><!--";-->
<!--</script>-->


