<style type="text/css">
    .list-group{
        margin:10px 0 20px 0;
    }


</style>
<?php
    global $post;
?>
<?php
global $wpdb;
$post_id = $_GET['post_id'];
$post_title_result = $wpdb->get_results("select post_title, post_name from $wpdb->posts where ID = ".$post_id);
$post_title = "";
$post_name = "";
foreach($post_title_result as $item) {
    $post_title = $item->post_title; 
    $post_name = $item->post_name;
}
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
?>

<?php
$admin_url=admin_url('admin-ajax.php');
?>
<script type="text/javascript">

    function update_wiki_entry() {
        entry_content = $(document.getElementById('wiki_content_editor_ifr').contentWindow.document.body).html();
        //var entry_content = $("#wiki_content_editor").val();
        var entry_title = "<?php echo $post_title; ?>";
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
            async: false,
	    data: update_content,
            dataType: "json",
            success: function(data){
                var post_name = "<?php echo $post_name; ?>";
                window.open("/?yada_wiki="+post_name);
		//window.location.href = "/?yada_wiki=" + post_name;
                //var form = document.createElement('form');
                //form.action = "/?yada_wiki=" + post_name;
                //form.target = '_blank';
                //form.method = 'POST';
                //document.body.appendChild(form);
                //form.submit();
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
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
<div class="wiki_sidebar_wrap">
<!--    <div class="list-group mulu">-->
<!--        <a href="#" class="list-group-item">-->
<!--            <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>-->
<!--            目录-->
<!--        </a>-->
<!--        --><?php
//        for($i=0; $i<count($_SESSION["entry_mulu"]); $i++) {
//            ?>
<!--            <a href="#" class="list-group-item mulu_item">--><?php //echo $_SESSION["entry_mulu"][$i]; ?><!--</a>-->
<!--            --><?php
//        }
//        ?>
<!--    </div>-->

    <div class="list-group mulu">
        <p class="wiki_sidebar_title">选择wiki分类</p>
        <a href="#" class="list-group-item" id="wiki_entry_categories">
            <?php
                foreach ($wiki_categorys as $wiki_category) {
                    echo "<b>" . $wiki_category . "</b>" . "&nbsp;&nbsp;&nbsp;";
                }
            ?>
        </a>
        <?php
        foreach($_SESSION['wiki_all_categories'] as $category_term_id => $category_name) {
            ?>
            <a href="#" class="list-group-item mulu_item"><input name="wiki_category" type="checkbox" <?php if(in_array($category_name, $wiki_categorys)) echo "checked=\"checked\" "; ?>value="<?php echo $category_term_id; ?>">&nbsp;&nbsp;&nbsp;<?php echo $category_name; ?></a>
            <?php
        }
        ?>
    </div>

    <div class="wiki_tags">
        <p class="wiki_sidebar_title">选择wiki标签</p>
        <input type="text" class="wiki_tags_input" value="<?php for($i=0;$i<count($wiki_tags);$i++){echo $wiki_tags[$i];if($i<count($wiki_tags)-1){echo ",";}} ?>" placeholder="多个标签用分号隔开"><br>
        <div id="wiki_hot_tags"></div>
    </div>

    <div class="create_wiki_btn">
        <a class="update_wiki">保存 wiki</a>
    </div>
</div>
</div>
