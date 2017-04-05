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


?>