<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); filemtime( get_stylesheet_directory() . '/style.css'); ?>"
          type="text/css" media="screen, projection"/>
<!--    <script type="text/javascript" src="--><?php //echo get_template_directory_uri(); ?><!--/js/jquery.js"></script>-->
<!--    <script src="http://cdn.static.runoob.com/libs/jquery/3.1.1/jquery.js"></script>-->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <script src="<?php bloginfo('template_url');?>/bootstrap/jquery-3.2.0.min.js"</script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.js"></script>
    <meta charset="UTF-8">
    <title>火花空间</title>
<!--    --><?php //wp_enqueue_style('sparkUI',get_stylesheet_uri());//加载jquery?>
    <?php wp_enqueue_script("jquery");//加载jquery?>
    <?php wp_head(); //加载js?>
</head>
<body>
    <div class="container">
        <div class="row" style="width: 100%">
            <nav class="navbar navbar-default " role="navigation">

                <div class="container-fluid">
                    <div class="col-md-9 col-sm-9 col-xs-9" id="col9">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php bloginfo("template_url")?>/img/logo.png"></a>
                        </div>
                        <div>
                            <ul class="nav navbar-nav">
                                <?php
                                    //列出用户添加的页面 不列出Home页//问题是如何加特效?
                                    wp_list_pages(array('title_li' => '','depth'=>1));//,'exclude' => 38
                                ?>
                            </ul>
                        </div>

                        <!--登录注册用户头像-->
                        <?php
                        if(is_user_logged_in()){
                            $current_user = wp_get_current_user();
                            $person_address=get_page_address('personal');
                            ?>
                            <div class="btn-group" >
                                <button type="button" id="user-portrait" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                       <?php echo get_avatar($current_user->ID,30,'');?>
                                </button>


                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="margin-top: 14px">
                                    <li role="presentation" style="height:35px;">
                                        <a role="menuitem" tabindex="-1" href="<?php echo admin_url();?>"><span class="glyphicon glyphicon-home"></span> 后台管理</a>
                                    </li>
                                    <li role="presentation" style="height:35px;">
                                        <a role="menuitem" tabindex="-1" href="<?php echo site_url().$person_address;?>"><span class="glyphicon glyphicon-user"></span>个人主页</a>
                                    </li>
                                    <li role="presentation" style="height:35px;">
                                        <a role="menuitem" tabindex="-1" href="#"><span class="glyphicon glyphicon-cog"></span> 设置</a>
                                    </li>
                                    <li role="presentation" style="height:35px;">
                                        <a role="menuitem" tabindex="-1" href="<?php echo site_url();?>/wp-login.php?loggedout=true"><span class="glyphicon glyphicon-log-in"></span> 退出</a>
                                    </li>
                                </ul>
                            </div>

                        <?php } else { ?>
                            <!--                             https://codex.wordpress.org/Function_Reference/wp_login_url-->
                            <a class="navbar-text" href="<?php echo wp_login_url( get_permalink() ); ?>">登陆</a>
                            <a class="navbar-text" href="<?php echo site_url(); ?>/wp-login.php?action=register">注册</a>
                        <?php } ?>
                    </div>
                    <div class="clearfix visible-xs"></div>
                    <div class="col-md-3 col-sm-3 col-xs-3" style="ma">
                        <form class="navbar-form " role="search" method="get" action="<?php echo home_url('/');//get_permalink() ?>" style="float: right;padding-left: 0px;padding-right: 0px">
                           <div class="form-group">
                               <input type="text" id="search-content" name='s' value="请输入要搜索的问题" onfocus="javascript:if(this.value=='请输入要搜索的问题')this.value=''" class="form-control" placeholder="Search">
<!--                                <input type="hidden" name="post_type" value="dwqa-question" class="form-control" placeholder="Search">-->
                                <input type="hidden" name="post_status" value="all">
                                <button type="submit" class="btn btn-default btn-sm" id="search-btn">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </form>


                    </div>
                    <div class="clearfix visible-xs"></div>
            </nav>
        </div>
    </div>
    <div style="height: 2px;background-color: #fe642d"></div>
    <div style="height: 4px;background-color: #ffe9e1"></div>
