<?php
/* header&footer为导航和下脚
 * index.php为所有页面通用模板
 * front-page.php为仅仅首页的默认模板
 * sidebar.php为右侧页面的默认模板
 *
 *
 */
?>



<?php get_header(); ?>


<!--引入动态模板-->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
<!--    标题和内容-->
<!--    <h1>-->
<!--        --><?php //the_title();//注释掉就不显示标题了 ?>
<!--    </h1>-->
        <?php the_content(); ?>

<?php endwhile;?>
      <?php else: ?>
    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>



<?php get_footer(); ?>
