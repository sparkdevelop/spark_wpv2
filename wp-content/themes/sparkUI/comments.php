<?php
//get 项目 related QA id。
$related_qa_id = pwRelatedQA(get_the_ID()); //返回一个qa_id集合而成的数组
$length = sizeof($related_qa_id);
?>
<ul id="leftTab" class="nav nav-pills">
        <li class="active"><a href="#project_comment" data-toggle="tab">评论</a></li>
        <li><a href="#related_QA" data-toggle="tab" id="QA_related">相关问答(<?=$length?>)</a></li>
</ul>
<?php
// 如果没有问题就不显示问答tab了
//    if($length==0){?>
<!--    <script>-->
<!--        $("#QA_related").css("display","none");-->
<!--    </script>-->
<?php //} ?>
<div id="leftTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="project_comment" style="margin-top: 65px">
                <div class="divline"></div>
             <div id="comments" class="comments-area">
	<?php
	comment_form( array(
		'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
		'title_reply_after'  => '</h2>',
		'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
			'</label><textarea id="comment" name="comment" cols="119" rows="5" aria-required="true">' .
			'</textarea></p >',
	) );
	?>
        <?php if ( have_comments() ) : ?>
                <h2 class="comments-title">
                        <?php
                        $comments_number = get_comments_number();
                        if ( 1 === $comments_number ) {
                                /* translators: %s: post title */
                                printf( _x( 'One thought on &ldquo;%s&rdquo;', 'comments title', 'twentysixteen' ), get_the_title() );
                        } else {
                                printf(
                                /* translators: 1: number of comments, 2: post title */
                                    _nx(
                                        '%1$s thought on &ldquo;%2$s&rdquo;',
                                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                                        $comments_number,
                                        'comments title',
                                        'twentysixteen'
                                    ),
                                    number_format_i18n( $comments_number ),
                                    get_the_title()
                                );
                        }
                        ?>
                </h2>
                <?php the_comments_navigation(); ?>
                <ol class="comment-list">
                                        <?php
                                        wp_list_comments( array(
                                            'style'       => 'ol',
                                            'short_ping'  => true,
                                            'avatar_size' => 32,
                                        ) );
                                        ?>
                                </ol><!-- .comment-list -->
                <?php the_comments_navigation(); ?>

        <?php endif; // Check for have_comments(). ?>
        <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :?>
                <p class="no-comments"><?php _e( 'Comments are closed.', 'twentysixteen' ); ?></p>
        <?php endif; ?>
</div>
        </div>
        <div class="tab-pane fade" id="related_QA">
                <ul class="list-group" style="margin-top: 65px;border-top: 1px solid lightgray">
                    <?php
                    if($length!=0){
                        for($i=0;$i<$length;$i++){
                         require "template/comment-question.php";
                        }
                    }else{?>
                        <h4>可以在侧脸栏提问</h4>
                    <?php } ?>
                </ul>
        </div>
</div><!-- .comments-area -->