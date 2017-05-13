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
        <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
            <!--引入动态模板-->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
                <h2><b><?php the_title(); ?></b></h2>
                <hr>
                <?php the_content(); ?>
                <hr>
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

<div class="side-tool" id="side-tool-project">
    <ul>
        <li data-placement="left" data-toggle="tooltip" data-original-title="回到顶部"><a href="#" class="">顶部</a></li>
        <li data-placement="left" data-toggle="tooltip" data-original-title="点赞吐槽"><a href="#comments" class="">评论</a></li>

        <?php if(is_user_logged_in()){ ?>
                <?php session_start();
                $_SESSION['post_id'] = get_the_ID();
                $_SESSION['post_type'] = get_post_type(get_the_ID());?>
                <li data-placement="left" data-toggle="tooltip" data-original-title="不懂就问"><a href="<?php echo site_url().get_page_address('ask_tiny');?>">提问</a></li>
        <?php }else{ ?>
                <li data-placement="left" data-toggle="tooltip" data-original-title="不懂就问"><a href="<?php echo wp_login_url( get_permalink() ); ?>">提问</a></li>
        <?php } ?>

    </ul>
</div>
<div class="side-tool" id="m-side-tool-project">
    <ul>
        <li><a href="<?php echo get_permalink( get_page_by_title( '编辑wiki' )); ?>&post_id=<?php echo $post->ID ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
        <li><a href="<?php echo get_permalink( get_page_by_title( '创建wiki' )); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
    </ul>
</div>

<?php
global $wpdb;
$post_id = get_the_ID();
$term_names = $wpdb->get_results("select t.`name` from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=".$post_id." and tt.taxonomy=\"wiki_cats\"");
$wiki_categorys = array();
foreach($term_names as $term_name) {
    $wiki_categorys[] = $term_name->name;
}

$tag_names = $wpdb->get_results("select t.`name` from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=".$post_id." and tt.taxonomy=\"wiki_tags\"");
$wiki_tags = array();
foreach($tag_names as $tag_name) {
    $wiki_tags[] = $tag_name->name;
}

$term_all_names = $wpdb->get_results("select t.`name`, t.`term_id` from $wpdb->terms t left join $wpdb->term_taxonomy tt on tt.term_id = t.term_id where tt.taxonomy = \"wiki_cats\";");
$wiki_all_categorys = array();
foreach($term_all_names as $wiki_all_name) {
    $wiki_all_categorys[$wiki_all_name->term_id] = $wiki_all_name->name;
}
$_SESSION['wiki_categories'] = $wiki_categorys;
$_SESSION['wiki_all_categories'] = $wiki_all_categorys;
$_SESSION['wiki_tags'] = $wiki_tags;
?>

<?php get_footer(); ?>


























