<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
    <title>修改密码</title>
    <script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/Book/forget.css"/>
</head>
<body>
<div class="content">
    <div class="title">MakerWay</div>
    <form class="form" action="<?php echo U(forget_handle,array('openid'=>$openid,'flag'=>$flag));?>" method="post" onsubmit="return check()">
        <input type="text" name="username" placeholder="用户名"/>
        <input type="text" name="studentnumber" placeholder="学号"/>
        <input type="text" name="phone" placeholder="手机号"/><img class="show" src="/passon/Public/images/Book/show.png">
        <input class="password" type="password" name="password" placeholder="新密码（长度为6到16位）"/>
        <input class="submit" type="submit" value="修&nbsp;&nbsp;&nbsp;&nbsp;改"/>
    </form>
</div>
</body>
<script src="/passon/Public/js/Book/forget.js" type="text/javascript"></script>
</html>