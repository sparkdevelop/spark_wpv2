<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>book</title>
    <link rel="stylesheet" type="text/css" href="/library/Public/css/book.css">
    <link rel="stylesheet" type="text/css" href="/library/Public/css/header.css">
    <link rel="stylesheet" type="text/css" href="/library/Public/css/footer.css">
    <script type="text/javascript" src="/library/Public/js/jquery-1.11.1.min.js"></script>
</head>
</head>
<body>
<div class="content">
    <div class="head">
    <div class="title">
        <div class="title-left">
            <span class="title-m"><a href="<?php echo U(index);?>">物品管理</a></span>
            <!-- <span class="title-help"><a href="<?php echo U(help);?>">帮助</a></span> -->
            <span class="title-main"><a href="<?php echo U(contribute);?>">物品上传</a></span>
            <span class="title-share"><a href="<?php echo U(share);?>">物品库</a></span>
        </div>
        <div class="div-search">
            <form name="search" action="<?php echo U(search);?>" method="post">
                <input  class="search" name="search" type="text" placeholder="书名/分类？" />
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
                    <?php if($user['image'] == '') :?>
                    <span><img src="/library/Public/images/defaultheader.jpg"/></span>
                    <?php else :?>
                    <span><img src="<?php echo ($user['image']); ?>"/></span>
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
            <div class="classify-title"><a style="cursor: pointer;color:#000;text-decoration: none" href="<?php echo U(index);?>">物品管理</a>>物品中心</div>
        </div>
        <div class="main-left">
            <div class="left-body">
                <img src="<?php echo ($cominfo['img']); ?>"/>
                <span class="name"><?php echo ($cominfo['name']); ?></span>
                <span class="name">库存：<?php echo ($cominfo['number_left']); ?></span>
            </div>
        </div>
        <div class="main-right">
            <div class="right-body">
                <div class="main-navigate">
                    <ul>
                        <li class="border">简介</li>
                    </ul>
                </div>
                <div class="body-message">
                    <div class="book-message">
                        <div>
                            <div class="book-main">
                                <span class="book-info">物品简介</span>
                            </div>
                            <div class="book-mainsessage">
                                <span><?php echo ($cominfo['summary']); ?></span>
                            </div>
                        </div>
                        <div>
                            <div class="book-main">
                                <span class="book-info">物品库存分布</span>
                            </div>
                            <div class="book-mainsessage">
                                <table>
                                    <thead>
                                        <th>序号</th>
                                        <th>保管者</th>
                                        <th>数量</th>
                                        <th>校区</th>
                                        <th>操作</th>
                                    </thead>
                                    <tbody>
                                        <?php if(is_array($comLog)): foreach($comLog as $key=>$item): ?><tr>
                                                <th><?php echo ($item['id']); ?></th>
                                                <th><?php echo ($item['keeper_name']); ?></th>
                                                <th><?php echo ($item['number']); ?></th>
                                                <th><?php echo ($item['address']); ?></th>
                                                <?php if($item['status'] == 2):?>
                                                <th>借用</th>
                                                <?php elseif($item['status'] == 3):?>
                                                <th>归还</th>
                                                <?php elseif($item['status'] == 4):?>
                                                <th>保修</th>
                                                <?php endif?>
                                            </tr><?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
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
<script type="text/javascript" src="/library/Public/js/book.js"></script>
<script type="text/javascript" src="/library/Public/js/labelsearch.js"></script>
</html>