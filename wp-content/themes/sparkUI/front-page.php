<?php get_header(); ?>
<!--<a class="brand" href="--><?php //echo site_url(); ?><!--">--><?php //bloginfo('name'); ?><!--</a>-->
<?php //wp_list_pages(array('title_li' => '', 'exclude' => 4));//创建一个列表项并且链接到每一个页面 ?>

<div class="container" style="margin-top: 10px">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-9" id="col9">
            <!--引入动态模板-->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
            <!--    首页内容-->
            <!--        <h1>--><?php //the_title(); ?><!--</h1>-->
                    <?php the_content(); ?>

            <?php endwhile;?>
                  <?php else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

            <?php endif; ?>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3 right " id="col3">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
