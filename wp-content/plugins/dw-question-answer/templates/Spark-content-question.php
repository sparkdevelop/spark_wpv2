<?php
    $ans_id = array();  //存储每个答案的id。
    $ans_author_id = array(); //存储每个答案的作者
    $votes=array();  //存储每个答案的赞数
    $post_content = array();
    $answer_ids=get_children(get_the_ID(),'ARRAY_A');
    //print_r($answer_ids);
    foreach ( $answer_ids as $answer_id ){   //剥除外层数组
        $ans_id[]=$answer_id['ID'];
        $ans_author_id[]=$answer_id['post_author'];
        $votes[] = dwqa_vote_count($answer_id['ID']);
        $post_content[] = $answer_id['post_content'];
    }
    $tol_votes=array_sum($votes);   //总的赞数
    $pos_search =@max($votes) ? @max($votes) : 0;
    $pos=array_search($pos_search,$votes);  //赞数最多的位置,用于定位最佳回答的作者
    $best_ans_author=$ans_author_id[$pos];  //赞数最多的答案作者ID
    $best_ans_id=$ans_id[$pos];         //赞数最多的答案ID
    $best_post_content=$post_content[$pos];

    //用户的自己的链接需要
    $user_id=get_post()->post_author;?>
<?php
    if (dwqa_question_answers_count() != 0) {
        if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {?>
            <li class="list-group-item" style="padding: 15px 0px">
                <!--    获取提问者头像-->
                <div style="display: inline-block;vertical-align: top;margin-top: 0px">
                    <?php echo get_avatar(get_the_author_ID(),48,'');?>
                </div>
                <div class="qa_show">
                    <!--        获取提问者名字、提问时间-->
                    <div class="qa_time">
                        <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$user_id;?>" class="author_link"><?php echo get_the_author();?></a>
                        <span><?php echo date('n月j日 G:i',get_the_time('U'));?>  </span>&nbsp;&nbsp;
                        <!--            -->
                        <span>提问</span>
                    </div>
                    <!--        获取问题的标题-->
                    <div class="qa_title">
                        <a class="ask_topic" href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a>
                    </div>

                    <!--        答案展示-->
                    <div style="color:gray;margin-top:10px;">
                        <!--            获取回答者信息(名字、时间)-->
                        <div class="qa_time">
                            <!--                --><?php //$user_id = get_post_field( 'post_author', get_the_ID() ) ? get_post_field( 'post_author', get_the_ID() ) : 0;?>
                            <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$best_ans_author;?>" class="author_link"><?php echo get_userdata($best_ans_author)->display_name;?></a>
                            <span><?php echo human_time_diff( get_post_time( 'U', true ) )."前";//human_time_diff(get_the_time('U',$best_ans_id))."前";?> </span>&nbsp;&nbsp;
                            <span>回答</span>
                        </div>
                        <!--            答案内容 逻辑有待完善-->
                        <div class="qa_best_answer">
                            <?php echo mb_strimwidth($best_post_content, 0, 100,"...");?>
                            <?php //echo $best_post_content; ?>
                        </div>

                        <span class="qa_count">赞同<?php echo dwqa_vote_count($best_ans_id);?></span>&nbsp;&nbsp;
                        <span class="qa_count" >回答<?php echo dwqa_question_answers_count();?></span>&nbsp;&nbsp;
                        <span class="qa_count" >浏览<?php echo dwqa_question_views_count();?></span>&nbsp;&nbsp;
                        <div style="word-wrap: break-word; word-break: keep-all;display: inline-block;">
                            <h4>
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
        <?php
        }
        elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {?>
            <li class="list-group-item" style="padding: 15px 0px">
        <div style="display: inline-block;vertical-align: top;margin-top: 0px">
            <?php echo get_avatar(get_the_author_ID(),48,'');?>
        </div>
        <div class="qa_show">
            <div class="qa_time">
                <?php $user_id=get_post()->post_author;?>
                <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$user_id;?>" class="author_link"><?php echo get_the_author();?></a>
                <span><?php echo date('n月j日 G:i',get_the_time('U'));?>  </span>&nbsp;&nbsp;
                <span>提问</span>
            </div>

            <div class="qa_title">
                <a class="ask_topic" href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a>
            </div>
            <!--答案展示-->
            <div style="color:gray;margin-top:10px;">
                <div class="qa_time">
                    <?php $user_id = get_post_field( 'post_author', get_the_ID() ) ? get_post_field( 'post_author', get_the_ID() ) : 0;?>
                    <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$best_ans_author;?>" class="author_link"><?php echo get_userdata($best_ans_author)->display_name;?></a>
                    <span><?php echo human_time_diff(get_the_time('U',$best_ans_id))."前";?>  </span>&nbsp;&nbsp;
                    <span>回答</span>
                </div>
                <div class="qa_best_answer">
                    <span class="label label-default" id="btn-solved">已采纳</span>
                    <?php echo mb_strimwidth(get_post(dwqa_get_the_best_answer())->post_content, 0, 100,"...");?>
                    <?php //echo get_post(dwqa_get_the_best_answer())->post_content;?>
                </div>

                <span class="qa_count">赞同<?php echo dwqa_vote_count($best_ans_id);?></span>&nbsp;&nbsp;
                <span class="qa_count">回答<?php echo dwqa_question_answers_count();?></span>&nbsp;&nbsp;
                <span class="qa_count">浏览<?php echo dwqa_question_views_count();?></span>&nbsp;&nbsp;
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
        <?php } else {echo "Oops,there is something wrong";}
    }
    else {?>
        <li class="list-group-item" style="padding: 15px 0px">
            <div style="display: inline-block;vertical-align: top;margin-top: 0px">
                <?php echo get_avatar(get_the_author_ID(),48,'');?>
            </div>
            <div class="qa_show">
                <div class="qa_time">
                    <?php $user_id=get_post()->post_author;?>
                    <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$user_id;?>" class="author_link"><?php echo get_the_author();?></a>
                    <span><?php echo date('n月j日 G:i',get_the_time('U'));?>  </span>&nbsp;&nbsp;
                    <span>提问</span>
                </div>
                <!--//标题-->

                <div class="qa_title">
                    <a class="ask_topic" href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a>
                </div>
                <!--撰写答案-->
                <div class="qa_info">
                    <a href="<?php echo get_permalink();?>">
                        <button class="btn btn-default" id="btn-answer">
                            撰写答案
                        </button>
                    </a>

                    <span class="qa_count" >回答<?php echo dwqa_question_answers_count();?></span>&nbsp;&nbsp;
                    <span class="qa_count">浏览<?php echo dwqa_question_views_count();?></span>&nbsp;&nbsp;
                    <div style="word-wrap: break-word; word-break: keep-all;display: inline-block">
                        <h4>
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
    <?php }
?>


