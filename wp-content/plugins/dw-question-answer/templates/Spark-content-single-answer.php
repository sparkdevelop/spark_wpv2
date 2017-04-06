<?php
/**
 * The template for displaying single answers
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */
?>
<?php //do_action( 'dwqa_before_single_question_content' );
global $wpdb;

?>
<!--本段注释放开以后可以收起回复框,但下面留白原因未知-->
<script>
    var flag=false;
    function answer_reply($ans_id){
        var temp = document.getElementById('reply_window_'+$ans_id);
        var temp_2 = document.getElementById('Spark_comments');
        if(flag){
            temp.style.display="block";
            temp_2.style.display ="block";
        }
        else{
            temp.style.display="none";
            temp_2.style.display ="none";
        }
        flag=!flag;
    }
</script>
<div class="<?php echo dwqa_post_class() ?>" style="padding: 15px 0px">

    <?php $user_id = get_post_field( 'post_author', get_the_ID() ) ? get_post_field( 'post_author', get_the_ID() ) : 0;
    $sql="SELECT comment_count from $wpdb->posts WHERE ID=".get_the_ID();
    $comment_count= $wpdb->get_var($sql);
    ?>
    <!--									头像-->
    <div style="display: inline-block;vertical-align: top;margin-left: 30px">
        <?php echo get_avatar( $user_id, 30);?>
    </div>
    <!--									内容-->
    <div style="display: inline-block;vertical-align: top;width: 90%">
        <div style="color:gray">
            <div style="margin-bottom: 10px">
                <!--												回答者信息-->
                <a href="<?php echo dwqa_get_author_link( $user_id );?>" style="margin-left: 20px;">
                    <?php echo get_the_author();?>
                </a>
                <!--												是否被采纳-->
                <?php if ( dwqa_current_user_can( 'edit_question', dwqa_get_question_from_answer_id() ) ) : ?>
                    <?php $action = dwqa_is_the_best_answer() ? 'dwqa-unvote-best-answer' : 'dwqa-vote-best-answer' ;
                    if($action=='dwqa-unvote-best-answer'){?>
                        <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'answer' => get_the_ID(), 'action' => $action ), admin_url( 'admin-ajax.php' ) ), '_dwqa_vote_best_answer' ) ) ?>" style="float: right;color: #fe642d">已采纳</a>
                    <?php	} else{?>
                        <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( array( 'answer' => get_the_ID(), 'action' => $action ), admin_url( 'admin-ajax.php' ) ), '_dwqa_vote_best_answer' ) ) ?>" style="float: right;">采纳</a>
                    <?php   } ?>
                <?php elseif ( dwqa_is_the_best_answer() ) : ?>
                    <span><?php _e( '已采纳', 'dwqa' ) ?></span>
                <?php endif; ?>
            </div>
            <!--											回答时间-->
            <p class="ask_date" style="margin-left: 20px;"><?php echo human_time_diff( get_post_time( 'U', true ) )."前回答";?></p>
        </div>
        <!--										答案内容-->
        <div style="color: gray;margin-left: 20px"><?php the_content();?></div>

        <!--										回复和点赞按钮链接-->
        <span class="answer-comment" style="margin-left: 0px;float: right;">
            <?php $ans_id=get_the_ID();?>
            <button class="btn btn-default" style="border: 0px;padding-top: 0px;color:gray;outline: none;" onclick="answer_reply(<?=$ans_id;?>)">回复<?php echo $comment_count; ?></button>
        </span>
        <div class="answer-vote" style="margin-right: 20px;float: right;color:gray;" data-nonce="<?php echo wp_create_nonce( '_dwqa_question_vote_nonce' ) ?>" data-post="<?php the_ID(); ?>">
            <a class="dwqa-vote dwqa-vote-up" href="#"><?php _e( '赞同', 'dwqa' ); ?></a>
            <span class="dwqa-vote-count"><?php echo dwqa_vote_count();?></span>
        </div>

        <!--										回复窗口-->
          <?php
            $reply_window_id="reply_window_".$ans_id;
            if($comment_count!=0){$comment_status="block";}
            else{$comment_status="none";}
            ?>
        <div id='<?=$reply_window_id?>' style="display:<?=$comment_status?> ;margin-top: 40px;">
            <?php comments_template(); ?>
        </div>
    </div>
</div>
