<?php
$admin_url=admin_url( 'admin-ajax.php' );
$user_id = get_current_user_id();
$post_id = get_the_ID();
$hasLearn = hasLearn($user_id, $post_id);
$num = learned_num($post_id);
$related_info = qaComeFrom($post_id);
if($related_info['post_type']=="post"){
    $post_from = "项目";
}elseif($related_info['post_type']=="yada_wiki"){
    $post_from = "wiki";
}else{
    $post_from="";
}
?>
<div class="container" style="margin-top: 10px;flex: 1 0 auto">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
            <!--引入动态模板-->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
                <div style="display: inline-block">
                    <h2><b><?php the_title(); ?></b></h2>
                    <!--来自项目or wiki-->
                    <?php
                    if($related_info['post_type'] != ""){?>
                        <div id="question_from" style="display:block;">
                <span>来自<?php echo $post_from?>:
                    <a href ="<?php echo get_permalink($related_info['id']);?>" target="_blank">
                        <?php echo get_the_title($related_info['id']);?>
                    </a>
                </span>
                        </div>
                    <?php } ?>
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

                <div class="like-area-wrapper" id="web_header_like_area">
                    <!-- 喜欢的 wrapper -->
                    <div class="count-like-wrapper rate-button" id="rate-button">
                        <!-- 计数的 block -->
                        <div class="count-like-block web-count-like-block" id="count-button">
                            <div class="like-block count-like-inner">
                                <span class="count-like" id="like_count"><?= $num;?></span>
                            </div>
                        </div>
                        <!-- 喜欢的 block -->
                        <div class="rate-like-block web-rate-like-block">
                            <div class="like-block">
                                <img class="rate-like-icon" src="<?php bloginfo("template_url") ?>/img/good-orange.png" id="like_pic"/>
                                <span class="like-words"  id="like">学会了</span>
                            </div>
                        </div>
                    </div>
                    <!-- 一般般的 block -->
                    <div class="rate-normal-block web-rate-normal-block rate-button" id="dislike-button">
                        <div class="like-block" >
                            <img class="rate-normal-icon" src="<?php bloginfo("template_url") ?>/img/sad-black.png" id="dislike_pic"/>
                            <span class="dislike-words"  id="dislike">没学会</span>
                        </div>
                    </div>
                </div>
            

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
            <li data-placement="left" data-toggle="tooltip" data-original-title="经验分享"><a onclick="addLayer2()" id="ask_link">分享</a></li>
        <?php }else{ ?>
            <li data-placement="left" data-toggle="tooltip" data-original-title="不懂就问"><a href="<?php echo wp_login_url( get_permalink() ); ?>">提问</a></li>
            <li data-placement="left" data-toggle="tooltip" data-original-title="经验分享"><a href="<?php echo wp_login_url( get_permalink() ); ?>">分享</a></li>
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
    $(function () {
        var num = document.getElementById("like_count");
        var background = document.getElementById("rate-button");
        var like_button = document.getElementById("like");
        var like_span = $("#like");
        var dislike = document.getElementById("dislike-button");
        var dislike_character = document.getElementById("dislike");
        var dislike_span = $("#dislike");
        var like_pic = document.getElementById("like_pic");
        var dislike_pic = document.getElementById("dislike_pic");
        var learned = <?=$hasLearn?>;
        switch (learned){
            case 0:
                background.style.backgroundColor = "orange";
                num.style.color = "white";
                like_button.style.color = "white";
                like_pic.src = "<?php bloginfo('template_url') ?>/img/good-white.png";
                dislike_span.attr("onclick","like(1);");
                background.style.cursor = "default";
                break;
            case 1:
                dislike.style.backgroundColor = "#8a8a8a";
                dislike_character.style.color = "white";
                dislike_pic.src = "<?php bloginfo('template_url') ?>/img/sad-white.png";
                like_span.attr("onclick","like(0);");
                dislike.style.cursor = "default";
                break;
            case 2:
                like_span.attr("onclick","like(0);");
                dislike_span.attr("onclick","like(1);");
                break;
        }

    });
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
    function addLayer2() {
        layer.open({
            type : 2,
            title: "经验分享", //不显示title   //'layer iframe',
            content: '<?php echo site_url().get_page_address('qa_create')."&post_id=".$current_page_id."&type=".$current_page_type;?>', //iframe的url
            area: ['70%', '80%'],
            closeBtn:1,            //是0为不显示叉叉 可选1,2
            shadeClose: true,    //点击其他shade区域关闭窗口
            shade: 0.5,   //透明度
            end: function () {
                location.reload();
            }
        });
    }
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
    function like(like_flag){
        var num = document.getElementById("like_count");
        var background = document.getElementById("rate-button");
        var like_button = document.getElementById("like");
        var dislike = document.getElementById("dislike-button");
        var dislike_character = document.getElementById("dislike");
        var like_pic = document.getElementById("like_pic");
        var dislike_pic = document.getElementById("dislike_pic");
        var data={
            action:'addLearn',
            user_id:'<?=$user_id?>',
            post_id:'<?=$post_id?>',
            learned:like_flag
        };
        if(like_flag==0){
            $.ajax({
                type: "POST",
                url: "<?php echo $admin_url;?>",
                data: data,
                success: function(res){
                    console.log(res);
                    num.innerHTML = parseInt(num.innerHTML) + 1;
                    background.style.backgroundColor = "orange";
                    num.style.color = "white";
                    like_button.style.color = "white";
                    dislike.style.backgroundColor = "#F6F6F6";
                    dislike_character.style.color = "black";
                    like_pic.src = "<?php bloginfo('template_url') ?>/img/good-white.png";
                    dislike_pic.src = "<?php bloginfo('template_url') ?>/img/sad-black.png";
                    $("#like").removeAttr('onclick');
                    $("#dislike").attr("onclick","like(1);");
                    background.style.cursor = "default";
                    dislike.style.cursor = "pointer";
                },
                error:function () {
                    layer.msg('选择失败，请重试',{time:2000,icon:1});
                }
            });
        }
        else{
            $.ajax({
                type: "POST",
                url: "<?php echo $admin_url;?>",
                data: data,
                success: function(){
                    if(background.style.backgroundColor == "orange"){
                        num.innerHTML = parseInt(num.innerHTML) - 1;
                    }
                    dislike_pic.src = "<?php bloginfo('template_url') ?>/img/sad-white.png";
                    background.style.backgroundColor = "#F6F6F6";
                    num.style.color = "orange";
                    like_button.style.color = "orange";
                    dislike.style.backgroundColor = "#8a8a8a";
                    dislike_character.style.color = "white";
                    like_pic.src = "<?php bloginfo('template_url') ?>/img/good-orange.png";
                    $("#dislike").removeAttr('onclick');
                    $("#like").attr("onclick","like(0);");
                    dislike.style.cursor = "default";
                    background.style.cursor = "pointer";
                },
                error:function () {
                    layer.msg('选择失败，请重试',{time:2000,icon:1});
                }
            });
        }

    }

</script>
