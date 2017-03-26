<?php
/*
Plugin Name: myFirstPlugins
Plugin URI: http://www.cherie.com
Description: 此插件为编写插件练习
Version: 1.0
Author: zhangxue
Author URI: http://www.cherie.com
License: GPL
*/
/* 注册激活插件时要调用的函数 */
register_activation_hook( __FILE__, 'display_copyright_install');

/* 注册停用插件时要调用的函数 */
register_deactivation_hook( __FILE__, 'display_copyright_remove');

function display_copyright_install() {
    /* 在数据库的 wp_options 表中添加一条记录，第二个参数为默认值 */
    add_option("display_copyright_text", "<p style='color:red'>本站点所有文章均为原创，转载请注明出处！</p>", '', 'yes');
}

function display_copyright_remove() {
    /* 删除 wp_options 表中的对应记录 */
    delete_option('display_copyright_text');
}

if( is_admin() ) {
    /*  利用 admin_menu 钩子，添加菜单 将添加一个选项页面到设置菜单 */
    add_action('admin_menu', 'display_copyright_menu');  //第一个参数为系统钩子,第二个参数为用户自己函数。
}

function display_copyright_menu() {
    /* add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function);  */
    /* 页名称，菜单名称，访问级别，菜单别名，点击该菜单时的回调函数（用以显示设置页面） */
    add_options_page('版权设置页面', '版权设置菜单', 'administrator','display_copyright', 'display_copyright_html_page');
}

function display_copyright_html_page() {
    ?>
    <div>
        <h2>版权信息设置</h2>
        <form method="post" action="options.php">
            <?php /* 下面这行代码用来保存表单中内容到数据库 */ ?>
            <?php wp_nonce_field('update-options'); ?>

            <p>
                <textarea name="display_copyright_text" id="display_copyright_text" cols="40" rows="6">
                    <?php echo get_option('display_copyright_text'); ?>
                </textarea>
            </p>

            <p>
                <input type="hidden" name="action" value="update"/>
                <input type="hidden" name="page_options" value="display_copyright_text"/>

                <input type="submit" value="保存设置" class="button-primary"/>
            </p>
        </form>
    </div>
    <?php
}

add_filter( 'the_content',  'display_copyright' );   //filter是操纵数据库的钩子

/* 这个函数在日志正文结尾处添加一段版权信息，并且只在 single 页添加 */
function display_copyright( $content ) {
    if( is_single() )
        $content = $content . get_option('display_copyright_text');

    return $content;
}
?>