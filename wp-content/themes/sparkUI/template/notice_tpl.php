<?php
global $wpdb;
$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;

$allMsg = array();
$allMsgIndex = 0;

//1.获取评论当前用户的数据
//step1: 获取所有当前用户发布的post表中的条目ID
$user_posts = $wpdb->get_results("select ID from $wpdb->posts where post_status = 'publish' and post_author=" . $current_user_id);
$user_post_ids = array();
foreach ($user_posts as $item) {
    $user_post_ids[] = $item->ID;
}
//step2: 获取这些post的comment数据
$comments_user = array();
$comments_posts_ids = generate_sql_structure($user_post_ids);
if ($comments_posts_ids != "") {
    //获取全部当前用户post的评论
    $sql_comment = "select comment_ID,comment_post_ID,comment_author,comment_date,comment_content,user_id from $wpdb->comments where comment_post_ID in " . $comments_posts_ids . " and comment_parent=0";
    $comments_to_current_user_posts = $wpdb->get_results($sql_comment);
    foreach ($comments_to_current_user_posts as $item) {
        $comments_user[] = $item;
    }
}
foreach ($comments_user as $item_temp) {
    $item_temp->msg_type = 1;
    $allMsg[] = $item_temp;
}

//2.获取回复当前用户的数据,当前用户评论了,之后有人回复
$user_all_comments = $wpdb->get_results("select * from $wpdb->comments where user_id=" . $current_user_id);
$user_comments_ids = array();
foreach ($user_all_comments as $item) {
    $user_comments_ids[] = $item->comment_ID;
}
$user_comments_ids_str = generate_sql_structure($user_comments_ids);
$user_replys = array();
if ($user_comments_ids_str != "") {
    $replys = $wpdb->get_results("select * from $wpdb->comments where comment_parent in " . $user_comments_ids_str);
    foreach ($replys as $item) {
        $user_replys[] = $item;
    }
}
foreach ($user_replys as $item_temp) {
    $item_temp->msg_type = 2;
    $allMsg[] = $item_temp;
}


//3.获取问答数据(在wiki,项目和项目页面提问)
$related_qas = array();
$user_post_qa_ids = generate_sql_structure($user_post_ids);
if ($user_post_qa_ids != "") {
    //$qas = $wpdb->get_results("select * from wp_relation r left join wp_posts p on r.related_id=p.ID where r.post_id in ".$user_post_qa_ids." and r.post_type=\"yada_wiki\" and r.related_post_type=\"dwqa-question\"");
    $qas = $wpdb->get_results("select * from wp_relation r left join wp_posts p on r.related_id=p.ID where r.post_id in " . $user_post_qa_ids . " and r.post_type in (\"yada_wiki\", \"post\") and r.related_post_type=\"dwqa-question\"");
    foreach ($qas as $item) {
        $related_qas[] = $item;
    }
}
foreach ($related_qas as $item_temp) {
    $item_temp->msg_type = 3;
    $allMsg[] = $item_temp;
}

//4.获取当前用户收到的答案(问题有人回复了)
$user_all_questions = $wpdb->get_results("select * from $wpdb->posts where post_author=" . $current_user_id . " and post_type = \"dwqa-question\" and post_parent=0");
$user_question_ids = array();
foreach ($user_all_questions as $item) {
    $user_question_ids[] = $item->ID;
}
$user_receive_answer = array();
$parent_questions = generate_sql_structure($user_question_ids);
if ($parent_questions != "") {
    $user_receive_answer_result = $wpdb->get_results("select * from $wpdb->posts where post_type = \"dwqa-answer\" and post_parent in " . $parent_questions);
    foreach ($user_receive_answer_result as $item) {
        $user_receive_answer[] = $item;
    }
}
foreach ($user_receive_answer as $item_temp) {
    $item_temp->msg_type = 4;
    $allMsg[] = $item_temp;
}

//5.获取被采纳的答案(当前用户的回答被采纳了)
$user_best_answers_result = $wpdb->get_results("select * from $wpdb->posts p left join $wpdb->postmeta pm on pm.meta_value=p.ID where p.post_type=\"dwqa-answer\" and pm.meta_key=\"_dwqa_best_answer\" and p.post_author=" . $current_user_id);
$user_best_answer = array();
foreach ($user_best_answers_result as $item) {
    $user_best_answer[] = $item;
}
foreach ($user_best_answer as $item_temp) {
    $item_temp->msg_type = 5;
    $allMsg[] = $item_temp;
}

//6.获取点赞的数据，解析meta中的表达式
$user_answer_favor_result = $wpdb->get_results("select * from $wpdb->posts p left join $wpdb->postmeta pm on p.ID=pm.post_id where p.post_type=\"dwqa-answer\" and pm.meta_key=\"_dwqa_votes_log\" and p.post_author=" . $current_user_id);
$user_answer_favors = array();
foreach ($user_answer_favor_result as $item) {
    $meta_value = $item->meta_value;
    $pattern = "/{(.*)}/";
    preg_match($pattern, $meta_value, $match);
    $meta_value_explode = explode(';', $match[1]);
    $favour_users = array();
    for ($index = 0; $index < count($meta_value_explode); $index++) {
        if ($index % 2 == 0) {
            $favour_users[] = substr($meta_value_explode[$index], -1); //从i:1中提取出1
        }
    }
    $str_index = $item->post_id;
    $user_answer_favors[$str_index] = $favour_users;
}
foreach ($user_answer_favors as $key => $value) {
    $item_temp_6 = new stdClass();
    $item_temp_6->msg_type = 6;
    $item_temp_6->key = $key;
    $allMsg[] = $item_temp_6;
}

//7、获得wiki、项目修改通知



usort($allMsg, 'sortByTime');

function sortByTime($a, $b)
{
    if ($a->msg_type == 1 || $a->msg_type == 2) {
        $a->post_modified = $a->comment_date;
    }
    if ($b->msg_type == 1 || $b->msg_type == 2) {
        $b->post_modified = $b->comment_date;
    }

    if ($a->post_modified == $b->post_modified) {
        return 0;
    } else {
        return ($a->post_modified < $b->post_modified) ? 1 : -1;
    }
}

$pro_length = count($related_qas) + count($comments_user) + count($user_replys)
    + count($user_receive_answer) + count($user_best_answer) + count($user_answer_favors);
$perpage = 10;
$total_page = ceil($pro_length / $perpage);

if (!$_GET['paged']) {
    $current_page = 1;
} else {
    $page_num = $_GET['paged'];
    $current_page = $page_num;
}
?>
<style>
    #notice-ava {
        display: inline-block;
        vertical-align: top;
        margin-top: 4px;
        margin-left: 10px
    }
</style>
<div class="divline" style="margin-top: 0px"></div>
<div id="rightTabContent" class="tab-content">
    <ul class="list-group">
        <?php if (count($allMsg) > 0) {
            //显示一页的东西
            $min_temp = $pro_length < $perpage * $current_page ? $pro_length : $perpage * $current_page;
            for ($i = $perpage * ($current_page - 1); $i < $min_temp; $i++) { ?>
                <li class="list-group-item">
                    <?php if ($allMsg[$i]->msg_type == 1) {  //有人给我评论
                    $comment_author_id = $allMsg[$i]->user_id;   //评论人id
                    $comment_author = $allMsg[$i]->comment_author; //评论人name
                    $parent_post_link = get_permalink($allMsg[$i]->comment_post_ID); //被评论的词条或项目链接
                    $parent_post_title = get_the_title($allMsg[$i]->comment_post_ID); //被评论的词条或项目名称
                    $parent_post_type = get_post_type($allMsg[$i]->comment_post_ID); //被评论的词条或项目类型
                    $comment_content = $allMsg[$i]->comment_content;//评论或回复内容
                    $comment_date = $allMsg[$i]->comment_date; //日期
                    ?>
                    <div id="notice-ava">
                        <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                    </div>
                    <div id="notice-content" style="display: inline-block;width:92%;">
                        <div id="notice-info" style="display: inline-block;margin-left: 3%">
                            <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $comment_author_id; ?>"
                               style="color: #169bd5"><?= $comment_author ?></a>
                            <?php
                            if ($parent_post_type == "yada_wiki") {
                                echo "<span>&nbsp;<span style=\"font-weight: bolder\">评论</span>了您的词条</span>";
                            } else {
                                echo "<span>&nbsp;<span style=\"font-weight: bolder\">评论</span>了您的项目</span>";
                            } ?>
                            <span><a href="<?= $parent_post_link ?>" style="color:#169bd5"><?= $parent_post_title ?></a></span>
                            <div style="margin-top: 5px"><?= $comment_content ?></div>
                        </div>
                        <div id="notice-time" style="display: inline-block;float: right">
                            <?php
                            if ($parent_post_type == "yada_wiki") {
                                echo "<div class=\"badge\" id=\"my_group_badge\" style=\"float: inherit;margin-top: 0px\">wiki</div>";
                            } else {
                                echo "<span class=\"badge\" id=\"my_group_badge\" style=\"float: inherit;margin-top: 0px\">项目</span>";
                            } ?>
                            <div style="margin-top: 30px"><?= $comment_date ?></div>
                        </div>
                    </div>
                    <?php }
                    else if ($allMsg[$i]->msg_type == 2) {
                        $comment_author_id = $allMsg[$i]->user_id;
                        $comment_author = $allMsg[$i]->comment_author;
                        $parent_post_link = get_permalink($allMsg[$i]->comment_post_ID);
                        $parent_post_title = get_the_title($allMsg[$i]->comment_post_ID);
                        $parent_post_type = get_post_type($allMsg[$i]->comment_post_ID);
                        $comment_content = $allMsg[$i]->comment_content;
                        $comment_date = $allMsg[$i]->comment_date;
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $comment_author_id; ?>"
                                   style="color: #169bd5"><?= $comment_author ?></a>
                                <?php
                                if ($parent_post_type == "yada_wiki") {
                                    echo "<span>&nbsp;在词条</span>";
                                } else {
                                    echo "<span>&nbsp;在项目</span>";
                                } ?>
                                <span><a href="<?= $parent_post_link ?>" style="color:#169bd5"><?= $parent_post_title ?></a></span>
                                <span>中<span style="font-weight: bolder">回复</span>了你</span>
                                <div style="margin-top: 5px"><?= $comment_content ?></div>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <?php
                                if ($parent_post_type == "yada_wiki") {
                                    echo "<div class=\"badge\" id=\"my_group_badge\" style=\"float: inherit;margin-top: 0px\">wiki</div>";
                                } else {
                                    echo "<span class=\"badge\" id=\"my_group_badge\" style=\"float: inherit;margin-top: 0px\">项目</span>";
                                } ?>
                                <div style="margin-top: 30px"><?= $comment_date ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->msg_type == 3){ //在wiki或项目中提问
                        $ask_author_id = $allMsg[$i]->post_author;  //提问人ID
                        $ask_author_name = get_the_author_meta('user_login',$ask_author_id);
                        $parent_post_title = get_the_title($allMsg[$i]->post_id);
                        $parent_post_link = get_permalink($allMsg[$i]->post_id);
                        $parent_post_type = get_post_type($allMsg[$i]->post_id);
                        $question_title = get_the_title($allMsg[$i]->ID);
                        $question_link = get_permalink($allMsg[$i]->ID);
                        $ask_date = $allMsg[$i]->post_date;
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $ask_author_id; ?>"
                                   style="color: #169bd5"><?= $ask_author_name ?></a>
                                <?php
                                if ($parent_post_type == "yada_wiki") {
                                    echo "<span>&nbsp;在词条</span>";
                                } else {
                                    echo "<span>&nbsp;在项目</span>";
                                } ?>
                                <span><a href="<?= $parent_post_link ?>" style="color:#169bd5"><?= $parent_post_title ?></a></span>
                                <span>中向你<span style="font-weight: bolder">提问</span></span>
                                <div style="margin-top: 5px">
                                    <a href="<?=$question_link?>" style="color: #169bd5"><?= $question_title ?></a>
                                </div>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <?php
                                if ($parent_post_type == "yada_wiki") {
                                    echo "<div class=\"badge\" id=\"my_group_badge\" style=\"float: inherit;margin-top: 0px\">wiki</div>";
                                } else {
                                    echo "<span class=\"badge\" id=\"my_group_badge\" style=\"float: inherit;margin-top: 0px\">项目</span>";
                                } ?>
                                <div style="margin-top: 30px"><?= $ask_date ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->msg_type == 4) {
                        $ans_author_id = $allMsg[$i]->post_author;  //回答人ID
                        $ans_author_name = get_the_author_meta('user_login',$ans_author_id); //回答人姓名
                        $parent_post_title = get_the_title($allMsg[$i]->post_parent);  //问题名称
                        $parent_post_link = get_permalink($allMsg[$i]->post_parent);   //问题链接
                        $ans_content = $allMsg[$i]->post_content;
                        $ans_date = $allMsg[$i]->post_date;?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $ans_author_id; ?>"
                                   style="color: #169bd5"><?= $ans_author_name ?></a>
                                <span>&nbsp;<span style="font-weight: bolder">回答</span>了您的问题</span>
                                <span><a href="<?= $parent_post_link ?>" style="color:#169bd5"><?= $parent_post_title ?></a></span>
                                <div style="margin-top: 5px"><?= $ans_content ?></div>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">问答</div>
                                <div style="margin-top: 30px"><?= $ans_date ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->msg_type == 5) {
                        $parent_post_title = get_the_title($allMsg[$i]->post_parent);  //问题名称
                        $parent_post_link = get_permalink($allMsg[$i]->post_parent);   //问题链接
                        $question_author = get_the_author($allMsg[$i]->post_parent);   //提问人name
                        $question_author_id = get_the_ID_by_name($question_author);    //提问人id
                        $ans_content = $allMsg[$i]->post_content;
                        $ans_date = $allMsg[$i]->post_date;
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $question_author_id; ?>"
                                   style="color: #169bd5"><?= $question_author ?></a>
                                <span>&nbsp;在问题</span>
                                <a href="<?= $parent_post_link ?>" style="color:#169bd5"><?= $parent_post_title ?></a>
                                <span>中<span style="font-weight: bolder">采纳</span>了您的答案</span>
                                <div style="margin-top: 5px">
                                    <span class="label label-default" id="btn-solved">已采纳</span>
                                    <?= $ans_content ?>
                                </div>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">问答</div>
                                <div style="margin-top: 30px"><?= $ans_date ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->msg_type == 6) {
                        $post = get_post($allMsg[$i]->key);
                        $parent_post_title = get_the_title($post->post_parent);  //问题名称
                        $parent_post_link = get_permalink($post->post_parent);   //问题链接
                        $ans_content = $post->post_content;
                        $ans_date = $post->post_date;
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <span>&nbsp;有人在问题</span>
                                <a href="<?= $parent_post_link ?>" style="color:#169bd5"><?= $parent_post_title ?></a>
                                <span>中<span style="font-weight: bolder">赞同了</span>了您的答案</span>
                                <div style="margin-top: 5px"><?= $ans_content ?></div>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">问答</div>
                                <div style="margin-top: 30px"><?= $ans_date ?></div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="divline"></div>
                </li>
            <?php }
        } else { ?>
            <div style="height: 1px;background-color: lightgray;"></div>
            <div class="alert alert-info" style="margin-top: 20px">Oops,还没有收到消息</div>
        <?php } ?>
    </ul>
    <?php if ($total_page > 1) { ?>
        <div id="page_favorite" style="text-align:center;margin-bottom: 20px">
            <!--翻页的超链接-->
            <a href="<?php echo add_query_arg(array('paged' => 1)) ?>">首页</a>
            <?php if ($current_page == 1) { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) ?>">下一页&nbsp;&raquo;</a>
            <?php } elseif ($current_page == $total_page) { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) ?>">&laquo;&nbsp;上一页</a>
            <?php } else { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) ?>">&laquo;&nbsp;上一页&nbsp;</a>
                <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) ?>">&nbsp;下一页&nbsp;&raquo;</a>
            <?php } ?>
            <a href="<?php echo add_query_arg(array('paged' => $total_page)) ?>">尾页</a>
            共<?= $total_page ?>页
        </div>
    <?php } ?>
</div>
