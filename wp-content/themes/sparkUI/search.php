<?php get_header(); ?>
<div class="container" style="margin-top: 10px">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-9" id="col9">
        <?php $posts=query_posts($query_string .'&posts_per_page=5'); ?>
        <?php require "template/qa/QA_search.php";?>
        </div>
        <?php get_sidebar();?>
    </div>
</div>
<?php get_footer(); ?>
