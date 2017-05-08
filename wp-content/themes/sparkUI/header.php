<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); filemtime( get_stylesheet_directory() . '/style.css'); ?>"
          type="text/css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" media="screen, projection" href="http://localhost/spark_wpv2/wp-content/themes/sparkUI/css/mobile.css" />
<!--    <script type="text/javascript" src="--><?php //echo get_template_directory_uri(); ?><!--/js/jquery.js"></script>-->
<!--    <script src="http://cdn.static.runoob.com/libs/jquery/3.1.1/jquery.js"></script>-->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<!--    <script src="--><?php //bloginfo('template_url');?><!--/bootstrap/jquery-3.2.0.min.js"</script>-->
    <script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <title>火花空间</title>
<!--    --><?php //wp_enqueue_style('sparkUI',get_stylesheet_uri());//加载jquery?>
    <?php wp_enqueue_script("jquery");//加载jquery?>
    <?php wp_head(); //加载js?>
    <?php $url_this = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]; ?>
</head>
<body>
    <div class="container">
        <div class="row" style="width: 100%">
            <nav class="navbar navbar-default " role="navigation">

                <div class="container-fluid">
                    <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
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
                                        <a role="menuitem" tabindex="-1" href="<?php echo site_url().$person_address;?>"><span class="glyphicon glyphicon-user"></span>个人主页</a>
                                    </li>
                                    <li role="presentation" style="height:35px;">
                                        <a role="menuitem" tabindex="-1" href="<?php echo site_url().$person_address;?>&tab=profile"><span class="glyphicon glyphicon-cog"></span> 设置</a>
                                    </li>
                                    <li role="presentation" style="height:35px;">
                                        <a role="menuitem" tabindex="-1" href="<?php echo wp_logout_url(); ?>"><span class="glyphicon glyphicon-log-in"></span> 退出</a>
                                    </li>
                                </ul>
                            </div>

                        <?php } else { ?>
                            <!--                             https://codex.wordpress.org/Function_Reference/wp_login_url-->
                            <a class="navbar-text" href="<?php echo wp_login_url($url_this); ?>">登陆</a>
                            <a class="navbar-text" href="<?php echo site_url(); ?>/wp-login.php?action=register">注册</a>
                            <a id="m-login-button" href="<?php echo wp_login_url($url_this); ?>"><i class="fa fa-user-o" aria-hidden="true"></i></a>
                            <a class="m-fa-search"><i class="fa fa-search" aria-hidden="true"></i></a>
                            <a class="m-fa-remove"><i class="fa fa-times" aria-hidden="true"></i></a>
                        <?php } ?>
                    </div>
                    <div class="clearfix visible-xs"></div>
                    <div class="m_search_box">
                        <form class="navbar-form " role="search" method="get" action="<?php echo home_url('/');//get_permalink() ?>" style="float: right;padding-left: 0px;padding-right: 0px">
                            <div class="form-group" style="position: relative">
                                <select class="form-control" id="search_select"
                                        onchange="selectSearchCat(this.value);">
                                    <option value="qa">搜问答</option>
                                    <option value="wiki">搜wiki</option>
                                    <option value="project">搜项目</option>
                                </select>
                                <input type="text" id="search-content" name='s' class="form-control" placeholder="Search" value="">
                                <input type="hidden" name="post_status" value="publish">
                                <input type="hidden" name="post_type" id="selectPostType" value=""/>
                                <button type="submit" class="btn btn-default btn-sm" id="search-btn">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3" id="col3">
                        <form class="navbar-form " role="search" method="get" action="<?php echo home_url('/');//get_permalink() ?>" style="float: right;padding-left: 0px;padding-right: 0px">
                           <div class="form-group" style="position: relative">
                               <select class="form-control" id="search_select"
                                       onchange="selectSearchCat(this.value);">
                                   <option value="qa">搜问答</option>
                                   <option value="wiki">搜wiki</option>
                                   <option value="project">搜项目</option>
                               </select>
                                <input type="text" id="search-content" name='s' class="form-control" placeholder="Search" value="">
                                <input type="hidden" name="post_status" value="publish">
                                <input type="hidden" name="post_type" id="selectPostType" value=""/>
                                <button type="submit" class="btn btn-default btn-sm" id="search-btn">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </form>
                        <script>
                            function selectSearchCat(value) {
                                var post_type= document.getElementById("selectPostType");
                                if(value=="wiki"){
                                    post_type.value = "yada_wiki";
                                } else if(value=="project"){
                                    post_type.value = "post";
                                } else{
                                    post_type.value = "";
                                }
                            }
                        </script>
                    </div>
                    <div class="clearfix visible-xs"></div>
            </nav>
        </div>
    </div>
    <div style="height: 2px;background-color: #fe642d"></div>
    <div style="height: 4px;background-color: #ffe9e1"></div>
