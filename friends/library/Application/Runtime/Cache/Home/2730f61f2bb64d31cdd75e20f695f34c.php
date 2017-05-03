<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>帮助</title>
    <link rel="stylesheet" type="text/css" href="/makerway/Public/css/help.css">
    <link rel="stylesheet" type="text/css" href="/makerway/Public/css/header.css">
    <link rel="stylesheet" type="text/css" href="/makerway/Public/css/footer.css">
    <script type="text/javascript" src="/makerway/Public/js/jquery-1.11.1.min.js"></script>
</head>
<body>
<div class="content">
    <div class="head">
    <div class="title">
        <div class="title-left">
            <span class="title-m"><a href="<?php echo U(index);?>">MakerWay</a></span>
            <span class="title-help"><a href="<?php echo U(help);?>">帮助</a></span>
            <span class="title-main"><a href="<?php echo U(contribute);?>">书籍上传</a></span>
            <span class="title-share"><a href="<?php echo U(share);?>">共享库</a></span>
        </div>
        <div class="div-search">
            <form name="search" action="<?php echo U(search);?>" method="post">
                <input  class="search" name="search" type="text" placeholder="书名/分类？" />
                <div class="search-a">
                    <input type="image" src="/makerway/Public/images/search.png" name="img">
                </div>
            </form>
            <!--<span>热门搜索：</span>-->
            <!--<span class="detail">-->
            <!--<span><a>数据库系统概念</a></span>-->
            <!--<span><a>CSS 3实战</a></span>-->
            <!--<span><a>操作系统概念</a></span>-->
            <!--</span>-->
        </div>
        <?php if($user['username'] == '') :?>
        <div class="username-list">
                <ul>
                    <li class="register"><a href="<?php echo U(register);?>">注册</a></li>
                    <li class="login"><a href="<?php echo U(login);?>">登录</a></li>
                </ul>
        </div>
        <?php else :?>
        <div class="username-c">
            <ul>
                <li>
                    <?php if($user['image'] == '') :?>
                    <span><img src="/makerway/Public/images/defaultheader.jpg"/></span>
                    <?php else :?>
                    <span><img src="<?php echo ($user['image']); ?>"/></span>
                    <?php endif?>
                    <span class="username-c-username"><?php echo ($user['username']); ?></span>
                    <ul>
                        <li><a href="<?php echo U(person);?>">我的主页</a></li>
                        <li>消息</li>
                        <li><a href="<?php echo U(message);?>">账号设置</a></li>
                        <li><a href="<?php echo U(logout);?>">退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php endif ?>
    </div>
</div>
    <div class="main">
        <div class="classify">
            <div class="classify-title"><a style="cursor: pointer;color:#000;text-decoration: none" href="<?php echo U(index);?>">MakerWay</a>>帮助</div>
        </div>
        <div class="main-right">
            <div class="subnavigate">
                <div class="message"  style="display: block;">
                    <ul>
                        <li class="activecolor">常见问题</li>
                        <li>关于我们</li>
                        <li>成长值规则</li>
                        </ul>
                    <div class="second-navigate">
                        <div class="question">
                            <div class="second-body">
                                <div class="question-answer">
                                    <div class="question-left">1</div>
                                    <div class="question-right">
                                        Q:我有一本读过的书觉得很赞，如何共享给大家？<br/>
                                        A:【网页端】登录Makerway，在首页进入“书籍上传”，输入书籍封底的ISBN码，按照提示文成上传，等待它的下一位读者，（您也可以选择不加入“漂流计划”，书籍将会上传到您的“私人书架”，管理您的知识体系。）<br/>
                                        【微信端】进入公众号——makerway，点击“上传”，扫一扫书籍封底的ISBN码，完成上传。
                                    </div>
                                </div>
                                <div class="question-answer">
                                    <div class="question-left">2</div>
                                    <div class="question-right">
                                        Q:如何借阅Makerway上的图书？<br/>
                                        A:【网页端】登录Makerway，进入“共享库”，搜索挑选你想阅读的书籍，根据提示信息联系该书籍的当前持有者，线下取书后，进入“个人中心-我的释放-借阅书籍”，点击“已借阅”<br/>
                                        【微信端】进入公众号——makerway，点击“借阅”，扫一扫书籍封底的ISBN码，完成阅读。
                                    </div>
                                </div>
                                <div class="question-answer">
                                    <div class="question-left">3</div>
                                    <div class="question-right">
                                        Q:我共享的书籍可以回收吗？<br/>
                                        A:可以。当书籍状态为可借阅时（漂流中），如果您需要，可以将其收回。
                                    </div>
                                </div>
                                <div class="question-answer">
                                    <div class="question-left">4</div>
                                    <div class="question-right">
                                        Q:借阅书籍有什么要求？<br/>
                                        A:爱护书籍时每一位书友的信条，请在获取知识的同时爱护它！<br/>
                                        如果在借阅过程中不慎对书籍造成了损坏，请联系我们妥善处理。
                                    </div>
                                </div>
                                <div class="question-answer">
                                    <div class="question-left">5</div>
                                    <div class="question-right">
                                        Q:在哪里可以进行反馈？<br/>
                                        A:【微信端】进入公众号——makerway，直接发送意见即可，我们期待您每一个宝贵的意见。
                                    </div>
                                </div>
                                <div class="qr">
                                    <img src="/makerway/Public/images/qrmakerway.jpg"/><br/>
                                    <span>扫面关注makerway微信公众号</span>
                                </div>
                            </div>
                        </div>
                        <div class="about-us">
                            <div class="second-body">
                                <div class="about-us-first">欢迎你来！</div>
                                <div>Maker Way是属于北邮人的一个线上图书馆，致力于让北邮人通过书籍共享这一形式来“一起分享智慧”！</div>
                                <div>在这里，每个人都是丰富资源的受益者，同时也是可爱的分享者。你可以通过上传分享自己的书籍，让它漂流下去；借阅书籍后留下你的阅读感悟，与更多书友进行交流。总之，晒书单、晒笔记、晒感悟，有无限可能。</div>
                                <div>在这里，你可以随时借阅北邮人所需的任意教材，那都是嫡系师兄师姐们传承下来的，还带着热气腾腾的笔记呢！</div>
                                <div>在这里，你将拥有管理自己书籍的能力，再也不会只买书不看书！</div>
                                <div>在这里，你将拥有掌握个人阅读情况的能力，成长之路尽收眼底！</div>
                                <div>在这里，你将遇见你的伯牙、子期，友谊的小船，不翻~</div>
                            </div>
                        </div>
                        <div class="rules">
                            <div class="second-body">
                                <div class="rules-body">
                                    <div class="rules-title">——成长值价值——</div>
                                    <div>您通过各种操作获取的积分可以用于提升您的成长等级，越高的成长等级可以开启越多的特权。</div>
                                    <div>定期还会推出限时特权等你哦！</div>
                                </div>
                                <div class="rules-body rule-body-details">
                                    <div class="rules-title">——成长值计算——</div>
                                    <div>如何获取成长值</div>
                                    <div><span class="rules-left">注册成功</span><span class="rules-right">+2分</span></div>
                                    <div><span class="rules-left">上传私人书籍</span><span class="rules-right">+5分</span></div>
                                    <div><span class="rules-left">上传共享书籍</span><span class="rules-right">+10分</span></div>
                                    <div><span class="rules-left">共享书籍被借阅</span><span class="rules-right">+2分</span></div>
                                    <div><span class="rules-left">借书</span><span class="rules-right">+2分</span></div>
                                    <div><span class="rules-left">发布笔记</span><span class="rules-right">+5分</span></div>
                                    <div><span class="rules-left">发布优质笔记（笔记被推送到共享库首页）</span><span class="rules-right">+10分</span></div>
                                    <div><span class="rules-left">赞同</span><span class="rules-right">+1分</span></div>
                                    <div><span class="rules-left">评论</span><span class="rules-right">+1分</span></div>
                                    <div><span class="rules-left">分享</span><span class="rules-right">+1分</span></div>
                                    <div>成长值等级规则</div>
                                    <div><img class="rules-left" src="/makerway/Public/images/flower.png"/><span class="rules-right">2分</span></div>
                                    <div><img class="rules-left" src="/makerway/Public/images/flower.png"/><img class="rules-left" src="/makerway/Public/images/flower.png"/><span class="rules-right">50分</span></div>
                                    <div><img class="rules-left" src="/makerway/Public/images/flower.png"/><img class="rules-left" src="/makerway/Public/images/flower.png"/><img class="rules-left" src="/makerway/Public/images/flower.png"/><span class="rules-right">150分</span></div>
                                    <div><img class="rules-left" src="/makerway/Public/images/tree.png"/><span class="rules-right">250分</span></div>
                                    <div><img class="rules-left" src="/makerway/Public/images/tree.png"/><img class="rules-left" src="/makerway/Public/images/tree.png"/><span class="rules-right">500分</span></div>
                                    <div><img class="rules-left" src="/makerway/Public/images/tree.png"/><img class="rules-left" src="/makerway/Public/images/tree.png"/><img class="rules-left" src="/makerway/Public/images/tree.png"/><span class="rules-right">1000分</span></div>
                                    <div><img class="rules-left" src="/makerway/Public/images/apple.png"/><span class="rules-right">2000分</span></div>
                                    <div><img class="rules-left" src="/makerway/Public/images/apple.png"/><img class="rules-left" src="/makerway/Public/images/apple.png"/><span class="rules-right">5000分</span></div>
                                    <div><img class="rules-left" src="/makerway/Public/images/apple.png"/><img class="rules-left" src="/makerway/Public/images/apple.png"/><img class="rules-left" src="/makerway/Public/images/apple.png"/><span class="rules-right">10000分</span></div>
                                </div>
                                <div class="rules-body">
                                    <div class="rules-title">——成长值补充说明——</div>
                                    <div>成长值是为了更好的记录每一位Mkakerway人的个人成长与进步，我们不允许刷分灌水等行为，让我们共同成长，一起分享智慧。</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
    <div class="pass">
        <img src="/makerway/Public/images/qrmakerway.jpg"/><span>扫面关注makerway微信公众号</span>
    </div>
    <span>联系邮箱：maker_way@163.com</span>
    <div class="footer-img">
        <img src="/makerway/Public/images/makerway.png"/>
    </div>
</div>
</div>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-68503572-4', 'auto');
    ga('send', 'pageview');

</script>
</body>
<script type="text/javascript" src="/makerway/Public/js/help.js"></script>
</html>