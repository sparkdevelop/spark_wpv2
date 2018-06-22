<?php
if (!is_user_logged_in()) {
    wp_redirect(home_url() . '/wp-login.php');
}
get_header(); ?>
<div class="container" style="margin-top: 10px;flex: 1 0 auto">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
            <?php require "template/search-template.php"; ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>
