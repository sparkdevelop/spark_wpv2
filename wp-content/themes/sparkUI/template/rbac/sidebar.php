<?php $current_user = wp_get_current_user();
$user_description = get_user_meta($current_user->ID,'description',true);
$admin_url=admin_url('admin-ajax.php');
?>


<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <ul id="personal_nav" class="nav nav-pills nav-stacked">
        <li class="active" id="gup">
            <img src="<?php bloginfo("template_url")?>/img/notification.png">
            <span>
                <a href="<?php echo esc_url(add_query_arg(array('tab'=>'gup'),remove_query_arg(array('paged','filter'))))?>">授予用户权限</a>
            </span>
        </li>
        <li id="gur">
            <img src="<?php bloginfo("template_url")?>/img/qa.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'gur'),remove_query_arg(array('paged','filter'))))?>">授予用户角色</a></span>
        </li>
        <li id="grp">
            <img src="<?php bloginfo("template_url")?>/img/wiki.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'grp'),remove_query_arg(array('paged','filter'))))?>">授予角色权限</a></span>
        </li>
        <li id="rl">
            <img src="<?php bloginfo("template_url")?>/img/qa.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'rl'),remove_query_arg(array('paged','filter'))))?>">角色配置</a></span>
        </li>
        <li id="pl">
            <img src="<?php bloginfo("template_url")?>/img/project.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'pl'),remove_query_arg(array('paged','filter'))))?>">权限配置</a></span>
        </li>
        <li id="ul">
            <img src="<?php bloginfo("template_url")?>/img/group.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'ul'),remove_query_arg(array('paged','filter'))))?>">查看用户权限</a></span>
        </li>
        <li id="approve">
            <img src="<?php bloginfo("template_url")?>/img/group.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'approve'),remove_query_arg(array('paged','filter'))))?>">审批用户权限</a></span>
        </li>
    </ul>
</div>
