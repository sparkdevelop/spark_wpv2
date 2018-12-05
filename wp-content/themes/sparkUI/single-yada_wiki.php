<?php
/**
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/7
 * Time: 16:52
 */
$url_this = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
$no_login = get_the_ID_by_title('火星派');
$tag_id = get_tag_id('火星派');
$no_login_post = get_post_by_tag($tag_id);
$post_id = get_the_ID();
if(in_array($post_id,$no_login_post) ){
    get_header();
    if(!user_can_view($post_id)){
        require "wiki-permission-verify.php";
    }
    else{
        require "single-yada_wiki_content.php";
    }
}else{
    if (!is_user_logged_in()) {
        wp_redirect( wp_login_url($url_this) );
    }else{
        get_header();
        if(!user_can_view($post_id)){
            require "wiki-permission-verify.php";
        }
        else{
            require "single-yada_wiki_content.php";
        }
    }
}

?>


























