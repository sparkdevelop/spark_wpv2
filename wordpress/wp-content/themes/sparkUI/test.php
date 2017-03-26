<?php
$instance = wp_parse_args( $instance, array('title' => __( 'hardware all questions', 'dwqa' ),
    'number' => 10,
) );

$args_hot = array(
    'posts_per_page'    => $instance['number'],
    'order'             => 'DESC',
    'orderby'           => 'meta_value_num',
    'meta_key'          => '_dwqa_views',
    'post_type'         => 'dwqa-question',
    //'suppress_filters'  => false,
);
$args_all = array(
    'posts_per_page'    => $instance['number'],
    'order'             => 'DESC',
    //'orderby'           => 'meta_value_num',
    'meta_key'          => '_dwqa_views',
    'post_type'         => 'dwqa-question',
    //'suppress_filters'  => false,
);

$questions_hot = new WP_Query( $args_hot );
$questions_all = new WP_Query( $args_all );
if ( $questions_hot->have_posts()||$questions_all->have_posts() ) {
?>

    <ul id="leftTab" class="nav nav-pills" style="float: left;height: 42px;">
        <li class="active"><a href="#OShardware" data-toggle="tab">开源硬件</a></li>
        <li><a href="#web" data-toggle="tab" style="margin-left: -16px">web学习</a></li>
    </ul>

    <div id="leftTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="OShardware">
            <ul id="rightTab" class="nav nav-pills" style="float: right;height: 42px;">
                <li><a href="#hot" data-toggle="tab">热门</a></li>
                <li class="active"><a href="#all" data-toggle="tab">所有989</a></li>
                <li><a href="#unresolve" data-toggle="tab">未解决102</a></li>
            </ul>
            <div id="rightTabContent" class="tab-content">
                <div class="tab-pane fade" id="hot">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                    <?php
//                    if ( $questions_hot->have_posts() ) {
                    while ($questions_hot->have_posts()) {
                        $questions_hot->the_post();
                        if (dwqa_question_answers_count() == 0) {
                            require 'template/qa_unanswered.php';
                        }
                        else {
                            if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {
                                require 'template/qa_answered.php';
                            } elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {
                                require 'template/qa_resolved.php';
                            } else {
                                echo "Oops,there is something wrong";
                            }
                        }
                    }
                    ?>
                    </ul>
                </div>
                <div class="tab-pane fade in active" id="all">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                        <?php
//                        if ( $questions_all->have_posts() ) {
                            while ($questions_all->have_posts()) {
                                $questions_all->the_post();
                                if (dwqa_question_answers_count() == 0) {
                                    require 'template/qa_unanswered.php';
                                }
                                else {
                                    if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {
                                        require 'template/qa_answered.php';
                                    } elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {
                                        require 'template/qa_resolved.php';
                                    } else {
                                        echo "Oops,there is something wrong";
                                    }
                                }
                            }
                            ?>
                        </ul>
                </div>
                <div class="tab-pane fade" id="unresolve">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                    <?php
                    while ($questions_all->have_posts()) {
                        $questions_all->the_post();
                        if (dwqa_question_answers_count() == 0) {
                            require 'template/qa_unanswered.php';
                        }
                    }
                    ?>
                        </ul>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="web">
            <ul id="rightTab" class="nav nav-pills" style="float: right;height: 42px;">
                <li><a href="#webhot" data-toggle="tab">热门</a></li>
                <li class="active"><a href="#weball" data-toggle="tab">所有989</a></li>
                <li><a href="#webunresolve" data-toggle="tab">未解决102</a></li>
            </ul>
            <div id="rightTabContent" class="tab-content">
                <div class="tab-pane fade" id="webhot">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                        <?php
                        while ($questions_hot->have_posts()) {
                            $questions_hot->the_post();
                            if (dwqa_question_answers_count() == 0) {
                                require 'template/qa_unanswered.php';
                            }
                            else {
                                if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {
                                    require 'template/qa_answered.php';
                                } elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {
                                    require 'template/qa_resolved.php';
                                } else {
                                    echo "Oops,there is something wrong";
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="tab-pane fade in active" id="weball">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                        <?php
                        while ($questions_all->have_posts()) {
                            $questions_all->the_post();
                            if (dwqa_question_answers_count() == 0) {
                                require 'template/qa_unanswered.php';
                            }
                            else {
                                if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {
                                    require 'template/qa_answered.php';
                                } elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {
                                    require 'template/qa_resolved.php';
                                } else {
                                    echo "Oops,there is something wrong";
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="webunresolve">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                        <?php
                        while ($questions_all->have_posts()) {
                            $questions_all->the_post();
                            if (dwqa_question_answers_count() == 0) {
                                require 'template/qa_unanswered.php';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php } //如果有符合条件的问题
wp_reset_query();
wp_reset_postdata();
//echo $after_widget;
?>





