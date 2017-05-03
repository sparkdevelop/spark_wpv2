<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<title>PASSON统计图查看</title>
<!-- <script type="text/javascript" src="http://libs.useso.com/js/jquery/1.7.2/jquery.min.js"></script> -->

</head>
<style type="text/css">
	.visit{
		text-align: center;
	}
	.visit table,td,th{
		margin:10px auto;
		border: 1px solid black;
		border-collapse:collapse;
	}

</style>
<body>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
	<div><a href="<?php echo U(share);?>">返回共享库</a></div>
    <div id="main" style="height:500px;"></div>
    <div>
	    <div class="visit">
	    	<table cellpadding="10" class="visitTable">
	    	<caption>用户浏览记录</caption>
	    		<tr>
	    			<th>用户</th>
	    			<th>网页</th>
	    			<th>日期</th>
	    			<th>时间</th>
	    			<th>IP</th>
	    		</tr>
	    		<?php foreach ($visitLog as $key => $value): ?>
	    			<tr>
	    				<td><?php echo ($value['username']); ?></td>
	    				<td><?php echo ($value['pagename']); ?></td>
	    				<td><?php echo ($value['date']); ?></td>
	    				<td><?php echo ($value['time']); ?></td>
	    				<td><?php echo ($value['ip']); ?></td>
		    		</tr>
	    		<?php endforeach ?>
	    	</table>
	    </div>
    </div>
    <!-- ECharts单文件引入 -->
<script type="text/javascript" src="/makerway/Public/echarts/build/dist/echarts.js"></script>
<script type="text/javascript">
	var d='<?php echo ($date); ?>';
	var pages=<?php echo ($pages); ?>;
    var nums=<?php echo ($pagesnum); ?>;
    var publicurl='/makerway/Public';
</script>
<script type="text/javascript" src="/makerway/Public/js/stastic.todayPages.js"></script>
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-68503572-4', 'auto');
	ga('send', 'pageview');

</script>
</body>
</html>