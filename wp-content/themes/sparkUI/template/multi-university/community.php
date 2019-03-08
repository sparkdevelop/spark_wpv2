<?php
global $wpdb;
$sql = "select post_id,uvs_short from wp_ms WHERE ID IN (1,15,16,17,19,20,21)";
$result = $wpdb->get_results($sql);
$url = site_url().get_page_address('join_ms');
$url_experiment = get_permalink(get_the_ID_by_title('精简版端到端实验'));
$experiment_2019 = get_permalink(get_the_ID_by_title('2019多校燎原计划——腾讯云AI+小程序'));
?>
<style>
    .school-entry-class img {
        width: 100%;
        height: 100%;
        border: 1px solid lightgray;
        border-radius: 10px;
    }

    .school-entry-class {
        padding: 20px 10px;
    }
</style>
<script>
    function join_ms() {
        layer.open({
            type: 2,
            title: "填写学校信息",
            content: "<?=$url?>",
            area: ['30%','66%'],
            closeBtn:1,
            shadeClose:true,
            shade:0.5,
            end:function () {}
        })
    }
</script>
<div id="community_index">
    <h3 style="display:inline;margin-top: 10px">燎原计划</h3>
    <span style="display: block;margin: 20px 20px">
        <a style="display: inline;font-size: 18px;margin: 20px 0px;cursor: pointer" onclick="window.open('<?=$experiment_2019?>')">2019多校燎原计划</a>
        <a style="display: inline;font-size: 18px;margin: 20px 20px;cursor: pointer" onclick="window.open('<?=$url_experiment?>')">2018精简版端到端实验</a>
    </span>
    <h3 style="display:inline;margin-top: 10px">入驻高校</h3>
    <?php
    if(current_user_can( 'manage_options' )){
        /* 加入一个学校要先建立对应学校的wiki,手动,然后加入到ms表,在这里添加*/
        ?>
        <button class="btn btn-green" style="display: inline;height:33px;margin:0 20px;vertical-align: bottom" onclick="join_ms()">加入</button>
    <? }

    ?>

    <ul class="list-group">
        <?php
        $size = sizeof($result);
        //$size = 0;
        for ($i = 0; $i < $size; $i++) {
            if ($i >= 9){?>
                <style>
                    #school-entry-<?=$i?>{
                        display: none;
                    }
                </style>
            <?php } ?>
            <li class="list-group-item col-md-3 col-sm-3 col-xs-6 school-entry-class" id="school-entry-<?=$i?>">
                <img src="<?=bloginfo('template_url')."/img/univerisity-logo/".strtoupper($result[$i]->uvs_short).".png"?>"
                onclick="window.open('<?php the_permalink($result[$i]->post_id)?>')" style="cursor: pointer;padding:5px;">
            </li>
        <?php } ?>
        <style>
            .more{
                margin-top: 10px;
                height: 36px;
                line-height: 36px;
                text-align: center;
                font-size: 20px;
                cursor: pointer;
                color: #fe642d;
            }
        </style>
        <div style="clear: both"></div>
<!--        <div class="more">显示全部高校</div>-->
    </ul>

<!--    <h3>联盟简介</h3>-->
<!--    我们对学生的希望：<br><br>-->
<!--    自学的能力是最重要的能力；<br>-->
<!--    要让学生有终身学习的意识与习惯；<br>-->
<!--    学生毕业的时候对自己有信心。<br><br>-->
<!---->
<!--    <b>对应的我们就需要创新、需要冒险，要“做到以往没想过的、认为不可能的”。</b>-->
</div>
<script>
    $(document).on('click','.more',function () {
        $(".school-entry-class").css('display','block');
        $(".more").css('display','none')
    })
</script>
