<?php
/**
 * sidebar共同的样式
 */
$page_wiki_id = get_page_id('wiki_index');
$page_qa_id = get_page_id('qa');
$page_project_id =get_page_id('project');
$page_ask_id = get_page_id('ask');
$page_personal_id = get_page_id('personal');
$page_search_id = get_page_id('search');
$wiki_post_type = get_post_type();
?>
<!--sidebar.php-->
<?php
if(is_home() || is_front_page()) { //首页显示“首页侧栏”
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('home_sidebar')){//dynamic_sidebar('注册时id或者name')
    }
}
if(is_page($page_wiki_id)) {
    require "template/wiki/wiki_sidebar.php";
}
//if ( is_page($page_qa_id) ) {//显示问答侧栏 参数为pageID 如何自动获取??
//    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_qasidebar')){
//    }
//    require "template/qa/QA_sidebar.php";
//}
if (is_page('项目')){
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_projectsidebar')){
    }
    require "template/project/project_sidebar.php";
}
if (is_tag()){
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_projectsidebar')){
    }
    require "template/project/project_sidebar.php";
}
if (is_category()){
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_projectsidebar')){
    }
    require "template/project/project_sidebar.php";
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
if ( is_page('otherpersonal') ) {//显示问题详情页
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_otherpersonalsidebar')){
    }
    require "template/otherpersonal_sidebar.php";
}

if (is_search()){
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_searchsidebar')){
    }
    require "template/search_sidebar.php";
}
if (is_tag()){
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_tagssidebar')){
    }
    //require "template/qa/QA_tags_sidebar.php";
}
if (is_page("group")){
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_groupsidebar')){
    }
    require "template/group/index_sidebar.php";
}
if (is_page("single_group")){
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_singlegroupsidebar')){
    }
    require "template/group/single_group_sidebar.php";
}
if (is_page("single_task")){
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_singletasksidebar')){
    }
    require "template/group/single_task_sidebar.php";
}
//这个判断wiki详情是谁写的，not created by chenli
if(is_page("wiki详情")) {
    require "template/wiki/wiki_entry_sidebar.php";
}
if(is_page("编辑wiki")) {
    require "template/wiki/wiki_edit_sidebar.php";
}
if(is_page("创建wiki")) {
    require "template/wiki/wiki_create_sidebar.php";
}
if($wiki_post_type == "yada_wiki" && empty($_GET['s'])) {
    require "template/wiki/wiki_entry_sidebar.php";
}
?>
