<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
    <title>个人中心</title>
    <script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/Book/bookBorrow.css"/>
</head>
<body>
    <div class="content">
        <div class="have-borrow">
            <div class="warning-title">
                <span>待取书籍</span>
                <span class="number"><?php echo ($waitcount); ?></span>
            </div>
            <div class="toTake">
                <form method="post" action="<?php echo U(formHandle);?>">
                    <ul>
                        <?php if(is_array($waitlist)): foreach($waitlist as $key=>$item): ?><li>
                                <input class="radio" type="checkbox" name="book_id[]" value="<?php echo ($item['book_id']); ?>"/>
                                <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                <span class="title"><?php echo ($item['bookinfo']['title']); ?></span>
                                <span class="author"><?php echo ($item['bookinfo']['author']); ?></span>
                                <span class="express"><?php echo ($item['bookinfo']['publisher']); ?></span>
                            </li><?php endforeach; endif; ?>
                    </ul>
                    <?php if ($waitcount!=0): ?>
                    <div class="choseall">
                        <input type="checkbox" name="allcheck" id="allcheck"/>
                        <label for="allcheck">全选</label>
                        <input class="button" type="submit" value="确认借阅"/>
                    </div>
                    <?php endif ?>
                </form>
            </div>
            <div class="have-read">
                <div class="warning-title">
                    <span>保管书籍</span>
                    <span>(<?php echo ($count); ?>)</span>
                </div>
                <?php if ($count==0): ?>
                <div class="no-book-list">
                    <img src="/passon/Public/images/Book/false.png"/>
                    <div>快去网页端发现更多好书吧！</div>
                </div>
                <?php else : ?>
                <div class="book-list">
                    <ul>
                        <?php if(is_array($booklist)): foreach($booklist as $key=>$item): ?><li>
                                <div>
                                    <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                </div>
                                <div class="title-font"><?php echo ($item['bookinfo']['title']); ?></div>
                            </li><?php endforeach; endif; ?>
                    </ul>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</body>
<script src="/passon/Public/js/Book/bookBorrow.js" type="text/javascript"></script>
</html>