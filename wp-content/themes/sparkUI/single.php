<?php
/**单独的文章模板
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/7
 * Time: 16:52
 */
get_header();
$post_id = get_the_ID();
if(false){
    require "post-permission-verify.php";
}
else{
    require "single_content.php";
}?>