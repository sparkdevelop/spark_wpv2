<?php
/**
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/7
 * Time: 16:52
 */
$url_this = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
if (!is_user_logged_in()) {
    wp_redirect( wp_login_url($url_this) );
}else{
    get_header(); ?>
    <?php $post_id = get_the_ID();
    if(!user_can_view($post_id)){
        require "wiki-permission-verify.php";
    }
    else{
        require "single-yada_wiki_content.php";
    }
}
?>


























