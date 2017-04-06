<?php
/**
 * The template for displaying single questions
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */
?>

<?php do_action( 'dwqa_before_single_question_content' ); ?>
    <div class="dwqa-question-item" style="padding: 0px 0px;">
    <!--问题标题-->
    <div class="question_title">
        <h4 class="qa_title ask_topic"><?php echo get_the_title();?></h4>
        <?php if ( dwqa_current_user_can( 'edit_question', get_the_ID() ) ) : ?>
            <?php if ( dwqa_is_enable_status() ) : ?>
                <span class="dwqa-question-status" style="float:right;">
<!--					--><?php //_e( '问题状态', 'dwqa' ) ?>
					<?php _e( '', 'dwqa' ) ?>
                    <select id="dwqa-question-status" data-nonce="<?php echo wp_create_nonce( '_dwqa_update_privacy_nonce' ) ?>" data-post="<?php the_ID(); ?>">
						<optgroup label="<?php _e( 'Status', 'dwqa' ); ?>">
							<option <?php selected( dwqa_question_status(), 'open' ) ?> value="open"><?php _e( 'Open', 'dwqa' ) ?></option>
							<option <?php selected( dwqa_question_status(), 'closed' ) ?> value="close"><?php _e( 'Closed', 'dwqa' ) ?></option>
							<option <?php selected( dwqa_question_status(), 'resolved' ) ?> value="resolved"><?php _e( 'Resolved', 'dwqa' ) ?></option>
						</optgroup>
					</select>
					</span>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <!--问题内容-->
    <p><?php the_content(); ?></p>
    <!--问题标签-->
    <div style="word-wrap: break-word; word-break: keep-all;display: inline-block">
        <h4>
            <?php
            $before ='<span id="temp_questions" class="label label-default">';
            $sep = '</span><span id="temp_questions" class="label label-default">';
            $after='</span>';
            echo get_the_term_list( get_the_ID(), 'dwqa-question_tag', $before , $sep, $after );
            ?>
        </h4>
    </div>
    <!--提问人信息-->
    <div>
        <span style="color: gray">提问人:&nbsp;<a href="<?php get_the_author_link();?>" class="author_link"><?php echo get_the_author();?></a></span>
        <span style="color: gray;margin-left: 5px"><?php echo date('n月j日 G:i',get_the_time('U'));?></span>
        <span class="scan_count" style="margin-left: 0px;float:right; ">浏览<?php echo dwqa_question_views_count();?></span>
        <span class="ask_count" style="margin-right: 20px;float: right;">回答<?php echo dwqa_question_answers_count();?></span>

    </div>
    <div class="divline"></div>
</div>

<?php do_action( 'dwqa_after_single_question_content' ); ?>
