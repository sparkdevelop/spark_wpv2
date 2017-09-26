<?php
/**
 * 布道大赛的主页
 */
$admin_url = admin_url('admin-ajax.php');
$official_group = get_group(get_group_id_by_name($budao_official))[0];
?>
<script>
    function verify_create_group($url) {
        layer.open({
            type: 2,
            title: "填写验证字段",
            content: $url,
            area: ['30%', '66%'],
            closeBtn: 1,
            shadeClose: true,
            shade: 0.5,
            end: function () {
            }
        })
    }
</script>
<style>
    #content {
        font-size: 15px;
        width: 80%;
        margin: 0px auto;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    #h_title {
        margin-top: 20px;
    }

    .budao_index_banner {
        background-color: #efefef;
        color: #fe642d;
        text-align: center;
        width: 80%;
        border-radius: 5px;
        height: 30px;
        margin: 0 auto;
        margin-top: 25px;
        margin-bottom: 20px;
    }
    .budao_index_banner p{
        color: #fe642d;
        font-size: 17px;
        vertical-align: middle;
        line-height: 30px;
    }

    .budao_join_button {
        border: 2px solid #fe642d;
        text-align: center;
        width: 15%;
        height: 45px;
        font-size: 20px;
        margin-top: 0px;
        background-color: transparent;
        color: #fe642d;
        border-radius: 22px;
    }

</style>
<div id="budao_rules">
    <div style="text-align: center;margin-top: 50px">
        <img src="<?php echo get_template_directory_uri() ?>/img/budao/budao_index_title.png">
    </div>
    <div style="text-align: center;margin-top: 30px">
        <?php if (is_user_logged_in()) {
            $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $official_group['ID']; ?>
            <button class="budao_join_button" onclick="verify_create_group('<?= $verify_url ?>')">
                点 击 报 名
            </button>
        <?php } else { ?>
            <button class="budao_join_button" onclick="location='<?php echo wp_login_url(get_permalink())?>'">
                点 击 报 名
            </button>
        <?php } ?>
    </div>
    <div style="margin: 0 auto;width:33%;margin-top: 20px;">
        <p style="color: grey">报名并加入 <span style="font-weight: bolder">腾讯云@沙邮-布道师大赛</span> 群组 get比赛任务</p>
    </div>

    <div class="budao_index_banner">
        <p>大 赛 简 介</p>
    </div>

    <div id="content">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        2017年，人工智能、互联网+、创业创新、新工科等等一系列的技术、教育、社会变化纷至沓来，这既给刚刚荣升大一的你们赋予了更重的使命，同时也为你们未来的发展提供了前所未有的良机。刚步入北邮校园的你们，可能迫切地需要融入大学生活，感受北邮的校园文化，让自己在人群中脱颖而出，实现价值。参加布道师大赛，对你们来说，将是一次绝佳的机会！
        <br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        何为布道师？这是一个特殊的创客团队，拥有两方面的特质：一是热爱动手实践、开源分享的创客文化；二是愿意宣传推广并亲自指导，吸引更多的人加入创客阵营。你们也许会问：“之前没有基础是否也能参加布道师大赛？”答案是肯定的！布道师需要的，是一颗热爱学习、勇于实践的心，和无私分享自己的学习经验，帮助他人享受创客文化的精神。
        <br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        布道师大赛将在你们中挑选出善于学习并乐于传播知识文化的佼佼者，除了让大一的你们尽早学习到先进的技术，更重要的是让你们体验自主学习和团队协作的魅力，这将是一段令人难忘和终身受益的经历。各位同学刚刚大一，专业知识欠缺是不可避免的事情，因此本次大赛将一共分为三个时间段进行，每个时间段细分为三个阶段。不同的时间段对应不同的任务，当然，任务的难度将会逐渐增加。这样合理地带领大家一步一步地掌握知识和技能，最终成为一个合格的布道师。
    </div>
    <div class="budao_index_banner">
        <p>参 赛 人 员</p>
    </div>
    <div id="content" style="margin: 0 auto;width: 25%">面向北京邮电大学全日制本科一年级学生</div>
    <div class="budao_index_banner">
        <p>赛 程 设 置</p>
    </div>
    <div style="text-align: center;margin-top: 50px;margin-bottom: 50px">
        <img src="<?php echo get_template_directory_uri() ?>/img/budao/budao_index_liuc.png"
             style="width:80%;">
    </div>
    <div class="budao_index_banner">
        <p>大 赛 奖 励</p>
    </div>
    <div id="content">
        ·第一次挑战赛：得分前10名的“布道师”可获得腾讯公司提供的价值65元的腾讯云平台实验代金券(即1个月的云平台服务)。
        <br><br>
        ·第二次挑战赛：得分前10名的“布道师”可获得腾讯公司提供的价值65元的腾讯云平台实验代金券(即1个月的云平台服务)。
        <br><br>
        ·第三次挑战赛：得分第1名的“布道师”可获得腾讯公司提供的价值343元的腾讯云平台实验代金券(即6个月的云平台服务)；得分第2、3名的“布道师”可获得腾讯公司提供的价值195元的腾讯云平台实验代金券(即3个月的云平台服务)；得分第4、5、6名的“布道师”可获得腾讯公司提供的价值65元的腾讯云平台实验代金券(即1个月的云平台服务)。
    </div>

    <h5 style="color:#fe642d;text-align: center;margin-top: 30px">说明：本次活动最终解释权归火花空间所有。</h5>

</div>




