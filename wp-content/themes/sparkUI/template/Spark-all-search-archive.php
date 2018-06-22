<?php
$search_word=$_GET['s'];
$ans_id = array();  //存储每个答案的id。
$ans_author_id = array(); //存储每个答案的作者
$votes=array();  //存储每个答案的赞数
$post_content = array();
$args = array('post_parent'=>$array_qa[$i]);
$answer_ids=get_children($args,'ARRAY_A');

foreach ( $answer_ids as $answer_id ){   //剥除外层数组
    $ans_id[]=$answer_id['ID'];
    $ans_author_id[]=$answer_id['post_author'];
    $votes[] = dwqa_vote_count($answer_id['ID']);
    $post_content[] = $answer_id['post_content'];
}
$pos_search =@max($votes) ? @max($votes) : 0;
$pos=array_search($pos_search,$votes);  //赞数最多的位置,用于定位最佳回答的作者
$best_ans_author=$ans_author_id[$pos];  //赞数最多的答案作者ID
$best_ans_id=$ans_id[$pos];         //赞数最多的答案ID
$best_post_content=$post_content[$pos];
?>
<style>
    .qa_show{
        margin-left: 0px;
    }
</style>
<?php
if (dwqa_question_answers_count($array_qa[$i]) != 0) {
    if (get_post_meta($array_qa[$i], '_dwqa_status', true) == 'open'||get_post_meta($array_qa[$i], '_dwqa_status', true) == 'answered') {?>
        <li class="list-group-item" style="padding: 15px 0px">
        <div class="qa_show">
            <div class="qa_title">
                <a class="ask_topic" href="<?php echo get_permalink($array_qa[$i]);?>">
                    <?php echo str_replace($search_word,'<font color="red">'.$search_word.'</font>',get_the_title($array_qa[$i]));?>
                </a>
            </div>
            <div style="color:gray;margin-top:10px;">
                <div class="qa_time">
                    <a href="<?php echo dwqa_get_author_link($best_ans_author);?>" class="author_link"><?php echo get_userdata($best_ans_author)->display_name;?></a>
                    <span><?php echo human_time_diff( get_post_time( 'U', true ,$array_qa[$i]) )."前";?></span>&nbsp;&nbsp;
                    <span>回答</span>
                    <div style="word-wrap: break-word; word-break: keep-all;display: inline-block;">
                        <h4>
                            <?php
                            $before ='<span id="temp" class="label label-default">';
                            $sep = '</span><span id="temp" class="label label-default">';
                            $after='</span>';
                            //if(get_the_tag_list()){
                            echo get_the_term_list($array_qa[$i], 'dwqa-question_tag', $before , $sep, $after );
                            //}
                            ?>
                        </h4>
                    </div>
                </div>
                <!--答案内容 逻辑有待完善-->
                <div class="qa_best_answer">
                    <?php $qa_best_answer_content = str_replace($search_word,'<font color="red">'.$search_word.'</font>',$best_post_content);?>
                    <?php echo mb_strimwidth($qa_best_answer_content, 0, 100,"...");?>
                </div>
            </div>
        </div>
        <div class="divline"></div>
        </li><?php
    } elseif (get_post_meta($array_qa[$i], '_dwqa_status', true) == 'resolved' || get_post_meta($array_qa[$i], '_dwqa_status', true) == 'close') {?>
        <li class="list-group-item" style="padding: 15px 0px">
            <div class="qa_show">
                <div class="qa_title">
                    <a class="ask_topic" href="<?php echo get_permalink($array_qa[$i]);?>"><?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_title($array_qa[$i]));?></a>
                </div>
                <!--答案展示-->
                <div style="color:gray;margin-top:10px;">
                    <div class="qa_time">
                        <?php $user_id = get_post_field( 'post_author', $array_qa[$i]) ? get_post_field( 'post_author', $array_qa[$i] ) : 0;?>
                        <a href="<?php dwqa_get_author_link( $best_ans_author );?>" class="author_link"><?php echo get_userdata($best_ans_author)->display_name;?></a>
                        <span><?php echo human_time_diff(get_the_time('U',$best_ans_id))."前";?>  </span>&nbsp;&nbsp;
                        <span>回答</span>
                        <div style="word-wrap: break-word; word-break: keep-all;display: inline-block;">
                            <h4>
                                <?php
                                $before ='<span id="temp" class="label label-default">';
                                $sep = '</span><span id="temp" class="label label-default">';
                                $after='</span>';
                                //if(get_the_tag_list()){
                                echo get_the_term_list( $array_qa[$i], 'dwqa-question_tag', $before , $sep, $after );
                                //}
                                ?>
                            </h4>
                        </div>
                    </div>
                    <div class="qa_best_answer">
                        <span class="label label-default" id="btn-solved">已采纳</span>
                        <?php $qa_best_answer_content = str_replace($search_word,'<font color="red">'.$search_word.'</font>',get_post(dwqa_get_the_best_answer($array_qa[$i]))->post_content);?>
                        <?php echo mb_strimwidth($qa_best_answer_content, 0, 100,"...");?>
                    </div>
                </div>
            </div>
            <div class="divline"></div>
        </li>
    <?php } else { echo "Oops,there is something wrong";}
}
else {?>
    <li class="list-group-item" style="padding: 15px 0px">
        <div class="qa_show">
            <div class="qa_title">
                <a class="ask_topic" href="<?php echo get_permalink($array_qa[$i]);?>">
                    <?php echo str_replace($search_word,'<font color="red">'.$search_word.'</font>',get_the_title($array_qa[$i]));?>
                </a>
            </div>
            <div class="qa_best_answer">
                <?php $qa_best_answer_content = str_replace($search_word,'<font color="red">'.$search_word.'</font>',get_the_content($array_qa[$i]));?>
                <?php echo mb_strimwidth($qa_best_answer_content, 0, 100,"...");?>
            </div>
        </div>
        <div class="divline"></div>
    </li>
<?php }


