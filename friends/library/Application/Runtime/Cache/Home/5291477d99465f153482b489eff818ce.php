<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>管理中心</title>
    <link rel="stylesheet" type="text/css" href="/library/Public/css/person.css">
    <link rel="stylesheet" type="text/css" href="/library/Public/css/header.css">
    <link rel="stylesheet" type="text/css" href="/library/Public/css/footer.css">
    <script type="text/javascript" src="/library/Public/js/jquery-1.11.1.min.js"></script>    
    <script type="text/javascript" src="/library/Public/js/mine.js"></script>
    <script type="text/javascript" charset="utf-8" src="/library/Public/js/jquery.leanModal.min.js"></script>
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
                <form action="" method="post">
                    <!-- <table class="search-tab">
                        <tr>
                            
                            <td><input class="common-text" placeholder="请输入搜索关键词" name="kw" value="<?php echo I('kw');?>" id="" type="text"></td>
                            <td><input class="btn btn-primary btn2" name="sub" value="查询" type="submit"></td>
                        </tr>
                    </table> -->
                </form>
            </div>
        </div>

<div class="main-right">
    <div class="subnavigate">
        <div  style="display:block;">
                    <div class="bookmessage-nav">
                        <ul class="bookmessage">
                            <li  class="activecolor">待取物品</li>
                            <li><a href="<?php echo U(myborrow);?>">已借物品</a></li>
                            <li><a href="<?php echo U(myrepair);?>">报修物品</a></li>
                            <li><a href="<?php echo U(mykeep);?>">保管物品</a></li>
                        </ul>
                    </div>    

<div class="result-wrap">
            <form name="myform" id="myform" method="post">
                <div class="result-title">
                    <div class="result-list">
                        <!-- <a id="batchDel" href="javascript:void(0)" ><input form="myform" formaction="/library/Home/Index/bdelwait" type="submit" class="btn btn-primary btn2" onclick="return confirm('确定批量删除选中项吗？');" value="批量删除" /></a> -->
                    </div>
                </div>
                
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr> 
                            <!-- <th class="tc" width="5%"><input type="checkbox" class="allChoose"  id='all' >全选</th> -->
                            <th>物品图片</th>
                            <th>物品名称</th>
                            <th>库存信息</th>
                            <th>数量</th>
                            <th>操作</th>
                        </tr>
                        <?php if(is_array($list2)): $i = 0; $__LIST__ = $list2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$to): $mod = ($i % 2 );++$i;?><tr>
                            <td align="center"><?php echo ($to["username"]); ?></td>
                            <td align="center"><?php echo ($to["address"]); ?></td>
                            <td align="center"><?php echo ($to["phone"]); ?></td>
                            <td class="tc" align="center"></td>
                            <td class="tc" align="center"></td>
                            

                        </tr> 
                        <?php if(is_array($list1)): $i = 0; $__LIST__ = $list1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['username'] == $to['username']): ?><tr>
                            <!-- <td class="tc" align="center">                           
                            <input name="ids[]" value="<?php echo ($vo["name"]); ?>" class="check" type="checkbox">                 
                            </td> -->

                            <td align="center"  class="td-img"><img style="height:160px;width:160px;" src="<?php echo ($vo["img"]); ?>"></td>
                            <td align="center"><?php echo ($vo["name"]); ?></td>
                            <?php if($vo['nownumber'] != 0): ?><td align="center">可借：<?php echo ($vo["nownumber"]); ?></td><?php endif; ?>
                            <?php if($vo['number_left'] != 0): ?><td align="center">可借：<?php echo ($vo["number_left"]); ?></td><?php endif; ?>
                            <td align="center"><?php echo ($vo["number"]); ?></td>
                            <td align="center">
                                <a class="conborrow-link" data-name="<?php echo ($vo["name"]); ?>" data-username="<?php echo ($to["username"]); ?>" data-number="<?php echo ($vo["number"]); ?>" href="#conborrowmodal">确认借用</a><br /><br />
                                
                                <a class="delborrow-link" data-name="<?php echo ($vo["name"]); ?>" data-username="<?php echo ($to["username"]); ?>" data-number="<?php echo ($vo["number"]); ?>" href="#delborrowmodal">删除</a> 
                        </tr><?php endif; endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>

                    </table>
                            <span class="fenpage"><?php echo ($page); ?></span>
                    
                </div>
            </form>
            <div class="main-tan"></div>
            <div id="conborrowmodal" class="tan-reback" style="display:none;">
                  <div>请你拿到物品后再点击“确认”，才会生成相应的借用信息，否则若出现物品丢失情况，后果自负！</div><br/><br/><br/>
                  <label for="username">备注:</label>
                  <input type="text" id="remarkName"><br/><br/><br/>
                  <a id="conborrowAck" href="#">确认</a>&nbsp;&nbsp;&nbsp;
                  <a class='closetrouble'  href="#">取消</a>
            </div>
            <div id="delborrowmodal" class="tan-reback" style="display:none;">
                  <div>确定删除此物品吗？</div><br/><br/><br/>
                  <a id="delborrowAck" href="#">确认</a>&nbsp;&nbsp;&nbsp;
                  <a class='closetrouble'  href="#">取消</a>
            </div>
        </div>
    </div>