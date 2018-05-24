<?php
$post_id = get_the_ID();
$admin_url=admin_url( 'admin-ajax.php' );
$apply_url = site_url().get_page_address('apply_permission').'&id='.$post_id;
?>
<div class="container" style="margin-top: 10px;flex: 1 0 auto">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
            <!--引入动态模板-->
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div style="display: inline-block">
                    <h2><b><?php the_title(); ?></b></h2>
                </div>
                <hr>
                <div style="height: 200px;overflow: hidden">
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
            <?php
            global $post;
            $entry_title = $post->post_title;
            $entry_content = $post->post_content;
            $wiki_content = $post->post_content;
            $regex = "/(?:<h2>.*<\/h2>)/";
            $match = array();
            $entry_titles = array();
            preg_match_all($regex, $wiki_content, $match);
            for ($i = 0; $i < count($match[0]); $i++) {
                $wiki_title_item = trim($match[0][$i]);
                $wiki_format_title = substr($wiki_title_item, 4, -5);
                if (empty($wiki_format_title)) {
                    continue;
                }
                $entry_titles[] = $wiki_format_title;
            }
            $_SESSION["entry_mulu"] = $entry_titles;
            ?>
            <div class="wiki_sidebar_wrap">
                <div class="row wiki-handle">
                    <div class="edit-wiki"><a
                            href="<?php echo get_permalink(get_page_by_title('编辑wiki')); ?>&post_id=<?php echo $post->ID ?>">编辑
                            wiki</a></div>
                    <div class="create-wiki"><a href="<?php echo get_permalink(get_page_by_title('创建wiki')); ?>">创建
                            wiki</a></div>
                </div>
                <?php
                global $post;
                $admin_url = admin_url('admin-ajax.php');
                ?>
                <script type="text/javascript">
                    $(function () {
                        var revision_url = "<?php echo site_url() . get_page_address('wiki_revisions') . '&wiki_id=' . $post->ID;?>";
                        var get_post_info = {
                            action: "get_post_info",
                            post_id: <?php echo $post->ID; ?>
                        };
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $admin_url;?>",
                            data: get_post_info,
                            dataType: "json",
                            success: function (data) {
                                var categories_show = "";
                                for (var i = 0; i < data.categories.length; i++) {
                                    categories_show = categories_show + data.categories[i] + "  ";
                                }
                                var tags_show = "";
                                for (var i = 0; i < data.tags.length; i++) {
                                    tags_show = tags_show + data.tags[i] + "  ";
                                }
                                $("#edit_nums").html("编辑: " + data.edit_author_nums + "人&nbsp;&nbsp;&nbsp;&nbsp;" + "<a href='" + revision_url + "' style='color: #fe642d;'>" + data.revision_nums + "个版本" + "</a>");
                                //$("#watch_nums").html("浏览: "+data);
                                $("#update_time").html("更新: " + data.time + "天前");
                                //$("#categories_show").html("分类: "+categories_show);
                                //$("#tags_show").html("标签: "+tags_show);
                                $("#watch_nums").html("浏览: " + data.watch_count + "次");
                            },
                            error: function () {
                                alert("数据加载失败!");
                            }
                        });

                    });
                </script>
                <div class="wiki_entry_info">
                    <p>创建:
                        <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . get_post()->post_author . '&tab=wiki' ?>"
                           class="author_link" style="color: #5e5e5e"><?php echo get_the_author(); ?>
                        </a>
                        <?php
                        $user_level = get_user_level(get_post()->post_author);
                        $img_url = $user_level.".png";
                        ?>
                        <img src="<?php bloginfo("template_url")?>/img/integral/<?=$img_url?>" style="width: 20px;margin-left: -20px">
                    </p>
                    <p id="edit_nums"></p>
                    <p id="watch_nums"></p>
                    <p id="update_time"></p>
                    <p id="categories_show">分类：<?php the_terms($post->ID, 'wiki_cats', '', ',', ''); ?></p>
                    <p id="tags_show">标签：<?php the_terms($post->ID, 'wiki_tags', '', ',', ''); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php
    global $wpdb;
    $post_id = get_the_ID();
    $term_names = $wpdb->get_results("select t.`name` from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=" . $post_id . " and tt.taxonomy=\"wiki_cats\"");
    $wiki_categorys = array();
    foreach ($term_names as $term_name) {
        $wiki_categorys[] = $term_name->name;
    }

    $tag_names = $wpdb->get_results("select t.`name` from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=" . $post_id . " and tt.taxonomy=\"wiki_tags\"");
    $wiki_tags = array();
    foreach ($tag_names as $tag_name) {
        $wiki_tags[] = $tag_name->name;
    }

    $term_all_names = $wpdb->get_results("select t.`name`, t.`term_id` from $wpdb->terms t left join $wpdb->term_taxonomy tt on tt.term_id = t.term_id where tt.taxonomy = \"wiki_cats\";");
    $wiki_all_categorys = array();
    foreach ($term_all_names as $wiki_all_name) {
        $wiki_all_categorys[$wiki_all_name->term_id] = $wiki_all_name->name;
    }
    $_SESSION['wiki_categories'] = $wiki_categorys;
    $_SESSION['wiki_all_categories'] = $wiki_all_categorys;
    $_SESSION['wiki_tags'] = $wiki_tags;
    ?>

    <?php get_footer(); ?>
