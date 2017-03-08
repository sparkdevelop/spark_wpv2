<?php get_header(); ?>

    <div style="float: left;width: 700px">
        <?php
        if( have_posts() ){
            while( have_posts() ){
                the_post();
                ?>
                <div>
                    <div><h2><a href="<? the_permalink(); ?>"><? the_title(); ?></a><h2></div>
                    <div><? the_content(); ?></div>
                </div>
                <?php
            }
        }else{
            echo '没有';
        }
        ?>
    </div>
<? get_sidebar(); ?>
<?php get_footer(); ?>