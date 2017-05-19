<style type="text/css">

</style>
<?php
$admin_url=admin_url('admin-ajax.php');
?>
<?php
global $wpdb;
$term_all_names = $wpdb->get_results("select t.`name`, t.`term_id` from $wpdb->terms t left join $wpdb->term_taxonomy tt on tt.term_id = t.term_id where tt.taxonomy = \"wiki_cats\";");
$wiki_all_categorys = array();
foreach($term_all_names as $wiki_all_name) {
    $wiki_all_categorys[$wiki_all_name->term_id] = $wiki_all_name->name;
}
?>
<script type="text/javascript">

    function create_wiki_entry() {
        entry_content = $(document.getElementById('wiki_content_editor_ifr').contentWindow.document.body).html();
        //var entry_content = $(document.getElementById('wiki_content_editor_ifr').contentWindow.document.body).html();
        //var entry_content = $("#wiki_content_editor").val();
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
            wiki_tags = wiki_tags_input.split(",");
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
            async: false,
	    data: create_content,
            dataType: "json",
            success: function(data){
                //window.location.href = "<?php //echo site_url();?>/?yada_wiki=" + data;
                //window.open("/spark_wpv2/?yada_wiki=" + data, '_self');
                //var form = document.createElement('form');
                //form.action = "/?yada_wiki=" + data;
                //form.target = '_blank';
                //form.method = 'POST';
                //document.body.appendChild(form);
                //form.submit();
                window.open("/?yada_wiki="+data);
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
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
<div class="wiki_sidebar_wrap">
    <div class="list-group mulu">
        <p class="wiki_sidebar_title">wiki分类</p>
        <?php
        foreach($wiki_all_categorys as $category_term_id => $category_name) {
            ?>
            <a href="#" class="list-group-item mulu_item"><input name="wiki_category" type="checkbox" value="<?php echo $category_term_id; ?>">&nbsp;&nbsp;&nbsp;<?php echo $category_name; ?></a>
            <?php
        }
        ?>
    </div>

    <div class="wiki_tags">
        <p class="wiki_sidebar_title">wiki标签</p>
        <input type="text" class="wiki_tags_input" placeholder="多个标签用分号隔开"><br>
        <div id="wiki_hot_tags"></div>
    </div>

    <div class="create_wiki_btn">
        <a class="update_wiki" onclick="actionPublish()">发布 wiki</a>
    </div>
</div>
</div>


    <div class="m-create-wiki-box">
        <div class="list-group mulu">
            <p class="wiki_sidebar_title">wiki分类</p>
            <?php
            foreach($wiki_all_categorys as $category_term_id => $category_name) {
                ?>
                <a href="#" class="list-group-item mulu_item"><input name="wiki_category" type="checkbox" value="<?php echo $category_term_id; ?>">&nbsp;&nbsp;&nbsp;<?php echo $category_name; ?></a>
                <?php
            }
            ?>
        </div>

        <div class="wiki_tags">
            <p class="wiki_sidebar_title">wiki标签</p>
            <input type="text" class="wiki_tags_input" placeholder="多个标签用分号隔开"><br>
            <div id="wiki_hot_tags"></div>
        </div>

        <div class="create_wiki_btn">
            <a class="update_wiki" onclick="actionPublish()">发布 wiki</a>
        </div>
    </div>
<script>
    function actionPublish() {
        document.cookie = "action=publish";
    }
</script>

