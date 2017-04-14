<?php
/**单独的文章模板
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/7
 * Time: 16:52
 */
 get_header(); ?>
<?php
//wp_enqueue_style('fep-style');
wp_enqueue_script('fep-script');
wp_enqueue_media();

$current_user = wp_get_current_user();
$status = isset($_GET['fep_type']) ? $_GET['fep_type'] : 'publish';
$paged = isset($_GET['fep_page']) ? $_GET['fep_page'] : 1;
$per_page = (isset($fep_misc['posts_per_page']) && is_numeric($fep_misc['posts_per_page'])) ? $fep_misc['posts_per_page'] : 10;//每页显示文章数
$author_posts = new WP_Query(array('posts_per_page' => $per_page, 'paged' => $paged, 'orderby' => 'DESC', 'author' => $current_user->ID, 'post_status' => $status,'cat'=>13,14,17 ));
$old_exist = ($paged * $per_page) < $author_posts->found_posts;
$new_exist = $paged > 1;
$postid = get_the_ID();

?>
    <div class="container" style="margin-top: 10px">
        <div class="row" style="width: 100%">
            <div class="col-md-8 col-sm-8 col-xs-8">
                <!--引入动态模板-->
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
                <!--    文章内容-->
                 <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
                <?php comments_template(); ?>
                <?php endwhile;?>
                <?php else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

                <?php endif; ?>

            </div>
            <div class="col-md-4 col-sm-4 col-xs-4 right">
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
                <?php $postid = get_the_ID(); ?>
                <div class="sidebar_button" style="margin-top: 20px;margin-right: 15px;margin-left: -2px">
                    <a href="?fep_action=edit&fep_id=<?= $postid; ?><?= (isset($_SERVER['QUERY_STRING']) ? '&' . $_SERVER['QUERY_STRING'] : '') ?>&page_id=199" style="color: white" >编辑项目</a>
                </div><br><br>
                <!--项目目录-->
                <!--<table class="table table-bordered" style="width: 200px;margin-left: 5px">
                    <tbody>
                        <tr>
                            <td style="padding-left: 20px"><b>目录</b></td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px">目标</td>
                        </tr>
                        <tr>
                            <td style="padding-left: 20px">原理</td>
                        </tr>
                    </tbody>
                </table>-->

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
                <div class="wiki_sidebar_wrap">
                    <div class="list-group mulu">
                        <a href="#" class="list-group-item">
                            <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
                            目录
                        </a>
                        <?php
                        global $post;
                        $wiki_content = $post->post_content;
                        $regex = "/\<h(?:.*)\>/";
                        $match = array();
                        preg_match_all($regex, $wiki_content, $match);
                        for($i=0;$i<count($match[0]);$i++) {
                            $wiki_title_item = trim($match[0][$i]);
                            $wiki_format_title = substr($wiki_title_item,4,-5);
                            if(empty($wiki_format_title)) {
                                continue;
                            }
                            ?>
                            <a href="#" class="list-group-item mulu_item"><?php echo $wiki_format_title; ?></a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div style="width: 200px;height: 200px;border: 2px solid lightgray;margin-left: 5px">
                    <p style="font-size: small;display:inline-block;margin-left: 20px;margin-top: 20px;font-weight: bold;">发布者：</p>
                    <span id="" style="display: inline-block;"><?php the_author(); ?></span><br>
                    <p style="font-size: small;display:inline-block;margin-left: 20px;font-weight: bold;">分类：</p>
                    <span id="" style="display: inline-block;"><?php the_category(', ') ?></span><br>
                    <p style="font-size: small;display:inline-block;margin-left: 20px;font-weight: bold;">标签：</p>
                    <span id="" style="display: inline-block;"><?php the_tags("", ",",''); ?></span><br>
                    <p style="font-size: small;display:inline-block;margin-left: 20px;font-weight: bold;">更新：</p>
                    <span id="" style="display: inline-block;"><?php the_modified_time('Y年n月j日 h:m:s'); ?></span><br>
                    <p style="font-size: small;display:inline-block;margin-left: 20px;font-weight: bold;">浏览：</p>
                    <span id="" style="display: inline-block;"><?php setProjectViews(get_the_ID()); ?><?php echo getProjectViews(get_the_ID()); ?></span><br>
                    <p style="font-size: small;display:inline-block;margin-left: 20px;font-weight: bold;">评论：</p>
                    <span id="" style="display: inline-block;"><?php comments_popup_link('0 条', '1 条', '% 条', '', '评论已关闭'); ?></span><br>
                </div><br>
            </div>
            <?php //get_sidebar();?>
        </div>
    </div>


<?php get_footer(); ?>

