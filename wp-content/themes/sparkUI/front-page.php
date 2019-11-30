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

    .container_1 {
        margin: 50px 0 0 0;
    }

    .col-md-4 .col-sm-4 .col-xs-4 {
        display: inline-block;
    }

    #wiki_list_link {
        float: right;
        display: inline-block;
        font-size: 15px;
        color: #4e4e4e;
        height: 28px;
        line-height: 28px;
    }

    .wiki_list_header p {
        display: inline-block;
    }
    .login_title {
        color: #000;
        font-size: 19px;
        text-align: center;
        margin-top: 20px;
    }

    .login_item {
        margin: 30px 20px;
        position: relative;
        border: 1px solid #c9c9c9;
        border-radius: 3px;
        box-sizing: border-box;
    }
    .ipt {
        width: 100%;
        padding: 0 20px;
        height: 47px;
        line-height: 47px;
        border: none;
        background: none;
    }
</style>
<script>
    var flag
</script>
<?php
$_COOKIE["page_id"] = 0;
//解析URL参数
function parseUrlParam($query)
{
    $queryArr = explode('&', $query);
    $params = array();
    if ($queryArr[0] !== '') {
        foreach ($queryArr as $param) {
            list($name, $value) = explode('=', $param);
            $params[urldecode($name)] = urldecode($value);
        }
    }
    return $params;
}

//设置URL参数数组
function setUrlParams($cparams, $url = '')
{
    $parse_url = $url === '' ? parse_url($_SERVER["REQUEST_URI"]) : parse_url($url);
    $query = isset($parse_url['query']) ? $parse_url['query'] : '';
    $params = parseUrlParam($query);
    foreach ($cparams as $key => $value) {
        $params[$key] = $value;
    }
    return $parse_url['path'] . '?' . http_build_query($params);
}

//获取URL参数
function getUrlParam($cparam, $url = '')
{
    $parse_url = $url === '' ? parse_url($_SERVER["REQUEST_URI"]) : parse_url($url);
    $query = isset($parse_url['query']) ? $parse_url['query'] : '';
    $params = parseUrlParam($query);
    return isset($params[$cparam]) ? $params[$cparam] : '';
}

$token = getUrlParam('token', '');

if ($token) {
    $token = urlencode($token);
    //验证token Header,signature
    $tokendata['secret']="e4yy5e";//实验的secret;
    $tokendata['aesKey']="0iqI26CNM4RmZMN1zlJiQhRu7R7a8f3R9hKImwC3oZ0=";//实验的aesKey;
    $tokendata['token']=urldecode($token);
    $tokenjson=json_encode($tokendata);
    $httpurl="http://lai1.club:9000/getUserInfo";
    $reqstr=httpRequest($httpurl,$tokenjson);
    $reqstr=json_decode($reqstr);
    if ($reqstr->id||$reqstr->un||$reqstr->dis) {//验证token成功，解密用户信息
        $user_login = $reqstr->un;
        $display_name = $reqstr->dis;
        ilab_login($user_login,$display_name);
        wp_redirect(get_permalink(get_the_ID_by_title('导论实验课')));
    } else { //验证token失败，弹出实验空间登录入口
        echo "<script> flag = 1;</script>";
    }

}


//relation_table_install();
//user_history_table_install();
//favorite_table_install();
//score_table_install();
//xml_table_install();
//entity_table_install();
//gp_table_install();
//gp_verify_table_install();
//gp_member_table_install();
//gp_task_table_install();
//gp_member_verify_tmp_table_install();
//gp_task_member_table_install();
//gp_member_team_table_install();
//gp_task_complete_tmp_table_install();
//gp_notice_table_install();
//pmessage_table_install();
//notice_table_install();
//multischool_table_install();
//token_table_install();
rbac_role_table_install();
rbac_permission_table_install();
rbac_ur_table_install();
rbac_up_table_install();
rbac_rp_table_install();
rbac_post_table_install();
rbac_apply_tmp_table_install();
rbac_user_post_table_install();
user_integral_table_install();
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

<div class="container">
    <!--<div class="wiki_list col-md-12 col-sm-12 col-xs-12" style="display: inline-block;margin: 50px 0 50px 0;">
        <div class="wiki_list_header">
            <p style="font-size: 20px">多校合作</p>
            <a id="wiki_list_link" href="<?php //echo site_url() . get_page_address('community'); ?>">更多内容>></a>
        </div>
        <!--分割线-->
        <!--<div class="divline" style="margin-top: 0px"></div>
        <ul class="list-group" style="margin-bottom: 0;">
            <li class="list-group-item col-md-4 col-sm-4 col-xs-12">
                <div style="display: inline-block; vertical-align: baseline;">
                    <a href="<?php echo get_permalink(get_the_ID_by_title('2019多校燎原计划——腾讯云AI+小程序')); ?>"
                       style="color: #fe642d;">
                        <span>【燎原计划】</span>2019多校燎原计划
                    </a>
                </div>
            </li>
            <li class="list-group-item col-md-4 col-sm-4 col-xs-12">
                <div style="display: inline-block; vertical-align: baseline;">
                    <a href="<?php //echo get_permalink(get_the_ID_by_title('精简版端到端实验')); ?>" style="color: #4e4e4e;">
                        <span>【燎原计划】</span>2018精简版端到端实验
                    </a>
                </div>
            </li>
            <li class="list-group-item col-md-4 col-sm-4 col-xs-12">
                <div style="display: inline-block; vertical-align: baseline;">
                    <a href="<?php //echo get_permalink(get_the_ID_by_title('创+腾讯')); ?>" style="color: #4e4e4e;">
                        <span>【学习资源】</span>创+腾讯
                    </a>
                </div>
            </li>
            <li class="list-group-item col-md-12 col-sm-12 col-xs-12" style="text-align: center;margin-top: 20px">
                <div style="display: inline-block;">
                    <span style="color: gray;margin: 10px auto">合作伙伴</span>
                </div>
            </li>
            <img style="width: 100%;margin-top: 10px"
                 src="<?php //bloginfo("template_url") ?>/img/univerisity-logo/community.png"/>
        </ul>


    </div>-->

    <div class="container_1" id="front-page_1" style="display: table">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div id="front-img"><img class="front-icon" src="<?php bloginfo("template_url") ?>/img/wiki_icon.png"/>
            </div>
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
            $wiki_item = array([235, '导论实验课', getWikiViews(235)],
                [981, '导论课设计理念', getWikiViews(981)],
                [50935, '学长学姐出品~第一单元FAQ', getWikiViews(50935)],
                [71976, '学长学姐出品~第二单元FAQ', getWikiViews(71976)],
                [53821, '学长学姐出品~第三单元FAQ', getWikiViews(53821)],
                [56574, '学长学姐出品~第四单元FAQ', getWikiViews(56574)],
            )
            ?>
            <ul class="list-group" style="margin-bottom: 0px">
                <?php
                foreach ($wiki_item as $key => $value) {
                    ?>
                    <li class="list-group-item">
                        <div style="display: inline-block; vertical-align: baseline;">
                            <a href="<?php the_permalink($value[0]); ?>" style="color: #4e4e4e;">
                            <? if ($key == 0) { ?>
                                    <span style="color: #fe642d">【导论实验课】</span><?= $value[1] ?>
                                <?php } ?>
                                <? if ($key == 1) { ?>
                                    <span style="color: #fe642d">【导论实验课】</span><?= $value[1] ?>
                                <?php } ?>
                                <? if ($key == 2||$key == 3||$key == 4||$key == 5) { ?>
                                    <span style="color: #fe642d">【精品FAQ】</span><?= $value[1] ?>
                                <?php } ?>
                            </a>
                            <!--传浏览量-->
                        </div>
                        <div style="display: inline-block;float: right; margin-right: 30px;">
                            <?php if($value[2]==0){  
                                echo '981';
                            } else{ echo $value[2];
                            }?>次
                        </div>
                        
                    </li>
                <?php }
                ?>
                <!--首页成长Wiki-->
                <li class="list-group-item"> 
                <div style="display: inline-block; vertical-align: baseline;">
                <a href="https://www.oursparkspace.cn/?page_id=71970&param=7" style="color: #4e4e4e; text-decoration:none" > <span style="color: #fe642d">【成长】</span>导论课结束了，有些想说一说的（18级）</a>
                </div>
                <div style="display: inline-block;float: right; margin-right: 30px;">65次
                </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="container_2" id="front-page_2" style="margin: 50px 0 0 0;display: table">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div id="front-img"><img class="front-icon" src="<?php bloginfo("template_url") ?>/img/qa_icon.png"/></div>
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
            $qa_item = array([236, '关于程序上传和代码出错的一些总结', dwqa_question_views_count(236)],
                [492, '→→→→→→→网络工程实验←←←←←←不信你们看不见', dwqa_question_views_count(492)],
                [3603, '【反馈】火花空间&通信导论课反馈帖', dwqa_question_views_count(3603)],
                [477, '[集合贴]导论课反馈汇总(无法解决的问题都来这里吧)', dwqa_question_views_count(477)],
                [473, '[集合贴]【必看】导论课实验问题汇总（更新舵机电机问题）', dwqa_question_views_count(473)],
                [5296, '关于微信小程序后台服务器的搭建', dwqa_question_views_count(5296)])
            ?>
            <ul class="list-group" style="margin-bottom: 0px">
                <?php
                foreach ($qa_item as $value) {
                    ?>
                    <li class="list-group-item">
                        <div style="display: inline-block; vertical-align: baseline;">
                            <a href="<?php the_permalink($value[0]); ?>" style="color: #4e4e4e;">
                                <?= $value[1] ?>
                            </a>
                            <!--传浏览量-->
                        </div>
                        <div style="display: inline-block;float: right; margin-right: 30px;">
                            <?= $value[2] ?>次
                        </div>
                    </li>
                <?php }
                ?>
            </ul>
        </div>
    </div>
    <div class="container_3" id="front-page_3" style="padding: 50px 0 50px 0;display: table">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div id="front-img"><img class="front-icon" src="<?php bloginfo("template_url") ?>/img/project_icon.png"/>
            </div>
        </div>
        <div class="wiki_list col-md-8 col-sm-8 col-xs-12" style="display: inline-block">
            <div class="wiki_list_header">
                <p style="font-size: 20px">热门项目</p>
                <a id="wiki_list_link" href="<?php echo get_the_permalink(get_page_by_title('项目')); ?>">更多项目>></a>
            </div>
            <!--分割线-->
            <div class="divline" style="margin-top: 0px"></div>
            <!--推荐列表-->
            <?php
            $pro_item = array([248, '猫·车 —— 一种新型的逗猫方式', getProjectViews(248)],
                [5, '手语翻译手套', getProjectViews(5)],
                [1270, '自动倒桩入库小车', getProjectViews(1270)],
                [258, '小学期创新课开放项目', getProjectViews(258)],
                [265, '2016年导论课线上创新作品展', getProjectViews(265)],
                [271, '2016年导论课创新作品汇报展', getProjectViews(271)])
            ?>
            <ul class="list-group" style="margin-bottom: 0px">
                <?php
                foreach ($pro_item as $value) {
                    ?>
                    <li class="list-group-item">
                        <div style="display: inline-block; vertical-align: baseline;">
                            <a href="<?php the_permalink($value[0]); ?>" style="color: #4e4e4e;">
                                <?= $value[1] ?>
                            </a>
                        </div>
                        <!--传浏览量-->
                        <div style="display: inline-block;float: right; margin-right: 30px;">
                            <?= $value[2] ?>次
                        </div>
                    </li>
                <?php }
                ?>
            </ul>
        </div>
    </div>
</div>
<div style="clear:both;"></div>
<!--修改密码样式-->
<div id="login_ilab" style="display:none">
    <div class="login_title">国家虚拟仿真实验教学项目共享平台-登录</div>
    <form class="login_form" id="loginForm">
        <div class="login_item">
            <input class="ipt" id="username" type="text"  name="phone" placeholder="手机号/用户名/邮箱">
        </div>
        <div class="login_item">
            <input class="ipt" id="password" type="password"  name="password" placeholder="密码" >
        </div>
    </form>
</div>
<?php get_footer(); ?>
<script>
    $(document).ready(function () {
        if (flag === 1) {
            layer.open({
                   type: 1,
                   title:false,
                   area: ['500px','320px'],
                   shadeClose: true,
                   content: $('#login_ilab'),
                   btn:['立即登录'],
                   yes:function(index, layero){
                       var username = $("#username").val();
                       var password = $("#password").val();
                       if ($("#username").val()==""){
                           layer.alert('用户名不能为空!',{
                               title: '提示框',
                               icon:0

                           });
                           return false;
                       }
                       if ($("#password").val()==""){
                           layer.alert('密码不能为空!',{
                               title: '提示框',
                               icon:0

                           });
                           return false;
                       }
                       else{
                           //发送到实验平台验证，并检测用户是否存在，未完成
                           var data = {
                               action: "login_ilab",
                               username: username,
                               password: password
                           };
                           $.ajax({
                               type: "POST",
                               url:"<?php echo admin_url('admin-ajax.php');?>",//你的请求程序页面
                               data: data,//请求需要发送的处理数据
                               dataType: "json",
                               success: function(msg) {
                                   console.log(msg);
                                   if(msg.code ==0){
                                       window.location.href = "<?php echo get_permalink(get_the_ID_by_title('导论实验课')) ;?>";
                                   }else{
                                       layer.alert("用户名或密码错误！",{
                                           title: '提示框',
                                           icon:0
                                       });
                                   }
                               },
                               error: function () {
                                   layer.alert("出错了，请重试！",{
                                       title: '提示框',
                                       icon:0
                                   });
                               }
                            });
                        }
                    }
                });
            layer.msg('登录信息失效，请重新登录');
        }

    })
</script>
