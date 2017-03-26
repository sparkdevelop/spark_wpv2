<!--提问按钮ok-->

<?php
global $wpdb;
$page_ask_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = 'ask'");
$ask_page_ID="?page_id=".$page_ask_id;
?>

<div class="sidebar_button" style="margin-top: 20px">
    <a href="<?php echo site_url().$ask_page_ID;?>" style="color: white">我要提问</a>
</div>
<!--热门标签-->
<div class="sidebar_list">
    <div class="sidebar_list_header">
        <p style="font-size: large;display:inline-block;margin-top: 5%;font-weight: bold">热门标签</p>
        <a href="tag.php" style="color:gray;float: right;display: inline-block;margin-top: 5%">全部标签</a>
    </div>
    <!--                分割线-->
    <div class="sidebar_divline"></div>
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
<div class="sidebar_list">
    <div class="sidebar_list_header">
        <p style="font-size: large;display:inline-block;margin-top: 5%;font-weight: bold">助教团</p>
        <a href="#" style="color:gray;float: right;display: inline-block;margin-top: 5%">加入</a>
    </div>
    <!--分割线-->
    <div class="sidebar_divline"></div>
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

<!--雷锋榜ok-->
<div class="sidebar_list">
    <div class="sidebar_list_header">
        <p>雷锋榜</p>
        <!--列表头-->
        <ul id="helperTab" class="nav nav-pills" style="float: right">
            <li class="active"><a href="#helperday" data-toggle="tab" style="width: 20px;margin-top: 5px;">日</a></li>
            <li><a href="#helpermonth" data-toggle="tab" style="width: 20px;margin-top: 5px;">周</a></li>
        </ul>
    </div>
    <!--分割线 下面的是列表-->
    <div class="sidebar_divline"></div>
    <!--列表内容 需要填写的都用php提取出来就行-->
    <div id="helperTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="helperday">
            <ul class="list-group">
                <?php
                $from_day=strtotime("-1 day")+8*3600;
                $answer_most =array();
                $answer_most=dwqa_user_most_answer(10,$from_day);
                $answer_most_author_id = $answer_most[0]['post_author'];
                for($i=0;$i<10;$i++){
                    ?>
                    <li class="list-group-item">
                    <img src="<?php bloginfo("template_url")?>/img/n<?php echo $i+1;?>.png" style="display: inline-block;margin-right: 10px;">
                    <?php echo get_avatar($answer_most[$i]['post_author'],20,'');?>
                    <a href="<?php echo dwqa_get_author_link($answer_most[$i]['post_author']);?>" style="display:inline-block;"><?php echo get_userdata($answer_most[$i]['post_author'])->display_name;?></a>
                        <p style="display: inline-block;float: right"><?php echo $answer_most[$i]['answer_count'];?>答</p>
                </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="tab-pane fade" id="helpermonth">
            <ul class="list-group">
                <?php
                $from_week=strtotime("-1 week")+8*3600;
                $answer_most_this_week = array();
                $answer_most_this_week = dwqa_user_most_answer(10,$from_week);
                //$answer_most_this_week_author_id = $answer_most_this_week[0]['post_author'];
                for($i=0;$i<10;$i++){
                    ?>
                    <li class="list-group-item">
                        <img src="<?php bloginfo("template_url")?>/img/n<?php echo $i+1;?>.png" style="display: inline-block;margin-right: 10px;"/>
                        <?php echo get_avatar($answer_most_this_week[$i]['post_author'],20,'');?>
                        <a href="<?php echo dwqa_get_author_link($answer_most_this_week[$i]['post_author']);?>" style="display:inline-block;">
                            <?php echo get_userdata($answer_most_this_week[$i]['post_author'])->display_name;?>
                        </a>
                        <p style="display: inline-block;float: right"><?php echo $answer_most_this_week[$i]['answer_count'];?>答
                        </p>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div><!--helper-->

<!--好问榜-->
<div class="sidebar_list">
    <div class="sidebar_list_header">
        <p>好问榜</p>
        <!--列表头-->
        <ul id="askerTab" class="nav nav-pills" style="float: right">
            <li><a href="#askerday" data-toggle="tab" style="width: 20px;margin-top: 5px;">日</a></li>
            <li class="active"><a href="#askermonth" data-toggle="tab" style="width: 20px;margin-top: 5px;">周</a></li>
        </ul>
    </div>
    <!--分割线-->
    <div class="sidebar_divline"></div><!--下面的是列表

    <!--列表内容 需要填写的都用php提取出来就行-->
    <div id="askerTabContent" class="tab-content">
        <div class="tab-pane fade" id="askerday">
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
        <div class="tab-pane fade in active" id="askermonth">
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