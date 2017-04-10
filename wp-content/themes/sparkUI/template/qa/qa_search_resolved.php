<?php
/*
 * 处理一些必要的数据
 * */
/*
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
    <div class="qa_show">
        <div class="qa_title">
            <a class="ask_topic" href="<?php echo get_permalink();?>"><?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_title());?></a>
        </div>
        <!--答案展示-->
        <div style="color:gray;margin-top:10px;">
            <div class="qa_time">
                <?php $user_id = get_post_field( 'post_author', get_the_ID() ) ? get_post_field( 'post_author', get_the_ID() ) : 0;?>
                <a href="<?php dwqa_get_author_link( $best_ans_author );?>" class="author_link"><?php echo get_userdata($best_ans_author)->display_name;?></a>
                <span><?php echo human_time_diff(get_the_time('U',$best_ans_id))."前";?>  </span>&nbsp;&nbsp;
                <span>回答</span>
            </div>
            <div class="qa_best_answer">
                <span class="label label-default" id="btn-solved">已采纳</span>
                <?php $qa_best_answer_content = str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_post(dwqa_get_the_best_answer())->post_content);?>
                <?php echo mb_strimwidth($qa_best_answer_content, 0, 100,"...");?>
            </div>
        </div>
    </div>
    <div class="divline"></div>
</li>
