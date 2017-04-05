
<div class="answer_comment">-->
<!--										<ul class="list-group" id="comment_display">-->
<!--											<li class="list-group-item" style="margin-top: 25px;border: 0px">-->
<!--												<div class="comment_topup" style="background-color: #f8f8f8;padding: 10px 0px">-->
<!--													--><?php //$comment_user_id = get_post_field( 'post_author', get_the_ID() ) ? get_post_field( 'post_author', get_the_ID() ) : 0 ?>
<!--													<div style="display: inline-block;vertical-align: top;margin-left: 20px">-->
<!--														--><?php //echo get_avatar( $user_id, 30);?>
<!--													</div>-->
<!--													<div style="display: inline-block;vertical-align: top;">-->
<!--														<div style="color:gray">-->
<!--															<a href="personal.php" style="margin-left: 20px;font-weight:bold;font-size: initial">如影随风</a>&nbsp;-->
<!--															<span>回复</span>&nbsp;-->
<!--															<a href="#" style="font-weight:bold;font-size: initial">莫里哀</a>-->
<!--															<p class="ask_date" style="margin-left: 20px;margin-top: 10px">3月2日</p>-->
<!--														</div>-->
<!--														<div style="color: gray;margin-left: 20px">-->
<!--															content-->
<!--														</div>-->
<!--														<span class="scan_count" style="display:block;margin-left: 20px;margin-top: 10px"><a href="#">回复</a></span>-->
<!--													</div>-->
<!--												</div>-->
<!--											</li>-->
<!--										</ul>-->
<!--									</div>-->

















    <!--	<ul class="list-group">-->
    <!--		<!--无回复的-->-->

    <!---->
    <!--		<!--                有回复的-->-->
    <!--		<li class="list-group-item" style="padding: 15px 0px">-->
    <!--			<div style="display: inline-block;vertical-align: top">-->
    <!--				<img src="img/listavatar.png" style="margin-top: 0px">-->
    <!--			</div>-->
    <!--			<div style="display: inline-block;vertical-align: top;width: 87%">-->
    <!--				<div>-->
    <!--					<div style="color:gray">-->
    <!--						<div style="margin-bottom: 10px"><a href="personal.php" style="margin-left: 20px;">如影随风</a></div>-->
    <!--						<p class="ask_date" style="margin-left: 20px;">3月2日</p>-->
    <!--					</div>-->
    <!--					<div style="color: gray;margin-left: 20px">-->
    <!--						content-->
    <!--					</div>-->
    <!--					<span class="scan_count" style="display:block;margin-left: 0px;float: right;"><a href="#">回复</a> </span>-->
    <!--					<span class="ask_count" style="display:block;margin-right: 20px;float: right;">赞同0</span>-->
    <!--				</div>-->
    <!--				<!--                    回复内容-->-->
    <!--				<div class="answer_comment">-->
    <!--					<ul class="list-group" id="comment_display">-->
    <!--						<li class="list-group-item" style="margin-top: 25px;border: 0px">-->
    <!--							<div class="comment_topup" style="background-color: #f8f8f8;padding: 10px 0px">-->
    <!--								<div style="display: inline-block;vertical-align: top;margin-left: 20px">-->
    <!--									<img src="img/listavatar.png" style="margin-top: 0px">-->
    <!--								</div>-->
    <!--								<div style="display: inline-block;vertical-align: top;">-->
    <!--									<div style="color:gray">-->
    <!--										<a href="personal.php" style="margin-left: 20px;font-weight:bold;font-size: initial">如影随风</a>&nbsp;-->
    <!--										<span>回复</span>&nbsp;-->
    <!--										<a href="#" style="font-weight:bold;font-size: initial">莫里哀</a>-->
    <!--										<p class="ask_date" style="margin-left: 20px;margin-top: 10px">3月2日</p>-->
    <!--									</div>-->
    <!--									<div style="color: gray;margin-left: 20px">-->
    <!--										content-->
    <!--									</div>-->
    <!--									<span class="scan_count" style="display:block;margin-left: 20px;margin-top: 10px"><a href="#">回复</a></span>-->
    <!--								</div>-->
    <!--							</div>-->
    <!--						</li>-->
    <!--					</ul>-->
    <!--				</div>-->
    <!--			</div>-->
    <!---->
    <!--			<div class="divline"></div>-->
    <!--		</li>-->
    <!---->
    <!--		<li class="list-group-item" style="padding: 15px 0px">-->
    <!--			<div style="display: inline-block;vertical-align: top">-->
    <!--				<img src="img/listavatar.png" style="margin-top: 0px">-->
    <!--			</div>-->
    <!--			<div style="display: inline-block;vertical-align: top;width: 87%">-->
    <!---->
    <!--				<div style="color:gray">-->
    <!--					<div style="margin-bottom: 10px"><a href="personal.php" style="margin-left: 20px;">如影随风</a></div>-->
    <!--					<p class="ask_date" style="margin-left: 20px;">3月2日</p>-->
    <!--				</div>-->
    <!--				<div style="color: gray;margin-left: 20px">-->
    <!--					content-->
    <!--				</div>-->
    <!--				<span class="scan_count" style="margin-left: 0px;float: right;"><a href="#">回复</a> </span>-->
    <!--				<span class="ask_count" style="margin-right: 20px;float: right;">赞同0</span>-->
    <!--			</div>-->
    <!--			<div class="divline"></div>-->
    <!--		</li>-->
    <!--		</ul>-->
</div>

<div class="dwqa-question-item">
    <div class="dwqa-question-vote" data-nonce="<?php echo wp_create_nonce( '_dwqa_question_vote_nonce' ) ?>" data-post="<?php the_ID(); ?>">
        <span class="dwqa-vote-count"><?php echo dwqa_vote_count() ?></span>
        <a class="dwqa-vote dwqa-vote-up" href="#"><?php _e( 'Vote Up', 'dwqa' ); ?></a>
        <a class="dwqa-vote dwqa-vote-down" href="#"><?php _e( 'Vote Down', 'dwqa' ); ?></a>
    </div>
    <div class="dwqa-question-meta">
        <?php $user_id = get_post_field( 'post_author', get_the_ID() ) ? get_post_field( 'post_author', get_the_ID() ) : false ?>
        <?php printf( __( '<span><a href="%s">%s%s</a> %s asked %s ago</span>', 'dwqa' ), dwqa_get_author_link( $user_id ), get_avatar( $user_id, 48 ), get_the_author(),  dwqa_print_user_badge( $user_id ), human_time_diff( get_post_time( 'U', true ) ) ) ?>
        <span class="dwqa-question-actions"><?php dwqa_question_button_action() ?></span>
    </div>
    <div class="dwqa-question-content"><?php the_content(); ?></div>
    <div class="dwqa-question-footer">
        <div class="dwqa-question-meta">
            <?php echo get_the_term_list( get_the_ID(), 'dwqa-question_tag', '<span class="dwqa-question-tag">' . __( 'Question Tags: ', 'dwqa' ), ', ', '</span>' ); ?>
            <?php if ( dwqa_current_user_can( 'edit_question', get_the_ID() ) ) : ?>
                <?php if ( dwqa_is_enable_status() ) : ?>
                    <span class="dwqa-question-status">
					<?php _e( 'This question is:', 'dwqa' ) ?>
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
    </div>
    <?php do_action( 'dwqa_before_single_question_comment' ) ?>
    <?php comments_template(); ?>
    <?php do_action( 'dwqa_after_single_question_comment' ) ?>
</div>
<?php do_action( 'dwqa_after_single_question_content' );
dwqa_answer_paginate_link();

?>




