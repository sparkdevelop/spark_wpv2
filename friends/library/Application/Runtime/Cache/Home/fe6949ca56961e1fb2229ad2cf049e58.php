<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<title>个人中心</title>
<script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="/passon/Public/css/Book/bookReading.css"/>
<body>
<div class="content">
    <div class="title">
        <span>我的在读书籍(<?php echo ($count); ?>)</span>
        <span class="long-touch">点击书籍完成阅读~</span>
    </div>
    <div class="book-list">
        <ul>
            <?php if(is_array($booklist)): foreach($booklist as $key=>$item): ?><li>
                    <div class="supernatant-share">
                        <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                    </div>
                    <input style="display: none" value="<?php echo ($item['book_id']); ?>"/>
                    <div class="title-font"><?php echo ($item['bookinfo']['title']); ?></div>
                    <div class="supernatant"></div>
                    <div class="super-share">已完成</div>
                </li><?php endforeach; endif; ?>
        </ul>
        <div class="tan-natant"></div>
        <div class="tan-message">
            <div class="close">x</div>
            <div class="tan-content">
                <div>恭喜你阅读完此书！</div>
                <div>此书已被加入到已读书籍中！</div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="/passon/Public/js/Book/bookReading.js"></script>
</html>