<?php

if(function_exists('register_nav_menus')){
    register_nav_menus(array('header-menu' => __( '导航自定义菜单' )));
}
register_sidebar(
    array(
        'name'          => '侧边栏',
        'before_widget' => '<div class="sbox">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
    )
);