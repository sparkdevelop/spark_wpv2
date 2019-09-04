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
    }

    .activity-content{
        width: 547px;height: 118px;
        background-color: #EEEEEE;
        margin-left: 21px;
        display: flex;
        align-items: center;
    }
</style>
<img src="<?php bloginfo("template_url") ?>/img/grow/shejilinian.png" style="width: 900px;height: 300px;">
<img src="<?php bloginfo("template_url") ?>/img/grow/xuexibaodian.png" style="margin-left:27px;width: 204px;height: 300px;">


<span class="subtitle-span"></span>
<p class="subtitle-text">导论课和我不得不说的故事</p>

<a id="get-more-stories" onclick="getMoreContents('hidden-stories')" style="float: right;font-size: 11px;margin-top: 47px;"> 查看更多 &gt;</a>

<p class="subtitle-sub">学长学姐有话说</p>


<div class="row">
    <?php for($idx=0; $idx < 4;$idx++){ ?>
    <div  class="col-md-3 col-sm-3 stories-content">
        <img style="width: 228px;height: 130px;" src="<?php bloginfo("template_url") ?>/img/grow/title-1.png">
        <p>这份让人成就感爆棚的工作，你要来吗？</p>

        <p  class="stories-content-sub">作者：XXX</p>
        <!--<p style="float: right;" class="stories-content-sub">阅读量：XX</p>-->
        <p style="clear:both;" class="stories-content-sub">发布于 2019年9月4日</p>
    </div>

    <?php }?>

    <?php for($idx=0; $idx < 8;$idx++){ ?>
        <div style="display: none;" class="col-md-3 col-sm-3 hidden-stories stories-content">
            <img style="width: 228px;height: 130px;" src="<?php bloginfo("template_url") ?>/img/grow/title-1.png">
            <p>这份让人成就感爆棚的工作，你要来吗？</p>

            <p  class="stories-content-sub">作者：XXX</p>
            <!--<p style="float: right;" class="stories-content-sub">阅读量：XX</p>-->
            <p style="clear:both;" class="stories-content-sub">发布于 2019年9月4日</p>
        </div>

    <?php }?>

</div>


<!---->
<span class="subtitle-span"></span>
<p class="subtitle-text">那些年，让学长学姐们怀疑人生的踩坑经历</p>
<p class="subtitle-sub">道路千万条，看完不踩坑</p>


<div class="row">
    <?php $title_idx = ['一','二','三','四','五','六'];
    for($idx=0; $idx < 6;$idx++){ ?>
        <div class="col-md-3 col-sm-3 stages-content">
            <img style="width: 68px;height: 68px;float: left;" src="<?php bloginfo("template_url") ?>/img/grow/stage<?=$idx+1?>.png">

            <p style="margin-left: 30px;">第<?=$title_idx[$idx]?>阶段</p>
        </div>

    <?php }?>
</div>

<span class="subtitle-span"></span>
<p class="subtitle-text">火花HIGH LIGHT</p>
<p class="subtitle-sub">火花空间活动回顾</p>


<div class="row">

        <div class="col-md-6 col-sm-6 activity-content">
            <p style="margin-left: 20px;font-size: 18px;float: left;">火花<br/>现场</p>

            <div style="margin-left: 60px;clear: both;">
                <a>“燎原计划”中国移动5G联创进校园北京六校创客马拉松</a><br/>
                <a>2018导论课作品展</a><br/>
                <a>信通院第二届导论课作品展颁奖仪式</a>
            </div>
        </div>


        <div class="col-md-6 col-sm-6 activity-content">
            <p style="margin-left: 20px;font-size: 18px;">火花<br/>采访</p>

            <div style="margin-left: 60px;clear: both;">
                <a>“智惠乡村”——特邀嘉宾智惠乡村志愿服务中心主任孙毅</a><br/>
                <a>采访李学华老师：工科教育，不只是一个人的战斗！</a><br/>
                <a>采访其他高校老师，关于工科学校的人文气息</a>
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