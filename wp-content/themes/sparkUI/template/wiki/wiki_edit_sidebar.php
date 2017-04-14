<style type="text/css">
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
    .wiki_tags_input{
        width: 100%;
    }
    .create_wiki_btn {
        margin-top: 30px;
    }
    .wiki_cloud_entry {
        display: inline-block;
        margin-right: 20px;
    }
    .wiki_cloud_entry_selected {
        background: #da4f49;
    }

</style>
<?php
    global $post;
?>
<?php
$admin_url=admin_url('admin-ajax.php');
?>
<script type="text/javascript">

    function update_wiki_entry() {
        //var entry_content = $(document.getElementById('wiki_content_editor_ifr').contentWindow.document.body).html();
        var entry_content = $("#wiki_content_editor").val();
        var entry_title = "<?php echo $_SESSION['post_title']; ?>";
        if(entry_title == null || $.trim(entry_title) == "") {
            alert("词条标题或内容不能为空!");
            return;
        }
        var wiki_categories = new Array();
        $('input[name="wiki_category"]:checked').each(function(){
            wiki_categories.push($(this).val());
        });
        var wiki_tags_input = $(".wiki_tags_input").val();
        var wiki_tags = new Array();
        if(wiki_tags_input != null && wiki_tags_input != "") {
            wiki_tags = wiki_tags_input.split(";");
        }
        for(var i=0; i<wiki_tags.length; i++) {
            wiki_tags[i] = $.trim(wiki_tags[i]);
        }
        $(".wiki_cloud_entry_selected").each(function() {
            wiki_tags.push($(this).text());
        });

        var update_content = {
            action: "update_wiki_entry",
            entry_title : entry_title,
            entry_content: entry_content,
            wiki_categories: wiki_categories,
            wiki_tags: wiki_tags,
            post_id: <?php echo $post->ID; ?>
        };

        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: update_content,
            dataType: "json",
            success: function(data){
                window.location.href = "/spark_wpv2/?yada_wiki=" + "<?php echo $_SESSION['post_name']; ?>";
            },
            error: function() {
                alert("wiki发布失败!");
            }
        });
    }

    $(function(){

        $(".wiki_cloud_entry").on("click", function(){
            $(this).toggleClass("wiki_cloud_entry_selected");
        });

        $(".update_wiki").on("click", function() {
            update_wiki_entry();
        });

        var wiki_entry_categories_html = $.trim($("#wiki_entry_categories").html());
        if(wiki_entry_categories_html == "") {
            $("#wiki_entry_categories").hide();
        }

        var get_tags_cloud = {
            action: "get_wiki_hot_tags",
        };
        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: get_tags_cloud,
            dataType: "json",
            success: function(data){
                for (var i=0;i<data.hot_tags.length;i++) {
                    $("#wiki_hot_tags").append("<span onclick=\"$(this).toggleClass(\'wiki_cloud_entry_selected\');\" id=\"wiki_cloud_entry\" class=\"wiki_cloud_entry\" value=\""+data.hot_tags[i]+"\">"+data.hot_tags[i]+"</span>");
                }
            },
            error: function() {
                alert("数据加载失败!");
            }
        });

        $(".update_wiki").on("click", function() {
            create_wiki_entry();
        });
    });
</script>
<div class="wiki_sidebar_wrap">
    <div class="list-group mulu">
        <a href="#" class="list-group-item">
            <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>
            目录
        </a>
        <?php
        for($i=0; $i<count($_SESSION["entry_mulu"]); $i++) {
            ?>
            <a href="#" class="list-group-item mulu_item"><?php echo $_SESSION["entry_mulu"][$i]; ?></a>
            <?php
        }
        ?>
    </div>

    <div class="list-group mulu">
        <a href="#" class="list-group-item" id="wiki_entry_categories">
            <?php
                foreach ($_SESSION['wiki_categories'] as $wiki_category) {
                    echo "<b>" . $wiki_category . "</b>" . "&nbsp;&nbsp;&nbsp;";
                }
            ?>
        </a>
        <?php
        foreach($_SESSION['wiki_all_categories'] as $category_term_id => $category_name) {
            ?>
            <a href="#" class="list-group-item mulu_item"><input name="wiki_category" type="checkbox" value="<?php echo $category_term_id; ?>">&nbsp;&nbsp;&nbsp;<?php echo $category_name; ?></a>
            <?php
        }
        ?>
    </div>

    <div class="wiki_tags">
        <b>wiki标签</b><br>
        <input type="text" class="wiki_tags_input" placeholder="多个标签用分号隔开"><br>
        <div id="wiki_hot_tags"></div>
    </div>

    <div class="create_wiki_btn">
        <button type="button" class="btn update_wiki" style="width: 100%">发布 wiki</button>
    </div>
</div>
