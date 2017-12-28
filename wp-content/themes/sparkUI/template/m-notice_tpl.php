<?php
$allMsg = get_allNotice();
$pro_length = count($allMsg);
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
    #notice-info {
        display: inline-block;
        margin-left: 3%;
        width: 75%;
    }
</style>
<script>
    function all_notice_read_delete() {
        layer.confirm('确定删除所有已读通知?', {
            icon: 3,
            resize:false,
            move:false,
            title:false,
            btnAlign: 'c',
            btn: ['确认', '取消'],
            btn2: function (index) {   //取消的回调
                layer.close(index);
            },
            btn1: function () {   //确认的回调
                var data = {
                    action: 'all_notice_read_delete'
                };
                $.ajax({
                    type: "POST",
                    url: '<?=admin_url('admin-ajax.php')?>',
                    data: data,
                    dataType: "text",
                    success: function () {
                        layer.msg('删除成功!', {time: 2000, icon: 1});
                        location.reload();
                    },
                    error: function () {
                        alert("error");
                    }
                });
            }
        })
    }

    function all_notice_set_as_read() {
        var data = {
            action: 'all_notice_set_as_read'
        };
        $.ajax({
            //async: false,    //否则永远返回false
            type: "POST",
            url: '<?=admin_url('admin-ajax.php')?>',
            data: data,
            dataType: "text",
            success: function () {
                layer.msg('全部设为已读', {time: 2000, icon: 1});
                location.reload();
            },
            error: function () {
                alert("error");
            }
        });
    }

    function notice_set_as_read(redirect_url,id) {
        var data = {
            action: 'notice_set_as_read',
            id : id
        };
        $.ajax({
            type: "POST",
            url: '<?=admin_url('admin-ajax.php')?>',
            data: data,
            dataType: "text",
            success: function () {
                window.open(redirect_url);
            }
        });
    }

</script>
<div>
    <div class="badge" id="my_group_badge"
         style="cursor:pointer;float: right;margin-top: -27px;margin-right: 5px"
         onclick="all_notice_set_as_read()">
        全部设为已读
    </div>
    <div class="badge" id="my_group_badge"
         style="cursor:pointer;float: right;margin-top: -27px;margin-right: 110px"
         onclick="all_notice_read_delete()">
        删除全部已读
    </div>
</div>
<div class="divline" style="margin-top: 0px;margin-bottom: -11px"></div>
<div id="rightTabContent" class="tab-content">
    <ul class="list-group">
        <?php if (count($allMsg) > 0) {
            //显示一页的东西
            $min_temp = $pro_length < $perpage * $current_page ? $pro_length : $perpage * $current_page;
            for ($i = $perpage * ($current_page - 1); $i < $min_temp; $i++) {
                if ($allMsg[$i]['notice_status'] == 0) { ?>
                    <style>
                        #message-li-<?=$i?> {
                            background-color: #fafbe9;
                            margin-top: 11px;
                            padding-bottom: 0px;
                        }
                    </style>
                <?php }
                else { ?>
                    <style>
                        #message-li-<?=$i?> {
                            background-color: transparent;
                            margin-top: 11px;
                            padding-bottom: 0px;
                        }
                    </style>
                <?php }
                ?>
                <li class="list-group-item" id="message-li-<?= $i ?>">
                    <?php if ($allMsg[$i]['notice_type'] == 1) {
                        //有人给我评论
                        $comment_info = get_comment($allMsg[$i]['notice_content']);
                        $comment_author_id = get_the_ID_by_name($comment_info->comment_author);   //评论人id
                        $comment_author = $comment_info->comment_author; //评论人name
                        $parent_post_link = get_permalink($comment_info->comment_post_ID); //被评论的词条或项目链接
                        $parent_post_title = get_the_title($comment_info->comment_post_ID); //被评论的词条或项目名称
                        $parent_post_type = get_post_type($comment_info->comment_post_ID); //被评论的词条或项目类型
                        $comment_content = $comment_info->comment_content;//评论或回复内容
                        $comment_date = $comment_info->comment_date; //日期
                        ?>
                        <div id="notice-ava">
                            <?php echo  get_avatar($comment_author_id,40)?>
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $comment_author_id; ?>"
                                   style="color: #169bd5"><?= $comment_author ?></a>
                                <?php
                                if ($parent_post_type == "yada_wiki") {
                                    echo "<span>&nbsp;<span style=\"font-weight: bolder\">评论</span>了您的词条</span>";
                                } else {
                                    echo "<span>&nbsp;<span style=\"font-weight: bolder\">评论</span>了您的项目</span>";
                                } ?>
                                <span><a onclick="notice_set_as_read('<?= $parent_post_link ?>',<?=$allMsg[$i]['ID']?>)" style="color:#169bd5;cursor: pointer"><?= $parent_post_title ?></a></span>
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
                    else if ($allMsg[$i]['notice_type'] == 2) {
                        //在词条中回复
                        $comment_info = get_comment($allMsg[$i]['notice_content']);
                        $comment_author_id = get_the_ID_by_name($comment_info->comment_author);
                        $comment_author = $comment_info->comment_author;
                        $parent_post_link = get_permalink($comment_info->comment_post_ID);
                        $parent_post_title = get_the_title($comment_info->comment_post_ID);
                        $parent_post_type = get_post_type($comment_info->comment_post_ID);
                        $comment_content = $comment_info->comment_content;
                        $comment_date = $comment_info->comment_date;
                        ?>
                        <div id="notice-ava">
                            <?php echo  get_avatar($comment_author_id,40)?>
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $comment_author_id; ?>"
                                   style="color: #169bd5"><?= $comment_author ?></a>
                                <?php
                                if ($parent_post_type == "yada_wiki") {
                                    echo "<span>&nbsp;在词条</span>";
                                } else {
                                    echo "<span>&nbsp;在项目</span>";
                                } ?>
                                <span><a onclick="notice_set_as_read('<?= $parent_post_link ?>',<?=$allMsg[$i]['ID']?>)" style="color:#169bd5;cursor: pointer"><?= $parent_post_title ?></a></span>
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
                    else if ($allMsg[$i]['notice_type'] == 3){
                        //在wiki或项目中提问
                        $question_info = get_post($allMsg[$i]['notice_content']);
                        $question_title = get_the_title($allMsg[$i]['notice_content']);
                        $question_link = get_permalink($allMsg[$i]['notice_content']);

                        $ask_author_id = $question_info->post_author;  //提问人ID
                        $ask_author_name = get_the_author_meta('user_login',$ask_author_id);

                        $parent_post_info = qaComeFrom($allMsg[$i]['notice_content']);
                        $parent_post_title = get_the_title($parent_post_info['id']);
                        $parent_post_link = get_permalink($parent_post_info['id']);
                        $parent_post_type = get_post_type($parent_post_info['id']);

                        $ask_date = $allMsg[$i]['modified_time'];
                        ?>
                        <div id="notice-ava">
                            <?php echo  get_avatar($ask_author_id,40)?>
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $ask_author_id; ?>"
                                   style="color: #169bd5"><?= $ask_author_name ?></a>
                                <?php
                                if ($parent_post_type == "yada_wiki") {
                                    echo "<span>&nbsp;在词条</span>";
                                } else {
                                    echo "<span>&nbsp;在项目</span>";
                                } ?>
                                <span><a onclick="notice_set_as_read('<?= $parent_post_link ?>',<?=$allMsg[$i]['ID']?>)" style="color:#169bd5;cursor: pointer"><?= $parent_post_title ?></a></span>
                                <span>中向你<span style="font-weight: bolder">提问</span></span>
                                <div style="margin-top: 5px">
                                    <a onclick="notice_set_as_read('<?=$question_link?>',<?=$allMsg[$i]['ID']?>)" style="color: #169bd5;cursor: pointer"><?= $question_title ?></a>
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
                    else if ($allMsg[$i]['notice_type'] == 4) {
                        $ans_info = get_post($allMsg[$i]['notice_content']);

                        $ans_author_id = $ans_info->post_author;  //回答人ID
                        $ans_author_name = get_the_author_meta('user_login',$ans_author_id); //回答人姓名

                        $parent_post_title = get_the_title($ans_info->post_parent);  //问题名称
                        $parent_post_link = get_permalink($ans_info->post_parent);   //问题链接

                        $ans_content = $ans_info->post_content;
                        $ans_date = $ans_info->post_date;?>
                        <div id="notice-ava">
                            <?php echo  get_avatar($ans_author_id,40)?>
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $ans_author_id; ?>"
                                   style="color: #169bd5"><?= $ans_author_name ?></a>
                                <span>&nbsp;<span style="font-weight: bolder">回答</span>了您的问题</span>
                                <span><a onclick="notice_set_as_read('<?= $parent_post_link ?>',<?=$allMsg[$i]['ID']?>)" style="color:#169bd5;cursor: pointer"><?= $parent_post_title ?></a></span>
                                <div style="margin-top: 5px"><?= $ans_content ?></div>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">问答</div>
                                <div style="margin-top: 30px"><?= $ans_date ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]['notice_type'] == 5) {
                        $ans_info = get_post($allMsg[$i]['notice_content']);

                        $ans_author_id = $ans_info->post_author;  //回答人ID
                        $ans_author_name = get_the_author_meta('user_login',$ans_author_id); //回答人姓名

                        $parent_post_title = get_the_title($ans_info->post_parent);  //问题名称
                        $parent_post_link = get_permalink($ans_info->post_parent);   //问题链接
                        $question_author = get_the_author($ans_info->post_parent);   //提问人name
                        $question_author_id = get_the_ID_by_name($question_author);    //提问人id
                        $ans_content = $ans_info->post_content;
                        $ans_date = $ans_info->post_date;

                        ?>
                        <div id="notice-ava">
                            <?php echo  get_avatar($question_author_id,40)?>
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $question_author_id; ?>"
                                   style="color: #169bd5"><?= $question_author ?></a>
                                <span>&nbsp;在问题</span>
                                <a onclick="notice_set_as_read('<?= $parent_post_link ?>',<?=$allMsg[$i]['ID']?>)" style="color:#169bd5;cursor: pointer"><?= $parent_post_title ?></a>
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
                    else if ($allMsg[$i]['notice_type'] == 6) {
                        $ans_info = get_post($allMsg[$i]['notice_content']);
                        $parent_post_title = get_the_title($ans_info->post_parent);  //问题名称
                        $parent_post_link = get_permalink($ans_info->post_parent);   //问题链接
                        $ans_content = $ans_info->post_content;
                        $ans_date = $ans_info->post_date;
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/vote.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info">
                                <span>有人在问题</span>
                                <a onclick="notice_set_as_read('<?= $parent_post_link ?>',<?=$allMsg[$i]['ID']?>)" style="color:#169bd5;cursor: pointer"><?= $parent_post_title ?></a>
                                <span>中<span style="font-weight: bolder">赞同了</span>您的答案</span>
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
