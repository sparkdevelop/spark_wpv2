<!--//本页面是问答页面的content-->
<div class="col-md-9 col-sm-9 col-xs-9" id="col9">
<?php
$args_question_all = array(
        'post_type'         => 'dwqa-question',
);
$questions_question_all = new WP_Query( $args_question_all );
?>

    <ul id="leftTab" class="nav nav-pills">
        <li  class="active"><a href="#allquestions" data-toggle="tab">所有问题</a></li>
        <li><a href="#OShardware" data-toggle="tab">开源硬件</a></li>
        <li><a href="#Spweb" data-toggle="tab">web学习</a></li>
    </ul>

    <div id="leftTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="allquestions">
                <ul id="rightTab" class="nav nav-pills" style="margin-top: -42px">
                    <li><a href="<?php echo esc_url(add_query_arg( array( 'post_type'=>'dwqa-question','sort' => 'views' ),site_url().'/') )?>">热门</a></li>
                    <li class="active"><a href="<?php echo esc_url(add_query_arg(array('post_type'=>'dwqa-question','filter'=>'all'),site_url().'/' ))?>">所有</a></li>
                    <li><a href="<?php echo esc_url( add_query_arg( array('post_type'=>'dwqa-question', 'filter' => 'unanswered' ) ) ) ?>">未解决</a></li>
                </ul>
                <div class="dwqa-questions-list" style="margin-top: 42px">
                    <?php if ( $questions_question_all->have_posts() ) : ?>
                        <?php while ($questions_question_all->have_posts()):$questions_question_all->the_post();?>
                            <?php if ( get_post_status() == 'publish' || ( get_post_status() == 'private' && dwqa_current_user_can( 'edit_question', get_the_ID() ) ) ) : ?>
                                <?php dwqa_load_template( 'Spark-content', 'question' ) ?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <?php dwqa_load_template( 'content', 'none' ) ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tab-pane fade" id="OShardware">
            <ul id="rightTab" class="nav nav-pills" style="margin-top: -42px">
                <li><a href="<?php echo esc_url(add_query_arg( array( 'dwqa-question_category'=>'hardware','sort' => 'views'),site_url().'/') )?>">热门</a></li>
                <li class="active"><a href="<?php echo remove_query_arg(array('sort','filter')) ?>">所有</a></li>
                <li><a href="<?php echo esc_url( add_query_arg( array( 'dwqa-question_category'=>'hardware','filter' => 'unanswered'),site_url().'/') )?>">未解决</a></li>
            </ul>
            <div class="dwqa-questions-list" style="margin-top: 42px">
                <?php if ( $questions_question_all->have_posts() ) : ?>
                    <?php while ($questions_question_all->have_posts()):$questions_question_all->the_post();?>
                        <?php if ( get_post_status() == 'publish' || ( get_post_status() == 'private' && dwqa_current_user_can( 'edit_question', get_the_ID() ) ) ) : ?>
                            <?php dwqa_load_template( 'Spark-content', 'question' ) ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                <?php else : ?>
                    <?php dwqa_load_template( 'content', 'none' ) ?>
                <?php endif; ?>
            </div>
        </div>
            <div class="tab-pane fade" id="Spweb">
                <ul id="rightTab" class="nav nav-pills" style="margin-top: -42px">
                    <li><a href="<?php echo esc_url(add_query_arg( array( 'dwqa-question_category'=>'web','sort' => 'views'),site_url().'/') )?>">热门</a></li>
                    <li class="active"><a href="<?php echo remove_query_arg(array('sort','filter')) ?>">所有</a></li>
                    <li><a href="<?php echo esc_url( add_query_arg( array( 'dwqa-question_category'=>'web','filter' => 'unanswered'),site_url().'/') )?>">未解决</a></li>
                </ul>
                <div class="dwqa-questions-list" style="margin-top: 42px">
                    <?php if ( $questions_question_all->have_posts() ) : ?>
                        <?php while ($questions_question_all->have_posts()):$questions_question_all->the_post();?>
                            <?php if ( get_post_status() == 'publish' || ( get_post_status() == 'private' && dwqa_current_user_can( 'edit_question', get_the_ID() ) ) ) : ?>
                                <?php dwqa_load_template( 'Spark-content', 'question' ) ?>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <?php dwqa_load_template( 'content', 'none' ) ?>
                    <?php endif; ?>
                </div>
            </div>
    </div>

<?php  //如果有符合条件的问题
wp_reset_query();
wp_reset_postdata();
?>
</div>
