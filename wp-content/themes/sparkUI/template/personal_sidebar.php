<?php $current_user = wp_get_current_user();
      $user_description = get_user_meta($current_user->ID,'description',true);

?>
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <div id="user-profile">
        <?php echo get_avatar($current_user->ID,100);?>
        <p style="font-size: large;margin-top: 20px"><?php echo $current_user->data->display_name;?></p>
        <p style="margin-top: 10px;color: gray"><?php echo $user_description;?></p>
    </div>
    <div style="height: 1px;background-color: lightgray;"></div>
    <ul id="personal_nav" class="nav nav-pills nav-stacked">
        <li>
            <img src="<?php bloginfo("template_url")?>/img/notification.png">
            <span>
                <a href="<?php echo esc_url(add_query_arg(array('tab'=>'notification')))?>">消息提醒</a>
            </span>
        </li>
        <li>
            <img src="<?php bloginfo("template_url")?>/img/wiki.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'wiki')))?>">我的wiki</a></span>
        </li>
        <li class="active">
            <img src="<?php bloginfo("template_url")?>/img/qa.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'qa')))?>">我的问答</a></span>
        </li>
        <li>
            <img src="<?php bloginfo("template_url")?>/img/project.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'project')))?>">我的项目</a></span>
        </li>
        <li>
            <img src="<?php bloginfo("template_url")?>/img/profile.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'profile')))?>">个人资料</a></span>
        </li>
    </ul>
</div>
