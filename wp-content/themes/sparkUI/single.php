<?php
/**单独的文章模板
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/7
 * Time: 16:52
 * 第58行需手动修改pageID为My Post ID 待修改
 */
 get_header(); ?>
<?php

wp_enqueue_script('fep-script');
wp_enqueue_media();

$current_user = wp_get_current_user();
$author_posts = new WP_Query(array('posts_per_page' => $per_page, 'paged' => $paged, 'orderby' => 'DESC', 'author' => $current_user->ID, 'post_status' => $status,'category_name'=>'project'));
$postid = get_the_ID();

?>
    <div class="container" style="margin-top: 10px">
        <div class="row" style="width: 100%">
            <div class="col-md-9 col-sm-9 col-xs-9" id="col9">
                <!--引入动态模板-->
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
                <!--    文章内容-->
                 <h2><b><?php the_title(); ?></b></h2><hr>
                <?php the_content(); ?>
                <?php comments_template(); ?>
                <?php endwhile;?>
                <?php else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

                <?php endif; ?>

            </div>
            <div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
                <style type="text/css">

                    .mulu a{
                        display: block;
                        border: #9ea7af 1px solid;
                        height: 50px;
                        padding-left: 30px;
                    }
                    .mulu .mulu_item{
                        display: block;
                        border: #9ea7af 1px solid;
                        height: 50px;
                        padding-left: 50px;
                    }

                </style>


                <!--判断用户是否为项目发布者，若是，则显示编辑按钮-->
                <?php global $current_user;
                get_currentuserinfo();
                $current_user->user_login  ;
                ?>
                <?php if($current_user->user_login  == get_the_author()) {
                    require 'template/project/project_edit_button.php';
                }else {
                    require 'template/project/project_release_button.php';
                }
                ?>


                <style type="text/css">
                    .create_wiki_btn {
                        margin-bottom: 30px;
                    }
                    .mulu a{
                        display: block;
                        border: #9ea7af 1px solid;
                        height: 50px;
                        padding-left: 30px;
                    }
                    .mulu .mulu_item{
                        display: block;
                        border: #9ea7af 1px solid;
                        height: 50px;
                        padding-left: 50px;
                    }
                    .wiki_entry_info {
                        border: #9ea7af 1px solid;
                        padding: 20px 30px;
                    }
                    .wiki_entry_score {
                        border: #9ea7af 1px solid;
                        margin-top: 20px;
                        padding: 20px 30px;
                    }
                </style>
<!--                <div class="wiki_sidebar_wrap">-->
<!--                    <div class="list-group mulu">-->
<!--                        <a href="#" class="list-group-item">-->
<!--                            <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>-->
<!--                            目录-->
<!--                        </a>-->
<!--                        --><?php
//                        global $post;
//                        $wiki_content = $post->post_content;
//                        $regex = "/\<h(?:.*)\>/";
//                        $match = array();
//                        preg_match_all($regex, $wiki_content, $match);
//                        for($i=0;$i<count($match[0]);$i++) {
//                            $wiki_title_item = trim($match[0][$i]);
//                            $wiki_format_title = substr($wiki_title_item,4,-5);
//                            if(empty($wiki_format_title)) {
//                                continue;
//                            }
//                            ?>
<!--                            <a href="#" class="list-group-item mulu_item">--><?php //echo $wiki_format_title; ?><!--</a>-->
<!--                            --><?php
//                        }
//                        ?>
<!--                    </div>-->
<!--                </div>-->
                <div class="sidebar-grey-frame">
                    <p>发布者：</p>
                    <span id="" ><?php the_author(); ?></span><br>
                    <p>分类：</p>
                    <span id="" ><?php the_category(', ') ?></span><br>
                    <p>标签：</p>
                    <span id=""><?php the_tags("", "  ",''); ?></span><br>
                    <p>更新：</p>
                    <span id="" ><?php the_modified_time('Y年n月j日 h:m:s'); ?></span><br>
                    <p>浏览：</p>
                    <span id=""><?php setProjectViews(get_the_ID()); ?><?php echo getProjectViews(get_the_ID()); ?></span><br>
                    <p>评论：</p>
                    <span><?php comments_popup_link('0 条', '1 条', '% 条', '', '评论已关闭'); ?></span><br>
                </div><br>
            </div>
            <?php //get_sidebar();?>
        </div>
    </div>



<?php get_footer(); ?>

