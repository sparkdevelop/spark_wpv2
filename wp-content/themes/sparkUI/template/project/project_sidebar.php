<!--项目首页侧边栏-->
<?php
//本页面是项目首页的侧边栏。

//为全部标签做准备
global $wpdb;
$tag_id = array();
$tag_name = array();//存储每个链接的名字;
$link = array(); // 存储每个标签的链接;
$tag_count = array();
//==============获取所有tag的id信息===============

//=============================
?>

<script>
    flag=false;
    function show_all_tags() {
        var $all_tags=document.getElementById('all_tags');
        var $related_tags = document.getElementById('hot_tags');
        if(flag){
            $all_tags.style.display ="block";
            $related_tags.style.display="none";
        }else{
            $all_tags.style.display="none";
            $related_tags.style.display="block";
        }
        flag=!flag;
    }
</script>
<style>
    .label-default [href]:focus,
    .label-default [href]:hover{background-color: transparent;outline: none;color: #fe642d}
    #buttonForAllTags{  outline: none;border:0px;color:gray;float: right;display: inline-block;margin-top: 20px;padding: 0 12px}
</style>

<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <?php require "project_release_button.php"?>
    <!--<div class="sidebar_button" style="margin-top: 20px">
        <a href="http://localhost/wordpress/?page_id=199;" style="color: white">我的项目</a>
    </div><br>-->

<!--推荐项目-->
<div class="sidebar_list">
    <div class="sidebar_list_header">
        <p>推荐项目</p>
       <!-- <a id="sidebar_list_link" href="">更多</a> -->
    </div>
    <!--分割线-->
    <div class="sidebar_divline"></div>
    <!--推荐列表-->
    <ul class="list-group" style="margin-top: 10px">
        <li class="list-group-item">
            <div style="display: inline-block; vertical-align: baseline;">
                <span class="fa fa-star pull-left" style="color: red"
                <p><a href="<?php the_permalink(258); ?>">&nbsp;&nbsp;小学期创新课开放项目</a></p></span>
                <!--传浏览量-->
            </div>
        </li>
        <li class="list-group-item">
            <div style="display: inline-block; vertical-align: baseline">
                <span class="fa fa-star pull-left" style="color: red"
                <p><a href="<?php the_permalink(265); ?>">&nbsp;&nbsp;2016年导论课线上创新作品展</a></p></span>
            </div>
        </li>
        <li class="list-group-item">
            <div style="display: inline-block; vertical-align: baseline">
                <span class="fa fa-star pull-left" style="color: red"
                <p><a href="<?php the_permalink(271); ?>">&nbsp;&nbsp;2016年导论课创新作品汇报展</a></p></span>
            </div>
        </li>
        <li class="list-group-item">
            <div style="display: inline-block; vertical-align: baseline">
                <span class="fa fa-star pull-left" style="color: red"
                <p><a href="<?php the_permalink(248); ?>">&nbsp;&nbsp;猫·车 —— 一种新型的逗猫方式</a></p></span>
            </div>
        </li>
        <li class="list-group-item">
            <div style="display: inline-block; vertical-align: baseline">
                <span class="fa fa-star pull-left" style="color: red"
                <p><a href="<?php the_permalink(5); ?>">&nbsp;&nbsp;手语翻译手套</a></p></span>
            </div>
        </li>    
    </ul>
</div>

<!--热门标签-->
<div class="sidebar_list">
    <div class="sidebar_list_header">
        <p>热门标签</p>
        <!--<a id="sidebar_list_link" onclick="show_all_tags()">全部标签</a>-->
    </div>
    <!--                分割线-->
    <div class="sidebar_divline"></div>
    <!--                标签群   固定个数?  如何生成热门标签 将输入的东西换成--><?//php?><!--传入的数据-->
    <!--<div id="hot_tags" style="word-wrap: break-word; word-break: keep-all;">
            <h4>
                <?php
/*                for($i=0;$i<9;$i++){*/?>
                    <a class="label label-default" href="<?/*=$link[$i]*/?>"><?/*=$tag_name[$i]*/?><span class="badge">(<?/*=$tag_count[$i]*/?>)</span></a>
                <?php /* } */?>
            </h4>
        </div>

        <div id="all_tags" style="display: none;word-wrap: break-word; word-break: keep-all;">
            <h4>
                <?php
/*                foreach ($tag_name as $key =>$i){*/?>
                    <a class="label label-default" href="<?/*=$link[$key]*/?>"><?/*=$i*/?><span class="badge">(<?/*=$tag_count[$key]*/?>)</span></a>
                <?php /*}
                */?>
            </h4>
        </div>
    </div>-->

    <div id="article-tag" style="margin-top: 10px">
        <?php $args = array(
            'smallest'                  => 10,
            'largest'                   => 10,
            'unit'                      => 'pt',
            'number'                    => 12,
            'format'                    => 'flat',
            'separator'                 => "&nbsp",
            'orderby'                   => 'count',
            'order'                     => 'DESC',
            'exclude'                   => null,
            'include'                   => null,
            'topic_count_text_callback' => 'default_topic_count_text',
            'link'                      => 'view',
            'taxonomy'                  => 'post_tag',
            'echo'                      => true,
            'child_of'                   => null
        ); ?>
        <?php wp_tag_cloud( $args ); ?>
    </div>

</div>
</div>




