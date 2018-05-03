<?php
wp_enqueue_script('fep-script');
wp_enqueue_media();

$current_user = wp_get_current_user();
//获取文章作者ID、用户名
$post_id = get_the_ID();
$author_id = get_post($post_id)->post_author;
$author_name = get_the_author_meta('user_login', $author_id);
$release_id = get_page_id('release');

//获取当前用户用户名
$admin_url = admin_url('admin-ajax.php');
$apply_url = site_url().get_page_address('apply_permission').'&id='.$post_id;
?>
<div class="container" style="margin-top: 10px;flex: 1 0 auto">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
            <!--引入动态模板-->
            <?php if (have_posts()) : while (have_posts()) :
                the_post(); ?>
                <!--    文章内容-->
                <div style="display:inline-block;">
                    <h2><b><?php the_title(); ?></b></h2>
                </div>
                <hr>
                <div style="height: 600px;overflow: hidden">
                    <?php the_content(); ?>
                </div>
                <div class="readall_box">
                    <div class="read_more_mask"></div>
                    <a class="btn btn-orange" onclick="layer_apply_permission('<?=$apply_url?>')">阅读全文</a>
                </div>
            <?php endwhile; ?>
            <?php else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
            <!--判断用户是否为项目发布者，若是，则显示编辑按钮,否则显示发布按钮-->
            <div class="sidebar_button">
                <?php if ($current_user->user_login == $author_name) {
                    echo "<a href='?fep_action=edit&fep_id=$post_id&page_id=$release_id' >编辑项目</a >";
                } else {
                    echo "<a href='" . get_the_permalink(get_page_by_title('发布项目')) . "' target='_blank' >发布项目</a>";
                }
                ?>
            </div>
            <div class="sidebar-grey-frame" style="margin-top: 30px">
                <p>发布者：
                    <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . get_post()->post_author . '&tab=project' ?>"
                       class="author_link" style="color: #5e5e5e"><?php echo get_the_author(); ?>
                    </a>
                </p><br>
                <p>分类：</p>
                <span id=""><?php the_category(', ') ?></span><br>
                <p>标签：</p>
                <span id=""><?php the_tags("", "  ", ''); ?></span><br>
                <p>更新：</p>
                <span id=""><?php the_modified_time('Y年n月j日 h:m:s'); ?></span><br>
                <p>浏览：</p>
                <span id=""><?php setProjectViews(get_the_ID()); ?><?php echo getProjectViews(get_the_ID()); ?>
                    次</span><br>
                <p>评论：</p>
                <span><?php comments_popup_link('0 条', '1 条', '% 条', '', '评论已关闭'); ?></span><br>
            </div>
            <br>
        </div>
    </div>
</div>
<?php get_footer(); ?>



