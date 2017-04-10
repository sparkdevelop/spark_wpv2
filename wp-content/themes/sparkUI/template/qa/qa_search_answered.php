<?php
/*已经回答了但还没有采纳,状态是open or answered
 * */
$ans_id = array();  //存储每个答案的id。
$ans_author_id = array(); //存储每个答案的作者
$votes=array();  //存储每个答案的赞数
$post_content = array();
$answer_ids=get_children(get_the_ID(),'ARRAY_A');
foreach ( $answer_ids as $answer_id ){   //剥除外层数组
    $ans_id[]=$answer_id['ID'];
    $ans_author_id[]=$answer_id['post_author'];
    $votes[] = dwqa_vote_count($answer_id['ID']);
    $post_content[] = $answer_id['post_content'];
}
$tol_votes=array_sum($votes);   //总的赞数
$pos=array_search(max($votes),$votes);  //赞数最多的位置,用于定位最佳回答的作者
$best_ans_author=$ans_author_id[$pos];   //赞数最多的答案作者ID
$best_ans_id=$ans_id[$pos];         //赞数最多的答案ID
$best_post_content=$post_content[$pos];

?>

<li class="list-group-item" style="padding: 15px 0px">
    <div class="qa_show">
        <!--        获取问题的标题-->
        <div class="qa_title">
            <a class="ask_topic" href="<?php echo get_permalink();?>">
                <?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_title());?>
            </a>
        </div>

        <!--        答案展示-->
        <div style="color:gray;margin-top:10px;">
            <!--            获取回答者信息(名字、时间)-->
            <div class="qa_time">
                <!--                --><?php //$user_id = get_post_field( 'post_author', get_the_ID() ) ? get_post_field( 'post_author', get_the_ID() ) : 0;?>
                <a href="<?php echo dwqa_get_author_link($best_ans_author);?>" class="author_link"><?php echo get_userdata($best_ans_author)->display_name;?></a>
                <span><?php echo human_time_diff( get_post_time( 'U', true ) )."前";//human_time_diff(get_the_time('U',$best_ans_id))."前";?> </span>&nbsp;&nbsp;
                <span>回答</span>
            </div>
            <!--            答案内容 逻辑有待完善-->
            <div class="qa_best_answer">
                <?php $qa_best_answer_content = str_replace($search_word,'<font color=red>'.$search_word.'</font>',$best_post_content);?>
                <?php echo mb_strimwidth($qa_best_answer_content, 0, 100,"...");?>
            </div>
        </div>
    </div>
    <div class="divline"></div>
</li>
<?php
//$ans_id=-1;
//$ans_author_id=-1;
//?>
