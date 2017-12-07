<?php

$allMsg = get_allMsg();

function get_allMsg()
{
    global $wpdb;
    $current_user_id = get_current_user_id();
    $sql = "SELECT * FROM wp_gp_notice WHERE user_id = $current_user_id ORDER BY modified_time DESC";
    $result = $wpdb->get_results($sql);
    return $result;
}

$pro_length = count($allMsg);
$perpage = 10;
$total_page = ceil($pro_length / $perpage);

if (!$_GET['paged']) {
    $current_page = 1;
} else {
    $page_num = $_GET['paged'];
    $current_page = $page_num;
}
//print_r($allMsg);
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
            for ($i = $perpage * ($current_page - 1); $i < $min_temp; $i++) {?>
                <li class="list-group-item">
                    <?php if ($allMsg[$i]->notice_type == 1) {  //自由加入群组有人加入群组
                        // XX加入了你的群组XX
                        $joiner = $allMsg[$i]->notice_content;   //加入人的id 是否需要转换
                        $joiner_name = get_author_name($joiner);  ###########
                        $group_id = $allMsg[$i]->group_id;      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $time = $allMsg[$i]->modified_time;  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $joiner; ?>"
                                   style="color: #169bd5"><?= $joiner_name ?></a>
                                <span>&nbsp;<span style="font-weight: bolder">加入</span>了您的群组</span>
                                <span><a
                                        href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group_id ?>"
                                        style="color:#169bd5"><?= $group_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">设为已读</div>
                                <div style="margin-top: 30px"><?= $time ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->msg_type == 2) {
                        // XX加入了你的群组XX
                        $joiner = $allMsg[$i]->notice_content;   //加入人的id 是否需要转换
                        $joiner_name = get_author_name($joiner);  ###########
                        $group_id = $allMsg[$i]->group_id;      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $time = $allMsg[$i]->modified_time;  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $joiner; ?>"
                                   style="color: #169bd5"><?= $joiner_name ?></a>
                                <span>&nbsp;<span style="font-weight: bolder">加入</span>了您的群组</span>
                                <span><a
                                        href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group_id ?>"
                                        style="color:#169bd5"><?= $group_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">设为已读</div>
                                <div style="margin-top: 30px"><?= $time ?></div>
                            </div>
                        </div>
                    <?php } else if ($allMsg[$i]->msg_type == 3) { //在wiki或项目中提问
                        $ask_author_id = $allMsg[$i]->post_author;  //提问人ID
                        $ask_author_name = get_author_name($ask_author_id);
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
                                <span><a href="<?= $parent_post_link ?>"
                                         style="color:#169bd5"><?= $parent_post_title ?></a></span>
                                <span>中向你<span style="font-weight: bolder">提问</span></span>
                                <div style="margin-top: 5px">
                                    <a href="<?= $question_link ?>" style="color: #169bd5"><?= $question_title ?></a>
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
                    <?php } else if ($allMsg[$i]->msg_type == 4) {
                        $ans_author_id = $allMsg[$i]->post_author;  //回答人ID
                        $ans_author_name = get_author_name($ans_author_id); //回答人姓名
                        $parent_post_title = get_the_title($allMsg[$i]->post_parent);  //问题名称
                        $parent_post_link = get_permalink($allMsg[$i]->post_parent);   //问题链接
                        $ans_content = $allMsg[$i]->post_content;
                        $ans_date = $allMsg[$i]->post_date; ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $ans_author_id; ?>"
                                   style="color: #169bd5"><?= $ans_author_name ?></a>
                                <span>&nbsp;<span style="font-weight: bolder">回答</span>了您的问题</span>
                                <span><a href="<?= $parent_post_link ?>"
                                         style="color:#169bd5"><?= $parent_post_title ?></a></span>
                                <div style="margin-top: 5px"><?= $ans_content ?></div>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">问答</div>
                                <div style="margin-top: 30px"><?= $ans_date ?></div>
                            </div>
                        </div>
                    <?php } else if ($allMsg[$i]->msg_type == 5) {
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
                    <?php } else if ($allMsg[$i]->msg_type == 6) {
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
            <strong>Oops!!还没有收到消息。</strong>
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