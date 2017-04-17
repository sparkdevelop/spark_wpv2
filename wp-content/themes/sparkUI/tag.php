<?php
/*
* 标签页面
*/
get_header(); ?>
<div class="container" style="margin-top: 10px">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-9" id="col9">
            <ul id="leftTab" class="nav nav-pills" style="height: 42px">
                <li class="active" style="margin-left: 16px"> <p>标签：<?php the_tags("", ",",''); ?> </p></li>
            </ul>

            <div id="rightTabContent" class="tab-content" >
                <div class="tab-pane fade in active" id="my-publish" style="padding-top: 40px;">
                    <div style="height: 1px;background-color: lightgray;"></div><br>
                    <ul class="list-group">
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <!-- 文章 -->
                            <?php include(TEMPLATEPATH .'/template/project/project_single.php'); ?>
                            <!-- 文章end -->
                        <?php endwhile;endif; ?>
                        <div class="pagenavi">
                            <?php  project_custom_pagenavi('',4);?>
                        </div>
                    </ul>
                </div>
            </div>

        </div>
        <?php get_sidebar();?>
    </div>
</div>

<?php get_footer(); ?>
