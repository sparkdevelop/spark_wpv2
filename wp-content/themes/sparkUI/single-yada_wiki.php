<?php
/**
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/7
 * Time: 16:52
 */
if (!is_user_logged_in()) {
    wp_redirect( home_url().'/wp-login.php' );
}
get_header(); ?>
<?php $post_id = get_the_ID();
if(!user_can_view($post_id)){
    require "wiki-permission-verify.php";
}
else{
    require "single-yada_wiki_content.php";
}?>


























