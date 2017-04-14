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
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'custom-script');
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
    return "<a $text>";
}
add_filter('wp_tag_cloud', 'colorCloud', 1);
//显示标签数量
function Tagno($text) {
    $text = preg_replace_callback('|<a (.+?)</a>|i', 'tagnoCallback', $text);
    return $text;
}
function tagnoCallback($matches) {
    $text=$matches[1];
    preg_match('|title=(.+?)style|i',$text ,$a);
    preg_match("/[0-9]/",$a[1],$a);
    return "<a ".$text ."<span class='badge'>(".$a[0].")</span>";
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
    $page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$page_name'");
    return $page_id;
}

function get_page_address($page_name){
    global $wpdb;
    $page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$page_name'");
    $page_address="?page_id=".$page_id;
    return $page_address;
}

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
//    $archive_question_url = get_permalink( $dwqa_general_settings['pages']['archive-question'] );
//    $page_text = dwqa_is_front_page() ? 'page' : 'paged';
//    $page = get_query_var( $page_text ) ? get_query_var( $page_text ) : 1;
//
//    $tag = get_query_var( 'dwqa-question_tag' ) ? get_query_var( 'dwqa-question_tag' ) : false;
//    $cat = get_query_var( 'dwqa-question_category' ) ? get_query_var( 'dwqa-question_category' ) : false;
//
//    $url = $cat
//        ? get_term_link( $cat, get_query_var( 'taxonomy' ) )
//        : ( $tag ? get_term_link( $tag, get_query_var( 'taxonomy' ) ) : $archive_question_url );
//
//    $args = array(
//        'base' => add_query_arg( $page_text, '%#%', $url ),
//        'format' => '',
//        'current' => $page,
//        'total' => $wp_query->dwqa_questions->max_num_pages
//    );
//
//    $paginate = paginate_links( $args );
//    $paginate = str_replace( 'page-number', 'dwqa-page-number', $paginate );
//    $paginate = str_replace( 'current', 'dwqa-current', $paginate );
//    $paginate = str_replace( 'next', 'dwqa-next', $paginate );
//    $paginate = str_replace( 'prev ', 'dwqa-prev ', $paginate );
//    $paginate = str_replace( 'dots', 'dwqa-dots', $paginate );
//
//    if ( $wp_query->dwqa_questions->max_num_pages > 1 ) {
//        echo '<div class="dwqa-pagination">';
//        echo $paginate;
//        echo '</div>';
//    }
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
/**
 * WordPress 媒体库只显示用户自己上传的文件
 * https://www.wpdaxue.com/view-user-own-media-only.html
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
?>