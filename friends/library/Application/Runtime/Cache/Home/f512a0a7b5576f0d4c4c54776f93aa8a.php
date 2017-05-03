<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
<title>个人中心</title>
<script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="/passon/Public/css/Book/personalBook.css"/>
<body>
    <div class="content">
        <div class="title">
            <span>我的私人书籍（<?php echo ($count); ?>）</span>
            <span class="long-touch">长按书籍试试~~</span>
        </div>
        <div class="book-list">
            <ul>
                <?php if(is_array($booklist)): foreach($booklist as $key=>$item): ?><li class="supernatant-share">
                        <div>
                            <img src="<?php echo ($item['image']); ?>"/>
                        </div>
                        <div><?php echo ($item['title']); ?></div>
                        <div class="supernatant"></div>
                        <div class="super-share">共享</div>
                    </li><?php endforeach; endif; ?>
            </ul>
            <div class="tan-natant"></div>
            <div class="tan-message">
                <div class="close">x</div>
                <div class="tan-content">
                    <div>本书已加入漂流计划</div>
                    <div>你已共享过3本书</div>
                    <div>共享率已超越15%的用户</div>
                </div>
                <div class="reset">点击撤回本次共享操作</div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="/passon/Public/js/Book/personalBook.js"></script>
</html>