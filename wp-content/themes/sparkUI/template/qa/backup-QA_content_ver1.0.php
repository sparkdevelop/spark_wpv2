<style>

</style>

<!--//本页面是问答页面的content-->
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <?php
    //==============处理翻页 未完成======================
    //add_action('Spark_after_question_list','Spark_question_paginate_link');
//    function Spark_question_paginate_link($count){
//    $perpage=6;
//    $max_num_pages = $count/$perpage+1;
//    $big = 9999;
//    $args = array(
//        'base' =>str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
//        //'base' => add_query_arg( $page_text, '%#%', $url ),
//        //'format' => '',
//        'current' => 0,
//        'total' => $max_num_pages,
//        'show_all'=>true,
//    );
//    $paginate = paginate_links( $args );
//    if ( $max_num_pages > 1 ) {
//        echo '<div class="dwqa-pagination" style="margin-top: 15px;text-align: center;">';
//        echo $paginate;
//        echo '</div>';
//    }
//}
//    function Spark_question_paginate_link_backup() {
//    global $wp_query, $dwqa_general_settings;
//
//    $archive_question_url = get_permalink( $dwqa_general_settings['pages']['archive-question'] );
//    $page_text = dwqa_is_front_page() ? 'page' : 'paged';
//    $page = get_query_var( $page_text ) ? get_query_var( $page_text ) : 1;
//
//    $tag = get_query_var( 'dwqa-question_tag' ) ? get_query_var( 'dwqa-question_tag' ) : false;
//    $cat = get_query_var( 'dwqa-question_category' ) ? get_query_var( 'dwqa-question_category' ) : false;
//
//    $url = $cat
//        ? get_term_link( $cat, get_query_var( 'taxonomy' ) )
//        : ( $tag ? get_term_link( $tag, get_query_var( 'taxonomy' ) ) : $archive_question_url );
//
//    $args = array(
//        'base' => add_query_arg( $page_text, '%#%', $url ),
//        'format' => '',
//        'current' => $page,
//        'total' => $wp_query->dwqa_questions->max_num_pages
//    );
//
//    $paginate = paginate_links( $args );
//    $paginate = str_replace( 'page-number', 'dwqa-page-number', $paginate );
//    $paginate = str_replace( 'current', 'dwqa-current', $paginate );
//    $paginate = str_replace( 'next', 'dwqa-next', $paginate );
//    $paginate = str_replace( 'prev ', 'dwqa-prev ', $paginate );
//    $paginate = str_replace( 'dots', 'dwqa-dots', $paginate );
//
//    if ( $wp_query->dwqa_questions->max_num_pages > 1 ) {
//        echo '<div class="dwqa-pagination">';
//        echo $paginate;
//        echo '</div>';
//    }
//}

//===============处理一些需要显示的数据===================================
//global $wpdb;
//$post_id =array();
//$new_meta_id =array();
//$sql_1="SELECT ID FROM $wpdb->posts WHERE post_type='dwqa-question' AND post_status != 'auto-draft' AND post_status != 'trash'";
//$sql_2="SELECT post_id from $wpdb->postmeta WHERE meta_key='_dwqa_views'";
//$result_1 =$wpdb->get_results($sql_1);
//$result_2 =$wpdb->get_results($sql_2);
//
//foreach ($result_1 as $temp){
//    $post_id[]=$temp->ID;
//}
//foreach ($result_2 as $temp){
//    $new_meta_id[]=$temp->post_id;
//}
//
//$new_question_id=array_merge(array_diff($post_id,$new_meta_id),array_diff($new_meta_id,$post_id));
//if(!empty($new_question_id)){
//    if(count($new_question_id) ==1){
//        //插入一行数据
//        $sql_3="INSERT INTO $wpdb->postmeta VALUES ('',".$new_question_id[0].",'_dwqa_views',0)";
//        $wpdb->query($sql_3);
//    }
//    else{
//        for($i=0;$i<count($new_question_id);$i++)
//        {
//            $sql_4 = "INSERT INTO $wpdb->postmeta VALUES ('',".$new_question_id[$i].",'_dwqa_views',0)";
//            $wpdb->query($sql_4);
//        }
//    }
//}

$instance = wp_parse_args( $instance, array('title' => __( 'all questions', 'dwqa' ),
    'number' => 10,
) );

$args_hardware_hot = array(
    'posts_per_page'    => $instance['number'],
    'order'             => 'DESC',
    'orderby'           => 'meta_value_num',
    'meta_key'          => '_dwqa_views',
    'post_type'         => 'dwqa-question',
    'nopaging'          => 'true',
    'tax_query' => array(
        array(
            'taxonomy' => 'dwqa-question_category',
            'field'    => 'slug',
            'terms'    => 'hardware',
        ),
    )
);
$args_hardware_all = array(
    'posts_per_page'    => $instance['number'],
    'order'             => 'DESC',
    'meta_key'          => '_dwqa_views',
    'post_type'         => 'dwqa-question',
    'nopaging'          => 'true',
    'tax_query' => array(
        array(
            'taxonomy' => 'dwqa-question_category',
            'field'    => 'slug',
            'terms'    => 'hardware',
        ),
    )
);
$args_web_hot = array(
    'posts_per_page'    => $instance['number'],
    'order'             => 'DESC',
    'orderby'           => 'meta_value_num',
    'meta_key'          => '_dwqa_views',
    'post_type'         => 'dwqa-question',
    'nopaging'          => 'true',
    'tax_query' => array(
        array(
            'taxonomy' => 'dwqa-question_category',
            'field'    => 'slug',
            'terms'    => 'web',
        ),
    )
);
$args_web_all = array(
    //'posts_per_page'    => $instance['number'],
    'order'             => 'DESC',
    'meta_key'          => '_dwqa_views',
    'post_type'         => 'dwqa-question',
    'nopaging'          => 'true',
    'tax_query' => array(
        array(
            'taxonomy' => 'dwqa-question_category',
            'field'    => 'slug',
            'terms'    => 'web',
        ),
    )
);
$args_question_all = array(
        'posts_per_page'    => $instance['number'],
        'order'             => 'DESC',
        //'orderby'           => 'meta_value_num',
        'meta_key'          => '_dwqa_views',
        'post_type'         => 'dwqa-question',
        'nopaging'          => 'true',
);
$args_question_hot = array(
        'posts_per_page'    => $instance['number'],
        'order'             => 'DESC',
        'orderby'           => 'meta_value_num',
        'meta_key'          => '_dwqa_views',
        'post_type'         => 'dwqa-question',
        'nopaging'          => 'true',
    );
    //============================================
$questions_hareware_hot = new WP_Query( $args_hardware_hot );
$questions_hareware_all = new WP_Query( $args_hardware_all );
$questions_web_hot = new WP_Query( $args_web_hot );
$questions_web_all = new WP_Query( $args_web_all );
$questions_question_hot = new WP_Query( $args_question_hot );
$questions_question_all = new WP_Query( $args_question_all );

    //===========================================
$hardware_count=$questions_hareware_all->post_count;
$web_count = $questions_web_all->post_count;?>

    <?php
    if ($questions_question_all->have_posts()){
    ?>
    <ul id="leftTab" class="nav nav-pills">
        <li><a href="#question_all" data-toggle="tab">所有问题</a></li>
        <li class="active">
            <a href="#OShardware" data-toggle="tab">开源硬件</a>
        </li>
        <li><a href="#web" data-toggle="tab">web学习</a></li>
    </ul>

    <div id="leftTabContent" class="tab-content">
        <div class="tab-pane fade" id="question_all">
            <ul id="rightTab" class="nav nav-pills" style="float: right;height: 42px;">
                <li><a href="#questionhot" data-toggle="tab">热门</a></li>
                <li class="active"><a href="#questionall" data-toggle="tab">所有</a></li>
                <li><a href="#questionunresolve" data-toggle="tab">未解决</a></li>
            </ul>
            <div id="rightTabContent" class="tab-content">
                <div class="tab-pane fade" id="questionhot">
                    <div style="height: 2px;background-color: lightgray"></div>

                    <ul class="list-group">
                        <?php
                        while ($questions_question_hot->have_posts()) {
                            $questions_question_hot->the_post();
                            if (dwqa_question_answers_count() != 0) {
                                if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {
                                    require 'qa_answered.php';
                                } elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {
                                    require 'qa_resolved.php';
                                } else {
                                    echo "Oops,there is something wrong";
                                }
                            }
                            else {
                                require 'qa_unanswered.php';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="tab-pane fade in active" id="questionall">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                        <?php
                        while ($questions_question_all->have_posts()) {
                            $questions_question_all->the_post();
                            if (dwqa_question_answers_count() != 0) {
                                if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {
                                    require 'qa_answered.php';
                                } elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {
                                    require 'qa_resolved.php';
                                } else {
                                    echo "Oops,there is something wrong";
                                }
                            }
                            else {
                                require 'qa_unanswered.php';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="questionunresolve">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                        <?php
                        while ($questions_question_all->have_posts()) {
                            $questions_question_all->the_post();
                            if (dwqa_question_answers_count() != 0) {
                            }else{
                                require 'qa_unanswered.php';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-pane fade in active" id="OShardware">
            <ul id="rightTab" class="nav nav-pills">
                <li><a href="#hot" data-toggle="tab">热门</a></li>
                <li class="active"><a href="#all" data-toggle="tab">所有</a></li>
                <li><a href="#unresolve" data-toggle="tab">未解决</a></li>
            </ul>
            <div id="rightTabContent" class="tab-content">
                <div class="tab-pane fade" id="hot">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                        <?php
                        while ($questions_hareware_hot->have_posts()) {
                            $questions_hareware_hot->the_post();
                            if (dwqa_question_answers_count() != 0) {
                                if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {
                                    require 'qa_answered.php';
                                } elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {
                                    require 'qa_resolved.php';
                                } else {
                                    echo "Oops,there is something wrong";
                                }
                            }
                            else {
                                require 'qa_unanswered.php';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="tab-pane fade in active" id="all">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                        <?php
                        while ($questions_hareware_all->have_posts()) {
                            $questions_hareware_all->the_post();
                            if (dwqa_question_answers_count() != 0) {
                                if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {
                                    require 'qa_answered.php';
                                } elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {
                                    require 'qa_resolved.php';
                                } else {
                                    echo "Oops,there is something wrong";
                                }
                            }
                            else {
                                require 'qa_unanswered.php';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="unresolve">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                        <?php
                        while ($questions_hareware_all->have_posts()) {
                            $questions_hareware_all->the_post();
                            if (dwqa_question_answers_count() != 0) {
                            }else{
                                require 'qa_unanswered.php';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="web">
            <ul id="rightTab" class="nav nav-pills">
                <li><a href="#webhot" data-toggle="tab">热门</a></li>
                <li class="active"><a href="#weball" data-toggle="tab">所有</a></li>
                <li><a href="#webunresolve" data-toggle="tab">未解决</a></li>
            </ul>
            <div id="rightTabContent" class="tab-content">
                <div class="tab-pane fade" id="webhot">
                    <div style="height: 2px;background-color: lightgray"></div>

                    <ul class="list-group">
                        <?php
                        while ($questions_web_hot->have_posts()) {
                            $questions_web_hot->the_post();
                            if (dwqa_question_answers_count() != 0) {
                                if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {
                                    require 'qa_answered.php';
                                } elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {
                                    require 'qa_resolved.php';
                                } else {
                                    echo "Oops,there is something wrong";
                                }
                            }
                            else {
                                require 'qa_unanswered.php';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="tab-pane fade in active" id="weball">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                        <?php
                        while ($questions_web_all->have_posts()) {
                            $questions_web_all->the_post();
                            if (dwqa_question_answers_count() != 0) {
                                if (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'open'||get_post_meta(get_the_ID(), '_dwqa_status', true) == 'answered') {
                                    require 'qa_answered.php';
                                } elseif (get_post_meta(get_the_ID(), '_dwqa_status', true) == 'resolved' || get_post_meta(get_the_ID(), '_dwqa_status', true) == 'close') {
                                    require 'qa_resolved.php';
                                } else {
                                    echo "Oops,there is something wrong";
                                }
                            }
                            else {
                                require 'qa_unanswered.php';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="webunresolve">
                    <div style="height: 2px;background-color: lightgray"></div>
                    <ul class="list-group">
                        <?php
                        while ($questions_web_all->have_posts()) {
                            $questions_web_all->the_post();
                            if (dwqa_question_answers_count() != 0) {
                            }else{
                                require 'qa_unanswered.php';
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
?>
</div>
