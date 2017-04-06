<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/3/7
 * Time: 下午3:30
 */
/*我要提问界面*/
include "./template/head.php";
include "./template/navbar.php";
?>
<div class="container" style="margin-top: 10px">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-9 left" id="col9">
            <h4 class="qTitle">
                求教使用AT查看或更改BT参数的代码!!!!
            </h4>
            <div class="qContent">
                <?php ?>
            </div>













        </div><!--col8-->
        <div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
            <!--提问按钮-->
            <a class="btn btn-default" href="ask.php">
                <img src="img/question.png" class="img-responsive center-block">
            </a>

            <!--热门标签-->
            <div class="tags" style="margin-left: 14px">
                <div style="height: 42px">
                    <p style="font-size: large;display:inline-block;margin-top: 5%;font-weight: bold">相似标签</p>
                    <a href="tag.php" style="color:gray;float: right;display: inline-block;margin-top: 5%">全部标签</a>
                </div>
                <!--分割线-->
                <div style="height: 2px;background-color: lightgray"></div>
                <!--标签群   固定个数?  如何生成热门标签 将输入的东西换成<?php?>传入的数据-->
                <div style="word-wrap: break-word; word-break: keep-all;">
                    <h4>
                        <a class="label label-default">
                            舵机<span class="badge">(40)</span>
                        </a>
                        <a class="label label-default">
                            编译<span class="badge">(36)</span>
                        </a>
                        <a class="label label-default">
                            上传<span class="badge">(30)</span>
                        </a>
                        <a class="label label-default">
                            Mwatch<span class="badge">(20)</span>
                        </a>
                        <a class="label label-default">
                            OLED<span class="badge">(18)</span>
                        </a>
                        <a class="label label-default">
                            Wifi<span class="badge">(15)</span>
                        </a>
                        <a class="label label-default">
                            Wifi气象站<span class="badge">(10)</span>
                        </a>
                        <a class="label label-default">
                            蓝牙<span class="badge">(10)</span>
                        </a>
                        <a class="label label-default">
                            触摸<span class="badge">(8)</span>
                        </a>
                        <a class="label label-default">
                            声音<span class="badge">(5)</span>
                        </a>
                    </h4>
                </div>
                <!--相似问题-->
                <div>
                    <div style="height: 42px">
                        <p style="font-size: large;display:inline-block;margin-top: 5%;font-weight: bold">相似问题</p>
                    </div>
                </div>
                <!--分割线-->
                <div style="height: 2px;background-color: lightgray"></div>
                <!--问题群-->
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="#">蓝牙连接不上怎么办?不知道代码哪里有问题,求帮助!</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#">蓝牙代码怎么写?</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#">蓝牙是个坑!</a>
                    </li>
                </ul>
                </div>
            </div>
    </div>
</div>
<?php include "./template/footer.php";?>


