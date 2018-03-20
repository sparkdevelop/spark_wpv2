<?php //session_start(); ?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); filemtime( get_stylesheet_directory() . '/style.css'); ?>"
          type="text/css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" media="screen, projection" href="<?php bloginfo('stylesheet_directory')?>/css/mobile.css" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
    <link href="<?php bloginfo('stylesheet_directory')?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<!--    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">-->
<!--    <script src="http://cdn.static.runoob.com/libs/jquery/1.10.2/jquery.min.js"></script>-->
    <link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('stylesheet_directory')?>/datetimepicker/css/bootstrap-datetimepicker.min.css" />
    <!--    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.js"></script>-->
<!--    <script src="http://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" href="<?php bloginfo("template_url")?>/template/group/im/im.css">
    <meta charset="UTF-8">
    <title>火花空间</title>
<!--    --><?php //wp_enqueue_style('sparkUI',get_stylesheet_uri());//加载jquery?>
    <?php wp_enqueue_script("jquery");//加载jquery?>
    <?php wp_head(); //加载js?>
    <?php $url_this = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"]; ?>

    <?php
    //控制导航栏显示哪几个page
    global $budao_official;
    $budao_official = "腾讯云@沙邮-布道师大赛";
    $page_wiki_id = get_page_id('wiki_index');
    $page_qa_id = get_page_id('qa');
    $page_project_id =get_page_id('project');
    $student_management_id =get_page_id('student_management');
    $page_group_id =get_page_id('group');
    $page_rbac_id = get_page_id('rbac');
    if (current_user_can( 'manage_options' )){
        $page_all_id=array($page_wiki_id,$page_qa_id,$page_project_id,$page_group_id,$page_rbac_id);
    }else{
        $page_all_id=array($page_wiki_id,$page_qa_id,$page_project_id,$page_group_id);

    }
    ?>

    <?php
    //埋数据点 
    session_start();
    $_SESSION['post_id']=isset($_COOKIE['page_id']) ? $_COOKIE['page_id'] : get_the_ID();
    $_SESSION['post_type']=get_post_type($_SESSION['post_id']);
    $_SESSION['user_id']=get_current_user_id();
    $_SESSION['action']=isset($_COOKIE['action']) ? $_COOKIE['action'] : 'browse';
    setcookie("page_id");
    setcookie("action");
    $_SESSION['timestamp']=date("Y-m-d H:i:s",time()+8*3600);
    writeUserTrack();
    //?>

</head>
<div class="header">
    <div class="container">
        <div class="row" id="web-header" style="width: 100%;">
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
                                wp_list_pages(array('include'=> $page_all_id,'title_li' => '','depth'=>1));//,'exclude' => 38
                                ?>
                                <li class="page_item page-item-20548">
<!--                                    <a href="--><?php //the_permalink(20548); ?><!--">多校</a>-->
                                    <a href="<?php the_permalink(get_the_ID_by_title('认知工委会')); ?>">多校</a>
                                </li>
                            </ul>
                        </div>
                        <!--登录注册用户头像-->
                        <?php
                        if(is_user_logged_in()){
                            $current_user = wp_get_current_user();
                            $person_address=get_page_address('personal');
                            ?>
                            <div class="dropdown btn-group" >
                                <button type="button" id="user-portrait" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                    <?php echo get_avatar($current_user->ID,30,'');?>
                                    <?
                                    if(hasGPNotice() || hasPrivateMessage() || hasNotice()){?>
                                        <i id="red-point"></i>
                                    <? } ?>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="margin-top: 14px">
                                    <li role="presentation" style="height:35px;">
                                        <a role="menuitem" tabindex="-1" href="<?php echo site_url().$person_address;?>">
                                            <span class="glyphicon glyphicon-user"></span>
                                            <span>个人主页</span>
                                        </a>
                                    </li>
                                    <li role="presentation" style="height:35px;">
                                        <a role="menuitem" tabindex="-1" href="<?php echo site_url().$person_address.'&tab=notification'?>"
                                           style="position:relative;">
                                            <span class="glyphicon glyphicon-bell"></span>
                                            <span>消息通知</span>
                                            <? if(hasGPNotice() || hasPrivateMessage() || hasNotice()){?>
                                                <i id="red-point" style="right: 25px;top: 12px"></i>
                                            <? } ?>
                                        </a>

                                    </li>
                                    <li role="presentation" style="height:35px;">
                                        <a role="menuitem" tabindex="-1" href="<?php echo site_url().$person_address;?>&tab=profile"><span class="glyphicon glyphicon-cog"></span> 设置</a>
                                    </li>
                                    <li role="presentation" style="height:35px;">
                                        <a role="menuitem" tabindex="-1" href="<?php echo wp_logout_url(); ?>"><span class="glyphicon glyphicon-log-in"></span> 退出</a>
                                    </li>
                                </ul>
                            </div>

<!--                            <script>-->
<!--                                $(document).ready(function(){-->
<!--                                    $(document).off('click.bs.dropdown.data-api');-->
<!--                                    var $dropdownLi = $('.dropdown li');-->
<!--                                    $dropdownLi.mouseover(function() {-->
<!--                                        $(this).addClass('open');-->
<!--                                    }).mouseout(function() {-->
<!--                                        $(this).removeClass('open');-->
<!--                                    })-->
<!--                                })-->
<!--                            </script>-->

                        <?php } else { ?>
                            <!--                             https://codex.wordpress.org/Function_Reference/wp_login_url-->
                            <a class="navbar-text" href="<?php echo wp_login_url($url_this); ?>">登录</a>
                            <a class="navbar-text" href="<?php echo site_url(); ?>/wp-login.php?action=register">注册</a>
                        <?php } ?>
                    </div>
                    <div class="clearfix visible-xs"></div>
                    <div class="col-md-3 col-sm-3 col-xs-3" id="col3">
                        <form class="navbar-form " role="search" method="get" action="<?php echo home_url('/');//get_permalink() ?>" style="float: right;padding-left: 0px;padding-right: 0px">
                            <div class="form-group" style="position: relative">
<!--                                <select class="form-control" id="search_select"-->
<!--                                        onchange="selectSearchCat(this.value);">-->
<!--                                    <option value="all">搜全部</option>-->
<!--                                    <option value="qa">搜问答</option>-->
<!--                                    <option value="wiki">搜wiki</option>-->
<!--                                    <option value="project">搜项目</option>-->
<!--                                </select>-->
                                <input type="text" id="search-content" name='s' class="form-control" placeholder="Search" value="">
<!--                                <input type="hidden" name="post_status" value="publish">-->
<!--                                <input type="hidden" name="post_type" id="selectPostType" value="all"/>-->
                                <button type="submit" class="btn btn-default btn-sm" id="search-btn">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix visible-xs"></div>
            </nav>
        </div>

        <div class="row" id="m-header" style="width: 100%;flex: 0 0 auto;">
            <nav class="navbar navbar-default " role="navigation">
                <div class="container-fluid">
                    <div class="col-md-9 col-sm-9 col-xs-12" id="col9" style="height: 60px;">
                        <div class="navbar-header">
                            <i class="fa fa-bars m-nav-icon" aria-hidden="true" id="m-nav-icon"></i>
                            <a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php bloginfo("template_url")?>/img/logo.png"></a>
                            <i class="fa fa-search m-fa-search" aria-hidden="true" id="m-search-icon"></i>
                            <i class="fa fa-times m-fa-remove" aria-hidden="true" id="m-search-close"></i>
                        </div>
                    </div>
                    <div class="clearfix visible-xs"></div>
                </div>
            </nav>
            <div class="m_search_box">
                <form class="navbar-form " role="search" method="get" action="<?php echo home_url('/');//get_permalink() ?>" style="float: right;padding-left: 0px;padding-right: 0px">
                    <div class="form-group" style="position: relative">
                        <input type="text" id="search-content" name='s' class="form-control" placeholder="Search" value="">
                        <button type="submit" class="btn btn-default btn-sm" id="search-btn">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="clearfix visible-xs"></div>
        </div>
    </div>
    <div style="height: 2px;background-color: #fe642d"></div>
    <div style="height: 4px;background-color: #ffe9e1"></div>
</div>
    <?php if(is_user_logged_in()){?>
    <div class="m-left-collapse-overlayer">
        <div class="m-left-collapse-menu">
            <div class="self-bg">
                <div class="m-avatar-box">
                    <button type="button" id="m-user-portrait" class="btn btn-default">
                        <?php echo get_avatar(wp_get_current_user()->ID, 60, ''); ?>
                    </button>
                    <div class="m-login-text">
                        <p style="font-size: large;margin-top: 20px"><?php echo wp_get_current_user()->data->display_name; ?></p>
                    </div>
                </div>
            </div>
            <div class="m-left-nav-box">
                <ul class="m-left-nav">
                    <li>
                        <img src="<?php bloginfo("template_url") ?>/img/wiki.png">
                        <a href="<?php echo site_url() . get_page_address('wiki_index'); ?>">wiki</a>
                    </li>
                    <li>
                        <img src="<?php bloginfo("template_url") ?>/img/qa.png">
                        <a href="<?php echo site_url() . get_page_address('qa'); ?>">问答</a>
                    </li>
                    <li>
                        <img src="<?php bloginfo("template_url") ?>/img/project.png">
                        <a href="<?php echo get_the_permalink(get_page_by_title('项目')); ?>">项目</a>
                    </li>
                    <li>
                        <img src="<?php bloginfo("template_url") ?>/img/group.png">
                        <a href="<?php echo get_the_permalink(get_page_by_title('协作')); ?>">协作</a>
                    </li>
                </ul>
            </div>
            <div class="m-left-personal-nav" id="m-left-personal-nav">
                <a id="m-btn-nav-personal" data-target="#m-personal-nav" onclick="collapse()">
                    <span class="glyphicon glyphicon-user"></span>个人<i class="fa fa-angle-down" aria-hidden="true"></i>
                </a>
                <div id="m-personal-nav" class="collapse">
                    <ul id="personal_nav" class="nav nav-pills nav-stacked">
                        <li><span><a href="<?php echo site_url() . get_page_address("personal") . '&tab=notification' ?>">消息提醒</a></span></li>
                        <li><span><a href="<?php echo site_url() . get_page_address("personal") . '&tab=wiki' ?>">我的wiki</a></span></li>
                        <li><span><a href="<?php echo site_url() . get_page_address("personal") . '&tab=qa' ?>">我的问答</a></span></li>
                        <li><span><a href="<?php echo site_url() . get_page_address("personal") . '&tab=project' ?>">我的项目</a></span></li>
                        <li><span><a href="<?php echo site_url() . get_page_address("personal") . '&tab=profile' ?>">个人资料</a></span></li>
                    </ul>
                </div>
            </div>
            <div class="setting" id="m-setting">
                <a href="<?php echo site_url() . get_page_address("personal"); ?>&tab=profile"><span
                        class="glyphicon glyphicon-cog"></span> 设置</a>
                <a href="<?php echo wp_logout_url(); ?>"><span class="glyphicon glyphicon-log-in"></span> 退出</a>
            </div>
        </div>
    </div>
    <?php }
    else { ?>
    <div class="m-left-collapse-overlayer">
        <div class="m-left-collapse-menu">
            <div class="self-bg">
                <div class="m-avatar-box">
                    <button type="button" id="m-user-portrait" class="btn btn-default">
                        <?php echo get_avatar('', 60, ''); ?>
                    </button>
                    <div class="m-login-text">
                        <a href="<?php echo wp_login_url($url_this); ?>">登陆</a>
                        <span>/</span>
                        <a href="<?php echo site_url(); ?>/wp-login.php?action=register">注册</a>
                    </div>
                </div>
            </div>
            <div class="m-left-nav-box">
                <ul class="m-left-nav">
                    <li>
                        <img src="<?php bloginfo("template_url") ?>/img/wiki.png">
                        <a href="<?php echo site_url() . get_page_address('wiki_index'); ?>">wiki</a>
                    </li>
                    <li>
                        <img src="<?php bloginfo("template_url") ?>/img/qa.png">
                        <a href="<?php echo site_url() . get_page_address('qa'); ?>">问答</a>
                    </li>
                    <li>
                        <img src="<?php bloginfo("template_url") ?>/img/project.png">
                        <a href="<?php echo get_the_permalink(get_page_by_title('项目')); ?>">项目</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <?php } ?>
