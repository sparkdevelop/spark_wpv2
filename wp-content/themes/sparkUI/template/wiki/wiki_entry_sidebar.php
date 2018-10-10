<?php
global $post;
$entry_title = $post->post_title;
$entry_content = $post->post_content;
$wiki_content = $post->post_content;
$post_id = $post->ID;
$regex = "/(?:<h2>.*<\/h2>)/";
$match = array();
$entry_titles = array();
preg_match_all($regex, $wiki_content, $match);
for ($i = 0; $i < count($match[0]); $i++) {
    $wiki_title_item = trim($match[0][$i]);
    $wiki_format_title = substr($wiki_title_item, 4, -5);
    if (empty($wiki_format_title)) {
        continue;
    }
    $entry_titles[] = $wiki_format_title;
}
$_SESSION["entry_mulu"] = $entry_titles;
$user_id = get_current_user_id();
$role_arr = get_rbac_user_relation('role', $user_id);
$role_id = get_type_id('role', '导论课编辑');
$permission_id = get_type_id('permission', '编辑导论课');
$permission_posts = get_permission_post($permission_id);
$modified_time = date("Y-m-d H:i:s", time() + 8 * 3600);
$apply_url = admin_url('admin-ajax.php');
?>
<div class="wiki_sidebar_wrap">
    <div class="row wiki-handle">
        <div class="edit-wiki">
            <?php if(judge_daolunke($role_id,$role_arr,$post_id,$permission_posts)){?>
                <a href="#" onclick="apply_role_daolunke(<?=$user_id;?>,<?=$role_id;?>,'<?=$modified_time;?>','<?=$apply_url;?>')">编辑
                    wiki</a>
            <?php }else {?>
                <a href="<?php echo get_permalink(get_page_by_title('编辑wiki')); ?>&post_id=<?php echo $post->ID ?>">编辑
                    wiki</a>
            <?php }?>
           </div>
        <div class="create-wiki"><a href="<?php echo get_permalink(get_page_by_title('创建wiki')); ?>">创建 wiki</a></div>
    </div>
    <div id="apply_permission_prompt" style="display: none;padding: 20px">
        <p >您没有权限编辑导论实验课相关内容，需要向网站管理员申请老师/助教权限。</p>
        <label for="reason">申请理由：</label>
        <input type="text" class="form-control" name="reason" id="dlk_reason" placeholder="请老师或助教填写姓名进行申请" value=""/>
    </div>
    <!--    <div class="list-group mulu">-->
    <!--        <a href="#" class="list-group-item">-->
    <!--            <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>-->
    <!--            目录-->
    <!--        </a>-->
    <!--        --><?php
    //            for($i=0; $i<count($entry_titles); $i++) {
    //                ?>
    <!--                <a href="#" class="list-group-item mulu_item">--><?php //echo $entry_titles[$i]; ?><!--</a>-->
    <!--                --><?php
    //            }
    //        ?>
    <!--    </div>-->
    <?php
    global $post;
    $admin_url = admin_url('admin-ajax.php');
    ?>
    <script type="text/javascript">
        $(function () {
            var revision_url = "<?php echo site_url() . get_page_address('wiki_revisions') . '&wiki_id=' . $post->ID;?>";
            var get_post_info = {
                action: "get_post_info",
                post_id: <?php echo $post->ID; ?>
            };
            $.ajax({
                type: "POST",
                url: "<?php echo $admin_url;?>",
                data: get_post_info,
                dataType: "json",
                success: function (data) {
                    var categories_show = "";
                    for (var i = 0; i < data.categories.length; i++) {
                        categories_show = categories_show + data.categories[i] + "  ";
                    }
                    var tags_show = "";
                    for (var i = 0; i < data.tags.length; i++) {
                        tags_show = tags_show + data.tags[i] + "  ";
                    }
                    $("#edit_nums").html("编辑: " + data.edit_author_nums + "人&nbsp;&nbsp;&nbsp;&nbsp;" + "<a href='" + revision_url + "' style='color: #fe642d;'>" + data.revision_nums + "个版本" + "</a>");
                    //$("#watch_nums").html("浏览: "+data);
                    $("#update_time").html("更新: " + data.time + "天前");
                    //$("#categories_show").html("分类: "+categories_show);
                    //$("#tags_show").html("标签: "+tags_show);
                    $("#watch_nums").html("浏览: " + data.watch_count + "次");
                },
                error: function () {
                    alert("数据加载失败!");
                }
            });

        });
    </script>
    <div class="wiki_entry_info">
        <p>创建:
            <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . get_post()->post_author . '&tab=wiki' ?>"
               class="author_link" style="color: #5e5e5e"><?php echo get_the_author(); ?>
            </a>
            <?php
            $user_level = get_user_level(get_post()->post_author);
            $img_url = $user_level . ".png";
            ?>
            <img src="<?php bloginfo("template_url") ?>/img/integral/<?= $img_url ?>"
                 style="width: 20px;margin-left: -20px">
        </p>
        <p id="edit_nums"></p>
        <p id="watch_nums"></p>
        <p id="update_time"></p>
        <p id="categories_show">分类：<?php the_terms($post->ID, 'wiki_cats', '', ',', ''); ?></p>
        <p id="tags_show">标签：<?php the_terms($post->ID, 'wiki_tags', '', ',', ''); ?></p>
    </div>
    <!--    --><?php /*echo $post_id= $post->ID;
    $tags=get_the_terms($post_id,'wiki_tags');
    echo $tags[0]->name;
    print_r($tags);*/ ?>
    <!--    <div class="wiki_entry_score">-->
    <!--        <p>学到好多: 有20人评分</p>-->
    <!--    </div>-->
    <!--    <div class="wiki_entry_share">-->
    <!--        <p>QQ     WECHAT     WEIBO</p>-->
    <!--    </div>-->

    <!--评分-->
    <?php
    $post_id = $post->ID;
    $current_user = wp_get_current_user();
    $score = calScore($post_id);
    $starScore = round($score['score']) - 1;
    $hasScore = hasScore($current_user->ID, $post_id);
    ?>
    <script>
        window.onload = function () {
            var flag;
            flag =<?=hasScore($current_user->ID, $post_id);?>;
            var score = document.getElementById('score');
            var oUl = document.getElementById('stars');
            var aLi = oUl.getElementsByTagName('li');
            var arr = ['毫无帮助', '内容一般', '有点帮助', '学到很多', '强力推荐'];
            if (flag == true) { //未打分
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
                                layer.msg('打分成功', {time: 2000, icon: 1}, function () {
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
            } else {
                for (var i = 0; i < aLi.length; i++) {
                    aLi[i].index = i;
                    markOut(<?=$starScore?>);   //初始显示
                    aLi[i].onclick = function () {
                        layer.msg("你已经打过分了", {time: 2000, icon: 2});
                    }
                }
            }

            function markOver(index) {
                for (var i = 0; i <= index; i++) {
                    aLi[i].style.color = index < 2 ? 'gray' : '#fe642d';
                }
                score.innerHTML = arr[index] ? arr[index] : '<?=$score['score']?>';
            }

            function markOut(index) {
                for (var i = 0; i <= index; i++) {
                    aLi[i].style.color = index < 2 ? 'gray' : '#fe642d';
                }
                var html = arr[index] + "<span>~<?=$score['num']?>人评分</span>";
                if (index == -1) {
                    html = "<span><?=$score['num']?>人评分</span>";
                }
                score.innerHTML = html;
            }
        }
    </script>
    <div id="proScore">
        <div class="sidebar_list_header">
            <p>wiki评分</p>
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
                    <?= $score['score']; ?>
                    <span>&nbsp;<?= $score['num'] ?>人评分</span>
                </div>
            </div>
        </div>
    </div>

    <!--知识图谱-->
    <?php
    $jsonString = wikiSideJsonGenerate(get_the_title());
    //$jsonString = wiki_path_select(get_the_title());
    if ($jsonString != '') {
        ?>
        <div class="wikiknowledge">
            <div class="sidebar_list_header">
                <p>学习路径</p>
            </div>
            <div style="height: 2px;background-color: lightgray"></div>
            <div id="sidechart" style="width:280px;height: 280px;padding-left: 0px"></div>
        </div>
        <script>
            sideChart('sidechart', '<?=$jsonString?>');
        </script>
    <?php } ?>

    <!--专利-->
    <div class="related_wikis">
        <div class="sidebar_list_header">
            <p>相关专利</p>
            <a href="http://www.sipo.gov.cn/zhfwpt/zlsqzn/zlsqspcxjs/zlsqsplc/" target="_blank"
               style="margin-left: 10px;font-size: small;color: darkgray;font-weight:normal">专利申请流程</a>
            <a id="sidebar_list_link" onclick="show_more_patent()">更多</a>
        </div>
        <!--分割线-->
        <div style="height: 2px;background-color: lightgray"></div>
        <div class="related_wiki" id="related_patent">
            <ul style="padding-left: 0px">
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU02014070200000000203688114628OADV01792B&patentType=patent2&patentLib=&_sessionID=EZDwMF5XCThYdrEp"
                       target="_blank" class="question-title">
                        自动气象观测系统 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/authorization?isNewWindow=yes&pid=PIDCNB02017051700000000103942115S08FGGU016475&patentType=patent2&patentLib=&_sessionID=YR8TSskFYd6pyjpf"
                       target="_blank" class="question-title">
                        一种基于气象观测数据的可吸入颗粒物浓度估算方法 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU02011050400000000201819114519VBHC0141F7&patentType=patent2&patentLib=&_sessionID=sR6we7Q33z8PsZFF"
                       target="_blank" class="question-title">
                        公路气象站系统 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU0201205160000000020222011451O0GB40161FA&patentType=patent2&patentLib=&_sessionID=chKDQf7SfX6tpKKE"
                       target="_blank" class="question-title">
                        LED节能灯 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA02018051100000000108028125E0AIQKM014E62&patentType=patent2&patentLib=&_sessionID=QbPbaaDWHwGjQH33"
                       target="_blank" class="question-title">
                        红外LED </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA02013091100000000103297114904BLGA012F19&patentType=patent2&patentLib=&_sessionID=dcGXfmXQRi78p3yz"
                       target="_blank" class="question-title">
                        蓝牙-WIFI网关 </a>
                </li>
            </ul>
        </div>

        <div class="more_related_wiki" id="more_related_patent" style="display: none">
            <ul style="padding-left: 0px; ">
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU02014070200000000203688114628OADV01792B&patentType=patent2&patentLib=&_sessionID=EZDwMF5XCThYdrEp"
                       target="_blank" class="question-title">
                        自动气象观测系统 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/authorization?isNewWindow=yes&pid=PIDCNB02017051700000000103942115S08FGGU016475&patentType=patent2&patentLib=&_sessionID=YR8TSskFYd6pyjpf"
                       target="_blank" class="question-title">
                        一种基于气象观测数据的可吸入颗粒物浓度估算方法 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU02011050400000000201819114519VBHC0141F7&patentType=patent2&patentLib=&_sessionID=sR6we7Q33z8PsZFF"
                       target="_blank" class="question-title">
                        公路气象站系统 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU0201205160000000020222011451O0GB40161FA&patentType=patent2&patentLib=&_sessionID=chKDQf7SfX6tpKKE"
                       target="_blank" class="question-title">
                        LED节能灯 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA02018051100000000108028125E0AIQKM014E62&patentType=patent2&patentLib=&_sessionID=QbPbaaDWHwGjQH33"
                       target="_blank" class="question-title">
                        红外LED </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA02013091100000000103297114904BLGA012F19&patentType=patent2&patentLib=&_sessionID=dcGXfmXQRi78p3yz"
                       target="_blank" class="question-title">
                        蓝牙-WIFI网关 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNU02010051900000000201476114515M9ES0152CA&patentType=patent2&patentLib=&_sessionID=H5P5dKxS5wQwSttb"
                       target="_blank" class="question-title">
                        称重传感器 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA0201808070000000010837612890ELDPF013368&patentType=patent2&patentLib=&_sessionID=JhKY2fkjT8cZEdGr"
                       target="_blank" class="question-title">
                        一种基于Arduino的阵列语音采集系统及采集方法 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDCNA0201808310000000010846412930AH818017F98&patentType=patent2&patentLib=&_sessionID=RibAReQWRxZbGbCz"
                       class="question-title"
                       target="_blank" id="more_wiki">
                        一种樱桃种植用灌溉光照调节装置 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDUSA1201708170000002017023611AJ26TB7K0118B7&patentType=patent2&patentLib=&_sessionID=33xhBpFeWDZfcs4G"
                       class="question-title" target="_blank" id="more_patent">
                        WIFI TRANSACTIONS </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/patentdetail?isNewWindow=yes&pid=PIDUSA12018062100000020180176126T2DPIRK010FDE&patentType=patent2&patentLib=&_sessionID=awzbfyQEMhYQaFAZ"
                       class="question-title" target="_blank" id="more_patent">
                        TCP Bufferbloat Resolution </a>
                </li>
                <li class="list-group-item">
                    <a href="http://www.so.iptrm.com/app/authorization?isNewWindow=yes&pid=PIDUSB22017032800000000009609117C04BM250124A1&patentType=patent2&patentLib=&_sessionID=NTCBE8sJbXj7a4fX"
                       class="question-title" target="_blank" id="more_patent">
                        HTTP proxy </a>
                </li>
            </ul>
        </div>
    </div>
    <!--论文-->
    <div class="related_wikis">
        <div class="sidebar_list_header">
            <p>相关论文</p>
            <a href="https://www.zhihu.com/question/34903516/answer/68547441" target="_blank"
               style="margin-left: 10px;font-size: 12px;color: darkgray;font-weight: normal">论文撰写教程</a>
            <a id="sidebar_list_link" onclick="show_more_paper()">更多</a>
        </div>
        <!--分割线-->
        <div style="height: 2px;background-color: lightgray"></div>
        <div class="related_wiki" id="related_paper">
            <ul style="padding-left: 0px">
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%286511d201fec9664c33a63d5c80f172bd%29&filter=sc_long_sign&sc_ks_para=q%3D%E4%B8%AD%E5%9B%BD%E5%8C%BA%E5%9F%9F%E8%87%AA%E5%8A%A8%E6%B0%94%E8%B1%A1%E7%AB%99%E8%BF%90%E8%A1%8C%E7%9B%91%E6%8E%A7%E7%B3%BB%E7%BB%9F%E5%BB%BA%E8%AE%BE&sc_us=9577558459288850597&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        中国区域自动气象站运行监控系统建设 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%281f7993a9b43d9a898ebcb9212265c508%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8E%E6%97%A0%E7%BA%BF%E4%BC%A0%E6%84%9F%E5%99%A8%E7%BD%91%E7%BB%9C%E7%9A%84%E5%BA%94%E6%80%A5%E6%B0%94%E8%B1%A1%E8%A7%82%E6%B5%8B%E7%B3%BB%E7%BB%9F%E8%AE%BE%E8%AE%A1&sc_us=10547582628123977144&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        基于无线传感器网络的应急气象观测系统设计 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28f79a61fea0c2a04fbcddf2808834d4c4%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8E%E9%AB%98%E9%80%9F%E5%85%AC%E8%B7%AF%E6%B0%94%E8%B1%A1%E7%9B%91%E6%B5%8B%E6%95%B0%E6%8D%AE%E5%88%86%E6%9E%90%E7%9A%84%E6%B5%93%E9%9B%BE%E9%A2%84%E6%8A%A5%E6%8C%87%E6%A0%87&sc_us=6486927265351682660&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        基于高速公路气象监测数据分析的浓雾预报指标 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%2872066344866dd32f60931e031ec15b22%29&filter=sc_long_sign&sc_ks_para=q%3DHeat%20and%20fluid%20flow%20in%20high-power%20LED%20packaging%20and%20applications&sc_us=10168108634810893133&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        Heat and fluid flow in high-power LED packaging and applications </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28a5cf762686afd0a6cfe0fb0b6ba88bd2%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8E%E6%9E%9C%E8%9D%87%E4%BC%98%E5%8C%96%E7%AE%97%E6%B3%95%E7%9A%84%E4%B8%89%E7%BB%B4LED%E5%85%89%E6%BA%90%E9%98%B5%E5%88%97%E4%BC%98%E5%8C%96%E8%AE%BE%E8%AE%A1&sc_us=8359613791293871464&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        基于果蝇优化算法的三维LED光源阵列优化设计 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%281c1b3c89d3741208870d5b4a1a14e80d%29&filter=sc_long_sign&sc_ks_para=q%3DZigBee%E4%B8%8E%E8%93%9D%E7%89%99%E7%9A%84%E5%88%86%E6%9E%90%E4%B8%8E%E6%AF%94%E8%BE%83&sc_us=2045037250759201464&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        ZigBee与蓝牙的分析与比较 </a>
                </li>
            </ul>
        </div>

        <div class="more_related_wiki" id="more_related_paper" style="display: none">
            <ul style="padding-left: 0px; ">
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%286511d201fec9664c33a63d5c80f172bd%29&filter=sc_long_sign&sc_ks_para=q%3D%E4%B8%AD%E5%9B%BD%E5%8C%BA%E5%9F%9F%E8%87%AA%E5%8A%A8%E6%B0%94%E8%B1%A1%E7%AB%99%E8%BF%90%E8%A1%8C%E7%9B%91%E6%8E%A7%E7%B3%BB%E7%BB%9F%E5%BB%BA%E8%AE%BE&sc_us=9577558459288850597&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        中国区域自动气象站运行监控系统建设 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%281f7993a9b43d9a898ebcb9212265c508%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8E%E6%97%A0%E7%BA%BF%E4%BC%A0%E6%84%9F%E5%99%A8%E7%BD%91%E7%BB%9C%E7%9A%84%E5%BA%94%E6%80%A5%E6%B0%94%E8%B1%A1%E8%A7%82%E6%B5%8B%E7%B3%BB%E7%BB%9F%E8%AE%BE%E8%AE%A1&sc_us=10547582628123977144&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        基于无线传感器网络的应急气象观测系统设计 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28f79a61fea0c2a04fbcddf2808834d4c4%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8E%E9%AB%98%E9%80%9F%E5%85%AC%E8%B7%AF%E6%B0%94%E8%B1%A1%E7%9B%91%E6%B5%8B%E6%95%B0%E6%8D%AE%E5%88%86%E6%9E%90%E7%9A%84%E6%B5%93%E9%9B%BE%E9%A2%84%E6%8A%A5%E6%8C%87%E6%A0%87&sc_us=6486927265351682660&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        基于高速公路气象监测数据分析的浓雾预报指标 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%2872066344866dd32f60931e031ec15b22%29&filter=sc_long_sign&sc_ks_para=q%3DHeat%20and%20fluid%20flow%20in%20high-power%20LED%20packaging%20and%20applications&sc_us=10168108634810893133&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        Heat and fluid flow in high-power LED packaging and applications </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28a5cf762686afd0a6cfe0fb0b6ba88bd2%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8E%E6%9E%9C%E8%9D%87%E4%BC%98%E5%8C%96%E7%AE%97%E6%B3%95%E7%9A%84%E4%B8%89%E7%BB%B4LED%E5%85%89%E6%BA%90%E9%98%B5%E5%88%97%E4%BC%98%E5%8C%96%E8%AE%BE%E8%AE%A1&sc_us=8359613791293871464&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        基于果蝇优化算法的三维LED光源阵列优化设计 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%281c1b3c89d3741208870d5b4a1a14e80d%29&filter=sc_long_sign&sc_ks_para=q%3DZigBee%E4%B8%8E%E8%93%9D%E7%89%99%E7%9A%84%E5%88%86%E6%9E%90%E4%B8%8E%E6%AF%94%E8%BE%83&sc_us=2045037250759201464&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        ZigBee与蓝牙的分析与比较 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28fabd26129ed1be4df2634dbbfd7813aa%29&filter=sc_long_sign&sc_ks_para=q%3DArduino%3A%20a%20low-cost%20multipurpose%20lab%20equipment.&sc_us=1963658631356660655&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        Arduino: a low-cost multipurpose lab equipment </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28355b2339b20c396239f8d8abe737e5f8%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8E%E7%BA%A2%E5%A4%96%E4%BC%A0%E6%84%9F%E5%99%A8%E7%9A%84%E6%99%BA%E8%83%BD%E6%95%99%E5%AE%A4%E7%85%A7%E6%98%8E%E6%8E%A7%E5%88%B6&sc_us=4489042973294239552&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       target="_blank" class="question-title">
                        基于红外传感器的智能教室照明控制 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28caec31e757e12b1e9ce257bd9df7971c%29&filter=sc_long_sign&sc_ks_para=q%3DExploring%20mobile%2FWiFi%20handover%20with%20multipath%20TCP&sc_us=10274875248912255968&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       class="question-title"
                       target="_blank" id="more_wiki">
                        Exploring mobile/WiFi handover with multipath TCP </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28b859962ca7d0c2a79ba10b29927163e0%29&filter=sc_long_sign&sc_ks_para=q%3DTCP%20Extensions%20for%20Multipath%20Operation%20with%20Multiple%20Addresses&sc_us=3632409001235107039&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       class="question-title" target="_blank" id="more_patent">
                        TCP Extensions for Multipath Operation with Multiple Addresses </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%281ef14ce097037b249bd6542fb8ce844f%29&filter=sc_long_sign&sc_ks_para=q%3D%E5%9F%BA%E4%BA%8EHTTP%E5%8D%8F%E8%AE%AE%E7%9A%84%E5%9C%B0%E8%B4%A8%E7%81%BE%E5%AE%B3%E6%95%B0%E6%8D%AE%E4%BC%A0%E8%BE%93%E7%B3%BB%E7%BB%9F%E8%AE%BE%E8%AE%A1&sc_us=11390142739195011222&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       class="question-title" target="_blank" id="more_patent">
                        基于HTTP协议的地质灾害数据传输系统设计 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%28099ddd3d36d0e04fed41a56fbccb30bb%29&filter=sc_long_sign&sc_ks_para=q%3DSpring%20MVC%E6%A1%86%E6%9E%B6%E5%BC%80%E5%8F%91WEB%E5%BA%94%E7%94%A8%E7%A8%8B%E5%BA%8F%E7%9A%84%E6%8E%A2%E7%B4%A2%E4%B8%8E%E7%A0%94%E7%A9%B6&sc_us=11406744225561867708&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       class="question-title" target="_blank" id="more_patent">
                        Spring MVC框架开发WEB应用程序的探索与研究 </a>
                </li>
                <li class="list-group-item">
                    <a href="http://xueshu.baidu.com/s?wd=paperuri%3A%2887a172a1410051f641bc5fe6140d703d%29&filter=sc_long_sign&sc_ks_para=q%3D%E8%93%9D%E7%89%99%E6%A8%A1%E5%9D%97%E4%B8%B2%E5%8F%A3%E9%80%9A%E4%BF%A1%E7%9A%84%E8%AE%BE%E8%AE%A1%E4%B8%8E%E5%AE%9E%E7%8E%B0&sc_us=11743206145125558581&tn=SE_baiduxueshu_c1gjeupa&ie=utf-8"
                       class="question-title" target="_blank" id="more_patent">
                        蓝牙模块串口通信的设计与实现 </a>
                </li>
            </ul>
        </div>
    </div>
    <!--相关项目-->
    <?php
    $related_pros = wikiRelatedPro(get_the_ID());
    if (sizeof($related_pros) != 0) {
        ?>
        <div class="related_pros">
            <div class="sidebar_list_header">
                <p>相关项目</p>
                <a id="sidebar_list_link" onclick="show_more_pros()">更多</a>
            </div>
            <!--分割线-->
            <div style="height: 2px;background-color: lightgray"></div>
            <div class="related_pros" id="related_pros">
                <ul style="padding-left: 0px">
                    <?php
                    //控制条数
                    if (sizeof($related_pros) < 5) {
                        $length = sizeof($related_pros);
                    } else {
                        $length = 5;
                    }
                    for ($i = 0; $i < $length; $i++) { ?>
                        <li class="list-group-item">
                            <div style="display: inline;">
                                <?php
                                if (has_post_thumbnail($related_pros[$i])) { ?>
                                    <a href="<?php the_permalink($related_pros[$i]); ?>" target="_blank"><img
                                                src="<?php echo get_the_post_thumbnail_url($related_pros[$i], '30') ?>"
                                                class="cover" height="50px" width="90px"/></a>
                                <?php } else { ?>
                                    <a href="<?php the_permalink($related_pros[$i]); ?>" target="_blank"><img
                                                src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面"
                                                style="width: 90px;height: 50px" class="cover"/></a>
                                <?php } ?>
                            </div>
                            <div style="width: 63%;float: right;">
                                <a href="<?php echo get_permalink($related_pros[$i]); ?>"
                                   style="word-wrap: break-word;word-break: break-all"
                                   class="question-title"><?php echo get_the_title($related_pros[$i]); ?></a>
                            </div>

                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="more_related_pros" id="more_related_pros" style="display: none">
                <ul style="padding-left: 0px">
                    <?php
                    //控制条数
                    if (sizeof($related_pros) >= 15) {
                        $length = 15;
                    } else {
                        $length = sizeof($related_pros);
                    }

                    for ($i = 0; $i < $length; $i++) { ?>
                        <li class="list-group-item">
                            <div style="display: inline;">
                                <?php
                                if (has_post_thumbnail($related_pros[$i])) { ?>
                                    <a href="<?php the_permalink($related_pros[$i]); ?>" target="_blank"><img
                                                src="<?php the_post_thumbnail_url('30') ?>" class="cover" height="50px"
                                                width="90px"/></a>
                                <?php } else { ?>
                                    <a href="<?php the_permalink($related_pros[$i]); ?>" target="_blank"><img
                                                src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面"
                                                style="width: 90px;height: 50px" class="cover"/></a>
                                <?php } ?>
                            </div>
                            <div style="width: 63%;float: right;">
                                <a href="<?php echo get_permalink($related_pros[$i]); ?>"
                                   style="word-wrap: break-word;word-break: break-all"
                                   class="question-title"><?php echo get_the_title($related_pros[$i]); ?></a>
                            </div>

                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php } ?>

    <!--知新-->
    <?php
    $wiki_recommend = wikiRecommend($current_user->ID);
    $wiki_review = wikiReview($current_user->ID);
    if (sizeof($wiki_recommend) != 0) {
        ?>
        <div class="wiki_recommends">
            <div class="sidebar_list_header">
                <p>推荐学习</p>
            </div>
            <!--分割线-->
            <div style="height: 2px;background-color: lightgray"></div>
            <div class="wiki_recommend" id="wiki_recommend">
                <ul style="padding-left: 0px">
                    <?php
                    for ($i = 0; $i < sizeof($wiki_recommend); $i++) { ?>
                        <li class="list-group-item">
                            <a href="<?php echo get_permalink($wiki_recommend[$i]); ?>" class="question-title">
                                <?php echo get_the_title($wiki_recommend[$i]); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php }
    if (sizeof($wiki_review) != 0) {
        ?>
        <div class="wiki_recommends">
            <div class="sidebar_list_header">
                <p>温故知新</p>
            </div>
            <!--分割线-->
            <div style="height: 2px;background-color: lightgray"></div>
            <div class="wiki_review" id="wiki_review">
                <ul style="padding-left: 0px">
                    <?php
                    for ($i = 0; $i < sizeof($wiki_review); $i++) { ?>
                        <li class="list-group-item">
                            <a href="<?php echo get_permalink($wiki_review[$i]); ?>" class="question-title">
                                <?php echo get_the_title($wiki_review[$i]); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php }
    ?>

</div>
<script>
    var flag = false;

    function show_more_pros() {
        var related_pros = document.getElementById('related_pros');
        var more_related_pros = document.getElementById('more_related_pros');
        if (flag) {
            related_pros.style.display = "block";
            more_related_pros.style.display = "none";
        } else {
            related_pros.style.display = "none";
            more_related_pros.style.display = "block";
        }
        flag = !flag;
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

</script>
