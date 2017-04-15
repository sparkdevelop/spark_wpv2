<style type="text/css">
    .wiki-handle {
        margin-bottom: 10px;
        padding-left: 16px;
    }
    .edit-wiki{
        width:45%;
        height: 48px;
        background-color: #fe642d;
        -moz-box-shadow: 5px 5px 5px #ffd8cc;
        box-shadow: 5px 5px 5px #ffd8cc;
        text-align: center;
        font-size: large;
        margin: 10px 15px 15px 0px;
        border-radius: 5px;
        float: left;
    }
    .edit-wiki:hover{
        box-shadow: none;
    }
    .edit-wiki>a,.edit-wiki>a:hover{
        display: block;
        height: 100%;
        line-height: 48px;
        width: 100%;
        color: white;
        text-decoration: none;
    }
    .create-wiki{
        width:45%;
        height: 48px;
        -moz-box-shadow: 3px 3px 3px #ffe8e0;
        box-shadow: 5px 5px 5px #ffe8e0;
        text-align: center;
        font-size: large;
        margin: 10px 0px 15px 0px;
        border:1px solid #fe642d;
        border-radius: 5px;
        float: left;
    }
    .create-wiki:hover{
        box-shadow: none;
    }
    .create-wiki>a,.create-wiki>a:hover{
        display: block;
        height: 100%;
        line-height: 48px;
        width: 100%;
        color: #fe642d;
        text-decoration: none;
    }

    .wiki_entry_info {
        /*border:  1px solid #eee;*/
        border-top:1px solid #eee;
        border-bottom: 1px solid #eee;
        padding: 20px 20px 10px 20px;
    }
    .wiki_entry_info p{
        color: #333;
        font-size: 14px;
    }
    .wiki_entry_score {
        border: 1px solid #eee;
        margin-top: 30px;
        padding: 20px 20px 10px 20px;
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
    <div class="row wiki-handle">
        <div class="edit-wiki"><a href="http://localhost/spark_wpv2/?page_id=60&post_id=<?php echo $post->ID ?>">编辑 wiki</a></div>
        <div class="create-wiki"><a href="http://localhost/spark_wpv2/?page_id=58">创建 wiki</a></div>
    </div>
<!--    <div class="list-group mulu">-->
<!--        <a href="#" class="list-group-item">-->
<!--            <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>-->
<!--            目录-->
<!--        </a>-->
<!--        --><?php
//            for($i=0; $i<count($entry_titles); $i++) {
//                ?>
<!--                <a href="#" class="list-group-item mulu_item">--><?php //echo $entry_titles[$i]; ?><!--</a>-->
<!--                --><?php
//            }
//        ?>
<!--    </div>-->
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

<!--    <div class="wiki_entry_score">-->
<!--        <p>学到好多: 有20人评分</p>-->
<!--    </div>-->
<!--    <div class="wiki_entry_share">-->
<!--        <p>QQ     WECHAT     WEIBO</p>-->
<!--    </div>-->
</div>

