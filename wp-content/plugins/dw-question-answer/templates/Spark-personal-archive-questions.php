<?php
$qa_filter = isset( $_GET['filter'] ) && !empty( $_GET['filter'] ) ? sanitize_text_field( $_GET['filter'] ) : 'my-questions';
if($qa_filter=='my-answers') {
    $Qpost_id=get_post()->post_parent;
    ?>
    <li class="list-group-item" style="padding: 15px 0px;">
        <div class="qa_title">
            <a class="ask_topic" href="<?php echo get_permalink($Qpost_id);?>"><?php echo get_the_title($Qpost_id);?></a>
        </div>
        <div>
            <p>我的回答</p>
            <div class="qa_best_answer">
                <?php echo mb_strimwidth(get_the_content(), 0, 100,"...");?>
            </div>
        </div>
        <div style="line-height: 44px;height: 44px;">
            <span class="qa_count" >回答<?php echo dwqa_question_answers_count($Qpost_id);?></span>&nbsp;&nbsp;
            <span class="qa_count" >浏览<?php echo dwqa_question_views_count($Qpost_id);?></span>&nbsp;&nbsp;
            <div style="word-wrap: break-word; word-break: keep-all;display: inline-block;">
                <h4>
                    <?php
                    $before ='<span id="temp" class="label label-default">';
                    $sep = '</span><span id="temp" class="label label-default">';
                    $after='</span>';
                    echo get_the_term_list( $Qpost_id, 'dwqa-question_tag', $before , $sep, $after );
                    ?>
                </h4>
            </div>
            <div class="qa_show" style="display: inline-block;width: 60%;">
                <!--        获取提问者名字、提问时间-->
                <div class="qa_time">
                    <span><?php echo date('n月j日 G:i',get_the_time('U'));?>  </span>&nbsp;&nbsp;
                    <span>回答</span>
                </div>
            </div>
        </div>
        <div class="divline"></div>
    </li>
<?php }
else{ ?>
    <li class="list-group-item" style="padding: 15px 0px">
        <div class="qa_title">
            <a class="ask_topic" href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a>
        </div>
        <div style="line-height: 44px;height: 44px;">
            <span class="qa_count" >回答<?php echo dwqa_question_answers_count();?></span>&nbsp;&nbsp;
            <span class="qa_count" >浏览<?php echo dwqa_question_views_count();?></span>&nbsp;&nbsp;
            <div style="word-wrap: break-word; word-break: keep-all;display: inline-block;">
                <h4>
                    <?php
                    $before ='<span id="temp" class="label label-default">';
                    $sep = '</span><span id="temp" class="label label-default">';
                    $after='</span>';
                    echo get_the_term_list( get_the_ID(), 'dwqa-question_tag', $before , $sep, $after );
                    ?>
                </h4>
            </div>
            <div class="qa_show" style="display: inline-block;width: 60%;">
                <!--        获取提问者名字、提问时间-->
                <div class="qa_time">
                    <span><?php echo date('n月j日 G:i',get_the_time('U'));?>  </span>&nbsp;&nbsp;
                    <span>提问</span>
                </div>
            </div>
        </div>
        <div class="divline"></div>
    </li>
<?php } ?>

