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
    <?php
    $related_patents  = RelatedPatents($post_id);
    //var_dump($related_patents);
    if($related_patents){ ?>
    <div class="related_wikis">
        <div class="sidebar_list_header">
            <p>相关专利</p>
            <a href="http://www.sipo.gov.cn/zhfwpt/zlsqzn/zlsqspcxjs/zlsqsplc/" target="_blank"
               style="margin-left: 10px;font-size: small;color: darkgray;font-weight:normal">专利申请流程</a>
        </div>
        <!--分割线-->
        <div style="height: 2px;background-color: lightgray"></div>
        <div class="related_wiki" id="related_patent">
            <ul style="padding-left: 0px">
               <?php foreach ($related_patents as $res){
                   if(strcmp($res->patent_url,'None')!=0){?>
                       <li class="list-group-item">

                           <a href="<?php echo  site_url().get_page_address('daima_url').'&url='.urlencode($res->patent_url).'&page=patent' ?>"
                              target="_blank" class="question-title">
                               <?php echo $res->patent_title?> </a>
                       </li>
                   <?php }
               }?>
            </ul>
        </div>
    </div>
    <?php }?>


    <!--论文-->
    <?php
    $related_papers  = RelatedPapers($post_id);
    //var_dump($related_patents);
    if($related_papers){ ?>
        <div class="related_wikis">
            <div class="sidebar_list_header">
                <p>相关论文</p>
                <a href="https://www.zhihu.com/question/34903516/answer/68547441" target="_blank" style="margin-left: 10px;font-size: 12px;color: darkgray;font-weight: normal">论文撰写教程</a>
            </div>
            <!--分割线-->
            <div style="height: 2px;background-color: lightgray"></div>
            <div class="related_wiki" id="related_paper">
                <ul style="padding-left: 0px">
                    <?php foreach ($related_papers as $res){
                        if(strcmp($res->paper_url,'None')!=0){?>
                            <li class="list-group-item">
                                <a href="<?php echo site_url().get_page_address('daima_url').'&url='.urlencode($res->paper_url).'&page=paper'?>"
                                   target="_blank" class="question-title">
                                    <?php echo $res->paper_title?> </a>
                            </li>
                        <?php }
                    }?>
                </ul>
            </div>
        </div>
    <?php }?>
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
