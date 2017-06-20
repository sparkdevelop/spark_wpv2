<style>
    .head-box{
        background: #f0f0f0;
        width: 100%;
        height:520px;
    }
    .head-box .banner-background{
        position: absolute;
        height: 520px;
        width: 100%;
        background-position: 55% 0;
        background-repeat: no-repeat;
        background-size: cover;
        transition: opacity 200ms ease-in-out;
    }
    .features-title{
        color: #333;
        text-decoration: none;
        padding-top: 10px;
    }
    .features-title:hover{
        color: #fe642d;
        text-decoration: none;
    }
    .features-sec{
        font-size: 20px;
        color: #b3b3b3;
        padding:5px 0 25px 0;
    }
    .front-icon{
        width:85%;
    }
    .col-md-4 .col-sm-4 .col-xs-4{
        display: inline-block;
    }
</style>

<?php
$_COOKIE["page_id"] = 0;
relation_table_install();
user_history_table_install();
favorite_table_install();
score_table_install ();
xml_table_install ();
entity_table_install ();
get_header();
?>

<div class="container-fluid" style="padding: 0;">
    <div class="head-box">
        <div class="banner-background">
            <img class="m-banner" src="<?php bloginfo("template_url")?>/img/spark_banner_m.jpg" alt=""/>
        </div>
    </div>
</div>
<!--    <div class="container" style="padding: 0">-->
<!--        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0 30px 0 0 ">-->
<!--            <img class="banner" src="--><?php //bloginfo("template_url") ?><!--/img/spark_banner.jpg"/>-->
<!--        </div>-->
<!--    </div>-->
<div class="container" id="front-page" style="padding: 50px 0; text-align: center;">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div><img class="front-icon" src="<?php bloginfo("template_url") ?>/img/wiki_icon.png"/></div>
        <a class="features-title" href="<?php echo site_url() . get_page_address('wiki');?>"><h1>wiki</h1></a>
        <p class="features-sec">“ 学习 ”</p>
        <p>知识共享：创客教育、自学资源、创新创业...<br/>协同创作：人人可免费浏览、编辑、创建wiki</p>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div><img class="front-icon" src="<?php bloginfo("template_url") ?>/img/qa_icon.png"/></div>
        <a class="features-title" href="<?php echo site_url() . get_page_address('qa');?>"><h1>问答</h1></a>
        <p class="features-sec">“ 解惑 ”</p>
        <p>专注高校硬件学习和web学习领域问答<br/>直系学长学姐和同届大神为你答疑解惑</p>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div><img class="front-icon" src="<?php bloginfo("template_url") ?>/img/project_icon.png"/></div>
        <a class="features-title" href="<?php echo get_the_permalink( get_page_by_title( '项目' )); ?>"><h1>项目</h1></a>
        <p class="features-sec">“ 致用 ”</p>
        <p>看优秀的开源项目，激发灵感，学习借鉴<br/>记录分享你的项目，让学习成长留下痕迹</p>
    </div>
</div>
<?php get_footer(); ?>
