<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
    <title>上传成功</title>
    <script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/Book/continueUpload.css"/>
</head>
<body>
    <div class="content">
        <div class="upload-message">
            <img src="<?php echo ($bookinforesult['image']); ?>" />
            <div><?php echo ($message); ?></div>
            <div class="username">----&nbsp;&nbsp;<?php echo ($username); ?></div>
        </div>
        <?php if ($flag==0): ?>
        <div class="upload-info">
            <span>本书已经加入漂流计划</span>
            <span>你的藏书量已经达到<?php echo ($personalCount); ?>本</span>
            <span>共享过<?php echo ($shareCount); ?>本书</span>
            <!--<span>共享率已超过15%的用户</span>-->
        </div>
        <?php else : ?>
        <div class="upload-info">
            <span>本书已成功添加到你的书房</span>
            <span>你的藏书量已经达到<?php echo ($personalCount); ?>本</span>
            <span>下次加入漂流计划</span>
            <!--<span>看看你的共享率超越了多少人！</span>-->
        </div>
        <?php endif ?>
    </div>
    <div class="footer">
        <input type="button" value="继续上传">
    </div>
</body>
</html>