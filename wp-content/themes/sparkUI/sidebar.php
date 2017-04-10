<?php
/**
 * sidebar共同的样式
 */
global $wpdb;
$page_qa_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = 'qa'");
$page_project_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = 'project'");
$page_ask_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = 'ask'");
$page_ask_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = 'personal'");
$page_search_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = 'search'");
$page_personal_id = get_personal_page();
?>
<!--sidebar.php-->
<?php
if(is_home() || is_front_page()) { //首页显示“首页侧栏”
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('home_sidebar')){//dynamic_sidebar('注册时id或者name')
    }
}

if ( is_page('wiki') ) {//显示wiki侧栏”
    echo '<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">';
    echo "wiki边栏";
    echo '</div>';

    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_wikisidebar')){
    }
}

if ( is_page($page_qa_id) ) {//显示问答侧栏 参数为pageID 如何自动获取??
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_qasidebar')){
    }
    //require "test.php";
    require "template/qa/QA_sidebar.php";
}
if ( is_page($page_ask_id) ) {//显示问题详情页
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_qa_asksidebar')){
    }
    require "template/qa/QA_ask_sidebar.php";
}
if ( is_page($page_personal_id) ) {//显示问题详情页
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_personalsidebar')){
    }
    require "template/personal_sidebar.php";
}
if (is_page($page_project_id)){
    echo '<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">';
    echo "项目边栏";
    echo '</div>';
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_projectsidebar')){
    }
}
if (is_search()){
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_searchsidebar')){
    }
    require "template/qa/QA_search_sidebar.php";
}
if (is_tag()){
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_tagssidebar')){
    }
    //require "template/qa/QA_tags_sidebar.php";
}
?>
