<!--项目首页 query_posts函数仅用于修改主页循环（Loop）。
如果你希望在主循环外另外生成循环，应该新建独立的WP_Query对象，用这些对象生成循环。
在主循环外的循环上使用query_posts会导致主循环运行偏差，并可能在页面上显示出你不希望看到的内容。
query_posts函数会改写并取代页面的主查询。为谨慎起见，请不要将query_posts用作其它用途。 -->
<?php $project_all_new = new WP_Query(array( 'posts_per_page' => -1, 'paged' => $paged, 'orderby' => ' date','order' =>'DESC',  'post_status' => $status,'cat'=>12,13 ));?>
<?php $project_all_hot = new WP_Query(array( 'posts_per_page' => -1, 'paged' => $paged, 'orderby' => 'meta_value_num','meta_key' => 'project_views','order' =>'DESC',  'post_status' => $status,'cat'=>12,13 ));?>
<?php $project_hardware_new = new WP_Query(array( 'posts_per_page' => -1, 'paged' => $paged, 'orderby' => ' date','order' =>'DESC',  'post_status' => $status,'cat'=>12 ));?>
<?php $project_hardware_hot = new WP_Query(array( 'posts_per_page' => -1, 'paged' => $paged, 'orderby' => 'meta_value_num','meta_key' => 'project_views','order' =>'DESC',  'post_status' => $status,'cat'=>12 ));?>
<?php $project_web_new = new WP_Query(array( 'posts_per_page' => -1, 'paged' => $paged, 'orderby' => ' date','order' =>'DESC',  'post_status' => $status,'cat'=>13 ));?>
<?php $project_web_hot = new WP_Query(array( 'posts_per_page' => -1, 'paged' => $paged, 'orderby' => 'meta_value_num','meta_key' => 'project_views','order' =>'DESC',  'post_status' => $status,'cat'=>13 ));?>
<div class="col-md-9 col-sm-9 col-xs-9" id="col9">
<ul id="leftTab" class="nav nav-pills" style="float: left;height: 42px;">
        <li class="active"><a href="#project_all" data-toggle="tab">所有</a></li>
        <li><a href="#OShardware" data-toggle="tab">开源硬件</a></li>
        <li><a href="#web" data-toggle="tab">web学习</a></li>
</ul>

<div id="leftTabContent" class="tab-content">
    <!--所有页面-->
    <div class="tab-pane fade in active" id="project_all">
        <ul id="rightTab" class="nav nav-pills" style="float: right;height: 42px">
            <li><a href="#hot" data-toggle="tab" >热门</a></li>
            <li class="active"><a href="#recent" data-toggle="tab" >最新</a></li>
        </ul>
        <div id="rightTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="recent"><!--最新-->
                <div style="height: 2px;background-color: lightgray"></div><br>
                 <ul class="list-group">
                     <?php while ($project_all_new->have_posts()) : $project_all_new->the_post(); ?>
                         <?php include(TEMPLATEPATH .'/template/project/project_single.php'); ?>
                     <?php endwhile; ?>
                 </ul>
            </div>
            <div class="tab-pane fade" id="hot"><!--热门-->
                <div style="height: 2px;background-color: lightgray"></div><br>
                    <ul class="list-group">
                        <?php while ($project_all_hot->have_posts()) : $project_all_hot->the_post(); ?>
                            <?php include(TEMPLATEPATH .'/template/project/project_single.php'); ?>
                        <?php endwhile; ?>
                    </ul>
            </div>
        </div>
    </div>
    <!--开源硬件页面-->
    <div class="tab-pane fade" id="OShardware">
        <ul id="rightTab" class="nav nav-pills" style="float: right;height: 42px">
            <li><a href="#hot_2" data-toggle="tab" >热门</a></li>
            <li class="active"><a href="#recent_2" data-toggle="tab" >最新</a></li>
        </ul>
        <div id="rightTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="recent_2"><!--硬件最新-->
                <div style="height: 2px;background-color: lightgray"></div><br>
                    <ul class="list-group">
                        <?php while ($project_hardware_new ->have_posts()) : $project_hardware_new->the_post(); ?>
                            <?php include(TEMPLATEPATH .'/template/project/project_single.php'); ?>
                        <?php endwhile; ?>
                    </ul>        
            </div>
            <div class="tab-pane fade" id="hot_2"><!--硬件热门-->
                <div style="height: 2px;background-color: lightgray"></div><br>
                    <ul class="list-group">
                        <?php while ($project_hardware_hot ->have_posts()) : $project_hardware_hot->the_post(); ?>
                            <?php include(TEMPLATEPATH .'/template/project/project_single.php'); ?>
                        <?php endwhile; ?>
                    </ul>        
            </div>
        </div>
    </div>
    <!--web开发页面-->
    <div class="tab-pane fade" id="web">
        <ul id="rightTab" class="nav nav-pills" style="float: right;height: 42px">
            <li><a href="#hot_3" data-toggle="tab" >热门</a></li>
            <li class="active"><a href="#recent_3" data-toggle="tab" >最新</a></li>
        </ul>
        <div id="rightTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="recent_3"><!--web最新-->
                <div style="height: 2px;background-color: lightgray"></div><br>
                    <ul class="list-group">
                        <?php while ($project_web_new  ->have_posts()) : $project_web_new ->the_post(); ?>
                            <?php include(TEMPLATEPATH .'/template/project/project_single.php'); ?>
                        <?php endwhile; ?>
                    </ul>        
            </div>
            <div class="tab-pane fade" id="hot_3"><!--web热门-->
                <div style="height: 2px;background-color: lightgray"></div><br>
                    <ul class="list-group">
                        <?php while ($project_web_hot  ->have_posts()) : $project_web_hot ->the_post(); ?>
                            <?php include(TEMPLATEPATH .'/template/project/project_single.php'); ?>
                        <?php endwhile; ?>
                    </ul>        
            </div>
        </div>
    </div>
</div>
</div>
<?php wp_reset_query();
wp_reset_postdata(); ?>

