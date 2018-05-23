<?php
/**
 * info的导航部分
 */
?>
<style>
    #info_nav {
        background-color: white;
        padding: 10px 0px;
    }

    #info_nav > li {
        height: 50px;
        line-height: 50px;
        border-left: 3px solid transparent;
        text-align: center;
    }

    #info_nav > li.active {
        border-left: 3px solid;
        border-left-color: #fe642d;
        background-color: #fff9f7;
    }

    #info_nav > li.active > span > a {
        color: #fe642d;
    }

    #info_nav > li > span > a {
        color: #0f0f0f;
    }
</style>
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <h4>关于火花空间</h4>
    <div class="divline"></div>
    <ul id="info_nav" class="nav nav-pills nav-stacked">
        <li id="contact">
            <img src="<?php bloginfo("template_url") ?>/img/notification.png">
            <span><a
                    href="<?php echo esc_url(add_query_arg(array('tab' => 'contact'), remove_query_arg(array('paged', 'filter')))) ?>">联系我们</a></span>
        </li>
        <li id="about">
            <img src="<?php bloginfo("template_url") ?>/img/qa.png">
            <span><a
                    href="<?php echo esc_url(add_query_arg(array('tab' => 'about'), remove_query_arg(array('paged', 'filter')))) ?>">关于我们</a></span>
        </li>
        <li id="integral">
            <img src="<?php bloginfo("template_url") ?>/img/profile.png">
            <span><a
                    href="<?php echo esc_url(add_query_arg(array('tab' => 'integral'), remove_query_arg(array('paged', 'filter')))) ?>">积分规则</a></span>
        </li>
    </ul>
</div>