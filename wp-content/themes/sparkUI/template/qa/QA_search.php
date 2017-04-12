<?php
$search_word=$_GET['s'];
$post_status=$_GET['post_status'];
$post_type= isset($_GET['post_type'])&&!empty($_GET['post_type'])?$_GET['post_type']: "dwqa-question";
$posts_per_page= isset($_GET['posts_per_page'])&&!empty($_GET['posts_per_page'])?$_GET['posts_per_page']: 5;
$archive_question_url = get_permalink(); //设当前页面为archive页面
//翻页所需参数
$page_text = dwqa_is_front_page() ? 'page' : 'paged';
$page = get_query_var( $page_text );

//$qa_filter = isset( $_GET['filter'] ) && !empty( $_GET['filter'] ) ? sanitize_text_field( $_GET['filter'] ) : 'my-questions';
//if ( is_user_logged_in() ) {
    if($post_type=='wiki'){    //根据自身情况更改
        $query = array(
            'post_type' => 'wiki',
            'post_per_page'=>$posts_per_page,
            'orderby' => 'date'
        );
        $query['paged'] = $page ? $page : 1;
        $search_query = new WP_Query($query);
    }
    if($post_type=='project'){  //根据自身情况更改
        $query = array(
            'post_type' => 'project',
            'post_per_page'=>$posts_per_page,
            'orderby' => 'date');
        $query['paged'] = $page ? $page : 1;
        $qa_query = new WP_Query($query);
    }
    else{
        $query = array(
            'post_type' => 'dwqa-question',
            'post_per_page'=>$posts_per_page,
            'author' => get_current_user_id(),
            'orderby' => 'date'
        );
        $query['paged'] = $page ? $page : 1;
        $qa_query = new WP_Query($query);
    }
//}
//else{
//    echo "请先登录";
//    $url=wp_login_url(get_permalink());
//    echo "<script language=\"javascript\">";
//    echo "location.href=\"$url\"";
//    echo "</script>";
//}
$args = array(
    'base' => add_query_arg($page_text, '%#%', $archive_question_url),
    'format' => '',
    'current' => $page,
    'total' => $qa_query->max_num_pages,
    'show_all' => True,
);
$paginate = paginate_links($args);





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



