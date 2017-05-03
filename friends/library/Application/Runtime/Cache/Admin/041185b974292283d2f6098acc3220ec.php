<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" charset="utf-8" content="text/css">
	<title>后台</title>
	<link rel="stylesheet" type="text/css" href="/library/Public/css/Admin/header.css">
	<link rel="stylesheet" type="text/css" href="/library/Public/css/Admin/login.css">
	<script type="text/javascript" src="/library/Public/js/jquery-1.11.1.min.js"></script>
</head>
<body>
	<div class="header">
    <div class="header-title">
        <span class="header-title-m">
            <span class="header-big">M</span>
            <span class="header-title-top">AKERWAY</span>
            <span class="header-title-bottom">一起分享智慧</span>
        </span>
    </div>
    <div class="header-ul">
        <ul>
            <li>首页</li>
            <li>用户管理</li>
            <li>书籍管理</li>
            <li>统计分析
                <ul class="sta">
                    <li>用户分析</li>
                    <li>书籍分析</li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="header-username">
        <img src="/library/Public/images/basketball.jpg"/>
        <ul>
            <li>管理员</li>
            <li>
                <a href="<?php echo U(logout);?>">注销</a>
            </li>
        </ul>
    </div>
 </div>
	<div class="content">
		<div class="title">管&nbsp;理&nbsp;员&nbsp;登&nbsp;录</div>
		<div>
			<form class="form" name="form"  action="<?php echo U(loginCheck);?>" method="post" onsubmit="return check()">
				<label class="font-size">用户名：</label>
				<input class="user input" name="adminname" type="user" placeholder="用户名" /><br/>
				<label class="font-size">密&nbsp;&nbsp;&nbsp;码：</label>
				<input class="passwd input" name="password" type="password" placeholder="密码" /><br/>
				<input class="btn" name="submit" type="submit" value="登录"/>
			</form>
		</div>
	</div>
</body>
<script type="text/javascript" src="/library/Public/js/Admin/login.js"></script>
</html>