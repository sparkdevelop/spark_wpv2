<?php
//get 项目 related QA id。
$related_qa_id = pwRelatedQA(get_the_ID()); //返回一个qa_id集合而成的数组
$origin_url = get_permalink();
$length = sizeof($related_qa_id);
$perpage = 4;
$total_page = ceil($length / $perpage);

//get 项目 related FAQ id。
$related_faq_id = RelatedFAQ(get_the_ID()); //返回一个qa_id集合而成的数组
$faq_length = sizeof($related_faq_id);
$faq_total_page = ceil($faq_length / $perpage);

if (!$_GET['paged']) {
    $current_page = 1;
} else {
    $page_num = $_GET['paged'];
    $current_page = $page_num; ?>
    <script>
        $(function () {
            $("#commentTab").removeClass("active");
            $("#project_comment").removeClass("in active");
            $("#qaTab").addClass("active");
            $("#related_QA").addClass("in active");
            $("#faqTab").removeClass("active");
            $("#related_FAQ").removeClass("in active");
        })
    </script>
<?php } ?>


<ul id="leftTab" class="nav nav-pills">
    <li class="active" id="qaTab"><a href="#related_QA" data-toggle="tab" id="QA_related">相关问答(<?= $length ?>)</a></li>
    <li id="faqTab"><a href="#related_FAQ" data-toggle="tab" id="FAQ_related">相关经验(<?= $faq_length ?>)</a></li>
    <li id="commentTab"><a href="#project_comment" data-toggle="tab" onclick="backToComment()">评论</a></li>
</ul>
<?php
// 如果没有问题就不显示问答tab了
//    if($length==0){?>
<!--    <script>-->
<!--        $("#QA_related").css("display","none");-->
<!--    </script>-->
<?php //} ?>
<div id="leftTabContent" class="tab-content">
    <div class="tab-pane fade" id="project_comment" style="margin-top: 65px">
        <div class="divline"></div>
        <div id="comments" class="comments-area">
            <?php
            comment_form(array(
                'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
                'title_reply_after' => '</h2>',
                'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun') .
                    '</label><textarea id="comment" name="comment" cols="119" rows="5" aria-required="true">' .
                    '</textarea></p >',
            ));
            ?>
            <?php if (have_comments()) : ?>
                <h2 class="comments-title">
                    <?php
                    $comments_number = get_comments_number();
                    if (1 === $comments_number) {
                        /* translators: %s: post title */
                        printf(_x('One thought on &ldquo;%s&rdquo;', 'comments title', 'twentysixteen'), get_the_title());
                    }
                    else {
                        printf(
                        /* translators: 1: number of comments, 2: post title */
                            _nx(
                                '%1$s thought on &ldquo;%2$s&rdquo;',
                                '%1$s thoughts on &ldquo;%2$s&rdquo;',
                                $comments_number,
                                'comments title',
                                'twentysixteen'
                            ),
                            number_format_i18n($comments_number),
                            get_the_title()
                        );
                    }
                    ?>
                </h2>
                <?php the_comments_navigation(); ?>
                <ol class="comment-list">
                    <?php
                    wp_list_comments(array(
                        'style' => 'ol',
                        'short_ping' => true,
                        'avatar_size' => 32,
                    ));
                    ?>
                </ol><!-- .comment-list -->
                <?php the_comments_navigation(); ?>

            <?php endif; // Check for have_comments(). ?>
            <?php
            // If comments are closed and there are comments, let's leave a little note, shall we?
            if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :?>
                <p class="no-comments"><?php _e('Comments are closed.', 'twentysixteen'); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="tab-pane fade in active" id="related_QA">
        <ul class="list-group" style="margin-bottom:0px;margin-top: 65px;border-top: 1px solid lightgray">
            <?php
            if ($length != 0) {
                $temp = $length < $perpage * $current_page ? $length : $perpage * $current_page;
                for ($i = $perpage * ($current_page - 1); $i < $temp; $i++) {
                    require "template/comment-question.php";
                }
            } else { ?>
                <div class="alert alert-info" style="margin-top: 20px">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>  <!--关闭按钮-->
                    <strong>Oops,还没有问题!</strong>您可以在侧边栏提问。
                </div>
            <?php } ?>
        </ul>
        <?php
        if ($total_page > 1) {
            ?>
            <div id="page_comment_qa" style="text-align:center;margin-bottom: 20px">
                <!--翻页-->
                <?php if ($current_page == 1) { ?>
                    <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) . '#QA_related' ?>">下一页&nbsp;&raquo;</a>
                <?php } elseif ($current_page == $total_page) { ?>
                    <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) . '#QA_related' ?>">&laquo;&nbsp;上一页</a>
                <?php } else { ?>
                    <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) . '#QA_related' ?>">&laquo;&nbsp;上一页&nbsp;</a>
                    <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) . '#QA_related' ?>">&nbsp;下一页&nbsp;&raquo;</a>
                <?php } ?>
            </div>
        <?php } ?>

    </div>
    <div class="tab-pane fade" id="related_FAQ">
        <ul class="list-group" style="margin-bottom:0px;margin-top: 65px;border-top: 1px solid lightgray">
            <?php
            if ($faq_length != 0) {
                for ($i = 0; $i < $faq_length; $i++) {
                    require "template/comment-faq.php";
                }
            } else { ?>
                <div class="alert alert-info" style="margin-top: 20px">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>  <!--关闭按钮-->
                    <strong>Oops,还没有经验分享!</strong>您可以在侧边栏分享。
                </div>
            <?php } ?>
        </ul>

    </div>
</div><!-- .comments-area -->
<script>
    function backToComment() {
        location.href = "<?=$origin_url?>" + "#QA_related";
    }
    $(function () {
        $("#submit").on("click", function () {
            document.cookie = "action=comment";
        })
    });
</script>