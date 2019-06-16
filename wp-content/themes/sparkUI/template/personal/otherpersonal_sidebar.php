<?php
    $current_user = wp_get_current_user();
    $user_id = isset($_GET["id"]) ? $_GET["id"] : $current_user->ID ;
    $user_description = get_user_meta($user_id,'description',true);
    $admin_url=admin_url('admin-ajax.php');
?>

<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <div id="user-profile">
        <div id="avatar">
            <?php echo get_avatar($user_id,100);?>
        </div>
        <p style="font-size: large;margin-top: 20px"><?php echo get_the_author_meta('user_login',$user_id);?>
            <?php
            $user_level = get_user_level($user_id);
            $img_url = $user_level.".png";
            ?>
            <a href="<?php echo site_url().get_page_address('info').'&tab=integral'?>"><img src="<?php bloginfo("template_url")?>/img/integral/<?=$img_url?>" style="width: 20px"></a>
        </p>
        <p style="margin-top: 10px;color: gray"><?php echo $user_description;?></p>
        <?php
        $message_url = site_url() . get_page_address("private_message") . "&ruser_id=" . $user_id ;
        ?>
        <div class="p-message">
            <button class="btn-green" style="margin-right: 0px" onclick="send_private_message('<?=$message_url?>')">+ 私信</button>
        </div>
    </div>
    <ul id="personal_nav" class="nav nav-pills nav-stacked">
        <li id="wiki">
            <img src="<?php bloginfo("template_url")?>/img/wiki.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'wiki'),remove_query_arg(array('paged','filter'))))?>">TA的wiki</a></span>
        </li>
        <li class="active" id="qa">
            <img src="<?php bloginfo("template_url")?>/img/qa.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'qa'),remove_query_arg(array('paged','filter'))))?>">TA的问答</a></span>
        </li>
        <li id="project">
            <img src="<?php bloginfo("template_url")?>/img/project.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'project'),remove_query_arg(array('paged','filter'))))?>">TA的项目</a></span>
        </li>
        <li id="favorite" style="display: none">
            <img src="<?php bloginfo("template_url")?>/img/collection.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'favorite'),remove_query_arg(array('paged','filter'))))?>">TA的收藏</a></span>
        </li>
    </ul>
</div>
