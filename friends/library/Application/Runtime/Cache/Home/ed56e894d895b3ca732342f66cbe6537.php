<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>个人中心</title>
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/person.css">
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/header.css">
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/footer.css">
    <script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
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
                    <span><img src="/passon/Public/images/defaultheader.jpg"/></span>
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
            <div class="classify-title"><a style="cursor: pointer;color:#000;text-decoration: none" href="<?php echo U(index);?>">MakerWay</a>>个人中心</div>
        </div>
        <div class="main-left">
            <div class="main-left-person">
                <div class="main-img">
                    <?php if($user['image'] == ''):?>
                    <img class="user-images" src="/passon/Public/images/defaultheader.jpg"/><br/>
                    <?php else :?>
                    <img class="user-images" src="<?php echo ($user['image']); ?>"/><br/>
                    <?php endif?>
                    <span class="username"><?php echo ($user['username']); ?></span>
                </div>
                <div class="username-details">
                    <?php if($honer < 50) :?>
                    <img src="/passon/Public/images/flower.png"/>
                    <?php elseif($honer>49 && $honer<150):?>
                    <img src="/passon/Public/images/flower.png"/><img src="/passon/Public/images/flower.png"/>
                    <?php elseif($honer>149 && $honer<250):?>
                    <img src="/passon/Public/images/flower.png"/><img src="/passon/Public/images/flower.png"/><img src="/passon/Public/images/flower.png"/>
                    <?php elseif($honer>249 && $honer<500):?>
                    <img src="/passon/Public/images/tree.png"/>
                    <?php elseif($honer>549 && $honer<1000):?>
                    <img src="/passon/Public/images/tree.png"/><img src="/passon/Public/images/tree.png"/>
                    <?php elseif($honer>999 && $honer<2000):?>
                    <img src="/passon/Public/images/tree.png"/><img src="/passon/Public/images/tree.png"/><img src="/passon/Public/images/tree.png"/>
                    <?php elseif($honer>1999 && $honer<5000):?>
                    <img src="/passon/Public/images/apple.png"/>
                    <?php elseif($honer>4999 && $honer<10000):?>
                    <img src="/passon/Public/images/apple.png"/><img src="/passon/Public/images/apple.png"/>
                    <?php else :?>
                    <img src="/passon/Public/images/flower.png"/><img src="/passon/Public/images/flower.png"/><img src="/passon/Public/images/flower.png"/>
                    <?php endif?>
                    <div><?php echo ($user['describe']); ?></div>
                    <div>已在MakerWay上帮助过<?php echo ($helpcount); ?>人</div>
                </div>
                <div class="main-ul">
                    <ul>
                        <li><?php echo ($countShare); ?><br/><br/>共享书籍</li>
                        <li><?php echo ($notecount); ?><br/><br/>笔记</li>
                        <li><span class="friend-number"><?php echo ($friendcount); ?></span><br/><br/>粉丝</li>
                    </ul>
                    <!--<div class="main-a"><a href="<?php echo U(contribute);?>"><input class="sharebtn" type="button" value="我要分享"/></a></div>-->
                </div>
            </div>
        </div>
        <div class="main-right">
            <div class="navigate">
                <ul>
                    <li>动态</li>
                    <li><a href="<?php echo U(mypersonal);?>">我的书房</a></li>
                    <li  class="border">阅读情况</li>
                    <li><a href="<?php echo U(booknote);?>">我的笔记</a></li>
                    <li>关注</li>
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
                        <div class="submybook" style="display:block;">
                            <div>共<span class="personnumber"><?php echo ($personalcount); ?></span>本/仅自己可见</div>
                            <?php if($personalcount == 0) :?>
                            <div class="submybook">
                                <div class="submybook-first">
                                    <img src="/passon/Public/images/false.png"/>
                                    <div>没有私人书籍？</div>
                                    <div>快来上传书籍吧！</div>
                                </div>
                            </div>
                            <?php else: ?>
                            <ul>
                                <?php if(is_array($personalbooklist)): foreach($personalbooklist as $key=>$item): ?><li>
                                        <div class="supernatant-share">
                                            <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                        </div>
                                        <div class="title-font"><?php echo ($item['bookinfo']['title']); ?></div>
                                        <div class="select-nav">
                                            <img src="/passon/Public/images/select.png"/>
                                            <ul>
                                                <!--<li>删除</li>-->
                                                <li>共享</li>
                                                <li style="display: none"><?php echo ($item['book_id']); ?></li>
                                                <li><a href="<?php echo U(booknote);?>">写笔记</a></li>
                                            </ul>
                                        </div>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="submybook" style="display: none;">
                        <?php if($countShare == 0) :?>
                        <div class="submybook">
                            <div class="submybook-first">
                                <img src="/passon/Public/images/false.png"/>
                                <div>没有共享书籍？</div>
                                <div>快来上传书籍吧！</div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div>漂流中-共<span class="sharenumber"><?php echo ($countSharecan); ?></span>本/他人可借阅</div>
                        <ul>
                            <?php if(is_array($sharebooklistcan)): foreach($sharebooklistcan as $key=>$item): ?><li>
                                    <div class="supernatant-share">
                                        <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                    </div>
                                    <div class="title-font"><?php echo ($item['bookinfo']['title']); ?></div>
                                    <div class="select-nav">
                                        <img src="/passon/Public/images/select.png"/>
                                        <ul>
                                            <!--<li>删除</li>-->
                                            <li>收回</li>
                                            <li style="display: none"><?php echo ($item['book_id']); ?></li>
                                            <li><a href="<?php echo U(booknote);?>">写笔记</a></li>
                                        </ul>
                                    </div>
                                </li><?php endforeach; endif; ?>
                            <?php endif ?>
                        </ul>
                        <div>借阅中-共<?php echo ($countShareno); ?>本/漂流在其他书友处</div>
                        <ul>
                            <?php if(is_array($sharebooklistno)): foreach($sharebooklistno as $key=>$item): ?><li>
                                    <div class="supernatant-share">
                                        <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                    </div>
                                    <div class="title-font"><?php echo ($item['bookinfo']['title']); ?></div>
                                    <div class="select-nav">
                                        <img src="/passon/Public/images/select.png"/>
                                        <ul>
                                            <li><a href="<?php echo U(booknote);?>">写笔记</a></li>
                                        </ul>
                                    </div>
                                </li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                    <div class="submybook" style="display: none;">
                        <?php if ($waitcount!=0): ?>
                        <div>待取，共<?php echo ($waitcount); ?>本/需要线下取书完成借阅</div>
                        <div class="toTake">
                            <form method="post" action="<?php echo U(formHandle);?>">
                                <ul>
                                    <?php if(is_array($waitbooklist)): foreach($waitbooklist as $key=>$item): ?><li>
                                            <input class="radio" type="checkbox" name="book_id[]" value="<?php echo ($item['book_id']); ?>"/>
                                            <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                            <span class="book-title"><?php echo ($item['bookinfo']['title']); ?></span>
                                            <span class="author"><?php echo ($item['bookinfo']['author']); ?></span>
                                            <span class="express"><?php echo ($item['bookinfo']['publisher']); ?></span>
                                        </li><?php endforeach; endif; ?>
                                </ul>
                                <div class="choseall">
                                    <input type="checkbox" name="allcheck" id="allcheck"/>
                                    <label for="allcheck">全选</label>
                                    <input class="button" type="submit" value="确认借阅"/>
                                </div>
                            </form>
                        </div>
                        <?php endif ?>
                        <div>保管书籍，共<?php echo ($countborrow); ?>本/现在仍漂流在我这</div>
                        <ul>
                            <?php if(is_array($borrowbooklist)): foreach($borrowbooklist as $key=>$item): ?><li>
                                    <div class="supernatant-share">
                                        <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                    </div>
                                    <div class="title-font"><?php echo ($item['bookinfo']['title']); ?></div>
                                    <div class="select-nav">
                                        <img src="/passon/Public/images/select.png"/>
                                        <ul>
                                            <li><a href="<?php echo U(booknote);?>">写笔记</a></li>
                                        </ul>
                                    </div>
                                </li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="booktags" style="display: block">
                    <div class="bookmessage-nav">
                        <ul class="bookmessage">
                            <li><a href="<?php echo U(bookreading);?>">在读</a></li>
                            <li class="activecolor">想读</li>
                            <li>已读</li>
                        </ul>
                        <div class="main-a"><a href="<?php echo U(contribute);?>"><input class="sharebtn" type="button" value="书籍上传"/></a></div>
                    </div>
                    <div class="mybook" >
                        <div class="submybook" style="display: none">
                            <?php if($countreading == 0): ?>
                            <div class="submybook-first">
                                <img src="/passon/Public/images/false.png"/>
                                <div>没有在读书籍？</div>
                                <div>快来共享库寻找喜欢的书籍吧！</div>
                            </div>
                            <?php else :?>
                            <div>共<span class="readingnumber"><?php echo ($countreading); ?></span>本</div>
                            <ul>
                                <?php if(is_array($readingbooklist)): foreach($readingbooklist as $key=>$item): ?><li>
                                        <div class="supernatant-share">
                                            <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                        </div>
                                        <div class="title-font"><?php echo ($item['bookinfo']['title']); ?></div>
                                        <div class="select-nav">
                                            <img src="/passon/Public/images/select.png"/>
                                            <ul>
                                                <li><a href="<?php echo U(booknote);?>">写笔记</a></li>
                                                <li>完成阅读</li>
                                                <li style="display: none"><?php echo ($item['book_id']); ?></li>
                                            </ul>
                                        </div>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                            <?php endif ?>
                        </div>
                        <div class="submybook" style="display: block">
                            <?php if($wantcount == 0): ?>
                            <div class="submybook-first">
                                <img src="/passon/Public/images/false.png"/>
                                <div>没有想读书籍？</div>
                                <div>快来共享库寻找喜欢的书籍吧！</div>
                            </div>
                            <?php else :?>
                            <div>共<span class="wantnumber"><?php echo ($wantcount); ?></span>本</div>
                            <ul>
                                <?php if(is_array($wantbooklist)): foreach($wantbooklist as $key=>$item): ?><li>
                                        <div class="supernatant-share">
                                            <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                        </div>
                                        <div class="title-font"><?php echo ($item['bookinfo']['title']); ?></div>
                                        <div class="select-nav">
                                            <img src="/passon/Public/images/select.png"/>
                                            <ul>
                                                <li><a href="<?php echo U(booknote);?>">写笔记</a></li>
                                                <li>开始阅读</li>
                                                <li style="display: none"><?php echo ($item['book_id']); ?></li>
                                            </ul>
                                        </div>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                            <?php endif ?>
                        </div>
                        <div class="submybook" style="display: none">
                            <?php if($countalready == 0): ?>
                            <div class="submybook-first">
                                <img src="/passon/Public/images/false.png"/>
                                <div>没有已读书籍？</div>
                                <div>快来共享库寻找喜欢的书籍吧！</div>
                            </div>
                            <?php else :?>
                            <div>共<?php echo ($countalready); ?>本</div>
                            <ul>
                                <?php if(is_array($alreadybooklist)): foreach($alreadybooklist as $key=>$item): ?><li>
                                        <div class="supernatant-share">
                                            <img src="<?php echo ($item['bookinfo']['image']); ?>"/>
                                        </div>
                                        <div class="title-font"><?php echo ($item['bookinfo']['title']); ?></div>
                                        <div class="select-nav">
                                            <img src="/passon/Public/images/select.png"/>
                                            <ul>
                                                <li><a href="<?php echo U(booknote);?>">写笔记</a></li>
                                            </ul>
                                        </div>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <div class="submybook" style="display: none;">
                    <div class="book-comment">
                        <div class="comment-num"><?php echo ($notecount); ?>条笔记</div>
                        <div class="comment-message">写笔记</div>
                    </div>
                    <div class="submybook">
                        <?php if($notecount == 0) :?>
                        <div class="submybook-first">
                            <img src="/passon/Public/images/false.png"/>
                            <div>读了这么多书，还没有写过笔记？</div>
                            <div>点击右上角写笔记按钮，发表你的读书感悟</div>
                            <div>帮助其他书友了解此书，期待他人的回应吧！</div>
                        </div>
                        <?php else :?>
                        <div class="comment-comment">
                            <div class="do-comment">
                                <form name="form" action="<?php echo U(dobooknote);?>" method="post" onsubmit="return check()">
                                    <div class="comment-title">
                                        <span>书名<input name="bookname"/></span>
                                        <span>标题<input name="title"/></span>
                                    </div>
                                    <div class="comment-top">笔记内容：</div>
                                    <div class="textarea">
                                        <textarea class="input_text" name="textarea"></textarea>
                                    </div>
                                    <div class="comment-button">
                                        <input type="submit" name="submit" value="发表" />
                                        <input class="exit" type="button" name="button" value="取消" />
                                    </div>
                                </form>
                            </div>
                            <ul>
                                <?php if(is_array($booknote)): foreach($booknote as $key=>$item): ?><li>
                                        <div class="main-bookcomment">
                                            <div>《<?php echo ($item['title']); ?>》</div>
                                            <div class="color">发布于<?php echo ($item['time']); ?></div>
                                            <div><?php echo ($item['note']); ?></div>
                                            <span class="comment-span"><span class="comment-spannum"><?php echo ($item['number']['note_approvenumber']+0)?></span><span class="comment-zannum" title="<?php if($item['approveflag']['flag']==1) echo '取消赞同'; elseif($item['approveflag']['flag']==0) echo '';?>">人赞同</span></span>
                                            <input class="exit" style="display: none" type="text" name="comment" value=<?php echo ($item['id']); ?> />
                                            <!--<input class="exit" style="display: none" type="text" name="bookid" value=<?php echo ($book['book_id']); ?> />-->
                                            <span class="com-n"><?php echo ($item['number']['note_commentnumber']+0)?>条评论</span>
                                            <!--<span>人分享</span>-->
                                        </div>
                                        <div class="comment-comment-ul">
                                            <ul>
                                                <?php foreach ($item['note_note'] as $itemnote): ?>
                                                <li>
                                                    <div class="main-comment-comment">
                                                        <img src="<?php echo ($itemnote['image']); ?>"/>
                                                        <span class="c-n"><?php echo ($itemnote['username']); ?></span>
                                                        <span class="c-c"><?php echo ($itemnote['note']); ?></span>
                                                        <span class="c-time color"><?php echo ($itemnote['time']); ?></span>
                                                    </div>
                                                </li>
                                                <?php endforeach ?>
                                                <form name="form" action="<?php echo U(dobooknote_note);?>" method="post" onsubmit="return check1()">
                                                    <textarea class="write" name="input" placeholder="写下你的评论"></textarea><br/>
                                                    <input class="write-exit" type="button" name="exit" value="取消" />
                                                    <input class="write-button" type="submit" name="submit" value="发表" />
                                                    <input class="exit" style="display: none" type="text" name="note" value=<?php echo ($item['id']); ?> />
                                                </form>
                                            </ul>
                                        </div>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                        </div>
                        <?php endif?>
                    </div>
                </div>
                <div class="submybook" style="display: none;">
                    <div class="focus-container">
                        <?php if($friendcount == 0):?>
                        <div class="focus-hd">
                            <p>0个关注</p>
                        </div>
                        <div class="focus-bd">
                            <div class="default clearfix">
                                <div class="avatar">
                                    <img src="/passon/Public/images/avatar.jpg" alt="">
                                </div>
                                <div class="text">
                                    浩瀚书海，我还没有好友相伴？<br>
                                    前往共享库借阅的同时，别忘了添加几个好友喔~ <br>
                                    第一时间获知好友的分享与借阅动态，一起分享智慧！
                                </div>
                            </div>
                        </div>
                        <?php else:?>
                        <div class="focus-hd">
                            <p class="strong"><span><?php echo ($user['username']); ?></span>关注了<span class="focus-hd-number"><?php echo ($friendcount); ?></span>人</p>
                        </div>
                        <div class="focus-bd">
                            <?php if(is_array($friendlist)): foreach($friendlist as $key=>$item): ?><div class="avatar-message clearfix">
                                    <div class="avatar">
                                        <img src="<?php echo ($item['image']); ?>" alt="">
                                    </div>
                                    <div class="message">
                                        <p class="name"><?php echo ($item['friendname']); ?></p>
                                        <p class="description"><?php echo ($item['describe']); ?></p>
                                        <p><span><?php echo ($item['sharecount']); ?></span>共享书籍/<span><?php echo ($item['notecount']); ?></span>笔记/<span><?php echo ($item['friendcount']); ?></span>粉丝/帮助过<span><?php echo ($item['helpcount']); ?></span>人 </p>
                                    </div>
                                    <div class="btn">
                                        <input class="cancel-btn" type="button" value="取消关注" />
                                        <input style="display: none" value="<?php echo ($item['id']); ?>"/>
                                    </div>
                                </div><?php endforeach; endif; ?>
                        </div>
                        <?php endif?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
    <div class="pass">
        <img src="/passon/Public/images/qrmakerway.jpg"/><span>扫面关注makerway微信公众号</span>
    </div>
    <span>联系邮箱：maker_way@163.com</span>
    <div class="footer-img">
        <img src="/passon/Public/images/makerway.png"/>
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