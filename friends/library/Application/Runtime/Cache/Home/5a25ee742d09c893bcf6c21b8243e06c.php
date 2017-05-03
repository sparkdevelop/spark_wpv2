<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>物品上传</title>
    <link rel="stylesheet" type="text/css" href="/library/Public/css/contribute.css">
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
                <div class="classify-title"><a style="cursor: pointer;color:#000;text-decoration: none" href="<?php echo U(share);?>">物品管理</a>>物品上传</div>
            </div>
            <div class="main-body">
                <div class="main-main">
                    <div class="book-upload">物&nbsp;品&nbsp;上&nbsp;传</div>
                    <!--<form name="form" action="{doContribute}" method="post" onsubmit="return check()">-->
                        <div class="isbn-message">
                            <div class="label-width">物品名称</div>
                            <div class="details-width book-details">
                                <input type="text" name="name" placeholder=""/>
                            </div>
                        </div>
                        <div class="book-reading-message">
                            <div class="label-width">物品图片</div>
                            <div class="details-width book-details">
                                <input type="file" class="user_pic" value="选择图片"/>
                                <input type="text" style="display:none;" name="imgpic" value=""/>
                                <input id="public" value="/library/Public" style="display: none">
                            <img class="img-result" src="">                           

                            </div>
                        </div>
                        <div class="book-reading-message">
                            <div class="label-width">物品数量</div>
                            <div class="details-width book-details">
                                <input type="text" name="number" placeholder=""/>个
                            </div>
                        </div>
                        <div class="book-join-drift">
                            <div class="label-width">物品分类</div>
                            <div class="details-width book-details">
                                <select name="tag">
                                    <option value="设备">设备</option>
                                    <option value="材料">材料</option>
                                    <option value="家具">家具</option>
                                    <option value="图书">图书</option>
                                </select>
                            </div>
                        </div>
                        <div class="book-leave-message">
                             <div class="label-width">物品简介</div>
                             <div class="details-width">
                                 <textarea class="write" name="summary"></textarea>
                             </div>
                        </div>
                        <input type="submit" value="确定上传" class="sure-submit"/>
                    <!--</form>-->
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
<script type="text/javascript" src="/library/Public/js/contribute.js"></script>
<!-- <script type="text/javascript" src="/library/Public/js/labelsearch.js"></script> --> 
</html>