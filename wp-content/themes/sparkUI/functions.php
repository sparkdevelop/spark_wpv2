<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/3/14
 * Time: 下午2:53
 */
//加载js
function sparkspace_scripts_with_jquery()
{
    // Register the script like this for a theme:
    wp_register_script( 'custom-script', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array( 'jquery' ) );
    wp_register_script( 'custom-script_2', get_template_directory_uri() . '/layer/layer.js', array( 'jquery' ) );
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'custom-script');
    wp_enqueue_script( 'custom-script_2');
}
add_action( 'wp_enqueue_scripts', 'sparkspace_scripts_with_jquery' );

//下面if中的内容为注册边栏小工具,分别是home页面,wiki页面和问答页面。与sidebar.php中的内容相对应。
//注释中的内容可以放出来看效果。注册时必须使用小写英文。
if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'name'          => 'home_sidebar',
        'id'            => 'widget_homesidebar',
//        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        //        'after_widget' => '</li>',
//        'before_title' => '<h2>',
        //        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name'          => 'wiki_sidebar',
        'id'            => 'widget_wikisidebar',
    ));
    register_sidebar(array(
        'name'          => 'qa_sidebar',
        'id'            => 'widget_qasidebar',
    ));
    register_sidebar(array(
        'name'          => 'qa_show_sidebar',
        'id'            => 'widget_qa_show_sidebar',
    ));
    register_sidebar(array(
        'name'          => 'qa_ask_sidebar',
        'id'            => 'widget_qa_ask_sidebar',
    ));
    register_sidebar(array(
        'name'          => 'project_sidebar',
        'id'            => 'widget_projectsidebar',
    ));
    register_sidebar(array(
        'name'          => 'search_sidebar',
        'id'            => 'widget_searchsidebar',
    ));
    register_sidebar(array(
        'name'          => 'tags_sidebar',
        'id'            => 'widget_tagssidebar',
    ));
    register_sidebar(array(
        'name'          => 'personal_sidebar',
        'id'            => 'widget_personalsidebar',
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
function my_register_admin_color_schemes() {
    wp_admin_css_color( 'skyblue', '天蓝色', 'style.css', array( '#149dc1', '#24272d', '#3b454b', '#f0f0f0' ) );
}
add_action( 'admin_init', 'my_register_admin_color_schemes', 10 );

//更改标签样式
function colorCloud($text) {
    $text = preg_replace_callback('|<a (.+?)>|i', 'colorCloudCallback', $text);
    return $text;
}
function colorCloudCallback($matches) {
    $text = $matches[1];
    $color= 'fe642d';
    $pattern = '/style=(\'|\")(.*)(\'|\")/i';
    $text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
    return "<a class='label label-default' $text>";
}
add_filter('wp_tag_cloud', 'colorCloud', 1);

//标签tag所包含的文章数量
function Tagno($text) {
    $text = preg_replace_callback('|<a (.+?)</a>|i', 'tagnoCallback', $text);
    return $text;
}
function tagnoCallback($matches) {
    $text=$matches[1];
    preg_match('|title=(.+?)style|i',$text ,$a);
    preg_match("/[0-9]+/",$a[0],$b);
    return "<a ".$text ."<span>[".$b[0]."]</span></a>";
}
add_filter('wp_tag_cloud', 'Tagno', 1);

function dwqa_user_most_ask( $number = 10, $from = false, $to = false ) {
    global $wpdb;

    $query = "SELECT post_author, count( * ) as `ask_count` 
				FROM `{$wpdb->prefix}posts` 
				WHERE post_type = 'dwqa-question' 
					AND post_status = 'publish'
					AND post_author <> 0";
    if ( $from ) {
        $from = date( 'Y-m-d h:i:s', $from );
        $query .= " AND `{$wpdb->prefix}posts`.post_date > '{$from}'";
    }
    if ( $to ) {
        $to = date( 'Y-m-d h:i:s', $to );
        $query .= " AND `{$wpdb->prefix}posts`.post_date < '{$to}'";
    }

    $prefix = '-all';
    if ( $from && $to ) {
        $prefix = '-' . ( $form - $to );
    }

    $query .= " GROUP BY post_author 
				ORDER BY `ask_count` DESC LIMIT 0,{$number}";
    $users = wp_cache_get( 'dwqa-most-ask' . $prefix );
    if ( false == $users ) {
        $users = $wpdb->get_results( $query, ARRAY_A  );
        wp_cache_set( 'dwqa-most-ask', $users );
    }
    return $users;
}

function get_hot_tags(){
    global $wpdb;
    $tag_id = array();
    $tag_name = array();//存储每个链接的名字;
    $link = array(); // 存储每个标签的链接;
    $tag_count = array();
//==============获取所有tag的id信息===============
    $tags = get_terms( 'dwqa-question_tag', array_merge( array( 'orderby' => 'count', 'order' => 'DESC' )));
//=============================
    foreach($tags as $key => $temp){
        $tag_id[]=$temp->term_id;
        $tag_count[]=$temp->count;
        $tag_name[]=$temp->name;
        array_push($link,get_term_link(intval($tag_id[$key]), 'dwqa-question_tag'));
    }
}

//获取当前页面地址
function curPageURL()
{
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on")
    {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80")
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    }
    else
    {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function get_page_id($page_name){
    global $wpdb;

    $page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$page_name' AND post_status = 'publish' ");
    return $page_id;
}

function get_page_address($page_name){
    global $wpdb;
    $page_id = get_page_id($page_name);
    $page_address="/?page_id=".$page_id;
    return $page_address;
}


function get_dwqa_cat_ID($cat_name){
    global $wpdb;
    $cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms WHERE name = '$cat_name'");
    return $cat_id;
}
//验证原密码是否正确
function checkPass(){
    global $wpdb;
    $current_user = wp_get_current_user();
    $user_id = $current_user->data->user_login;
    $password = isset($_POST["oldpassword"]) ? $_POST["oldpassword"] :'';
    $sql = "SELECT user_pass FROM $wpdb->users WHERE ID=".$current_user->ID;
    $user_pass = $wpdb->get_var($sql);
    $data = wp_check_password($password,$user_pass);
    if($data){ //如果是wordpress的用户
        $response =true;
    } else {
        if(!empty($user_id) && !empty($password)) { //如果不是wordpress的用户
            $post_data = array(
                'username' => $user_id,
                'password' => $password );
            $if_user_in_mediawiki = send_post_to_mediawiki('http://115.28.144.64/wiki_wp/index.php', $post_data);
            if(!empty($if_user_in_mediawiki)) {
                $response = true;
            }
            else{
                $response = false;
            }
        }
    }
    echo $response;
    exit;
}
add_action('wp_ajax_checkPass', 'checkPass');
add_action('wp_ajax_nopriv_checkPass', 'checkPass');

//删除我的问题
function deleteMyQuestion(){
    global $wpdb;
    $question_id = isset($_POST["question_id"]) ? $_POST["question_id"] :'';
    if(!empty($question_id)){
        $sql = "UPDATE $wpdb->posts SET post_status = 'trash' WHERE ID =".$question_id;
        $wpdb->get_results($sql);
        $response = true;
    } else{
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
function custom_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/custom-login/custom-login.css" />';
}
add_action('login_head', 'custom_login');

//更改logo的url，默认指向wordpress.org
function custom_headerurl( $url ) {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'custom_headerurl' );

//更改logo的title，默认是“Powered by WordPress”(基于WordPress)
function custom_headertitle ( $title ) {
    return __( '欢迎来到火花空间' );
}
add_filter('login_headertitle','custom_headertitle');

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
function getProjectViews($postID){
    $count_key = 'project_views'; //自定义域
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count.'';
}
function setProjectViews($postID) {
    $count_key = 'project_views'; //自定义域
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//给投稿者上传文件的权限
if ( current_user_can('contributor') && !current_user_can('upload_files') )
    add_action('init', 'allow_contributor_uploads');

function allow_contributor_uploads() {
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
function my_upload_media( $wp_query_obj ) {
    global $current_user, $pagenow;
    if( !is_a( $current_user, 'WP_User') )
        return;
    if( 'admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments' )
        return;
    if( !current_user_can( 'manage_options' ) && !current_user_can('manage_media_library') )
        $wp_query_obj->set('author', $current_user->ID );
    return;
}
add_action('pre_get_posts','my_upload_media');

//除管理员外，在[媒体库]只显示用户上传的文件
function my_media_library( $wp_query ) {
    if ( strpos( $_SERVER[ 'REQUEST_URI' ], '/wp-admin/upload.php' ) !== false ) {
        if ( !current_user_can( 'manage_options' ) && !current_user_can( 'manage_media_library' ) ) {
            global $current_user;
            $wp_query->set( 'author', $current_user->id );
        }
    }
}
add_filter('parse_query', 'my_media_library' );
/**
 * create by chenli
 * 处理wiki编辑更新的ajax请求
 */

function update_wiki_entry(){
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

    $wpdb->insert($wpdb->posts, $wiki_new_entry);
    $wpdb->update($wpdb->posts, array(
        "post_content" => $entry_content,
        "post_modified" => $post_modified,
        "post_modified_gmt" => $post_modified_gmt
    ),array(
        ID => $post_id
    ));

    //处理分类
    $term_names_result = $wpdb->get_results("select tt.term_id, tt.term_taxonomy_id, tt.count from $wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tr.term_taxonomy_id=tt.term_taxonomy_id where tt.taxonomy=\"wiki_cats\" and tr.object_id=".$post_id);
    foreach ($term_names_result as $item) {
        $tt_term_id = $item->term_id;
        $tt_term_taxonomy_id = $item->term_taxonomy_id;
        $count = $item->count;
        if(!in_array($tt_term_id, $wiki_categories)){
            $wpdb->query("delete from $wpdb->term_relationships where term_taxonomy_id=".$tt_term_taxonomy_id);
            $wpdb->update($wpdb->term_taxonomy, array(
                "count" => --$count
            ),array(
                term_taxonomy_id => $tt_term_taxonomy_id
            ));
        }

    }
    foreach($wiki_categories as $wiki_category) {
        $is_continue = false;
        $if_has_category = $wpdb->get_results("select count(*) as has_category from $wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id where tr.object_id=".$post_id." and tt.term_id=".$wiki_category);
        foreach($if_has_category as $item) {
            if($item->has_category != 0) {
                $is_continue = true;
            }
        }
        if($is_continue) {
            continue;
        }
        $term_taxonomy_result = $wpdb->get_results("select * from $wpdb->term_taxonomy where term_id=".$wiki_category);
        foreach($term_taxonomy_result as $term_taxonomy_item) {
            $count = $term_taxonomy_item->count;
            $term_taxonomy_id = $term_taxonomy_item->term_taxonomy_id;
            $wpdb->update($wpdb->term_taxonomy, array(
                "count" => ++$count
            ),array(
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
    $term_names_result = $wpdb->get_results("select t.`name`, tt.term_taxonomy_id, tt.count from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=".$post_id." and tt.taxonomy=\"wiki_tags\"");
    foreach ($term_names_result as $item) {
        $term_name = $item->name;
        $tt_term_taxonomy_id = $item->term_taxonomy_id;
        $count = $item->count;
        if(!in_array($term_name, $wiki_tags)){
            $wpdb->query("delete from $wpdb->term_relationships where term_taxonomy_id=".$tt_term_taxonomy_id);
            $wpdb->update($wpdb->term_taxonomy, array(
                "count" => --$count
            ),array(
                term_taxonomy_id => $tt_term_taxonomy_id
            ));
        }

    }
    foreach($wiki_tags as $wiki_tag) {
        $is_continue = false;
        $if_has_tag = $wpdb->get_results("select count(*) as has_tag from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=".$post_id." and t.`name`=\"".$wiki_tag."\" and tt.taxonomy=\"wiki_tags\"");
        foreach($if_has_tag as $item) {
            if($item->has_tag != 0) {
                $is_continue = true;
            }
        }
        if($is_continue) {
            continue;
        }
        $if_tag_exist = $wpdb->get_results("select count(*) as tag_nums, t.term_id from $wpdb->terms t left join $wpdb->term_taxonomy tt on t.term_id = tt.term_id where tt.taxonomy=\"wiki_tags\" and t.name = "."\"".$wiki_tag."\"");
        foreach($if_tag_exist as $if_tag_exist_item) {
            if($if_tag_exist_item->tag_nums > 0) {
                $term_taxonomy_result = $wpdb->get_results("select * from $wpdb->term_taxonomy where term_id=".$if_tag_exist_item->term_id);
                foreach($term_taxonomy_result as $term_taxonomy_item) {
                    $count = $term_taxonomy_item->count;
                    $term_taxonomy_id = $term_taxonomy_item->term_taxonomy_id;
                    $wpdb->update($wpdb->term_taxonomy, array(
                        "count" => ++$count
                    ),array(
                        term_id => $if_tag_exist_item->term_id
                    ));
                }
                $wpdb->insert($wpdb->term_relationships,array(
                    "object_id" => $post_id,
                    "term_taxonomy_id" => $term_taxonomy_id,
                    "term_order" => 0
                ));
            } else {
                $wpdb->query("insert into $wpdb->terms values (0, "."\"".$wiki_tag."\", \"".$wiki_tag."\", 0)");
                $last_insert = $wpdb->insert_id;
                $wpdb->query("insert into $wpdb->term_taxonomy values (0, ".$last_insert.", \"wiki_tags\", \"wiki_tags\", 0, 1)");
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
function create_wiki_entry() {
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
    $same_title_entrys = $wpdb->get_results("select count(*) as nums from $wpdb->posts where post_title=\"".$entry_title."\" and post_status=\"publish\"");
    $nums = 0;
    foreach($same_title_entrys as $item) {
        $nums = $item->nums;
    }
    $post_name = time();
    if($nums > 0) {
        $nums++;
        $post_name = $post_name."-".$nums;
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
    $last_insert = $wpdb->get_results("select ID from $wpdb->posts where post_title=\"".$entry_title."\" and post_status=\"publish\" and post_name=\"".$post_name."\"");
    $last_insert_ID = 0;
    foreach($last_insert as $item) {
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
        'post_name' => urlencode($last_insert_ID."-revision-v1"),
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
    foreach($wiki_categories as $wiki_category) {
        $term_taxonomy_result = $wpdb->get_results("select * from $wpdb->term_taxonomy where term_id=".$wiki_category);
        foreach($term_taxonomy_result as $term_taxonomy_item) {
            $count = $term_taxonomy_item->count;
            $term_taxonomy_id = $term_taxonomy_item->term_taxonomy_id;
            $wpdb->update($wpdb->term_taxonomy, array(
                "count" => ++$count
            ),array(
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
    foreach($wiki_tags as $wiki_tag) {
        $if_tag_exist = $wpdb->get_results("select count(*) as tag_nums, t.term_id from $wpdb->terms t left join $wpdb->term_taxonomy tt on t.term_id = tt.term_id where tt.taxonomy=\"wiki_tags\" and t.name = "."\"".$wiki_tag."\"");
        foreach($if_tag_exist as $if_tag_exist_item) {
            if($if_tag_exist_item->tag_nums > 0) {
                $term_taxonomy_result = $wpdb->get_results("select * from $wpdb->term_taxonomy where term_id=".$if_tag_exist_item->term_id);
                foreach($term_taxonomy_result as $term_taxonomy_item) {
                    $count = $term_taxonomy_item->count;
                    $term_taxonomy_id = $term_taxonomy_item->term_taxonomy_id;
                    $wpdb->update($wpdb->term_taxonomy, array(
                        "count" => ++$count
                    ),array(
                        term_id => $if_tag_exist_item->term_id
                    ));
                }
                $wpdb->insert($wpdb->term_relationships,array(
                    "object_id" => $last_insert_ID,
                    "term_taxonomy_id" => $term_taxonomy_id,
                    "term_order" => 0
                ));
            } else {
                $wpdb->query("insert into $wpdb->terms values (0, "."\"".$wiki_tag."\", \"".$wiki_tag."\", 0)");
                $last_insert = $wpdb->insert_id;
                $wpdb->query("insert into $wpdb->term_taxonomy values (0, ".$last_insert.", \"wiki_tags\", \"wiki_tags\", 0, 1)");
                $last_insert_t_t_id = $wpdb->insert_id;
                $wpdb->insert($wpdb->term_relationships, array(
                    "object_id" => $last_insert_ID,
                    "term_taxonomy_id" => $last_insert_t_t_id,
                    "term_order" => 0
                ));
            }
        }
    }

    echo json_encode($post_name);
    die();

}
add_action('wp_ajax_create_wiki_entry', 'create_wiki_entry');
add_action('wp_ajax_nopriv_create_wiki_entry', 'create_wiki_entry');

function get_post_info() {
    global $wpdb;
    $post_id = $_POST['post_id'];
    $edit_authors_result = $wpdb->get_results("select count(distinct post_author) as edit_authors from $wpdb->posts where post_parent = ".$post_id);
    $revisions_result = $wpdb->get_results("select count(*) as revisions from $wpdb->posts where post_parent = ".$post_id);
    $post_modified_result = $wpdb->get_results("select post_modified from $wpdb->posts where post_parent=".$post_id." order by post_modified desc limit 1");
    $edit_author_nums = 0;
    $revision_nums = 0;
    $post_modified_date = strtotime (date("y-m-d h:i:s"));
    $current_date = strtotime (date("y-m-d h:i:s"));
    foreach($edit_authors_result as $edit_authors) {
        $edit_author_nums = $edit_authors->edit_authors;
    }
    foreach($revisions_result as $revisions) {
        $revision_nums = $revisions->revisions;
    }
    foreach ($post_modified_result as $post_modified) {
        $post_modified_date = strtotime($post_modified->post_modified);
    }
    $time = ceil(($current_date-$post_modified_date)/86400);
    $categorys_result = $wpdb->get_results("select t.`name` from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=".$post_id." and tt.taxonomy=\"wiki_cats\"");
    $tags_result = $wpdb->get_results("select t.`name` from ($wpdb->term_taxonomy tt left join $wpdb->term_relationships tr on tt.term_taxonomy_id=tr.term_taxonomy_id) left join $wpdb->terms t on t.term_id=tt.term_id where tr.object_id=".$post_id." and tt.taxonomy=\"wiki_tags\"");
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
    $if_has_watched = $wpdb->get_results("select meta_value, meta_id from $wpdb->postmeta where meta_key=\"count\" and post_id=".$post_id);
    $is_watched = false;
    $watch_nums = 0;
    $meta_id = 0;
    foreach ($if_has_watched as $item) {
        $watch_nums = $item->meta_value;
        if(!empty($watch_nums)) {
            $is_watched = true;
            $meta_id = $item->meta_id;
        }
    }
    if($is_watched) {
        $wpdb->update($wpdb->postmeta, array(
            "meta_value" => ++$watch_nums
        ),array(
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

function get_wiki_hot_tags() {
    global $wpdb;
    $hot_tags_nums = 20;
    $hot_tags = array();
    $hot_tags_result = $wpdb->get_results("select t.`name` from $wpdb->terms t left join $wpdb->term_taxonomy tt on t.term_id=tt.term_id where tt.taxonomy=\"wiki_tags\" order by tt.count desc limit ".$hot_tags_nums);
    foreach($hot_tags_result as $item) {
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
function project_custom_pagenavi($custom_query,$range = 4 ) {
    global $paged,$wp_query;
    if ( !$max_page ) {
        $max_page = $custom_query->max_num_pages;
    }
    if( $max_page >1 ) {
        echo "<div class='pagenavi'>";
        if( !$paged ){
            $paged = 1;
        }
        if( $paged != 1 ) {
            echo "<a href='".get_pagenum_link(1) ."' class='extend' title='跳转到首页'>首页</a>";
        }
        previous_posts_link('上一页');
        if ( $max_page >$range ) {
            if( $paged <$range ) {
                for( $i = 1; $i <= ($range +1); $i++ ) {
                    echo "<a href='".get_pagenum_link($i) ."'";
                    if($i==$paged) echo " class='current'";echo ">$i</a>";
                }
            }elseif($paged >= ($max_page -ceil(($range/2)))){
                for($i = $max_page -$range;$i <= $max_page;$i++){
                    echo "<a href='".get_pagenum_link($i) ."'";
                    if($i==$paged)echo " class='current'";echo ">$i</a>";
                }
            }elseif($paged >= $range &&$paged <($max_page -ceil(($range/2)))){
                for($i = ($paged -ceil($range/2));$i <= ($paged +ceil(($range/2)));$i++){
                    echo "<a href='".get_pagenum_link($i) ."'";if($i==$paged) echo " class='current'";echo ">$i</a>";
                }
            }
        }else{
            for($i = 1;$i <= $max_page;$i++){
                echo "<a href='".get_pagenum_link($i) ."'";
                if($i==$paged)echo " class='current'";echo ">$i</a>";
            }
        }
        next_posts_link('下一页',$custom_query->max_num_pages);
        if($paged != $max_page){
            echo "<a href='".get_pagenum_link($max_page) ."' class='extend' title='跳转到最后一页'>尾页</a>";
        }
        echo '<span>['.$paged.']/['.$max_page.']页</span>';
        echo "</div>\n";
    }
}
// 项目模板挂载函数到正确的钩子
function my_add_mce_button() {
    // 检查用户权限
    if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
        return;
    }
    // 检查是否启用可视化编辑
    if ( 'true' == get_user_option( 'rich_editing' ) ) {
        add_filter( 'mce_external_plugins', 'my_add_tinymce_plugin' );
        add_filter( 'mce_buttons', 'my_register_mce_button' );
    }
}
add_action('init', 'my_add_mce_button');

// 声明项目模板的脚本
function my_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['my_mce_button'] = get_template_directory_uri() .'/template/project/mce-button.js';
    return $plugin_array;
}

// 在编辑器上注册项目模板按钮
function my_register_mce_button( $buttons ) {
    array_push( $buttons, 'my_mce_button' );
    return $buttons;
}

//支持中文注册和登陆
function ludou_sanitize_user ($username, $raw_username, $strict) {
    $username = wp_strip_all_tags( $raw_username );
    $username = remove_accents( $username );
    // Kill octets
    $username = preg_replace( '|%([a-fA-F0-9][a-fA-F0-9])|', '', $username );
    $username = preg_replace( '/&.+?;/', '', $username ); // Kill entities

    // 网上很多教程都是直接将$strict赋值false，
    // 这样会绕过字符串检查，留下隐患
    if ($strict) {
        $username = preg_replace ('|[^a-z\p{Han}0-9 _.\-@]|iu', '', $username);
    }

    $username = trim( $username );
    // Consolidate contiguous whitespace
    $username = preg_replace( '|\s+|', ' ', $username );

    return $username;
}

add_filter ('sanitize_user', 'ludou_sanitize_user', 10, 3);

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

function get_user_related_wiki() {
    $wikis = array();
    $post_status = $_POST['get_wiki_type'];
    $current_user = wp_get_current_user();
    $post_author = $current_user->ID;
    global $wpdb;
    if($post_status == "publish") {
        $publish_wikis_result = $wpdb->get_results("select * from $wpdb->posts where post_author=".$post_author." and post_status=\"publish\" and post_type=\"yada_wiki\"");
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
        $inherit_wikis_result = $wpdb->get_results("select * from $wpdb->posts where post_author=".$post_author." and post_status=\"inherit\" group by post_parent");
        foreach ($inherit_wikis_result as $item) {
            $parent_id = $item->post_parent;
            if(in_array($parent_id, $all_wikis_ids)) {
                $inherit_ids[] = $parent_id;
            }
        }
        if(count($inherit_ids)>0) {
            $inherit_ids_str = "";
            for($i=0;$i<count($inherit_ids);$i++) {
                if($i == 0) {
                    $inherit_ids_str = "(".$inherit_ids[$i].",";
                    continue;
                }
                if($i == count($inherit_ids)-1){
                    $inherit_ids_str = $inherit_ids_str.$inherit_ids[$i].")";
                    continue;
                }
                $inherit_ids_str = $inherit_ids_str.$inherit_ids[$i].",";
            }
            if(count($inherit_ids) == 1) {
                $inherit_ids_str = "(".$inherit_ids[0].")";
            }
            $final_wikis_result = $wpdb->get_results("select * from $wpdb->posts where `ID` in ".$inherit_ids_str);
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

function get_notice() {
    global $wpdb;
    $all_post_ids = array();
    $new_comments = array();
    $current_user = wp_get_current_user();
    //$all_post_id_result = $wpdb->get_results("select ID from $wpdb->posts where post_author =".$current_user);
    $all_post_id_result = $wpdb->get_results("select * from $wpdb->posts where post_author=" . get_current_user());

    foreach ($all_post_id_result as $item) {
        $all_post_ids[] = $item->ID;
    }
    if(count($all_post_ids)>0) {

        $inherit_ids_str = "";
        for($i=0;$i<count($all_post_ids);$i++) {
            if($i == 0) {
                $inherit_ids_str = "(".$all_post_ids[$i].",";
                continue;
            }
            if($i == count($all_post_ids)-1){
                $inherit_ids_str = $inherit_ids_str.$all_post_ids[$i].")";
                continue;
            }
            $inherit_ids_str = $inherit_ids_str.$all_post_ids[$i].",";
        }
        if(count($all_post_ids) == 1) {
            $inherit_ids_str = "(".$all_post_ids[0].")";
        }
        $new_comments_result = $wpdb->get_results("select * from $wpdb->comments where comment_post_ID in ".$inherit_ids_str." and user_id !=".$current_user." and if_new_comment = 0");
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
function my_login_redirect($redirect_to, $request){
    if( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() )
        return get_bloginfo( 'url' ) ;
    else
        return $redirect_to;
}
add_filter('login_redirect', 'my_login_redirect', 10, 3);

// 在编辑器中启用字体和字体大小选择
if ( ! function_exists( 'wpex_mce_buttons' ) ) {
    function wpex_mce_buttons( $buttons ) {
        array_unshift( $buttons, 'fontselect' ); // 添加字体选择
        array_unshift( $buttons, 'fontsizeselect' ); // 添加字体大小选择
        return $buttons;
    }
}
add_filter( 'mce_buttons_2', 'wpex_mce_buttons' );

//建立relation表
function relation_table_install () {
    global $wpdb;
    $table_name = $wpdb->prefix . "relation";  //获取表前缀，并设置新表的名称
    if($wpdb->get_var("show tables like $table_name") != $table_name) {  //判断表是否已存在
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


//写入pro-->wiki关系。-->在pro页面展示wiki
function writeProWiki($pro_post_id){
    /* 先找出一个项目,获取项目的content(ok)
     * 进入对所有wiki词条的循环
     * 在循环中找出wiki词条title(ok),在content中搜索,计数
     * 并在relation数据库中插入一条数据,默认qa和project中为空
     * 将wiki的信息保存
     * 将返回的信息压进一个数组
     * 在循环外对数字排序
     * 返回值是 pro所关联的wiki信息数组。
     * */
    $td_array = array();
    $arr_sort_wiki= array();
    //获取项目内容
    $content = strtolower(get_post($pro_post_id)->post_content);
    //获取所有wiki词条
    $args_wiki_all = array(
        'post_type'  => 'yada_wiki',
        'posts_per_page' => -1,
    );
    $wiki_all = new WP_Query( $args_wiki_all );
    //进入wiki词条循环,对每一个词条
    if ( $wiki_all->have_posts() ) :
         while ($wiki_all->have_posts()) : $wiki_all->the_post();
             if (get_post_status() == 'publish') :
                 //进行比对处理,获取回来的$wiki_info包含id,title,count三个信息
                 $wiki_info = processEachProWiki($pro_post_id,$content);
                 if(!empty($wiki_info)){//如果该词条出现在了项目中,将其保存在$td_array二维数组中
                     array_push($td_array,$wiki_info);
                 }
             endif;
         endwhile;
    else :
        echo "error";//没有wiki词条的情况,不会出现
    endif;
    //如果项目中包含一些wiki词条
    if(!empty($td_array)){
        //按照count排序,保存在$td_array中
        foreach($td_array as $key =>$value){
            foreach($value as $i =>$count){
                $arr_sort_wiki[$i][$key] = $count;
            }
        }
        array_multisort($arr_sort_wiki['wiki_count'], SORT_DESC,$td_array);
    }
    return $td_array;
}
//针对每一个wiki词条 为writeProWiki服务
function processEachProWiki($pro_post_id,$content)
{
    $wiki_info = array();
    $wiki_title = strtolower(get_the_title());  //全部转化成小写 因为substr_count是精确匹配。
    $appear_count = substr_count($content, $wiki_title);  //这个词条在content中出现的次数。
    if ($appear_count != 0) {  //如果出现了
        global $wpdb;
        $wiki_id = get_the_ID(); //获取这个wiki的ID
        $view_count =getViews($wiki_id);
        //判断表中是否已经存在这个pro<->wiki对
        $sql_1 = "SELECT * FROM wp_relation WHERE post_id=$pro_post_id AND related_id=$wiki_id";
        $col = $wpdb->query($sql_1); //返回的结果有几行
        if ($col === 0) {  //如果没有这个pro<->wiki对
            $sql_2 = "INSERT INTO wp_relation VALUES ('',$pro_post_id,'post',$wiki_id,'yada_wiki')";
            $wpdb->get_results($sql_2);
        }
        //如果存在了这个pro<->wiki对,不做任何处理,将wiki的信息加入返回的数组
        $count = 0.5*$appear_count+0.5*$view_count;
        $wiki_info = array('wiki_id' => $wiki_id, 'wiki_title' => $wiki_title, 'wiki_count' => $count);
    }
    //没有出现不做任何处理,直接返回空数组。
    return $wiki_info;
}

//获取wiki的浏览量
function getViews($post_id){
    global $wpdb;
    $sql = "SELECT * FROM wp_views WHERE post_id=$post_id";
    $view_count = $wpdb->get_var($wpdb->prepare($sql,""),3,0);
    return $view_count;
}

//写入pro-->qa wiki->qa 关系.  -->在QA页面展示pro wiki
function writePWQA($post_id,$post_type,$related_id,$related_post_type){
    global $wpdb;
    $sql_1 = "SELECT * FROM wp_relation WHERE post_id=$post_id AND related_id=$related_id";
    $col = $wpdb->query($sql_1); //返回的结果有几行
    if ($col === 0) {  //如果没有这个pro<->wiki对
        $sql_2 = "INSERT INTO wp_relation VALUES ('',$post_id,'$post_type',$related_id,'$related_post_type')";
        $wpdb->get_results($sql_2);
    }
}

//在qa页面展示来自项目or wiki 返回来自哪个post的info
function qaComeFrom($qa_id){
    global $wpdb;
    $post_id = $wpdb->get_var($wpdb->prepare("SELECT * FROM wp_relation WHERE related_id=$qa_id;",""),1,0);
    $post_type = $wpdb->get_var($wpdb->prepare("SELECT * FROM wp_relation WHERE related_id=$qa_id;",""),2,0);
    $related_info = array('id' => $post_id, 'post_type' => $post_type);
    return $related_info;
}

//返回此项目对用的所有问答  -->在项目和wiki页面的comment中显示QA
function pwRelatedQA($pro_id){
    global $wpdb;
    $qa_id = array();
    $sql = "SELECT * FROM wp_relation WHERE post_id=$pro_id AND related_post_type='dwqa-question'";
    $result = $wpdb->get_results($sql);
    foreach($result as $key =>$value){
        $related_id[] = $value->related_id;
        array_push($qa_id,$related_id[$key]);
    }
    return $qa_id;
}

//获取问题的作者id和name,为wiki和project评论中的问题服务(pwRelatedQA())
function Spark_get_author($qa_id){
    global $wpdb;
    $author_id = $wpdb->get_var($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE ID=$qa_id",""),1,0);
    $author_name = $wpdb->get_var($wpdb->prepare("SELECT * FROM $wpdb->users WHERE ID=$author_id",""),1,0);
    $author_info = array('id' => $author_id, 'name' => $author_name);
    return $author_info;
}

//wiki侧边栏显示相关的项目
function wikiRelatedPro($wiki_id){
    global $wpdb;
    $post_id = array(); //项目id
    $sql = "SELECT * FROM wp_relation WHERE related_id=$wiki_id AND post_type='post'";
    $result = $wpdb->get_results($sql);
    foreach($result as $key =>$value){
        $pro_id[] = $value->post_id;
        array_push($post_id,$pro_id[$key]);
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
            <li id="related_project" class="list-group-item">
                <a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a>
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
                <a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a>
            </li>
            <?php $i++;
        }
        wp_reset_query();
    }
    if ($i == 0) echo '<p>没有相似项目!</p>';
}

//建立用户轨迹表
function user_history_table_install ()
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
function writeUserTrack(){
    global $wpdb;
    $post_id = $_SESSION['post_id'];
    $post_type = $_SESSION['post_type'];
    $user_action = $_SESSION['action'];
    $user_id = $_SESSION['user_id'];
    $timestamp = $_SESSION['timestamp'];
    session_destroy();
    $sql = "INSERT INTO wp_user_history VALUES ('',$user_id,'$user_action',$post_id,'$post_type','$timestamp')";
    $wpdb->get_results($sql);
}

?>
