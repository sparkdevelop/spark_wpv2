<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>个人中心</title>
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/person.css">
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/header.css">
    <script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
</head>
<body>
<div class="content">
    <div class="head">
    <div class="title">
        <div class="title-left">
            <span class="title-m">MakerWay</span>
            <span class="title-help"><a href="<?php echo U();?>">帮助</a></span>
            <span class="title-main"><a href="<?php echo U(contribute);?>">书籍上传</a></span>
            <span class="title-share"><a href="<?php echo U(share);?>">共享库</a></span>
        </div>
        <div class="div-search">
            <form name="search" action="<?php echo U(search);?>" method="post">
                <input  class="search" name="search" type="text" placeholder="书名/分类？" />
                <div class="search-a">
                    <input type="image" src="/passon/Public/images/search.png" name="img">
                </div>
            </form>
            <!--<span>热门搜索：</span>-->
            <!--<span class="detail">-->
            <!--<span><a>数据库系统概念</a></span>-->
            <!--<span><a>CSS 3实战</a></span>-->
            <!--<span><a>操作系统概念</a></span>-->
            <!--</span>-->
        </div>
        <div class="username-c">
            <ul>
                <li>
                    <span><img /></span>
                    <span class="username-c-username"><?php echo cookie('username')?></span>
                    <ul>
                        <li><a href="<?php echo U(person);?>">我的主页</a></li>
                        <li>消息</li>
                        <li><a href="<?php echo U(message);?>">账号设置</a></li>
                        <li><a href="<?php echo U(logout);?>">退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
    <div class="main">
        <div class="classify">
            <div class="classify-title"><a style="cursor: pointer;color:#000;text-decoration: none" href="<?php echo U(index);?>">MakerWay</a>>个人中心</div>
        </div>
        <div class="main-left">
            <div class="main-left-person">
                <div class="main-img">
                    <img class="user-images" src="<?php echo ($user['image']); ?>"/><br/>
                    <span class="username"><?php echo cookie('username')?></span>
                </div>
                <div class="username-details">
                    <img src="/passon/Public/images/flower.png"/>
                    <div>已在MakerWay上帮助过{}人</div>
                </div>
                <div class="main-ul">
                    <ul>
                        <li><?php echo ($booknum); ?><br/><br/>共享书籍</li>
                        <!--<li><?php echo ($integral); ?><br/><br/>积分</li>-->
                        <li><?php echo ($integral); ?><br/><br/>笔记</li>
                        <li><?php echo ($integral); ?><br/><br/>粉丝</li>
                    </ul>
                    <!--<div class="main-a"><a href="<?php echo U(contribute);?>"><input class="sharebtn" type="button" value="我要分享"/></a></div>-->
                </div>
            </div>
        </div>
        <div class="main-right">
            <div class="navigate">
                <ul>
                    <li>动态</li>
                    <li><a href="<?php echo U(personshare);?>">我的书房</a></li>
                    <li>笔记</li>
                    <li  class="border"><a href="<?php echo U(readingmessage);?>">阅读情况</a></li>
                    <li>好友</li>
                    <li>消息</li>
                </ul>
            </div>
            <div class="subnavigate">
                <div style="display: none">
                    <ul style="height: 10px;clear: both;"></ul>
                    <div class="my-pass">
                        <div class="book_life_experience_p">
                            <section id="cd-timeline" class="cd-container">
                                <div class="cd-timeline-block">
                                    <div class="cd-timeline-img cd-picture">
                                        <img src="/passon/Public/images/logo.png" alt="Picture">
                                    </div>

                                    <div class="cd-timeline-content">
                                        <h2>哪一本书</h2>
                                        <p>会被我青睐呢</p>
                                        <span class="cd-date">future</span>
                                    </div>
                                </div>
                                <?php if ($booklog): ?>
                                <?php foreach ($booklog as $item): ?>
                                <?php if ($item['status']==2): ?>
                                <div class="cd-timeline-block">
                                    <div class="cd-timeline-img cd-picture">
                                        <img src="/passon/Public/images/logo.png" alt="Picture">
                                    </div>

                                    <div class="cd-timeline-content">
                                        <h2>借</h2>
                                        <p><span class='keeper' >我</span>借走了《<?php echo ($item['booklog']['title']); ?>》</p>
                                        <p>将在<span class="keeper"><?php echo ($item['end_time']); ?></span>还书</p>
                                        <span class="cd-date"><?php echo ($item['start_time']); ?></span>
                                    </div>
                                </div>
                                <?php elseif ($item['status']==4): ?>
                                <div class="cd-timeline-block">
                                    <div class="cd-timeline-img cd-picture">
                                        <img src="/passon/Public/images/logo.png" alt="Picture">
                                    </div>

                                    <div class="cd-timeline-content">
                                        <h2>预</h2>
                                        <p><span class='keeper' >我</span>预约了《<?php echo ($item['booklog']['title']); ?>》</p>
                                        <span class="cd-date"><?php echo ($item['start_time']); ?></span>
                                    </div>
                                </div>
                                <?php elseif ($item['status']==5): ?>
                                <div class="cd-timeline-block">
                                    <div class="cd-timeline-img cd-picture">
                                        <img src="/passon/Public/images/logo.png" alt="Picture">
                                    </div>

                                    <div class="cd-timeline-content">
                                        <h2>续</h2>
                                        <p><span class='keeper' >我</span>续借了《<?php echo ($item['booklog']['title']); ?>》</p>
                                        <p>将在<span class='keeper' ><?php echo ($item['end_time']); ?></span>还书</p>
                                        <span class="cd-date"><?php echo ($item['start_time']); ?></span>
                                    </div>
                                </div>
                                <?php elseif ($item['status']==3): ?>
                                <div class="cd-timeline-block">
                                    <div class="cd-timeline-img cd-picture">
                                        <img src="/passon/Public/images/logo.png" alt="Picture">
                                    </div>

                                    <div class="cd-timeline-content">
                                        <h2>还</h2>
                                        <p><span class='keeper' >我</span>归还了《<?php echo ($item['booklog']['title']); ?>》</p>
                                        <span class="cd-date"><?php echo ($item['end_time']); ?></span>
                                    </div>
                                </div>
                                <?php endif ?>
                                <?php endforeach ?>
                                <?php endif ?>
                                <div class="cd-timeline-block">
                                    <div class="cd-timeline-img cd-picture">
                                        <img src="/passon/Public/images/logo.png" alt="Picture">
                                    </div>
                                    <div class="cd-timeline-content">
                                        <h2>我</h2>
                                        <p>来到了Makerway这个奇幻漂流世界</p>
                                        <p>可以尽情畅游书海</p>
                                        <span class="cd-date"><?php echo ($book['contribute_time']); ?></span>
                                    </div>

                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div  style="display:none;">
                    <div class="bookmessage-nav">
                        <ul class="bookmessage">
                            <li class="activecolor"><a href="<?php echo U(mypersonal);?>">私人书籍</a></li>
                            <li><a href="<?php echo U(personshare);?>">共享书籍</a></li>
                            <li><a href="<?php echo U(myKeeps);?>">借阅书籍</a></li>
                        </ul>
                        <div class="main-a"><a href="<?php echo U(contribute);?>"><input class="sharebtn" type="button" value="书籍上传"/></a></div>
                    </div>
                    <div class="mybook" >
                        <!--<div class="submybook">-->
                        <!--<div class="submybook-first">-->
                        <!--<img src="/passon/Public/images/false.png"/>-->
                        <!--<div>没有私人书籍？</div>-->
                        <!--<div>快来上传书籍吧！</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <div class="submybook" style="display: block;">
                            <div>共9本/仅自己可见</div>
                            <ul>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                    <div class="select-nav">
                                        <img />
                                        <ul>
                                            <li>删除</li>
                                            <li>共享</li>
                                            <li>写笔记</li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                                <?php if(is_array($mybooks)): foreach($mybooks as $key=>$item): ?><li>
                                        <div class="main-body-li">
                                            <div onclick="document.location='<?php echo U(bookInfo,array('bookid'=>$item['book_id']));?>'" style="cursor:pointer">
                                                <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                                <span class="name">《<?php echo $item['bookinfo']['title']?>》</span>
                                                <span class="author">标签：<?php echo ($item['bookinfo']['tags']); ?></span>
                                                <span class="favour">创建时间：<?php echo ($item['contribute_time']); ?></span>
                                                <span class="comment">书本状态：<?php if($item['status']==1) echo '可借阅'; if($item['status']==2) echo '已借出';if($item['status']==3) echo '可借阅';if($item['status']==4) echo '可预约';if($item['status']==5) echo '可预约'?></span>
                                            </div>
                                            <div style="text-align: center;margin-top: -20px;">
                                                <input type="button" value="打印二维码"  style="cursor:pointer" onclick="javascript:window.open('<?php echo U(qr,array('book_id'=>$item['book_id']));?>')"/>
                                                <input class="recall" type="button" value="收回本书"  style="cursor:pointer;margin-left: 10%"/>
                                            </div>
                                        </div>
                                        <div class="main-tan"></div>
                                        <div class="tan-message">
                                            <div>
                                                <p>现在我在 <?php echo ($item['bookuser']['username']); ?> 那儿</p>
                                                <p>联系方式： <?php echo ($item['bookuser']['phone']); ?></p>
                                                <p>常在地址： <?php echo ($item['bookuser']['addr']); ?></p>
                                                <p>请记录好联系人相关信息，点击确认后将删除关于书本的相关信息，您是否确定？</p>
                                                <input class="tan-button" type="button" value="确定" onclick="document.location='<?php echo U(deleteBook,array('book_id'=>$item['book_id']));?>'"/>
                                                <input class="tan-button1" type="button" value="取消"/>
                                            </div>
                                        </div>
                                    </li><?php endforeach; endif; ?>
                                <span class="fenpage"><?php echo ($page); ?></span>
                            </ul>
                        </div>
                        <div class="submybook" style="display: none;">
                            <div class="doing">
                                <div style="display: block;">
                                    <ul>
                                        <?php if(is_array($mybooks)): foreach($mybooks as $key=>$item): ?><li>
                                                <div class="main-body-li">
                                                    <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                                    <span class="name">《<?php echo $item['bookinfo']['title']?>》</span>
                                                    <span class="author">类别：</span>
                                                    <span class="favour">创建时间：<?php echo ($item['contribute_time']); ?></span>
                                                    <span class="comment">书本状态：<?php if($item['status']==1) echo '可借阅'; if($item['status']==2) echo '已借出';if($item['status']==3) echo '可借阅';if($item['status']==5) echo '可预约'?></span>
                                                    <!--<input type="button" value="借阅历史" onclick="document.location='<?php echo U(bookInfo,array('bookid'=>$item['book_id']));?>'" style="cursor:pointer"/>-->
                                                </div>
                                            </li><?php endforeach; endif; ?>
                                        <span class="fenpage"><?php echo ($page); ?></span>
                                    </ul>
                                </div>
                                <div style="display: none;">
                                    <ul>
                                        <li>
                                            <div class="main-body-li">
                                                <img src=""/>
                                                <span class="name">书名3：<?php echo $item['bookinfo']['title']?></span>
                                                <span class="author">类别：</span>
                                                <span class="favour">创建时间：<?php echo ($item['contribute_time']); ?></span>
                                                <span class="comment">书本状态：<?php if($item['status']==1) echo '可借阅'; if($item['status']==2) echo '已借出';if($item['status']==3) echo '可借阅';if($item['status']==5) echo '可预约'?></span>
                                                <input type="button" value="借阅历史" onclick="document.location='<?php echo U(bookInfo,array('bookid'=>$item['book_id']));?>'" style="cursor:pointer"/>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div style="display: none">
                            <ul style="height: 10px;clear: both;"></ul>
                            <div class="my-pass"></div>
                        </div>
                    </div>
                </div>
                <div style="display: none;">
                    <ul style="height: 10px;clear: both;"></ul>
                    <div class="my-pass"></div>
                    <!--<ul>-->
                    <!--<li class="activecolor">我的书签</li>-->
                    <!--<li>朋友的书签</li>-->
                    <!--<li>热门书签</li>-->
                    <!--</ul>-->
                    <!--<div class="tags">-->
                    <!--<div style="display: block">-->
                    <!--<ul style="height: 10px;clear: both;"></ul>-->
                    <!--<div class="my-pass"></div>-->
                    <!--</div>-->
                    <!--<div style="display: none">-->
                    <!--<ul style="height: 10px;clear: both;"></ul>-->
                    <!--<div class="my-pass"></div>-->
                    <!--</div>-->
                    <!--<div style="display: none">-->
                    <!--<ul style="height: 10px;clear: both;"></ul>-->
                    <!--<div class="my-pass"></div>-->
                    <!--</div>-->
                    <!--</div>-->
                </div>
                <div class="booktags" style="display: block">
                    <div class="bookmessage-nav">
                        <ul class="bookmessage">
                            <li class="activecolor"><a href="<?php echo U(mypersonal);?>">在读</a></li>
                            <li><a href="<?php echo U(personshare);?>">想读</a></li>
                            <li><a href="<?php echo U(myKeeps);?>">已读</a></li>
                        </ul>
                        <div class="main-a"><a href="<?php echo U(contribute);?>"><input class="sharebtn" type="button" value="书籍上传"/></a></div>
                    </div>
                    <div class="mybook" >
                        <!--<div class="submybook">-->
                        <!--<div class="submybook-first">-->
                        <!--<img src="/passon/Public/images/false.png"/>-->
                        <!--<div>没有私人书籍？</div>-->
                        <!--<div>快来上传书籍吧！</div>-->
                        <!--</div>-->
                        <!--</div>-->
                        <div class="submybook" style="display: block;">
                            <div>共9本</div>
                            <ul>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                    <div class="select-nav">
                                        <img src="/passon/Public/images/select.png"/>
                                        <ul>
                                            <li>写笔记</li>
                                            <li>完成阅读</li>
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                                <li>
                                    <div class="supernatant-share">
                                        <img src=""/>
                                    </div>
                                    <div class="title-font">css实战</div>
                                </li>
                            </ul>
                        </div>
                        <div style="display: none">
                            <ul style="height: 10px;clear: both;"></ul>
                            <div class="my-pass"></div>
                        </div>
                    </div>
                </div>
                <div class="friend" style="display: none">
                    <ul>
                        <li class="activecolor">好友列表</li>
                        <li>好友动态</li>
                    </ul>
                    <ul style="height: 10px;clear: both;"></ul>
                    <div class="my-pass">
                        <div class="tags">
                            <div class="friend-message" style="display: block">
                                <div class="friend-member">
                                    <ul>
                                        <?php if(is_array($friendresult)): foreach($friendresult as $key=>$item): ?><li>
                                                <img />
                                                <span><?php echo ($item['friendname']); ?></span>
                                            </li><?php endforeach; endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <div style="display: none">
                                <ul style="height: 10px;clear: both;"></ul>
                                <div class="my-pass"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="notice-request" style="display: none">
                    <ul>
                        <li>请求</li>
                        <li class="activecolor">通知</li>
                    </ul>
                    <ul style="height: 10px;clear: both;"></ul>
                    <div class="my-pass">
                        <div class="message-body">
                            <ul style="display: none">
                                <?php if(is_array($friendhandle)): foreach($friendhandle as $key=>$item): ?><li>
                                        <div class="person-pass-left">
                                            <img />
                                            <span class="person-pass-name"><?php echo ($item['friendname']); ?></span>
                                            <span class="person-pass-request">请求加您为好友</span>
                                        </div>
                                        <div class="person-pass-right">
                                            <input class="agree" type="button" value="同意"/>
                                            <a class="disagree">忽略</a>
                                            <input style="display: none" value="<?php echo ($item['friendname']); ?>"/>
                                        </div>
                                        <div class="person-pass-right" style="display: none">
                                            <input class="agree" type="button" value="已同意"/>
                                        </div>
                                        <div class="person-pass-right" style="display: none">
                                            <a class="disagree">已忽略</a>
                                        </div>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                            <ul>
                                <?php if(is_array($resultmessage)): foreach($resultmessage as $key=>$item): ?><li>
                                            <span class="message-img">
                                                <img src="/passon/Public/images/administrator.png"/>
                                            </span>
                                        <span class="message-notice">系统通知</span>
                                            <span class="message-notice-details">
                                                <span class="message-color">群组系统通知</span><br/>
                                                <span class="message-handle"><?php echo ($item['groupname']); ?>群主
                                                    <?php if ($item['result']==1): ?>
                                                    同意
                                                    <?php elseif ($item['result']==0):?>
                                                    忽略
                                                    <?php endif ?>
                                                    您的加群申请。
                                                </span>
                                            </span>
                                    </li><?php endforeach; endif; ?>
                                <?php if(is_array($friendaddresult)): foreach($friendaddresult as $key=>$item): ?><li>
                                            <span class="message-img">
                                                <img src="/passon/Public/images/administrator.png"/>
                                            </span>
                                        <span class="message-notice">系统通知</span>
                                            <span class="message-notice-details">
                                                <span class="message-color">好友系统通知</span><br/>
                                                <span class="message-handle"><?php echo ($item['username']); ?>
                                                    <?php if ($item['result']==1): ?>
                                                    同意
                                                    <?php elseif ($item['result']==0):?>
                                                    忽略
                                                    <?php endif ?>
                                                    您的好友申请。
                                                </span>
                                            </span>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
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
<script type="text/javascript" src="/passon/Public/js/person.js"></script>
<script type="text/javascript" src="/passon/Public/js/labelsearch.js"></script>
</html>