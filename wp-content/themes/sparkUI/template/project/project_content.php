<!--项目首页 query_posts函数仅用于修改主页循环（Loop）。
如果你希望在主循环外另外生成循环，应该新建独立的WP_Query对象，用这些对象生成循环。
在主循环外的循环上使用query_posts会导致主循环运行偏差，并可能在页面上显示出你不希望看到的内容。
query_posts函数会改写并取代页面的主查询。为谨慎起见，请不要将query_posts用作其它用途。 -->
<?php
global $wp_query;
$orderby=get_query_var('orderby')? get_query_var('orderby') : 'meta_value_num';
$category_name=get_query_var('category_name')? get_query_var('category_name') : 'project';
$meta_key=get_query_var('meta_key')? get_query_var('meta_key') : 'project_views';
$paged=get_query_var('paged')? get_query_var('paged') : '1';
$query = array(
    'post_type'	=> 'post',
    'posts_per_page' => 9,
    'paged' => $paged,
    'order' =>'DESC',
    'category_name'=>$category_name,
    'orderby' =>$orderby,
    'meta_key' => $meta_key
);
$project= new WP_Query($query);
?>
<script>
    window.onload=function(){
        var li=document.getElementById("<?=$category_name?>");
        var li_default= document.getElementById("project");
        li_default.className = "";
        li.className="active";
    }
</script>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <div class="archive-nav">
        <ul id="leftTab" class="nav nav-pills" style="float: left;height: 42px;">
            <li class="active" id="project"><a href="<?php echo esc_url(remove_query_arg(array('paged','category_name')))?>" >所有</a></li>
            <li id="hardware"><a href="<?php echo esc_url(add_query_arg(array('category_name'=>'hardware','paged'=>'1')))?>" >开源硬件</a></li>
            <li id="web"><a href="<?php echo esc_url(add_query_arg(array('category_name'=>'web','paged'=>'1')))?>" >web开发</a></li>
        </ul>
    </div>
    <ul id="rightTab" class="nav nav-pills" style="float: right;height: 42px">
        <?php if($orderby== 'meta_value_num'){?>
            <li class="active"><a href="<?php echo esc_url(add_query_arg(array( 'orderby' => 'meta_value_num', 'meta_key' => 'project_views','paged'=>'1')))?>"  >热门</a></li>
            <li ><a href="<?php echo esc_url(remove_query_arg(array('meta_key'),add_query_arg(array('orderby' => 'date','paged'=>'1'))))?>"  >最新</a></li>
        <?php }else{?>
            <li ><a href="<?php echo esc_url(add_query_arg(array( 'orderby' => 'meta_value_num', 'meta_key' => 'project_views','paged'=>'1')))?>"  >热门</a></li>
            <li class="active"><a href="<?php echo esc_url(remove_query_arg(array('meta_key'),add_query_arg(array('orderby' => 'date','paged'=>'1'))))?>"  >最新</a></li>
        <?php }?>
    </ul>
    <div style="height: 2px;background-color: lightgray"></div><br>
    <ul class="list-group">
        <?php if ( $project->have_posts() ) : ?>
            <?php while ($project->have_posts()) : $project->the_post(); ?>
                <li style="list-style-type: none;">
                    <div class="col-md-4 col-sm-4 col-xs-6" id="project-fluid">
                        <div class="thumbnail" id="project-div-fluid">
                            <?php
                            if ( has_post_thumbnail() ) { ?>
                                <a href="<?php the_permalink(); ?>" target="_blank"><?php the_post_thumbnail(array(255,142)); ?></a> <?php } else {?>
                                <a href="<?php the_permalink(); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面" height="150"/></a>
                            <?php } ?>
                            <div style="height: 1px;background-color: lightgray"></div>
                            <div class="caption">
                                <div class="project-title"><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></div>
                                <div class="project-info">
                                    <span class="fa fa-user-o pull-left">&nbsp;<?php the_author(); ?></span><span class="fa fa-bookmark-o pull-right" id="project-category-info" > <?php the_category(', ') ?></span><span class="fa fa-eye pull-right" id="m-project-views" > <?php echo getProjectViews(get_the_ID()); ?></span><br>
                                    <span class="fa fa-clock-o pull-left"> <?php echo date('n月j日 G:i',get_the_time('U'));?> </span><span class="fa fa-comments-o pull-right" > <?php comments_popup_link('0 ', '1 ', '% ', '', '评论已关闭'); ?></span><span class="fa fa-eye pull-right" id="web-project-views" > <?php echo getProjectViews(get_the_ID()); ?></span><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
            <!--分页函数-->
            <?php project_custom_pagenavi($project,4);?>

            <?php wp_reset_query();
            wp_reset_postdata(); ?>
        <?php else:  ?>
            <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
        <?php endif; ?>
    </ul>
</div>

<div class="side-tool" id="m-side-tool-project">
    <ul>
        <li><a href="<?php echo get_the_permalink(get_page_by_title('发布项目')) ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
    </ul>
</div>
