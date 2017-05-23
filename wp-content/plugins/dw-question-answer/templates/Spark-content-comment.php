<?php
/**
 * The template for displaying content comment
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */
?>

<?php global $comment; ?>
<div class="dwqa-comment">
    <div class="Spark-comment-meta">
        <?php $user = get_user_by( 'id', $comment->user_id ); ?>
        <div style="display: inline-block;vertical-align: top;margin-left: 20px">
            <?php echo get_avatar( $comment->user_id, 30 )?>
        </div>
        <div style="display: inline-block;vertical-align: top;">
            <div style="color:gray">
                <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='. $comment->user_id;?>" class="ask-author" style="margin-left: 20px;font-weight:bold;font-size: initial">
                    <?php echo get_comment_author() ?></a>&nbsp;
<!--                <span>回复</span>&nbsp;-->
<!--                <a href="#" style="font-weight:bold;font-size: initial">莫里哀</a>-->
                <p class="answer_date" style="margin-left: 20px;margin-top: 10px"><?php echo  human_time_diff( get_comment_time( 'U', true ) );?>前回复</p>
            </div>
            <div style="color: gray;margin-left: 20px;margin-top: 20px;font-size: 16px;">
                <?php comment_text(); ?>
            </div>
<!--            <span class="scan_count" style="display:block;margin-left: 20px;margin-top: 10px"><a href="#">回复</a></span>-->
        </div>

        <div class="dwqa-comment-actions">
            <?php if ( dwqa_current_user_can( 'edit_comment' ) ) : ?>
                <a href="<?php echo esc_url( add_query_arg( array( 'comment_edit' => $comment->comment_ID ) ) ) ?>"><?php _e( 'Edit', 'dwqa' ) ?></a>
            <?php endif; ?>
            <?php if ( dwqa_current_user_can( 'delete_comment' ) ) : ?>
                <a class="dwqa-delete-comment" href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'dwqa-action-delete-comment', 'comment_id' => $comment->comment_ID ), admin_url( 'admin-ajax.php' ) ), '_dwqa_delete_comment' ) ?>"><?php _e( 'Delete', 'dwqa' ) ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>
