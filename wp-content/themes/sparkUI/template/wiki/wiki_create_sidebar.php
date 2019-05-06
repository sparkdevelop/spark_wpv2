<?php
global $wpdb;
$current_user = wp_get_current_user();
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

        //设置可见性 by cherie
        var wiki_visibility=[];
        var visibility = $('input[name="visibility"]:checked').val();
        if (visibility=='all'){
            wiki_visibility.push('all')
        }else{
            var part = $('input[name="sharePart"]:checked');
            if(part.length==0){
                wiki_visibility.push('all')
            } else{
                part.each(function () {
                    wiki_visibility.push($(this).val());
                });
            }
        }


        var create_content = {
            action: "create_wiki_entry",
            entry_title: entry_title,
            entry_content: entry_content,
            wiki_categories: wiki_categories,
            wiki_tags: wiki_tags,
            wiki_visibility:wiki_visibility
        };

        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            async: false,
            data: create_content,
            dataType: "json",
            success: function (data) {
                //console.log(data);
                window.location.replace("<?php echo site_url();?>/?yada_wiki=" + data);
            },
            error: function (e,xhr,opt) {
                alert("Error requesting " + opt + ": " + xhr);
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
            error: function (e,xhr,opt) {
                console.log(e);
                console.log(xhr);
                console.log(opt);
                alert(e+ "Error requesting " + opt + ": " + xhr);
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
            <div id="permission-addon"></div>
        </div>
<!--        绑定事件-->
        <script>
            $(function () {
                showAddon();
                $("input[name=visibility]").on('change', function () {
                    showAddon();
                });
                function showAddon() {
                    switch ($("input[name=visibility]:checked").attr("id")) {   //根据id判断
                        case "shareAll":
                            $("#permission-addon").html("<span style='color: red;'>*</span><p style='margin: 10px 16px;display: inline-block'>所有用户可见</p>");
                            break;
                        case "sharePart":
                            var html = '<div class="divline"></div>'+
                            '<div><input type="checkbox" name="sharePart" value="myrole" style="margin-top: 10px"/><span> 和我同一角色的</span></div>'+
                            '<div><input type="checkbox" name="sharePart" value="myschool"/><span> 和我同一学校的</span></div>'+
                            '<div><input type="checkbox" name="sharePart" value="private"/><span> 只有我可见</span></div>'   ;
                            $("#permission-addon").html(html);
                            break;
                    }
                }
            })
        </script>

        <div class="create_wiki_btn">
            <a class="update_wiki" onclick="actionPublish()">发布wiki</a>
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

        var json = [];
        var row1 = {};
        var row2 = {};
        var row3 = {};
        var row4 = {};
        row1.userid=  <?php echo $current_user->ID;?>;
        row1.username="<?php echo $current_user->data->user_login;?>";
        row1.usersno="<?php echo get_user_meta( $current_user->ID, 'Sno');?>";
        row1.university="<?php echo get_user_meta( $current_user->ID, 'University');?>";
        row2.content = document.getElementById("wikititle").value;
        row2.activity="publish";
        row2.time=getNowFormatDate();
        row2.url=null;
        row3.otherid=null;
        row3.othercontent=null;
        row4.source="sparkspace";
        row4.userinfo=row1;
        row4.scene=row2;
        row4.otheruserinfo=row3

        // row1.likenum="";//被点赞数
        // row1.likename="";  //点赞项目名称

        json.push(row4);


        alert(JSON.stringify(json));
        document.cookie = "action=publish";
    }
    function getNowFormatDate() {//获取当前时间

        var date = new Date();

        var seperator1 = "-";

        var seperator2 = ":";

        var month = date.getMonth() + 1<10? "0"+(date.getMonth() + 1):date.getMonth() + 1;

        var strDate = date.getDate()<10? "0" + date.getDate():date.getDate();

        var currentdate = date.getFullYear() + seperator1  + month  + seperator1  + strDate

            + " "  + date.getHours()  + seperator2  + date.getMinutes()

            + seperator2 + date.getSeconds();

        return currentdate;

    }
</script>

