<?php
$admin_url=admin_url( 'admin-ajax.php' );
?>
<script>
    function setCSS(flag) {
        if(flag == 1){  //未收藏
            addFavorite();
        }else{
            cancelFavorite(flag);
        }
    }
    function addFavorite() {
        var data={
            action:'addFavorite',
            userID:'<?=$current_user->ID?>',
            postID:'<?=$post_id?>'
        };
        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: data,
            success: function(){
                layer.msg('收藏成功',{time:2000,icon:1});  //layer.msg(content, {options}, end) - 提示框
                var html = "<a onclick=\"setCSS(0)\" class=\"btn btn-default\" id=\"btn-add-favorite\">"+
                    "<span class=\"glyphicon glyphicon-star\"></span>已收藏"+"</a>";
                $("#addFavorite").html(html);
//                $("#btn-add-favorite").css({"color":"white",
//                    "background-color": "#fe642d",
//                    "border-color": "transparent"});
            },
            error:function () {
                alert("收藏失败");
            }
        });
    }
    function cancelFavorite() {
        var data={
            action:'cancelFavorite',
            userID:'<?=$current_user->ID?>',
            postID:'<?=$post_id?>'
        };
        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: data,
            success: function(){
                layer.msg('已取消',{time:2000,icon:1});  //layer.msg(content, {options}, end) - 提示框
                var html = "<a onclick=\"setCSS(1)\" class=\"btn btn-default\" id=\"btn-add-favorite\">"+
                    "<span class=\"glyphicon glyphicon-star-empty\"></span>收藏"+"</a>";
                $("#addFavorite").html(html);
                //更改样式
//                $("#btn-add-favorite").css({ "color":"#fe642d",
//                    "background-color": "transparent",
//                    "border-color": "#fe642d"});
            },
            error:function () {
                alert("error");
            }
        });
    }
</script>
<div class="container" style="margin-top: 10px;flex: 1 0 auto">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
            <!--引入动态模板-->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
                <div style="display: inline-block">
                    <h2><b><?php the_title(); ?></b></h2>
                </div>
                <?php if( !ifFavorite($current_user->ID,$post_id) ){ //未收藏
                    $flag = 1;
                    $avalue = "<span class=\"glyphicon glyphicon-star-empty\"></span>收藏";
                } else{
                    $flag = 0;
                    $avalue = "<span class=\"glyphicon glyphicon-star\"></span>已收藏";
                } ?>
                <div id="addFavorite">
                    <a onclick="setCSS(<?=$flag?>)" class="btn btn-default" id="btn-add-favorite">
                        <?php echo $avalue; ?>
                    </a>
                </div>
                <hr>
                <div id="wiki_content">
                    <?php the_content(); //keywordHighlight_update(); ?>
                </div>
                <hr>
                <?php comments_template(); ?>
            <?php endwhile;?>
            <?php else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

            <?php endif; ?>

        </div>
        <div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<div class="side-tool" id="side-tool-project">
    <ul>
        <li data-placement="left" data-toggle="tooltip" data-original-title="回到顶部"><a href="#" class="">顶部</a></li>
        <li data-placement="left" data-toggle="tooltip" data-original-title="点赞吐槽"><a href="#comments" class="">评论</a></li>
        <?php
        $current_page_id = get_the_ID();
        $current_page_type = get_post_type(get_the_ID());?>
        <?php if(is_user_logged_in()){?>
            <li data-placement="left" data-toggle="tooltip" data-original-title="不懂就问"><a onclick="addLayer()" id="ask_link">提问</a></li>
        <?php }else{ ?>
            <li data-placement="left" data-toggle="tooltip" data-original-title="不懂就问"><a href="<?php echo wp_login_url( get_permalink() ); ?>">提问</a></li>
        <?php } ?>

    </ul>
</div>
<div class="side-tool" id="m-side-tool-project">
    <ul>
        <li><a href="<?php echo get_permalink( get_page_by_title( '编辑wiki' )); ?>&post_id=<?php echo $post->ID ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
        <li><a href="<?php echo get_permalink( get_page_by_title( '创建wiki' )); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
    </ul>
</div>
<div class="bottom-button" id="faq-button">
    <button  type="button" class="btn btn-warning  btn-lg" data-toggle="tooltip" title="看看大家遇到的问题和解决方法"><a href="https://www.oursparkspace.cn/?yada_wiki=1539591196"  target="_blank">精品FAQ</a></button>
</div>
<?php
global $wpdb;
$post_id = get_the_ID();
$term_names = $wpdb->get_results("select t.`name` from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=".$post_id." and tt.taxonomy=\"wiki_cats\"");
$wiki_categorys = array();
foreach($term_names as $term_name) {
    $wiki_categorys[] = $term_name->name;
}

$tag_names = $wpdb->get_results("select t.`name` from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=".$post_id." and tt.taxonomy=\"wiki_tags\"");
$wiki_tags = array();
foreach($tag_names as $tag_name) {
    $wiki_tags[] = $tag_name->name;
}

$term_all_names = $wpdb->get_results("select t.`name`, t.`term_id` from $wpdb->terms t left join $wpdb->term_taxonomy tt on tt.term_id = t.term_id where tt.taxonomy = \"wiki_cats\";");
$wiki_all_categorys = array();
foreach($term_all_names as $wiki_all_name) {
    $wiki_all_categorys[$wiki_all_name->term_id] = $wiki_all_name->name;
}
$_SESSION['wiki_categories'] = $wiki_categorys;
$_SESSION['wiki_all_categories'] = $wiki_all_categorys;
$_SESSION['wiki_tags'] = $wiki_tags;
?>

<?php get_footer(); ?>
<script>
    $(function () { $("[data-toggle='tooltip']").tooltip({}); });
    function addLayer() {
        layer.open({
            type : 2,
            title: "提问", //不显示title   //'layer iframe',
            content: '<?php echo site_url().get_page_address('ask_tiny')."&post_id=".$current_page_id."&type=".$current_page_type;?>', //iframe的url
            area: ['70%', '80%'],
            closeBtn:1,            //是0为不显示叉叉 可选1,2
            shadeClose: true,    //点击其他shade区域关闭窗口
            shade: 0.5,   //透明度
            end: function () {
                location.reload();
            }
        });
    }
</script>
