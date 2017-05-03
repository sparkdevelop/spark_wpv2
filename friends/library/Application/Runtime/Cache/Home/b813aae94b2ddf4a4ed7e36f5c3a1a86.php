<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>物品库</title>
    <link rel="stylesheet" type="text/css" href="/spark_wpv2/friends/library/Public/css/share.css">
    <link rel="stylesheet" type="text/css" href="/spark_wpv2/friends/library/Public/css/header.css">
    <link rel="stylesheet" type="text/css" href="/spark_wpv2/friends/library/Public/css/footer.css">
    <script type="text/javascript" src="/spark_wpv2/friends/library/Public/js/jquery-1.11.1.min.js"></script>
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
                    <input type="image" src="/spark_wpv2/friends/library/Public/images/search.png" name="img">
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
                    <span><img src="/spark_wpv2/friends/library/Public/images/defaultheader.jpg"/></span>
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
            <div class="classify-title"><a style="cursor: pointer;color:#000;text-decoration: none" href="<?php echo U(share);?>">物品管理</a>>物品库</div>
        </div>
        <div class="view">
            <div class="view-body">
                <div class="view-body-left">
                    <div class="com_type">物品分类</div>
                    <ul class="com_ul">
                        <li>材料</li>
                        <li>设备</li>
                        <li>家具</li>
                        <li>图书</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main-body">
            <div>
                <div class="main-body-left">
                    <div class="main-ll">
                        <div class="main-title">
                            <!-- <div class="checkbox">
                                <?php if ($flag==1): ?>
                                <input id="check1" type="checkbox" style="cursor: pointer"/><label for="check1">仅显示可借书籍</label>
                                <?php elseif ($flag==0): ?>
                                <input id="check2" type="checkbox" checked style="cursor: pointer"/><label for="check2">仅显示可借书籍</label>
                                <?php endif ?>
                            </div> -->
                            <!-- <div class="main-search">
                                <form name="search" action="<?php echo U(search);?>" method="post">
                                    <input  class="search1" name="search" type="text" placeholder="书名/分类？" />
                                    <div class="search-b">
                                        <input type="image" src="/spark_wpv2/friends/library/Public/images/search.png" name="img">
                                    </div>
                                </form>
                            </div> -->
                        </div>
                        <div class="main-body-ul">
                            <ul>
                                <?php if(is_array($component)): foreach($component as $key=>$item): ?><li style="cursor: pointer">
                                        <div class="main-body-li">
                                            <span class="name"><?php echo $item['name']?></span>
                                            <img  onclick="document.location='<?php echo U(componentInfo,array('id'=>$item['id']));?>'"  src="<?php echo ($item['img']); ?>"/>
                                            <span class="usermessage keeper">库存:<?php echo ($item['number_left']); ?></span>
                                            <i data-role="minus" style="width:10px;cursor:pointer;">-</i>
                                            <input data-role="number" style="margin-top:20px; width:30px;" value="1" />
                                            <i data-role="plus">+</i>
                                            <input class="exit" style="display: none" type="text" value=<?php echo ($item['number_left']); ?> /></br>
                                            <input class="attention" style="background-color: #5e99b3" type="submit" name="attention" value="借用"/>
                                            <input class="exit" style="display: none" type="text" name="bookid" value=<?php echo ($item['id']); ?> />
                                        </div>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                            <span class="fenpage"><?php echo ($page); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="footer">
    <div class="pass">
        <img src="/spark_wpv2/friends/library/Public/images/qrmakerway.jpg"/><span>扫描关注makerway微信公众号</span>
    </div>
    <span>联系邮箱：maker_way@163.com</span>
    <div class="footer-img">
        <img src="/spark_wpv2/friends/library/Public/images/makerway.png"/>
    </div>
</div> -->
</div>
</body>
<script type="text/javascript" src="/spark_wpv2/friends/library/Public/js/share.js"></script>
<!-- <script type="text/javascript" src="/spark_wpv2/friends/library/Public/js/guest.js"></script> -->
<!-- <script type="text/javascript" src="/spark_wpv2/friends/library/Public/js/labelsearch.js"></script> -->
<!-- <script type="text/javascript" src="/spark_wpv2/friends/library/Public/js/label.js"></script> -->
</html>