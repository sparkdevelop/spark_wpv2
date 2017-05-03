<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=no">
    <title>书籍信息</title>
    <script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/Book/upload.css"/>
</head>
<body>
<div class="content">
    <div class="bookinfo">
        <img src="<?php echo ($bookinfo['image']); ?>"/>
        <span class="title"><?php echo ($bookinfo['title']); ?></span>
        <span class="author"><?php echo ($bookinfo['author']); ?></span>
        <span class="express"><?php echo ($bookinfo['publisher']); ?></span>
    </div>
    <div class="book-form">
        <form method="post" action="<?php echo U(upload_handle,array('openid'=>$openid));?>" onsubmit="return check()">
            <div class="label-input">
                <span><label for="already" class="checked">已读</label><input id="already" name="reading" type="radio" checked="checked" value="3"/></span>
                <span class="doing"><label for="doing">在读</label><input id="doing" name="reading" type="radio" value="2"/></span>
                <span class="want"><label for="want">想读</label><input id="want" name="reading" type="radio" value="1"/></span>
                <div class="join-drift">
                    <span>加入漂流计划</span>
                    <span class="drift-message">i</span>
                    <span class="img"><img src="/passon/Public/images/Book/on.png"/></span>
                    <input class="on-off" name="on-off" style="display: none" value="1"/>
                </div>
                <div class="drift-message-more">共享出你不再需要的书，由下一位需要的它的人来认领，阅读完后继续漂流。<br/>这不仅仅是你分享的一本书，更是无限漂流下去的知识与智慧！</div>
            </div>
            <div class="message-border">
                <div>留言板</div>
                <input name="message"  class="leave-message" placeholder="对这本书的继承者们说点什么吧！"/>
            </div>
            <?php if(!$username):?>
            <div class="connect-message">
                <div>联系方式</div>
                <ul>
                    <?php if(is_array($userresult)): foreach($userresult as $key=>$item): ?><li>
                            <?php if ($item['id'] == $defaultid): ?>
                            <label class="checked"></label>
                            <input type="radio" name="connectMessage" value="<?php echo ($item['id']); ?>" checked="checked" />
                            <div class="m-color">[默认]</div>
                            <?php else: ?>
                            <label></label>
                            <input type="radio" name="connectMessage" value="<?php echo ($item['id']); ?>"/>
                            <div class="m-color">[一般]</div>
                            <?php endif ?>
                            <!--<input value="<?php echo ($item['id']); ?>" style="display: none"/>-->
                            <div>联系人：<?php echo ($item['username']); ?></div>
                            <div>手机号：<?php echo ($item['phone']); ?></div>
                            <div>地址：<?php echo ($item['address']); ?></div>
                        </li><?php endforeach; endif; ?>
                    <li>
                        <label></label>
                        <input type="radio" name="connectMessage" value="<?php echo ($zhenqing['id']); ?>"/>
                        <!--<input value="<?php echo ($zhenqing['id']); ?>" style="display: none"/>-->
                        <div class="t-color">[托管]</div>
                        <div>联系人：<?php echo ($zhenqing['username']); ?></div>
                        <div>手机号：<?php echo ($zhenqing['phone']); ?></div>
                        <div>地址：<?php echo ($zhenqing['address']); ?></div>
                        <div class="drift-warning">
                            <span class="drift-message">i</span>
                            <span class="drift-upload">上传书籍完成后可将书交由真情协办，在书籍未借出前帮你保管。</span>
                        </div>
                    </li>
                </ul>
                <?php if ($userresultcount != 2): ?>
                <div class="add-connect">添加联系方式&gt;</div>
                <?php endif ?>
            </div>
            <?php endif ?>
            <div class="footer">
                <input type="submit" value="确定上传">
            </div>
        </form>
    </div>
    <div class="tan-natant"></div>
    <div class="message-border tan-message">
        <div class="leave-message1">对这本书的继承者们说点什么吧！</div>
        <input name="message"  class="leave-message2"/>
        <input class="message-sure" type="button" value="确定"/>
    </div>
</div>
<div class="add-message">
    <input type="text" name="username" placeholder="用户名"/>
    <input type="text" name="phone" placeholder="手机号"/>
    <input type="text" name="address" placeholder="地址"/>
    <span>设为默认</span>
    <span class="imgadd"><img src="/passon/Public/images/Book/off.png"/></span>
    <input class="on-off-add" name="on-off-add" style="display: none" value="0"/>
    <input class="add-button" type="button" value="添加"/>
    <input style="display: none" value="<?php echo ($openid); ?>"/>
    <input style="display: none" value="<?php echo ($isbn); ?>"/>
</div>
</body>
<script src="/passon/Public/js/Book/upload.js" type="text/javascript"></script>
</html>