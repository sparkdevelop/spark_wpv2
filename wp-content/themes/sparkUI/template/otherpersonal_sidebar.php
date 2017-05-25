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
        <p style="font-size: large;margin-top: 20px"><?php echo get_userdata($user_id)->data->display_name;?></p>
        <p style="margin-top: 10px;color: gray"><?php echo $user_description;?></p>
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
        <li id="favorite">
            <img src="<?php bloginfo("template_url")?>/img/project.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'favorite'),remove_query_arg(array('paged','filter'))))?>">TA的收藏</a></span>
        </li>
    </ul>
</div>
