<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<script type="text/javascript" src="/library/Public/js/jquery-1.11.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/library/Public/css/login.css">
</head>
<body>
<div class="header">
	<a></a>
</div>
<div class="main">
	<div class="main-m">
		<div class="title">登录</div>
		<div>
			<form class="form" name="form"  action="<?php echo U(login_handle);?>" method="post" onsubmit="return check()">
				<input type="text" name="username" placeholder="用户名"/>
				<input type="password" name="password" placeholder="密码"/>
				<input class="submit" name="submit" type="submit" value="登录"/>
				<div class="footer">
					<span class="register">没有账号？去<a href="<?php echo U(register);?>">注册</a></span>
					<span class="forget"><a href="<?php echo U(forget);?>">忘记密码</a></span>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
<script type="text/javascript" src="/library/Public/js/login.js"></script>
</html>