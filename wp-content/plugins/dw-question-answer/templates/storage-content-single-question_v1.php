<?php
/**
 * The template for displaying single questions
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */
?>

<?php //do_action( 'dwqa_before_single_question_content' );
global $wpdb;

?>
<script>
	var flag=false;
	function answer_reply(){
		var temp = document.getElementById('reply_window');
		//temp.style.display="block";
		if(flag){temp.style.display="block";}
		else{temp.style.display="none";}
		flag=!flag;
	}
</script>
<div class="container" style="margin-top: 10px">
	<div class="row" style="width: 100%">
<<<<<<< HEAD
		<div class="col-md-9 col-sm-9 col-xs-9" style="padding-left: 0;padding-right: 0;">
=======
		<div class="col-md-8 col-sm-8 col-xs-8">
>>>>>>> 0736b4fcc462d013e0d3eb82e8bbadfb98202f56
<!--			问题部分-->
			<div class="dwqa-question-item" style="padding: 0px 0px;">
				<!--问题标题-->
				<div class="question_title">
				<h4><?php echo get_the_title();?></h4>
				<?php if ( dwqa_current_user_can( 'edit_question', get_the_ID() ) ) : ?>
					<?php if ( dwqa_is_enable_status() ) : ?>
						<span class="dwqa-question-status" style="float:right;">
					<?php _e( '问题状态', 'dwqa' ) ?>
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
<<<<<<< HEAD
		<span style="color: gray">提问人:&nbsp;<a href="<?php get_the_author_link();?>" class="author_link"><?php echo get_the_author();?></a></span>
=======
		<span style="color: gray">提问人:&nbsp;<a href="<?php get_the_author_link();?>"><?php echo get_the_author();?></a></span>
>>>>>>> 0736b4fcc462d013e0d3eb82e8bbadfb98202f56
		<span style="color: gray;margin-left: 5px"><?php echo date('n月j日 G:i',get_the_time('U'));?></span>
		<span class="scan_count" style="margin-left: 0px;float:right; ">浏览<?php echo dwqa_question_views_count();?></span>
		<span class="ask_count" style="margin-right: 20px;float: right;">回答<?php echo dwqa_question_answers_count();?></span>

	</div>
				<!--显示问题状态-->
<!--			--><?php //if ( dwqa_current_user_can( 'edit_question', get_the_ID() ) ) : ?>
<!--			--><?php //if ( dwqa_is_enable_status() ) : ?>
<!--				<span class="dwqa-question-status">-->
<!--					--><?php //_e( 'This question is:', 'dwqa' ) ?>
<!--					<select id="dwqa-question-status" data-nonce="--><?php //echo wp_create_nonce( '_dwqa_update_privacy_nonce' ) ?><!--" data-post="--><?php //the_ID(); ?><!--">-->
<!--						<optgroup label="--><?php //_e( 'Status', 'dwqa' ); ?><!--">-->
<!--							<option --><?php //selected( dwqa_question_status(), 'open' ) ?><!-- value="open">--><?php //_e( 'Open', 'dwqa' ) ?><!--</option>-->
<!--							<option --><?php //selected( dwqa_question_status(), 'closed' ) ?><!-- value="close">--><?php //_e( 'Closed', 'dwqa' ) ?><!--</option>-->
<!--							<option --><?php //selected( dwqa_question_status(), 'resolved' ) ?><!-- value="resolved">--><?php //_e( 'Resolved', 'dwqa' ) ?><!--</option>-->
<!--						</optgroup>-->
<!--					</select>-->
<!--					</span>-->
<!--			--><?php //endif; ?>
<!--			--><?php //endif; ?>
				<div class="divline"></div>
				<?php if ( dwqa_current_user_can( 'post_answer' ) && !dwqa_is_closed( get_the_ID() ) ) : ?>
					<?php dwqa_load_template( 'answer', 'submit-form' ) ?>
				<?php endif; ?>

			</div>
<!--			答案部分-->
			<div class="dwqa-answers">
				<?php do_action( 'dwqa_before_answers');?>
				<div class="divline"></div>
				<?php if ( dwqa_has_answers() ) : ?>
					<div class="dwqa-answers-title">
<!--						显示几个answer-->
						<?php printf( __( '%s 个答案', 'dwqa' ), dwqa_question_answers_count( get_the_ID() ) ) ;?>
					</div>
<!--					答案列表-->
					<div class="dwqa-answers-list">
						<ul class="list-group">
						<?php while ( dwqa_has_answers() ) : dwqa_the_answers(); ?>
							<?php $question_id = get_post_meta( get_the_ID(), '_question', true ) ?>
							<?php if ( ( 'private' == get_post_status() &&
											( dwqa_current_user_can( 'edit_answer', get_the_ID() ) || dwqa_current_user_can( 'edit_question', $question_id ) ) )
										|| 'publish' == get_post_status() ) : ?>

								<li class="list-group-item" style="padding: 15px 0px">
									<?php $user_id = get_post_field( 'post_author', get_the_ID() ) ? get_post_field( 'post_author', get_the_ID() ) : 0;
										$sql="SELECT comment_count from $wpdb->posts WHERE ID=".get_the_ID();
										$comment_count= $wpdb->get_var($sql);
									?>
<!--									头像-->
									<div style="display: inline-block;vertical-align: top">
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
											<p class="ask_date" style="margin-left: 20px;"><?php echo human_time_diff( get_post_time( 'U', true ) )."前";?></p>
										</div>
<!--										答案内容-->
										<div style="color: gray;margin-left: 20px"><?php the_content();?></div>

<!--										回复和点赞按钮链接-->
										<span class="answer-comment" style="margin-left: 0px;float: right;">
											<button class="btn btn-default" style="border: 0px;padding-top: 0px;color:gray;outline: none;" onclick="answer_reply()">回复<?php echo $comment_count; ?></button>
										</span>
										<div class="answer-vote" style="margin-right: 20px;float: right;color:gray;" data-nonce="<?php echo wp_create_nonce( '_dwqa_question_vote_nonce' ) ?>" data-post="<?php the_ID(); ?>">
											<a class="dwqa-vote dwqa-vote-up" href="#"><?php _e( '赞同', 'dwqa' ); ?></a>
											<span class="dwqa-vote-count"><?php echo dwqa_vote_count();?></span>
										</div>

<!--										回复窗口-->
										<div id="reply_window" style="display: block;">

											<?php comments_template("/Spark_comment.php"); ?>

										</div>
									</div>
									<div class="divline"></div>
								</li>
							<?php endif; ?>
						<?php endwhile; ?>
						</ul>
						<?php wp_reset_postdata(); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php comments_template(); ?>
		</div>
<<<<<<< HEAD
		<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
=======
		<div class="col-md-4 col-sm-4 col-xs-4 right">
>>>>>>> 0736b4fcc462d013e0d3eb82e8bbadfb98202f56
				<?php $ask_page_ID="?page_id=96"; ?>

				<div class="sidebar_button" style="margin-top: 20px">
					<a href="<?php echo site_url().$ask_page_ID;?>" style="color: white">我要提问</a>
				</div>
				<div class="tags" style="margin-left: 14px">
					<div style="height: 42px">
						<p style="font-size: large;display:inline-block;margin-top: 5%;font-weight: bold">相似标签</p>
						<a href="tag.php" style="color:gray;float: right;display: inline-block;margin-top: 5%">全部标签</a>
					</div>
					<!--分割线-->
					<div style="height: 2px;background-color: lightgray"></div>
					<div style="word-wrap: break-word; word-break: keep-all;">
						<h4>
							<a class="label label-default">
								舵机<span class="badge">(40)</span>
							</a>
							<a class="label label-default">
								编译<span class="badge">(36)</span>
							</a>
							<a class="label label-default">
								上传<span class="badge">(30)</span>
							</a>
							<a class="label label-default">
								Mwatch<span class="badge">(20)</span>
							</a>
							<a class="label label-default">
								OLED<span class="badge">(18)</span>
							</a>
							<a class="label label-default">
								Wifi<span class="badge">(15)</span>
							</a>
							<a class="label label-default">
								Wifi气象站<span class="badge">(10)</span>
							</a>
							<a class="label label-default">
								蓝牙<span class="badge">(10)</span>
							</a>
							<a class="label label-default">
								触摸<span class="badge">(8)</span>
							</a>
							<a class="label label-default">
								声音<span class="badge">(5)</span>
							</a>
						</h4>
					</div>
				</div>

				<!--            相似问题-->
				<div class="related_questions" style="margin-left: 14px">
					<div style="height: 42px">
						<p style="font-size: large;display:inline-block;margin-top: 5%;font-weight: bold">相似问题</p>
					</div>
					<!--分割线-->
					<div style="height: 2px;background-color: lightgray"></div>
					<!--标签群   固定个数?  如何生成热门标签 将输入的东西换成<?php?>传入的数据-->
					<ul class="list-group">
						<li class="list-group-item">
							<a href="#">蓝牙模块连不上怎么办?不知道代码哪里有问题</a>
						</li>
						<li class="list-group-item">
							<a href="#">蓝牙的代码该怎么写啊</a>
						</li>
						<li class="list-group-item">
							<a href="#">蓝牙是个坑啊</a>
						</li>

					</ul>
				</div>
			</div>
	</div>
</div>

