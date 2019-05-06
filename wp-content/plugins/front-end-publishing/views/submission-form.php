<?php
wp_enqueue_style('fep-style');
wp_enqueue_script('fep-script');
wp_enqueue_media();

$current_user = wp_get_current_user();
$post = false;
$post_id = -1;
$featured_img_html = '';
if (isset($_GET['fep_id']) && isset($_GET['fep_action']) && $_GET['fep_action'] == 'edit') {
    $post_id = $_GET['fep_id'];
    $p = get_post($post_id, 'ARRAY_A');
    if ($p['post_author'] != $current_user->ID) return __("你没有权限编辑这个项目", 'frontend-publishing');
    $category = get_the_category($post_id);
    $tags = wp_get_post_tags($post_id, array('fields' => 'names'));
    $featured_img = get_post_thumbnail_id($post_id);
    $featured_img_html = (!empty($featured_img)) ? wp_get_attachment_image($featured_img, array(200, 200)) : '';
    $post = array(
        'title'            => $p['post_title'],
        'content'          => $p['post_content'],
        'post_status' => 'publish',//是否直接发布
        //'post_category' => array(13),分类目录-项目  未实现
        'about_the_author' => get_post_meta($post_id, 'about_the_author', true)
    );
    if (isset($category[0]) && is_array($category))
        $post['category'] = $category[0]->cat_ID;
    if (isset($tags) && is_array($tags))
        $post['tags'] = implode(', ', $tags);
}
?>
<noscript>
    <div id="no-js"
         class="warning"><?php _e('This form needs JavaScript to function properly. Please turn on JavaScript and try again!', 'frontend-publishing'); ?></div>
</noscript>

<div id="fep-new-post">
    <div id="fep-message" class="warning"></div>
    <form id="fep-submission-form">
        <div class="col-md-9 col-sm-9 col-xs-9" id="col9">
<!--        <label for="fep-post-title">--><?php //_e('标题', 'frontend-publishing'); ?><!--</label>-->
        <input type="text" name="post_title" placeholder="输入项目名称" id="fep-post-title" value="<?php echo ($post) ? $post['title'] : ''; ?>" style="width: 100%;font-size: 30px;font-weight: bold;color: #333;margin: 0px 0 25px 0;border: none;border-bottom: 1px solid #dcdcdc;box-shadow: none;">
<!--        <label for="fep-post-content">--><?php //_e('內容', 'frontend-publishing'); ?><!--</label>-->
        <?php
        $enable_media = (isset($fep_roles['enable_media']) && $fep_roles['enable_media']) ? current_user_can($fep_roles['enable_media']) : 1;
        wp_editor($post['content'], 'fep-post-content',
                  $settings = array(
                      'textarea_name' => 'post_content',
                      'textarea_rows' => 50,
                      'media_buttons' => $enable_media
                      )
                );
        wp_nonce_field('fepnonce_action', 'fepnonce');
        ?>
        <?php if (!$fep_misc['disable_author_bio']): ?>
            <label for="fep-about"><?php _e('Author Bio', 'frontend-publishing'); ?></label>
            <textarea name="about_the_author" id="fep-about" rows="5"><?php echo ($post) ? $post['about_the_author'] : ''; ?></textarea>
        <?php else: ?>
            <input type="hidden" name="about_the_author" id="fep-about" value="-1">
        <?php endif; ?>
            <div class="m-publish-project">
                <div id="m-fep-featured-image" style="width: 100%;height: 150px">
                    <div id="fep-featured-image-container"><?php echo $featured_img_html; ?></div>
                    <a id="m-fep-featured-image-link" href="#"><?php _e('选择封面图片', 'frontend-publishing'); ?></a>
                    <input type="hidden" id="fep-featured-image-id" value="<?php echo (!empty($featured_img)) ? $featured_img : '-1'; ?>"/>
                </div>
                <label for="fep-category"><?php _e('分类', 'frontend-publishing'); ?></label>
                <?php wp_dropdown_categories(array('id' => 'fep-category', 'hide_empty' => 0, 'name' => 'post_category', 'orderby' => 'name','child_of' =>6 ,'selected' => $post['category'], 'hierarchical' => true,/* 'show_option_none' => __('None', 'frontend-publishing')*/)); ?>
                <label for="fep-tags"><?php _e('标签', 'frontend-publishing'); ?></label>
                <input type="text" name="post_tags" id="fep-tags" value="<?php echo ($post) ? $post['tags'] : ''; ?>" placeholder="多个标签用英文逗号（,）隔开">
                <input type="hidden" name="post_id" id="fep-post-id" value="<?php echo $post_id ?>"><br><br>
                <button type="button" id="fep-submit-post" class="active-btn" onclick="actionPublish()"><?php _e('发布', 'frontend-publishing'); ?></button>&nbsp;<button type="button" id="m-close" class="close_btn">取消</button>
                <img class="fep-loading-img" src="<?php echo plugins_url('static/img/ajax-loading.gif', dirname(__FILE__)); ?>"/>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-3 right publish-project-choose" id="col3">
            <div id="fep-featured-image" style="width: 100%;height: 150px">
                <div id="fep-featured-image-container"><?php echo $featured_img_html; ?></div>
                <a id="fep-featured-image-link" href="#"><?php _e('选择封面图片', 'frontend-publishing'); ?></a>
                <input type="hidden" id="fep-featured-image-id" value="<?php echo (!empty($featured_img)) ? $featured_img : '-1'; ?>"/>
            </div>
        <label for="fep-category"><?php _e('分类', 'frontend-publishing'); ?></label>
        <?php wp_dropdown_categories(array('id' => 'fep-category', 'hide_empty' => 0, 'name' => 'post_category', 'orderby' => 'name','child_of' =>6 ,'selected' => $post['category'], 'hierarchical' => true,/* 'show_option_none' => __('None', 'frontend-publishing')*/)); ?>
        <label for="fep-tags"><?php _e('标签', 'frontend-publishing'); ?></label>
        <input type="text" name="post_tags" id="fep-tags" value="<?php echo ($post) ? $post['tags'] : ''; ?>" placeholder="多个标签用英文逗号（,）隔开">
        <input type="hidden" name="post_id" id="fep-post-id" value="<?php echo $post_id ?>"><br><br>
            <!--        添加可见性-->
            <div class="post_permission">
                <p class="post_sidebar_title">谁可以看</p>
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

        <button type="button" id="fep-submit-post" class="active-btn" onclick="actionPublish()"><?php _e('发布', 'frontend-publishing'); ?></button>&nbsp;<button type="button" id="close" class="close_btn">取消</button>
        <img class="fep-loading-img" src="<?php echo plugins_url('static/img/ajax-loading.gif', dirname(__FILE__)); ?>"/>
        </div>

    </form>
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
        row2.content =document.getElementById("fep-post-title").value;
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