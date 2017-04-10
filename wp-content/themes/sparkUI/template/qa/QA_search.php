<?php
    $search_word=$_GET['s'];
    $post_status=$_GET['post_status'];
?>
<?php if (have_posts()) : ?>
    <ul id="leftTab" class="nav nav-pills">
        <li><a href="#wiki_search" data-toggle="tab">wiki</a></li>
        <li class="active">
            <a href="#qa_search" data-toggle="tab">问答</a>
        </li>
        <li><a href="#project_search" data-toggle="tab">项目</a></li>
    </ul>
    <p style="float:right;margin-top: 15px;margin-bottom: 0px"><span style="color:#fe642d"><?=$search_word;?></span>的搜索结果</p>

    <div id="leftTabContent" class="tab-content">
        <div class="tab-pane fade" id="wiki_search">
            <div style="height: 2px;background-color: lightgray"></div>
            <ul class="list-group">
                <?php
                    while (have_posts()) : the_post();
                        if(get_post()->post_type=="wiki"){?>
                            <a href="<?php the_permalink();?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                                <?php the_title();?>
                            </a>
                            <?php echo get_post()->post_type;?>
                        <?php } ?>
                    <?php endwhile; ?>
            </ul>
        </div>
        <div class="tab-pane fade in active" id="qa_search">
        <div style="height: 2px;background-color: lightgray"></div>
            <ul class="list-group">
                <?php
                    while (have_posts()) : the_post();
                        if(get_post()->post_type=="dwqa-question"){?>
                            <?php
                            if (dwqa_question_answers_count() != 0) {
                                    if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {
                                    require 'qa_search_answered.php';
                                    } elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {
                                    require 'qa_search_resolved.php';
                                    } else {
                                    echo "Oops,there is something wrong";
                                    }
                                }
                            else {
                            require 'qa_search_unanswered.php';
                            }
                            ?>
                        <?php } ?>
                    <?php endwhile; ?>
            </ul>
        </div>
        <div class="tab-pane fade" id="project_search">
        <div style="height: 2px;background-color: lightgray"></div>
            <ul class="list-group">
                <?php
                    while (have_posts()) : the_post();
                        if(get_post()->post_type=="dwqa-question"){?>
                        <a href="<?php the_permalink();?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
                            <?php the_title();?>
                        </a>
                        <?php echo get_post()->post_type;?>
                        <?php } ?>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    <?php else: ?>
    <p><?php _e('未找到搜索结果'); ?></p>
<?php endif; ?>



