<?php
global $wpdb;
$term_all_names = $wpdb->get_results("select t.`name`, t.`term_id` from $wpdb->terms t left join $wpdb->term_taxonomy tt on tt.term_id = t.term_id where tt.taxonomy = \"wiki_cats\";");
$wiki_all_categorys = array();
foreach ($term_all_names as $wiki_all_name) {
    $wiki_all_categorys[$wiki_all_name->term_id] = $wiki_all_name->name;
}
$admin_url = admin_url('admin-ajax.php');
?>
<script type="text/javascript">

    function create_wiki_entry() {
        //关闭保存时离开页面提示框
        $(window).unbind('beforeunload');
        window.onbeforeunload = null;

        var entry_content = $(document.getElementById('wiki_content_editor_ifr').contentWindow.document.body).html();
        //var entry_content = $(document.getElementById('wiki_content_editor_ifr').contentWindow.document.body).html();
        //var entry_content = $("#wiki_content_editor").val();
        var entry_title = $(".wiki_entry_title").val();
        if (entry_title == null || $.trim(entry_title) == "") {
            alert("词条标题不能为空!");
            return;
        }
        var wiki_categories = new Array();
        $('input[name="wiki_category"]:checked').each(function () {
            wiki_categories.push($(this).val());
        });
        var wiki_tags_input = $(".wiki_tags_input").val();
        var wiki_tags = new Array();
        if (wiki_tags_input != null && wiki_tags_input != "") {
            wiki_tags = wiki_tags_input.split(",");
        }
        for (var i = 0; i < wiki_tags.length; i++) {
            wiki_tags[i] = $.trim(wiki_tags[i]);
        }
        $(".wiki_cloud_entry_selected").each(function () {
            wiki_tags.push($(this).text());
        });

        var create_content = {
            action: "create_wiki_entry",
            entry_title: entry_title,
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
            success: function (data) {
                window.location.replace("<?php echo site_url();?>/?yada_wiki=" + data);
            },
            error: function () {
                alert("wiki发布失败!");
            }
        });
    }

    $(function () {

        var get_tags_cloud = {
            action: "get_wiki_hot_tags",
        };
        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: get_tags_cloud,
            dataType: "json",
            success: function (data) {
                for (var i = 0; i < data.hot_tags.length; i++) {
                    $("#wiki_hot_tags").append("<span onclick=\"$(this).toggleClass(\'wiki_cloud_entry_selected\');\" id=\"wiki_cloud_entry\" class=\"wiki_cloud_entry\" value=\"" + data.hot_tags[i] + "\">" + data.hot_tags[i] + "</span>");
                }
            },
            error: function () {
                alert("数据加载失败!");
            }
        });

        $(".update_wiki").on("click", function () {
            create_wiki_entry();
        });
    });
</script>
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <div class="wiki_sidebar_wrap">
        <div class="list-group mulu">
            <p class="wiki_sidebar_title">wiki分类</p>
            <?php
            foreach ($wiki_all_categorys as $category_term_id => $category_name) {
                ?>
                <a href="#" class="list-group-item mulu_item"><input name="wiki_category" type="checkbox"
                                                                     value="<?php echo $category_term_id; ?>">&nbsp;&nbsp;&nbsp;<?php echo $category_name; ?>
                </a>
                <?php
            }
            ?>
        </div>

        <div class="wiki_tags">
            <p class="wiki_sidebar_title">wiki标签</p>
            <input type="text" class="wiki_tags_input" placeholder="多个标签用分号隔开"><br>
            <div id="wiki_hot_tags"></div>
        </div>
<!--        添加可见性-->
        <div class="wiki_permission">
            <p class="wiki_sidebar_title">谁可以看</p>
            <input type="radio" id="shareAll" name="visibility" value="all" style="display: inline-block" checked/><span> 所有人</span>&nbsp;&nbsp;
            <input type="radio" id="sharePart" name="visibility" value="part" style="display: inline-block;margin-left: 30px"/><span> 部分可见</span>&nbsp;&nbsp;
        </div>
<!--        绑定事件-->
        <script>
            $(function () {
                showAddon();
                $("input[name=gjoin]").on('change', function () {
                    showAddon();
                });
                function showAddon() {
                    switch ($("input[name=gjoin]:checked").attr("id")) {   //根据id判断
                        case "freejoin":
                            $("#gjoin-addon").html("<p>注:用户自由加入,无需审核</p>");
                            break;
                        case "verifyjoin":
                            var html = '<div style="background-color: #f2f2f2;padding-top: 10px">' +
                                '<div id="insert-text">' +
                                '<p style="margin: 10px 20px; margin-top: 0px">设置需要用户填写的验证字段,如:真实姓名、学号,该信息将在小组内公开</p>' +
                                '<input type="text" class="form-control" name="g-ver-info[]" id="g-ver-info" style="margin-bottom:10px;margin-left:10px;display:inline;width: 85%" placeholder="真实姓名" value="真实姓名"/>' +
                                '<input type="text" class="form-control" name="g-ver-info[]" id="g-ver-info" style="margin-bottom:10px;margin-left:10px;display:inline;width: 85%" placeholder="学号" value="学号"/>' +
                                '<input type="button" id="addNewFieldBtn" value="+" style="margin-left:10px;display:inline">' +
                                '</div>' +
                                '</div>';
                            $("#gjoin-addon").html(html);
                            break;
                        case "verify":
                            $("#gjoin-addon").html("<p>注:注册通过即可加入,无需填写验证信息</p>");
                            break;
                    }
                }

                $(document).on('click', '#addNewFieldBtn', function () {
                    $("#addNewFieldBtn").hide();
                    var input = '<input type="text" class="form-control" name="g-ver-info[]" id="g-ver-info" style="margin-bottom:10px;margin-left:10px;display:inline;width: 85%" placeholder="" value=""/>' +
                        '<input type="button" id="addNewFieldBtn" value="+" style="margin-left:10px;display:inline">';
                    $("#insert-text").append(input);
                })
            })
        </script>












        <div class="create_wiki_btn">
            <a class="update_wiki" onclick="actionPublish()">发布 wiki</a>
        </div>
    </div>
</div>


<div class="m-create-wiki-box">
    <div class="list-group mulu">
        <p class="wiki_sidebar_title">wiki分类</p>
        <?php
        foreach ($wiki_all_categorys as $category_term_id => $category_name) {
            ?>
            <a href="#" class="list-group-item mulu_item">
                <input name="wiki_category" type="checkbox" value="<?php echo $category_term_id; ?>">&nbsp;&nbsp;&nbsp;
                <?php echo $category_name; ?>
            </a>
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

