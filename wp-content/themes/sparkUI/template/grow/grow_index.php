<style>
    .subtitle-span{
        float:left;width: 9px;height: 29px; background: #ff9800;margin-top: 47px;
    }

    .subtitle-text{
        font-size: 20px;margin-top: 47px;margin-left: 15px;
        float: left;
    }

    .subtitle-sub{
        color: #646464;
        font-size: 14px;
        margin-left: 25px;
        clear: both;
    }

    .stories-content{
        margin-left:20px;width: 263px;height:244px;border: lightgray solid 3px;
        cursor: pointer;
    }

    .stories-content-sub{
        font-size: 10px;
        float: left;
    }

    .hidden-stories{
        margin-top: 10px;
    }

    .stages-content{
        width: 264px;height: 100px;
        background-color: #EEEEEE;
        margin-top: 16px;
        margin-left: 19px;
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .activity-content{
        width: 547px;height: 118px;
        background-color: #EEEEEE;
        margin-left: 21px;
        display: flex;
        align-items: center;
    }
</style>


<img onclick="window.open('https://www.oursparkspace.cn/?yada_wiki=导论课设计理念');" onmouseover="$(this).css('opacity',0.5);" onmouseout="$(this).css('opacity',1);" src="<?php bloginfo("template_url") ?>/img/grow/shejilinian.png" style="cursor:pointer;width: 900px;height: 300px;">
<img onclick="window.open('<?=site_url().get_page_address('preparing_page') ?>');" src="<?php bloginfo("template_url") ?>/img/grow/xuexibaodian.png" style="margin-left:27px;width: 204px;height: 300px;">

<!-- 成长型思维介绍 -->
<span class="subtitle-span"></span>
<p class="subtitle-text">成长型思维</p>

<p class="subtitle-sub">了解成长型思维，激发你的无限潜能</p>

<div class="row" >
    <div onclick="window.open('https://oursparkspace.cn/?page_id=89295')" class="col-md-3 col-sm-3 stories-content">
        <img style="width: 228px;height: 130px;" src="<?php bloginfo("template_url") ?>/img/grow/introduce.jpg">
        <p style="height: 40px;">这两种思维模式，你了解吗</p>

        <p  class="stories-content-sub">作者：红领巾</p>
        <!--<p style="float: right;" class="stories-content-sub">阅读量：XX</p>-->
        <p style="clear:both;" class="stories-content-sub">发布于 2020-06-30</p>
    </div>
    <div onclick="window.open('http://oursparkspace.cn/?page_id=89403')" class="col-md-3 col-sm-3 stories-content">
        <img style="width: 228px;height: 130px;" src="<?php bloginfo("template_url") ?>/img/grow/ceshi.jpeg">
        <p style="height: 40px;">快来测测自己的思维模式吧！</p>

        <p  class="stories-content-sub">作者：红领巾</p>
        <!--<p style="float: right;" class="stories-content-sub">阅读量：XX</p>-->
        <p style="clear:both;" class="stories-content-sub">发布于 2020-06-30</p>
    </div>
    <div onclick="window.open(' http://oursparkspace.cn/?page_id=89382')" class="col-md-3 col-sm-3 stories-content">
        <img style="width: 228px;height: 130px;" src="<?php bloginfo("template_url") ?>/img/grow/brain.jpg">
        <p style="height: 40px;">大脑如同肌肉，也会成长！</p>

        <p  class="stories-content-sub">作者：红领巾</p>
        <!--<p style="float: right;" class="stories-content-sub">阅读量：XX</p>-->
        <p style="clear:both;" class="stories-content-sub">发布于 2020-06-30</p>
    </div>
    <div onclick="window.open(' http://oursparkspace.cn/?page_id=89397 ')" class="col-md-3 col-sm-3 stories-content">
        <img style="width: 228px;height: 130px;" src="<?php bloginfo("template_url") ?>/img/grow/method.jpeg">
        <p style="height: 40px;">成长型思维可以培养吗？</p>

        <p  class="stories-content-sub">作者：红领巾</p>
        <!--<p style="float: right;" class="stories-content-sub">阅读量：XX</p>-->
        <p style="clear:both;" class="stories-content-sub">发布于 2020-06-30</p>
    </div>

</div>

<!--导论课故事  部分-->
<span class="subtitle-span"></span>
<p class="subtitle-text">成长案例展示</p>


<a id="get-more-stories" onclick="getMoreContents('hidden-stories')" style="float: right;font-size: 11px;margin-top: 47px;"> 查看更多 &gt;</a>

<p class="subtitle-sub">学长学姐有话说</p>


<div class="row" >
    <?php $stories_titles = ['这份让人成就感爆棚的工作，你要来吗？',
        '多面少年，你pick哪一面？',
        '大二的她：有上千号粉丝的布道师',
        '大一宿舍中诞生的创客团队',
        '助教故事——剡恺',
        '助教故事——伊甸',
        '【鱼家】——冯昕澳',
        '【盲点】——刘辰尧',
        '【盲点】——井一诺',
        '超可爱的整蛊狗团队故事'];
    $stories_authors = ['红领巾','红领巾','红领巾','红领巾','红领巾','红领巾','红领巾','红领巾','红领巾','红领巾'];
    $stories_dates = ['2018-05-23','2018-06-07','2018-05-15','2018-05-14','2018-06-07','2018-06-07','2018-06-07','2018-06-11','2018-06-09','2017-12-25'];

    $stories_links = site_url().get_page_address('grow_stories_content');


    for($idx=0; $idx < 4;$idx++){ ?>
    <div onclick="window.open('<?=$stories_links ?>&param=<?=$idx+1 ?>')" class="col-md-3 col-sm-3 stories-content">
        <img style="width: 228px;height: 130px;" src="<?php bloginfo("template_url") ?>/img/grow/title-<?=$idx+1?>.png">
        <p style="height: 40px;"><?=$stories_titles[$idx] ?></p>

        <p  class="stories-content-sub">作者：<?=$stories_authors[$idx] ?></p>
        <!--<p style="float: right;" class="stories-content-sub">阅读量：XX</p>-->
        <p style="clear:both;" class="stories-content-sub">发布于 <?=$stories_dates[$idx] ?></p>
    </div>

    <?php }?>

    <?php if(sizeof($stories_titles) > 4) {
        for ($idx = 4; $idx < sizeof($stories_titles); $idx++) { ?>
            <div style="display: none;" onclick="window.open('<?=$stories_links ?>&param=<?=$idx+1 ?>')" class="col-md-3 col-sm-3 hidden-stories stories-content">
                <img style="width: 228px;height: 130px;" src="<?php bloginfo("template_url") ?>/img/grow/title-<?=$idx+1?>.png">
                <p style="height: 40px;"><?=$stories_titles[$idx] ?></p>

                <p  class="stories-content-sub">作者：<?=$stories_authors[$idx] ?></p>
                <!--<p style="float: right;" class="stories-content-sub">阅读量：XX</p>-->
                <p style="clear:both;" class="stories-content-sub">发布于 <?=$stories_dates[$idx] ?></p>
            </div>

        <?php }
    }?>

</div>

<p class="subtitle-sub"  style="margin-top:20px;">成长感悟</p>
<div class="row">
<div onclick="window.open(' http://oursparkspace.cn/?page_id=89418');" class="col-md-3 col-sm-3 stages-content">
    <img style="width: 68px;height: 68px;float: left;" src="<?php bloginfo("template_url") ?>/img/grow/ganwu.jpg">
    <p style="margin-left: 30px;">内蒙古师范大学课程感悟（一）</p>
</div>
<div onclick="window.open(' http://oursparkspace.cn/?page_id=89425');" class="col-md-3 col-sm-3 stages-content">
    <img style="width: 68px;height: 68px;float: left;" src="<?php bloginfo("template_url") ?>/img/grow/ganwu.jpg">
    <p style="margin-left: 30px;">内蒙古师范大学课程感悟（二）</p>
</div>
</div>

<!--踩坑经历  部分-->
<p class="subtitle-sub" style="margin-top:20px;">那些年，让学长学姐们怀疑人生的踩坑经历</p>

<div class="row">
    <?php $title_idx = ['一','二','三','四','五','六'];
    $links = ['https://www.oursparkspace.cn/?yada_wiki=1539591196',
        'https://www.oursparkspace.cn/?yada_wiki=1568188996',
        'https://www.oursparkspace.cn/?yada_wiki=1540515851',
        'https://www.oursparkspace.cn/?yada_wiki=1540976613',
        'https://www.oursparkspace.cn/?yada_wiki=1541509887',
        'https://www.oursparkspace.cn/?page_id=71970&param=4'];

    for($idx=0; $idx < 6;$idx++){ ?>
        <div onclick="window.open('<?=$links[$idx] ?>');" class="col-md-3 col-sm-3 stages-content">
            <img style="width: 68px;height: 68px;float: left;" src="<?php bloginfo("template_url") ?>/img/grow/stage<?=$idx+1?>.png">

            <p style="margin-left: 30px;">第<?=$title_idx[$idx]?>阶段</p>
        </div>

    <?php }?>
</div>

<!--偕成长  部分-->
<span class="subtitle-span"></span>
<p class="subtitle-text">“偕成长”小程序</p>
<p class="subtitle-sub">通往成长型思维的道路是一段旅程，不是一个宣言</p>
<div class="row">
<div class="col-md-6 col-sm-6" style="width: 547px;height: 250px;background-color: #EEEEEE;margin-left: 21px;display: flex;align-items: center;">
<div style="margin-left: 25px;margin-top: 10px;">成长型思维的培养需要科学系统的方法，“偕成长”小程序可以帮助更多人采用成长型思维，
而非固定型思维，过上注重学习与成长的生活。扫描右侧二维码进行体验吧~培养自己的成长型思维~</div>
<img style="width: 200px;height: 200px;margin-left: 25px;" src="<?php bloginfo("template_url") ?>/img/grow/logo.jpg">
</div>
</div>

<!--火花HIGH LIGHT  部分-->
<span class="subtitle-span"></span>
<p class="subtitle-text">火花HIGH LIGHT</p>
<p class="subtitle-sub">火花空间活动回顾</p>


<div class="row">

        <div class="col-md-6 col-sm-6 activity-content">
            <p style="margin-left: 20px;font-size: 18px;float: left;">火花<br/>现场</p>

            <div style="margin-left: 60px;clear: both;">
                <a href="https://mp.weixin.qq.com/s/_XMyUhgXuE22qewOc8MfIw">“燎原计划”中国移动5G联创进校园北京六校创客马拉松</a><br/>
                <!--<a>2018导论课作品展</a><br/>
                <a>信通院第二届导论课作品展颁奖仪式</a>-->
                <a href="https://mp.weixin.qq.com/s/aI0q20ikjFzLXMMAaJ3NmA">“好学长奖”提升北邮新生幸福指数</a>
            </div>
        </div>


        <div class="col-md-6 col-sm-6 activity-content">
            <p style="margin-left: 20px;font-size: 18px;">火花<br/>采访</p>

            <div style="margin-left: 60px;clear: both;">
                <!--<a>“智惠乡村”——特邀嘉宾智惠乡村志愿服务中心主任孙毅</a><br/>
                <a>采访李学华老师：工科教育，不只是一个人的战斗！</a><br/>-->
                <a href="https://mp.weixin.qq.com/s/SsP2TDADqLRJu0Q5MKlXHA">采访其他高校老师，关于工科学校的人文气息</a>
            </div>
        </div>
</div>

<script>
    function getMoreContents(className) {
        //$('.hidden-stories').show();
        if($('.'+className).css('display') == 'none') {
            $('.' + className).show();
            $('#get-more-stories').text('<收起');
        }else {
            $('.' + className).hide();
            $('#get-more-stories').text('查看更多>');
        }
    }

</script>