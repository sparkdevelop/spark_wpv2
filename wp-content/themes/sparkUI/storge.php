<div class="container" style="margin-top: 10px">
    <div class="row" style="width: 100%">
        <div class="col-md-8 col-sm-8 col-xs-8">
            <div style="height: 38px">
                <!--                左标签页-->
                <ul id="leftTab" class="nav nav-pills" style="float: left">
                    <li class="active"><a href="#OShardware" data-toggle="tab">开源硬件</a></li>
                    <li><a href="#web" data-toggle="tab" style="margin-left: -16px">web学习</a></li>
                </ul>
                <!--                右标签页-->
                <ul class="nav nav-pills" id="OShardware" style="float: right">
                    <li><a href="#hot" data-toggle="tab" style="margin-right: -16px">热门</a></li>
                    <li class="active"><a href="#all" data-toggle="tab" style="margin-right: -16px">所有989</a></li>
                    <li><a href="#unresolve" data-toggle="tab">未解决102</a></li>
                </ul>
            </div>
            <div style="height: 2px;background-color: lightgray"></div>

            <!--           左列表内容 需要填写的都用php提取出来就行-->

            <div id="leftTabContent" class="tab-content">
                <div class="tab-pane fade in active" id="OShardware">

                    <ul class="list-group">
                        <!--提问模式-->
                        <li class="list-group-item" style="padding: 15px 0px">
                            <!--                            问题列表,一页10条-->
                            <div style="display: inline-block;vertical-align: top">
                                <img src="<?php bloginfo("template_url")?>/img/listavatar.png" style="margin-top: 0px">
                            </div>
                            <div style="display: inline-block;vertical-align: top;width: 84%;margin-left: 15px">

                                <div style="color:gray">
                                    <a href="personal.php">小菜</a>
                                    <span class="ask_date" style="margin-left: 20px">3月2日</span>&nbsp;&nbsp;
                                    <span>提问</span>
                                </div>

                                <div style="margin-top:10px;">
                                    <a class="ask_topic" href="show_question.php" style="font-size: medium;font-weight: bold">help!请问这个代码里关于蜂鸣器音调的部分完全没有作用,在线等,好急啊!</a>
                                </div>

                                <div style="color:gray;margin-top:10px;">
                                    <button class="btn btn-default" style="padding-left: 0px"><img src="<?php bloginfo("template_url")?>/img/answer_button.png"></button>
                                    <span class="ask_count" style="margin-left: 0px">回答0</span>&nbsp;&nbsp;
                                    <span class="scan_count" style="margin-left: 0px">浏览12</span>&nbsp;&nbsp;
                                    <div style="word-wrap: break-word; word-break: keep-all;display: inline-block">
                                        <h4>
                                            <a class="label label-default">硬件</a>
                                            <a class="label label-default">蜂鸣器</a>
                                            <a class="label label-default">音调</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="divline"></div>
                        </li>
                        <!--                        有回答未采纳模式-->
                        <li class="list-group-item" style="padding: 15px 0px">
                            <div style="display: inline-block;vertical-align: top">
                                <img src="<?php bloginfo("template_url")?>/img/listavatar.png" style="margin-top: 0px">
                            </div>
                            <div style="display: inline-block;vertical-align: top">

                                <div style="color:gray">
                                    <a href="personal.php" style="margin-left: 20px">jiangs</a>
                                    <span class="ask_date" style="margin-left: 20px">3月2日</span>&nbsp;&nbsp;
                                    <span>提问</span>
                                </div>

                                <div style="margin-top:10px;">
                                    <a class="ask_topic" href="show_question.php" style="margin-left: 20px;font-size: medium;font-weight: bold">
                                        求教使用AT查看或更改BT的参数代码!!!!</a>
                                </div>
                                <!--                                答案展示-->
                                <div style="color:gray;margin-top:10px;">
                                    <div style="color:gray">
                                        <a href="personal.php" style="margin-left: 20px">如影随风</a>
                                        <span class="ask_date" style="margin-left: 20px">1小时前</span>&nbsp;&nbsp;
                                        <span>回答</span>
                                    </div>
                                    <div style="color: gray;margin-left: 20px">
                                        content
                                    </div>
                                    <span class="ask_count" style="margin-left: 20px">赞同5</span>&nbsp;&nbsp;
                                    <span class="ask_count" style="margin-left: 20px">回答4</span>&nbsp;&nbsp;
                                    <span class="scan_count" style="margin-left: 20px">浏览12</span>&nbsp;&nbsp;
                                    <div style="word-wrap: break-word; word-break: keep-all;display: inline-block">
                                        <h4>
                                            <a class="label label-default">硬件</a>
                                            <a class="label label-default">蜂鸣器</a>
                                            <a class="label label-default">音调</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="divline"></div>
                        </li>
                        <!--                        回答且采纳模式-->
                        <li class="list-group-item" style="padding: 15px 0px">
                            <div style="display: inline-block;vertical-align: top">
                                <img src="<?php bloginfo("template_url")?>/img/listavatar.png" style="margin-top: 0px">
                            </div>
                            <div style="display: inline-block;vertical-align: top">

                                <div style="color:gray">
                                    <a href="personal.php" style="margin-left: 20px">李永康</a>
                                    <span class="ask_date" style="margin-left: 20px">3月2日</span>&nbsp;&nbsp;
                                    <span>提问</span>
                                </div>

                                <div style="margin-top:10px;">
                                    <a class="ask_topic" href="show_question.php" style="margin-left: 20px;font-size: medium;font-weight: bold">
                                        求教使用AT查看或更改BT的参数代码!!!!</a>
                                </div>
                                <!--                                答案展示-->
                                <div style="color:gray;margin-top:10px;">
                                    <div style="color:gray">
                                        <a href="personal.php" style="margin-left: 20px">如影随风</a>
                                        <span class="ans_date" style="margin-left: 20px">1小时前</span>&nbsp;&nbsp;
                                        <span>回答</span>
                                    </div>
                                    <div style="color: gray;margin-left: 20px">
                                        <span class="label label-default">已采纳</span>content
                                    </div>
                                    <span class="like_count" style="margin-left: 20px">赞同5</span>&nbsp;&nbsp;
                                    <span class="ans_count" style="margin-left: 20px">回答4</span>&nbsp;&nbsp;
                                    <span class="scan_count" style="margin-left: 20px">浏览12</span>&nbsp;&nbsp;
                                    <div style="word-wrap: break-word; word-break: keep-all;display: inline-block">
                                        <h4>
                                            <a class="label label-default">硬件</a>
                                            <a class="label label-default">蜂鸣器</a>
                                            <a class="label label-default">音调</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                            <div class="divline"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!--md8-->

        <div class="col-md-4 col-sm-4 col-xs-4 right">
            <!--提问按钮-->
            <div class="ask_button" onclick="ask()">
                <p>我要提问</p>
            </div>




            <!--            <a class="btn btn-default" href="ask.php">-->
            <!--                <img src="--><?php //bloginfo("template_url")?><!--/img/question.png" class="img-responsive center-block">-->
            <!--            </a>-->

            <!--            热门标签-->
            <div class="tags" style="margin-left: 14px">
                <div style="height: 42px">
                    <p style="font-size: large;display:inline-block;margin-top: 5%;font-weight: bold">热门标签</p>
                    <a href="tag.php" style="color:gray;float: right;display: inline-block;margin-top: 5%">全部标签</a>
                </div>
                <!--                分割线-->
                <div style="height: 2px;background-color: lightgray"></div>
                <!--                标签群   固定个数?  如何生成热门标签 将输入的东西换成--><?//php?><!--传入的数据-->
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
            </div>

            <!--助教团-->
            <div class="assistant" style="margin-left: 14px">
                <div style="height: 42px">
                    <p style="font-size: large;display:inline-block;margin-top: 5%;font-weight: bold">助教团</p>
                    <a href="join.php" style="color:gray;float: right;display: inline-block;margin-top: 5%">加入</a>
                </div>
                <!--分割线-->
                <div style="height: 2px;background-color: lightgray"></div>
                <!--助教列表-->
                <ul class="list-group">
                    <li class="list-group-item">
                        <div style="display: inline-block;vertical-align: baseline">
                            <img src="<?php bloginfo("template_url")?>/img/avatar.png" style="margin-top: -15px">
                        </div>
                        <div style="display: inline-block; vertical-align: baseline">
                            <a href="personal.php">如影随风</a>
                            <p>北邮信通院大四学长</p>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div style="display: inline-block;vertical-align: baseline">
                            <img src="<?php bloginfo("template_url")?>/img/avatar.png" style="margin-top: -15px">
                        </div>
                        <div style="display: inline-block; vertical-align: baseline">
                            <a href="personal.php">如影随风</a>
                            <p>北邮信通院大四学长</p>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div style="display: inline-block;vertical-align: baseline">
                            <img src="<?php bloginfo("template_url")?>/img/avatar.png" style="margin-top: -15px">
                        </div>
                        <div style="display: inline-block; vertical-align: baseline">
                            <a href="personal.php">如影随风</a>
                            <p>北邮信通院大四学长</p>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div style="display: inline-block;vertical-align: baseline">
                            <img src="<?php bloginfo("template_url")?>/img/avatar.png" style="margin-top: -15px">
                        </div>
                        <div style="display: inline-block; vertical-align: baseline">
                            <a href="personal.php">如影随风</a>
                            <p>北邮信通院大四学长</p>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div style="display: inline-block;vertical-align: baseline">
                            <img src="<?php bloginfo("template_url")?>/img/avatar.png" style="margin-top: -15px">
                        </div>
                        <div style="display: inline-block; vertical-align: baseline">
                            <a href="personal.php">如影随风</a>
                            <p>北邮信通院大四学长</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!--雷锋榜-->
            <div class="helper" style="margin-left: 14px">
                <div style="height: 42px">
                    <p style="font-size: large;display:inline-block;margin-top: 5%;font-weight: bold">雷锋榜</p>
                    <!--列表头-->
                    <ul id="helperTab" class="nav nav-pills" style="float: right">
                        <li><a href="#helperday" data-toggle="tab" style="width: 20px;margin-top: 5px;">日</a></li>
                        <li class="active"><a href="#helpermonth" data-toggle="tab" style="width: 20px;margin-top: 5px;">周</a></li>
                    </ul>


                    <!--                    <a href="#" style="color:gray;float: right;display: inline-block;margin-top: 5%">日</a>-->
                    <!--                    <a href="#" style="color:gray;float: right;display: inline-block;margin-top: 5%">周</a>-->
                </div>
                <!--分割线-->
                <div style="height: 2px;background-color: lightgray"></div><!--下面的是列表

                <!--列表内容 需要填写的都用php提取出来就行-->
                <div id="helperTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="helperday">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">yangtianming314</a>
                                <p style="display: inline-block;float: right">96答</p>
                            </li>
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">Sun</a>
                                <p style="display: inline-block;float: right">65答</p>
                            </li>
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">joy</a>
                                <p style="display: inline-block;float: right">65答</p>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="helpermonth">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">yangtianming314</a>
                                <p style="display: inline-block;float: right">96答</p>
                            </li>
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">yangtianming314</a>
                                <p style="display: inline-block;float: right">96答</p>
                            </li>
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">yangtianming314</a>
                                <p style="display: inline-block;float: right">96答</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!--helper-->

            <!--            好问榜-->
            <div class="asker" style="margin-left: 14px">
                <div style="height: 42px">
                    <p style="font-size: large;display:inline-block;margin-top: 5%;font-weight: bold">好问榜</p>
                    <!--列表头-->
                    <ul id="askerTab" class="nav nav-pills" style="float: right">
                        <li><a href="#askerday" data-toggle="tab" style="width: 20px;margin-top: 5px;">日</a></li>
                        <li class="active"><a href="#askermonth" data-toggle="tab" style="width: 20px;margin-top: 5px;">周</a></li>
                    </ul>


                    <!--                   <a href="#" style="color:gray;float: right;display: inline-block;margin-top: 5%">日</a>-->
                    <!--                   <a href="#" style="color:gray;float: right;display: inline-block;margin-top: 5%">周</a>-->
                </div>
                <!--分割线-->
                <div style="height: 2px;background-color: lightgray"></div><!--下面的是列表

                <!--列表内容 需要填写的都用php提取出来就行-->
                <div id="askerTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="askerday">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">yangtianming314</a>
                                <p style="display: inline-block;float: right">96问</p>
                            </li>
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">Sun</a>
                                <p style="display: inline-block;float: right">65问</p>
                            </li>
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">joy</a>
                                <p style="display: inline-block;float: right">65问</p>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="askermonth">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">yangtianming314</a>
                                <p style="display: inline-block;float: right">96问</p>
                            </li>
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">yangtianming314</a>
                                <p style="display: inline-block;float: right">96问</p>
                            </li>
                            <li class="list-group-item">
                                <img src="<?php bloginfo("template_url")?>/img/n1.png" style="display: inline-block">
                                <img src="<?php bloginfo("template_url")?>/img/smallava.png" style="display: inline-block">
                                <a href="#" style="display:inline-block;">yangtianming314</a>
                                <p style="display: inline-block;float: right">96问</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!--asker-->
        </div>
    </div>
</div>










<!--function.php-->
