<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<title>个人中心</title>
<script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="/passon/Public/css/Book/bookAlready.css"/>
<body>
<div class="content">
    <div class="title">
        <span>我的已读书籍(<?php echo ($count); ?>)</span>
    </div>
    <div class="book-list">
        <ul>
            <?php if(is_array($booklist)): foreach($booklist as $key=>$item): ?><li class="supernatant-share">
                    <div>
                        <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                    </div>
                    <div class="title-font"><?php echo ($item['bookinfo']['title']); ?></div>
                </li><?php endforeach; endif; ?>
        </ul>
    </div>
</div>
</body>
</html>