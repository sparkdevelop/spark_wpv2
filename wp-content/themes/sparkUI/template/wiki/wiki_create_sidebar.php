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
$admin_url=admin_url('admin-ajax.php');
?>
<script type="text/javascript">

    function create_wiki_entry() {
        //var entry_content = $(document.getElementById('wiki_content_editor_ifr').contentWindow.document.body).html();
        var entry_content = $("#wiki_content_editor").val();
        var entry_title = $(".wiki_entry_title").val();
        if(entry_title == null || $.trim(entry_title) == "") {
            alert("词条标题不能为空!");
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

        var create_content = {
            action: "create_wiki_entry",
            entry_title : entry_title,
            entry_content: entry_content,
            wiki_categories: wiki_categories,
            wiki_tags: wiki_tags,
        };

        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: create_content,
            dataType: "json",
            beforeSend: function() {
                //$(document.getElementById('wiki_content_editor_ifr').contentWindow.document.body).html("");
                var entry_content = $("#wiki_content_editor").val("");
                $(".wiki_entry_title").val("");
                $('input:checkbox').each(function () {
                    $(this).attr('checked',false);
                });
                var wiki_tags_input = $(".wiki_tags_input").val("");
            },
            success: function(data){
                window.location.href = "/spark_wpv2/?yada_wiki=" + data;
            },
            error: function() {
                alert("wiki发布失败!");
            }
        });
    }

    $(function(){

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
    <p><b>wiki分类</b></p>
    <div class="list-group mulu">
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
