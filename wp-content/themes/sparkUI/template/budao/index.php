<?php
/**
 * 布道大赛的主页
 */
$admin_url = admin_url('admin-ajax.php');
$official_group = get_group(get_group_id_by_name($budao_official))[0];
?>
<style>
    .group_name {color: #333;}
    .group_name:hover{text-decoration: none;  color: #fe642d;}
    #content{
        font-size: 15px;width: 95%;margin: 0px auto;margin-top: 10px;margin-bottom: 10px;
    }
    #h_title{
        margin-top: 20px;
    }

</style>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <div id="group-ava" style="display: none">
        <img src="<?= $official_group['group_cover'] ?>" style="width: 85px;height: 85px"></div>
    <div id="group-info" style="display: none;margin-left: 20px">
        <div class="group_title">
            <?php
            if ($official_group['group_status'] == "close") {
                if (get_current_user_id() != $author) { ?>
                    <a class="group_name" href="#group-info"><h4><?= $official_group['group_name'] ?></h4></a>
                <?php } else { ?>
                    <a class="group_name"
                       href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $official_group['ID']; ?>">
                        <h4><?= $official_group['group_name'] ?></h4>
                    </a>
                <?php } ?>
            <?php } else { ?>
                <a class="group_name"
                   href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $official_group['ID']; ?>">
                    <h4><?= $official_group['group_name'] ?></h4>
                </a>
            <?php } ?>
        </div>
        <div class="group_abs">
            <?php echo $official_group['group_abstract']; ?>
        </div>
        <div class="group_others">
            <?php
            if (is_group_member($official_group['ID'])) {
                echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">已加入</span>&nbsp;&nbsp;';
            } elseif ($official_group['group_status'] == "close") {
                echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">已关闭</span>&nbsp;&nbsp;';
            } else {
                $verify_type = get_verify_type($official_group['ID']);
                $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $official_group['ID'];
                if ($verify_type == 'verifyjoin') { ?>
                    <button id="group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                <?php } else { ?>
                    <button id="group_join_btn"
                            onclick="join_the_group(<?= $official_group['ID'] ?>,'<?= $admin_url ?>')">加入
                    </button>&nbsp;&nbsp;
                <?php }
            }
            ?>
            <span><?= $official_group['member_count'] ?>个成员</span>&nbsp;&nbsp;
            <span>管理员</span>
            <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $author; ?>"
               style="color: #169bd5"><?php echo get_author_name($author) ?></a>
        </div>
    </div>
<!--    <div class="divline"></div>-->
    <h3 style="text-align: center">布道师大赛细则</h3>
    <div class="divline"></div>
    <h4 id="h_title">大赛介绍:</h4>
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
    <h4 id="h_title">参赛时间:</h4>
    <div id="content">2017年9月29日——2017年11月30日(共9个教学周)</div>
    <h4 id="h_title">参赛人员:</h4>
    <div id="content">面向北京邮电大学全日制本科一年级学生</div>
    <h4 id="h_title">赛程设置:</h4>
    <div id="content">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        1. 学习阶段：征集60名学生成为第一批布道师，在火花空间上注册并查看“布道师大赛”专栏上发布的学习任务，利用火花空间学习相关知识，并在腾讯云平台开发者实验室完成相关实验。
        <br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        2. 布道阶段：60名布道师通过火花空间“布道师大赛”专栏下的“创建布道群组”功能创建自己的群组，并调动自身社会资源吸引志同道合的小伙伴构建团队，再将自己所学知识传授给团队内成员。群组每增加一名成员积1分(成员人数无限制)。
        注意：已加入到某一“布道群组”中的成员可以根据自身意愿创建自己的“布道群组”，申请成为新的“布道师”，获取布道阶段积分。
        <br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        3. 比赛阶段： 布道师完成团队创建和相应知识学习后，可在火花空间上申请参加“QCloud创客布道师挑战赛”，完成本阶段挑战赛相应任务要求。挑战赛根据布道师发展团队成员积分和团队完成比赛项目情况进行量化评价，挑战赛一共分为三次，每次的奖励机制不同。
    </div>
    <h4 id="h_title">奖励机制:</h4>
    <div id="content">
        ·第一次挑战赛：得分前10名的“布道师”可获得腾讯公司提供的价值65元的腾讯云平台实验代金券(即1个月的云平台服务)。
        <br><br>
        ·第二次挑战赛：得分前10名的“布道师”可获得腾讯公司提供的价值65元的腾讯云平台实验代金券(即1个月的云平台服务)。
        <br><br>
        ·第三次挑战赛：得分第1名的“布道师”可获得腾讯公司提供的价值343元的腾讯云平台实验代金券(即6个月的云平台服务)；得分第2、3名的“布道师”可获得腾讯公司提供的价值195元的腾讯云平台实验代金券(即3个月的云平台服务)；得分第4、5、6名的“布道师”可获得腾讯公司提供的价值65元的腾讯云平台实验代金券(即1个月的云平台服务)。
    </div>
    <h5 style="text-align: center;margin-top: 30px">说明：本次活动最终解释权归北京邮电大学信息与通信工程学院所有。</h5>
</div>

