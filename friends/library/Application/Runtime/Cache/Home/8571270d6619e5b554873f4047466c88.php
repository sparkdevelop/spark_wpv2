<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>个人中心</title>
    <link rel="stylesheet" type="text/css" href="/library/Public/css/person.css">
    <link rel="stylesheet" type="text/css" href="/library/Public/css/header.css">
    <link rel="stylesheet" type="text/css" href="/library/Public/css/footer.css">
    <script type="text/javascript" src="/library/Public/js/jquery-1.11.1.min.js"></script>
</head>
<body>
<div class="content">
    <div class="head">
    <div class="title">
        <div class="title-left">
            <span class="title-m"><a href="<?php echo U(share);?>">物品管理</a></span>
            <span class="title-help"><a href="<?php echo U(mywait);?>">购物车</a></span>
            <span class="title-main"><a href="<?php echo U(share);?>">物品库</a></span>
             <?php if($user['username'] == $admin['username']) :?>
            <span class="title-share"><a href="<?php echo U(contribute);?>">物品上传</a></span>
            <?php endif ?>    
        </div>
        <div class="div-search">
            <form name="search" action="<?php echo U(search);?>" method="post">
                <input  class="search" name="search" type="text" placeholder="输入您想搜索物品的名字" />
                <div class="search-a">
                    <input type="image" src="/library/Public/images/search.png" name="img">
                </div>
            </form>
            <!--<span>热门搜索：</span>-->
            <!--<span class="detail">-->
            <!--<span><a>数据库系统概念</a></span>-->
            <!--<span><a>CSS 3实战</a></span>-->
            <!--<span><a>操作系统概念</a></span>-->
            <!--</span>-->
        </div>
        <?php if($user['username'] == '') :?>
        <div class="username-list">
                <ul>
                    <li class="register"><a href="<?php echo U(register);?>">注册</a></li>
                    <li class="login"><a href="<?php echo U(login);?>">登录</a></li>
                </ul>
        </div>
        <?php else :?>
        <div class="username-c">
            <ul>
                <li>
                    <?php if($user['img'] == '') :?>
                    <span><img src="/library/Public/images/defaultheader.jpg"/></span>
                    <?php else :?>
                    <span><img src="<?php echo ($user['img']); ?>"/></span>
                    <?php endif?>
                    <span class="username-c-username"><?php echo ($user['username']); ?></span>
                    <ul>
                        <li><a href="<?php echo U(person);?>">我的主页</a></li>
                        <li><a href="<?php echo U(message);?>">账号设置</a></li>
                        <li><a href="<?php echo U(logout);?>">退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php endif ?>
    </div>
</div>
    <div class="main">
        <div class="classify">
            <div class="classify-title"><a style="cursor: pointer;color:#000;text-decoration: none" href="<?php echo U(share);?>">物品管理</a>>个人中心</div>
        </div>
        <div class="main-left">
            <div class="main-left-person">
                <div class="main-img">
                    <?php if($userdetails['img'] == ''):?>
                    <img class="user-images" src="/library/Public/images/defaultheader.jpg"/><br/>
                    <?php else :?>
                    <img class="user-images" src="<?php echo ($userdetails['img']); ?>"/><br/>
                    <?php endif?>
                    <span class="username"><?php echo ($userdetails['username']); ?></span><br/>
                    <span class="username"><?php echo ($userdetails['address']); ?></span>
                    <?php if($userdetails['username']==$user['username']){ ?>
                    <div><a href="<?php echo U(message);?>"><input class="sharebtn" type="button" value="账号设置"/></a></div>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="main-right-person">
            <div class="navigate">
                <ul>
                    <li class="border">动态</li>
                </ul>
            </div>
            <div class="subnavigate" style="display: block">
                <div style="display: block">
                    <ul style="height: 10px;clear: both;"></ul>
                    <div class="my-pass">
                        <div class="book_life_experience_p">
                            <section id="cd-timeline" class="cd-container">
                                <?php if ($userlog): ?>
                                <?php foreach ($userlog as $item): ?>
                                <?php if ($item['status']==2): ?>
                                <div class="cd-timeline-block">
                                    <div class="cd-timeline-img cd-picture">
                                        <img src="/library/Public/images/logo.png" alt="Picture">
                                    </div>

                                    <div class="cd-timeline-content">
                                        <h2>借</h2>
                                        <p><span class='keeper' ></span><?php echo ($item['name']); ?>&nbsp;X&nbsp;<?php echo ($item['number']); ?></p>
                                        <span class="cd-date"><?php echo ($item['time']); ?></span>
                                    </div>
                                </div>
                                <?php elseif ($item['status']==3): ?>
                                <div class="cd-timeline-block">
                                    <div class="cd-timeline-img cd-picture">
                                        <img src="/library/Public/images/logo.png" alt="Picture">
                                    </div>

                                    <div class="cd-timeline-content">
                                        <h2>还</h2>
                                        <p><span class='keeper' ></span><?php echo ($item['name']); ?>&nbsp;X&nbsp;<?php echo ($item['number']); ?></p>
                                        <span class="cd-date"><?php echo ($item['time']); ?></span>
                                    </div>
                                </div>
                                <?php elseif ($item['status']==4): ?>
                                <div class="cd-timeline-block">
                                    <div class="cd-timeline-img cd-picture">
                                        <img src="/library/Public/images/logo.png" alt="Picture">
                                    </div>

                                    <div class="cd-timeline-content">
                                        <h2>报修</h2>
                                        <p><span class='keeper' ></span><?php echo ($item['name']); ?>&nbsp;X&nbsp;<?php echo ($item['number']); ?></p>
                                        <span class="cd-date"><?php echo ($item['time']); ?></span>
                                    </div>
                                </div>
                                <?php endif ?>
                                <?php endforeach ?>
                                <?php endif ?>
                            </section>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <!-- <div class="footer">
    <div class="pass">
        <img src="/library/Public/images/qrmakerway.jpg"/><span>扫描关注makerway微信公众号</span>
    </div>
    <span>联系邮箱：maker_way@163.com</span>
    <div class="footer-img">
        <img src="/library/Public/images/makerway.png"/>
    </div>
</div> -->
</div>
</body>
<!-- <script type="text/javascript" src="/library/Public/js/person.js"></script>
<script type="text/javascript" src="/library/Public/js/labelsearch.js"></script> -->
</html>