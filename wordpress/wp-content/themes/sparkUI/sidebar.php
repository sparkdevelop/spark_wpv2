<?php
/**
 * sidebar共同的样式
 */
?>
<!--sidebar.php-->
<?php
if(is_home() || is_front_page()) { //首页显示“首页侧栏”
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('home_sidebar')){//dynamic_sidebar('注册时id或者name')
    }
}

if ( is_page('wiki') ) {//显示wiki侧栏”
    echo "wiki边栏";
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_wikisidebar')){
    }
}

if ( is_page(55) ) {//显示问答侧栏 参数为pageID 如何自动获取??
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_qasidebar')){
    }
    require "template/qa/QA_sidebar.php";
}
if ( is_page(96) ) {//显示问题详情页
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_qa_ask_sidebar')){
    }
    require "template/qa/QA_ask_sidebar.php";
}
if (is_page(62)){
    echo "项目边栏";
    if (function_exists('dynamic_sidebar') && dynamic_sidebar('widget_projectsidebar')){
    }

}

?>


