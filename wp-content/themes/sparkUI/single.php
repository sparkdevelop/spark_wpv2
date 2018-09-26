<?php
/**单独的文章模板
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/7
 * Time: 16:52
 */
if (!is_user_logged_in()) {
    wp_redirect( home_url().'/wp-login.php' );
}
get_header();
$post_id = get_the_ID();
if(!user_can_view($post_id)){
    require "post-permission-verify.php";
}
else{
    require "single_content.php";
} ?>

