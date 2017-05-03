<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<title>个人中心</title>
<script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="/passon/Public/css/Book/bookShare.css"/>
<body>
<div class="content">
    <?php if ($count==0): ?>
    <div class="no-share">
        <div class="title">
            <span class="title-share">我的共享书籍（0）</span>
        </div>
        <div class="no-book-list">
            <img src="/passon/Public/images/Book/false.png"/>
            <div>下一次上传书籍加入漂流计划</div>
            <div>看看你的共享率能超越多少用户！</div>
        </div>
    </div>
    <?php else : ?>
    <div class="have-share">
        <div class="title">
            <span class="title-share">我的共享书籍-漂流中（<?php echo ($count); ?>）</span>
            <span class="long-touch">点击书籍进行收回~</span>
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
                        <div class="super-share">已收回</div>
                    </li><?php endforeach; endif; ?>
            </ul>
            <div class="tan-natant"></div>
            <div class="tan-message">
                <div class="close">x</div>
                <div class="tan-content">
                    <div>本书已转入你的私人书籍中</div>
                    <div>且停止漂流，他人不再可借阅</div>
                </div>
                <div class="reset">点击撤回本次收回操作</div>
            </div>
        </div>
    </div>
    <?php endif ?>
</div>
</body>
<script type="text/javascript" src="/passon/Public/js/Book/bookShare.js"></script>
</html>