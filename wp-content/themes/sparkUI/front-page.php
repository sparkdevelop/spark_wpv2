<style>
    #myCarousel {
        background: #f0f0f0;
        width: 100%;
    }

    .carousel-inner {
        background: white;
        width: auto;
    }

    .carousel-inner .item {
        position: inherit;
        width: auto;
    }

    .carousel-inner .item img {
        display: inherit;
    }

    /*.head-box{*/
    /*background: #f0f0f0;*/
    /*width: 100%;*/
    /*height:520px;*/
    /*}*/
    /*.head-box .banner-background{*/
    /*position: absolute;*/
    /*height: 520px;*/
    /*width: 100%;*/
    /*background-position: 55% 0;*/
    /*background-repeat: no-repeat;*/
    /*background-size: cover;*/
    /*transition: opacity 200ms ease-in-out;*/
    /*}*/
    .features-title {
        color: #333;
        text-decoration: none;
        padding-top: 10px;
    }

    .features-title:hover {
        color: #fe642d;
        text-decoration: none;
    }

    .features-sec {
        font-size: 20px;
        color: #b3b3b3;
        padding: 5px 0 25px 0;
    }

    .front-icon {
        width: 85%;
    }

    .col-md-4 .col-sm-4 .col-xs-4 {
        display: inline-block;
    }
    #wiki_list_link{
        float: right;
        display: inline-block;
        font-size: 15px;
        color: #4e4e4e;
        height: 28px;
        line-height: 28px;
    }
    .wiki_list_header p{
        display: inline-block;
    }
</style>

<?php
$_COOKIE["page_id"] = 0;
relation_table_install();
user_history_table_install();
favorite_table_install();
score_table_install();
xml_table_install();
entity_table_install();
gp_table_install();
gp_verify_table_install();
gp_member_table_install();
gp_task_table_install();
gp_member_verify_tmp_table_install();
gp_task_member_table_install();
gp_member_team_table_install();
gp_task_complete_tmp_table_install();
get_header();
?>
<script>
    $(function () {
        $("#myCarousel").carousel({
            interval: 10000
        });
        if (screen.width < 480) {
            $("#webpage").css("display", "none");
            $("#mobile_front").css("display", "block");
            $("#webpage_2").css("display", "none");
            $("#mobile_front_2").css("display", "block")
        }
    });
</script>
<!--此处若想还是显示到边上的banner,则将div class="container-fluid" 移到此处-->
<div class="container-fluid" style="padding: 0;">
    <div id="myCarousel" class="carousel slide">
        <!-- 轮播（Carousel）指标 -->
        <ol class="carousel-indicators">
            <!--            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>-->
            <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>
        <!-- 轮播（Carousel）项目 -->
        <div class="carousel-inner">
            <!--            <div class="item active">-->
            <!--                <img src="--><?php ////bloginfo("template_url")?><!--/img/budao.jpg" id="webpage_2"-->
            <!--                     style="margin: 0 auto;cursor: pointer"-->
            <!--                     onclick="location.replace('--><?php ////echo site_url() . get_page_address('budao_index')?>
            <!--                ')"/>-->
            <!--                <img src="-->
            <?php ////bloginfo("template_url")?><!--/img/budao_m.jpg" id="mobile_front_2"-->
            <!--                     style="margin: 0 auto;display: none"-->
            <!--                     onclick="location.replace('--><?php ////echo site_url() . get_page_address('budao_index')?>
            <!--                ')"/>-->
            <!--            </div>-->
            <div class="item active">
                <img src="<?php bloginfo("template_url") ?>/img/spark_banner.jpg" id="webpage"
                     style="margin: 0 auto;cursor: pointer"
                     onclick="location.replace('<?php echo site_url() ?>')"/>
                <img src="<?php bloginfo("template_url") ?>/img/spark_banner_m.jpg" id="mobile_front"
                     style="margin: 0 auto; display: none"
                     onclick="location.replace('<?php echo site_url() ?>')"/>
            </div>

        </div>
    </div>
</div>
<div class="container" id="front-page" style="padding: 50px 0 0 0;">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div><img class="front-icon" src="<?php bloginfo("template_url") ?>/img/wiki_icon.png"/></div>
    </div>
    <div class="wiki_list col-md-8 col-sm-8 col-xs-12" style="display: inline-block">
        <div class="wiki_list_header">
            <p style="font-size: 20px">热门Wiki</p>
            <a id="wiki_list_link" href="<?php echo site_url() . get_page_address('wiki_index'); ?>">更多Wiki>></a>
        </div>
        <!--分割线-->
        <div class="divline" style="margin-top: 0px"></div>
        <!--推荐列表-->
        <?php
        $wiki_item = array([235,'导论实验课',get_wiki_watched_nums(235)],
            [239,'Unit1：开源硬件与Web编程入门',get_wiki_watched_nums(239)],
            [1191,'Unit2：计算机和微机实验',get_wiki_watched_nums(1191)],
            [540,'Unit3：电路基础实验',get_wiki_watched_nums(540)],
            [1202,'Unit4：网络基础实验',get_wiki_watched_nums(1202)],
            [979,'Unit5: 复杂工程进阶实验',get_wiki_watched_nums(979)],
            [13476,'Unit6: 工程认知与创新素质培养',get_wiki_watched_nums(13476)]
            )
        ?>
        <ul class="list-group" style="margin-bottom: 0px">
            <?php
                foreach ($wiki_item as $key => $value){?>
                    <li class="list-group-item">
                        <div style="display: inline-block; vertical-align: baseline;">
                            <a href="<?php the_permalink($value[0]); ?>" style="color: #4e4e4e;">
                                <span style="color: #fe642d">【导论实验课】</span><?=$value[1]?>
                                <? if ($key==4){?>
                                    <span>
                                        &nbsp;->&nbsp;<a href="http://sice.owvlab.net/openlab/jsj">网络虚拟仿真实验平台入口</a>
                                    </span>
                                <?php } ?>
                            </a>
                            <!--传浏览量-->
                        </div>
                        <div style="display: inline-block;float: right; margin-right: 30px;">
                            <?=$value[2]?>次
                        </div>
                    </li>
            <?php }
            ?>
        </ul>
    </div>
</div>
<div class="container" id="front-page" style="padding: 50px 0 0 0;">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div><img class="front-icon" src="<?php bloginfo("template_url") ?>/img/qa_icon.png"/></div>
    </div>
    <div class="wiki_list col-md-8 col-sm-8 col-xs-12" style="display: inline-block">
        <div class="wiki_list_header">
            <p style="font-size: 20px">热门问答</p>
            <a id="wiki_list_link" href="<?php echo site_url() . get_page_address('qa'); ?>">更多问答>></a>
        </div>
        <!--分割线-->
        <div class="divline" style="margin-top: 0px"></div>
        <!--推荐列表-->
        <?php
        $qa_item = array([236,'关于程序上传和代码出错的一些总结',dwqa_question_views_count(236)],
                          [492,'→→→→→→→网络工程实验←←←←←←不信你们看不见',dwqa_question_views_count(492)],
                          [3603,'【反馈】火花空间&通信导论课反馈帖',dwqa_question_views_count(3603)],
                          [477,'[集合贴]导论课反馈汇总(无法解决的问题都来这里吧)',dwqa_question_views_count(477)],
                          [473,'[集合贴]【必看】导论课实验问题汇总（更新舵机电机问题）',dwqa_question_views_count(473)],
                          [5296,'关于微信小程序后台服务器的搭建',dwqa_question_views_count(5296)])
        ?>
        <ul class="list-group" style="margin-bottom: 0px">
            <?php
            foreach ($qa_item as $value){?>
                <li class="list-group-item">
                    <div style="display: inline-block; vertical-align: baseline;">
                        <a href="<?php the_permalink($value[0]); ?>" style="color: #4e4e4e;">
                            <?=$value[1]?>
                        </a>
                        <!--传浏览量-->
                    </div>
                    <div style="display: inline-block;float: right; margin-right: 30px;">
                        <?=$value[2]?>次
                    </div>
                </li>
            <?php }
            ?>
        </ul>
    </div>
</div>
<div class="container" id="front-page" style="padding: 50px 0 50px 0;">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div><img class="front-icon" src="<?php bloginfo("template_url") ?>/img/project_icon.png"/></div>
    </div>
    <div class="wiki_list col-md-8 col-sm-8 col-xs-12" style="display: inline-block">
        <div class="wiki_list_header">
            <p style="font-size: 20px">热门项目</p>
            <a id="wiki_list_link" href="<?php echo get_the_permalink( get_page_by_title( '项目' )); ?>">更多项目>></a>
        </div>
        <!--分割线-->
        <div class="divline" style="margin-top: 0px"></div>
        <!--推荐列表-->
        <?php
        $pro_item = array([248,'猫·车 —— 一种新型的逗猫方式',getProjectViews(248)],
                          [5,'手语翻译手套',getProjectViews(5)],
                          [1270,'自动倒桩入库小车',getProjectViews(1270)],
                          [258,'小学期创新课开放项目',getProjectViews(258)],
                          [265,'2016年导论课线上创新作品展',getProjectViews(265)],
                          [271,'2016年导论课创新作品汇报展',getProjectViews(271)])
        ?>
        <ul class="list-group" style="margin-bottom: 0px">
            <?php
            foreach ($pro_item as $value){?>
                <li class="list-group-item">
                    <div style="display: inline-block; vertical-align: baseline;">
                        <a href="<?php the_permalink($value[0]); ?>" style="color: #4e4e4e;">
                            <?=$value[1]?>
                        </a>
                    </div>
                    <!--传浏览量-->
                    <div style="display: inline-block;float: right; margin-right: 30px;">
                        <?=$value[2]?>次
                    </div>
                </li>
            <?php }
            ?>
        </ul>
    </div>
</div>
<?php get_footer(); ?>
