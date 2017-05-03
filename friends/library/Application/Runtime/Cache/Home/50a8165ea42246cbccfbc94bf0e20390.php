<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
    <title>请先登录</title>
    <script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/Book/register.css"/>
</head>
<body>
    <div class="content">
        <div class="title">MakerWay</div>
        <form class="form" action="<?php echo U(register_handle,array('openid'=>$openid,'flag'=>$flag));?>" method="post" onsubmit="return check()">
            <input type="text" name="username" placeholder="用户名"/><img class="show" src="/passon/Public/images/Book/show.png">
            <input class="password" type="text" name="password" placeholder="密码（长度为6到16位）"/>
            <input type="text" name="studentnumber" placeholder="学号"/>
            <input type="text" name="phone" placeholder="手机号"/>
            <input type="text" name="address" placeholder="地址"/>
            <!--<input type="text" name="sex" placeholder="性别"/>-->
            <select type="text" name="sex">
                <option selected="selected">性别</option>
                <option>男</option>
                <option>女</option>
                <option>不告诉你</option>
            </select>
            <input class="submit" type="submit" value="注&nbsp;&nbsp;&nbsp;&nbsp;册"/>
        </form>
        <div class="footer">
            <span>已在网页端注册过？去<a href="<?php echo U(login,array('openid'=>$openid,'flag'=>$flag));?>">登录</a></span>
        </div>
    </div>
</body>
<script src="/passon/Public/js/Book/register.js" type="text/javascript"></script>
</html>