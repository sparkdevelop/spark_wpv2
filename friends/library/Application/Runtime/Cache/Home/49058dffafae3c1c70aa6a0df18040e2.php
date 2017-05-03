<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <script type="text/javascript" src="/library/Public/js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/library/Public/css/forget.css">
    <title>忘记密码</title>
</head>
<body>
<div class="header">
    <a></a>
</div>
<div class="main">
    <div class="main-m">
        <div class="title">
            <span>忘记密码</span>
        </div>
        <div>
            <form class="form" name="form"  action="<?php echo U(forget_handle);?>" method="post" onsubmit="return check()">
                <input type="text" name="username" placeholder="用户名"/>
                <input type="text" name="studentnumber" placeholder="学号"/>
                <input type="text" name="phone" placeholder="手机号"/><img class="show" src="/library/Public/images/Book/show.png">
                <input class="password" type="text" name="password" placeholder="新密码（长度为6到16位）"/>
                <input class="submit" type="submit" value="修&nbsp;&nbsp;&nbsp;&nbsp;改"/>
            </form>
        </div>
    </div>
</div>
<div class="footer"></div>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-68503572-4', 'auto');
    ga('send', 'pageview');

</script>
</body>
<script type="text/javascript" src="/library/Public/js/forget.js"></script>
</html>