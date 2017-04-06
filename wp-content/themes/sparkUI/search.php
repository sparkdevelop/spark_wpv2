<?php get_header(); ?>
<div class="container" style="margin-top: 10px">
    <div class="row" style="width: 100%">
        <div class="col-md-8 col-sm-8 col-xs-8">
            hahahahhahhaah
            <?php echo $post_status;?>
        </div>





        <?php $posts=query_posts($query_string .'&posts_per_page=20'); ?>
        <?php if (have_posts()) : ?>
            <h2>Search Results</h2>
            <?php while (have_posts()) : the_post(); ?>
                <article class="searchlist clearfix">
                    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to < ?php the_title_attribute(); ?>">< ?php the_title(); ?></a>
                    <br/>Posted in <?php the_category(', ') ?> on <?php the_time('l jS F, Y - g:ia') ?>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
        <?php get_sidebar();?>
    </div>
</div>
<?php get_footer(); ?>
