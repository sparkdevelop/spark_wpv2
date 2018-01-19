<?php
//http://wanlimm.com/77201410012399.html 翻页的解决
global $wp_query;
$search_word = isset($_GET['s'])&&!empty($_GET['s'])&&!ctype_space($_GET['s']) ? $_GET['s'] : '';
if($search_word==''){
  wp_redirect(home_url());
}
//=====获取搜索到的条目数
//所有结果
$query = array(
    's' => $search_word,
    'post_status' => 'publish',
    'post_type' => array('yada_wiki', 'dwqa-question', 'post')
);
$result = new WP_Query($query);
$all_found = $result->found_posts;

//wiki结果
$query = array(
    's' => $search_word,
    'post_status' => 'publish',
    'post_type' => 'yada_wiki'
);
$result = new WP_Query($query);
$wiki_found = $result->found_posts;

//项目结果
$query = array(
    's' => $search_word,
    'post_status' => 'publish',
    'post_type' => 'post'
);
$result = new WP_Query($query);
$project_found = $result->found_posts;

//问答结果
$query = array(
    's' => $search_word,
    'post_status' => 'publish',
    'post_type' => 'dwqa-question'
);
$result = new WP_Query($query);
$QA_found = $result->found_posts;

//标签结果


//======================
$post_type = isset($_GET['post_type']) && !empty($_GET['post_type']) ? sanitize_text_field($_GET['post_type']) : "all";

$posts_per_page = isset($_GET['posts_per_page']) && !empty($_GET['posts_per_page']) ? $_GET['posts_per_page'] : 10;
$current_url = curPageURL();//设当前页面为archive页面

//翻页所需参数
$page_text = dwqa_is_front_page() ? 'page' : 'paged';
$page = get_query_var($page_text) ? get_query_var($page_text) : 1;


if ($post_type == 'yada_wiki') {    //根据自身情况更改
    $query_string = $query_string . '&posts_per_page=10' . '&post_type=' . $post_type;
    $posts = query_posts($query_string);
} elseif ($post_type == 'post') {  //根据自身情况更改
    $query_string = $query_string . '&posts_per_page=10' . '&post_type=' . $post_type;
    $posts = query_posts($query_string);
} elseif ($post_type == 'qa') {
    $query_string = $query_string . '&posts_per_page=10' . '&post_type=dwqa-question';
    $posts = query_posts($query_string);
} else {
    $query_string = $query_string . '&posts_per_page=-1';
    $posts = query_posts($query_string);
}
$args = array(
    'base' => add_query_arg($page_text, '%#%', $current_url),
    'format' => '',
    'current' => $page,
    'show_all' => false,
);
$paginate = paginate_links($args);
?>
<style>
    #search_more_link{
        text-align: center;
        height: 50px;
        line-height: 50px;
    }
    #search_more_link a{
        font-size: medium;
    }
</style>
<div class="m_search_page_box">
    <form class="navbar-form " role="search" method="get" action="<?php echo home_url('/');//get_permalink() ?>"
          style="float: right;padding-left: 0px;padding-right: 0px">
        <div class="form-group" style="position: relative">
            <select class="form-control" id="search_select"
                    onchange="selectSearchCat(this.value);">
                <option value="qa">搜问答</option>
                <option value="wiki">搜wiki</option>
                <option value="project">搜项目</option>
            </select>
            <input type="text" id="search-content" name='s' class="form-control" placeholder="Search" value="">
            <input type="hidden" name="post_status" value="publish">
            <input type="hidden" name="post_type" id="selectPostType" value=""/>
            <button type="submit" class="btn btn-default btn-sm" id="search-btn">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </div>
    </form>
</div>

<ul id="searchTab" class="nav nav-pills">
    <?php
    $current_url = home_url(add_query_arg(array()));
    $url_array = parse_url($current_url);
    $query_parse = explode("&", $url_array['query']);
    if (array_search("post_type=yada_wiki", $query_parse)) {
        ?>
        <li><a href="<?php echo remove_query_arg(array('post_type', 'paged')) ?>">全部(<?php echo $all_found ?>)</a></li>
        <li class="active"><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'yada_wiki', 'paged' => '1'))) ?>">wiki(<?php echo $wiki_found ?>)</a></li>
        <li><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'qa', 'paged' => '1'))) ?>"">问答(<?php echo $QA_found ?>)</a></li>
        <li><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'post', 'paged' => '1'))) ?>">项目(<?php echo $project_found ?>)</a></li>
    <?php } elseif (array_search("post_type=post", $query_parse)) {
        ?>
        <li><a href="<?php echo remove_query_arg(array('post_type', 'paged')) ?>">全部(<?php echo $all_found ?>)</a></li>
        <li><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'yada_wiki', 'paged' => '1'))) ?>">wiki(<?php echo $wiki_found ?>)</a></li>
        <li><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'qa', 'paged' => '1'))) ?>"">问答(<?php echo $QA_found ?>)</a></li>
        <li class="active"><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'post', 'paged' => '1'))) ?>">项目(<?php echo $project_found ?>)</a></li>
    <?php } elseif (array_search("post_type=qa", $query_parse)) {
        ?>
        <li><a href="<?php echo remove_query_arg(array('post_type', 'paged')) ?>">全部(<?php echo $all_found ?>)</a></li>
        <li><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'yada_wiki', 'paged' => '1'))) ?>">wiki(<?php echo $wiki_found ?>)</a></li>
        <li class="active"><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'qa', 'paged' => '1'))) ?>">问答(<?php echo $QA_found ?>)</a></li>
        <li><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'post', 'paged' => '1'))) ?>">项目(<?php echo $project_found ?>)</a></li>
    <?php } else { ?>
        <li class="active"><a href="<?php echo remove_query_arg(array('post_type', 'paged')) ?>">全部(<?php echo $all_found ?>)</a></li>
        <li><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'yada_wiki', 'paged' => '1'))) ?>">wiki(<?php echo $wiki_found ?>)</a></li>
        <li><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'qa', 'paged' => '1'))) ?>">问答(<?php echo $QA_found ?>)</a></li>
        <li><a href="<?php echo esc_url(add_query_arg(array('post_type' => 'post', 'paged' => '1'))) ?>">项目(<?php echo $project_found ?>)</a></li>
    <?php } ?>
</ul>

<div class="dwqa-questions-list">
    <?php $count_wiki = 0;
    $count_qa = 0;
    $count_pro = 0;
    $array_wiki = array();
    $array_qa = array();
    $array_pro = array();
    if (have_posts()) : ?>
        <?php while (have_posts()):the_post(); ?>
            <?php if (get_post_status() == 'publish' || (get_post_status() == 'private' && dwqa_current_user_can('edit_question', get_the_ID()))) :
                if ($post_type == 'all') {
                    $post_type_for_all = get_post_type();
                    if ($post_type_for_all == 'yada_wiki' && $count_wiki < 5) {
                        if (sizeof($array_wiki) < 5) {
                            array_push($array_wiki, get_the_ID());
                        }
                        $count_wiki++;
                    }
                    if ($post_type_for_all == 'post' && $count_pro < 5) {
                        if (sizeof($array_pro) < 5) {
                            array_push($array_pro, get_the_ID());
                        }
                        $count_pro++;
                    }
                    if (($post_type_for_all == 'dwqa-question') && $count_qa < 5) {
                        if (sizeof($array_qa) < 5) {
                            array_push($array_qa, get_the_ID());
                        }
                        $count_qa++;
                    }
                } else {
                    if ($post_type == 'yada_wiki') {
                        dwqa_load_template('Spark-wiki-search', 'archive');
                    } elseif ($post_type == 'post') {
                        dwqa_load_template('Spark-project-search', 'archive');
                    } elseif ($post_type == 'qa') {
                        dwqa_load_template('Spark-qa-search', 'archive');
                    }
                } ?>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php else : ?>
        <?php dwqa_load_template('Spark-content', 'none') ?>
    <?php endif; ?>
    <?php
    wp_reset_query();
    wp_reset_postdata();
    rewind_posts();
    ?>
    <?php
    if ($post_type == 'all') {
        if ($wiki_found != 0) {
            echo '<h4 style="color: #fe642d;">wiki搜索结果</h4>';
            echo '<div class="divline"></div>';
            for ($i = 0; $i < min($wiki_found, 5); $i++) {?>
                <div style="margin-top: 20px;">
                    <div style="width: 100%;">
                        <div class="project-title">
                            <a class="project-title" href="<?php the_permalink($array_wiki[$i]); ?>" style="color: black"><?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_title($array_wiki[$i])); ?></a>
                        </div>
                        <div>
                            <?php
                            $post = get_post($array_wiki[$i]);
                            $post_content = strip_tags($post->post_content);
                            echo mb_strimwidth($post_content, 0, 100,"...");?>
                        </div>
                    </div>
                    <div style="height: 1px;background-color: #dcdcdc;margin-top: 20px"></div>
                </div>
            <?php }
            if ($wiki_found > 5) {
                echo '<div id="search_more_link"><a href="' . esc_url(add_query_arg(array('post_type' => 'yada_wiki', 'paged' => '1'))) . '">更多wiki搜索结果</a></div>';
            }
        }
        if ($QA_found != 0) {
            echo '<h4 style="color: #fe642d;">问答搜索结果</h4>';
            echo '<div class="divline"></div>';
            for ($i = 0; $i < min($QA_found, 5); $i++) {
                require 'Spark-all-search-archive.php';
            }
            if ($QA_found > 5) {
                echo '<div id="search_more_link"><a href="' . esc_url(add_query_arg(array('post_type' => 'qa', 'paged' => '1'))) . '">更多问答搜索结果</a></div>';
            }
        }
        if ($project_found != 0) {
            echo '<h4 style="color: #fe642d;">项目搜索结果</h4>';
            echo '<div class="divline"></div>';
            for ($i = 0; $i < min($project_found, 5); $i++) {?>
                <div style="margin-top: 20px;" class="clearfix">
                    <div class="m-search-project-list" style="float: left;">
                        <?php
                        if (has_post_thumbnail($array_pro[$i])) { ?>
                            <img src="<?php the_post_thumbnail_url('full') ?>"
                                 style="height:100px;width:180px;display: block"/>
                        <?php } else { ?>
                            <img src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面" height="100"
                                 width="180"/>
                        <?php } ?>
                    </div>
                    <div class="search-project-text">
                        <div class="project-title" id="m-project-title-box">
                            <a class="project-title" id="m-project-title" href="<?php the_permalink($array_pro[$i]); ?>"
                               style="color: black"><?php echo str_replace($search_word, '<font color=red>' . $search_word . '</font>', get_the_title($array_pro[$i])); ?></a>
                        </div>
                        <div>
                            <?php
                            $post = get_post($array_pro[$i]);
                            $post_content = strip_tags($post->post_content);
                            echo mb_strimwidth($post_content, 0, 100,"...");?>
                        </div>
<!--                        <p style="word-wrap: break-word">--><?php //echo str_replace($search_word, '<font color=red>' . $search_word . '</font>', get_the_excerpt($array_pro[$i])); ?>
<!--                            <a href="--><?php //the_permalink($array_pro[$i]); ?><!--" class="button right" style="color: #fe642d;">阅读全文</a>-->
<!--                        </p>-->
                    </div>
                    <div class="search-project-divline"></div>
                </div>
           <?php }
            if ($project_found > 5) {
                echo '<div id="search_more_link"><a href="' . esc_url(add_query_arg(array('post_type' => 'post', 'paged' => '1'))) . '">更多项目搜索结果</a></div>';
            }
        }
    }
    ?>
</div>
<div class="dwqa-questions-footer" style="text-align: center;margin-bottom: 20px;margin-top: 10px">
    <div class="dwqa-pagination">
        <?php echo $paginate; ?>
    </div>
</div>

