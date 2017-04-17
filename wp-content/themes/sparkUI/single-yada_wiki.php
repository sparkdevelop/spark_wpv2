<?php
/**
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/7
 * Time: 16:52
 */
get_header(); ?>
<!--<a class="brand" href="--><?php //echo site_url(); ?><!--">--><?php //bloginfo('name'); ?><!--</a>-->
<?php //wp_list_pages(array('title_li' => '', 'exclude' => 4));//创建一个列表项并且链接到每一个页面 ?>

<div class="container" style="margin-top: 10px">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-9" id="col9">
            <!--引入动态模板-->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
                <h2><b><?php the_title(); ?></b></h2>
                <hr>
                <?php the_content(); ?>
                <?php comments_template(); ?>
            <?php endwhile;?>
            <?php else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

            <?php endif; ?>

        </div>
        <div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php
global $wpdb;
$post_id = get_the_ID();
$term_names = $wpdb->get_results("select t.`name` from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=".$post_id." and tt.taxonomy=\"wiki_cats\"");
$wiki_categorys = array();
foreach($term_names as $term_name) {
    $wiki_categorys[] = $term_name->name;
}
$term_all_names = $wpdb->get_results("select t.`name`, t.`term_id` from $wpdb->terms t left join $wpdb->term_taxonomy tt on tt.term_id = t.term_id where tt.taxonomy = \"wiki_cats\";");
$wiki_all_categorys = array();
foreach($term_all_names as $wiki_all_name) {
    $wiki_all_categorys[$wiki_all_name->term_id] = $wiki_all_name->name;
}
$_SESSION['wiki_categories'] = $wiki_categorys;
$_SESSION['wiki_all_categories'] = $wiki_all_categorys;
?>

<?php get_footer(); ?>


























