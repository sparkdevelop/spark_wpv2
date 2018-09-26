<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/3/14
 * Time: 下午2:53
 */
global $integral_system;
$integral_system = array(
    'create_wiki' => 15,  //创建wiki
    'create_project' => 15,     //创建项目
    'edit_wiki' => 15,  //编辑wiki
    'get_grade' => 5,   //获得打分
    'grade' => 2,  //为别人打分
    'get_favorite' => 2,    //获得收藏
    'comment' => 5,     //为wiki和项目评论
    'answer_question' => 5, //回答问题
    'get_vote' => 1,     //获得赞同
    'unlock_source' => 6  //解锁资源
);


//加载js
function sparkspace_scripts_with_jquery()
{
    // Register the script like this for a theme:
    wp_register_script('custom-script', get_template_directory_uri() . '/bootstrap/jquery-3.2.0.min.js');
    wp_register_script('custom-script_1', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array('jquery'));
    wp_register_script('custom-script_2', get_template_directory_uri() . '/layer/layer.js', array('jquery'));
    wp_register_script('custom-script_3', get_template_directory_uri() . '/javascripts/eventFunction.js', array('jquery'));
    //wp_register_script('custom-script_4', get_template_directory_uri() . '/javascripts/echarts.js', array('jquery'));
    wp_register_script('custom-script_5', get_template_directory_uri() . '/datetimepicker/js/bootstrap-datetimepicker.js', array('jquery'));
    wp_register_script('custom-script_6', get_template_directory_uri() . '/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js');
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script('custom-script');
    wp_enqueue_script('custom-script_1');
    wp_enqueue_script('custom-script_2');
    wp_enqueue_script('custom-script_3');
    //wp_enqueue_script('custom-script_4');
    wp_enqueue_script('custom-script_5');
    wp_enqueue_script('custom-script_6');
}

add_action('wp_enqueue_scripts', 'sparkspace_scripts_with_jquery');

//下面if中的内容为注册边栏小工具,分别是home页面,wiki页面和问答页面。与sidebar.php中的内容相对应。
//注释中的内容可以放出来看效果。注册时必须使用小写英文。
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'home_sidebar',
        'id' => 'widget_homesidebar',
//        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        //        'after_widget' => '</li>',
//        'before_title' => '<h2>',
        //        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => 'wiki_sidebar',
        'id' => 'widget_wikisidebar',
    ));
    register_sidebar(array(
        'name' => 'qa_sidebar',
        'id' => 'widget_qasidebar',
    ));
    register_sidebar(array(
        'name' => 'qa_show_sidebar',
        'id' => 'widget_qa_show_sidebar',
    ));
    register_sidebar(array(
        'name' => 'qa_ask_sidebar',
        'id' => 'widget_qa_ask_sidebar',
    ));
    register_sidebar(array(
        'name' => 'project_sidebar',
        'id' => 'widget_projectsidebar',
    ));
    register_sidebar(array(
        'name' => 'search_sidebar',
        'id' => 'widget_searchsidebar',
    ));
    register_sidebar(array(
        'name' => 'tags_sidebar',
        'id' => 'widget_tagssidebar',
    ));
    register_sidebar(array(
        'name' => 'personal_sidebar',
        'id' => 'widget_personalsidebar',
    ));
    register_sidebar(array(
        'name' => 'otherpersonal_sidebar',
        'id' => 'widget_otherpersonalsidebar',
    ));
}
//取消注册sidebar
//if(function_exists('unregister_sidebar')){
//    unregister_sidebar('wiki_sidebar');
//}


//去除顶部默认的工具条 仅对管理员显示 http://www.cuizl.com/wpjiaochen/2314.html
if (!current_user_can('manage_options')) {

    add_filter('show_admin_bar', '__return_false');
}
//add_filter( 'avatar_defaults', 'newgravatar' );


//用户更改头像
require_once(TEMPLATEPATH . '/simple-local-avatars.php');


//热门问题小工具
//require "widget/Spark_Widgets_Popular_Question.php";

//热门标签小工具
//require "widget/Spark_Widgets_Popular_Tags.php";

//更改后台样式
function my_register_admin_color_schemes()
{
    wp_admin_css_color('skyblue', '天蓝色', 'style.css', array('#149dc1', '#24272d', '#3b454b', '#f0f0f0'));
}

add_action('admin_init', 'my_register_admin_color_schemes', 10);

//更改标签样式
function colorCloud($text)
{
    $text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text);
    return $text;
}

function colorCloudCallback($matches)
{
    $text = $matches[1];
    $color = 'fe642d';
    $pattern = '/style=(\'|\")(.*)(\'|\")/i';
    $text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
    return "<a class='label label-default' $text>";
}

add_filter('wp_tag_cloud', 'colorCloud', 1);

//标签tag所包含的文章数量
function Tagno($text)
{
    $text = preg_replace_callback('|<a (.+?)</a>|i', 'tagnoCallback', $text);
    return $text;
}

function tagnoCallback($matches)
{
    $text = $matches[1];
    preg_match('|title=(.+?)style|i', $text, $a);
    preg_match("/[0-9]+/", $a[0], $b);
    return "<a " . $text . "<span>[" . $b[0] . "]</span></a>";
}

add_filter('wp_tag_cloud', 'Tagno', 1);

function dwqa_user_most_ask($number = 10, $from = false, $to = false)
{
    global $wpdb;

    $query = "SELECT post_author, count( * ) as `ask_count` 
				FROM `{$wpdb->prefix}posts` 
				WHERE post_type = 'dwqa-question' 
					AND post_status = 'publish'
					AND post_author <> 0";
    if ($from) {
        $from = date('Y-m-d h:i:s', $from);
        $query .= " AND `{$wpdb->prefix}posts`.post_date > '{$from}'";
    }
    if ($to) {
        $to = date('Y-m-d h:i:s', $to);
        $query .= " AND `{$wpdb->prefix}posts`.post_date < '{$to}'";
    }

    $prefix = '-all';
    if ($from && $to) {
        $prefix = '-' . ($form - $to);
    }

    $query .= " GROUP BY post_author 
				ORDER BY `ask_count` DESC LIMIT 0,{$number}";
    $users = wp_cache_get('dwqa-most-ask' . $prefix);
    if (false == $users) {
        $users = $wpdb->get_results($query, ARRAY_A);
        wp_cache_set('dwqa-most-ask', $users);
    }
    return $users;
}

function get_hot_tags()
{
    global $wpdb;
    $tag_id = array();
    $tag_name = array();//存储每个链接的名字;
    $link = array(); // 存储每个标签的链接;
    $tag_count = array();
//==============获取所有tag的id信息===============
    $tags = get_terms('dwqa-question_tag', array_merge(array('orderby' => 'count', 'order' => 'DESC')));
//=============================
    foreach ($tags as $key => $temp) {
        $tag_id[] = $temp->term_id;
        $tag_count[] = $temp->count;
        $tag_name[] = $temp->name;
        array_push($link, get_term_link(intval($tag_id[$key]), 'dwqa-question_tag'));
    }
}

//获取当前页面地址
function curPageURL()
{
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function get_page_id($page_name)
{
    global $wpdb;

    $page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$page_name' AND post_status = 'publish' ");
    return $page_id;
}

function get_page_address($page_name)
{
    global $wpdb;
    $page_id = get_page_id($page_name);
    $page_address = "/?page_id=" . $page_id;
    return $page_address;
}


function get_dwqa_cat_ID($cat_name)
{
    global $wpdb;
    $cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms WHERE name = '$cat_name'");
    return $cat_id;
}

/*//验证原密码是否正确
function checkPass()
{
    global $wpdb;
    $current_user = wp_get_current_user();
    $user_id = $current_user->data->user_login;
    $password = isset($_POST["oldpassword"]) ? $_POST["oldpassword"] : '';
    $sql = "SELECT user_pass FROM $wpdb->users WHERE ID=" . $current_user->ID;
    $user_pass = $wpdb->get_var($sql);
    $data = wp_check_password($password, $user_pass);
    if ($data) { //如果是wordpress的用户
        $response = true;
    } else {
        if (!empty($user_id) && !empty($password)) { //如果不是wordpress的用户
            $post_data = array(
                'username' => $user_id,
                'password' => $password);
            $if_user_in_mediawiki = send_post_to_mediawiki('http://115.28.144.64/wiki_wp/index.php', $post_data);
            if (!empty($if_user_in_mediawiki)) {
                $response = true;
            } else {
                $response = false;
            }
        }
    }
    echo $response;
    exit;
}

add_action('wp_ajax_checkPass', 'checkPass');
add_action('wp_ajax_nopriv_checkPass', 'checkPass');*/

/*function checkLoginPass($user_login, $user_pwd)
{
    global $wpdb;
    $sql = "SELECT user_pass FROM $wpdb->users WHERE user_login='$user_login'";
    $user_pass = $wpdb->get_var($sql);
    $data = @wp_check_password($user_pwd, $user_pass);
    if ($data) { //如果是wordpress的用户
        return true;
    } else {
        return false;
    }
}*/

//删除我的问题
function deleteMyQuestion()
{
    global $wpdb;
    $question_id = isset($_POST["question_id"]) ? $_POST["question_id"] : '';
    if (!empty($question_id)) {
        $sql = "UPDATE $wpdb->posts SET post_status = 'trash' WHERE ID =" . $question_id;
        $wpdb->get_results($sql);
        $response = true;
    } else {
        $response = false;
    }
    echo $response;
    exit;
}

add_action('wp_ajax_deleteMyQuestion', 'deleteMyQuestion');
add_action('wp_ajax_nopriv_deleteMyQuestion', 'deleteMyQuestion');

//附件的默认尺寸
//add_action( 'after_setup_theme', 'default_attachment_display_settings' );
//function default_attachment_display_settings() {
//    update_option( 'image_default_align', 'center' );
//    update_option( 'image_default_link_type', 'none' );
//    update_option( 'image_default_size', 'medium' );
//}


//function loadCustomTemplate($template) {
//    global $wp_query;
//    if(!file_exists($template))return;
//    $wp_query->is_page = true;
//    $wp_query->is_single = false;
//    $wp_query->is_home = false;
//    $wp_query->comments = false;
//    // if we have a 404 status
//    if ($wp_query->is_404) {
//        // set status of 404 to false
//        unset($wp_query->query["error"]);
//        $wp_query->query_vars["error"]="";
//        $wp_query->is_404=false;
//    }
//    // change the header to 200 OK
//    header("HTTP/1.1 200 OK");
//    //load our template
//    include($template);
//    exit;
//}
//
//function templateRedirect() {
//    $basename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
//    loadCustomTemplate(TEMPLATEPATH.'/template/'."/$basename.php");
//}
//
//add_action('template_redirect', 'templateRedirect');

//增加登录注册页自定义样式表
function custom_login()
{
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/custom-login/custom-login.css" />';
}

add_action('login_head', 'custom_login');

//更改logo的url，默认指向wordpress.org
function custom_headerurl($url)
{
    return get_bloginfo('url');
}

add_filter('login_headerurl', 'custom_headerurl');

//更改logo的title，默认是“Powered by WordPress”(基于WordPress)
function custom_headertitle($title)
{
    return __('欢迎来到火花空间');
}

add_filter('login_headertitle', 'custom_headertitle');

//在登陆表单中添加信息
//function custom_login_message() {
//    echo '<p style="text-align:center">' . __('欢迎来到火花空间，登陆后可编辑wiki');
//}
//add_action('login_form', 'custom_login_message');

//添加自定义HTML，例如增加版权信息
//function custom_html() {
//    echo '<p class="copyright">&copy; ' . get_bloginfo(url);
//}
//add_action('login_footer', 'custom_html');


//暂时无用
//function Spark_question_paginate_link() {
//    global $wp_query, $dwqa_general_settings;
//
//    $archive_question_url = curPageURL();
//    $page_text = dwqa_is_front_page() ? 'page' : 'paged';
//    $page = get_query_var( $page_text ) ? get_query_var( $page_text ) : 1;
//
//   // $tag = get_query_var( 'dwqa-question_tag' ) ? get_query_var( 'dwqa-question_tag' ) : false;
//    //$cat = get_query_var( 'dwqa-question_category' ) ? get_query_var( 'dwqa-question_category' ) : false;
//
////    $url = $cat
////        ? get_term_link( $cat, get_query_var( 'taxonomy' ) )
////        : ( $tag ? get_term_link( $tag, get_query_var( 'taxonomy' ) ) : $archive_question_url );
//
//    $args = array(
//        'base' => add_query_arg( $page_text, '%#%', $archive_question_url ),
//        'format' => '',
//        'current' => $page,
//        'show_all' => True,
//        //'total' => $wp_query->dwqa_questions->max_num_pages
//    );
//
//    $paginate = paginate_links( $args );
//    //$paginate = str_replace( 'page-number', 'dwqa-page-number', $paginate );
//    //$paginate = str_replace( 'current', 'dwqa-current', $paginate );
//    //$paginate = str_replace( 'next', 'dwqa-next', $paginate );
//    //$paginate = str_replace( 'prev ', 'dwqa-prev ', $paginate );
//    //$paginate = str_replace( 'dots', 'dwqa-dots', $paginate );
//
//    return $paginate;
//}
//项目浏览统计
function getProjectViews($postID)
{
    $count_key = 'project_views'; //自定义域
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count . '';
}

function setProjectViews($postID)
{
    $count_key = 'project_views'; //自定义域
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

//获取wiki词条浏览量
function getWikiViews($postID)
{
    $count_key = 'count'; //自定义域
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count . '';
}

//给投稿者上传文件的权限
if (current_user_can('contributor') && !current_user_can('upload_files'))
    add_action('init', 'allow_contributor_uploads');

function allow_contributor_uploads()
{
    $contributor = get_role('contributor');
    $contributor->add_cap('upload_files');
}

/*剥夺投稿者上传文件的权限
if ( current_user_can('contributor') && current_user_can('upload_files') )
    add_action('admin_init', 'allow_contributor_uploads');

function allow_contributor_uploads() {
    $contributor = get_role('contributor');
    $contributor->remove_cap('upload_files');
}
*/


//在文章编辑页面的[添加媒体]只显示用户自己上传的文件
function my_upload_media($wp_query_obj)
{
    global $current_user, $pagenow;
    if (!is_a($current_user, 'WP_User'))
        return;
    if ('admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments')
        return;
    if (!current_user_can('manage_options') && !current_user_can('manage_media_library'))
        $wp_query_obj->set('author', $current_user->ID);
    return;
}

add_action('pre_get_posts', 'my_upload_media');

//除管理员外，在[媒体库]只显示用户上传的文件
function my_media_library($wp_query)
{
    if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/upload.php') !== false) {
        if (!current_user_can('manage_options') && !current_user_can('manage_media_library')) {
            global $current_user;
            $wp_query->set('author', $current_user->id);
        }
    }
}

add_filter('parse_query', 'my_media_library');
/**
 * create by chenli
 * 处理wiki编辑更新的ajax请求
 */

function update_wiki_entry()
{
    date_default_timezone_set('Asia/Shanghai');
    global $wpdb;
    $post_id = $_POST['post_id'];
    $entry_title = $_POST['entry_title'];
    $entry_content = stripslashes($_POST['entry_content']);
    $wiki_categories = $_POST['wiki_categories'];
    $wiki_tags = $_POST['wiki_tags'];
    $current_user = wp_get_current_user();
    $post_author = $current_user->ID;
    $post_date = date("Y-m-d H:i:s");
    $post_date_gmt = $post_date;
    $post_excerpt = "";
    $post_status = "inherit";
    $comment_status = "closed";
    $ping_status = "closed";
    $post_password = "";
    $post_name = $post_id . "-revision-v1";
    $to_ping = "";
    $pinged = "";
    $post_modified = $post_date;
    $post_modified_gmt = $post_date;
    $post_content_filtered = "";
    $post_parent = $post_id;
    //更新guid
    $guid = "";
    $menu_order = 0;
    $post_type = "revision";
    $post_mime_type = "";
    $comment_count = 0;
    $wiki_new_entry = array(
        'ID' => 0,
        'post_author' => $post_author,
        'post_date' => $post_date,
        'post_date_gmt' => $post_date_gmt,
        'post_title' => $entry_title,
        'post_content' => $entry_content,
        'post_excerpt' => $post_excerpt,
        'post_status' => $post_status,
        'comment_status' => $comment_status,
        'ping_status' => $ping_status,
        'post_password' => $post_password,
        'post_name' => urlencode($post_name),
        'to_ping' => $to_ping,
        'pinged' => $pinged,
        'post_modified' => $post_modified,
        'post_modified_gmt' => $post_modified_gmt,
        'post_content_filtered' => $post_content_filtered,
        'post_parent' => $post_parent,
        'guid' => $guid,
        'menu_order' => $menu_order,
        'post_type' => $post_type,
        'post_mime_type' => $post_mime_type,
        'comment_count' => $comment_count
    );
    /*
    $update_wiki_entry = "insert into $wpdb->posts values (null, ".$post_author." ,".$post_date." ,".$post_date_gmt." ,".
    $post_excerpt.$post_status.",".$comment_status.",".$ping_status.",".$post_password.",".$post_name.",".$to_ping.",".$pinged.",".$post_modified.
    ",".$post_modified_gmt.",".$post_content_filtered.",".$post_parent.",".$guid.",".$menu_order.",".$post_type.",".
    $post_mime_type.",".$comment_count;
    */

    //增加积分
    global $integral_system;
    if (get_current_user_id() != get_post($post_id)->post_author) {
        add_user_integral(get_current_user_id(), $integral_system['edit_wiki']);
    }


    $wpdb->insert($wpdb->posts, $wiki_new_entry);
    $wpdb->update($wpdb->posts, array(
        "post_content" => $entry_content,
        "post_modified" => $post_modified,
        "post_modified_gmt" => $post_modified_gmt
    ), array(
        ID => $post_id
    ));

    //处理分类
    $term_names_result = $wpdb->get_results("select tt.term_id, tt.term_taxonomy_id, tt.count from $wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tr.term_taxonomy_id=tt.term_taxonomy_id where tt.taxonomy=\"wiki_cats\" and tr.object_id=" . $post_id);
    foreach ($term_names_result as $item) {
        $tt_term_id = $item->term_id;
        $tt_term_taxonomy_id = $item->term_taxonomy_id;
        $count = $item->count;
        if (!in_array($tt_term_id, $wiki_categories)) {
            $wpdb->query("delete from $wpdb->term_relationships where term_taxonomy_id=" . $tt_term_taxonomy_id);
            $wpdb->update($wpdb->term_taxonomy, array(
                "count" => --$count
            ), array(
                term_taxonomy_id => $tt_term_taxonomy_id
            ));
        }

    }
    foreach ($wiki_categories as $wiki_category) {
        $is_continue = false;
        $if_has_category = $wpdb->get_results("select count(*) as has_category from $wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id where tr.object_id=" . $post_id . " and tt.term_id=" . $wiki_category);
        foreach ($if_has_category as $item) {
            if ($item->has_category != 0) {
                $is_continue = true;
            }
        }
        if ($is_continue) {
            continue;
        }
        $term_taxonomy_result = $wpdb->get_results("select * from $wpdb->term_taxonomy where term_id=" . $wiki_category);
        foreach ($term_taxonomy_result as $term_taxonomy_item) {
            $count = $term_taxonomy_item->count;
            $term_taxonomy_id = $term_taxonomy_item->term_taxonomy_id;
            $wpdb->update($wpdb->term_taxonomy, array(
                "count" => ++$count
            ), array(
                term_id => $wiki_category
            ));
            $wpdb->insert($wpdb->term_relationships, array(
                "object_id" => $post_id,
                "term_taxonomy_id" => $term_taxonomy_id,
                "term_order" => 0
            ));
        }
    }

    //处理tag
    $term_names_result = $wpdb->get_results("select t.`name`, tt.term_taxonomy_id, tt.count from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=" . $post_id . " and tt.taxonomy=\"wiki_tags\"");
    foreach ($term_names_result as $item) {
        $term_name = $item->name;
        $tt_term_taxonomy_id = $item->term_taxonomy_id;
        $count = $item->count;
        if (!in_array($term_name, $wiki_tags)) {
            $wpdb->query("delete from $wpdb->term_relationships where term_taxonomy_id=" . $tt_term_taxonomy_id);
            $wpdb->update($wpdb->term_taxonomy, array(
                "count" => --$count
            ), array(
                term_taxonomy_id => $tt_term_taxonomy_id
            ));
        }

    }
    foreach ($wiki_tags as $wiki_tag) {
        $wiki_tag_slug = urlencode($wiki_tag);
        $is_continue = false;
        $if_has_tag = $wpdb->get_results("select count(*) as has_tag from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=" . $post_id . " and t.`name`=\"" . $wiki_tag . "\" and tt.taxonomy=\"wiki_tags\"");
        foreach ($if_has_tag as $item) {
            if ($item->has_tag != 0) {
                $is_continue = true;
            }
        }
        if ($is_continue) {
            continue;
        }
        $if_tag_exist = $wpdb->get_results("select count(*) as tag_nums, t.term_id from $wpdb->terms t left join $wpdb->term_taxonomy tt on t.term_id = tt.term_id where tt.taxonomy=\"wiki_tags\" and t.name = " . "\"" . $wiki_tag . "\"");
        foreach ($if_tag_exist as $if_tag_exist_item) {
            if ($if_tag_exist_item->tag_nums > 0) {
                $term_taxonomy_result = $wpdb->get_results("select * from $wpdb->term_taxonomy where term_id=" . $if_tag_exist_item->term_id);
                foreach ($term_taxonomy_result as $term_taxonomy_item) {
                    $count = $term_taxonomy_item->count;
                    $term_taxonomy_id = $term_taxonomy_item->term_taxonomy_id;
                    $wpdb->update($wpdb->term_taxonomy, array(
                        "count" => ++$count
                    ), array(
                        term_id => $if_tag_exist_item->term_id
                    ));
                }
                $wpdb->insert($wpdb->term_relationships, array(
                    "object_id" => $post_id,
                    "term_taxonomy_id" => $term_taxonomy_id,
                    "term_order" => 0
                ));
            } else {
                $wpdb->query("insert into $wpdb->terms values (0, " . "\"" . $wiki_tag . "\", \"" . $wiki_tag_slug . "\", 0)");
                $last_insert = $wpdb->insert_id;
                $wpdb->query("insert into $wpdb->term_taxonomy values (0, " . $last_insert . ", \"wiki_tags\", \"wiki_tags\", 0, 1)");
                $last_insert_t_t_id = $wpdb->insert_id;
                $wpdb->insert($wpdb->term_relationships, array(
                    "object_id" => $post_id,
                    "term_taxonomy_id" => $last_insert_t_t_id,
                    "term_order" => 0
                ));
            }
        }
    }


    echo json_encode("success!");
    die();
}

add_action('wp_ajax_update_wiki_entry', 'update_wiki_entry');
add_action('wp_ajax_nopriv_update_wiki_entry', 'update_wiki_entry');

/**
 * create by chenli
 * 用户创建新的wiki词条
 */
function create_wiki_entry()
{
    date_default_timezone_set('Asia/Shanghai');
    global $wpdb;
    $entry_title = stripslashes($_POST['entry_title']);
    $entry_content = stripslashes($_POST['entry_content']);
    $wiki_categories = $_POST['wiki_categories'];
    $wiki_tags = $_POST['wiki_tags'];
    $current_user = wp_get_current_user();
    $post_author = $current_user->ID;
    $post_date = date("Y-m-d H:i:s");
    $post_date_gmt = $post_date;
    $post_excerpt = "";
    $post_status1 = "publish";
    $post_status2 = "inherit";
    $comment_status1 = "open";
    $comment_status2 = "closed";
    $ping_status = "closed";
    $post_password = "";
    //$post_name = $post_id . "-revision-v1";
    $same_title_entrys = $wpdb->get_results("select count(*) as nums from $wpdb->posts where post_title=\"" . $entry_title . "\" and post_status=\"publish\"");
    $nums = 0;
    foreach ($same_title_entrys as $item) {
        $nums = $item->nums;
    }
    $post_name = time();
    if ($nums > 0) {
        $nums++;
        $post_name = $post_name . "-" . $nums;
    }
    $to_ping = "";
    $pinged = "";
    $post_modified = $post_date;
    $post_modified_gmt = $post_date;
    $post_content_filtered = "";
    //$post_parent = $post_id;
    $post_parent = 0;
    //更新guid
    $guid = "";
    $menu_order = 0;
    //$post_type = "revision";
    $post_type = "yada_wiki";
    $post_mime_type = "";
    $comment_count = 0;

    $wiki_new_entry1 = array(
        'ID' => 0,
        'post_author' => $post_author,
        'post_date' => $post_date,
        'post_date_gmt' => $post_date_gmt,
        'post_title' => $entry_title,
        'post_content' => $entry_content,
        'post_excerpt' => $post_excerpt,
        'post_status' => $post_status1,
        'comment_status' => $comment_status1,
        'ping_status' => $ping_status,
        'post_password' => $post_password,
        'post_name' => urlencode($post_name),
        'to_ping' => $to_ping,
        'pinged' => $pinged,
        'post_modified' => $post_modified,
        'post_modified_gmt' => $post_modified_gmt,
        'post_content_filtered' => $post_content_filtered,
        'post_parent' => $post_parent,
        'guid' => $guid,
        'menu_order' => $menu_order,
        'post_type' => $post_type,
        'post_mime_type' => $post_mime_type,
        'comment_count' => $comment_count
    );

    $wpdb->insert($wpdb->posts, $wiki_new_entry1);
    $last_insert = $wpdb->get_results("select ID from $wpdb->posts where post_title=\"" . $entry_title . "\" and post_status=\"publish\" and post_name=\"" . $post_name . "\"");
    $last_insert_ID = 0;
    foreach ($last_insert as $item) {
        $last_insert_ID = $item->ID;
    }
    $wiki_new_entry2 = array(
        'ID' => 0,
        'post_author' => $post_author,
        'post_date' => $post_date,
        'post_date_gmt' => $post_date_gmt,
        'post_title' => $entry_title,
        'post_content' => $entry_content,
        'post_excerpt' => $post_excerpt,
        'post_status' => $post_status2,
        'comment_status' => $comment_status2,
        'ping_status' => $ping_status,
        'post_password' => $post_password,
        'post_name' => urlencode($last_insert_ID . "-revision-v1"),
        'to_ping' => $to_ping,
        'pinged' => $pinged,
        'post_modified' => $post_modified,
        'post_modified_gmt' => $post_modified_gmt,
        'post_content_filtered' => $post_content_filtered,
        'post_parent' => $last_insert_ID,
        'guid' => $guid,
        'menu_order' => $menu_order,
        'post_type' => "revision",
        'post_mime_type' => $post_mime_type,
        'comment_count' => $comment_count
    );
    $wpdb->insert($wpdb->posts, $wiki_new_entry2);

    //处理分类
    foreach ($wiki_categories as $wiki_category) {
        $term_taxonomy_result = $wpdb->get_results("select * from $wpdb->term_taxonomy where term_id=" . $wiki_category);
        foreach ($term_taxonomy_result as $term_taxonomy_item) {
            $count = $term_taxonomy_item->count;
            $term_taxonomy_id = $term_taxonomy_item->term_taxonomy_id;
            $wpdb->update($wpdb->term_taxonomy, array(
                "count" => ++$count
            ), array(
                term_id => $wiki_category
            ));
            $wpdb->insert($wpdb->term_relationships, array(
                "object_id" => $last_insert_ID,
                "term_taxonomy_id" => $term_taxonomy_id,
                "term_order" => 0
            ));
        }
    }

    //处理tag
    foreach ($wiki_tags as $wiki_tag) {
        $wiki_tag_slug = urlencode($wiki_tag);
        $if_tag_exist = $wpdb->get_results("select count(*) as tag_nums, t.term_id from $wpdb->terms t left join $wpdb->term_taxonomy tt on t.term_id = tt.term_id where tt.taxonomy=\"wiki_tags\" and t.name = " . "\"" . $wiki_tag . "\"");
        foreach ($if_tag_exist as $if_tag_exist_item) {
            if ($if_tag_exist_item->tag_nums > 0) {
                $term_taxonomy_result = $wpdb->get_results("select * from $wpdb->term_taxonomy where term_id=" . $if_tag_exist_item->term_id);
                foreach ($term_taxonomy_result as $term_taxonomy_item) {
                    $count = $term_taxonomy_item->count;
                    $term_taxonomy_id = $term_taxonomy_item->term_taxonomy_id;
                    $wpdb->update($wpdb->term_taxonomy, array(
                        "count" => ++$count
                    ), array(
                        term_id => $if_tag_exist_item->term_id
                    ));
                }
                $wpdb->insert($wpdb->term_relationships, array(
                    "object_id" => $last_insert_ID,
                    "term_taxonomy_id" => $term_taxonomy_id,
                    "term_order" => 0
                ));
            } else {
                $wpdb->query("insert into $wpdb->terms values (0, " . "\"" . $wiki_tag . "\", \"" . $wiki_tag_slug . "\", 0)");
                $last_insert = $wpdb->insert_id;
                $wpdb->query("insert into $wpdb->term_taxonomy values (0, " . $last_insert . ", \"wiki_tags\", \"wiki_tags\", 0, 1)");
                $last_insert_t_t_id = $wpdb->insert_id;
                $wpdb->insert($wpdb->term_relationships, array(
                    "object_id" => $last_insert_ID,
                    "term_taxonomy_id" => $last_insert_t_t_id,
                    "term_order" => 0
                ));
            }
        }
    }

    //处理可见性
    $visibility = $_POST['wiki_visibility'];
    create_process_visibility($visibility, $last_insert_ID, $current_user->ID);

    //增加积分
    global $integral_system;
    add_user_integral($current_user->ID, $integral_system['create_wiki']);


    echo json_encode($post_name);
    die();

}

add_action('wp_ajax_create_wiki_entry', 'create_wiki_entry');
add_action('wp_ajax_nopriv_create_wiki_entry', 'create_wiki_entry');

function get_post_info()
{
    global $wpdb;
    $post_id = $_POST['post_id'];
    $edit_authors_result = $wpdb->get_results("select count(distinct post_author) as edit_authors from $wpdb->posts where post_parent = " . $post_id);
    $revisions_result = $wpdb->get_results("select count(*) as revisions from $wpdb->posts where post_parent = " . $post_id);
    $post_modified_result = $wpdb->get_results("select post_modified from $wpdb->posts where post_parent=" . $post_id . " order by post_modified desc limit 1");
    $edit_author_nums = 0;
    $revision_nums = 0;
    $post_modified_date = strtotime(date("y-m-d h:i:s"));
    $current_date = strtotime(date("y-m-d h:i:s"));
    foreach ($edit_authors_result as $edit_authors) {
        $edit_author_nums = $edit_authors->edit_authors;
    }
    foreach ($revisions_result as $revisions) {
        $revision_nums = $revisions->revisions;
    }
    foreach ($post_modified_result as $post_modified) {
        $post_modified_date = strtotime($post_modified->post_modified);
    }
    $time = ceil(($current_date - $post_modified_date) / 86400);
    $categorys_result = $wpdb->get_results("select t.`name` from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=" . $post_id . " and tt.taxonomy=\"wiki_cats\"");
    $tags_result = $wpdb->get_results("select t.`name` from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=" . $post_id . " and tt.taxonomy=\"wiki_tags\"");
    $categorys = array();
    $tags = array();
    foreach ($categorys_result as $item) {
        $categorys[] = $item->name;
    }
    foreach ($tags_result as $item) {
        $tags[] = $item->name;
    }

    //处理浏览次数
    $watch_count = 0;
    $if_has_watched = $wpdb->get_results("select meta_value, meta_id from $wpdb->postmeta where meta_key=\"count\" and post_id=" . $post_id);
    $is_watched = false;
    $watch_nums = 0;
    $meta_id = 0;
    foreach ($if_has_watched as $item) {
        $watch_nums = $item->meta_value;
        if (!empty($watch_nums)) {
            $is_watched = true;
            $meta_id = $item->meta_id;
        }
    }
    if ($is_watched) {
        $wpdb->update($wpdb->postmeta, array(
            "meta_value" => ++$watch_nums
        ), array(
            meta_id => $meta_id
        ));

        $watch_count = $watch_nums;
    } else {
        $wpdb->insert($wpdb->postmeta, array(
            "meta_id" => 0,
            "post_id" => $post_id,
            "meta_key" => "count",
            "meta_value" => 1
        ));
        $watch_count = 1;
    }

    $data = array(
        "edit_author_nums" => $edit_author_nums,
        "revision_nums" => $revision_nums,
        "time" => $time,
        "categories" => $categorys,
        "tags" => $tags,
        "watch_count" => $watch_count
    );
    echo json_encode($data);
    die();
}

add_action('wp_ajax_get_post_info', 'get_post_info');
add_action('wp_ajax_nopriv_get_post_info', 'get_post_info');

function get_wiki_hot_tags()
{
    global $wpdb;
    $hot_tags_nums = 20;
    $hot_tags = array();
    $hot_tags_result = $wpdb->get_results("select t.`name` from $wpdb->terms t left join $wpdb->term_taxonomy tt on t.term_id=tt.term_id where tt.taxonomy=\"wiki_tags\" order by tt.count desc limit " . $hot_tags_nums);
    foreach ($hot_tags_result as $item) {
        $hot_tags[] = $item->name;
    }
    $data = array(
        "hot_tags" => $hot_tags
    );
    echo json_encode($data);
    die();
}

add_action('wp_ajax_get_wiki_hot_tags', 'get_wiki_hot_tags');
add_action('wp_ajax_nopriv_get_wiki_hot_tags', 'get_wiki_hot_tags');


//项目首页、标签页、分类页、个人页分页
function project_custom_pagenavi($custom_query, $range = 4)
{
    global $paged, $wp_query;
    if (!$max_page) {
        $max_page = $custom_query->max_num_pages;
    }
    if ($max_page > 1) {
        echo "<div class='pagenavi'>";
        if (!$paged) {
            $paged = 1;
        }
        if ($paged != 1) {
            echo "<a href='" . get_pagenum_link(1) . "' class='extend' title='跳转到首页'>首页</a>";
        }
        previous_posts_link('上一页');
        if ($max_page > $range) {
            if ($paged < $range) {
                for ($i = 1; $i <= ($range + 1); $i++) {
                    echo "<a href='" . get_pagenum_link($i) . "'";
                    if ($i == $paged) echo " class='current'";
                    echo ">$i</a>";
                }
            } elseif ($paged >= ($max_page - ceil(($range / 2)))) {
                for ($i = $max_page - $range; $i <= $max_page; $i++) {
                    echo "<a href='" . get_pagenum_link($i) . "'";
                    if ($i == $paged) echo " class='current'";
                    echo ">$i</a>";
                }
            } elseif ($paged >= $range && $paged < ($max_page - ceil(($range / 2)))) {
                for ($i = ($paged - ceil($range / 2)); $i <= ($paged + ceil(($range / 2))); $i++) {
                    echo "<a href='" . get_pagenum_link($i) . "'";
                    if ($i == $paged) echo " class='current'";
                    echo ">$i</a>";
                }
            }
        } else {
            for ($i = 1; $i <= $max_page; $i++) {
                echo "<a href='" . get_pagenum_link($i) . "'";
                if ($i == $paged) echo " class='current'";
                echo ">$i</a>";
            }
        }
        next_posts_link('下一页', $custom_query->max_num_pages);
        if ($paged != $max_page) {
            echo "<a href='" . get_pagenum_link($max_page) . "' class='extend' title='跳转到最后一页'>尾页</a>";
        }
        echo '<span>[' . $paged . ']/[' . $max_page . ']页</span>';
        echo "</div>\n";
    }
}

// 项目模板挂载函数到正确的钩子
function my_add_mce_button()
{
    // 检查用户权限
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }
    // 检查是否启用可视化编辑
    if ('true' == get_user_option('rich_editing')) {
        add_filter('mce_external_plugins', 'my_add_tinymce_plugin');
        add_filter('mce_buttons', 'my_register_mce_button');
    }
}

add_action('init', 'my_add_mce_button');

// 声明项目模板的脚本
function my_add_tinymce_plugin($plugin_array)
{
    $plugin_array['my_mce_button'] = get_template_directory_uri() . '/template/project/mce-button.js';
    return $plugin_array;
}

// 在编辑器上注册项目模板按钮
function my_register_mce_button($buttons)
{
    array_push($buttons, 'my_mce_button');
    return $buttons;
}

//支持中文注册和登陆
function ludou_sanitize_user($username, $raw_username, $strict)
{
    $username = wp_strip_all_tags($raw_username);
    $username = remove_accents($username);
    // Kill octets
    $username = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '', $username);
    $username = preg_replace('/&.+?;/', '', $username); // Kill entities

    // 网上很多教程都是直接将$strict赋值false，
    // 这样会绕过字符串检查，留下隐患
    if ($strict) {
        $username = preg_replace('|[^a-z\p{Han}0-9 _.\-@]|iu', '', $username);
    }

    $username = trim($username);
    // Consolidate contiguous whitespace
    $username = preg_replace('|\s+|', ' ', $username);

    return $username;
}

add_filter('sanitize_user', 'ludou_sanitize_user', 10, 3);

//// 用户注册成功后自动登录，并跳转到指定页面
//function auto_login_new_user( $user_id ) {
//    wp_set_current_user($user_id);
//    wp_set_auth_cookie($user_id);
//
//    // 这里设置的是跳转到首页，要换成其他页面
//
//    // 如 wp_redirect( 'http://www.baidu.com' );
//    wp_redirect(  get_bloginfo( 'url' ) );
//    exit;
//}
//add_action( 'user_register', 'auto_login_new_user' );

function get_user_related_wiki()
{
    $wikis = array();
    $post_status = $_POST['get_wiki_type'];
    $post_author = $_POST['userID'];
    //$current_user = wp_get_current_user();
    //$post_author = $current_user->ID;
    global $wpdb;
    if ($post_status == "publish") {
        $publish_wikis_result = $wpdb->get_results("select * from $wpdb->posts where post_author=" . $post_author . " and post_status=\"publish\" and post_type=\"yada_wiki\"");
        foreach ($publish_wikis_result as $item) {
            $wikis[] = $item;
        }
    } else {
        $all_wikis_ids = array();
        $published_wikis = $wpdb->get_results("select ID from $wpdb->posts where post_status=\"publish\" and post_type=\"yada_wiki\"");
        foreach ($published_wikis as $item) {
            $all_wikis_ids[] = $item->ID;
        }
        $inherit_ids = array();
        $inherit_wikis_result = $wpdb->get_results("select * from $wpdb->posts where post_author=" . $post_author . " and post_status=\"inherit\" group by post_parent");
        foreach ($inherit_wikis_result as $item) {
            $parent_id = $item->post_parent;
            if (in_array($parent_id, $all_wikis_ids)) {
                $inherit_ids[] = $parent_id;
            }
        }
        if (count($inherit_ids) > 0) {
            $inherit_ids_str = "";
            for ($i = 0; $i < count($inherit_ids); $i++) {
                if ($i == 0) {
                    $inherit_ids_str = "(" . $inherit_ids[$i] . ",";
                    continue;
                }
                if ($i == count($inherit_ids) - 1) {
                    $inherit_ids_str = $inherit_ids_str . $inherit_ids[$i] . ")";
                    continue;
                }
                $inherit_ids_str = $inherit_ids_str . $inherit_ids[$i] . ",";
            }
            if (count($inherit_ids) == 1) {
                $inherit_ids_str = "(" . $inherit_ids[0] . ")";
            }
            $final_wikis_result = $wpdb->get_results("select * from $wpdb->posts where `ID` in " . $inherit_ids_str);
            foreach ($final_wikis_result as $item) {
                $wikis[] = $item;
            }
        }
    }
    $data = array(
        "wikis" => $wikis
    );
    echo json_encode($data);
    die();

}

add_action('wp_ajax_get_user_related_wiki', 'get_user_related_wiki');
add_action('wp_ajax_nopriv_get_user_related_wiki', 'get_user_related_wiki');

function get_notice()
{
    global $wpdb;
    $all_post_ids = array();
    $new_comments = array();
    $current_user = wp_get_current_user();
    //$all_post_id_result = $wpdb->get_results("select ID from $wpdb->posts where post_author =".$current_user);
    $all_post_id_result = $wpdb->get_results("select * from $wpdb->posts where post_author=" . get_current_user());

    foreach ($all_post_id_result as $item) {
        $all_post_ids[] = $item->ID;
    }
    if (count($all_post_ids) > 0) {

        $inherit_ids_str = "";
        for ($i = 0; $i < count($all_post_ids); $i++) {
            if ($i == 0) {
                $inherit_ids_str = "(" . $all_post_ids[$i] . ",";
                continue;
            }
            if ($i == count($all_post_ids) - 1) {
                $inherit_ids_str = $inherit_ids_str . $all_post_ids[$i] . ")";
                continue;
            }
            $inherit_ids_str = $inherit_ids_str . $all_post_ids[$i] . ",";
        }
        if (count($all_post_ids) == 1) {
            $inherit_ids_str = "(" . $all_post_ids[0] . ")";
        }
        $new_comments_result = $wpdb->get_results("select * from $wpdb->comments where comment_post_ID in " . $inherit_ids_str . " and user_id !=" . $current_user . " and if_new_comment = 0");
        foreach ($new_comments_result as $item) {
            $new_comments[] = $item;
        }

    }
    $data = array(
        "new_comments" => $new_comments
    );
    echo json_encode($data);
    die();

}

add_action('wp_ajax_get_notice', 'get_notice');
add_action('wp_ajax_nopriv_get_notice', 'get_notice');

//登陆之后跳转到首页
function my_login_redirect($redirect_to, $request)
{
    if (empty($redirect_to) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url())
        return home_url();
    else
        return $redirect_to;
}

add_filter('login_redirect', 'my_login_redirect', 10, 3);
// 在编辑器中启用字体和字体大小选择
if (!function_exists('wpex_mce_buttons')) {
    function wpex_mce_buttons($buttons)
    {
        array_unshift($buttons, 'fontselect'); // 添加字体选择
        array_unshift($buttons, 'fontsizeselect'); // 添加字体大小选择
        return $buttons;
    }
}
add_filter('mce_buttons_2', 'wpex_mce_buttons');


//create by zhangxue

//建立relation表
function relation_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "relation";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
		  post_id int NOT NULL,
		  post_type varchar(20) NOT NULL,
		  related_id int NOT NULL,
		  related_post_type varchar(20) NOT NULL
          );";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//执行数据表创建。当然你可以在前面加上一些判断，或者将函数放置到插件的安装脚本中执行。

//更新前的准备工作
function deleteRelation()
{
    global $wpdb;
    //删除之前的pro《--》wiki关系
    $sql_delete = "DELETE FROM wp_relation WHERE post_type ='post' AND related_post_type='yada_wiki'";
    $wpdb->query($sql_delete);
}

//定时更新relation表
function updateRelation($post_id, $relationArray)
{
    global $wpdb;
    $post_type = get_post_type($post_id);
    if (!empty($relationArray)) {
        foreach ($relationArray as $value) {
            $sql_1 = "SELECT * FROM wp_relation WHERE post_id=$post_id AND related_id=$value";
            $col = $wpdb->query($sql_1); //返回的结果有几行
            if ($col === 0) {  //如果没有这个pro<->wiki对
                $sql_2 = "INSERT INTO wp_relation VALUES ('',$post_id,'$post_type',$value,'yada_wiki')";
                $wpdb->get_results($sql_2);
            }
        }
    }
}

//显示相关知识
function showProWiki($post_id)
{
    global $wpdb;
    $td_array = array();
    $sql_1 = "SELECT related_id FROM wp_relation WHERE post_id=$post_id and related_post_type='yada_wiki'";
    $result = $wpdb->get_results($sql_1, 'ARRAY_A');
    foreach ($result as $value) {
        $wiki_id = $value['related_id'];
        $wiki_title = get_the_title($wiki_id);
        $wiki_info = array('wiki_id' => $wiki_id, 'wiki_title' => $wiki_title);
        array_push($td_array, $wiki_info);
    }
    return $td_array;
}

//写入pro-->qa wiki->qa 关系.  -->在QA页面展示pro wiki
function writePWQA($post_id, $post_type, $related_id, $related_post_type)
{
    global $wpdb;
    $sql_1 = "SELECT * FROM wp_relation WHERE post_id=$post_id AND related_id=$related_id";
    $col = $wpdb->query($sql_1); //返回的结果有几行
    if ($col === 0) {  //如果没有这个pro<->wiki对
        $sql_2 = "INSERT INTO wp_relation VALUES ('',$post_id,'$post_type',$related_id,'$related_post_type')";
        $wpdb->get_results($sql_2);

        //add notice type3
        $noticeuser_id = get_post($post_id)->post_author;
        $notice_type = 3;
        $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
        $sql_add_notice = "INSERT INTO wp_notification VALUES ('',$noticeuser_id,$notice_type,'$related_id',0,'$current_time')";
        $wpdb->get_results($sql_add_notice);
    }
}

//在qa页面展示来自项目or wiki 返回来自哪个post的info
function qaComeFrom($qa_id)
{
    global $wpdb;
    $post_id = $wpdb->get_var($wpdb->prepare("SELECT * FROM wp_relation WHERE related_id=$qa_id;", ""), 1, 0);
    $post_type = $wpdb->get_var($wpdb->prepare("SELECT * FROM wp_relation WHERE related_id=$qa_id;", ""), 2, 0);
    $related_info = array('id' => $post_id, 'post_type' => $post_type);
    return $related_info;
}


//返回此项目对用的所有问答  -->在项目和wiki页面的comment中显示QA
function pwRelatedQA($pro_id)
{
    global $wpdb;
    $qa_id = array();
    $sql = "SELECT * FROM wp_relation WHERE post_id=$pro_id AND related_post_type='dwqa-question'";
    $result = $wpdb->get_results($sql);
    foreach ($result as $key => $value) {
        $related_id[] = $value->related_id;
        array_push($qa_id, $related_id[$key]);
    }
    return $qa_id;
}

//获取问题的作者id和name,为wiki和project评论中的问题服务(pwRelatedQA())
function Spark_get_author($qa_id)
{
    global $wpdb;
    $author_id = $wpdb->get_var($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID=$qa_id", ""), 1, 0);
    $author_name = $wpdb->get_var($wpdb->prepare("SELECT * FROM $wpdb->users WHERE ID=$author_id", ""), 1, 0);
    $author_info = array('id' => $author_id, 'name' => $author_name);
    return $author_info;
}

//wiki侧边栏显示相关的项目
function wikiRelatedPro($wiki_id)
{
    global $wpdb;
    $post_id = array(); //项目id
    $sql = "SELECT * FROM wp_relation WHERE related_id=$wiki_id AND post_type='post'";
    $result = $wpdb->get_results($sql);
    foreach ($result as $key => $value) {
        $pro_id[] = $value->post_id;
        array_push($post_id, $pro_id[$key]);
    }
    return $post_id;
}

//获取项目的相似项目
function related_project()
{
    $post_num = 5;/*展示的项目数*/
    $exclude_id = get_the_ID();
    $posttags = get_the_tags();
    $i = 0;
    if ($posttags) {
        $tags = '';
        foreach ($posttags as $tag) $tags .= $tag->term_id . ',';
        $args = array(
            'post_status' => 'publish',
            'tag__in' => explode(',', $tags),
            'post__not_in' => explode(',', $exclude_id),
            'caller_get_posts' => 1,
            'orderby' => 'rand',
            'posts_per_page' => $post_num
        );
        query_posts($args);
        while (have_posts()) {
            the_post(); ?>
            <li class="list-group-item">
                <div style="display: inline;">
                    <?php
                    if (has_post_thumbnail()) { ?>
                        <a href="<?php the_permalink(); ?>" target="_blank"><img
                                src="<?php the_post_thumbnail_url('30') ?>" class="cover" height="50px"
                                width="90px"/></a>
                    <?php } else { ?>
                        <a href="<?php the_permalink(); ?>" target="_blank"><img
                                src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面"
                                style="width: 90px;height: 50px" class="cover"/></a>
                    <?php } ?>
                </div>
                <div style="width: 63%;float: right;">
                    <a href="<?php echo get_permalink(); ?>" style="word-wrap: break-word;word-break: break-all"
                       class="question-title"><?php echo get_the_title(); ?></a>
                </div>
            </li>
            <?php
            $exclude_id .= ',' . $post_id;
            $i++;
        }
        wp_reset_query();
    }
//    同标签项目数量不足从分类中获取
    if ($i < $post_num) {
        $cats = '';
        foreach (get_the_category() as $cat) $cats .= $cat->cat_ID . ',';
        $args = array(
            'category__in' => explode(',', $cats),
            'post__not_in' => explode(',', $exclude_id),
            'caller_get_posts' => 1,
            'orderby' => 'rand',
            'posts_per_page' => $post_num - $i
        );
        query_posts($args);
        while (have_posts()) {
            the_post(); ?>
            <li class="list-group-item">
                <div style="display: inline;">
                    <?php
                    if (has_post_thumbnail()) { ?>
                        <a href="<?php the_permalink(); ?>" target="_blank"><img
                                src="<?php the_post_thumbnail_url('30') ?>" class="cover" height="50px"
                                width="90px"/></a>
                    <?php } else { ?>
                        <a href="<?php the_permalink(); ?>" target="_blank"><img
                                src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面"
                                style="width: 90px;height: 50px" class="cover"/></a>
                    <?php } ?>
                </div>
                <div style="width: 63%;float: right;">
                    <a href="<?php echo get_permalink(); ?>" style="word-wrap: break-word;word-break: break-all"
                       class="question-title"><?php echo get_the_title(); ?></a>
                </div>
            </li>
            <?php $i++;
        }
        wp_reset_query();
    }
    if ($i == 0) echo '<p>没有相似项目!</p>';
}

//建立用户轨迹表
function user_history_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "user_history";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          user_action varchar(20) NOT NULL,
		  action_post_id int NOT NULL,
		  action_post_type varchar(20) NOT NULL,
		  action_time datetime NOT NULL
          );";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//写入用户浏览数据
function writeUserTrack()
{
    global $wpdb;
    $post_id = $_SESSION['post_id'];
    $post_type = $_SESSION['post_type'];
    $user_action = $_SESSION['action'];
    $user_id = $_SESSION['user_id'];
    $timestamp = $_SESSION['timestamp'];
    session_destroy();
    if ($user_id != 0) {
        $sql = "INSERT INTO wp_user_history VALUES ('',$user_id,'$user_action',$post_id,'$post_type','$timestamp')";
        $wpdb->get_results($sql);
    }
}


//建立用户收藏表
function favorite_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "favorite";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
		  favorite_post_id int NOT NULL,
		  favorite_post_type varchar(20) NOT NULL,
		  favorite_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//处理添加favorite操作
function addFavorite()
{
    global $wpdb;
    $user_id = $_POST['userID'];
    $post_id = $_POST['postID'];
    $post_type = get_post_type($post_id);
    $time = date("Y-m-d H:i:s", time() + 8 * 3600);
    if (!ifFavorite($user_id, $post_id)) {
        $sql = "INSERT INTO wp_favorite VALUES ('',$user_id,$post_id,'$post_type','$time')";
        $wpdb->get_results($sql);
        //加积分
        global $integral_system;
        $author = get_post($post_id)->post_author;
        add_user_integral($author, $integral_system['get_favorite']);

        die();
    }

}

add_action('wp_ajax_addFavorite', 'addFavorite');
add_action('wp_ajax_nopriv_addFavorite', 'addFavorite');


function cancelFavorite()
{
    global $wpdb;
    $user_id = $_POST['userID'];
    $post_id = $_POST['postID'];
    $sql = "DELETE FROM wp_favorite WHERE user_id=$user_id AND favorite_post_id=$post_id";
    $wpdb->query($sql);

    //加积分
    global $integral_system;
    $author = get_post($post_id)->post_author;
    cut_user_integral($author, $integral_system['get_favorite']);

    die();
}

add_action('wp_ajax_cancelFavorite', 'cancelFavorite');
add_action('wp_ajax_nopriv_cancelFavorite', 'cancelFavorite');

//判断该项目是否已被该用户收藏
function ifFavorite($user_id, $post_id)
{
    global $wpdb;
    $sql = "SELECT * FROM wp_favorite WHERE user_id=$user_id AND favorite_post_id=$post_id";
    $col = $wpdb->query($sql);
    if ($col == 0) {    //未收藏
        return false;
    } else { //已收藏
        return true;
    }
}

//个人页面展示项目favorite
function showFavorite($user_id)
{
    global $wpdb;
    $ret = array();
    $sql = "SELECT favorite_post_id FROM wp_favorite WHERE user_id=$user_id AND favorite_post_type='post'";
    $results = $wpdb->get_results($sql, "ARRAY_A");
    foreach ($results as $result) {
        array_push($ret, $result['favorite_post_id']);
    }
    return $ret;
}

//获取用户收藏的wiki
function get_user_favorite_wiki()
{
    global $wpdb;
    $wikis = array();
    $post_status = $_POST['get_wiki_type'];
    $user_id = $_POST['user_ID'];
    if ($post_status == "publish") {
        $sql = "SELECT favorite_post_id FROM wp_favorite WHERE user_id=$user_id AND favorite_post_type='yada_wiki'";
        $results = $wpdb->get_results($sql, 'ARRAY_A');
        foreach ($results as $result) {
            $sql_1 = "select * from $wpdb->posts where ID=" . $result['favorite_post_id'];
            $favorite_wikis_result = $wpdb->get_results($sql_1);
            foreach ($favorite_wikis_result as $item) {
                $wikis[] = $item;
            }
        }
    } else {
        echo "other";
    }
    $data = array(
        "wikis" => $wikis
    );
    echo json_encode($data);
    die();
}

add_action('wp_ajax_get_user_favorite_wiki', 'get_user_favorite_wiki');
add_action('wp_ajax_nopriv_get_user_favorite_wiki', 'get_user_favorite_wiki');


//建立用户打分表
function score_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "score";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          score int NOT NULL,
		  score_post_id int NOT NULL,
		  score_post_type varchar(20) NOT NULL,
		  score_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//添加用户打分
function addScore()
{
    global $wpdb;
    global $integral_system;
    $user_id = $_POST['userID'];
    $post_id = $_POST['postID'];
    $score = $_POST['score'];
    $post_type = get_post_type($post_id);
    $time = date("Y-m-d H:i:s", time() + 8 * 3600);
    $sql = "INSERT INTO wp_score VALUES ('',$user_id,$score,$post_id,'$post_type','$time')";
    $wpdb->get_results($sql);

    //加积分
    add_user_integral($user_id, $integral_system['grade']);
    if ($score >= 3) {
        $author = get_post($post_id)->post_author;
        add_user_integral($author, $integral_system['get_grade']);
    }
    die();
}

add_action('wp_ajax_addScore', 'addScore');
add_action('wp_ajax_nopriv_addScore', 'addScore');

//计算当前项目的评分
function calScore($post_id)
{
    global $wpdb;
    $sum = 0;
    $sql = "SELECT score FROM wp_score WHERE score_post_id = $post_id";
    $results = $wpdb->get_results($sql, "ARRAY_A");
    if (sizeof($results) == 0) {
        $scoreNum = 1;
    } else {
        $scoreNum = sizeof($results);
    }
    foreach ($results as $result) {
        $sum += $result['score'];
    }
    $scoreAverage = round($sum / $scoreNum, 1);
    $ret = array('score' => $scoreAverage, 'num' => sizeof($results));
    return $ret;
}

//判断用户是否已经评分
function hasScore($user_id, $post_id)
{
    global $wpdb;
    $sql = "SELECT * FROM wp_score WHERE user_id=$user_id AND score_post_id = $post_id";
    $col = $wpdb->query($sql);
    if ($col == 0) { //未打分
        return "true";
    } else {
        return "false";
    }
}

//收藏项目展示页 评论部分
function Spark_comments_popup_link($zero = false, $one = false, $more = false, $css_class = '', $none = false, $post_id)
{
    $id = $post_id;
    $title = get_the_title($post_id);
    $number = get_comments_number($id);

    if (false === $zero) {
        /* translators: %s: post title */
        $zero = sprintf(__('No Comments<span class="screen-reader-text"> on %s</span>'), $title);
    }

    if (false === $one) {
        /* translators: %s: post title */
        $one = sprintf(__('1 Comment<span class="screen-reader-text"> on %s</span>'), $title);
    }

    if (false === $more) {
        /* translators: 1: Number of comments 2: post title */
        $more = _n('%1$s Comment<span class="screen-reader-text"> on %2$s</span>', '%1$s Comments<span class="screen-reader-text"> on %2$s</span>', $number);
        $more = sprintf($more, number_format_i18n($number), $title);
    }

    if (false === $none) {
        /* translators: %s: post title */
        $none = sprintf(__('Comments Off<span class="screen-reader-text"> on %s</span>'), $title);
    }

    if (0 == $number && !comments_open($post_id) && !pings_open($post_id)) {
        echo '<span' . ((!empty($css_class)) ? ' class="' . esc_attr($css_class) . '"' : '') . '>' . $none . '</span>';
        return;
    }

    if (post_password_required()) {
        _e('Enter your password to view comments.');
        return;
    }

    echo '<a href="';   //链接
    $respond_link = the_permalink($post_id) . '#comments';
    echo apply_filters('respond_link', $respond_link, $id);
    echo '"';

    if (!empty($css_class)) {   //分类
        echo ' class="' . $css_class . '" ';
    }

    $attributes = '';
    /**
     * Filters the comments link attributes for display.
     *
     * @since 2.5.0
     *
     * @param string $attributes The comments link attributes. Default empty.
     */
    echo apply_filters('comments_popup_link_attributes', $attributes);
    echo '>';
    echo "&nbsp" . $number;  //显示数字
    echo '</a>';
}

//学习路径json生成
function jsonGenerate_old($user_id)
{
    //echo "function";
//    exec("python wp-content/themes/sparkUI/algorithm/sortWikiEntry.py",$output,$ret);
//    print_r($output);
//    if($ret==0){
//        echo "success";
//    }else{
//        echo "error";
//    }
    //生成知识图谱json串 格式按照test.json  只要 nodes:name,value,url,category  link category
    global $wpdb;
    $nodes = array();
    $links = array();
    $json = array();

    $sql = "SELECT DISTINCT action_post_id FROM wp_user_history WHERE user_id=$user_id";
    $results = $wpdb->get_results($sql, "ARRAY_A");
    foreach ($results as $key => $result) {
        if ($result['action_post_id'] != 0) {
            //nodes数据
            $sql_1 = "SELECT COUNT(*) FROM wp_user_history WHERE action_post_id=" . $result['action_post_id'];
            $value = $wpdb->get_var($sql_1, 0);  //获取每个节点的value
            $sql_2 = "SELECT post_title,post_type FROM $wpdb->posts WHERE ID=" . $result['action_post_id'];
            $temp = $wpdb->get_results($sql_2, "ARRAY_A");  //获取每个节点的name和类型

            //node中的category数据
            if ($temp[0]["post_type"] == "post") {
                $pre_node = array("name" => $temp[0]["post_title"], "value" => $value, "category" => 0, "url" => get_permalink($result['action_post_id']));
            } elseif ($temp[0]["post_type"] == "dwqa-question") {
                $pre_node = array("name" => $temp[0]["post_title"], "value" => $value, "category" => 1, "url" => get_permalink($result['action_post_id']));
            } elseif ($temp[0]["post_type"] == "yada_wiki") {
                $pre_node = array("name" => $temp[0]["post_title"], "value" => $value, "category" => 2, "url" => get_permalink($result['action_post_id']));
            } else {
                $pre_node = array("name" => $temp[0]["post_title"], "value" => $value, "category" => 3, "url" => get_permalink($result['action_post_id']));
            }
            array_push($nodes, $pre_node);
            //links数据
            $pre_links = array("target" => $key + 1, "source" => $key);
            array_push($links, $pre_links);
        }
    }
    $categories = array(
        array("name" => "项目"),
        array("name" => "问答"),
        array("name" => "wiki"),
        array("name" => "其他")
    );
    $pre_json = array("categories" => $categories, "nodes" => $nodes, "links" => $links);
    array_push($json, $pre_json);
    $jsonString = json_encode($pre_json);
    return $jsonString;
}

//通过python生成知识图谱底图
function jsonGenerate()
{
    exec("python wp-content/themes/sparkUI/algorithm/category.py", $output, $ret);
    if ($ret == 0) {
        return $output[0];
    } else {
        exec("python wp-content/themes/sparkUI/algorithm/category.py 2>&1", $output, $ret);
        return $output;
    }
}

//直接拿json文件做底
function readJson($file_name)
{
    $nodes = array();
    $links = array();
    $file_url = "wp-content/themes/sparkUI/algorithm/" . $file_name . ".json";
    $jsonString = file_get_contents($file_url);
    $jsonString = json_decode($jsonString, true);
    //nodes加工
    $temp_1 = array("itemStyle" =>
        array("normal" =>
            array("opacity" => 1)
        )
    );
    foreach ($jsonString["nodes"] as $key => $value) {
        $value += $temp_1;
        $value += array("id" => $key);
        array_push($nodes, $value);
    }
    $jsonString["nodes"] = $nodes;
    //links加工
    $temp_1 = array("lineStyle" =>
        array("normal" =>
            array("opacity" => 1)
        )
    );
    foreach ($jsonString["links"] as $key => $value) {
        $value += $temp_1;
        array_push($links, $value);
    }
    $jsonString["links"] = $links;

    $jsonString = json_encode($jsonString);
    //$jsonString = addUrl($jsonString);
    return $jsonString;
}

//项目知识图谱生成
function proSideJSONGenerte($user_id, $post_type)
{
    if ($post_type == "post") {
        $cat_id = 0;
    } elseif ($post_type == "qa") {
        $cat_id = 1;
    } elseif ($post_type == "yada_wiki") {
        $cat_id = 2;
    } else {
        $cat_id = 3;
    }
    $jsonString = jsonGenerate_old($user_id);
    $jsonArray = json_decode($jsonString, true);
    $nodes = array();
    $links = array();
    $categories = $jsonArray['categories'];
    foreach ($jsonArray['nodes'] as $key => $value) {
        if ($value['category'] == $cat_id) {
            $pre_node = array("name" => $value["name"], "value" => $value['value'], "category" => $cat_id, "url" => $value['url']);
            array_push($nodes, $pre_node);
            $pre_link = $jsonArray['links'][$key];
            array_push($links, $pre_link);
        }
    }
    $pre_json = array("categories" => $categories, "nodes" => $nodes, "links" => $links);
    $proJsonString = json_encode($pre_json);
    return $proJsonString;
}

//wiki图谱生成
function wikiSideJsonGenerate($post_id)
{
    /* Step1: 判断该wiki属于哪个类,实现:取出该post_id对应的wp_wiki_class表中的class
     * Step2: 把这个class explode
     * Step3: array_search
     * Step4: 分类(暂时分为四类) 每一类调用对应的json串
     * Step5: 如果不属于任何类,返回空串
     * */
    global $wpdb;
    $sql = "SELECT class FROM new_wiki WHERE wiki = '$post_id'";
    $result = $wpdb->get_var($wpdb->prepare($sql, 'ARRAY_A'), 0, 0);
    if ($result == "计算机") {
        $json = readJson('computer');
        $jsonString = addUrl($json);
    } elseif ($result == "通信") {
        $json = readJson('communication');
        $jsonString = addUrl($json);
    } elseif ($result == "电子") {
        $json = readJson('electron');
        $jsonString = addUrl($json);
    } elseif ($result == "人工智能") {
        $json = readJson('artificial');
        $jsonString = addUrl($json);
    } elseif ($result == "项目指导") {
        $json = readJson('course');
        $jsonString = addUrl($json);
    } else {
        $jsonString = "";
    }
    return $jsonString;
}


//node加工,加链接
function addUrl($jsonString)
{
    $nodes = array();
    $json = json_decode($jsonString, true);
    //加工
    foreach ($json["nodes"] as $key => $value) {
        $node_id = get_the_ID_by_title($value['name']);
        $temp = array("url" => get_permalink($node_id));
        $value += $temp;
//        $value +=array("id"=>$key);
        array_push($nodes, $value);
    }
    $json["nodes"] = $nodes;
    $jsonString = json_encode($json);
    return $jsonString;
}

//侧边栏路径生成
function wiki_path_select($name)
{
    $file_name = "example";
    $file_url = "wp-content/themes/sparkUI/algorithm/" . $file_name . ".json";
    $jsonString = file_get_contents($file_url);
    $jsonString = json_decode($jsonString, true);

    $nodes = array();
    $links = array();
    $path_part_result = new stdClass();

    array_push($nodes, array("name" => $name));
    foreach ($jsonString["links"] as $key => $value) {
        if ($value["source"] == $name) {
            array_push($links, $value);
            array_push($nodes, array("name" => $value["target"]));
        } else if ($value["target"] == $name) {
            array_push($links, $value);
            array_push($nodes, array("name" => $value["source"]));
        }
    }
    $path_part_result->nodes = $nodes;
    $path_part_result->links = $links;

    $path_part_result = json_encode($path_part_result);
    $path_part_result = addUrl($path_part_result);

    return $path_part_result;
}

//处理wiki和项目内容,请求API的版本
function keywordHighlight()
{
    //请求api后用
    $phrase = processContent(get_the_ID()); ?>
    <!--    <script>-->
    <!--        // 下面的方法失败了,并不能请求全部的字符,而且返回只能写jsonp-->
    <!--        $(function () {-->
    <!--            var request={-->
    <!--                apikey:'RHizNjRR',-->
    <!--                phrase:-->
    <!--            };-->
    <!--            $.ajax({-->
    <!--                url : "http://ebs.ckcest.cn/kb/elxml",-->
    <!--                data: request,-->
    <!--                type:'GET',-->
    <!--                dataType:'JSONP',-->
    <!--                crossDomain: true,-->
    <!--                success : function (data) {-->
    <!--                    console.log(data);-->
    <!--                }-->
    <!--            })-->
    <!--        })-->
    <!--    </script>-->


    <?php
    $url = 'http://ebs.ckcest.cn/kb/elxml?apikey=RHizNjRR&phrase=' . $phrase;
    $returnXML = file_get_contents($url);
    if (isXML($returnXML)) {
        $xml = simplexml_load_string($returnXML); //创建 SimpleXML对象 读字符串法
        $new_content = get_the_content();
        foreach ($xml->ENTITY->ITEM as $value) {
            $keyword = $value->NAME;    //所有关键词的名字
            $abstract = preg_replace("/\s*/", "", (string)$value->ABSTRACT->ITEM);  //去掉所有空格

            if ($abstract != "") {          //如果关键词有摘要
                $insteadString = "<a id=layer-" . $keyword . '>' . $keyword . '</a>'; //将文字替换成为链接
                //new_content处理,
                $pattern = "#(?=[^>]*(?=<(?!/a>)|$))" . $keyword . "#";
                $new_content = preg_replace($pattern, $insteadString, $new_content, 1);
            } ?>
            <script>
                $(function () {
                    $("#layer-<?=$keyword?>").on('mouseover', function () {
                        layer.tips("<?php echo $abstract?>", '#layer-<?=$keyword?>',
                            {
                                tips: [1, "black"]    //位置和颜色                });
                            })
                    })
                });
            </script>
        <?php }
    } else {
        $new_content = get_the_content();
    }
    echo $new_content;
//        $url = get_template_directory_uri()."/highlight.xml";
//        $xml = simplexml_load_file($url); //创建 SimpleXML对象
//        print_r($xml);
//        $new_content = get_the_content();  //初始字符串是原文内容
//        foreach ($xml->ENTITY->ITEM as $value){
//            $keyword = $value->NAME;    //所有关键词的名字
//            $abstract = preg_replace("/\s*/","",(string)$value->ABSTRACT->ITEM);  //去掉所有空格
//            if($abstract!=""){          //如果关键词有摘要
//                $insteadString = "<a id=layer-".$keyword.'>'.$keyword.'</a>';
//                $firstPos = strpos((string)$new_content,(string)$keyword);
//                $new_content = substr_replace($new_content,$insteadString,$firstPos,strlen($keyword));
//                //$new_content = str_replace($keyword,$insteadString,$new_content,$count);
//            }
//        }
//        //$new_content = get_the_content();
//        echo $new_content;
}

//处理wiki和项目内容,从数据库取出xml文件版本
function keywordHighlight_update()
{
    //更新后从数据库提取xml文件
    /* step1: 从数据库提出当前项目的xml 格式转化成为xml object
     * step2: foreach $keyword
     * */
    $new_content = get_the_content();
    global $wpdb;
    $xmlsql = "SELECT xml_string FROM wp_xml WHERE post_id =" . get_the_ID();
    $returnXML = $wpdb->get_results($xmlsql);
    for ($i = 0; $i < sizeof($returnXML); $i++) {

        $xml[$i] = @simplexml_load_string($returnXML[$i]->xml_string); //创建 SimpleXML对象 读字符串法
        if ($xml[$i]->ENTITY->ITEM != NULL) {
            foreach ($xml[$i]->ENTITY->ITEM as $value) {
                $keyword = $value->NAME;    //所有关键词的名字
                $abstract = preg_replace("/\s*/", "", (string)$value->ABSTRACT->ITEM);  //去掉所有空格
                if ($abstract != "") {          //如果关键词有摘要
                    $insteadString = "<a id=layer-" . $keyword . '>' . $keyword . '</a>'; //将文字替换成为链接
                    $pattern = "#(?=[^>]*(?=<(?!/a>)|$))" . $keyword . "#";
                    //new_content处理,
                    $new_content = preg_replace($pattern, $insteadString, $new_content, 1);   //小bug 第二轮,第三轮的时候也厚替换第一个词
//                $firstPos = strpos((string)$new_content,(string)$keyword);      //获取第一次出现位置
//                $new_content = substr_replace($new_content,$insteadString,$firstPos,strlen($keyword)); //替换一次
//                $new_content = str_replace($keyword,$insteadString,$new_content,$count);//替换所有
                }
                //ajax的参数
                $current_user = wp_get_current_user();
                $admin_url = admin_url('admin-ajax.php');
                $post_id = get_the_ID_by_title($keyword);
                $keyword_url = get_permalink($post_id);
                ?>
                <script>
                    $(function () {
                        $("#layer-<?=$keyword?>").css({"color": "#3194d0", "cursor": "pointer"})
                            .on('mouseover', function () {
                                var html = '<div id="directFavorite-<?=$keyword?>">' +
                                    '<span class="glyphicon glyphicon-star-empty"></span>' +
                                    '</div>' +
                                    '<div class="divline" style="margin-top:0px"></div>' +
                                    '<?=$abstract?>';
                                layer.tips(html, '#layer-<?=$keyword?>',
                                    {
                                        tips: [1, "black"],   //位置和颜色
                                        success: clickEvent()
                                    });
                            });

                        function clickEvent() {
                            $("#directFavorite-<?=$keyword?>").on('click', function () {
                                this.html('<span class="glyphicon glyphicon-star"></span>');
                            });
                            $(document).on('click', '#directFavorite-<?=$keyword?>', function () {
                                $("#directFavorite-<?=$keyword?>").html('<span class="glyphicon glyphicon-star"></span>');
                                if ('<?=$post_id?>' == '') {
                                    layer.msg('还没有该词条,无法收藏', {time: 5000, icon: 2});
                                } else {
                                    var data = {
                                        action: 'addFavorite',
                                        userID: '<?=$current_user->ID?>',
                                        postID: '<?=$post_id?>'
                                    };
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo $admin_url;?>",
                                        data: data,
                                        success: function () {
                                            layer.msg('收藏成功', {time: 2000, icon: 1});  //layer.msg(content, {options}, end) - 提示框
                                        },
                                        error: function () {
                                            alert("收藏失败");
                                        }
                                    });
                                }
                            });
                            $("#layer-<?=$keyword?>").click(function () {  //跳转到该词条
                                if ('<?=$post_id?>' == '') {
                                    layer.msg('还没有该词条,无法跳转', {time: 5000, icon: 2});
                                } else {
                                    location.href = '<?=$keyword_url?>';
                                }
                            });
                        }
                    })
                </script>
            <?php }
        }
    }
    echo $new_content;
}

//建立关键词信息表
function xml_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "xml";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          post_id int NOT NULL,
          post_type varchar(20) NOT NULL,
          xml_string longtext NOT NULL,
          modified_time datetime NOT NULL,
          section_id tinyint default 1
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//timer中更新的项目的关键词内容
function updateContentItem($post_type)
{
    //更新数据库中的xml串(暂时只有项目) 在timer中手动更新
    /* step1: 选出所有项目的id post_type和modified_time
     * step2: 判断xml表中是否有改post_id,若有,则查看posts中的modefiedtime和xml中的modifiedtime哪个更近。
     * step3: 若在修改后没有刷新过,则请求新的xml文件 (必要时要截取原串)
     * step4: 将新的xml文件存入数据库
     * step5: 在keywordHighlight()中提取xml;
     * */
    //step1
    global $wpdb;
    $sql = "SELECT ID, post_modified FROM $wpdb->posts WHERE post_type='$post_type' and post_status ='publish'";
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    //step2
    foreach ($results as $result) {
        $sql_1 = "SELECT post_id, modified_time FROM wp_xml WHERE post_id=" . $result['ID'];
        $col = $wpdb->get_results($sql_1, "ARRAY_A");
        if (sizeof($col) != 0) {    //xml表总是否已经有这个项目的xml,如果有
            $flag = strtotime($col[0]["modified_time"]) - strtotime($result['post_modified']);
            if ($flag < 0) { // 项目内容有了新的修改 否则不做任何操作。
                echo "执行一次update" . $result['ID'] . "<br>";
                updateXML($result['ID']);
            }
        } else {//如果xml表没有这个post_id, 执行step3.  在新增项目那里可以执行这个函数。
            echo "执行一次insert" . $result['ID'] . "<br>";
            insertContentItem($result['ID']);
        }
    }
//    for($i=340;$i<375;$i++){  //目前到这里了,这十组全是error
//        $sql_1 = "SELECT post_id, modified_time FROM wp_xml WHERE post_id=".$results[$i]['ID'];
//        $col = $wpdb->get_results($sql_1,"ARRAY_A");
//        if(sizeof($col)!=0){    //xml表总是否已经有这个项目的xml,如果有
//            $flag = strtotime($col[0]["modified_time"])-strtotime($results[$i]['post_modified']);
//            if($flag>0){        // 项目内容有了新的修改 否则不做任何操作。
//                echo "执行一次update".$results[$i]['ID']."<br>";
//                updateXML($results[$i]['ID']);
//            }
//        }
//        else{//如果xml表没有这个post_id, 执行step3.  在新增项目那里可以执行这个函数。
//            echo "执行一次insert".$results[$i]['ID']."<br>";
//            insertContentItem($results[$i]['ID']);
//        }
//    }
}

//新增xml中的一行  在发布项目那里可以调用一次
function insertContentItem($post_id)
{
    global $wpdb;
    $phrase = processContent($post_id);   //现在变成了一个数组
    $length = sizeof($phrase);
    for ($i = 0; $i < $length; $i++) {
        $url = 'http://ebs.ckcest.cn/kb/elxml?apikey=RHizNjRR&phrase=' . $phrase[$i];
        $returnXML = @file_get_contents($url);
        if (isXML($returnXML)) {
            $post_type = get_post_type($post_id);
            $modified_time = date("Y-m-d H:i:s", time() + 8 * 3600);
            $sql = "INSERT INTO wp_xml VALUES ('',$post_id,'$post_type','$returnXML','$modified_time',$i)";
            $wpdb->get_results($sql);
        } else {
            echo "error" . "<br>";
        }
        sleep(5);
    }
}

//更新xml中的一行
function updateXML($post_id)
{
    global $wpdb;
    $phrase = processContent($post_id);
    $length = sizeof($phrase);
    for ($i = 0; $i < $length; $i++) {
        $url = 'http://ebs.ckcest.cn/kb/elxml?apikey=RHizNjRR&phrase=' . $phrase[$i];
        $returnXML = @file_get_contents($url);
        if (isXML($returnXML)) {
            $modified_time = date("Y-m-d H:i:s", time() + 8 * 3600);
            //判断表中是否已有section1,2…… 若有,执行update,若没有,执行insert
            if (hasSection($post_id, $i) == 1) {
                $sql_update = "update wp_xml set xml_string = '$returnXML',modified_time = '$modified_time' WHERE section_id= $i and post_id=" . $post_id;
                $wpdb->get_results($sql_update);
            } else {
                $post_type = get_post_type($post_id);
                $sql_insert = "INSERT INTO wp_xml VALUES ('',$post_id,'$post_type','$returnXML','$modified_time',$i)";
                $wpdb->get_results($sql_insert);
            }
        } else {
            echo "error" . "<br>";
        }
        sleep(5);
    }
}

//判断表中是否已经有section1,2,3.。。
function hasSection($post_id, $section_id)
{
    global $wpdb;
    $sql = "SELECT * FROM wp_xml WHERE post_id = $post_id and section_id = $section_id";
    $col = $wpdb->query($sql);
    if ($col == 0) {
        return false;
    } else {
        return true;
    }
}

function xml_backup_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "xml";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          post_id int NOT NULL,
          post_type varchar(20) NOT NULL,
          xml_string longtext NOT NULL,
          modified_time datetime NOT NULL,
          section_id tinyint default 1
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}


//判断返回是否是XML
function isXML($str)
{
    $pattern = "/^\<\?xml/";
    if (preg_match($pattern, $str)) {
        return true;
    } else {
        return false;
    }
}

//处理每个项目的内容,生成调取api的phrase
function processContent($post_id)
{
    $post_type = get_post_type($post_id);
    if ($post_type = 'post') {
        $phrase_arr = array();
        $phrase = get_the_content_by_id($post_id);
        $phrase = preg_replace("#\"*\'*#", "", $phrase); //去掉" '
        $phrase = preg_replace("/\s*/", "", $phrase);  //去掉空格
        $phrase = preg_replace("#<hr[^>]+>#", "", $phrase);  //去掉分割线
        $phrase = preg_replace("/\<h[^\>]*?>.*?\<\/h[^\>]*?>/", "", $phrase); //去掉标题
        $phrase = preg_replace("/\<a[^\>]*?>.*?\<\/a[^\>]*?>/", "", $phrase); //去掉链接
        $phrase = preg_replace("/\<pre\>*?>.*?\<\/pre\>*?>/", "", $phrase); //去掉代码
        $phrase = strip_tags($phrase);  //去掉其他标签
        //添加长的文章
        $length = mb_strlen($phrase, 'utf-8');
        $total_section = ceil($length / 650);//共有几个section
        echo $length . "   " . $total_section . "<br>";
        for ($i = 0; $i < $total_section; $i++) {
            array_push($phrase_arr, mb_substr($phrase, $i * 650, $i + 650, "utf-8"));
        }
    } else { //wiki
        $phrase_arr = array();
        $phrase = get_the_content_by_id($post_id);
        $phrase = preg_replace("#\"*\'*#", "", $phrase); //去掉" '
        $phrase = preg_replace("/\s*/", "", $phrase);  //去掉空格
        $phrase = preg_replace("#<hr[^>]+>#", "", $phrase);  //去掉分割线
        $phrase = preg_replace("/\<h[^\>]*?>.*?\<\/h[^\>]*?>/", "", $phrase); //去掉标题
        $phrase = preg_replace("/\<a[^\>]*?>.*?\<\/a[^\>]*?>/", "", $phrase); //去掉链接
        $phrase = preg_replace("/\<pre\>*?>.*?\<\/pre\>*?>/", "", $phrase); //去掉代码
        $phrase = strip_tags($phrase);  //去掉其他标签
        //添加长的文章
        $length = mb_strlen($phrase, 'utf-8');
        $total_section = ceil($length / 650);//共有几个section
        echo $length . "   " . $total_section . "<br>";
        for ($i = 0; $i < $total_section; $i++) {
            array_push($phrase_arr, mb_substr($phrase, $i * 650, $i + 650, "utf-8"));
        }
    }

    //$phrase = mb_substr($phrase,0,650,"utf-8");
    return $phrase_arr;
}

//通过post_id获取post内容。
function get_the_content_by_id($post_id)
{
    global $wpdb;
    $sql = "SELECT post_content FROM $wpdb->posts WHERE ID=$post_id";
    $result = $wpdb->get_results($sql);
    return $result[0]->post_content;
}

//通过post_title获取post_id()
function get_the_ID_by_title($post_title)
{
    global $wpdb;
    $sql = "SELECT ID FROM $wpdb->posts WHERE post_title='$post_title' AND post_status = 'publish' AND (post_type='yada_wiki' or post_type='page')";
    $result = $wpdb->get_results($sql);
    if (sizeof($result) != 0) {
        return $result[0]->ID;
    } else {
        $sql_m = "SELECT ID FROM $wpdb->posts WHERE post_title like '%$post_title%' AND post_status = 'publish' AND (post_type='yada_wiki' or post_type='page')";
//        return $sql;
        $result_m = $wpdb->get_results($sql_m);
        if (sizeof($result_m) != 0) {
            return $result_m[0]->ID;
        } else {
            return 0;
        }

    }

}

//建立实体表
function entity_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "entity";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          entity_name text NOT NULL,
          entity_category text NOT NULL,
          entity_label text NOT NULL,
          abstract longtext,
          wiki_id int,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//将xml表中的实体提取出来,在实体表中插入数据
function updateInsertEntity()
{
    global $wpdb;
    //step1:取出有xml的所有post_id
    $xmlsql = "SELECT DISTINCT post_id FROM wp_xml";
    $post_id_arr = $wpdb->get_results($xmlsql, 'ARRAY_A');
    foreach ($post_id_arr as $value) {
        insertEntity($value['post_id']);
    }
}

//处理每一个xml串
function insertEntity($post_id)
{
    global $wpdb;
    //step1:取出xml字符串
    $xmlsql = "SELECT xml_string FROM wp_xml WHERE post_id =" . $post_id;
    $returnXML = $wpdb->get_results($xmlsql);
    for ($i = 0; $i < sizeof($returnXML); $i++) {
        $xml[$i] = simplexml_load_string($returnXML[$i]->xml_string); //创建 SimpleXML对象 读字符串法
        //step2:处理xml字符串
        if ($xml[$i]->ENTITY->ITEM != NULL) {
            foreach ($xml[$i]->ENTITY->ITEM as $value) {
                $entity_name = $value->NAME;
                if (isNewEntity($entity_name)) {
                    $entity_category = "";
                    $entity_label = "";
                    for ($i = 0; $i < 3; $i++) {
                        $entity_category .= $value->CATEGORY->ITEM[$i] . ",";
                        $entity_label .= $value->LABEL->ITEM[$i] . ",";
                    }
                    $abstract = preg_replace("/\s*/", "", (string)$value->ABSTRACT->ITEM);  //去掉所有空格
                    $sql_wiki = "SELECT ID FROM $wpdb->posts WHERE post_type='yada_wiki' and post_status='publish' and post_title='" . $entity_name . "'";
                    $wiki_id = $wpdb->get_results($sql_wiki, 'ARRAY_A')[0]['ID'];
                    $modified_time = date("Y-m-d H:i:s", time() + 8 * 3600);
                    $sql = "insert into wp_entity VALUES ('','$entity_name','$entity_category','$entity_label','$abstract','$wiki_id','$modified_time')";
                    $wpdb->get_results($sql);
                }
            }
        }
    }
}

//判断是否是已经在表中的实体
function isNewEntity($entity_name)
{
    global $wpdb;
    $sql = "SELECT ID from wp_entity WHERE entity_name='$entity_name'";
    $col = $wpdb->query($sql);
    if ($col == 0) {
        return true;
    } else {
        return false;
    }
}


/*下面一系列函数为群组相关函数
 * 获取所有的群组信息,若无群组id则取所有的群组get_group($id = null)
 * 获取群组的任务信息 变量为群组id,若无taskid则去全部的任务。get_task($group_id,$id=null)
 * 获取该群组的所有任务信息 变量为task_id。 get_task_group($id)
 * 头像适配大小函数get_group_avatar() 返回值为<img>
 * 判断用户是否为群组管理员 is_group_admin()
 * 判断成员是否是这个群组的成员 is_group_member()
 *
 *
 * */
//建立任务表
function gp_task_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "gp_task";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          task_name text NOT NULL,
          task_author int NOT NULL,
          belong_to int NOT NULL,
          task_content longtext NOT NULL,
          task_status text NOT NULL,
          task_type text NOT NULL,
          create_date datetime NOT NULL,
          deadline datetime NOT NULL,
          complete_count int NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//建立群组表
function gp_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "gp";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          group_name text NOT NULL,
          group_author int NOT NULL,
          group_abstract longtext NOT NULL,
          group_status text NOT NULL,
          publish_status text NOT NULL,
          group_cover text NOT NULL,
          join_permission text NOT NULL,
          task_permission text NOT NULL,
          create_date datetime NOT NULL,
          member_count int NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//建立任务验证表
function gp_verify_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "gp_verify";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          verify_id int NOT NULL,
          verify_type text NOT NULL,
          verify_content longtext NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//建立群组成员表
function gp_member_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "gp_member";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          group_id int NOT NULL,
          indentity text NOT NULL,
          join_date datetime NOT NULL,
          verify_info text ,
          member_status int NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//建立成员临时审核表
function gp_member_verify_tmp_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "gp_member_verify_tmp";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          group_id int NOT NULL,
          apply_time datetime NOT NULL,
          verify_info text
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//建立成员-任务关系表
function gp_task_member_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "gp_task_member";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          task_id int NOT NULL,
          completion int NOT NULL default 0,
          complete_time datetime NOT NULL,
          apply_content text,
          remark text,
          team_id int 
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//建立成员-团队表
function gp_member_team_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "gp_member_team";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          task_id int NOT NULL,
          team_id int NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//建立任务完成tmp表,针对reading任务
function gp_task_complete_tmp_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "gp_task_complete_tmp";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          task_id int NOT NULL,
          complete_content text NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//建立群组通知表
function gp_notice_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "gp_notice";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          group_id int NOT NULL,
          notice_type int NOT NULL,
          notice_content text NOT NULL,
          notice_status int NOT NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//建立私信表
function pmessage_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "pmessage";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          from_id int NOT NULL,
          to_id int NOT NULL,
          content text NOT NULL,
          message_status int NOT NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//建立通知表
function notice_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "notification";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          notice_type int NOT NULL,
          notice_content text NOT NULL,
          notice_status int NOT NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//判断群组是否重名
function checkGroupName()
{
    global $wpdb;
    $groupName = isset($_POST['groupName']) ? $_POST['groupName'] : "";
    $nowGroupName = isset($_POST['nowGroupName']) ? $_POST['nowGroupName'] : "";
    if ($nowGroupName != '') {
        if ($groupName == $nowGroupName) {
            $response = true;
        } else {
            if ($groupName != '') {
                $sql = "SELECT ID FROM wp_gp WHERE group_name = '$groupName'";
                $col = $wpdb->query($sql);
                if ($col == 0) {
                    $response = true;
                } else {
                    $response = false;
                }
            } else {
                $response = false;
            }
        }
    } elseif ($groupName != '') {
        $sql = "SELECT ID FROM wp_gp WHERE group_name = '$groupName'";
        $col = $wpdb->query($sql);
        if ($col == 0) {
            $response = true;
        } else {
            $response = false;
        }
    } else {
        $response = false;
    }
    echo $response;
    exit();
}

add_action('wp_ajax_checkGroupName', 'checkGroupName');
add_action('wp_ajax_nopriv_checkGroupName', 'checkGroupName');

//获取所有的群组信息,若无群组id则取所有的群组
function get_group($id = null)
{
    global $wpdb;
    if ($id != null) {
        $sql = "SELECT * FROM wp_gp WHERE ID = $id";
    } else {
        $sql = "SELECT * FROM wp_gp";
    }
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    return $results;
}

//获取群组的任务信息 变量为群组id,若无taskid则去全部的任务。
function get_task($group_id, $id = null)
{
    global $wpdb;
    if ($id != null) {   //
        $sql = "SELECT * FROM wp_gp_task WHERE ID = $id AND belong_to = $group_id and task_status = 'publish'";
    } else {
        $sql = "SELECT * FROM wp_gp_task WHERE belong_to=$group_id and task_status = 'publish'";
    }
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    return $results;
}

//获取该群组的所有任务信息 变量为task_id
function get_task_group($id)
{
    global $wpdb;
    $sql = "SELECT belong_to FROM wp_gp_task WHERE ID = $id";
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    return $results[0]['belong_to'];
}

//判断用户是否为群组管理员  在显示管理员哪里用?
function is_group_admin($group_id, $user_id = NULL)
{
    global $wpdb;
    if ($user_id == NULL) {
        $user_id = get_current_user_id();
    }
    $sql = "SELECT * from wp_gp_member 
            WHERE user_id = $user_id and group_id = $group_id and indentity='admin' and member_status=0";
    $col = $wpdb->query($sql);
    if ($col != 0) {
        return true;
    } else {
        return false;
    }
}

//判断成员是否是这个群组的成员
function is_group_member($group_id, $user_id = Null)
{
    global $wpdb;
    if ($user_id == NULL) {
        $user_id = get_current_user_id();
    }
    $sql = "SELECT indentity from wp_gp_member WHERE user_id = $user_id and group_id = $group_id and member_status=0";
    $col = $wpdb->query($sql);
    if ($col != 0) {
        return true;
    } else {
        return false;
    }
}

//获取当前用户加入的所有群组
function get_current_user_group()
{
    global $wpdb;
    $joined_group = array();
    $user_id = get_current_user_id();
    $sql = "SELECT group_id FROM wp_gp_member WHERE user_id = $user_id and member_status = 0";
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    foreach ($results as $value) {
        $group_info = get_group($value['group_id']);
        array_push($joined_group, $group_info[0]);
    }
    return $joined_group;
}

//ajax 加入群组  逻辑需要重新梳理
function join_the_group()
{
    global $wpdb;
    $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : "";
    $user_id = get_current_user_id();
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    $admin_id_arr = get_group_member($group_id)['admin'];
    //判断验证方式
    if ($group_id != "") {
        $verify_type = get_verify_type($group_id);
        if ($verify_type == "freejoin") {
            //看这个人是第几次加入了,初次加入,执行insert,退出又加入,执行update
            $sql_count = "Select * From wp_gp_member WHERE user_id=$user_id and group_id=$group_id";
            $col = $wpdb->query($sql_count);
            if ($col == 0) {
                $sql_member = "INSERT INTO wp_gp_member VALUES ('',$user_id,$group_id,'member','$current_time','',0)";
                $wpdb->get_results($sql_member);

                //==============notice================
                foreach ($admin_id_arr as $admin) {
                    $admin_id = $admin['user_id'];

                    $sql_has_notice = "SELECT ID FROM wp_gp_notice WHERE user_id = $admin_id and group_id = $group_id
                        and notice_type = 1 and notice_content = '$user_id'";
                    $col = $wpdb->query($sql_has_notice);
                    if ($col == 0) {
                        $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$admin_id,$group_id,1,'$user_id',0,'$current_time')";
                        $wpdb->get_results($sql_add_notice);
                    } else {
                        $sql_update_notice = "update wp_gp_notice set modified_time = '$current_time',notice_status = 0 
                                    WHERE user_id = $admin_id and group_id = $group_id and notice_type = 1 and notice_content = '$user_id'";
                        $wpdb->get_results($sql_update_notice);
                    }
                }
            } else {
                $sql_member = "update wp_gp_member set member_status = 0 WHERE user_id = $user_id and group_id = $group_id";
                $wpdb->get_results($sql_member);

                //==============notice================
                foreach ($admin_id_arr as $admin) {
                    $admin_id = $admin['user_id'];

                    $sql_has_notice = "SELECT ID FROM wp_gp_notice WHERE user_id = $admin_id and group_id = $group_id
                        and notice_type = 1 and notice_content = '$user_id'";

                    $col = $wpdb->query($sql_has_notice);
                    if ($col == 0) {
                        $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$admin_id,$group_id,1,'$user_id',0,'$current_time')";
                        $wpdb->get_results($sql_add_notice);
                    } else {
                        $sql_update_notice = "update wp_gp_notice set modified_time = '$current_time',notice_status = 0 
                                    WHERE user_id = $admin_id and group_id = $group_id and notice_type = 1 and notice_content = '$user_id'";
                        $wpdb->get_results($sql_update_notice);
                    }
                }
            }

            $sql_add_count = "update wp_gp set member_count = (member_count+1) WHERE ID = $group_id";
            $wpdb->get_results($sql_add_count);

            rongCloudJoinGroup2($user_id, $group_id);
            $response = "freejoin";
        } elseif ($verify_type == "verify") {
            //等待验证即可,将其存入tmp表
            $sql_member = "INSERT INTO wp_gp_member_verify_tmp VALUES ('',$user_id,$group_id,'$current_time','')";
            $wpdb->get_results($sql_member);

            $response = "verify";
        } else {
            //先弹出框框,填写好字段,然后将字段值存入tmp表
//            //==============notice================
//            foreach ($admin_id_arr as $admin) {
//                $admin_id = $admin['user_id'];
//                //判断是否有这个通知
//                $sql_has_notice = "SELECT ID FROM wp_gp_notice WHERE user_id = $admin_id and group_id = $group_id
//                        and notice_type = 3 and notice_content = '$user_id'";
//                $col =  $wpdb->query($sql_has_notice);
//                if($col==0){
//                    $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$admin_id,$group_id,3,'$user_id',0,'$current_time')";
//                    $wpdb->get_results($sql_add_notice);
//                }else{
//                    $sql_update_notice = "update wp_gp_notice set modified_time = '$current_time',notice_status = 0
//                                    WHERE user_id = $admin_id and group_id = $group_id and notice_type = 3 and notice_content = '$user_id'";
//                    $wpdb->get_results($sql_update_notice);
//                }
//            }
            $response = "verifyjoin";
        }
    }
    echo $response;
    die();
}

add_action('wp_ajax_join_the_group', 'join_the_group');
add_action('wp_ajax_nopriv_join_the_group', 'join_the_group');

//ajax 退出群组
function quit_the_group()
{
    global $wpdb;
    $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : "";
    $admin_id_arr = get_group_member($group_id)['admin'];
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    if ($group_id != "") {
        $user_id = get_current_user_id();
        $sql_member = "update wp_gp_member set member_status = 1 WHERE user_id = $user_id and group_id = $group_id";
        $wpdb->get_results($sql_member);
        $sql_cut_count = "update wp_gp set member_count = (member_count-1) WHERE ID = $group_id";
        $wpdb->get_results($sql_cut_count);

        rongCloudQuitGroup2($user_id, $group_id);
        //==============notice================
        foreach ($admin_id_arr as $admin) {
            $admin_id = $admin['user_id'];
            //判断是否有这个通知
            $sql_has_notice = "SELECT ID FROM wp_gp_notice WHERE user_id = $admin_id and group_id = $group_id
                        and notice_type = 2 and notice_content = '$user_id'";
            $col = $wpdb->query($sql_has_notice);
            if ($col == 0) {
                $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$admin_id,$group_id,2,'$user_id',0,'$current_time')";
                $wpdb->get_results($sql_add_notice);
            } else {
                $sql_update_notice = "update wp_gp_notice set modified_time = '$current_time',notice_status = 0 
                                    WHERE user_id = $admin_id and group_id = $group_id and notice_type = 2 and notice_content = '$user_id'";
                $wpdb->get_results($sql_update_notice);
            }
        }
    }
    die();
}

add_action('wp_ajax_quit_the_group', 'quit_the_group');
add_action('wp_ajax_nopriv_quit_the_group', 'quit_the_group');


//获取验证字段,参数(id,type) 返回值 验证字段数组
function get_verify_field($id, $type)
{
    global $wpdb;
    $sql = "SELECT verify_content FROM wp_gp_verify WHERE verify_id=$id and verify_type='$type'";
    $result = $wpdb->get_results($sql, 'ARRAY_A');
    $verifyField = explode(',', $result[0]['verify_content']);
    foreach ($verifyField as $key => $value) {
        if ($value == '') {
            unset($verifyField[$key]);
        }
    }
    return $verifyField;
}

//获取验证方式
function get_verify_type($group_id)
{
    global $wpdb;
    $sql = "SELECT join_permission FROM wp_gp WHERE ID=$group_id";
    $result = $wpdb->get_results($sql, 'ARRAY_A');
    return $result[0]['join_permission'];
}

/* 用于成员列表页
 * 获取所有成员信息 返回带成员身份的数组 get_group_member($group_id)
 * */
//获取成员信息 返回所有成员分身份的数组
function get_group_member($group_id)
{
    global $wpdb;
    $m_admin = array();
    $m_common = array();
    $sql = "SELECT * FROM wp_gp_member WHERE group_id = $group_id and member_status = 0";
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    foreach ($results as $value) {
        if ($value['indentity'] == 'admin') {
            array_push($m_admin, $value);
        } else {
            array_push($m_common, $value);
        }
    }
    $m = array('admin' => $m_admin, 'common' => $m_common);
    return $m;
}

//用于群组管理的成员审核
/* 获取成员的验证信息 get_member_verify_tmp($group_id)
 * 通过ajax   verify_pass()
 * 通过后台处理 verify_pass_process($user_id,$group_id)
 * 忽略ajax   verify_ignore()
 * 忽略后台处理 verify_ignore_process($user_id,$group_id)
 * */
//获取成员的验证信息   取一个成员的最后申请信息
function get_member_verify_tmp($group_id)
{
    global $wpdb;
    $sql = "select * from wp_gp_member_verify_tmp WHERE group_id = $group_id";
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    return $results;
}

//通过
function verify_pass()
{
    /* 若有user_id, 则把user加入到member表中,gp表member+1,删除当前tmp表中的内容
     * 若没有user_id,则遍历所有的user_id 执行上面的操作。因此把上面的操作写成函数。
     * */
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
    $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : "";
    if ($group_id != "") {   //前提
        if ($user_id != "") {
            verify_pass_process($user_id, $group_id);
            //融云
            //rongCloudJoinGroup($user_id,$group_id,get_group($group_id)[0]['group_name']);
        } else {
            $all_verify_info = get_member_verify_tmp($group_id);
            foreach ($all_verify_info as $tmp) {
                verify_pass_process($tmp['user_id'], $group_id);
                //rongCloudJoinGroup($tmp['user_id'],$group_id,get_group($group_id)[0]['group_name']);
            }
        }
    }

    //布道版块审核处理
    /* 上面已经执行过加入官方群的操作
     * 首先判断本群是否为官方群,如果是
     * 创建一个新的群组,
     * */
//    $budao_official = isset($_POST['budao_official']) ? $_POST['budao_official'] : "";
//    if ($group_id == get_group_id_by_name($budao_official)) {
//        //create_budao_group($user_id);
//    }
    exit();
}

add_action('wp_ajax_verify_pass', 'verify_pass');
add_action('wp_ajax_nopriv_verify_pass', 'verify_pass');

//忽略
function verify_ignore()
{
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
    $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : "";
    if ($group_id != "") {   //前提
        if ($user_id != "") {
            verify_ignore_process($user_id, $group_id);
        } else {
            $all_verify_info = get_member_verify_tmp($group_id);
            foreach ($all_verify_info as $tmp) {
                verify_ignore_process($tmp['user_id'], $group_id);
            }
        }
    }
    exit();
}

add_action('wp_ajax_verify_ignore', 'verify_ignore');
add_action('wp_ajax_nopriv_verify_ignore', 'verify_ignore');

//审核通过(忽略)处理
function verify_pass_process($user_id, $group_id)
{
    global $wpdb;
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    //首先获取验证信息
    $sql = "SELECT verify_info FROM wp_gp_member_verify_tmp WHERE user_id = $user_id and group_id=$group_id";
    $result = $wpdb->get_results($sql, "ARRAY_A");
    $verify_info = $result[0]['verify_info'];
    //看他是第几次加入
    $sql_count = "Select * From wp_gp_member WHERE user_id=$user_id and group_id=$group_id";
    $col = $wpdb->query($sql_count);
    if ($col == 0) { //如果没加入过,那么进行插入
        $sql_member = "INSERT INTO wp_gp_member VALUES ('',$user_id,$group_id,'member','$current_time','$verify_info',0)";
        $wpdb->get_results($sql_member);
    } else {  //如果插入过,进行更新
        $sql_member = "update wp_gp_member set member_status = 0 , verify_info = '$verify_info' , join_date='$current_time' WHERE user_id = $user_id and group_id = $group_id";
        $wpdb->get_results($sql_member);
    }
    //在gp表中添加成员
    $sql_add_count = "update wp_gp set member_count = (member_count+1) WHERE ID = $group_id";
    $wpdb->get_results($sql_add_count);

    $sql_delete_tmp = "delete from wp_gp_member_verify_tmp WHERE user_id = $user_id and group_id = $group_id";
    $wpdb->get_results($sql_delete_tmp);

    rongCloudJoinGroup2($user_id, $group_id);
}

function verify_ignore_process($user_id, $group_id)
{
    global $wpdb;
    $sql_delete_tmp = "delete from wp_gp_member_verify_tmp WHERE user_id = $user_id and group_id = $group_id";
    $wpdb->get_results($sql_delete_tmp);
}

//判断用户是否多次发送加入申请
function in_member_tmp($user_id, $group_id)
{
    global $wpdb;
    $sql = "SELECT * FROM wp_gp_member_verify_tmp WHERE user_id = $user_id and group_id=$group_id";
    $col = $wpdb->query($sql);
    if ($col == 0) {
        return false;
    } else {
        return true;
    }
}


/* 群组管理之成员管理页面
 * 获取成员的基本信息 get_member_info($group_id)
 * 修改成员身份 changeIndentity
 * */
//获取成员的基本信息
function get_member_info($group_id)
{
    global $wpdb;
    $ret = array();
    $sql = "SELECT * FROM wp_gp_member WHERE group_id = $group_id and member_status = 0";
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    foreach ($results as $value) {
        $arr_tmp = array();
        //返回的数组格式[id,用户名,验证字段切分,身份]
        array_push($arr_tmp, $value['user_id']);
        $user_name = get_the_author_meta('user_login', $value['user_id']);
        array_push($arr_tmp, $user_name);
        $verifyInfo = explode(',', $value['verify_info']);
        $len = sizeof(get_verify_field($group_id, 'group'));
        if ($len == sizeof($verifyInfo)) {  //没填的写空
            for ($i = 0; $i < $len; $i++) {
                array_push($arr_tmp, $verifyInfo[$i]);
            }
        } else {
            for ($i = 0; $i < $len; $i++) {
                array_push($arr_tmp, '');
            }
        }
        if ($value['indentity'] == 'admin') {    # 可改进
            $indentity = '管理员';
        } else {
            $indentity = '普通成员';
        }
        array_push($arr_tmp, $indentity);
        array_push($ret, $arr_tmp);
    }
    return $ret;
}

//修改成员身份  可改进的部分就是判断群有几个管理员,还有默认群主不能修改身份
function changeIndentity()
{
    global $wpdb;
    $user_id = $_POST['user_id'];
    $indentity = $_POST['indentity'];
    $group_id = $_POST['group_id'];
    for ($i = 0; $i < sizeof($user_id); $i++) {
        $sql_indentity = "update wp_gp_member set indentity ='$indentity' WHERE user_id = $user_id[$i] and group_id = $group_id";
        $wpdb->get_results($sql_indentity);
    }

    //notice
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    $notice_content = get_current_user_id();
    foreach ($user_id as $value) {
        //多次变更只显示最后一次
        $sql_has_notice = "SELECT ID FROM wp_gp_notice WHERE user_id = $value and group_id = $group_id
                        and notice_type = 6 ";
        $col = $wpdb->query($sql_has_notice);
        if ($col == 0) {
            $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$value,$group_id,6,'$notice_content',0,'$current_time')";
            $wpdb->get_results($sql_add_notice);
        } else {
            $sql_update_notice = "update wp_gp_notice set notice_content = '$notice_content',modified_time = '$current_time',notice_status = 0 
                                  WHERE user_id = $value and group_id = $group_id
                                  and notice_type = 6 ";
            $wpdb->get_results($sql_update_notice);
        }
    }
    exit();
}

add_action('wp_ajax_changeIndentity', 'changeIndentity');
add_action('wp_ajax_nopriv_changeIndentity', 'changeIndentity');

function get_member_identity($group_id, $user_id)
{
    global $wpdb;
    $sql = "SELECT indentity FROM wp_gp_member WHERE group_id = $group_id and user_id = $user_id";
    $result = $wpdb->get_results($sql)[0]->indentity;
    return $result;
}

function kick_out_the_group()
{
    global $wpdb;
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
    $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : "";
    $admin = get_group_member($group_id)['admin'];
    $response_tmp = "notadmin";
    if (sizeof($admin) == 1) {
        for ($i = 0; $i < sizeof($user_id); $i++) {
            if ($user_id[$i] == $admin[0]['user_id']) {
                $response_tmp = "isadmin";
            }
        }
    }
    if ($response_tmp == "notadmin") {
        if ($group_id != "" and $user_id != "") {
            for ($i = 0; $i < sizeof($user_id); $i++) {
                $sql_member = "update wp_gp_member set member_status = 1 WHERE user_id = $user_id[$i] and group_id = $group_id";
                $wpdb->get_results($sql_member);
                $sql_cut_count = "update wp_gp set member_count = (member_count-1) WHERE ID = $group_id";
                $wpdb->get_results($sql_cut_count);
                rongCloudQuitGroup2($user_id[$i], $group_id);
            }

            $response = "success";

            //notice
            $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
            $notice_content = get_current_user_id();
            foreach ($user_id as $value) {
                $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$value,$group_id,7,'$notice_content',0,'$current_time')";
                $wpdb->get_results($sql_add_notice);
            }
        }
    } else {
        $response = "error";
    }
    echo $response;
    die();
}

add_action('wp_ajax_kick_out_the_group', 'kick_out_the_group');
add_action('wp_ajax_nopriv_kick_out_the_group', 'kick_out_the_group');


//恢复wiki历史版本
function restore_post_revision()
{
    $revision_id = $_POST['revision_id'];
    wp_restore_post_revision($revision_id);
    die();
}

add_action('wp_ajax_restore_post_revision', 'restore_post_revision');
add_action('wp_ajax_nopriv_restore_post_revision', 'restore_post_revision');
/*task部分*/
/* 距离任务结束还有多长时间,精确到天或小时 countDown()
 * 判断任务是否截止 is_overdue()
 * 获取本组的所有未截止项目且未完成任务 get_unfinish_task($group_id)
 * 为了自动检测阅读任务的完成情况ajax complete_read_task()
 * 打开时完成度的显示 complete_single($task_id)
 * 在成员-任务表中添加成员的完成情况 complete_all($task_id,$user_id)
 * 群组中完成成员的总百分比 complete_percentage($group_id,$task_id)
 * 项目任务是否完成  is_complete_task($task_id,$user_id)
 * 最活跃成员:  get_latest_active($group_id_tmp)
 * 判断用户名输入的是否正确ajax  checkUserName()
 * 通过user_name获取user_id  get_the_ID_by_name($user_name)
 * 获取user提交的任务内容    get_user_task_content($task_id,$user_id = NULL)
 * 获取本team的成员   get_team_member($task_id)
 * 获取team_id    get_team_id($task_id, $user_id = NULL)
 *
 *
 * */
function countDown($task_id)
{
    global $wpdb;
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    $deadline = $wpdb->get_var($wpdb->prepare("SELECT deadline FROM wp_gp_task WHERE ID=$task_id", ""), 0, 0);
    $current_time = strtotime($current_time);
    $deadline = strtotime($deadline);
    $day_time = $deadline - $current_time;
    if ($day_time > 0) {  //未到截止日期
        $day = ceil($day_time / (24 * 3600));
        return $day;
    } else {
        return 0;
    }
}

//判断任务是否截止
function is_overdue($task_id)
{
    global $wpdb;
    $current_time = strtotime(date('Y-m-d H:i:s', time() + 8 * 3600));
    $deadline = strtotime($wpdb->get_var($wpdb->prepare("SELECT deadline FROM wp_gp_task WHERE ID=$task_id", ""), 0, 0));
    $day_time = $deadline - $current_time;
    if ($day_time > 0) {  //未到截止日期
        return false;
    } else {
        return true;
    }
}

//获取本组的所有未截止项目且未完成任务!!
function get_unfinish_task($group_id)
{
    $task = get_task($group_id);
    $user_id = get_current_user_id();
    foreach ($task as $key => $value) {
        if ($value['task_type'] == 'tread') {
            $per = complete_all_read($value['ID'], $user_id);
            if (is_overdue($value['ID']) || $per == 100) {
                unset($task[$key]);
            }
        } elseif ($value['task_type'] == 'tpro') {
            if (is_overdue($value['ID']) || is_complete_task($value['ID'], $user_id)) { //已完成
                unset($task[$key]);
            }
        } else {
            if (is_overdue($value['ID']) || is_complete_task($value['ID'], $user_id)) {
                unset($task[$key]);
            }
        }
    }
    return $task;
}

//为了自动检测阅读任务的完成情况
function complete_read_task()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $task_id = $_POST['task_id'];
    $complete_content = $_POST['complete_content'];
    $id = $_POST['id'];
    /* step1: 查找有没有这个用户完成这个任务的信息
     * step2: 若没有,则insert into tmp表
     * step3: 若有,则insert新的一行到tmp表,但不能重复
     * step4: 上述操作做完,检测全部阅读链接的完成情况,若完成,则更改成员任务表的完成情况
     * step5: 完成情况可以从这里面提取,有链接的就可以算完成了。
     * */
    $sql_1 = "SELECT * FROM wp_gp_task_complete_tmp 
                    WHERE user_id = $user_id and task_id = $task_id and complete_content = '$complete_content'";
    $col = $wpdb->query($sql_1);
    if ($col == 0) {
        $sql_insert = "INSERT INTO wp_gp_task_complete_tmp VALUES ('','$user_id','$task_id','$complete_content')";
        $wpdb->get_results($sql_insert);
        $per = complete_all_read($task_id, $user_id);
    }
    echo '#' . $id;
    die();
}

add_action('wp_ajax_complete_read_task', 'complete_read_task');
add_action('wp_ajax_nopriv_complete_read_task', 'complete_read_task');

//打开时完成度的显示
function complete_single($task_id)
{
    /* 返回值是一个数组,按顺序的返回完成ornot 格式[0,1],0表示完成,1表示未完成
     * step:1 取出验证字段,即,link的字段
     * step:2 对于每一个link,搜索该用户是否在tmp表中有过。
     * step:3 若col不为0,即已经看过,result push 1 否则push 0
     * */
    global $wpdb;
    $result = array();
    $verify_field = get_verify_field($task_id, 'task');
    $user_id = get_current_user_id();
    foreach ($verify_field as $key => $value) {
        $sql_1 = "SELECT * FROM wp_gp_task_complete_tmp 
                    WHERE user_id = $user_id and task_id = $task_id and complete_content = '$value'";
        $col = $wpdb->query($sql_1);
        if ($col == 0) {
            array_push($result, '<span>未完成</span>');
        } else {
            $url = get_template_directory_uri() . "/img/complete.png";
            array_push($result, "<img src=" . $url . ">");
        }
    }
    return $result;
}

//在成员-任务表中添加成员的完成情况 read
function complete_all_read($task_id, $user_id)
{
    global $wpdb;
    $time = date('Y-m-d H:i:s', time() + 8 * 3600);
    $sql_all = "SELECT * FROM wp_gp_task_complete_tmp WHERE user_id = $user_id and task_id = $task_id";
    $col_all = $wpdb->query($sql_all);
    $verify_size = sizeof(get_verify_field($task_id, 'task'));
    if ($col_all == $verify_size) {   //完成了
        //加判断是否已经插入过了
        $sql_exist = "SELECT * FROM wp_gp_task_member WHERE user_id = $user_id and task_id = $task_id";
        $col_exist_in_task_member = $wpdb->query($sql_exist);
        if ($col_exist_in_task_member == 0) {  //如果没有插入过
            $sql_insert = "INSERT INTO wp_gp_task_member VALUES ('',$user_id,$task_id,1,'$time','','')";
            $sql_update_task = "UPDATE wp_gp_task SET complete_count = (complete_count + 1) WHERE ID = $task_id";
            $wpdb->get_results($sql_insert);
            $wpdb->get_results($sql_update_task);
        }
    }
    $per = round(($col_all / $verify_size) * 100);
    return $per;
}

//群组中完成成员的总百分比 退出群组怎么办——————不用管,仍然保存他的数据但不统计
function complete_percentage($group_id, $task_id)
{
    /* step1: 取出本组所有的成员数
     * step2: 取出本组所有完成的成员数
     * */
    global $wpdb;
    $all_member = get_group($group_id)[0]['member_count'];
    $complete_member = 0;
    //sql_complete是目前在群组中的成员的完成数量
    $sql_complete = "SELECT * FROM wp_gp_task_member WHERE task_id =$task_id";
    $complete_info = $wpdb->get_results($sql_complete, 'ARRAY_A');
    foreach ($complete_info as $value) {
        if (is_group_member($group_id, $value['user_id'])) { //是群组成员才算完成情况
            $complete_member += 1;
        }
    }
    $per = round(($complete_member / $all_member) * 100);
    return $per;
}

//项目任务是否完成
function is_complete_task($task_id, $user_id)
{
    global $wpdb;
    $sql = "SELECT * FROM wp_gp_task_member WHERE user_id=$user_id and task_id = $task_id";
    $col = $wpdb->query($sql);
    if ($col != 0) {
        return true;
    } else {
        return false;
    }
}

/*得到本群组中最近活跃成员的函数
 *即最近加入的三个成员
 * 参数：group的id
 * 返回：三个成员或更少成员（当加入人数小于3）的id
 * */
function get_latest_active($group_id_tmp)
{
    global $wpdb;
    $group_active_info = $wpdb->get_results("select * from wp_gp_member where group_id=$group_id_tmp and member_status= 0");

    $group_active = array();
    foreach ($group_active_info as $item) {
        $group_active[$item->user_id] = $item->join_date;
    }

    //print_r($group_active);
    arsort($group_active);

    //如果只有小于3个成员加入，只存入1或2个人
    if (sizeof($group_active) >= 3) {
        $i = 0;
        foreach ($group_active as $key => $value) {
            $group_active_id[] = $key;
            $i++;
            if ($i == 3)
                break;
        }
    } else {
        $i = 0;
        foreach ($group_active as $key => $value) {
            $group_active_id[] = $key;
            $i++;
            if ($i == sizeof($group_active))
                break;
        }
    }
    //print_r($group_active_id);
    return $group_active_id;
}

/*群组动态栏（即发布任务的动态）
 * 返回：包含所有动态信息的数组
 * 结构：$group_task[$i]['task_author'];
                        ['task_identity'];
                        ['group_name'];
                        ['task_name'];
                        ['task_address'];
                        ['notice_type']
 */
function get_gp_notification($group_id = null)
{
    global $wpdb;
    if ($group_id == null) {
        //1.发布任务
        $group_task_info = $wpdb->get_results("select * from wp_gp_task");

        $group_task = array();
        foreach ($group_task_info as $item) {
            $single_task = array();

            //作者、身份、组名、任务名
            //$task_author_info = $wpdb->get_results("select * from $wpdb->users where ID=".$item->task_author);
            $single_task['task_author'] = get_the_author_meta('user_login', $item->task_author);
            //$task_author_info[0]->user_login;

            $task_author_iden_info = $wpdb->get_results("select * from wp_gp_member where user_id=" . $item->task_author . " and group_id=" . $item->belong_to);
            $task_author_iden = $task_author_iden_info[0]->indentity;
            if (strcmp($task_author_iden, "member") == 0) {
                $single_task['task_identity'] = "成员";
            } else if (strcmp($task_author_iden, "admin") == 0) {
                $single_task['task_identity'] = "管理员";
            }

            $task_group_info = $wpdb->get_results("select * from wp_gp where ID=" . $item->belong_to);
            $single_task['group_name'] = $task_group_info[0]->group_name;

            $single_task['task_name'] = $item->task_name;

            $single_task['task_address'] = add_query_arg(array('page_id' => get_page_id('single_task'), 'id' => $item->ID), get_home_url());

            $single_task['time'] = $item->create_date;

            $single_task['notice_type'] = 1;

            $group_task[] = $single_task;
        }


        //2.加入群组
        $group_join_info = $wpdb->get_results("select * from wp_gp_member");
        foreach ($group_join_info as $item) {
            $single_task = array();

            //$task_author_info = $wpdb->get_results("select * from $wpdb->users where ID=".$item->user_id);
            $single_task['task_author'] = get_the_author_meta('user_login', $item->user_id);

            //$task_author_info[0]->user_login;

            $task_author_iden_info = $wpdb->get_results("select * from wp_gp where ID=" . $item->group_id);
            $single_task['group_name'] = $task_author_iden_info[0]->group_name;

            $single_task['task_address'] = add_query_arg(array('page_id' => get_page_id('single_group'), 'id' => $item->group_id), get_home_url());

            $single_task['time'] = $item->join_date;

            $single_task['notice_type'] = 2;

            $group_task[] = $single_task;
        }

        //3.创建群组
        $group_create_info = $wpdb->get_results("select * from wp_gp");
        foreach ($group_create_info as $item) {
            $single_task = array();

            //$task_author_info = $wpdb->get_results("select * from $wpdb->users where ID=".$item->group_author);
            $single_task['task_author'] = get_the_author_meta('user_login', $item->group_author);
            //$task_author_info[0]->user_login;

            $single_task['group_name'] = $item->group_name;

            $single_task['task_address'] = add_query_arg(array('page_id' => get_page_id('single_group'), 'id' => $item->ID), get_home_url());

            $single_task['time'] = $item->create_date;

            $single_task['notice_type'] = 3;

            $group_task[] = $single_task;
        }

        //4.完成任务
        $task_complete_info = $wpdb->get_results("select * from wp_gp_task_member");
        foreach ($task_complete_info as $item) {
            $single_task = array();

            //$task_author_info = $wpdb->get_results("select * from $wpdb->users where ID=".$item->user_id);
            $single_task['task_author'] = get_the_author_meta('user_login', $item->user_id);
            //$task_author_info[0]->user_login;

            $group_task_info = $wpdb->get_results("select * from wp_gp_task where ID=" . $item->task_id);
            $single_task['task_name'] = $group_task_info[0]->task_name;

            $single_task['task_address'] = add_query_arg(array('page_id' => get_page_id('single_task'), 'id' => $item->task_id), get_home_url());

            $single_task['time'] = $item->complete_time;

            $single_task['notice_type'] = 4;

            $group_task[] = $single_task;
        }

        usort($group_task, function ($a, $b) {
            if ($a == $b) return 0;
            return ($a['time'] > $b['time']) ? -1 : 1;
        });


        //print_r($group_task);
        return $group_task;
    } else {
        //1.发布任务
        $group_task_info = $wpdb->get_results("select * from wp_gp_task WHERE belong_to = $group_id");
        $group_task = array();
        foreach ($group_task_info as $item) {
            $single_task = array();

            //作者、身份、组名、任务名
            $single_task['task_author'] = get_the_author_meta('user_login', $item->task_author);
            $task_author_iden_info = $wpdb->get_results("select * from wp_gp_member where user_id=" . $item->task_author . " and group_id=" . $item->belong_to);
            $task_author_iden = $task_author_iden_info[0]->indentity;
            if (strcmp($task_author_iden, "member") == 0) {
                $single_task['task_identity'] = "成员";
            } else if (strcmp($task_author_iden, "admin") == 0) {
                $single_task['task_identity'] = "管理员";
            }

            /*$task_author_iden_info = $wpdb->get_results("select * from wp_gp where group_author=".$item->task_author." and ID=".$item->belong_to);
            if($task_author_iden_info != null){
                $single_task['task_identity'] = "管理员";
            }else{
                $task_author_iden_info = $wpdb->get_results("select * from wp_gp_member where user_id=".$item->task_author." and group_id=".$item->belong_to);
                if($task_author_iden_info != null){
                   $single_task['task_identity'] = "成员";}
            }*/

            $task_group_info = $wpdb->get_results("select * from wp_gp where ID=" . $item->belong_to);
            $single_task['group_name'] = $task_group_info[0]->group_name;

            $single_task['task_name'] = $item->task_name;

            $single_task['task_address'] = add_query_arg(array('page_id' => get_page_id('single_task'), 'id' => $item->ID), get_home_url());

            $single_task['time'] = $item->create_date;

            $single_task['notice_type'] = 1;

            $group_task[] = $single_task;
        }


        //2.加入群组
        $group_join_info = $wpdb->get_results("select * from wp_gp_member WHERE group_id=$group_id");
        foreach ($group_join_info as $item) {
            $single_task = array();

            //$task_author_info = $wpdb->get_results("select * from $wpdb->users where ID=".$item->user_id);
            $single_task['task_author'] = get_the_author_meta('user_login', $item->user_id);

            //$task_author_info[0]->user_login;

            $task_author_iden_info = $wpdb->get_results("select * from wp_gp where ID=" . $item->group_id);
            $single_task['group_name'] = $task_author_iden_info[0]->group_name;

            $single_task['task_address'] = add_query_arg(array('page_id' => get_page_id('single_group'), 'id' => $item->group_id), get_home_url());

            $single_task['time'] = $item->join_date;

            $single_task['notice_type'] = 2;

            $group_task[] = $single_task;
        }

        //3.创建群组
//        $group_create_info = $wpdb->get_results("select * from wp_gp");
//        foreach ($group_create_info as $item) {
//            $single_task = array();
//
//            //$task_author_info = $wpdb->get_results("select * from $wpdb->users where ID=".$item->group_author);
//            $single_task['task_author'] = get_author_name($item->group_author);
//            //$task_author_info[0]->user_login;
//
//            $single_task['group_name'] = $item->group_name;
//
//            $single_task['task_address'] = add_query_arg(array('page_id' => get_page_id('single_group'), 'id' => $item->ID), get_home_url());
//
//            $single_task['time'] = $item->create_date;
//
//            $single_task['notice_type'] = 3;
//
//            $group_task[] = $single_task;
//        }

        //4.完成任务
        $tasks = get_task($group_id);
        $task_complete_info = $wpdb->get_results("select * from wp_gp_task_member where task_id in $tasks");

        foreach ($task_complete_info as $item) {
            $single_task = array();

            //$task_author_info = $wpdb->get_results("select * from $wpdb->users where ID=".$item->user_id);
            $single_task['task_author'] = get_the_author_meta('user_login', $item->user_id);
            //$task_author_info[0]->user_login;

            $group_task_info = $wpdb->get_results("select * from wp_gp_task where ID=" . $item->task_id);
            $single_task['task_name'] = $group_task_info[0]->task_name;

            $single_task['task_address'] = add_query_arg(array('page_id' => get_page_id('single_task'), 'id' => $item->task_id), get_home_url());

            $single_task['time'] = $item->complete_time;

            $single_task['notice_type'] = 4;

            $group_task[] = $single_task;
        }

        usort($group_task, function ($a, $b) {
            if ($a == $b) return 0;
            return ($a['time'] > $b['time']) ? -1 : 1;
        });


        //print_r($group_task);
        return $group_task;
    }
}


//判断用户名输入的是否正确ajax,是否是本组的,是否是系统里的
function checkUserName()
{
    global $wpdb;
    $name = $_POST['name'];
    $group_id = $_POST['group_id'];
    $task_id = $_POST['task_id'];
    $sql = "SELECT * FROM $wpdb->users WHERE user_login = '$name'";
    $col = $wpdb->query($sql);
    if ($col == 0) {
        $response = 0;
    } else {
        //如果有这个用户判断这个用户是不是该组成员
        $id = get_the_ID_by_name($name);
        if (!is_group_member($group_id, $id)) {   //已经是本组成员的话不行
            $response = 1;
        } else {
            if (!is_ungroup($id, $group_id, $task_id)) {  //如果已经分组了,不可以
                $response = 3;
            } else {
                $response = 2;
            }
        }
    }
    if ($name == '') {
        $response = 2;
    }
    echo $response;
    die();
}

add_action('wp_ajax_checkUserName', 'checkUserName');
add_action('wp_ajax_nopriv_checkUserName', 'checkUserName');

//判断用户名输入的是否正确ajax,是否是本组的,是否是系统里的
function checkUpdateUserName()
{
    global $wpdb;
    $name = $_POST['name'];
    $group_id = $_POST['group_id'];
    $task_id = $_POST['task_id'];
    $team_id = $_POST['team_id'];
    $sql = "SELECT * FROM $wpdb->users WHERE user_login = '$name'";
    $col = $wpdb->query($sql);
    if ($col == 0) {
        $response = 0;  //用户不存在
    } else {
        //如果有这个用户判断这个用户是不是该组成员
        $id = get_the_ID_by_name($name);
        if (!is_group_member($group_id, $id)) {   //如果不是本群组的成员
            $response = 1;
        } else {   //用户存在且是本组成员,判断是否分组
            if (!is_ungroup($id, $group_id, $task_id)) {  //如果不是未分组的,即已经分组了
                //判断是否是当前小组的
                if (!in_array($id, get_team_member($task_id, $team_id))) {
                    $response = 3;
                } else {
                    $response = 2;
                }
            } else {  //未分组的
                $response = 2;   //可以加入群组
            }
        }
    }
    if ($name == '') {
        $response = 2;  //名字为空,可以加入群组
    }
    echo $response;
    die();
}

add_action('wp_ajax_checkUpdateUserName', 'checkUpdateUserName');
add_action('wp_ajax_nopriv_checkUpdateUserName', 'checkUpdateUserName');

//用户是否组队
function is_ungroup($id, $group_id, $task_id)
{
    $ungroup_member = pro_table($group_id, $task_id)['ungroup'];
    if (!empty($ungroup_member)) {
        foreach ($ungroup_member as $value) {
            if ($value[0] == $id) {
                return true;
            }
        }
    }
    return false;
}


//判断用户输入的邀请用户名是否正确,是否已经是本组的
function checkInUserName()
{
    global $wpdb;
    $name = $_POST['name'];
    $group_id = $_POST['group_id'];
    $sql = "SELECT * FROM $wpdb->users WHERE user_login = '$name' or display_name = '$name'";
    $col = $wpdb->query($sql);
    if ($col == 0) {
        $response = 0;
    } else {
        //如果有这个用户判断这个用户是不是该组成员
        $id = get_the_ID_by_name($name);
        if (is_group_member($group_id, $id)) {   //已经是本组成员的话不行
            $response = 1;
        } else {
            $response = 2;
        }
    }
    if ($name == '') {
        $response = 2;
    }
    echo $response;
    die();
}

add_action('wp_ajax_checkInUserName', 'checkInUserName');
add_action('wp_ajax_nopriv_checkInUserName', 'checkInUserName');

//通过user_name获取user_id
function get_the_ID_by_name($user_name)
{
    global $wpdb;
    $sql = "SELECT ID FROM $wpdb->users WHERE user_login = '$user_name'";
    $id = $wpdb->get_var($wpdb->prepare($sql, ""), 0, 0);
    return $id;
}

//获取user提交的任务内容
function get_user_task_content($task_id, $user_id = NULL)
{
    global $wpdb;
    if ($user_id == NULL) {
        $user_id = get_current_user_id();
    }
    $sql = "SELECT * from wp_gp_task_member WHERE user_id=$user_id and task_id = $task_id";
    $result = $wpdb->get_results($sql, 'ARRAY_A');
    return $result[0];
}

//获取本team的成员
function get_team_member($task_id, $team_id = NULL)
{
    global $wpdb;
    $result = [];
    if ($team_id == NULL) {
        $team_id = get_team_id($task_id);
    }
    $sql_id = "SELECT user_id from wp_gp_member_team WHERE team_id=$team_id and task_id = $task_id";
    $uid = $wpdb->get_results($sql_id, 'ARRAY_N');
    foreach ($uid as $value) {
        array_push($result, $value[0]);
    }
    return $result;
}

//获取team_id  (当前用户或指定用户的team_id)
function get_team_id($task_id, $user_id = NULL)
{
    global $wpdb;
    if ($user_id == NULL) {
        $user_id = get_current_user_id();
    }
    $sql = "SELECT team_id from wp_gp_member_team WHERE user_id=$user_id and task_id = $task_id";
    $team_id = $wpdb->get_results($sql, 'ARRAY_A')[0]['team_id'];
    return $team_id;
}

//专为提交项目类任务表格提供信息的函数返回一个二维数组,一维是team_id,一维是表格信息
function pro_table($group_id, $task_id)
{
    /* step0: 取出本任务的所有team_id 为了控制合并行的数量 如果没有一个team时?
     * step1: 取出本组的所有成员 为了控制总的行数
     * step2: 对于每一个team_id 取出team中的成员,在本组所有成员的数组中减去他们。最后剩下的就是还未分组的成员
     * step3: 对于每一个team_id 中的每一个成员, 数据有:用户名,验证字段,项目链接,完成情况(completion)  对于管理员? 另算 在循环的td中修改
     * step4: 最后push到一个巨大的二维数组中。
     * 未分组成员用array_unshift($a,$element)
     * */
    global $wpdb;
    $result = [];  //存储返回数组

    //step0:
    $sql_team_id = "SELECT distinct(team_id) FROM wp_gp_member_team WHERE task_id = $task_id ORDER BY team_id";
    $array_team_id = $wpdb->get_results($sql_team_id, 'ARRAY_A');

    //step1: 格式 Array ( [0] => 22 [1] => 1 )
    $sql_member_id = "SELECT DISTINCT(user_id) FROM wp_gp_member WHERE group_id = $group_id and member_status = 0";
    $array_member_id_tmp = $wpdb->get_results($sql_member_id, 'ARRAY_A');
    $array_member_id = [];
    foreach ($array_member_id_tmp as $value) {
        array_push($array_member_id, $value['user_id']);
    }
    //step2:
    $array_member_id_ungroup = $array_member_id;
    if (sizeof($array_team_id) != 0) {    //$array_team_id数组的大小是有多少组
        //如果有组队成功的
        foreach ($array_team_id as $key => $value) {
            $tmp_team = [];
            $uid = get_team_member($task_id, $value['team_id']); //获得本小组的成员id
            $array_member_id_ungroup = array_diff($array_member_id_ungroup, $uid);  //获取未分组的成员,每一轮减去一个team的成员,但索引不变

            foreach ($uid as $id) {
                $tmp = [];//存储内层数组
                $user_id = $id;
                $user_name = get_the_author_meta('user_login', $id);
                $verify_field = get_user_verify_field($group_id, $id);
                $completion = get_user_task_completion($task_id, $user_id);
                array_push($tmp, $user_id, $user_name);
                $tmp = array_merge($tmp, $verify_field, $completion[0]);
//                if(sizeof($verify_field)!=0){
//                    $tmp = array_merge($tmp, $verify_field, $completion[0]);
//                }else{
//                    $tmp = array_merge($tmp, array(), $completion[0]);
//                }
                array_push($tmp_team, $tmp);
            }
            $result += array($value['team_id'] => $tmp_team);
        }
    }

    //处理未分组的成员
    $tmp_team_ungroup = [];
    foreach ($array_member_id_ungroup as $key => $value_ungroup) {
        $tmp = [];//存储内层数组
        $user_id = $value_ungroup;
        $user_name = get_the_author_meta('user_login', $value_ungroup);
        $verify_field = get_user_verify_field($group_id, $value_ungroup);
        $completion = array('completion' => '', 'apply_content' => '');
        array_push($tmp, $user_id, $user_name);
        $tmp = array_merge($tmp, $verify_field, $completion);
        array_push($tmp_team_ungroup, $tmp);
    }
    $result = array("ungroup" => $tmp_team_ungroup, "team" => $result);
    return $result;
}

//根据用户id获取验证字段
function get_user_verify_field($group_id, $user_id)
{
    global $wpdb;
    $sql = "SELECT * FROM wp_gp_member WHERE group_id = $group_id and user_id = $user_id and member_status = 0";
    $results = $wpdb->get_results($sql, 'ARRAY_A');

    foreach ($results as $value) {
        $arr_tmp = [];
        $verifyInfo = explode(',', $value['verify_info']);
        $len = sizeof(get_verify_field($group_id, 'group'));
        if ($len == sizeof($verifyInfo)) {  //没填的写空
            for ($i = 0; $i < $len; $i++) {
                array_push($arr_tmp, $verifyInfo[$i]);
            }
        } else {
            for ($i = 0; $i < $len; $i++) {
                array_push($arr_tmp, '');
            }
        }
        return $arr_tmp;
    }
}

//根据用户id获取任务内容和完成情况
function get_user_task_completion($task_id, $user_id)
{
    global $wpdb;
    $sql = "SELECT completion,apply_content FROM wp_gp_task_member WHERE task_id = $task_id and user_id = $user_id";
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    return $results;
}

//项目审核增加成绩ajax
function change_grade()
{
    global $wpdb;
    $completion = $_POST['grade'];
    $task_id = $_POST['task_id'];
    $team_id = $_POST['team_id'];
    $team_member = get_team_member($task_id, $team_id);
    foreach ($team_member as $member) {
        $sql = "update wp_gp_task_member set completion = $completion WHERE user_id=$member and task_id=$task_id";
        try {
            $wpdb->get_results($sql);
        } catch (Exception $e) {
            return ['code' => $e->getCode(), 'msg' => $e->getMessage()];
        }
    }

    //notice
    $group_id = $_POST['group_id'];
    foreach ($team_member as $value) {
        $notice_id = $value;   //被通知人ID
        $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);

        $sql_has_notice = "SELECT ID FROM wp_gp_notice WHERE user_id = $notice_id and group_id = $group_id
                        and notice_type = 5 and notice_content = '$task_id'";
        $col = $wpdb->query($sql_has_notice);
        if ($col == 0) {
            $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$notice_id,$group_id,5,'$task_id',0,'$current_time')";
            $wpdb->get_results($sql_add_notice);
        } else {
            $sql_update_notice = "update wp_gp_notice set modified_time = '$current_time',notice_status = 0 WHERE user_id = $notice_id and group_id = $group_id
                        and notice_type = 5 and notice_content = '$task_id'";
            $wpdb->get_results($sql_update_notice);
        }
    }
    die();
}

add_action('wp_ajax_change_grade', 'change_grade');
add_action('wp_ajax_nopriv_change_grade', 'change_grade');

//成绩的数字和文字转换
function transform_grade($rank)
{
    $map = ['待审核', '不合格', '合格', '一般', '良好', '优秀', '特优'];
    return $map[$rank];
}

//获取本other项目完成的成员和信息
function task_complete_other($task_id, $user_id = NULL)
{
    global $wpdb;
    if ($user_id != NULL) {
        $sql = "SELECT * FROM wp_gp_task_member WHERE task_id = $task_id and user_id = $user_id";
        $results = $wpdb->get_results($sql, 'ARRAY_A');
    } else {
        $sql = "SELECT * FROM wp_gp_task_member WHERE task_id = $task_id";
        $results = $wpdb->get_results($sql, 'ARRAY_A');
    }
    return $results;
}

//审核other项目结果
function change_grade_other()
{
    global $wpdb;
    $completion = $_POST['grade'];
    $task_id = $_POST['task_id'];
    $user_id = $_POST['user_id'];
    $sql = "update wp_gp_task_member set completion = $completion WHERE user_id=$user_id and task_id=$task_id";
    try {
        $wpdb->get_results($sql);
    } catch (Exception $e) {
        return ['code' => $e->getCode(), 'msg' => $e->getMessage()];
    }

    //notice
    $group_id = $_POST['group_id'];
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    $sql_add_notice = "INSERT INTO wp_gp_notice VALUES ('',$user_id,$group_id,5,'$task_id',0,'$current_time')";
    $wpdb->get_results($sql_add_notice);
    die();
}

add_action('wp_ajax_change_grade_other', 'change_grade_other');
add_action('wp_ajax_nopriv_change_grade_other', 'change_grade_other');

//点评任务结果
function task_remark_submit()
{
    global $wpdb;
    $remark = $_POST['remark'];
    $task_id = $_POST['task_id'];
    $user_id = $_POST['user_id'];
    echo $remark;
    $sql = "update wp_gp_task_member set remark = '$remark' WHERE user_id=$user_id and task_id=$task_id";
    $wpdb->query($sql);
    //echo $sql;
    die();
}

add_action('wp_ajax_task_remark_submit', 'task_remark_submit');
add_action('wp_ajax_nopriv_task_remark_submit', 'task_remark_submit');
//判断是否有点评
function has_remark($task_id, $user_id)
{
    global $wpdb;
    $sql = "SELECT remark from wp_gp_task_member WHERE user_id = $user_id and task_id = $task_id";
    $remarks = $wpdb->get_results($sql);
    foreach ($remarks as $remark)
        if ($remark->remark != null) {
            return true;
        } else {
            return false;
        }
}

/* 布道师大赛所用的模块
 * */
function get_group_id_by_name($group_name)
{
    global $wpdb;
    $sql = "SELECT ID FROM wp_gp WHERE group_name = '$group_name'";
    $res = $wpdb->get_results($sql);
    return $res[0]->ID;
}


function create_budao_group($user_id)
{
    global $wpdb;
    $user_name = get_the_author_meta('user_login', $user_id);
    $group_name = "布道师" . $user_name . "的群组";
    $group_author = $user_id;
    $group_abstract = "这里为布道师" . $user_name . "的群组";
    $group_status = 'open';
    $join_permission = 'freejoin';
    $task_permission = 'admin'; //all、admin
    $create_date = date("Y-m-d H:i:s", time() + 8 * 3600);
    $upload_path = wp_upload_dir();  //获取wordpress的上传路径。

    $group_cover_address = $upload_path['baseurl'] . "/group-avatars/1/default.png";
    $new_upload_path = $upload_path['basedir'] . "/group-avatars/1/default.png";

    //处理加入方式
    //首先获取最后一个group_id;
    $sql_fun = "select ID from wp_gp ORDER BY ID DESC LIMIT 0,1";
    $result = $wpdb->get_results($sql_fun);
    $group_id = $result[0]->ID + 1;


    $sql_gp = "INSERT INTO wp_gp VALUES ('$group_id','$group_name',$group_author,
                                          '$group_abstract','$group_status','budao',
                                          '$group_cover_address','$join_permission',
                                          '$task_permission','$create_date',1)";

    $sql_member = "INSERT INTO wp_gp_member VALUES ('',$group_author,$group_id,'admin','$create_date','',0)";

    $sql_group_name = "SELECT ID FROM wp_gp WHERE group_name = '$group_name'";
    $col = $wpdb->query($sql_group_name);
    if ($col == 0 && $group_abstract != "" && $group_status != "" &&
        $join_permission != "" && $task_permission != ""
    ) {
        $wpdb->query($sql_gp);
        $wpdb->query($sql_member);
    }
}

//群组搜索功能
function get_search_group_ids($search_str)
{   //需改进
    global $wpdb;
    $search_str = trim($search_str);
    $search_str_arr = explode(" ", $search_str);
    $sql_pre = "";
    foreach ($search_str_arr as $key => $words) {
        $sql_pre = $sql_pre . "group_name LIKE '%$words%' ";
        if (sizeof($search_str_arr) != $key + 1) {
            $sql_pre = $sql_pre . "or ";
        }
    }

    $sql = "SELECT ID FROM wp_gp WHERE " . $sql_pre;
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    $return = [];
    foreach ($results as $value) {
        array_push($return, $value['ID']);
    }
    $str = implode(',', $return);
    return $str;
}

//布道师大赛群组获取
function get_budao_group($id = NULL)
{
    global $wpdb;
    if ($id != null) {
        $sql = "SELECT * FROM wp_gp WHERE ID = $id and publish_status = 'budao' ";
    } else {
        $sql = "SELECT * FROM wp_gp WHERE publish_status = 'budao'";
    }
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    return $results;
}

//为用户加入的group分类,变成加入和创建的分开
function group_personal($all_group)
{
    $user_id = get_current_user_id();
    $create = [];
    $joined = [];
    if (sizeof($all_group) != 0) {
        foreach ($all_group as $value) {
            if ($user_id == $value['group_author']) {
                array_push($create, $value);
            } else {
                array_push($joined, $value);
            }
        }
    }
    $return = array('create' => $create, 'joined' => $joined);
    return $return;
}

//任务页面任务排序
function task_order($all_task)
{
    /* 以当前的时间为分界线
     * 没有截止的按deadline正序排列
     * 截止了的按createdate倒序排列
     * */
    //step1: 分类
    $overdue = [];  //存储截止了的任务
    $goingon = []; //存储未截止的任务
    foreach ($all_task as $key => $value) {
        if (is_overdue($value['ID'])) {
            array_push($overdue, $value);
        } else {
            array_push($goingon, $value);
        }
    }
    //step2: 分别排序
    if (sizeof($overdue) != 0) {
        $overdue = multiArrSort($overdue, 'create_date', SORT_DESC);
    }
    if (sizeof($goingon) != 0) {
        $goingon = multiArrSort($goingon, 'deadline', SORT_ASC);
    }

    //step3: merge到一起 $goingon在前
    $return = array_merge($goingon, $overdue);
    return $return;
}

//二维数组排序函数
/* 参数: 要排序的数组, 按那个字段排序,升序or降序(SORT_DESC or SORT_ASC)
 * return 排序后的数组
 * ex: $result = multiArrSort($array,'create_date',SORT_DESC)
 * */
function multiArrSort($array, $field, $order)
{
    $arrSort = array();
    foreach ($array as $uniqid => $row) {
        foreach ($row as $key => $value) {
            $arrSort[$key][$uniqid] = $value;
        }
    }
    array_multisort($arrSort[$field], $order, $array);
    return $array;
}


function get_group_ava($group_id, $size)
{
    $url = get_group($group_id)[0]['group_cover'];
    $canvar_id = 'gp_canvas_' . $group_id;
    ?>
    <div id="gp_avatar">
        <canvas width="<?= $size ?>px" height="<?= $size ?>px" id="<?= $canvar_id ?>"></canvas>
    </div>
    <script>
        $(function () {
            var ctx = document.getElementById('<?=$canvar_id?>').getContext('2d');
            var imageObj = new Image();
            imageObj.onload = function () {
                var img_w = this.width;
                var img_h = this.height;
                if (img_w >= img_h) {
                    ctx.drawImage(imageObj, ((img_w - img_h) / 2), 0, img_h, img_h, 0, 0, <?=$size?>, <?=$size?>);
                    $("#<?=$canvar_id?>").css("-webkit-border-radius", "10px");
                }
                else {
                    ctx.drawImage(imageObj, 0, ((img_h - img_w) / 2), img_w, img_w, 0, 0, <?=$size?>, <?=$size?>);
                    $("#<?=$canvar_id?>").css("-webkit-border-radius", "10px");
                }
            };
            imageObj.src = '<?=$url?>';
            $("#<?=$canvar_id?>").show();
        })
    </script>
<?php }

function get_recommand_task($task_id)
{
    global $wpdb;
    $sql = "SELECT * FROM wp_gp_task_member WHERE task_id = $task_id and completion >=5";
    $results = $wpdb->get_results($sql, 'ARRAY_A');
    return $results;
}

function delete_task()
{
    global $wpdb;
    $task_id = $_POST['task_id'];
    $sql_update = "UPDATE wp_gp_task SET task_status = 'trash' WHERE ID = $task_id";
    $wpdb->query($sql_update);
    die();
}

add_action('wp_ajax_delete_task', 'delete_task');
add_action('wp_ajax_nopriv_delete_task', 'delete_task');

function get_group_member_id($group_id)
{
    global $wpdb;
    $sql = "SELECT user_id FROM wp_gp_member WHERE group_id = $group_id";
    $result = $wpdb->get_results($sql);
    return $result;
}


//===============群组消息===========
//获取所有群组消息
function get_allMsg()
{
    global $wpdb;
    $current_user_id = get_current_user_id();
    $sql = "SELECT * FROM wp_gp_notice WHERE user_id = $current_user_id  ORDER BY notice_status,modified_time DESC";
    $result = $wpdb->get_results($sql, 'ARRAY_A');
    return $result;
}

//全部设为已读
function all_set_as_read()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $sql_update = "UPDATE wp_gp_notice SET notice_status = 1 WHERE user_id = $user_id";
    $wpdb->query($sql_update);
    die();
}

add_action('wp_ajax_all_set_as_read', 'all_set_as_read');
add_action('wp_ajax_nopriv_all_set_as_read', 'all_set_as_read');

//删除所有已读群消息
function all_read_delete()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $sql_update = "DELETE FROM wp_gp_notice WHERE user_id = $user_id and notice_status = 1";
    $wpdb->query($sql_update);
    die();
}

add_action('wp_ajax_all_read_delete', 'all_read_delete');
add_action('wp_ajax_nopriv_all_read_delete', 'all_read_delete');

//群消息设为已读
function set_as_read()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $group_id = $_POST['group_id'];
    $notice_type = $_POST['notice_type'];
    $notice_content = $_POST['notice_content'];
    $notice_content_arr = explode(',', $notice_content);
    foreach ($notice_content_arr as $value) {
        $sql_update = "UPDATE wp_gp_notice SET notice_status = 1 
                   WHERE user_id = $user_id and group_id =$group_id and
                   notice_type = $notice_type and notice_content = '$value'";
        $wpdb->query($sql_update);
    }

    die();
}

add_action('wp_ajax_set_as_read', 'set_as_read');
add_action('wp_ajax_nopriv_set_as_read', 'set_as_read');

//有群消息通知
function hasGPNotice($group_id = NULL)
{
    global $wpdb;
    $user_id = get_current_user_id();
    if ($group_id == null) {
        $sql = "SELECT ID FROM wp_gp_notice WHERE user_id = $user_id and notice_status = 0";
        $col = $wpdb->query($sql);
    } else {
        $sql = "SELECT ID FROM wp_gp_notice WHERE user_id = $user_id and group_id = $group_id 
                and notice_type = 3 and notice_status = 0";
        $col = $wpdb->query($sql);
    }
    if ($col != 0) { //有未读消息
        return true;
    } else {
        return false;
    }
}

//合并一些群消息
function processMsg($allMsg)
{
    $result = [];
    if (!empty($allMsg)) {
        foreach ($allMsg as $value) {
            if ($value['notice_type'] != 1 && $value['notice_type'] != 2 && $value['notice_type'] != 3) {
                array_push($result, $value);   //正常处理
            } else {   //需要合并的话
                if (!empty($result)) {
                    $flag = 0; //判断是否push的标志;
                    foreach ($result as &$tmp) {
                        //拼接notice_content,
                        //将value['notice_content']合并到$tmp['notice_content']
                        if ($value['group_id'] == $tmp['group_id'] && $value['notice_type'] == 1
                            && $value['notice_type'] == $tmp['notice_type']
                        ) {
                            $tmp['notice_content'] .= ',' . $value['notice_content'];
                            $flag = 1;
                            break;
                        } else if ($value['group_id'] == $tmp['group_id'] && $value['notice_type'] == 2
                            && $value['notice_type'] == $tmp['notice_type']
                        ) {
                            $tmp['notice_content'] .= ',' . $value['notice_content'];
                            $flag = 1;
                            break;
                        } else if ($value['group_id'] == $tmp['group_id'] && $value['notice_type'] == 3
                            && $value['notice_type'] == $tmp['notice_type']
                        ) {
                            $tmp['notice_content'] .= ',' . $value['notice_content'];
                            $flag = 1;
                            break;
                        } else {
                            //push进result
                            continue;
                        }
                    }
                    if ($flag == 0) {
                        array_push($result, $value);   //正常处理
                    }
                } else {
                    array_push($result, $value);   //正常处理
                }
            }
        }
    }
    return $result;
}

//=============私信===========
//获取当前用户全部私信
function get_allPrivateMsg()
{
    global $wpdb;
    $current_user_id = get_current_user_id();
    $sql = "SELECT * FROM wp_pmessage WHERE to_id = $current_user_id  ORDER BY message_status,modified_time DESC";
    $result = $wpdb->get_results($sql, 'ARRAY_A');
    return $result;
}

//私信全部设为已读
function all_message_set_as_read()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $sql_update = "UPDATE wp_pmessage SET message_status = 1 WHERE to_id = $user_id";
    $wpdb->query($sql_update);
    die();
}

add_action('wp_ajax_all_message_set_as_read', 'all_message_set_as_read');
add_action('wp_ajax_nopriv_all_message_set_as_read', 'all_message_set_as_read');

//删除所有已读私信
function all_message_read_delete()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $sql_update = "DELETE FROM wp_pmessage WHERE to_id = $user_id and message_status = 1";
    $wpdb->query($sql_update);
    die();
}

add_action('wp_ajax_all_message_read_delete', 'all_message_read_delete');
add_action('wp_ajax_nopriv_all_message_read_delete', 'all_message_read_delete');

//私信设为已读
function message_set_as_read()
{
    global $wpdb;
    $id = $_POST['id'];
    $sql_update = "UPDATE wp_pmessage SET message_status = 1 WHERE ID = $id";
    echo $sql_update;
    $wpdb->query($sql_update);
    die();
}

add_action('wp_ajax_message_set_as_read', 'message_set_as_read');
add_action('wp_ajax_nopriv_message_set_as_read', 'message_set_as_read');

//有私信通知
function hasPrivateMessage()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $sql = "SELECT ID FROM wp_pmessage WHERE to_id = $user_id and message_status = 0";
    $col = $wpdb->query($sql);

    if ($col != 0) { //有未读消息
        return true;
    } else {
        return false;
    }
}

//=============普通通知===========
function get_allNotice()
{
    global $wpdb;
    $current_user_id = get_current_user_id();
    $sql = "SELECT * FROM wp_notification WHERE user_id = $current_user_id  ORDER BY notice_status,modified_time DESC";
    $result = $wpdb->get_results($sql, 'ARRAY_A');
    return $result;
}

//删除垃圾评论
function delete_spam_comment($comment_id)
{
    global $wpdb;
    $sql = "DELETE FROM wp_comments WHERE comment_ID = $comment_id";
    $wpdb->query($sql);
}

//点击采纳,添加通知
//add notice type5:
function click_accept()
{
    global $wpdb;
    $answer_id = isset($_POST['ans_id']) ? $_POST['ans_id'] : '';
    if ($answer_id != '') {
        $qid = dwqa_get_question_from_answer_id($answer_id);
        $noticeuser_id = get_post($qid)->post_author;
        $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
        $notice_type = 5;
        $sql_add_notice = "INSERT INTO wp_notification VALUES ('',$noticeuser_id,$notice_type,'$answer_id',0,'$current_time')";
        $wpdb->get_results($sql_add_notice);
        //加回答者积分
        global $integral_system;
        $author = get_post($answer_id)->post_author;
        $score = get_question_offers($qid);
        add_user_integral($author, $score);
        //减提问者积分
        cut_user_integral($noticeuser_id,$score);
    }
}

add_action('wp_ajax_click_accept', 'click_accept');
add_action('wp_ajax_nopriv_click_accept', 'click_accept');

//点击赞同,添加通知
//add notice type5:
function click_vote()
{
    global $wpdb;
    $answer_id = isset($_POST['ans_id']) ? $_POST['ans_id'] : '';
    if ($answer_id != '') {
        $qid = dwqa_get_question_from_answer_id($answer_id);
        $noticeuser_id = get_post($qid)->post_author;
        $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
        $notice_type = 6;
        $sql_add_notice = "INSERT INTO wp_notification VALUES ('',$noticeuser_id,$notice_type,'$answer_id',0,'$current_time')";
        $wpdb->get_results($sql_add_notice);
        //加积分
        global $integral_system;
        $author = get_post($answer_id)->post_author;
        add_user_integral($author, $integral_system['get_vote']);
    }
}

add_action('wp_ajax_click_vote', 'click_vote');
add_action('wp_ajax_nopriv_click_vote', 'click_vote');

//私信全部设为已读
function all_notice_set_as_read()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $sql_update = "UPDATE wp_notification SET notice_status = 1 WHERE user_id = $user_id";
    $wpdb->query($sql_update);
    die();
}

add_action('wp_ajax_all_notice_set_as_read', 'all_notice_set_as_read');
add_action('wp_ajax_nopriv_all_notice_set_as_read', 'all_notice_set_as_read');

//删除所有已读私信
function all_notice_read_delete()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $sql_update = "DELETE FROM wp_notification WHERE user_id = $user_id and notice_status = 1";
    $wpdb->query($sql_update);
    die();
}

add_action('wp_ajax_all_notice_read_delete', 'all_notice_read_delete');
add_action('wp_ajax_nopriv_all_notice_read_delete', 'all_notice_read_delete');

//普通通知设为已读
function notice_set_as_read()
{
    global $wpdb;
    $id = $_POST['id'];
    $sql_update = "UPDATE wp_notification SET notice_status = 1 WHERE ID = $id";
    $wpdb->query($sql_update);
    die();
}

add_action('wp_ajax_notice_set_as_read', 'notice_set_as_read');
add_action('wp_ajax_nopriv_notice_set_as_read', 'notice_set_as_read');

//有普通通知
function hasNotice()
{
    global $wpdb;
    $user_id = get_current_user_id();
    $sql = "SELECT ID FROM wp_notification WHERE user_id = $user_id and notice_status = 0";
    $col = $wpdb->query($sql);

    if ($col != 0) { //有未读消息
        return true;
    } else {
        return false;
    }
}

//建立多校表
function multischool_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "ms";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          uvs_name text NOT NULL,
          uvs_short text NOT NULL,
          post_id int NOT NULL,
          parent_id int ,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}


//权限管理系统
//建表 phpmyadmin添加内联
function rbac_role_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "rbac_role";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          role_name text NOT NULL,
          illustration text NOT NULL,
          author int NOT NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

function rbac_permission_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "rbac_permission";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          permission_name text NOT NULL,
          illustration text NOT NULL,
          author int NOT NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

function rbac_ur_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "rbac_ur";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          role_id int NOT NULL,
          author int NOT NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

function rbac_up_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "rbac_up";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          permission_id int NOT NULL,
          author int NOT NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

function rbac_rp_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "rbac_rp";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          role_id int NOT NULL,
          permission_id int NOT NULL,
          author int NOT NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

function rbac_post_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "rbac_post";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          permission_id int NOT NULL,
          post_id int NOT NULL,
          author int NOT NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

function rbac_apply_tmp_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "rbac_apply_tmp";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          source_type int NOT NULL,
          source_id int NOT NULL,
          state int NOT NULL,
          reason text NULL,
          operator int NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

function rbac_user_post_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "rbac_user_post";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          ID int AUTO_INCREMENT PRIMARY KEY,
          user_id int NOT NULL,
          post_arr text NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//获取所有type=permission、role、user
//word关键词为id或者名称
function rbac_get_all_items($type, $word = '')
{
    global $wpdb;
    if ($word == '') {  //获取所有该类的item,不推荐使用
        if ($type == 'permission') {
            $sql = "SELECT permission_name FROM wp_rbac_permission";
            $pre_result = $wpdb->get_results($sql, 'ARRAY_A');
            $result = array_column($pre_result, 'permission_name');
            return $result;
        } elseif ($type == 'user') {
            $sql = "SELECT user_login FROM wp_users";
            $pre_result = $wpdb->get_results($sql, 'ARRAY_A');
            $result = array_column($pre_result, 'user_login');
            return $result;
        } elseif ($type == 'role') {
            $sql = "SELECT role_name FROM wp_rbac_role";
            $pre_result = $wpdb->get_results($sql, 'ARRAY_A');
            $result = array_column($pre_result, 'role_name');
            return $result;
        } else {
            $sql = "SELECT post_title FROM wp_posts WHERE post_type in ('yada_wiki','post') and post_status='publish'";
            $pre_result = $wpdb->get_results($sql, 'ARRAY_A');
            $result = array_column($pre_result, 'post_title');
            return $result;
        }
    } else {
        if ($type == 'permission') {
            $sql = "SELECT permission_name FROM wp_rbac_permission WHERE permission_name like '%$word%'";
            $pre_result = $wpdb->get_results($sql, 'ARRAY_A');
            $result = array_column($pre_result, 'permission_name');
            return $result;
        } elseif ($type == 'user') {
            $sql = "SELECT user_login FROM wp_users WHERE user_login like '%$word%'";
            $pre_result = $wpdb->get_results($sql, 'ARRAY_A');
            $result = array_column($pre_result, 'user_login');
            return $result;
        } else {
            $sql = "SELECT role_name FROM wp_rbac_role WHERE role_name like '%$word%'";
            $pre_result = $wpdb->get_results($sql, 'ARRAY_A');
            $result = array_column($pre_result, 'role_name');
            return $result;
        }
    }
}

//联想功能
function rbac_autocomplete()
{
    //为了联想
    $type = $_POST['part'];
    $word = $_POST['word'];
    $all_items = rbac_get_all_items($type, $word);
    $tmp = '';
    if ($word != '') {
        $pattern = "/" . $word . "/i";
        foreach ($all_items as $value) {
            if (preg_match($pattern, $value)) {   //如果搜到
                $tmp .= $value;
                $tmp .= '|';
            }
        }
    }
    echo $tmp;
    die();
}

add_action('wp_ajax_rbac_autocomplete', 'rbac_autocomplete');
add_action('wp_ajax_nopriv_rbac_autocomplete', 'rbac_autocomplete');

//判断是否有权限、用户、角色
function rbac_hasItem()
{
    //为了联想
    $type = $_POST['part'];
    $word = $_POST['word'];
    $all_items = rbac_get_all_items($type, $word);   //数组
    if (in_array($word, $all_items)) {
        echo get_type_id($type, $word);
    } else {
        echo false;
    }
    die();
}

add_action('wp_ajax_rbac_hasItem', 'rbac_hasItem');
add_action('wp_ajax_nopriv_rbac_hasItem', 'rbac_hasItem');

//在检索资源的时候判断是否有该post、category、tag
function rbac_hasPost()
{
    global $wpdb;
    $creation = $_POST['creation'];
    $word = $_POST['word'];
    $result = [];
    if ($creation == 'name') {
        //选出所有post匹配当前word的post
        $sql = "SELECT ID,post_type FROM wp_posts WHERE post_title ='$word' and post_type in ('yada_wiki','post') and post_status='publish'";
        $pre_result = $wpdb->get_results($sql);
        if (sizeof($pre_result) != 0) {
            foreach ($pre_result as $v) {
                $id = $v->ID;
                $t = get_post($id);
                $post_title = $t->post_title;
                $post_type = $v->post_type;
                $tmp[] = [$id, $post_title, $post_type];
            }
            $result = json_encode($tmp);
        } else {
            $result = json_encode($result);
        }
        echo $result;
    } else {
        if ($creation == 'cate') {
            $sql = "SELECT t.term_id,t.name,tt.count FROM wp_term_taxonomy as tt LEFT JOIN wp_terms as t
              ON tt.term_id=t.term_id WHERE tt.taxonomy in ('category','wiki_cats') and tt.count!=0 and t.name ='$word'";
        } else {
            $sql = "SELECT t.term_id,t.name,tt.count FROM wp_term_taxonomy as tt LEFT JOIN wp_terms as t
              ON tt.term_id=t.term_id WHERE tt.taxonomy in ('post_tag','wiki_tags') and tt.count!=0 and t.name ='$word'";
        }
        $pre_result = $wpdb->get_results($sql);
        if (sizeof($pre_result) != 0) {
            foreach ($pre_result as $v) {
                $cat_id = $v->term_id;
                $count = $v->count;
                //有post对应这个分类,获取post
                $sql = "SELECT object_id FROM wp_term_relationships WHERE term_taxonomy_id=$cat_id";
                $mid_result = $wpdb->get_results($sql);
                foreach ($mid_result as $m) {
                    $t = get_post($m->object_id);
                    $id = $m->object_id;
                    $post_title = $t->post_title;
                    $post_type = $t->post_type;
                    $tmp[] = [$id, $post_title, $post_type];
                }
                $result = json_encode($tmp);
            }
        } else {
            $result = json_encode($result);
        }
        echo $result;
    }
    die();

}

add_action('wp_ajax_rbac_hasPost', 'rbac_hasPost');
add_action('wp_ajax_nopriv_rbac_hasPost', 'rbac_hasPost');

//获取某一权限的所有post_id
function get_permission_post($pid)
{
    global $wpdb;
    $sql = "SELECT post_id FROM wp_rbac_post WHERE permission_id=$pid";
    $pre_result = $wpdb->get_results($sql, 'ARRAY_A');
    $result = array_column($pre_result, 'post_id');
    return $result;
}


//查看权限的资源的ajax
function rbac_get_permission_post()
{
    $pid = $_POST['permission_id'];
    $post_ids = get_permission_post($pid);
    $result = [];
    if ($post_ids != []) {
        foreach ($post_ids as $p) {
            $post = get_post($p);
            $post_title = $post->post_title;
            $post_type = $post->post_type;
            $tmp[] = [$p, $post_title, $post_type];
        }
        $result = json_encode($tmp);
    } else {
        $result = json_encode($result);
    }
    echo $result;
    die();
}

add_action('wp_ajax_rbac_get_permission_post', 'rbac_get_permission_post');
add_action('wp_ajax_nopriv_rbac_get_permission_post', 'rbac_get_permission_post');


//根据各类型的名字输出id
function get_type_id($type, $word)
{
    global $wpdb;
    if ($type == 'permission') {
        $sql = "SELECT ID FROM wp_rbac_permission WHERE permission_name= '$word'";
        $result = $wpdb->get_results($sql)[0]->ID;
        return $result;
    } elseif ($type == 'user') {
        $sql = "SELECT ID FROM wp_users WHERE user_login = '$word'";
        $result = $wpdb->get_results($sql)[0]->ID;
        return $result;
    } elseif ($type == 'role') {
        $sql = "SELECT ID FROM wp_rbac_role WHERE role_name = '$word'";
        $result = $wpdb->get_results($sql)[0]->ID;
        return $result;
    } else {
        $sql = "SELECT ID FROM wp_posts WHERE post_title = '$word'";
        $result = $wpdb->get_results($sql)[0]->ID;
        return $result;
    }
}

//赋予权限
function grant_rp_confirm()
{
    global $wpdb;
    $role_id = explode(',', $_POST['role_id']);
    $permission_id = explode(',', $_POST['permission_id']);
    $author = get_current_user_id();
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    foreach ($role_id as $r) {
        foreach ($permission_id as $p) {
            //确认有没有这个r-p对
            $sql_c = "SELECT ID FROM wp_rbac_rp WHERE role_id=$r and pms_id = $p";
            $col = $wpdb->query($sql_c);
            if ($col == 0) {
                $sql = "INSERT INTO wp_rbac_rp VALUES ('',$r,$p,$author,'$current_time')";
                $wpdb->query($sql);
            }
        }
    }
    die();
}

add_action('wp_ajax_grant_rp_confirm', 'grant_rp_confirm');
add_action('wp_ajax_nopriv_grant_rp_confirm', 'grant_rp_confirm');

function grant_ur_confirm()
{
    global $wpdb;
    $user_id = explode(',', $_POST['user_id']);
    $role_id = explode(',', $_POST['role_id']);
    $author = get_current_user_id();
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    foreach ($user_id as $u) {
        foreach ($role_id as $r) {
            //确认有没有这个u-r对
            $sql_c = "SELECT ID FROM wp_rbac_ur WHERE user_id=$u and role_id = $r";
            $col = $wpdb->query($sql_c);
            if ($col == 0) {
                $sql = "INSERT INTO wp_rbac_ur VALUES ('',$u,$r,$author,'$current_time')";
                $wpdb->query($sql);
            }
        }
    }
    die();
}

add_action('wp_ajax_grant_ur_confirm', 'grant_ur_confirm');
add_action('wp_ajax_nopriv_grant_ur_confirm', 'grant_ur_confirm');

function grant_up_confirm()
{
    global $wpdb;
    $user_id = explode(',', $_POST['user_id']);
    $permission_id = explode(',', $_POST['permission_id']);
    $author = get_current_user_id();
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);

    foreach ($user_id as $u) {
        $all_permission = rbac_get_user_all_permission($u);
        foreach ($permission_id as $p) {
            if (in_array($p, $all_permission)) {
                break;
            }
            //确认有没有这个u-p对
            $sql_c = "SELECT ID FROM wp_rbac_up WHERE user_id=$u and permission_id = $p";
            $col = $wpdb->query($sql_c);
            if ($col == 0) {
                $sql = "INSERT INTO wp_rbac_up VALUES ('',$u,$p,$author,'$current_time')";
                $wpdb->query($sql);
            }
        }
    }

    die();
}

add_action('wp_ajax_grant_up_confirm', 'grant_up_confirm');
add_action('wp_ajax_nopriv_grant_up_confirm', 'grant_up_confirm');


//查询角色对应的权限or权限对应的角色(单表的)
//type代表要查询的类型(如role),id是role的id
//返回值是role对应的权限id数组
function get_rbac_rp_relation($type, $id)
{
    global $wpdb;
    if ($type == 'role') {
        $sql = "SELECT permission_id FROM wp_rbac_rp WHERE role_id = $id";
        $preresult = $wpdb->get_results($sql, 'ARRAY_A');
        $result = array_column($preresult, 'permission_id');
        return $result;
    } else {
        $sql = "SELECT role_id FROM wp_rbac_rp WHERE permission_id = $id";
        $preresult = $wpdb->get_results($sql, 'ARRAY_A');
        $result = array_column($preresult, 'role_id');
        return $result;
    }
}

//查询用户对应的权限or用户对应的角色(单表的)
//type代表要查询的类型(如role),id是user的id
//返回值是user对应的权限角色id数组
function get_rbac_user_relation($type, $id)
{
    global $wpdb;
    if ($type == 'role') {
        $sql = "SELECT role_id FROM wp_rbac_ur WHERE user_id = $id";
        $preresult = $wpdb->get_results($sql, 'ARRAY_A');
        $result = array_column($preresult, 'role_id');
        return $result;
    } else {
        $sql = "SELECT permission_id FROM wp_rbac_up WHERE user_id = $id";
        $preresult = $wpdb->get_results($sql, 'ARRAY_A');
        $result = array_column($preresult, 'permission_id');
        return $result;
    }
}

//获取权限或角色信息(只包括单表数据)
function get_rbac_info($type, $id)
{
    global $wpdb;
    $sql = "SELECT * FROM wp_rbac_$type WHERE ID = $id";
    $result = $wpdb->get_results($sql)[0];
    return $result;
}

//获取用户、角色、权限表格(授予部分)中的信息
function rbac_get_table_info()
{
    global $wpdb;
    $type = $_POST['part'];
    $word = $_POST['word'];
    if ($type == 'user') {
        //需要的信息有 name,id, 创建日期,对应角色, 对应权限
        $sql = "SELECT ID,user_login,user_registered FROM wp_users WHERE user_login = '$word'";  //选出基本的权限信息
        $pre_result = $wpdb->get_results($sql)[0];
        //获取用户角色信息
        $role_id = get_rbac_user_relation('role', $pre_result->ID);   //根据权限ID去选对应的角色
        $role_name = [];
        foreach ($role_id as $r) {
            $role_name[] = get_rbac_info('role', $r)->role_name;
        }
        $role = implode(PHP_EOL, $role_name);   //角色用回车链接

        //获取角色对应的权限信息
        $permission_name = [];
        foreach ($role_id as $r) {
            $pid = get_rbac_rp_relation('role', $r);
            foreach ($pid as $p) {
                $permission_name[] = get_rbac_info('permission', $p)->permission_name;
            }
        }
        //获取用户单独的权限信息
        $permission_id = get_rbac_user_relation('permission', $pre_result->ID);
        foreach ($permission_id as $p) {
            $permission_name[] = get_rbac_info('permission', $p)->permission_name;
        }
        $permission_name = array_unique($permission_name);
        $permission = implode(PHP_EOL, $permission_name);
        $tmp = [$pre_result->user_login, $pre_result->ID, $pre_result->user_registered, $role, $permission];
        echo json_encode($tmp);
        die();
    } elseif ($type == 'permission') {
        //需要的信息有 name,id,说明,创建日期,对应角色,需要处理
        $sql = "SELECT * FROM wp_rbac_permission WHERE permission_name = '$word'";  //选出基本的权限信息
        $pre_result = $wpdb->get_results($sql)[0];
        $role_id = get_rbac_rp_relation('permission', $pre_result->ID);   //根据权限ID去选对应的角色
        $role_name = [];
        foreach ($role_id as $r) {
            $role_name[] = get_rbac_info('role', $r)->role_name;
        }
        $role = implode(PHP_EOL, $role_name);   //角色用回车链接
        $tmp = [$pre_result->permission_name, $pre_result->ID, $role, $pre_result->modified_time, $pre_result->illustration];
        echo json_encode($tmp);
        die();
    } else {
        //如果是角色信息
        $sql = "SELECT * FROM wp_rbac_role WHERE role_name = '$word'";
        $pre_result = $wpdb->get_results($sql)[0];
        $permission_id = get_rbac_rp_relation('role', $pre_result->ID);
        $permission_name = [];
        foreach ($permission_id as $p) {
            $permission_name[] = get_rbac_info('permission', $p)->permission_name;
        }
        $permission = implode(PHP_EOL, $permission_name);
        $tmp = [$pre_result->role_name, $pre_result->ID, $permission, $pre_result->modified_time, $pre_result->illustration];
        echo json_encode($tmp);
        die();
    }
}

add_action('wp_ajax_rbac_get_table_info', 'rbac_get_table_info');
add_action('wp_ajax_nopriv_rbac_get_table_info', 'rbac_get_table_info');

//获取角色、权限表格(配置部分)中的信息
function rbac_get_list_info()
{
    global $wpdb;
    $type = $_POST['part'];
    $word = $_POST['word'];
//    if ($type == 'user') {
//        //需要的信息有 name,id, 创建日期,对应角色, 对应权限
//        $sql = "SELECT ID,user_login,user_registered FROM wp_users WHERE user_login = '$word'";  //选出基本的权限信息
//        $pre_result = $wpdb->get_results($sql)[0];
//        //获取用户角色信息
//        $role_id = get_rbac_user_relation('role',$pre_result->ID);   //根据权限ID去选对应的角色
//        $role_name =[];
//        foreach ($role_id as $r){
//            $role_name[] = get_rbac_info('role',$r)->role_name;
//        }
//        $role = implode(PHP_EOL,$role_name);   //角色用回车链接
//
//        //获取角色对应的权限信息
//        $permission_name =[];
//        foreach($role_id as $r){
//            $pid = get_rbac_rp_relation('role',$r);
//            foreach ($pid as $p){
//                $permission_name[] = get_rbac_info('permission',$p)->permission_name;
//            }
//        }
//        //获取用户单独的权限信息
//        $permission_id = get_rbac_user_relation('permission',$pre_result->ID);
//        foreach ($permission_id as $p){
//            $permission_name[] = get_rbac_info('permission',$p)->permission_name;
//        }
//        $permission = implode(PHP_EOL,$permission_name);
//
//        $tmp = [$pre_result->user_login,$pre_result->ID,$pre_result->user_registered, $role,$permission];
//        echo json_encode($tmp);
//        die();
//    }
    if ($word == '') {
        if ($type == 'permission') {
            //需要的信息有 name,id,说明,创建日期,对应角色,需要处理
            $sql = "SELECT * FROM wp_rbac_permission";  //选出所有的权限信息
            $pre_result = $wpdb->get_results($sql);
            foreach ($pre_result as $p) {
                $role_id = get_rbac_rp_relation('permission', $p->ID);   //根据权限ID去选对应的角色
                $role_name = [];
                foreach ($role_id as $r) {
                    $role_name[] = get_rbac_info('role', $r)->role_name;
                }
                $role = implode('<br>', $role_name);   //角色用回车链接
                $tmp[] = [$p->permission_name, $p->ID, $role, $p->modified_time, $p->illustration];
            }
            echo json_encode($tmp);
            die();
        } else {
            //如果是角色信息
            $sql = "SELECT * FROM wp_rbac_role";
            $pre_result = $wpdb->get_results($sql);
            foreach ($pre_result as $r) {
                $permission_id = get_rbac_rp_relation('role', $r->ID);
                $permission_name = [];
                foreach ($permission_id as $p) {
                    $permission_name[] = get_rbac_info('permission', $p)->permission_name;
                }
                $permission = implode('<br>', $permission_name);
                $tmp[] = [$r->role_name, $r->ID, $permission, $r->modified_time, $r->illustration];
            }
            echo json_encode($tmp);
            die();
        }
    } else {
        if ($type == 'permission') {
            //需要的信息有 name,id,说明,创建日期,对应角色,需要处理
            $sql = "SELECT * FROM wp_rbac_permission WHERE permission_name = '$word'";  //选出基本的权限信息
            $pre_result = $wpdb->get_results($sql)[0];
            $role_id = get_rbac_rp_relation('permission', $pre_result->ID);   //根据权限ID去选对应的角色
            $role_name = [];
            foreach ($role_id as $r) {
                $role_name[] = get_rbac_info('role', $r)->role_name;
            }
            $role = implode('<br>', $role_name);   //角色用回车链接
            $tmp = [$pre_result->permission_name, $pre_result->ID, $role, $pre_result->modified_time, $pre_result->illustration];
            echo json_encode($tmp);
            die();
        } else {
            //如果是角色信息
            $sql = "SELECT * FROM wp_rbac_role WHERE role_name = '$word'";
            $pre_result = $wpdb->get_results($sql)[0];
            $permission_id = get_rbac_rp_relation('role', $pre_result->ID);
            $permission_name = [];
            foreach ($permission_id as $p) {
                $permission_name[] = get_rbac_info('permission', $p)->permission_name;
            }
            $permission = implode('<br>', $permission_name);
            $tmp = [$pre_result->role_name, $pre_result->ID, $permission, $pre_result->modified_time, $pre_result->illustration];
            echo json_encode($tmp);
            die();
        }
    }
}

add_action('wp_ajax_rbac_get_list_info', 'rbac_get_list_info');
add_action('wp_ajax_nopriv_rbac_get_list_info', 'rbac_get_list_info');

//获取用户(查看部分 的信息)
function rbac_get_user_info()
{
//    global $wpdb;
    $type = $_POST['part'];   //user
    $word = $_POST['word'];    //user_name
    $rp = [];
    $rp_name = [];
    if ($type != '' && $word != '') {
        $user_id = get_the_ID_by_name($word);
        $role_id = get_rbac_user_relation('role', $user_id);
        //role对应的permission
        $role_name = [];
        foreach ($role_id as $r) {
            $role_name[] = get_rbac_info('role', $r)->role_name;
            $tmp_id = get_rbac_rp_relation('role', $r);
            $tmp_name = [];
            foreach ($tmp_id as $v) {
                $tmp_name[] = get_rbac_info('permission', $v)->permission_name;
            }
            if (!empty($tmp_id)) {
                $rp[] = $tmp_id;
                $rp_name[] = $tmp_name;
            }
        }

        //单独的permission
        $permission_id = get_rbac_user_relation('permission', $user_id);
        $permission_name = [];
        foreach ($permission_id as $p) {
            $permission_name[] = get_rbac_info('permission', $p)->permission_name;
        }
        $tmp = [$role_id, $role_name, $rp, $rp_name, $permission_id, $permission_name, $user_id];
        echo json_encode($tmp);
    } else {
        echo json_encode([]);
    }
    die();
}

add_action('wp_ajax_rbac_get_user_info', 'rbac_get_user_info');
add_action('wp_ajax_nopriv_rbac_get_user_info', 'rbac_get_user_info');

//获得用户的所有权限,包括角色带的和自身有的
//输入值是用户id
function rbac_get_user_all_permission($id)
{
    $result = rbac_get_user_role_permission($id);
    //permission对应的
    $permission_id = get_rbac_user_relation('permission', $id);
    if (!empty($permission_id)) {
        $result[] = $permission_id;
        $result = flatten_array($result);
    }
    return $result;
}

//获取用户角色对应的权限
function rbac_get_user_role_permission($id)
{
    $role_id = get_rbac_user_relation('role', $id);
    $result = [];
    //role对应的
    foreach ($role_id as $r) {
        $tmp_id = get_rbac_rp_relation('role', $r);
        if (!empty($tmp_id)) {
            $result[] = $tmp_id;
        }
    }
    $result = flatten_array($result);
    return $result;
}


//二维数组扁平化和去重
function flatten_array($arr)
{
    $result = [];
    foreach ($arr as $key => $value) {
        foreach ($value as $v) {
            $result[] = $v;
        }
    }
    $result = array_unique($result);
    return $result;
}

//删除用户权限
function rbac_user_permission_delete()
{
    global $wpdb;
    $user_id = $_POST['user_id'];
    $permission_id = $_POST['permission_id'];
    $sql = "DELETE FROM wp_rbac_up WHERE user_id=$user_id and permission_id=$permission_id";
    $wpdb->query($sql);
    die();
}

add_action('wp_ajax_rbac_user_permission_delete', 'rbac_user_permission_delete');
add_action('wp_ajax_nopriv_rbac_user_permission_delete', 'rbac_user_permission_delete');


//删除用户角色
function rbac_user_role_delete()
{
    global $wpdb;
    $user_id = $_POST['user_id'];
    $role_id = $_POST['role_id'];
    $sql = "DELETE FROM wp_rbac_ur WHERE user_id=$user_id and role_id=$role_id";
    $wpdb->query($sql);
    die();

}

add_action('wp_ajax_rbac_user_role_delete', 'rbac_user_role_delete');
add_action('wp_ajax_nopriv_rbac_user_role_delete', 'rbac_user_role_delete');


//检查角色名或者权限名是否重复
function check_rbac_name()
{
    global $wpdb;
    $name = isset($_POST['Name']) ? $_POST['Name'] : "";
    $type = isset($_POST['part']) ? $_POST['part'] : "role";
    $type_name = $type . "_name";
    if ($name != '') {
        $sql = "SELECT ID FROM wp_rbac_$type WHERE $type_name = '$name'";
        $col = $wpdb->query($sql);
        if ($col == 0) {
            $response = true;
        } else {
            $response = false;
        }
    } else {
        $response = false;
    }
    echo $response;
    exit();
}

add_action('wp_ajax_check_rbac_name', 'check_rbac_name');
add_action('wp_ajax_nopriv_check_rbac_name', 'check_rbac_name');

//角色绑定了多少用户?权限绑定了多少角色
function layer_confirm_delete()
{
    global $wpdb;
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $type = isset($_POST['part']) ? $_POST['part'] : "role";
    if ($type == 'role') {
        $sql = "select ID from wp_rbac_ur WHERE role_id = $id";
        $col = $wpdb->query($sql);
    } else {
        $sql = "select ID from wp_rbac_rp WHERE permission_id = $id";
        $col = $wpdb->query($sql);
    }
    echo $col;
    die();
}

add_action('wp_ajax_layer_confirm_delete', 'layer_confirm_delete');
add_action('wp_ajax_nopriv_layer_confirm_delete', 'layer_confirm_delete');

//执行删除角色或权限的操作
function confirm_delete()
{
    global $wpdb;
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    $type = isset($_POST['part']) ? $_POST['part'] : "role";
    if ($type == 'role') {
        //删除角色表
        $sql_role = "DELETE from wp_rbac_role WHERE ID = $id";
        $wpdb->query($sql_role);
        //删除角色权限关联
        $sql_rp = "DELETE from wp_rbac_rp WHERE role_id = $id";
        $wpdb->query($sql_rp);
        //删除角色用户关联
        $sql_ur = "DELETE from wp_rbac_ur WHERE role_id = $id";
        $wpdb->query($sql_ur);
    } else {
        //删除权限表
        $sql_role = "DELETE from wp_rbac_permission WHERE ID = $id";
        $wpdb->query($sql_role);
        //删除角色权限关联
        $sql_rp = "DELETE from wp_rbac_rp WHERE permission_id = $id";
        $wpdb->query($sql_rp);
        //删除角色用户关联
        $sql_ur = "DELETE from wp_rbac_ur WHERE permission_id = $id";
        $wpdb->query($sql_ur);
    }
    die();
}

add_action('wp_ajax_confirm_delete', 'confirm_delete');
add_action('wp_ajax_nopriv_confirm_delete', 'confirm_delete');

//取消编辑
function cancel_config()
{
    global $wpdb;
    $type = $_POST['part'];
    $id = $_POST['id'];
    if ($type == 'permission') {
        //需要的信息有 name,id,说明,创建日期,对应角色,需要处理
        $sql = "SELECT * FROM wp_rbac_permission WHERE ID = $id";  //选出基本的权限信息
        $pre_result = $wpdb->get_results($sql)[0];
        $role_id = get_rbac_rp_relation('permission', $id);   //根据权限ID去选对应的角色
        $role_name = [];
        foreach ($role_id as $r) {
            $role_name[] = get_rbac_info('role', $r)->role_name;
        }
        $role = implode(PHP_EOL, $role_name);   //角色用回车链接
        $tmp = [$pre_result->permission_name, $pre_result->ID, $role, $pre_result->modified_time, $pre_result->illustration];
        echo json_encode($tmp);
        die();
    } else {
        //如果是角色信息
        $sql = "SELECT * FROM wp_rbac_role WHERE ID = '$id'";
        $pre_result = $wpdb->get_results($sql)[0];
        $permission_id = get_rbac_rp_relation('role', $id);
        $permission_name = [];
        foreach ($permission_id as $p) {
            $permission_name[] = get_rbac_info('permission', $p)->permission_name;
        }
        $permission = implode(PHP_EOL, $permission_name);
        $tmp = [$pre_result->role_name, $pre_result->ID, $permission, $pre_result->modified_time, $pre_result->illustration];
        echo json_encode($tmp);
        die();
    }
}

add_action('wp_ajax_cancel_config', 'cancel_config');
add_action('wp_ajax_nopriv_cancel_config', 'cancel_config');

//保存编辑
function save_config()
{
    global $wpdb;
    $type = $_POST['part'];
    $id = $_POST['id'];
    $name = $_POST['name'];
    $ill = $_POST['ill'];
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    $author = get_current_user_id();
    if ($type == 'permission') {
        //更新信息
        $sql_update = "UPDATE wp_rbac_permission SET permission_name = '$name',illustration='$ill',
                      modified_time = '$current_time',author=$author WHERE ID=$id";
        $wpdb->get_results($sql_update);

        //需要的信息有 name,id,说明,创建日期,对应角色,需要处理
        $sql = "SELECT * FROM wp_rbac_permission WHERE ID = $id";  //选出基本的权限信息
        $pre_result = $wpdb->get_results($sql)[0];
        $role_id = get_rbac_rp_relation('permission', $id);   //根据权限ID去选对应的角色
        $role_name = [];
        foreach ($role_id as $r) {
            $role_name[] = get_rbac_info('role', $r)->role_name;
        }
        $role = implode(PHP_EOL, $role_name);   //角色用回车链接
        $tmp = [$pre_result->permission_name, $pre_result->ID, $role, $pre_result->modified_time, $pre_result->illustration];
        echo json_encode($tmp);
        die();
    } else {
        //更新信息
        $sql_update = "UPDATE wp_rbac_role SET role_name = '$name',illustration='$ill',
                       modified_time = '$current_time',author=$author WHERE ID = $id";
        $wpdb->get_results($sql_update);
        //如果是角色信息
        $sql = "SELECT * FROM wp_rbac_role WHERE ID = '$id'";
        $pre_result = $wpdb->get_results($sql)[0];
        $permission_id = get_rbac_rp_relation('role', $id);
        $permission_name = [];
        foreach ($permission_id as $p) {
            $permission_name[] = get_rbac_info('permission', $p)->permission_name;
        }
        $permission = implode(PHP_EOL, $permission_name);
        $tmp = [$pre_result->role_name, $pre_result->ID, $permission, $pre_result->modified_time, $pre_result->illustration];
        echo json_encode($tmp);
        die();
    }
}

add_action('wp_ajax_save_config', 'save_config');
add_action('wp_ajax_nopriv_save_config', 'save_config');

//配置页
function get_config_url()
{
    $type = $_POST['part'];
    if ($type == 'role') {
        echo site_url() . get_page_address('config_role');
        die();
    } else {
        echo site_url() . get_page_address('config_permission');
        die();
    }
}

add_action('wp_ajax_get_config_url', 'get_config_url');
add_action('wp_ajax_nopriv_get_config_url', 'get_config_url');

//解除关联
function rp_disassociate()
{
    global $wpdb;
    $rid = isset($_POST['rid']) ? $_POST['rid'] : "";
    $pid = isset($_POST['pid']) ? $_POST['pid'] : "";
    if ($rid != '' && $pid != '') {
        $sql = "DELETE FROM wp_rbac_rp WHERE role_id=$rid and permission_id=$pid";
        $wpdb->get_results($sql);
    }
    die();
}

add_action('wp_ajax_rp_disassociate', 'rp_disassociate');
add_action('wp_ajax_nopriv_rp_disassociate', 'rp_disassociate');

//权限与资源对应的自动补充
function rbac_post_autocomplete()
{
    global $wpdb;
    $creation = isset($_POST['creation']) ? $_POST['creation'] : 'name';
    $post_name = $_POST['word'];
    if ($creation == 'name') {
        $sql = "SELECT ID,post_title FROM wp_posts WHERE post_title like '%$post_name%' and post_type IN('post','yada_wiki') and post_status = 'publish'";
        $result = $wpdb->get_results($sql);
        $tmp = json_encode($result);
    } elseif ($creation == 'cate') {
        $sql = "SELECT t.term_id,t.name,tt.count FROM wp_term_taxonomy as tt LEFT JOIN wp_terms as t
              ON tt.term_id=t.term_id WHERE tt.taxonomy in ('category','wiki_cats') and tt.count!=0 and t.name like '%$post_name%'";
        $result = $wpdb->get_results($sql);
        $tmp = json_encode($result);
    } else {
        $sql = "SELECT t.term_id,t.name,tt.count FROM wp_term_taxonomy as tt LEFT JOIN wp_terms as t
              ON tt.term_id=t.term_id WHERE tt.taxonomy in ('post_tag','wiki_tags') and tt.count!=0 and t.name like '%$post_name%'";
        $result = $wpdb->get_results($sql);
        $tmp = json_encode($result);
    }
    echo $tmp;
    die();

}

add_action('wp_ajax_rbac_post_autocomplete', 'rbac_post_autocomplete');
add_action('wp_ajax_nopriv_rbac_post_autocomplete', 'rbac_post_autocomplete');

//删除资源, 如果资源不对应其他权限，则将其放回公共资源，否则不变
//对于用户-资源表, 刷新。
function rbac_delete_post()
{
    global $wpdb;
    $pid = isset($_POST['permission_id']) ? $_POST['permission_id'] : '';
    $delete_id = $_POST['delete_id'];
    foreach ($delete_id as $p) {
        $sql = "DELETE FROM wp_rbac_post WHERE post_id=$p and permission_id=$pid";
        $wpdb->get_results($sql);
        //如果这个资源还对应别的权限,则不用处理,如果她不对应任何权限,则回到公共资源里
        $result = apply_permission($p)['permission_id'];
        if (sizeof($result) == 0) {
            update_public_post([$p],'add');
        }
    }
    die();
}

add_action('wp_ajax_rbac_delete_post', 'rbac_delete_post');
add_action('wp_ajax_nopriv_rbac_delete_post', 'rbac_delete_post');

//添加资源, 一旦资源有了权限，就将其从公共资源删除，对于用户资源表，刷新
function rbac_add_post()
{
    global $wpdb;
    $pid = isset($_POST['permission_id']) ? $_POST['permission_id'] : '';
    $add_id = $_POST['add_id'];
    foreach ($add_id as $p) {
        $sql_pre = "SELECT ID FROM wp_rbac_post WHERE post_id=$p and permission_id=$pid";
        echo $sql_pre;
        $col = $wpdb->query($sql_pre);
        if ($col == 0) {
            $author = get_current_user_id();
            $modified_time = date('Y-m-d H:i:s', time() + 8 * 3600);
            $sql = "INSERT INTO wp_rbac_post VALUES ('',$pid,$p,$author,'$modified_time')";
            $wpdb->get_results($sql);
        }
    }
    update_public_post($add_id,'delete');
    die();
}

add_action('wp_ajax_rbac_add_post', 'rbac_add_post');
add_action('wp_ajax_nopriv_rbac_add_post', 'rbac_add_post');

//申请权限页面
function apply_permission_ajax()
{
    $post_id = $_POST['id'];
    $r = apply_permission($post_id);  //权限和角色的id
    //获取权限信息
    function a(&$v, $p)
    {
        $v = $p;
        return $v;
    }

    if ($r['permission_id'] != []) {
        foreach ($r['permission_id'] as $pid) {
            $p = get_rbac_info('permission', $pid);
            $p_name = $p->permission_name;
            $p_ill = $p->illustration;
            $ptmp[] = [$pid, $p_name, $p_ill];
        }
        $r['permission_id'] = array_map('a', $r['permission_id'], $ptmp);
    }
    if ($r['role_id'] != []) {
        foreach ($r['role_id'] as $rid) {
            $t = get_rbac_info('role', $rid);
            $r_name = $t->role_name;
            $r_ill = $t->illustration;
            $rtmp[] = [$rid, $r_name, $r_ill];
        }
        $r['role_id'] = array_map('a', $r['role_id'], $rtmp);
    }
    $result = json_encode($r);
    echo $result;
    die();
}

add_action('wp_ajax_apply_permission_ajax', 'apply_permission_ajax');
add_action('wp_ajax_nopriv_apply_permission_ajax', 'apply_permission_ajax');

//获取一个资源对应的权限和角色
function apply_permission($post_id)
{
    global $wpdb;
    $result = [];
    $r_result = [];
    //选择该post—permission
    $sql_pp = "SELECT permission_id FROM  wp_rbac_post WHERE post_id=$post_id";
    $pre_result = $wpdb->get_results($sql_pp, 'ARRAY_A');
    $p_result = array_column($pre_result, 'permission_id');

    //选择该permission对应的role
    if ($p_result != []) {
        foreach ($p_result as $p) {
            $sql_pr = "SELECT role_id FROM  wp_rbac_rp WHERE permission_id=$p";
            $pre_result = $wpdb->get_results($sql_pr, 'ARRAY_A');
            $tmp[] = array_column($pre_result, 'role_id');
        }
        $r_result = flatten_array($tmp);
    }
    $result = array('permission_id' => $p_result, 'role_id' => $r_result);
    return $result;
}

//获取未处理的审核信息
function rbac_get_apply_info()
{
    global $wpdb;
    $sql = "SELECT * FROM wp_rbac_apply_tmp WHERE state = 0";//选出所有未操作的数据
    $pre_result = $wpdb->get_results($sql, 'ARRAY_A');
    $map = ['权限', '角色'];
    function a(&$v, $p)
    {
        $v = array_merge($v, $p);
        return $v;
    }

    if ($pre_result != []) {
        foreach ($pre_result as $r) {
            $user_name = get_the_author_meta('user_login', $r['user_id']);
            $item_type = $map[$r['source_type']];
            if ($r['source_type'] == 0) {
                $item_name = get_rbac_info('permission', $r['source_id'])->permission_name;
            } else {
                $item_name = get_rbac_info('role', $r['source_id'])->role_name;
            }
            $tmp[] = array('applyer' => $user_name, 'item_name' => $item_name, 'item_type' => $item_type);

        }
        $result = array_map('a', $pre_result, $tmp);
    } else {
        $result = [];
    }
    return $result;
}

//获取已经处理过的信息
function rbac_get_solved_info()
{
    global $wpdb;
    $sql = "SELECT * FROM wp_rbac_apply_tmp WHERE state IN (1,2)";//选出所有操作过的数据
    $pre_result = $wpdb->get_results($sql, 'ARRAY_A');
    $map = ['权限', '角色'];
    $state = ['已通过', '已驳回'];
    function a(&$v, $p)
    {
        $v = array_merge($v, $p);
        return $v;
    }

    if ($pre_result != []) {
        foreach ($pre_result as $r) {
            $user_name = get_the_author_meta('user_login', $r['user_id']);   //申请人姓名
            $item_type = $map[$r['source_type']];   //申请类型
            if ($r['source_type'] == 0) {
                $item_name = get_rbac_info('permission', $r['source_id'])->permission_name;  //申请名称
            } else {
                $item_name = get_rbac_info('role', $r['source_id'])->role_name;
            }
            $apply_state = $state[$r['state'] - 1];   //申请状态
            $manager = get_the_author_meta('user_login', $r['operator']);
            $tmp[] = array('applyer' => $user_name, 'item_name' => $item_name, 'item_type' => $item_type, 'manager' => $manager, 't_state' => $apply_state);

        }
        $result = array_map('a', $pre_result, $tmp);
    } else {
        $result = [];
    }
    return $result;
}

//通过或者驳回
function set_as_solved_ajax()
{
    $info = $_POST['info'];
    $state = $_POST['state'];
    set_as_solved($info,$state);
    die();
}

add_action('wp_ajax_set_as_solved_ajax', 'set_as_solved_ajax');
add_action('wp_ajax_nopriv_set_as_solved_ajax', 'set_as_solved_ajax');

function set_as_solved($info,$state){
    global $wpdb;
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    $operator = get_current_user_id();
    if ($info != []) {
        //每一个td是一个大小为3数组,第一个数是user_id,
        //第二个数是source_type,第三个数是source_id,
        foreach ($info as $td) {
            if ($state == 'pass') {   //如果通过
                //step1:更改表状态
                $sql_pass = "UPDATE wp_rbac_apply_tmp SET state = 1,operator ='$operator',modified_time = '$current_time'
                               WHERE user_id = $td[0] and source_type = $td[1] and source_id=$td[2]";
                $wpdb->get_results($sql_pass);
                //step2:更改ur或up表
                if ($td[1] == 0) { //更改权限表
                    $sql_up = "INSERT INTO wp_rbac_up VALUES ('',$td[0],$td[2],'$operator','$current_time')";
                    $wpdb->get_results($sql_up);
                } else {  //更改角色表
                    $sql_ur = "INSERT INTO wp_rbac_ur VALUES ('',$td[0],$td[2],'$operator','$current_time')";
                    $wpdb->get_results($sql_ur);
                }
            } else {
                //只需要更新tmp表
                $sql_deny = "UPDATE wp_rbac_apply_tmp SET state = 2,operator ='$operator',modified_time = '$current_time'
                               WHERE user_id = $td[0] and source_type = $td[1] and source_id=$td[2]";
                $wpdb->get_results($sql_deny);
            }
        }
    }
}




//用户可以查看资源(用户有权限)
//单建一张表,并维护,其中,user——id= 0的是公共资源,所有用户都可见
//如果发上来的资源是所有人可见的,那就加入到这里面
//添加公共资源
function process_public_post()
{
    global $wpdb;
    //先处理公共资源
    $sql_post = "SELECT ID FROM wp_posts WHERE post_status = 'publish' and post_type IN ('yada_wiki','post') ";
    $post_id_arr = $wpdb->get_results($sql_post, 'ARRAY_A');
    $post_id_arr = array_column($post_id_arr, 'ID');
    $post_string = implode(',', $post_id_arr);
    $sql_insert = "INSERT INTO wp_rbac_user_post VALUES('',0,'$post_string')";
    $wpdb->get_results($sql_insert);
}

//获取所有用户的公共资源
function get_public_post()
{
    global $wpdb;
    //先处理公共资源
    $sql_post = "SELECT post_arr FROM wp_rbac_user_post WHERE user_id = 0";
    $post_id_str = $wpdb->get_results($sql_post)[0]->post_arr;
    $post_id_arr = explode(',', $post_id_str);
    return $post_id_arr;
}

//更新公共资源
function update_public_post($post_arr,$type){
    global $wpdb;
    $public_post = get_public_post();  //获取公共资源数组
    if($type=='add'){
        $public_post = array_merge($public_post,$post_arr);
    }
    if($type=='delete'){
        $public_post = array_diff($public_post,$post_arr);
    }
    $post_string = implode(',', $public_post);
    $sql_update = "UPDATE wp_rbac_user_post SET post_arr ='$post_string' WHERE user_id = 0";
    $wpdb->get_results($sql_update);
}
//获取用户的私有资源
function get_private_post($user_id)
{
    global $wpdb;
    //先处理公共资源
    $sql_post = "SELECT post_arr FROM wp_rbac_user_post WHERE user_id = $user_id";
    $post_id_str = $wpdb->get_results($sql_post)[0]->post_arr;
    $post_id_arr = explode(',', $post_id_str);
    return $post_id_arr;
}

function update_user_post_table()
{
    global $wpdb;
    $sql = "SELECT ID FROM wp_users";
    $user_id_arr = $wpdb->get_results($sql, 'ARRAY_A');
    $user_id_arr = array_column($user_id_arr, 'ID');   //获取所有user_id
    $result = [];
    foreach ($user_id_arr as $id) {
        $role_id = get_rbac_user_relation('role', $id);
        $permission = [];
        //role对应的
        foreach ($role_id as $r) {
            $tmp_id = get_rbac_rp_relation('role', $r);
            if (!empty($tmp_id)) {
                $permission[] = $tmp_id;
            }
        }
        //permission对应的
        $permission_id = get_rbac_user_relation('permission', $id);
        if (!empty($permission_id)) {
            $permission[] = $permission_id;
        }
        $permission_arr = flatten_array($permission);   //获取所有permission_id

        foreach ($permission_arr as $value) {
            $result[] = get_permission_post($value);
        }

        $post_arr = flatten_array($result);
        $post_arr = implode(',', $post_arr);

        //判断是插入还是更新
        $sql_judge = "SELECT user_id from wp_rbac_user_post WHERE user_id = $id";
        $col = $wpdb->query($sql_judge);
        if ($col == 0) {
            $sql_insert = "INSERT INTO wp_rbac_user_post VALUES('',$id,'$post_arr')";
            $wpdb->get_results($sql_insert);
        } else {
            $sql_update = "UPDATE wp_rbac_user_post SET post_arr = '$post_arr' WHERE user_id = $id";
            $wpdb->get_results($sql_update);
        }
    }
}

function update_user_post_table_ajax()
{
    update_user_post_table();
}

add_action('wp_ajax_update_user_post_table_ajax', 'update_user_post_table_ajax');
add_action('wp_ajax_nopriv_update_user_post_table_ajax', 'update_user_post_table_ajax');

//更新某一用户的资源信息，即更新某一用户的user_post表
function update_user_post($user_id){
    global $wpdb;
    // 取出所有角色对应的资源
    $role_id_arr = get_rbac_user_relation('role',$user_id);
    $result = [];
    foreach ($role_id_arr as $role_id){
        $post = get_role_post($role_id);
        $result = array_merge($result,$post);
    }
    $post_arr = explode(',',$result);
    // 更新或插入user_post表
    $sql = "SELECT $user_id FROM wp_rbac_user_post where user_id=$user_id";
    $col = $wpdb->query($sql);
    if($col==0){
        $sql_insert = "INSERT INTO wp_rbac_user_post VALUES('',$user_id,'$post_arr')";
        $wpdb->query($sql_insert);
    }else{
        $sql_update = "UPDATE wp_rbac_user_post SET post_arr = '$post_arr' where user_id=$user_id";
        $wpdb->query($sql_update);
    }
}

//获取某一角色对应的资源
function get_role_post($role_id){
    $perimisson_id_arr = get_rbac_rp_relation('role',$rold_id);
    $result = [];
    foreach ($permission_id_arr as $pid){
        $tmp = get_permission_post($pid);
        $result = array_merge($result,$tmp);
    }
    return $result;
}

function user_can_view($post_id)
{
    $user_id = get_current_user_id();
    $public = get_public_post();
    //$private = get_private_post($user_id);
    //两个数组取并集
    //$all_source = array_merge($public, $private);
    if (in_array($post_id, $public)) {
        return true;
    } else {
        //从用户->角色->权限->post
        $post = [];
        $permission_arr = rbac_get_user_all_permission($user_id);
        print_r($permission_arr);
        foreach ($permission_arr as $p) {
            $post[] = get_permission_post($p);
        }
        $post = flatten_array($post);
        print_r($post);
        return in_array($post_id, $post);
    }
}

//为当前已经填写了学校信息的同学设置角色
function init_user_school_role()
{
    global $wpdb;
    $tmp = $wpdb->get_results("SELECT user_id,meta_value FROM wp_usermeta WHERE meta_key = 'University'");
    foreach ($tmp as $value) {
        $sname = $wpdb->get_results("select uvs_name from wp_ms WHERE ID = $value->meta_value")[0]->uvs_name;
        $role_id = $wpdb->get_results("SELECT ID from wp_rbac_role WHERE role_name = '$sname'")[0]->ID;
        //插入ur表
        $author = get_current_user_id();
        $modified_time = date('Y-m-d H:i:s', time() + 8 * 3600);
        $sql_ur = "INSERT INTO wp_rbac_ur VALUES ('',$value->user_id,$role_id,$author,'$modified_time')";
        $wpdb->get_results($sql_ur);

    }
}

//处理可见性
function create_process_visibility($visibility, $post_id, $author)
{
    global $wpdb;
    if (in_array('all', $visibility)) {
        //全部人可见
        //直接添加到公共资源中
        $arr = get_public_post();
        $arr[] = $post_id;
        $post_string = implode(',', $arr);
        $sql_insert = "UPDATE  wp_rbac_user_post SET post_arr = '$post_string' WHERE user_id =0";
        $wpdb->get_results($sql_insert);
    } else {
        /* 最终落地到权限上
         * 和我同一角色的->最终将资源添加到角色对应的权限上
         * 和我同一学校的->最终将资源添加到学校角色对应的权限上
         */

        foreach ($visibility as $v) {
            if ($v == 'myrole') {
                //获取我的所有角色,进而所有权限,进而为权限添加资源
                $role_permission = rbac_get_user_role_permission($author);  //角色对应的所有权限
                foreach ($role_permission as $pid) {
                    $modified_time = date('Y-m-d H:i:s', time() + 8 * 3600);
                    $sql = "INSERT INTO wp_rbac_post VALUES ('',$pid,$post_id,$author,'$modified_time')";
                    $wpdb->get_results($sql);
                }
            } elseif ($v == 'myschool') {
                //为这个学校的角色添加post
                //1、获取学校id
                $school_id = get_user_meta($author, 'University', true);
                //2、获取角色id
                $sname = $wpdb->get_results("select uvs_name from wp_ms WHERE ID = $school_id")[0]->uvs_name;
                $role_id = $wpdb->get_results("SELECT ID from wp_rbac_role WHERE role_name = '$sname'")[0]->ID;
                //3、对这个角色下所有的权限添加这个post
                $permission_id = get_rbac_rp_relation('role', $role_id);
                foreach ($permission_id as $pid) {
                    $modified_time = date('Y-m-d H:i:s', time() + 8 * 3600);
                    $sql = "INSERT INTO wp_rbac_post VALUES ('',$pid,$post_id,$author,'$modified_time')";
                    $wpdb->get_results($sql);
                }
            } else {
                //私有
                //step1:新建一个权限,名称为查看XXX资源的权限,将改资源绑定给权限
                $pname = get_post($post_id)->post_title;
                $pname = "查看资源:" . $pname . " 的权限";
                $pauthor = $author;
                $pdate = date('Y-m-d H:i:s', time() + 8 * 3600);
                $relative_post = [$post_id];
                $permission_id = create_permission($pname, $pauthor, $pname, $pdate, $relative_post);
                //step2:将权限绑定给作者用户
                //确认有没有这个u-p对
                $sql_c = "SELECT ID FROM wp_rbac_up WHERE user_id=$author and permission_id = $permission_id";
                $col = $wpdb->query($sql_c);
                if ($col == 0) {
                    $sql = "INSERT INTO wp_rbac_up VALUES ('',$author,$permission_id,$author,'$pdate')";
                    $wpdb->query($sql);
                }
            }
        }
    }
}

//创建权限
function create_permission($pname, $pauthor, $ill, $pdate, $relative_post)
{
    global $wpdb;
//首先获取最后一个permission_id;
    $sql_fun = "select ID from wp_rbac_permission ORDER BY ID DESC LIMIT 0,1";
    $result = $wpdb->get_results($sql_fun);
    $permission_id = $result[0]->ID + 1;
    $sql_permission = "INSERT INTO wp_rbac_permission VALUES ($permission_id,'$pname','$ill','$pauthor','$pdate')";
    if ($pname != "" && $ill != "") {
        $wpdb->query($sql_permission);
    }
    if (sizeof($relative_post) != 0) {
        foreach ($relative_post as $p) {
            $sql = "INSERT INTO wp_rbac_post VALUES ('',$permission_id,$p,$pauthor,'$pdate')";
            $wpdb->query($sql);
        }
    }
    return $permission_id;
}

//============积分系统================
//建立用户积分表
function user_integral_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "user_integral";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          user_id int PRIMARY KEY,
          integral int NOT NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

//初始化用户积分表
function init_user_integral_table()
{
    global $wpdb;
    $sql = "select ID from wp_users";
    $pre_result = $wpdb->get_results($sql, 'ARRAY_A');
    $result = array_column($pre_result, 'ID');
    foreach ($result as $uid) {
        init_user_integral($uid);
    }
}

//新用户初始化积分
function init_user_integral($user_id)
{
    global $wpdb;
    $tmp = get_current_date();
    $score = calculate_user_integral($user_id)+100;
    $sql_insert = "REPLACE INTO wp_user_integral VALUES($user_id,$score,'$tmp')";
    $wpdb->get_results($sql_insert);
}

//计算当前用户初始积分
function calculate_user_integral($user_id)
{
    $score = 0;
    global $wpdb;
    global $integral_system;
    //现有的wiki、项目的作者初始化加分
    $sql = "SELECT ID FROM wp_posts WHERE post_author = $user_id 
                                      and post_status = 'publish' 
                                      and post_type IN ('yada_wiki','post')";
    $pre_result = $wpdb->get_results($sql);
    $score += sizeof($pre_result) * $integral_system['create_wiki'];

    //别人为当前打过分
    foreach($pre_result as $v){
        $id = $v->ID;
        $sql_getgrade = "SELECT score FROM wp_score WHERE score_post_id = $id";
        $getgrade_result = $wpdb->get_results($sql_getgrade,'ARRAY_A');
        if($getgrade_result!=[]){
            $result = array_column($getgrade_result,'score');
            foreach ($result as $value){
                if ($value>=3){
                    $score += $integral_system['get_grade'];
                }
            }
        }
    }

    //为别人打过分,每条加两分
    $sql_score = "SELECT score FROM wp_score WHERE user_id = $user_id";
    $grade_result = $wpdb->get_results($sql_score,'ARRAY_A');
    $score += sizeof($grade_result) * $integral_system['grade'];

    //被收藏加分
    foreach($pre_result as $v){
        $id = $v->ID;
        $sql_favorite = "SELECT ID FROM wp_favorite WHERE favorite_post_id = $id";
        $favorite_result = $wpdb->get_results($sql_favorite,'ARRAY_A');
        $score += sizeof($favorite_result) * $integral_system['get_favorite'];
    }

    //回答过别人的问题加分
    $sql_answer = "SELECT DISTINCT post_parent FROM wp_posts WHERE post_author = $user_id 
                                             and post_status = 'publish' 
                                             and post_type ='dwqa-answer'";
    $answer_result = $wpdb->get_results($sql_answer);
    $score += sizeof($answer_result) * $integral_system['answer_question'];
    return $score;
}

//获取用户积分
function get_user_integral($user_id)
{
    global $wpdb;
    $sql = "SELECT integral FROM wp_user_integral WHERE user_id =$user_id";
    $integral = $wpdb->get_results($sql)[0]->integral;
    return $integral;
}

//添加用户积分(可批量)
function add_user_integral($user_id, $score)
{
    global $wpdb;
    if (is_array($user_id)) { //如果是数组
        foreach ($user_id as $uid) {
            $integral = get_user_integral($uid) + $score;
            $time = get_current_date();
            $sql = "update wp_user_integral set integral = $integral,modified_time = '$time' WHERE user_id = $uid";
            $wpdb->get_results($sql);
        }
    } elseif (is_numeric($user_id)) {
        $integral = get_user_integral($user_id) + $score;
        $time = get_current_date();
        $sql = "update wp_user_integral set integral = $integral,modified_time = '$time' WHERE user_id = $user_id";
        $wpdb->get_results($sql);
    }
}

function add_user_integral_ajax()
{
    $user_id = $_POST['user_id'];
    $score = $_POST['score'];
    add_user_integral($user_id, $score);
}

add_action('wp_ajax_add_user_integral_ajax', 'add_user_integral_ajax');
add_action('wp_ajax_nopriv_add_user_integral_ajax', 'add_user_integral_ajax');


//减少用户积分
function cut_user_integral($user_id, $score)
{
    global $wpdb;
    if (is_array($user_id)) { //如果是数组
        foreach ($user_id as $uid) {
            $integral = get_user_integral($uid) - $score;
            $time = get_current_date();
            $sql = "update wp_user_integral set integral = $integral,modified_time = '$time' WHERE user_id = $uid";
            $wpdb->get_results($sql);
        }
    } elseif (is_numeric($user_id)) {
        $integral = get_user_integral($user_id) - $score;
        $time = get_current_date();
        $sql = "update wp_user_integral set integral = $integral,modified_time = '$time' WHERE user_id = $user_id";
        $wpdb->get_results($sql);
    }
}

function cut_user_integral_ajax()
{
    $user_id = $_POST['user_id'];
    $score = $_POST['score'];
    add_user_integral($user_id, $score);
}

add_action('wp_ajax_cut_user_integral_ajax', 'cut_user_integral_ajax');
add_action('wp_ajax_nopriv_cut_user_integral_ajax', 'cut_user_integral_ajax');

//积分等级转化
function transfer_integral($score)
{
    $map = ['Lv1', 'Lv2', 'Lv3', 'Lv4', 'Lv5'];
    if ($score < 200) {
        return $map[0];
    } elseif ($score >= 200 && $score < 500) {
        return $map[1];
    } elseif ($score >= 500 && $score < 1000) {
        return $map[2];
    } elseif ($score >= 1000 && $score < 2000) {
        return $map[3];
    } else {
        return $map[4];
    }
}

function get_user_level($user_id)
{
    $score = get_user_integral($user_id);
    return transfer_integral($score);
}

function check_score(){
    global $wpdb;
    $score = $_POST['offer'];
    $user_id = $_POST['user_id'];
    $sql = "SELECT integral FROM wp_user_integral WHERE user_id = $user_id";
    $result = $wpdb->get_results($sql)[0]->integral;
    if($result > $score){
        echo 1;
    }else{
        echo 0;
    }
    die();
}
add_action('wp_ajax_check_score', 'check_score');
add_action('wp_ajax_nopriv_check_score', 'check_score');

function get_question_offers($qid){
    $score = get_post_meta($qid,'_dwqa_scores',true);
    if($score==''){
        $score = 0;
    }
    return $score;
}

//积分解锁资源
function offer_unlock_ajax(){
    $permission_id = $_POST['permission_id'];
    $result = offer_unlock($permission_id);
    echo $result;
    die();
}
add_action('wp_ajax_offer_unlock_ajax', 'offer_unlock_ajax');
add_action('wp_ajax_nopriv_offer_unlock_ajax', 'offer_unlock_ajax');

function offer_unlock($permission_id)
{
    global $integral_system;
    global $wpdb;
    //先积分操作
    $user_id = get_current_user_id();
    $score = sizeof($permission_id)*$integral_system['unlock_source'];
    $user_integral = get_user_integral($user_id);
    if($score > $user_integral){
        return false;
    }
    cut_user_integral($user_id,$score);

    //为用户直接赋予选择的权限
    $current_time = date('Y-m-d H:i:s', time() + 8 * 3600);
    $all_permission = rbac_get_user_all_permission($user_id);
    foreach ($permission_id as $p) {
        if (in_array($p, $all_permission)) {
            break;
        }
        //确认有没有这个u-p对
        $sql_c = "SELECT ID FROM wp_rbac_up WHERE user_id=$user_id and permission_id = $p";
        $col = $wpdb->query($sql_c);
        if ($col == 0) {
            $sql = "INSERT INTO wp_rbac_up VALUES ('',$user_id,$p,$user_id,'$current_time')";
            $wpdb->query($sql);
        }
    }
    return true;
}







//融云
//建立token表
function token_table_install()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "token";  //获取表前缀，并设置新表的名称
    if ($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
        $sql = "CREATE TABLE " . $table_name . " (
          kID int AUTO_INCREMENT PRIMARY KEY,
          id int NOT NULL,
          t_type text NOT NULL,
          token text NOT NULL,
          modified_time datetime NOT NULL
          ) character set utf8";
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");  //引用wordpress的内置方法库
        dbDelta($sql);
    }
}

function getUserToken($user_id, $user_name, $avatar_url)
{ //注册用户
    global $wpdb;
    $appKey = 'e0x9wycfe4h8q';
    $appSecret = 'gBasm0OQHKa';
    include_once 'algorithm/server-sdk/API/rongcloud.php';
    // 获取 Token 方法
    $RongCloud = new RongCloud($appKey, $appSecret);;
    $result = $RongCloud->user()->getToken($user_id, $user_name, $avatar_url);
    $token_array = json_decode($result);
    if ($token_array->code == 200) {
        $sql = "select id from wp_token WHERE id = $token_array->userId and t_type = 'user'";
        $col = $wpdb->query($sql);
        $modified_time = date('Y-m-d H:i:s', time() + 8 * 3600);
        if ($col == 0) {   //未注册过
            $sql_insert = "insert into wp_token VALUES ('',$token_array->userId,'user','$token_array->token','$modified_time')";
            $wpdb->query($sql_insert);
            //            echo "user:".$token_array->userId."注册成功";
        } else {  //已注册过,刷新
            $sql_update = "update wp_token set token = '$token_array->token',modified_time = '$modified_time' WHERE id=$token_array->userId";
            $wpdb->query($sql_update);
        }
    }
}

function getGroupToken($user_array, $group_id, $group_name)
{
    $appKey = 'e0x9wycfe4h8q';
    $appSecret = 'gBasm0OQHKa';
    include_once 'algorithm/server-sdk/API/rongcloud.php';
    // 获取 Token 方法   group没有token
    $RongCloud = new RongCloud($appKey, $appSecret);;
    $result = $RongCloud->group()->create($user_array, $group_id, $group_name);
    $token_array = json_decode($result);
    if ($token_array->code != 200) {
        echo "error" . $token_array->code;
    }
}

function hasToken($user_id)
{
    global $wpdb;
    $sql = "select id from wp_token WHERE id =$user_id";
    $col = $wpdb->query($sql);
    if ($col != 0) return true;
    else return false;
}

function rongCloudJoinGroup()
{
    global $wpdb;
    include_once 'algorithm/server-sdk/API/rongcloud.php';
    $group_id = $_POST['group_id'];
    $user_id = get_current_user_id();
    $group_name = get_group($group_id)[0]['group_name'];
    $appKey = '82hegw5u8y3bx';
    $appSecret = '3xiNmMC4VLWKr7';
    $RongCloud = new RongCloud($appKey, $appSecret);
    if (!hasToken($user_id)) {
        $avatar_url = site_url() . "/wp-content/themes/sparkUI/img/rongcloud-avatar.png";
        $user_name = get_the_author_meta('user_login', $user_id);
        getUserToken($user_id, $user_name, $avatar_url);
    }

    $result = $RongCloud->group()->join([$user_id], $group_id, $group_name);
    $token_array = json_decode($result);
    if ($token_array->code != 200) {
        echo "error";
    }
    echo $result;
    die();
}

add_action('wp_ajax_rongCloudJoinGroup', 'rongCloudJoinGroup');
add_action('wp_ajax_nopriv_rongCloudJoinGroup', 'rongCloudJoinGroup');

function rongCloudQuitGroup()
{
    include_once 'algorithm/server-sdk/API/rongcloud.php';
    $group_id = $_POST['group_id'];
    $user_id = get_current_user_id();
    $appKey = 'e0x9wycfe4h8q';
    $appSecret = 'gBasm0OQHKa';
    $RongCloud = new RongCloud($appKey, $appSecret);
    $result = $RongCloud->group()->quit([$user_id], $group_id);
    $token_array = json_decode($result);
    if ($token_array->code != 200) {
        echo "error";
    }
    echo $result;
    die();
}

add_action('wp_ajax_rongCloudQuitGroup', 'rongCloudQuitGroup');
add_action('wp_ajax_nopriv_rongCloudQuitGroup', 'rongCloudQuitGroup');


function rongCloudJoinGroup2($user_id, $group_id)
{
    global $wpdb;
    include_once 'algorithm/server-sdk/API/rongcloud.php';
    $group_name = get_group($group_id)[0]['group_name'];
    $appKey = 'e0x9wycfe4h8q';
    $appSecret = 'gBasm0OQHKa';
    $RongCloud = new RongCloud($appKey, $appSecret);
    if (!hasToken($user_id)) {
        $avatar_url = site_url() . "/wp-content/themes/sparkUI/img/rongcloud-avatar.png";
        $user_name = get_the_author_meta('user_login', $user_id);
        getUserToken($user_id, $user_name, $avatar_url);
    }

    $result = $RongCloud->group()->join([$user_id], $group_id, $group_name);
}

function rongCloudQuitGroup2($user_id, $group_id)
{
    include_once 'algorithm/server-sdk/API/rongcloud.php';
    $appKey = 'e0x9wycfe4h8q';
    $appSecret = 'gBasm0OQHKa';
    $RongCloud = new RongCloud($appKey, $appSecret);
    $result = $RongCloud->group()->quit([$user_id], $group_id);
}

function get_template_params()
{
    $targetId = $_POST['targetId'];
    $targetType = $_POST['targetType'];
    $result = array();
    if ($targetType == 'user') {
        $userName = get_the_author_meta('user_login', $targetId);
        $result['userName'] = $userName;
    } else {
        $group_name = get_group($targetId)[0]['group_name'];
        $result['groupName'] = $group_name;
    }
    $result_json = json_encode($result);
    echo $result_json;
    die();
}

add_action('wp_ajax_get_template_params', 'get_template_params');
add_action('wp_ajax_nopriv_get_template_params', 'get_template_params');

//function get_current_group_id(){
//    //获取群组名用
//    $result = [];
//    $targetId =$_POST['targetId'];
//    $group_name = get_group($targetId)[0]['group_name'];
//    $result['groupName'] = $group_name;
//
////    $current_url = curPageURL();
////    $result['groupId'] = $current_url;
////    $url_array=parse_url($current_url);
////    $query_parse=explode("&",$url_array['query']);
////    foreach( $query_parse as $v){
////        $q=explode("=",$v);
////        if ($q[0]=='id')
////            $result['groupId'] = $q[1];
////    }
//    $result_json = json_encode($result);
//    echo $result_json;
//    die();
//}
//add_action('wp_ajax_get_current_group_id', 'get_current_group_id');
//add_action('wp_ajax_nopriv_get_current_group_id', 'get_current_group_id');


//修改域名  域名要包括http
function changeDomain($old_domain, $new_domain)
{
    global $wpdb;
//usermeta表中meta_key  meta_value 变更
//post表中post_content变更
    $sql_meta = "select * from $wpdb->usermeta WHERE meta_key='simple_local_avatar'";
    $results = $wpdb->get_results($sql_meta);
    foreach ($results as $key => $value) {
        $new_value = str_replace($old_domain, $new_domain, $value->meta_value);
        $sql_update = "update $wpdb->usermeta set meta_value='$new_value' WHERE meta_key='simple_local_avatar' and umeta_id = $value->umeta_id";
        $wpdb->get_results($sql_update);
    }
    $sql_post = "select ID, post_content from $wpdb->posts ORDER BY 'ID' ASC";
    $results_post = $wpdb->get_results($sql_post);
    foreach ($results_post as $key => $value) {
        $new_value = addslashes(str_replace($old_domain, $new_domain, $value->post_content));
        $sql_update = "update $wpdb->posts set post_content ='$new_value' WHERE ID = $value->ID";
        $wpdb->get_results($sql_update);
    }
    echo "<h4>已将域名由" . $old_domain . "变更为" . $new_domain . "</h4>";
}

//温故
function wikiReview($id)
{
//    exec("python wp-content/themes/sparkUI/algorithm/wenguzhixin.py",$output,$ret);
//    if($ret ==0){
//        return $output[0];
//    }else{
//        exec("python wp-content/themes/sparkUI/algorithm/wenguzhixin.py 2>&1",$output,$ret);
//        return $output;
//    }
    global $wpdb;
    $result_arr = array();
    $sql = "SELECT review_old FROM wp_user_review WHERE ID=$id";
    $result = $wpdb->get_results($sql, 'ARRAY_A');
    if (sizeof($result) != 0) {
        $result_arr = explode(",", $result[0]['review_old']);
    }
    return $result_arr;
}

//知新  参数用户id
function wikiRecommend($id)
{
    global $wpdb;
    $result_arr = array();
    $sql = "SELECT know_new FROM wp_user_review WHERE ID=$id";
    $result = $wpdb->get_results($sql, 'ARRAY_A');
    if (sizeof($result) != 0) {
        $result_arr = explode(",", $result[0]['know_new']);
    }
    return $result_arr;
}

//是否有信息
function hasSinfo($str)
{
    $user_id = get_current_user_id();
    $arr = get_user_meta($user_id, $str);
    if (sizeof($arr) == 0) {
        return false;
    } else {
        return true;
    }
}

//获取当前时间
function get_current_date()
{
    return date('Y-m-d H:i:s', time() + 8 * 3600);
}

//自动登录
function auto_login($user_login)
{
    if (!is_user_logged_in()) {
        // 获取用户id
        $user = get_user_by('login', $user_login);
        $user_id = $user->ID;
        // 登录
        wp_set_current_user($user_id, $user_login);
        wp_set_auth_cookie($user_id);
        do_action('wp_login', $user_login);
    }
}

//通过学号获取用户ID
function sno_to_id($sno)
{
    global $wpdb;
    $sql = "SELECT user_id FROM wp_usermeta WHERE meta_key ='Sno' AND meta_value =$sno";
    $result = $wpdb->get_results($sql);
    return $result[0]->user_id;
}

//获取最近一次登录时间
function get_lastest_login($user_id)
{
    global $wpdb;
    $sql_id = "SELECT history_id FROM wp_simple_history_contexts WHERE `value` =$user_id AND `key` ='user_id'";
    $result_id = $wpdb->get_results($sql_id);
    if (sizeof($result_id) != 0) {
        $lastest_history_id = max($result_id)->history_id;
        $sql_time = "SELECT `date` FROM `wp_simple_history` WHERE `id` =$lastest_history_id AND `message` = 'Logged in'";
        $result_time = $wpdb->get_results($sql_time);
        return $result_time[0]->date;
    } else {
        return false;
    }
}

//添加或禁用上传文件类型
add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes($existing_mimes = array())
{
// 添加支持上传的文件类型
    $existing_mimes['zip'] = 'application/zip';
    $existing_mimes['rar'] = 'application/rar';
    $existing_mimes['xmind'] = 'application/xmind';
// 下载是禁止上传的文件类型
    unset($existing_mimes['exe']);
    unset($existing_mimes['php']);
    unset($existing_mimes['asp']);
    unset($existing_mimes['bat']);
    unset($existing_mimes['js']);

    return $existing_mimes;
}


/**
验证码ticket验证
 */
function captcha_ticket_verify(){
    $url = "https://ssl.captcha.qq.com/ticket/verify";
    $params = array(
        "aid" => $_POST['aid'],
        "AppSecretKey" => $_POST['AppSecretKey'],
        "Ticket" => $_POST['Ticket'],
        "Randstr" => $_POST['Randstr'],
        "UserIP" => $_POST['UserIP']
    );
    $paramstring = http_build_query($params);
    $content = txcurl($url,$paramstring);
    $result = json_decode($content,true);
    if($result){
        if($result['response'] == 1){
           echo  json_encode($result);
        }else{
            echo "Deny";
        }
    }else{
        echo "请求失败";
    }
    die();
}


add_action('wp_ajax_captcha_ticket_verify', 'captcha_ticket_verify');
add_action('wp_ajax_nopriv_captcha_ticket_verify', 'captcha_ticket_verify');

/**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
function txcurl($url,$params=false,$ispost=0){
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
    curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
    curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if( $ispost )
    {
        curl_setopt( $ch , CURLOPT_POST , true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
        curl_setopt( $ch , CURLOPT_URL , $url );
    }
    else
    {
        if($params){
            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
        }else{
            curl_setopt( $ch , CURLOPT_URL , $url);
        }
    }
    $response = curl_exec( $ch );
    if ($response === FALSE) {
        //echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
    curl_close( $ch );
    return $response;
}
/**
 *
 * @param  int $post_id [postID]
 * @param  string $keyword [关键词]
 */
function addPostKeyword($post_id,$keyword){
    global $wpdb;
    $sql = "INSERT INTO wp_post_keywords VALUES ('',$post_id,'$keyword','','','','')";
    $wpdb->get_results($sql);
}
////wiki和项目内容处理 去标签化 暂时无用
//function removeHTMLLabel($post_id){
//    global $wpdb;
//    $sql = "select post_content from $wpdb->posts WHERE ID= $post_id";
//    $result = $wpdb->get_var($sql,0);
//    return strip_tags($result);
//}
//function xml_parser($str){  //暂时无用
//    $xml_parser = xml_parser_create();
//    if(!xml_parse($xml_parser,$str,true)){
//        return false;
//    }else {
//        return true;
//    }
//}
////判断用户是否有收藏
//function hasFavorite($user_id){
//    global $wpdb;
//    $sql = "SELECT * FROM wp_favorite WHERE user_id=$user_id AND favorite_post_type='post'";
//    $col = $wpdb->query($sql);
//    if($col==0){    //未收藏
//        return false;
//    }else{ //已收藏
//        return true;
//    }
//}
//原始算法
////写入pro-->wiki关系。-->在pro页面展示wiki
//function writeProWiki($pro_post_id){
//    /* 先找出一个项目,获取项目的content(ok)
//     * 进入对所有wiki词条的循环
//     * 在循环中找出wiki词条title(ok),在content中搜索,计数
//     * 并在relation数据库中插入一条数据,默认qa和project中为空
//     * 将wiki的信息保存
//     * 将返回的信息压进一个数组
//     * 在循环外对数字排序
//     * 返回值是 pro所关联的wiki信息数组。
//     * */
//    $td_array = array();
//    $arr_sort_wiki= array();
//    //获取项目内容
//    $content = strtolower(get_post($pro_post_id)->post_content);
//    //获取所有wiki词条
//    $args_wiki_all = array(
//        'post_type'  => 'yada_wiki',
//        'posts_per_page' => -1,
//    );
//    $wiki_all = new WP_Query( $args_wiki_all );
//    //进入wiki词条循环,对每一个词条
//    if ( $wiki_all->have_posts() ) :
//         while ($wiki_all->have_posts()) : $wiki_all->the_post();
//             if (get_post_status() == 'publish') :
//                 //进行比对处理,获取回来的$wiki_info包含id,title,count三个信息
//                 $wiki_info = processEachProWiki($pro_post_id,$content);
//                 if(!empty($wiki_info)){//如果该词条出现在了项目中,将其保存在$td_array二维数组中
//                     array_push($td_array,$wiki_info);
//                 }
//             endif;
//         endwhile;
//    else :
//        echo "error";//没有wiki词条的情况,不会出现
//    endif;
//    //如果项目中包含一些wiki词条
//    if(!empty($td_array)){
//        //按照count排序,保存在$td_array中
//        foreach($td_array as $key =>$value){
//            foreach($value as $i =>$count){
//                $arr_sort_wiki[$i][$key] = $count;
//            }
//        }
//        array_multisort($arr_sort_wiki['wiki_count'], SORT_DESC,$td_array);
//    }
//    return $td_array;
//}
////针对每一个wiki词条 为writeProWiki服务
//function processEachProWiki($pro_post_id,$content)
//{
//    $wiki_info = array();
//    $wiki_title = strtolower(get_the_title());  //全部转化成小写 因为substr_count是精确匹配。
//    $appear_count = substr_count($content, $wiki_title);  //这个词条在content中出现的次数。
//    if ($appear_count != 0) {  //如果出现了
//        global $wpdb;
//        $wiki_id = get_the_ID(); //获取这个wiki的ID
//        $view_count =getViews($wiki_id);
//        //判断表中是否已经存在这个pro<->wiki对
//        $sql_1 = "SELECT * FROM wp_relation WHERE post_id=$pro_post_id AND related_id=$wiki_id";
//        $col = $wpdb->query($sql_1); //返回的结果有几行
//        if ($col === 0) {  //如果没有这个pro<->wiki对
//            $sql_2 = "INSERT INTO wp_relation VALUES ('',$pro_post_id,'post',$wiki_id,'yada_wiki')";
//            $wpdb->get_results($sql_2);
//        }
//        //如果存在了这个pro<->wiki对,不做任何处理,将wiki的信息加入返回的数组
//        $count = 0.5*$appear_count+0.5*$view_count;
//        $wiki_info = array('wiki_id' => $wiki_id, 'wiki_title' => $wiki_title, 'wiki_count' => $count);
//    }
//    //没有出现不做任何处理,直接返回空数组。
//    return $wiki_info;
//}
////获取wiki的浏览量
//function getViews($post_id){
//    global $wpdb;
//    $sql = "SELECT * FROM wp_views WHERE post_id=$post_id";
//    $view_count = $wpdb->get_var($wpdb->prepare($sql,""),3,0);
//    return $view_count;
//}

//function create_process_visibility_ajax(){
//    global $wpdb;
//    $visibility = $_POST['post_visibility'];
//    $post_id = $_POST['post_id'];
//    $author = $_POST['author'];
//    create_process_visibility($visibility,$post_id,$author);
//}
//add_action('wp_ajax_create_process_visibility_ajax', 'create_process_visibility_ajax');
//add_action('wp_ajax_nopriv_create_process_visibility_ajax', 'create_process_visibility_ajax');

//function update_user_can_view($user_id,$post_arr){
//    global $wpdb;
//    $arr = get_private_post($user_id);
//    $new_arr = array_merge($arr,$post_arr);
//    $post_string = implode(',',$new_arr);
//    $sql_insert = "UPDATE  wp_rbac_user_post SET post_arr = '$post_string' WHERE user_id =$user_id";
//    $wpdb->get_results($sql_insert);
//}

?>
