<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>管理中心</title>
    <link rel="stylesheet" type="text/css" href="/library/Public/css/person.css">
    <link rel="stylesheet" type="text/css" href="/library/Public/css/header.css">
    <!-- <link rel="stylesheet" type="text/css" href="/library/Public/css/footer.css"> -->
    <script type="text/javascript" src="/library/Public/js/jquery-1.11.1.min.js"></script>    
    <script type="text/javascript" src="/library/Public/js/mine.js"></script>
    <script type="text/javascript" charset="utf-8" src="/library/Public/js/jquery.leanModal.min.js"></script>

</head>
<body>
<div class="content">
    <div class="head">
    <div class="title">
        <div class="title-left">
            <span class="title-m"><a href="<?php echo U(share);?>">物品管理</a></span>
            <span class="title-help"><a href="<?php echo U(mywait);?>">购物车</a></span>
            <span class="title-main"><a href="<?php echo U(share);?>">物品库</a></span>
             <?php if($user['username'] == $admin['username']) :?>
            <span class="title-share"><a href="<?php echo U(contribute);?>">物品上传</a></span>
            <?php endif ?>    
        </div>
        <div class="div-search">
            <form name="search" action="<?php echo U(search);?>" method="post">
                <input  class="search" name="search" type="text" placeholder="输入您想搜索物品的名字" />
                <div class="search-a">
                    <input type="image" src="/library/Public/images/search.png" name="img">
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
                    <?php if($user['img'] == '') :?>
                    <span><img src="/library/Public/images/defaultheader.jpg"/></span>
                    <?php else :?>
                    <span><img src="<?php echo ($user['img']); ?>"/></span>
                    <?php endif?>
                    <span class="username-c-username"><?php echo ($user['username']); ?></span>
                    <ul>
                        <li><a href="<?php echo U(person);?>">我的主页</a></li>
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
            <div class="classify-title"><a style="cursor: pointer;color:#000;text-decoration: none" href="<?php echo U(share);?>">物品管理</a>>管理中心</div>
        </div>

        <div class="search-wrap">
            <div class="search-content">
                <!-- <form action="" method="post">
                    <table class="search-tab">
                        <tr>
                            
                            <td><input class="common-text" placeholder="请输入搜索关键词" name="kw" value="<?php echo I('kw');?>" id="" type="text"></td>
                            <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form> -->
            </div>
        </div>

<div class="main-right">
    <div class="subnavigate">
        <div  style="display:block;">
                    <div class="bookmessage-nav">
                        <ul class="bookmessage">
                            <li><a href="<?php echo U(mywait);?>">待取物品</a></li>
                            <li><a href="<?php echo U(myborrow);?>">已借物品</a></li>
                            <li  class="activecolor">报修物品</li>
                            <li><a href="<?php echo U(mykeep);?>">保管物品</a></li>
                        </ul>
                    </div>    

<div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-title">
                    <div class="result-list">                    
                        <!-- <a id="batchDel" href="javascript:void(0)" ><input form="myform" formaction="/library/Home/Index/bcancel" type="submit" class="btn btn-primary btn2" onclick="return confirm('确定批量取消选中项吗？');" value="批量取消" /></a> -->
                    </div>
                </div>
                
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <!-- <th class="tc" width="5%"><input type="checkbox" class="allChoose"  id='all' >全选</th> -->                             
                            <th>物品图片</th>
                            <th>物品名称</th>
                            <th>报修数量</th>
                            <th>报修时间</th> 
                            <th>状态</th> 
                            <th>操作</th>               
                        </tr>
                        
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <!-- <td class="tc" align="center">                           
                            <input name="ids[]" value="<?php echo ($vo["id"]); ?>" class="check" type="checkbox">                 
                            </td> -->
                            <td align="center"  class="td-img"><img style="height:160px;width:160px;" src="<?php echo ($vo["img"]); ?>"></td>
                            <td align="center"><?php echo ($vo["name"]); ?></td>
                            <td align="center"><?php echo ($vo["nownumber"]); ?></td>
                            <td align="center"><?php echo ($vo["time"]); ?></td>
                            <td align="center">
                                <?php if($vo['conditions'] == 0): ?>报修中<?php endif; ?>
                                <?php if($vo['conditions'] == 1): ?>处理中<?php endif; ?>
                                <?php if($vo['conditions'] == 2): ?>已完成<?php endif; ?>

                            </td>

                            <td align="center">
                                <?php if($vo['conditions'] == 0): ?><a class="link-canl" data-name="<?php echo ($vo["name"]); ?>" data-number="<?php echo ($vo["nownumber"]); ?>" href="#cancelmodal">取消报修</a><?php endif; ?>
                                <?php if($vo['conditions'] == 1): ?><a class="link-canl" data-name="<?php echo ($vo["name"]); ?>" data-number="<?php echo ($vo["nownumber"]); ?>" href="#cancelmodal">取消报修</a><?php endif; ?>
                                <?php if($vo['conditions'] == 2): ?><a class="link-canl" data-name="<?php echo ($vo["name"]); ?>" data-number="<?php echo ($vo["nownumber"]); ?>" href="#cancelmodal">确认</a><?php endif; ?>
                                
                            </td>
                            
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                    </table>
                    <div class="list-page"> <?php echo ($page); ?></div>
                </div>
            </form>
            <div class="main-tan"></div>
            <div id="cancelmodal" class="tan-reback" style="display:none;">
                  <div>确定取消报修选中项吗？</div><br/><br/><br/>
                  <a id="cancelNumAck" href="#">确认</a>&nbsp;&nbsp;&nbsp;
                  <a class='closetrouble'  href="#">取消</a>
            </div>
        </div>        
    </div>