<?php
/*
 * 处理一些必要的数据
 * */
/*已经回答了但还没有采纳,状态是open or answered
 * */
$ans_id = array();  //存储每个答案的id。
$ans_author_id = array(); //存储每个答案的作者
$votes=array();  //存储每个答案的赞数
$answer_ids=get_children(get_the_ID(),'ARRAY_A');
//print_r($answer_ids);
foreach ( $answer_ids as $answer_id ){   //剥除外层数组
    $ans_id[]=$answer_id['ID'];
    $ans_author_id[]=$answer_id['post_author'];
    $votes[] = dwqa_vote_count($answer_id['ID']);
}
$tol_votes=array_sum($votes);   //总的赞数
$pos=array_search(max($votes),$votes);  //赞数最多的位置,用于定位最佳回答的作者
$best_ans_author=$ans_author_id[$pos];  //赞数最多的答案作者ID
$best_ans_author=$ans_author_id[$pos];   //赞数最多的答案作者ID
$best_ans_id=$ans_id[$pos];         //赞数最多的答案ID
?>

<li class="list-group-item" style="padding: 15px 0px">
    <div style="display: inline-block;vertical-align: top;margin-top: 0px">
        <?php echo get_avatar(get_the_author_ID(),30,'');?>
    </div>
    <div style="display: inline-block;vertical-align: top;width: 84%;margin-left: 15px">
        <div style="color:gray">
            <a href="<?php get_the_author_link()?>"><?php echo get_the_author();?></a>
            <span style="margin-left: 20px"><?php echo date('n月j日 G:i',get_the_time('U'));?>  </span>&nbsp;&nbsp;
            <span>提问</span>
        </div>

        <div style="margin-top:10px;">
            <a class="ask_topic" href="<?php echo get_permalink();?>" style="font-size: medium;font-weight: bold"><?php echo get_the_title();?></a>
        </div>
        <!--答案展示-->
        <div style="color:gray;margin-top:10px;">
            <div style="color:gray">
                <?php $user_id = get_post_field( 'post_author', get_the_ID() ) ? get_post_field( 'post_author', get_the_ID() ) : 0;?>
                <a href="<?php dwqa_get_author_link( $best_ans_author );?>"><?php echo get_userdata($best_ans_author)->display_name;?></a>
                <span style="margin-left: 20px"><?php echo human_time_diff(get_the_time('U',$best_ans_id))."前";?>  </span>&nbsp;&nbsp;
                <span>回答</span>
            </div>
            <div style="color: gray;margin-top: 10px">
                <span class="label label-default">已采纳</span>
                <?php echo get_post(dwqa_get_the_best_answer())->post_content;?>
            </div>


            <span class="ask_count">赞同<?php echo dwqa_vote_count($best_ans_id);?></span>&nbsp;&nbsp;
            <span class="ask_count" style="margin-left: 20px">回答<?php echo dwqa_question_answers_count();?></span>&nbsp;&nbsp;
            <span class="scan_count" style="margin-left: 20px">浏览<?php echo dwqa_question_views_count();?></span>&nbsp;&nbsp;
            <div class="content-label" style="word-wrap: break-word; word-break: keep-all;display: inline-block">
                <h4 style="margin-bottom: 0px">
                    <?php
                    $before ='<span id="temp" class="label label-default">';
                    $sep = '</span><span id="temp" class="label label-default">';
                    $after='</span>';
                    //if(get_the_tag_list()){
                        echo get_the_term_list( get_the_ID(), 'dwqa-question_tag', $before , $sep, $after );
                    //}
                    ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="divline"></div>
</li>