<?php
/*
* 分类页面
*/
get_header(); ?>
<div class="container" style="margin-top: 10px;flex: 1 0 auto">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
            <ul id="leftTab" class="nav nav-pills" style="height: 42px;margin-top: 10px">
                <li class="active" style="margin-left: 16px"> <p>分类目录： <?php the_category(' , ') ?></p></li>
            </ul>

            <div id="rightTabContent" class="tab-content" >
                <div class="tab-pane fade in active" id="my-publish" style="padding-top: 40px;">
                    <div style="height: 1px;background-color: lightgray;"></div><br>
                      <ul class="list-group">
                      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                          <!-- 文章 -->
                          <?php include(TEMPLATEPATH .'/template/project/project_simple.php'); ?>
                          <!-- 文章end -->
                      <?php endwhile;endif; ?>
                          <?php  project_custom_pagenavi($wp_query,4);?>
                      </ul>
                </div>
            </div>

        </div>
        <?php get_sidebar();?>
    </div>
</div>

<?php get_footer(); ?>