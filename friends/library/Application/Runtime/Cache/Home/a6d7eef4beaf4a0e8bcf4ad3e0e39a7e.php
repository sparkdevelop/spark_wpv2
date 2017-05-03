<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
    <title>请先登录</title>
    <script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/Book/login.css"/>
</head>
<body>
<div class="content">
    <div class="title">MakerWay</div>
    <form class="form" action="<?php echo U(login_handle,array('openid'=>$openid,'flag'=>$flag));?>" method="post" onsubmit="return check()">
        <input type="text" name="username" placeholder="用户名"/>
        <input type="password" name="password" placeholder="密码"/>
        <?php if($flag == 2): ?>
        <input class="submit" type="button" value="登&nbsp;&nbsp;&nbsp;&nbsp;录"/>
        <input style="display: none" value="<?php echo ($openid); ?>"/>
        <input style="display: none" value="<?php echo ($flag); ?>"/>
        <?php else:?>
        <input class="submit" type="submit" value="登&nbsp;&nbsp;&nbsp;&nbsp;录"/>
        <?php endif?>
    </form>
    <div class="footer">
        <span class="register">没有账号？去<a href="<?php echo U(register,array('openid'=>$openid,'flag'=>$flag));?>">注册</a></span>
        <span class="forget"><a href="<?php echo U(forget,array('openid'=>$openid,'flag'=>$flag));?>">忘记密码</a></span>
    </div>
</div>
</body>
<script src="/passon/Public/js/Book/login.js" type="text/javascript"></script>
</html>