<style type="text/css">
    .create_wiki_btn {
        margin-bottom: 30px;
    }
    .mulu a{
        display: block;
        border: #9ea7af 1px solid;
        height: 50px;
        padding-left: 30px;
    }
    .mulu .mulu_item{
        display: block;
        border: #9ea7af 1px solid;
        height: 50px;
        padding-left: 50px;
    }
    .wiki_entry_info {
        border: #9ea7af 1px solid;
        padding: 20px 30px;
    }
    .wiki_entry_score {
        border: #9ea7af 1px solid;
        margin-top: 20px;
        padding: 20px 30px;
    }
</style>
<?php
    global $post;
    $entry_title = $post->post_title;
    $entry_content = $post->post_content;
    $wiki_content = $post->post_content;
    $regex = "/(?:<h2>.*<\/h2>)/";
    $match = array();
    $entry_titles = array();
    preg_match_all($regex, $wiki_content, $match);
    for($i=0;$i<count($match[0]);$i++) {
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
    <div class="row create_wiki_btn">
        <div class="col-md-5"><a href="http://localhost/spark_wpv2/?page_id=60&post_id=<?php echo $post->ID ?>"><button type="button" class="btn" style="width: 100%">编辑 wiki</button></a></div>
        <div class="col-md-offset-2 col-md-5"><a href="http://localhost/spark_wpv2/?page_id=58"><button type="button" class="btn" style="width: 100%">创建 wiki</button></a></div>
    </div>
    <div class="list-group mulu">
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
            目录
        </a>
        <?php
            for($i=0; $i<count($entry_titles); $i++) {
                ?>
                <a href="#" class="list-group-item mulu_item"><?php echo $entry_titles[$i]; ?></a>
                <?php
            }
        ?>
    </div>
    <?php
        global $post;
        $admin_url=admin_url('admin-ajax.php');
    ?>
    <script type="text/javascript">
        $(function(){
            var get_post_info = {
                action: "get_post_info",
                post_id: <?php echo $post->ID; ?>
            };
            $.ajax({
                type: "POST",
                url: "<?php echo $admin_url;?>",
                data: get_post_info,
                dataType: "json",
                success: function(data){
                    var categories_show = "";
                    for (var i=0;i<data.categories.length;i++) {
                        categories_show = categories_show + data.categories[i] + "  ";
                    }
                    var tags_show = "";
                    for (var i=0;i<data.tags.length;i++) {
                        tags_show = tags_show + data.tags[i] + "  ";
                    }
                    $("#edit_nums").html("编辑: "+data.edit_author_nums+"人&nbsp;&nbsp;&nbsp;&nbsp;"+data.revision_nums+"个版本");
                    //$("#watch_nums").html("浏览: "+data);
                    $("#update_time").html("更新: "+data.time+"天前");
                    $("#categories_show").html("分类: "+categories_show);
                    $("#tags_show").html("标签: "+tags_show);
                    $("#watch_nums").html("浏览: "+data.watch_count+"次");
                },
                error: function() {
                    alert("数据加载失败!");
                }
            });

        });
    </script>
    <div class="wiki_entry_info">
        <p>创建: <?php the_author(); ?></p>
        <p id="edit_nums"></p>
        <p id="watch_nums"></p>
        <p id="update_time"></p>
        <p id="categories_show"></p>
        <p id="tags_show"></p>
    </div>

    <div class="wiki_entry_score">
        <p>学到好多: 有20人评分</p>
    </div>
    <br><br>
    <div class="wiki_entry_share">
        <p>QQ     WECHAT     WEIBO</p>
    </div>
</div>

