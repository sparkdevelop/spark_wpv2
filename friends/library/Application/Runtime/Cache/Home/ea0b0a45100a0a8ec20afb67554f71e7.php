<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
    <title>个人中心</title>
    <script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/Book/personalCenter.css"/>
</head>
<body>
    <div class="content">
        <div class="liststyle userinfo">
            <!--<span class="percent">-->
                <!--<span class="percent-number">15</span>-->
                <!--<sub>%</sub>-->
            <!--</span>-->
            <?php if ($username): ?>
            <img src="/passon/Public/images/basketball.jpg"/>
            <div class="username"><?php echo ($username); ?></div>
            <?php else : ?>
            <img src="/passon/Public/images/basketball.jpg"/>
            <div class="username" onclick="window.location.href='<?php echo U(login,array('openid'=>$openid,'flag'=>0));?>'">登录</div>
            <?php endif ?>
        </div>
        <div class="main">
            <div class="mybookroom">
                <div class="room-title">
                    <img/>
                    <span>我的书房</span>
                </div>
                <div class="room-body">
                    <ul>
                        <li onclick="document.location='<?php echo U(personalBook);?>'">
                            <div class="book-number"><?php echo ($countPersonal); ?></div>
                            <div>私人书籍</div>
                        </li>
                        <li onclick="document.location='<?php echo U(bookShare);?>'">
                            <div class="book-number"><?php echo ($countShare); ?></div>
                            <div>共享书籍</div>
                        </li>
                        <li class="book-last" onclick="document.location='<?php echo U(bookBorrow);?>'">
                            <?php if ($waitcount!=0): ?>
                            <div class="borrow-number"><?php echo ($waitcount); ?></div>
                            <?php endif ?>
                            <div class="book-number"><?php echo ($countBorrow); ?></div>
                            <div>借阅书籍</div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="book-reading">
                <div class="room-title">
                    <img/>
                    <span>阅读情况</span>
                </div>
                <div class="reading-body">
                    <ul>
                        <?php if ($countReading==0): ?>
                        <li>
                            <?php else : ?>
                        <li onclick="document.location='<?php echo U(bookReading);?>'">
                            <?php endif ?>
                            <div class="reading">
                                <div class="reading-number"><?php echo ($countReading); ?></div>
                                <div class="reading-status">在读</div>
                            </div>
                            <div class="book-title">
                                <?php if ($countReading==0): ?>
                                <div>没有书</div>
                                <?php else : ?>
                                <div><?php echo ($booklistReading[0]['bookinfo']['title']); ?></div>
                                <div><?php echo ($booklistReading[1]['bookinfo']['title']); ?></div>
                                <div><?php echo ($booklistReading[2]['bookinfo']['title']); ?></div>
                                <?php endif ?>
                            </div>
                            <div class="book-img">
                                <?php if ($countReading==0): ?>
                                <img src="/passon/Public/images/Book/jiong.png"/>
                                <?php else : ?>
                                <img src="<?php echo ($booklistReading[0]['bookinfo']['image']); ?>"/>
                                <?php endif ?>
                            </div>
                        </li>
                        <?php if ($countatten==0): ?>
                        <li>
                        <?php else : ?>
                        <li onclick="document.location='<?php echo U(bookWant);?>'">
                        <?php endif ?>
                        <div class="reading">
                                <div class="reading-number"><?php echo ($countatten); ?></div>
                                <div class="reading-status">想读</div>
                            </div>
                            <div class="book-title">
                                <?php if ($countatten==0): ?>
                                <div>没有书</div>
                                <?php else : ?>
                                <div><?php echo ($booklistWant[0]['bookinfo']['title']); ?></div>
                                <div><?php echo ($booklistWant[1]['bookinfo']['title']); ?></div>
                                <div><?php echo ($booklistWant[2]['bookinfo']['title']); ?></div>
                                <?php endif ?>
                            </div>
                            <div class="book-img">
                                <?php if ($countatten==0): ?>
                                <img src="/passon/Public/images/Book/jiong.png"/>
                                <?php else : ?>
                                <img src="<?php echo ($booklistWant[0]['bookinfo']['image']); ?>"/>
                                <?php endif ?>
                            </div>
                        </li>
                        <?php if ($countAlready==0): ?>
                        <li>
                            <?php else : ?>
                        <li onclick="document.location='<?php echo U(bookAlready);?>'">
                            <?php endif ?>
                            <div class="reading">
                                <div class="reading-number"><?php echo ($countAlready); ?></div>
                                <div class="reading-status">已读</div>
                            </div>
                            <div class="book-title">
                                <?php if ($countAlready==0): ?>
                                <div>没有书</div>
                                <?php else : ?>
                                <div><?php echo ($booklistAlready[0]['bookinfo']['title']); ?></div>
                                <div><?php echo ($booklistAlready[1]['bookinfo']['title']); ?></div>
                                <div><?php echo ($booklistAlready[2]['bookinfo']['title']); ?></div>
                                <?php endif ?>
                            </div>
                            <div class="book-img">
                                <?php if ($countAlready==0): ?>
                                <img src="/passon/Public/images/Book/jiong.png"/>
                                <?php else : ?>
                                <img src="<?php echo ($booklistAlready[0]['bookinfo']['image']); ?>"/>
                                <?php endif ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>