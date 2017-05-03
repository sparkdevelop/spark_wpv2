<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>系统概貌</title>
    <link rel="stylesheet" type="text/css" href="/library/Public/css/person.css">
    <link rel="stylesheet" type="text/css" href="/library/Public/css/header.css">
    <link rel="stylesheet" type="text/css" href="/library/Public/css/footer.css">
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
            <div class="classify-title"><a style="cursor: pointer;color:#000;text-decoration: none" href="<?php echo U(share);?>">物品管理</a>>系统概貌</div>
        </div>


<div class="main-right">
    <div class="subnavigate">
        <div  style="display:block;">
                    <div class="bookmessage-nav">
                        <ul class="bookmessage">
                            <li><a href="<?php echo U(system);?>">全部物品</a></li>
                            <li><a href="<?php echo U(repair);?>">报修物品</a></li>
                            <li><a href="<?php echo U(record);?>">借用记录</a></li>
                            <li  class="activecolor">用户管理</li>
                            <li><a href="<?php echo U(recovery);?>">待回收物品</a></li>
                            <li><a href="<?php echo U(examine);?>">待审核物品</a></li>
                        </ul>
                    </div>    

<div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <!-- <div class="result-title">
                    <div class="result-list">                    
                        <a id="batchDel" href="javascript:void(0)" ><input form="myform" formaction="/library/Home/Index/bdeluser" type="submit" class="btn btn-primary btn2" onclick="return confirm('确定批量删除选中项吗？');" value="批量删除" /></a>
                    </div>
                </div> -->
                
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <!-- <th class="tc">全选</th>   -->
                            <th>序号</th>
                            <th>用户名</th>
                            <th>基本信息</th>
                            <th>借用状态</th>
                            <th>操作</th>                          
                        </tr>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <!-- <td class="tc" align="center">                           
                            <input name="ids[]" value="<?php echo ($vo["id"]); ?>" class="check" type="checkbox">                 
                            </td> -->

                            <td align="center"><?php echo ($vo["id"]); ?></td>
                            <td align="center"><?php echo ($vo["username"]); ?></td>
                            <td align="center">学号：<?php echo ($vo["number"]); ?><br />手机号：<?php echo ($vo["phone"]); ?></td>

                            <td align="center">
                            <?php if(is_array($arrb)): $i = 0; $__LIST__ = $arrb;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$qo): $mod = ($i % 2 );++$i; if($qo['username'] == $vo['username']): ?>借用中×<?php echo ($qo["nownumber"]); ?><br /><?php endif; endforeach; endif; else: echo "" ;endif; ?>

                            <?php if(is_array($arrk)): $i = 0; $__LIST__ = $arrk;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$wo): $mod = ($i % 2 );++$i; if($wo['username'] == $vo['username']): ?>保管中×<?php echo ($wo["nownumber"]); ?><br /><?php endif; endforeach; endif; else: echo "" ;endif; ?>

                            <?php if(is_array($arrr)): $i = 0; $__LIST__ = $arrr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$eo): $mod = ($i % 2 );++$i; if($eo['username'] == $vo['username']): ?>报修中×<?php echo ($eo["nownumber"]); ?><br /><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </td>

                            <td align="center">
                                                               
                                <a class="del-user" data-id="<?php echo ($vo["id"]); ?>" href="#delmodal">删除</a><br /><br />                      
                                <a class="link-details" href=" /library/Home/Index/person/id/<?php echo ($vo["id"]); ?>">详情</a>
                                
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </table>
                    <span style="margin-top:20px;display:inline-block;">共<?php echo ($count); ?>个用户</span>
                    <span class="fenpage"><?php echo ($page); ?></span>
                </div>
            </form>
            <div class="main-tan"></div>
            <div id="delmodal" class="tan-reback" style="display:none;">
                  <div>确定删除此用户吗？</div><br/><br/><br/>
                  <a id="delNumAck" href="#">确认</a>&nbsp;&nbsp;&nbsp;
                  <a class='closetrouble'  href="#">取消</a>
            </div>
           <!--  <li> <?php echo ($ttest); ?> </li> -->
        </div>
    </div>