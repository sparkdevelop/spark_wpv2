<?php
/* header&footer为导航和下脚
 * index.php为所有页面通用模板
 * front-page.php为仅仅首页的默认模板
 * sidebar.php为右侧页面的默认模板
 * home.php为文章列表页面
 * single.php为单文章列表页,也就是文章详情页
 */
?>

<?php get_header(); ?>
<div class="container" style="margin-top: 10px">
    <div class="row" style="width: 100%">
<<<<<<< HEAD
        <div class="col-md-9 col-sm-9 col-xs-9" style="padding-left: 0;padding-right: 0;">
=======
        <div class="col-md-8 col-sm-8 col-xs-8">
>>>>>>> 0736b4fcc462d013e0d3eb82e8bbadfb98202f56
            <!--引入动态模板 显示文章标题和提交时间-->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <h2><a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h2>
                <p><em><?php the_time('l, F jS, Y'); ?></em></p>
                <hr>

            <?php endwhile; else: ?>
                <p><?php _e('Sorry, there are no posts.'); ?></p>
            <?php endif; ?>
        </div>

<<<<<<< HEAD
        <div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
=======
        <div class="col-md-4 col-sm-4 col-xs-4 right">
>>>>>>> 0736b4fcc462d013e0d3eb82e8bbadfb98202f56
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
