<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>账号设置</title>
    <link rel="stylesheet" type="text/css" href="/library/Public/css/message.css">
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
                <div class="classify-title"><a style="cursor: pointer;color:#000;text-decoration: none" href="<?php echo U(share);?>">物品管理</a>>账号设置</div>
            </div>
            <div class="main-right">
                <div class="subnavigate">
                    <div class="message"  style="display: block;">
                        <ul>
                            <li class="activecolor">联系方式</li>
                            <li>密码安全</li>
                            <li>修改头像</li>
                        </ul>
                        <div class="second-navigate">
                            <div style="display: block;">
                                <div class="messageform2">
                                    <div class="message-user">
                                        <p class="tan-message-size">联系人： <?php echo ($user['username']); ?></p>
                                        <p class="tan-message-size">学号： <?php echo ($user['number']); ?></p>
                                        <p class="tan-message-size">手机号： <?php echo ($user['phone']); ?></p>
                                        <p class="tan-message-size">地址： <?php echo ($user['address']); ?></p>
                                        <input class="change-message1" type="button" value="修改"/>
                                        <input class="submit" type="submit" style="display:none;" value="<?php echo ($user['id']); ?>"/>
                                    </div>
                                    <div class="form">
                                        <!-- <input type="text" name="username" placeholder="用户名"/> -->
                                        <input type="text" name="phone" placeholder="手机号"/>
                                        <div class="select">
                                            <select name="select">
                                                <option value="北邮本部">北邮本部</option>
                                                <option value="北邮沙河">北邮沙河</option>
                                                <option value="北邮宏福">北邮宏福</option>
                                            </select>
                                            <input type="text" name="building" placeholder="楼">
                                            <input type="text" name="room" placeholder="室">
                                        </div>
                                        <input class="submit" type="submit" value="修改"/>
                                    </div>
                                </div>
                            </div>
                            <div style="display: none;">
                                <form class="messageform" action="<?php echo U(usemessage);?>" method="post" onsubmit="return check()">
                                    <div class="label-n"><label>原密码：&nbsp;&nbsp;&nbsp;&nbsp;</label><input class="username-in" name="password"/></div><br/>
                                    <div class="label-n"><label>新密码：&nbsp;&nbsp;&nbsp;&nbsp;</label><input class="username-in" name="rpassword"/></div><br/>
                                    <input class="savebtn savemessage" type="submit" value="保存"/>
                                </form>
                            </div>
                            <div style="display: none;">
                                <form class="messageform1" action="<?php echo U(imgmessage);?>" method="post" onsubmit="return check2()">
                                    <div class="label-m label-float">
                                        <img class="file-img" src="" />
                                        <input class="changeimg" name="changeimg" style="display: none" value=""/>
                                    </div>
                                    <div class="label-m marginleft">
                                        <div class="choose-img">
                                            <img class="img-result" src="">
                                            <input class="user_pic file" type="file" name="user_pic" value="选择图片" />
                                            <input id="public" value="/library/Public" style="display: none">
                                        </div>
                                    </div><br/>
                                    <div class="label-m marginleft">
                                        <label>说明：</label><br/>
                                        <label>1、支持JPG、JPEG、GIF、PNG文件格式。</label><br/>
                                        <label>2、GIF帧数过高会造成您电脑运行缓慢。</label><br/>
                                    </div><br/>
                                    <!--<div class="span-s">生&nbsp;&nbsp;&nbsp;&nbsp;日：<input type="radio"/>保密 <input type="radio"/>男 <input type="radio"/>女</div><br/>-->
                                    <input class="savebtn savemessage" type="submit" value="保存资料"/>
                                </form>
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
<script type="text/javascript" src="/library/Public/js/message.js"></script>
</html>