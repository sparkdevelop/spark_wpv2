<?php
/**
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/7
 * Time: 16:52
 */
get_header(); ?>
<?php $post_id = get_the_ID();
if(false){
    require "wiki-permission-verify.php";
}
else{
    require "single-yada_wiki_content.php";
}?>


























