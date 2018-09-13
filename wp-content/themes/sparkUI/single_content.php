<?php
wp_enqueue_script('fep-script');
wp_enqueue_media();

$current_user = wp_get_current_user();
//获取文章作者ID、用户名
$post_id = get_the_ID();

$author_id=get_post($post_id)->post_author;
$author_name=get_the_author_meta('user_login',$author_id);
$release_id=get_page_id('release');
//相关知识
$related_wiki = showProWiki(get_the_ID());
?>
<?php
//获取当前用户用户名
global $current_user;
get_currentuserinfo();
$current_user->user_login;
$admin_url=admin_url( 'admin-ajax.php' );
?>
<script>
    function addFavorite() {
        var data={
            action:'addFavorite',
            userID:'<?=$current_user->ID?>',
            postID:'<?=$post_id?>'
        };
        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: data,
            success: function(){
                layer.msg('收藏成功',{time:2000,icon:1});  //layer.msg(content, {options}, end) - 提示框
                var html = "<a onclick=\"setCSS(0)\" class=\"btn btn-default\" id=\"btn-add-favorite\">"+
                    "<span class=\"glyphicon glyphicon-star\"></span>已收藏"+"</a>";
                $("#addFavorite").html(html);
            },
            error:function () {
                alert("收藏失败");
            }
        });
    }
    function cancelFavorite() {
        var data={
            action:'cancelFavorite',
            userID:'<?=$current_user->ID?>',
            postID:'<?=$post_id?>'
        };
        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: data,
            success: function(){
                layer.msg('已取消',{time:2000,icon:1});  //layer.msg(content, {options}, end) - 提示框
                var html = "<a onclick=\"setCSS(1)\" class=\"btn btn-default\" id=\"btn-add-favorite\">"+
                    "<span class=\"glyphicon glyphicon-star-empty\"></span>收藏"+"</a>";
                $("#addFavorite").html(html);
            },
            error:function () {
                alert("error");
            }
        });
    }
</script>

<div class="container" style="margin-top: 10px;flex: 1 0 auto">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
            <!--引入动态模板-->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
                <!--    文章内容-->
                <div style="display:inline-block;">
                    <h2><b><?php the_title(); ?></b></h2>
                </div>
                <?php if( !ifFavorite($current_user->ID,$post_id) ){ //未收藏
                    $flag = 1;
                    $avalue = "<span class=\"glyphicon glyphicon-star-empty\"></span>收藏";
                } else{
                    $flag = 0;
                    $avalue = "<span class=\"glyphicon glyphicon-star\"></span>已收藏";
                } ?>
                <div id="addFavorite">
                    <a onclick="setCSS(<?=$flag?>)" class="btn btn-default" id="btn-add-favorite">
                        <?php echo $avalue; ?>
                    </a>
                </div>
                <hr>
                <?php
                //the_content();
                keywordHighlight_update();
                ?><hr>
                <?php comments_template(); ?>
            <?php endwhile;?>
            <?php else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

            <?php endif; ?>

        </div>
        <div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
            <style type="text/css">
                .mulu a{
                    display: block;
                    border: #9ea7af 1px solid;
                    height: 50px;
                    padding-left: 30px;
                }
                .mulu .mulu_item{
                    display: block;
                    border: #9ea7af 1px solid;
                    height: 50px;
                    padding-left: 50px;
                }

            </style>

            <!--判断用户是否为项目发布者，若是，则显示编辑按钮,否则显示发布按钮-->
            <div class="sidebar_button">
                <?php if($current_user->user_login  == $author_name) {
                    echo "<a href='?fep_action=edit&fep_id=$post_id&page_id=$release_id' >编辑项目</a >";
                }else {
                    echo "<a href='".get_the_permalink(get_page_by_title('发布项目')). "' target='_blank' >发布项目</a>";
                }
                ?>
            </div>
            <div class="sidebar-grey-frame" style="margin-top: 30px">
                <p>发布者：
                    <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.get_post()->post_author.'&tab=project'?>"
                       class="author_link" style="color: #5e5e5e"><?php echo get_the_author();?>
                        <?php
                        $user_level = get_user_level(get_post()->post_author);
                        $img_url = $user_level.".png";
                        ?>
                        <img src="<?php bloginfo("template_url")?>/img/integral/<?=$img_url?>" style="width: 20px;margin-left: -20px">
                    </a>
                </p><br>
                <p>分类：</p>
                <span id="" ><?php the_category(', ') ?></span><br>
                <p>标签：</p>
                <span id=""><?php the_tags("", "  ",''); ?></span><br>
                <p>更新：</p>
                <span id="" ><?php the_modified_time('Y年n月j日 h:m:s'); ?></span><br>
                <p>浏览：</p>
                <span id=""><?php setProjectViews(get_the_ID()); ?><?php echo getProjectViews(get_the_ID()); ?> 次</span><br>
                <p>评论：</p>
                <span><?php comments_popup_link('0 条', '1 条', '% 条', '', '评论已关闭'); ?></span><br>
            </div><br>

            <?php $score = calScore($post_id);
            $starScore = round($score['score'])-1;
            $hasScore = hasScore($current_user->ID,$post_id);
            ?>
            <script>
                window.onload = function () {
                    var flag;
                    flag =<?=hasScore($current_user->ID,$post_id);?>;
                    var score = document.getElementById('score');
                    var oUl = document.getElementById('stars');
                    var aLi = oUl.getElementsByTagName('li');
                    var arr = ['内容太少','项目一般', '有点帮助','学到很多','强力推荐'];
                    if(flag==true){ //未打分
                        for (var i = 0; i < aLi.length; i++) {
                            aLi[i].index = i;
                            markOut(<?=$starScore?>);   //初始显示
                            aLi[i].onclick = function () {
                                markOver(this.index);  //this指的是aLi[i]
                                oUl.index = this.index;
                                var data = {
                                    action: 'addScore',
                                    userID: '<?=$current_user->ID?>',
                                    postID: '<?=$post_id?>',
                                    score: this.index + 1
                                };
                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo $admin_url;?>",
                                    data: data,
                                    success: function () {
                                        layer.msg('打分成功', {time: 2000, icon: 1},function () {
                                            location.reload();
                                        });  //layer.msg(content, {options}, end) - 提示框
                                    },
                                    error: function () {
                                        alert("Oops,打分失败了T^T");
                                    }
                                });
                            };
                            aLi[i].onmouseover = function () {
                                for (var i = 0; i < aLi.length; i++) {
                                    aLi[i].style.color = '#ccc';
                                }
                                markOver(this.index);
                            };
                            aLi[i].onmouseout = function () {
                                for (var i = 0; i <= this.index; i++) {
                                    aLi[i].style.color = '#ccc';
                                }
                                markOut(<?=$starScore?>);
                            };
                        }
                    }else{
                        for (var i = 0; i < aLi.length; i++) {
                            aLi[i].index = i;
                            markOut(<?=$starScore?>);   //初始显示
                            aLi[i].onclick = function (){
                                layer.msg("你已经打过分了",{time:2000,icon:2});
                            }
                        }
                    }
                    function markOver(index) {
                        for (var i = 0; i <= index; i++) {
                            aLi[i].style.color = index < 2 ? 'gray' : '#fe642d';
                        }
                        score.innerHTML = arr[index] ? arr[index] :'<?=$score['score']?>';
                    }
                    function markOut(index) {
                        for (var i = 0; i <= index; i++) {
                            aLi[i].style.color = index < 2 ? 'gray' : '#fe642d';
                        }
                        var html = arr[index]+"<span>~<?=$score['num']?>人评分</span>";
                        if(index==-1){
                            html = "<span><?=$score['num']?>人评分</span>";
                        }
                        score.innerHTML =html;
                    }
                }
            </script>
            <div id="proScore">
                <div class="sidebar_list_header">
                    <p>项目评分</p>
                </div>
                <div style="height: 2px;background-color: lightgray"></div>
                <div id="starsdiv">
                    <div id="starsdivleft">
                        <ul class="stars" id="stars">
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                            <li class="fa fa-star"></li>
                        </ul>
                        <div id="score">
                            <?=$score['score'];?>
                            <span>&nbsp;<?=$score['num']?>人评分</span>
                        </div>
                    </div>
                </div>
            </div>

            <?php //$projsonString = proSideJSONGenerte($current_user->ID,"post"); ?>
            <!--            <div class="proknowledge">-->
            <!--                <div class="sidebar_list_header">-->
            <!--                    <p>学习路径</p>-->
            <!--                </div>-->
            <!--                <div style="height: 2px;background-color: lightgray"></div>-->
            <!--                <div id="sidechart" style="width:350px;height: 350px"></div>-->
            <!--            </div>-->
            <script>
                //sideChart('sidechart','<?php //$projsonString?>');
            </script>
            <!--专利-->
            <div class="related_wikis">
                <div class="sidebar_list_header">
                    <p>相关专利</p>
                    <a href="http://www.sipo.gov.cn/zhfwpt/zlsqzn/zlsqspcxjs/zlsqsplc/" target="_blank" style="margin-left: 10px;font-size: small;color: darkgray;font-weight:normal">专利申请流程</a>
                    <a id="sidebar_list_link" onclick="show_more_patent()">更多</a>
                </div>
                <!--分割线-->
                <div style="height: 2px;background-color: lightgray"></div>
                <div class="related_wiki" id="related_patent">
                    <ul style="padding-left: 0px">
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU02014070200000000203688114628OADV01792B&patentType=patent2&patentLib=&_sessionID=EZDwMF5XCThYdrEp" target="_blank" class="question-title">
                                自动气象观测系统 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/authorization?isNewWindow=yes&pid=PIDCNB02017051700000000103942115S08FGGU016475&patentType=patent2&patentLib=&_sessionID=YR8TSskFYd6pyjpf" target="_blank" class="question-title">
                                一种基于气象观测数据的可吸入颗粒物浓度估算方法 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU02011050400000000201819114519VBHC0141F7&patentType=patent2&patentLib=&_sessionID=sR6we7Q33z8PsZFF" target="_blank" class="question-title">
                                公路气象站系统 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU0201205160000000020222011451O0GB40161FA&patentType=patent2&patentLib=&_sessionID=chKDQf7SfX6tpKKE" target="_blank" class="question-title">
                                LED节能灯 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA02018051100000000108028125E0AIQKM014E62&patentType=patent2&patentLib=&_sessionID=QbPbaaDWHwGjQH33" target="_blank" class="question-title">
                                红外LED </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA02013091100000000103297114904BLGA012F19&patentType=patent2&patentLib=&_sessionID=dcGXfmXQRi78p3yz" target="_blank" class="question-title">
                                蓝牙-WIFI网关 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU02010051900000000201476114515M9ES0152CA&patentType=patent2&patentLib=&_sessionID=H5P5dKxS5wQwSttb" target="_blank" class="question-title">
                                称重传感器 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA0201808070000000010837612890ELDPF013368&patentType=patent2&patentLib=&_sessionID=JhKY2fkjT8cZEdGr" target="_blank" class="question-title">
                                一种基于Arduino的阵列语音采集系统及采集方法 </a>
                        </li>
                    </ul>
                </div>

                <div class="more_related_wiki" id="more_related_patent" style="display: none">
                    <ul style="padding-left: 0px; ">
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU02014070200000000203688114628OADV01792B&patentType=patent2&patentLib=&_sessionID=EZDwMF5XCThYdrEp" target="_blank" class="question-title">
                                自动气象观测系统 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/authorization?isNewWindow=yes&pid=PIDCNB02017051700000000103942115S08FGGU016475&patentType=patent2&patentLib=&_sessionID=YR8TSskFYd6pyjpf" target="_blank" class="question-title">
                                一种基于气象观测数据的可吸入颗粒物浓度估算方法 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU02011050400000000201819114519VBHC0141F7&patentType=patent2&patentLib=&_sessionID=sR6we7Q33z8PsZFF" target="_blank" class="question-title">
                                公路气象站系统 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU0201205160000000020222011451O0GB40161FA&patentType=patent2&patentLib=&_sessionID=chKDQf7SfX6tpKKE" target="_blank" class="question-title">
                                LED节能灯 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA02018051100000000108028125E0AIQKM014E62&patentType=patent2&patentLib=&_sessionID=QbPbaaDWHwGjQH33" target="_blank" class="question-title">
                                红外LED </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA02013091100000000103297114904BLGA012F19&patentType=patent2&patentLib=&_sessionID=dcGXfmXQRi78p3yz" target="_blank" class="question-title">
                                蓝牙-WIFI网关 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU02010051900000000201476114515M9ES0152CA&patentType=patent2&patentLib=&_sessionID=H5P5dKxS5wQwSttb" target="_blank" class="question-title">
                                称重传感器 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA0201808070000000010837612890ELDPF013368&patentType=patent2&patentLib=&_sessionID=JhKY2fkjT8cZEdGr" target="_blank" class="question-title">
                                一种基于Arduino的阵列语音采集系统及采集方法 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA0201808310000000010846412930AH818017F98&patentType=patent2&patentLib=&_sessionID=RibAReQWRxZbGbCz" class="question-title"
                               target="_blank" id="more_wiki">
                                一种樱桃种植用灌溉光照调节装置 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDUSA1201708170000002017023611AJ26TB7K0118B7&patentType=patent2&patentLib=&_sessionID=33xhBpFeWDZfcs4G" class="question-title" target="_blank" id="more_patent">
                                WIFI TRANSACTIONS </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDUSA12018062100000020180176126T2DPIRK010FDE&patentType=patent2&patentLib=&_sessionID=awzbfyQEMhYQaFAZ" class="question-title" target="_blank" id="more_patent">
                                TCP Bufferbloat Resolution </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://www.so.iptrm.com/app/authorization?isNewWindow=yes&pid=PIDUSB22017032800000000009609117C04BM250124A1&patentType=patent2&patentLib=&_sessionID=NTCBE8sJbXj7a4fX" class="question-title" target="_blank" id="more_patent">
                                HTTP proxy </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--论文-->
            <div class="related_wikis">
                <div class="sidebar_list_header">
                    <p>相关论文</p>
                    <a href="https://www.zhihu.com/question/34903516/answer/68547441" target="_blank" style="margin-left: 10px;font-size: 12px;color: darkgray;font-weight: normal">论文撰写教程</a>
                    <a id="sidebar_list_link" onclick="show_more_paper()">更多</a>
                </div>
                <!--分割线-->
                <div style="height: 2px;background-color: lightgray"></div>
                <div class="related_wiki" id="related_paper">
                    <ul style="padding-left: 0px">
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%2872066344866dd32f60931e031ec15b22%29&filter=sc_long_sign&sc_ks_para=q%3DHeat%20and%20fluid%20flow%20in%20high-power%20LED%20packaging%20and%20applications&sc_us=10168108634810893133&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" target="_blank" class="question-title">
                                Heat and fluid flow in high-power LED packaging and applications </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28a5cf762686afd0a6cfe0fb0b6ba88bd2%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8E%E6%9E%9C%E8%9D%87%E4%BC%98%E5%8C%96%E7%AE%97%E6%B3%95%E7%9A%84%E4%B8%89%E7%BB%B4LED%E5%85%89%E6%BA%90%E9%98%B5%E5%88%97%E4%BC%98%E5%8C%96%E8%AE%BE%E8%AE%A1&sc_us=8359613791293871464&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" target="_blank" class="question-title">
                                基于果蝇优化算法的三维LED光源阵列优化设计 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%281c1b3c89d3741208870d5b4a1a14e80d%29&filter=sc_long_sign&sc_ks_para=q%3DZigBee%E4%B8%8E%E8%93%9D%E7%89%99%E7%9A%84%E5%88%86%E6%9E%90%E4%B8%8E%E6%AF%94%E8%BE%83&sc_us=2045037250759201464&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" target="_blank" class="question-title">
                                ZigBee与蓝牙的分析与比较 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28fabd26129ed1be4df2634dbbfd7813aa%29&filter=sc_long_sign&sc_ks_para=q%3DArduino%3A%20a%20low-cost%20multipurpose%20lab%20equipment.&sc_us=1963658631356660655&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" target="_blank" class="question-title">
                                Arduino: a low-cost multipurpose lab equipment </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28355b2339b20c396239f8d8abe737e5f8%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8E%E7%BA%A2%E5%A4%96%E4%BC%A0%E6%84%9F%E5%99%A8%E7%9A%84%E6%99%BA%E8%83%BD%E6%95%99%E5%AE%A4%E7%85%A7%E6%98%8E%E6%8E%A7%E5%88%B6&sc_us=4489042973294239552&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" target="_blank" class="question-title">
                                基于红外传感器的智能教室照明控制 </a>
                        </li>
                    </ul>
                </div>

                <div class="more_related_wiki" id="more_related_paper" style="display: none">
                    <ul style="padding-left: 0px; ">
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%2872066344866dd32f60931e031ec15b22%29&filter=sc_long_sign&sc_ks_para=q%3DHeat%20and%20fluid%20flow%20in%20high-power%20LED%20packaging%20and%20applications&sc_us=10168108634810893133&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" target="_blank" class="question-title">
                                Heat and fluid flow in high-power LED packaging and applications </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28a5cf762686afd0a6cfe0fb0b6ba88bd2%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8E%E6%9E%9C%E8%9D%87%E4%BC%98%E5%8C%96%E7%AE%97%E6%B3%95%E7%9A%84%E4%B8%89%E7%BB%B4LED%E5%85%89%E6%BA%90%E9%98%B5%E5%88%97%E4%BC%98%E5%8C%96%E8%AE%BE%E8%AE%A1&sc_us=8359613791293871464&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" target="_blank" class="question-title">
                                基于果蝇优化算法的三维LED光源阵列优化设计 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%281c1b3c89d3741208870d5b4a1a14e80d%29&filter=sc_long_sign&sc_ks_para=q%3DZigBee%E4%B8%8E%E8%93%9D%E7%89%99%E7%9A%84%E5%88%86%E6%9E%90%E4%B8%8E%E6%AF%94%E8%BE%83&sc_us=2045037250759201464&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" target="_blank" class="question-title">
                                ZigBee与蓝牙的分析与比较 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28fabd26129ed1be4df2634dbbfd7813aa%29&filter=sc_long_sign&sc_ks_para=q%3DArduino%3A%20a%20low-cost%20multipurpose%20lab%20equipment.&sc_us=1963658631356660655&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" target="_blank" class="question-title">
                                Arduino: a low-cost multipurpose lab equipment </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28355b2339b20c396239f8d8abe737e5f8%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8E%E7%BA%A2%E5%A4%96%E4%BC%A0%E6%84%9F%E5%99%A8%E7%9A%84%E6%99%BA%E8%83%BD%E6%95%99%E5%AE%A4%E7%85%A7%E6%98%8E%E6%8E%A7%E5%88%B6&sc_us=4489042973294239552&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" target="_blank" class="question-title">
                                基于红外传感器的智能教室照明控制 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28caec31e757e12b1e9ce257bd9df7971c%29&filter=sc_long_sign&sc_ks_para=q%3DExploring%20mobile%2FWiFi%20handover%20with%20multipath%20TCP&sc_us=10274875248912255968&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" class="question-title"
                               target="_blank" id="more_wiki">
                                Exploring mobile/WiFi handover with multipath TCP </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28b859962ca7d0c2a79ba10b29927163e0%29&filter=sc_long_sign&sc_ks_para=q%3DTCP%20Extensions%20for%20Multipath%20Operation%20with%20Multiple%20Addresses&sc_us=3632409001235107039&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" class="question-title" target="_blank" id="more_patent">
                                TCP Extensions for Multipath Operation with Multiple Addresses </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%281ef14ce097037b249bd6542fb8ce844f%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8EHTTP%E5%8D%8F%E8%AE%AE%E7%9A%84%E5%9C%B0%E8%B4%A8%E7%81%BE%E5%AE%B3%E6%95%B0%E6%8D%AE%E4%BC%A0%E8%BE%93%E7%B3%BB%E7%BB%9F%E8%AE%BE%E8%AE%A1&sc_us=11390142739195011222&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" class="question-title" target="_blank" id="more_patent">
                                基于HTTP协议的地质灾害数据传输系统设计 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28099ddd3d36d0e04fed41a56fbccb30bb%29&filter=sc_long_sign&sc_ks_para=q%3DSpring%20MVC%E6%A1%86%E6%9E%B6%E5%BC%80%E5%8F%91WEB%E5%BA%94%E7%94%A8%E7%A8%8B%E5%BA%8F%E7%9A%84%E6%8E%A2%E7%B4%A2%E4%B8%8E%E7%A0%94%E7%A9%B6&sc_us=11406744225561867708&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" class="question-title" target="_blank" id="more_patent">
                                Spring MVC框架开发WEB应用程序的探索与研究 </a>
                        </li>
                        <li class="list-group-item">
                            <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%2887a172a1410051f641bc5fe6140d703d%29&filter=sc_long_sign&sc_ks_para=q%3D%E8%93%9D%E7%89%99%E6%A8%A1%E5%9D%97%E4%B8%B2%E5%8F%A3%E9%80%9A%E4%BF%A1%E7%9A%84%E8%AE%BE%E8%AE%A1%E4%B8%8E%E5%AE%9E%E7%8E%B0&sc_us=11743206145125558581&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8" class="question-title" target="_blank" id="more_patent">
                                蓝牙模块串口通信的设计与实现 </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="related_questions">
                <div class="sidebar_list_header">
                    <p>相似项目</p>
                </div>
                <div style="height: 2px;background-color: lightgray"></div>
                <ul class="list-group" style="padding-left: 0px; ">
                    <?php related_project() ?>
                </ul>
            </div>

            <div class="related_wikis">
                <div class="sidebar_list_header">
                    <p>相关知识</p>
                    <a id="sidebar_list_link" onclick="show_more_wiki()">更多</a>
                </div>
                <!--分割线-->
                <div style="height: 2px;background-color: lightgray"></div>
                <div class="related_wiki" id="related_wiki">
                    <ul style="padding-left: 0px; ">
                        <?php
                        //控制条数
                        if(sizeof($related_wiki)<5){$length = sizeof($related_wiki);}
                        else{$length = 5;}
                        for($i=0;$i<$length;$i++){ ?>
                            <li class="list-group-item">
                                <a href="<?php echo get_permalink($related_wiki[$i]["wiki_id"]);?>" class="question-title">
                                    <?php echo get_the_title($related_wiki[$i]["wiki_id"]);?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="more_related_wiki" id="more_related_wiki" style="display: none">
                    <ul style="padding-left: 0px">
                        <?php
                        //控制条数
                        if(sizeof($related_wiki)>=15){$length = 15;}
                        else{$length = sizeof($related_wiki);}

                        for($i=0;$i<$length;$i++){ ?>
                            <li class="list-group-item">
                                <a href="<?php echo get_permalink($related_wiki[$i]["wiki_id"]);?>" class="question-title" id="more_wiki">
                                    <?php echo get_the_title($related_wiki[$i]["wiki_id"]);?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

        </div>
        <?php //get_sidebar();?>
    </div>
</div>
<?php get_footer(); ?>
<div class="side-tool" id="side-tool-project">
    <ul>
        <li data-placement="left" data-toggle="tooltip" data-original-title="回到顶部"><a href="#" class="">顶部</a></li>
        <li data-placement="left" data-toggle="tooltip" data-original-title="点赞吐槽"><a href="#comments" class="">评论</a></li>

        <?php
        $current_url = curPageURL();
        $url_array=parse_url($current_url);
        $current_page_id=explode("=",$url_array['query'])[1];
        $current_page_type = get_post_type($current_page_id);
        ?>
        <?php if(is_user_logged_in()){ ?>
            <li data-placement="left" data-toggle="tooltip" data-original-title="不懂就问">
                <a onclick="addLayer()" id="ask_link">提问</a>
            </li>
        <?php }else{ ?>
            <li data-placement="left" data-toggle="tooltip" data-original-title="不懂就问">
                <a href="<?php echo wp_login_url( get_permalink() ); ?>">提问</a>
            </li>
        <?php } ?>

    </ul>
</div>

<div class="side-tool" id="m-side-tool-project">
    <ul>
        <?php if($current_user->user_login  == $author_name){
            echo "<li><a href='?fep_action=edit&fep_id=$post_id&page_id=$release_id' ><i class='fa fa-pencil' aria-hidden = 'true' ></i ></a ></li>";
            echo "<li><a href='".get_the_permalink(get_page_by_title('发布项目')). "'><i class='fa fa-plus' aria-hidden='true'></i></a></li>";
        }else{
            echo "<li><a href='".get_the_permalink(get_page_by_title('发布项目')). "'><i class='fa fa-plus' aria-hidden='true'></i></a></li>";
        }
        ?>
    </ul>
</div>

<script type="text/javascript">
    $(function () { jQuery("[data-toggle='tooltip']").tooltip(); });
</script>
<script>
    var flag=false;

    function show_more_wiki() {
        var related_wiki=document.getElementById('related_wiki');
        var more_related_wiki = document.getElementById('more_related_wiki');
        if(flag){
            related_wiki.style.display ="block";
            more_related_wiki.style.display="none";
        }else{
            related_wiki.style.display="none";
            more_related_wiki.style.display="block";
        }
        flag=!flag;
    }

    var flag1 = false;

    function show_more_patent() {
        var related_patent = document.getElementById('related_patent');
        var more_related_patent = document.getElementById('more_related_patent');
        if (flag1) {
            related_patent.style.display = "block";
            more_related_patent.style.display = "none";
        } else {
            related_patent.style.display = "none";
            more_related_patent.style.display = "block";
        }
        flag1 = !flag1;
    }
    var flag2 = false;

    function show_more_paper() {
        var related_paper = document.getElementById('related_paper');
        var more_related_paper = document.getElementById('more_related_paper');
        if (flag2) {
            related_paper.style.display = "block";
            more_related_paper.style.display = "none";
        } else {
            related_paper.style.display = "none";
            more_related_paper.style.display = "block";
        }
        flag2 = !flag2;
    }
    function addLayer() {
        layer.open({
            type : 2,
            title: "提问", //不显示title   //'layer iframe',
            content: '<?php echo site_url().get_page_address('ask_tiny')."&post_id=".$current_page_id."&type=".$current_page_type;?>', //iframe的url
            area: ['70%', '80%'],
            closeBtn:1,            //是0为不显示叉叉 可选1,2
            shadeClose: true,    //点击其他shade区域关闭窗口
            shade: 0.5,   //透明度
            end: function () {
                location.reload();
            }
        });
    }
</script>


