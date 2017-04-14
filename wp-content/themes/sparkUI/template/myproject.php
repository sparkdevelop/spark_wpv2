<?php
wp_enqueue_style('fep-style');
wp_enqueue_script('fep-script');
wp_enqueue_media();

$current_user = wp_get_current_user();
$status = isset($_GET['fep_type']) ? $_GET['fep_type'] : 'publish';
$paged = isset($_GET['fep_page']) ? $_GET['fep_page'] : 1;
$per_page = (isset($fep_misc['posts_per_page']) && is_numeric($fep_misc['posts_per_page'])) ? $fep_misc['posts_per_page'] : 10;//每页显示文章数
$author_posts = new WP_Query(array('posts_per_page' => -1, 'paged' => $paged, 'orderby' => 'DESC', 'author' => $current_user->ID, 'post_status' => $status,'cat'=>13,14,17 ));
$old_exist = ($paged * $per_page) < $author_posts->found_posts;
$new_exist = $paged > 1;
?>


    <div id="fep-post-table-container">
        <?php if (!$author_posts->have_posts()): ?>
            <?php _e('还没有发布过项目.', 'frontend-publishing'); ?>
        <?php else: ?>
            <p><?php printf(__('%s article(s).', 'frontend-publishing'), $author_posts->found_posts); ?></p>
        <?php endif; ?>

            <?php
            while ($author_posts->have_posts()) : $author_posts->the_post();
            $postid = get_the_ID();
            ?>
            <li style="list-style-type: none;">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <div class="thumbnail" style="height: 270px">

                        <?php
                        if ( has_post_thumbnail() ) { ?>
                            <?php the_post_thumbnail(array(220,150)); ?> <?php } else {?>
                            <img src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面" height="150"/>
                        <?php } ?>
                        <div style="height: 1px;background-color: lightgray"></div>
                        <div class="caption">
                            <div style="height: 50px;font-size: 20px;color: black;">
                                <b><a href="<?php the_permalink(); ?>" style="color: black"><?php the_title(); ?></a></b></div>
                            <div style="display: inline;">
                                <span class="fa fa-user-o pull-left" style="font-size: 12px;color: gray">&nbsp;<?php the_author(); ?></span><span class="fa fa-bookmark-o pull-right" style="font-size: 12px;color: gray"> <?php the_category(', ') ?></span>
                            </div><br>
                            <div style="display: inline;">
                                <span class="fa fa-clock-o pull-left" style="font-size: 12px;color: gray"> <?php the_time('Y年n月j日') ?> </span><span class="fa fa-comments-o pull-right" style="font-size: 12px;color: gray"> <?php comments_popup_link('0 条', '1 条', '% 条', '', '评论已关闭'); ?></span><span class="fa fa-eye pull-right" style="font-size: 12px;color: gray"> <?php echo getProjectViews(get_the_ID()); ?></span>
                                <br>
                                <?php
                                $url = get_bloginfo('url');
                                if (current_user_can('edit_post', $post->ID)){
                                    echo '<a class="delete-post" href="';
                                    echo wp_nonce_url("$url/wp-admin/post.php?action=delete&post=$id", 'delete-post_' . $post->ID);
                                    echo '">删除</a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </li>
            <?php endwhile; ?>






        <?php wp_nonce_field('fepnonce_delete_action', 'fepnonce_delete'); ?>
        <div class="fep-nav">
            <?php /*if ($new_exist): */?><!--
                <a class="fep-nav-link fep-nav-link-left" href="?fep_type=<?/*= $status */?>&fep_page=<?/*= ($paged - 1) */?>">
                    &#10094; <?php /*_e('Newer Posts', 'frontend-publishing'); */?></a>
            <?php /*endif; */?>
            <?php /*if ($old_exist): */?>
                <a class="fep-nav-link fep-nav-link-right"
                   href="?fep_type=<?/*= $status */?>&fep_page=<?/*= ($paged + 1) */?>"><?php /*_e('更多项目', 'frontend-publishing'); */?>
                    &#10095;</a>
            --><?php /*endif; */?>
            <div style="clear:both;"></div>
        </div>
        <?php wp_reset_query();
        wp_reset_postdata(); ?>
    </div>
