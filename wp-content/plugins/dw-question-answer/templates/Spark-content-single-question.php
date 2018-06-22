<?php
/**
 * The template for displaying single questions
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */
?>
<?php
      $post_id =$_COOKIE["post_id"];   //相关的项目或者wikiid
      $post_type = $_COOKIE["post_type"];  //相关的post类型
      setcookie("post_id");
      setcookie("post_type");
      $related_id = get_the_ID();
      $related_post_type = get_post_type($related_id);

if($post_id==''){
    //在tiny页面有设置cookie
    //从数据库取出
    $post_info = qaComeFrom($related_id);
    $post_id = $post_info["id"];
    $post_type = $post_info["post_type"];
} else{
    //插入数据
    writePWQA($post_id,$post_type,$related_id,$related_post_type);
}
if($post_type=="post"){
    $post_from = "项目";
}elseif($post_type=="yada_wiki"){
    $post_from = "wiki";
}else{
    $post_type="";
}

?>
<?php do_action( 'dwqa_before_single_question_content' ); ?>
    <div class="dwqa-question-item" style="padding: 0px 0px;">
    <!--问题标题-->
    <div class="question_title">
        <h4 class="qa_title ask_topic"><?php echo get_the_title();?></h4>
        <?php if ( dwqa_current_user_can( 'edit_question', get_the_ID() ) ) : ?>
            <?php if ( dwqa_is_enable_status() ) : ?>
                <span class="dwqa-question-status" style="float:right;">
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
        <!--来自项目or wiki-->
        <?php
            if($post_type != ""){?>
            <div id="question_from" style="display:block;">
                <span>来自<?php echo $post_from?>:
                    <a href ="<?php echo get_permalink($post_id);?>">
                        <?php echo get_the_title($post_id);?>
                    </a>
                </span>
            </div>
        <?php } ?>


    <!--提问人信息-->
    <div>
        <span style="color: gray">提问人:&nbsp;<a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.get_post()->post_author;?>" class="author_link"><?php echo get_the_author();?></a></span>
        <?php
        $user_level = get_user_level(get_post()->post_author);
        $img_url = $user_level.".png";
        ?>
        <img src="<?php bloginfo("template_url")?>/img/integral/<?=$img_url?>" style="width: 20px;margin-left: -20px;">

        <span class="m-qa-count"></span>
        <span class="time_count"><?php echo date('n月j日 G:i',get_the_time('U'));?></span>
        <?php
        $offers = get_question_offers(get_post()->ID);
        if ($offers!=0){?>
            <span class="offers"><img src="<?php bloginfo("template_url")?>/img/integral/offers.png" style="width: 20px;"><?=$offers?></span>
        <? } ?>

        <span class="scan_count">浏览<?php echo dwqa_question_views_count();?></span>
        <span class="ask_count">回答<?php echo dwqa_question_answers_count();?></span>

    </div>
    <div class="divline"></div>
</div>

<?php do_action( 'dwqa_after_single_question_content' ); ?>
