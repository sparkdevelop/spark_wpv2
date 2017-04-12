<?php
//翻页所需参数
$posts_per_page = isset( $dwqa_general_settings['posts-per-page'] ) ?  $dwqa_general_settings['posts-per-page'] : 5; //每页展示的问题数
$page_text = dwqa_is_front_page() ? 'page' : 'paged';
$page = get_query_var( $page_text );
$archive_question_url = get_permalink(); //设当前页面为archive页面
$qa_filter = isset( $_GET['filter'] ) && !empty( $_GET['filter'] ) ? sanitize_text_field( $_GET['filter'] ) : 'my-questions';
if ( is_user_logged_in() ) {
    if($qa_filter=='my-questions'){
            $query = array(
                'post_type' => 'dwqa-question',
                'post_per_page'=>$posts_per_page,
                'author' => get_current_user_id(),
                'orderby' => 'date'
            );
            $query['paged'] = $page ? $page : 1;
            $qa_query = new WP_Query($query);
        }
    if($qa_filter=='my-answers'){
            $query = array(
                'post_type' => 'dwqa-answer',
                'post_per_page'=>$posts_per_page,
                'author' => get_current_user_id(),
                'orderby' => 'date');
            $query['paged'] = $page ? $page : 1;
            $qa_query = new WP_Query($query);
        }
}
else{
    echo "请先登录";
    $url=wp_login_url(get_permalink());
    echo "<script language=\"javascript\">";
    echo "location.href=\"$url\"";
    echo "</script>";
}
$args = array(
    'base' => add_query_arg($page_text, '%#%', $archive_question_url),
    'format' => '',
    'current' => $page,
    'total' => $qa_query->max_num_pages,
    'show_all' => True,
);
$paginate = paginate_links($args);
?>
    <ul id="myqaTab" class="nav nav-pills">
        <?php
        $current_url = curPageURL();
        $url_array=parse_url($current_url);
        $query_parse=explode("&",$url_array['query']);
        if(array_search("filter=my-answers",$query_parse)){?>
            <li><a href="<?php echo esc_url(add_query_arg( array('filter'=>'my-questions' ) ) )?>">我的提问</a></li>
            <li class="active"><a href="<?php echo esc_url(add_query_arg( array('filter'=>'my-answers' ) ) )?>">我的回答</a></li>
        <?php }else{ ?>
            <li id="my-questions" class="active"><a href="<?php echo esc_url(add_query_arg( array('filter'=>'my-questions' ) ) )?>">我的提问</a></li>
            <li id="my-answers"><a href="<?php echo esc_url(add_query_arg( array('filter'=>'my-answers' ) ) )?>">我的回答</a></li>
        <?php } ?>
    </ul>
    <div class="dwqa-questions-list">
        <?php if ( $qa_query->have_posts() ) : ?>
            <?php while ($qa_query->have_posts()):$qa_query->the_post();?>
                <?php if ( get_post_status() == 'publish' || ( get_post_status() == 'private' && dwqa_current_user_can( 'edit_question', get_the_ID() ) ) ) : ?>
                    <?php dwqa_load_template( 'Spark-personal-archive', 'questions' ) ?>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php else : ?>
            <?php dwqa_load_template( 'content', 'none' ) ?>
        <?php endif; ?>
    </div>
    <div class="dwqa-questions-footer"  style="text-align: center;margin-bottom: 20px;margin-top: 10px">
        <div class="dwqa-pagination">
            <?php echo $paginate;?>
        </div>
    </div>
<?php
wp_reset_query();
wp_reset_postdata();
?>
