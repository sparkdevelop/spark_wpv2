<?php
/**
 *  本页面是footer部分的解释说明部分
 *  sidebar导航
 */
$tab = isset($_GET['tab']) && !empty($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'about';
?>
<script>
    $(function () {
        $("#contact").removeClass("active");
        $("#<?=$tab?>").addClass("active");
    });
</script>
<style>
    #contact_index {
        text-align: center;
        height: -webkit-fill-available;
    }

    #contact_index > li {
        margin: 10px 0px;
        font-size: 20px;
    }

    #about_title {
        margin-top: 20px;
        font-size: 20px;
    }
    #about_us{
        width: 90%;
        margin: 0 auto;
    }
    #about_content{
        margin-top: 10px;
    }

</style>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9" style="background-color: white">
    <?php
    if ($tab == 'contact') {
        ?>
        <h4>联系方式</h4>
        <div class="divline"></div>
        <ul class="list-group" id="contact_index">
            <li class="list-group-item"><a target="_blank" href="mailto:sparkdevelop@163.com">sparkdevelop@163.com</a>
            </li>
            <li class="list-group-item">
                <a target="_blank" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=JRQUEhcSFBUdFBFlVFQLRkpI"
                   style="text-decoration:none;">
                    QQ: 1172710814
                </a>
            </li>
        </ul>
    <?php }
    if ($tab == 'about') {
        ?>
        <h4 style="text-align: center">关于我们</h4>
        <div class="divline"></div>
        <div id="about_us">
            <div id="about_title">火花概况</div>
            <div id="about_content">
                火花空间专注高校硬件学习和web学习领域，通过提供开放开源的教育资源，创建一个知识共享与协同创作的项目式的开放学习平台。目前的3.0版本包含wiki、问答、项目、协作四个版块。<br><br>
                wiki用于学习，人人可用，人人可创建，是知识碰撞的宝地。问答用于解惑，提出你的疑问，会有老师和大神热心为你解答。项目用于实践，从项目中学习，能将理论知识用于实践中，催生出新的想法，你也可以将自己的项目发布在版块上，指导他人学习。协作用于管理，加入同一个群组中的人，需要完成布置的任务，在合作与竞争的环境中，督促自己进步。<br><br>
                火花空间成立于2016年，从一个人的单兵作战到现在已经有了十几个核心成员的团队，致力于技术研究，拥有一些基础的开发套件。历经两个版本，现在正在进行3.0版本的设计开发，功能日益完善，更多有趣的类似布道师大赛的活动也将接连上线。<br><br>
            </div>
            <div id="about_title">愿景</div>
            <div id="about_content">
                火花空间帮助初学者找到想要获得的资源，并且有部分具有一定经验的人来带领初学者少走弯路，为他们指明方向。帮助学生用户在最短周期内熟悉自己的专业知识体系，建立起对专业领域从基础理论到前沿发展的具体认识；体验自主学习、团队合作、创新过程、展示交流、学以致用等与工程能力紧密相关的各种过程。未来将更大的发挥火花的平台价值，作为信息、知识汇聚的节点，管理分配好相关信息和知识。<br><br>
                同时，火花空间的设计一直随着科技的进步在逐渐更新，日后将融入人工智能的理念，增加学习路径、知识图谱等功能，为用户提供更加个性化的服务。<br><br>
            </div>
            <div id="about_title">发展历程</div>
            <div id="about_content">
                2015-12-01 火花空间在沙河校区成立，初始宗旨确立为给广大北邮学生提供一个创客方面的交流学习的平台<br><br>
                2016-08-15 火花空间网站研发初步完毕。目标是为广大北邮同学提供一个服务自学的平台，以基于wiki的知识积累和基于论坛的互动问答为核心功能，为初学者、技术大牛和老师提供一个知识服务系统<br><br>
                2016-09-22 火花空间中的导论实验课部分内容基本建设完毕<br><br>
                信通院召开会议，决定将通信原理、电子电路基础、数字信号处理、信息论等四门重要课程采用火花空间的维基服务建设共享知识库<br><br>
                2016-09-27 2014级信息工程学院李煜鸿同学到沙河校区分享他在暑期完成的平衡车项目，这是火花空间的第一次基于平台的开放项目交流活动<br><br>
                2016-09-30 信通院2016级同学全部进行了导论课第一次课程，开始体验开源硬件，并且在火花空间上进行各种提问，同时也有助教同学开始回答问题<br><br>
                2016-10-21 北京信息科技大学进行布道<br><br>
                2016-10-29/30 2016（第二届）全国移动互联创新大赛决赛中，北京邮电大学曲岩同学的团队获得特等奖。该项目已经在火花空间开源<br><br>
                2016-11-27 火花空间举办第一次创客马拉松<br><br>
                2016-12-11 火花空间创客马拉松中的大一新生前三名团队参加微软举办的清北航邮四校Hackathon，收获很多<br><br>
                2016-12-13 大四的边子政同学在沙河校区，成立web学习小组，并且建立了组织<br><br>
                2016-12-24 信通院第一届创新导论创新成果展圆满举办<br><br>
                2017-03 火花空间3.0版本研发开始<br><br>
                2017-06 火花空间3.0版本上线<br><br>
                2017-09-29 火花空间第一次布道师大赛开启<br><br>
            </div>
            <div id="about_title">火花空间团队与热心贡献者</div>
            <div id="about_content">
                社团：张明权、伊甸、石晋阶、吴佳桐、秦冰强、常明、江金融、谷嘉航、李星原、王超、刘晓宇、杨汀滢<br><br>
                技术与产品：罗昊、严帅、杜思聪、沈丹阳、谌利<br><br>
                内容：杜思聪、剡恺、张明权、秦冰强、吴佳桐、常明、黄萌、张雪、纪阳、吴振宇、魏浩然<br><br>
                开放项目分享者：参见小学期创新课开放项目<br><br>
            </div>
            <div id="about_title">使用指南</div>
            <div id="about_content">
                学生/小白：可以以导论课为起点熟悉并使用火花空间的服务，在上面进行免费的自主学习活动。wiki板块下，可以利用wiki词条搜索自己需要了解的知识；同时在问答版块下，及时解答疑惑；项目板块下，可以学习并实践之前的项目，也可以发布自己的项目；协作板块下，可以加入自己参与项目的团队，完成任务的同时掌握技能，也可以组建自己的团队，定期发布学习任务训练自己的团队，使团队成员共同进步。<br><br>
                老师／技术大牛：wiki板块下，可以创建自己的wiki词条，发布新学到的知识，也可以修改前人发布的wiki，完善内容。您还可以在协作板块下发布自己的的项目并指导他人学习，或是利用问答版块解疑答惑。您的努力将给他人，尤其是新生们带来巨大的帮助，可能会有意想不到的奖励哦。<br><br>
            </div>
        </div>
    <?php }
    if ($tab == 'integral'){ ?>
        <style>
            .table img{
                width: 20px;
            }
            .table{
                width: 80%;
                margin: 10px auto;
            }
            li{
                margin: 5px auto;
            }
            h4{
                margin: 20px auto;
            }
        </style>
        <h4 style="text-align: center">积分规则</h4>
        <div class="divline"></div>
        <h4>1、如何获取积分</h4>
        <div style="width: 90%;margin: 10px auto;">
            <p style="font-weight: bolder">用户在火花空间上的以下行为可以获取积分：</p>
            <h5>wiki部分</h5>
            <ul>
                <li>创建wiki词条(15分)</li>
                <li>完善他人的wiki词条(15分)</li>
                <li>为他人的wiki打分(2分)</li>
                <li>用户编写的词条获得他人3分（含）以上的打分(5分)</li>
                <li>用户编写的词条被他人收藏(2分)</li>
                <li>在词条评论区和他人交流(5分)</li>
            </ul>
        </div>
        <div style="width: 90%;margin: 10px auto;">
            <h5>问答部分</h5>
            <ul>
                <li>回答问题(5分)</li>
                <li>答案被他人赞同(1分)</li>
                <li>答案被提问者采纳还可获得提问者的悬赏分</li>
            </ul>
        </div>
        <div style="width: 90%;margin: 10px auto;">
            <h5>项目部分</h5>
            <ul>
                <li>创建项目词条(15分)</li>
                <li>为他人的项目打分(2分)</li>
                <li>用户项目获得他人3分（含）以上的打分(5分)</li>
                <li>用户项目被他人收藏(2分)</li>
                <li>在项目评论区和他人交流(5分)</li>
            </ul>
        </div>
        <h4>2、积分有什么用</h4>
        <div style="width: 90%;margin: 10px auto;">
            <ul>
                <li>积分可用来进行提问的悬赏，让你的问题更有价值，吸引更多人来为你解答</li>
                <li>积分可用来解锁设置了查看权限的资源，无需管理员通过，快速获取想看的资源</li>
                <li>活动期间，积分可获取线下礼品，根据活动的内容不同可兑换多种多样的礼品</li>
            </ul>
        </div>
        <h4>3、积分和等级的关系</h4>
        <div style="text-align: center">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>分值</th>
                    <th>等级</th>
                    <th>图标</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>0-200</td>
                    <td>Lv1</td>
                    <td><img src="<?php bloginfo("template_url")?>/img/integral/Lv1.png"></td>
                </tr>
                <tr>
                    <td>201-500</td>
                    <td>Lv2</td>
                    <td><img src="<?php bloginfo("template_url")?>/img/integral/Lv2.png"></td>
                </tr>
                <tr>
                    <td>501-1000</td>
                    <td>Lv3</td>
                    <td><img src="<?php bloginfo("template_url")?>/img/integral/Lv3.png"></td>
                </tr>
                <tr>
                    <td>1001-2000</td>
                    <td>Lv4</td>
                    <td><img src="<?php bloginfo("template_url")?>/img/integral/Lv4.png"></td>
                </tr>
                <tr>
                    <td>2000+</td>
                    <td>Lv5</td>
                    <td><img src="<?php bloginfo("template_url")?>/img/integral/Lv5.png"></td>
                </tr>
                </tbody>
            </table>
        </div>












    <? } ?>
</div>
