
<li class="list-group-item" style="padding: 15px 0px">
    <div style="display: inline-block;vertical-align: top;margin-top: 0px">
        <?php echo get_avatar(get_the_author_ID(),30,'');?>
    </div>
    <div style="display: inline-block;vertical-align: top;width: 84%;margin-left: 15px">
        <div style="color:gray">
            <a href="<?php get_the_author_link();?>" class="author_link"><?php echo get_the_author();?></a>
            <span style="margin-left: 20px"><?php echo date('n月j日 G:i',get_the_time('U'));?>  </span>&nbsp;&nbsp;
            <span>提问</span>
        </div>
        <!--//标题-->

        <div style="margin-top:10px;">
            <a class="ask_topic" href="<?php echo get_permalink();?>"><?php echo get_the_title();?></a>
        </div>
        <!--撰写答案-->
        <div class="qa_info">
            <a href="<?php echo get_permalink();?>">
                <button class="btn btn-default" id="btn-answer">
                    撰写答案
                </button>
            </a>

            <span class="qa_count">回答<?php echo dwqa_question_answers_count();?></span>&nbsp;&nbsp;
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