<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2019/3/14
 * Time: 9:23
 */
wp_enqueue_style('fep-style');
wp_enqueue_script('fep-script');
wp_enqueue_media();

$current_post_id = $_GET["post_id"];
$current_type = $_GET["type"];

global $wpdb;
$term_all_names = $wpdb->get_results("select t.`name`, t.`term_id` from $wpdb->terms t left join $wpdb->term_taxonomy tt on tt.term_id = t.term_id where tt.taxonomy = \"wiki_cats\";");
$wiki_all_categorys = array();
foreach ($term_all_names as $wiki_all_name) {
    $wiki_all_categorys[$wiki_all_name->term_id] = $wiki_all_name->name;
}
$admin_url = admin_url('admin-ajax.php');
?>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <div id="fep-new-post">
        <div id="ffff">
            <input type="text" name="wiki_entry_title" class="wiki_entry_title" placeholder="输入词条标题">
            <?php
            wp_editor("", 'wiki_content_editor', $settings = array('textarea_name' => 'post_content', 'textarea_rows' => 25,'teeny'=>true));
            ?>
        </div>
    </div>
</div>

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
       /* var wiki_tags_input = $(".wiki_tags_input").val();
        var wiki_tags = new Array();
        if (wiki_tags_input != null && wiki_tags_input != "") {
            wiki_tags = wiki_tags_input.split(",");
        }
        for (var i = 0; i < wiki_tags.length; i++) {
            wiki_tags[i] = $.trim(wiki_tags[i]);
        }
        $(".wiki_cloud_entry_selected").each(function () {
            wiki_tags.push($(this).text());
        });*/

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
            wiki_tags: ['qa'],
            wiki_visibility:wiki_visibility,
            is_qa:true,
            current_id : <?php echo $current_post_id;?>,
            current_type : '<?php echo $current_type;?>'
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

        $(".update_wiki").on("click", function () {
            create_wiki_entry();
        });
    });
</script>
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <div class="wiki_sidebar_wrap">
        <div class="list-group mulu">
            <p class="wiki_sidebar_title">经验分类</p>
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

        <!--<div class="wiki_tags">
            <p class="wiki_sidebar_title">经验标签</p>
            <input type="text" class="wiki_tags_input" placeholder="多个标签用英文分号隔开"><br>
            <div id="wiki_hot_tags"></div>
        </div>-->

        <div class="create_wiki_btn">
            <a class="update_wiki" onclick="actionPublish()">分享经验</a>
        </div>
    </div>
</div>
<script>
    function actionPublish() {
        document.cookie = "action=publish";
    }
</script>



