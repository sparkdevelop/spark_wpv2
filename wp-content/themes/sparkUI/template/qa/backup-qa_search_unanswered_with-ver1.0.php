<?php
/*还没被回答的问题。
* */
?>
<li class="list-group-item" style="padding: 15px 0px">
    <div class="qa_show">
        <div class="qa_title">
            <a class="ask_topic" href="<?php echo get_permalink();?>">
                <?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_title());?>
            </a>
        </div>
        <div class="qa_best_answer">
            <?php $qa_best_answer_content = str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_content());?>
            <?php echo mb_strimwidth($qa_best_answer_content, 0, 100,"...");?>
        </div>
    </div>
    <div class="divline"></div>
</li>
