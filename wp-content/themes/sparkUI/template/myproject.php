<?php
wp_enqueue_style('fep-style');
wp_enqueue_script('fep-script');
wp_enqueue_media();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$current_user = wp_get_current_user();
$author_posts = new WP_Query(array('posts_per_page' => 12, 'paged' => $paged, 'orderby' => 'DESC', 'author' => $current_user->ID, 'post_status' => $status,'category_name'=>'project' ));

?>

<style type="text/css">
    #close-icon{
        position: absolute;
        display: block;
        top: 6px;
        right: 20px;
        color: lightgrey;
    }
    #close-icon:hover{
        color: #fe642d;
        cursor: pointer;
    }
</style>

<script type="text/javascript">
    //鼠标划过事件
    $(".thumbnail").mouseover(function () {
        //$(this).addClass("border");
        //显示删除叉
        $(this).getElementById("close-icon").css("display", "block");
    });
    $(".thumbnail").mouseleave(function () {
        //$(this).removeClass("border");
        //隐藏删除叉
        $(this).find("#close-icon").css("display", "none");

    });
    function delete_confirm() {
        
    }
</script>

<ul id="leftTab" class="nav nav-pills" style="height: 42px">
    <?php if (!$author_posts->have_posts()): ?>
        <p style="margin-left: 30px;margin-top:10px;font-size: 15px"><?php _e('还没有发布过项目.', 'frontend-publishing'); ?></p>
    <?php else: ?>
        <li class="active"><a ><?php printf(__('已发布项目（%s） ', 'frontend-publishing'), $author_posts->found_posts); ?></a></li>
    <?php endif; ?>
</ul>

<div id="rightTabContent" class="tab-content" >
    <div class="tab-pane fade in active" id="my-publish" style="padding-top: 40px;">
        <div style="height: 1px;background-color: lightgray;"></div><br>

        <ul class="list-group">
            <?php
            while ($author_posts->have_posts()) : $author_posts->the_post();
            $postid = get_the_ID();
            ?>
            <li style="list-style-type: none;">
                <div class="col-md-4 col-sm-4 col-xs-6" id="project-fluid">
                    <div class="thumbnail" id="project-div-fluid">
                        <span >
                             <?php
                             $url = get_bloginfo('url');
                             if (current_user_can('edit_post', $post->ID)){
                                 echo '<a class="fa fa-trash-o fa-lg" id="close-icon" class="post-delete" style="font-size:15px" onclick="return confirm(\'确认删除吗？\')" href="';
                                 echo wp_nonce_url("$url/wp-admin/post.php?action=delete&post=$id", 'delete-post_' . $post->ID);
                                 echo '"></a>';
                             }
                             ?>
                        </span> <!--删除文章-->
                        <?php
                        if ( has_post_thumbnail() ) { ?>
                            <a href="<?php the_permalink(); ?>" target="_blank"><img src="<?php the_post_thumbnail_url('full')?>" class="cover" /></a>
                        <?php } else {?>
                            <a href="<?php the_permalink(); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面" class="cover" /></a>
                        <?php } ?>
                        <div style="height: 1px;background-color: lightgray"></div>
                        <div class="caption">
                            <div class="project-title"><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></div>
                            <div>
                                <span class="fa fa-user-o pull-left">&nbsp;<?php the_author(); ?></span><span class="fa fa-bookmark-o pull-right" id="project-category-info" > <?php the_category(', ') ?></span><span class="fa fa-eye pull-right" id="m-project-views" > <?php echo getProjectViews(get_the_ID()); ?></span><br>
                                <span class="fa fa-clock-o pull-left"> <?php echo date('n月j日 G:i',get_the_time('U'));?> </span><span class="fa fa-comments-o pull-right" > <?php comments_popup_link('0 ', '1 ', '% ', '', '评论已关闭'); ?></span><span class="fa fa-eye pull-right" id="web-project-views" > <?php echo getProjectViews(get_the_ID()); ?></span><br>
                            </div>
                        </div>
                    </div>

                </div>
            </li>
            <?php endwhile; ?>
            <?php  project_custom_pagenavi($author_posts,4);?>
        </ul>
</div>





        <?php wp_nonce_field('fepnonce_delete_action', 'fepnonce_delete'); ?>
        <!--<div class="fep-nav">
            <?php /*if ($new_exist): */?><!--
                <a class="fep-nav-link fep-nav-link-left" href="?fep_type=<?/*= $status */?>&fep_page=<?/*= ($paged - 1) */?>">
                    &#10094; <?php /*_e('Newer Posts', 'frontend-publishing'); */?></a>
            <?php /*endif; */?>
            <?php /*if ($old_exist): */?>
                <a class="fep-nav-link fep-nav-link-right"
                   href="?fep_type=<?/*= $status */?>&fep_page=<?/*= ($paged + 1) */?>"><?php /*_e('更多项目', 'frontend-publishing'); */?>
                    &#10095;</a>
            --><?php /*endif; */?>
           <!-- <div style="clear:both;"></div>
        </div>-->
        <?php wp_reset_query();
        wp_reset_postdata(); ?>
    </div>
