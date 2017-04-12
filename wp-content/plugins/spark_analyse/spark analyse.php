<?php
/**
Plugin Name: spark
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Matt Mullenweg
Version: 1.6
Author URI: http://ma.tt/
 */
if ( ! function_exists( 'spark_settings_submenu_page' ) ) {
    require_once( 'analyseview.php' );
}

     add_action( 'admin_menu', 'spark_create_menu' );
     add_action('admin_menu', 'spark_create_submenu_page');
    // add_filter('the_content','addContent');
    // add_filter('get_comment_author','authorUpperCase');
         function spark_create_menu()
         {
             // 创建顶级菜单
             add_menu_page(
                 'My Plugin',
                 '数据分析',
                 'administrator',
                 'spark_analyse',
                 'spark_settings_menu'
             );
         }
//add_action( 'admin_init', 'my_plugin_admin_init' );

         function spark_create_submenu_page()
         {

             add_submenu_page(
                  'spark_analyse',
                  '查看用户画像',
                  '查看用户画像',
                  'administrator',
                  'spark_analyse-submenu-page',
                  'spark_settings_submenu_page' );
          //add_action('admin_enqueue_scripts', 'wpjam_normal_script');
          }

         function spark_settings_menu()
         {

             ?>
             <?php
           //  update_option('spark_search_user_copy_right', 'root');
             $option = get_option('spark_search_user_copy_right');//获取选项
             if( $option == '' ){
                 //设置默认数据
                $option = '请输入用户ID';
                 update_option('spark_search_user_copy_right', $option);//更新选项
             }
             if(isset($_POST['option_save'])){
                 //处理数据
                 $option = stripslashes($_POST['spark_search_user_copy_right']);
                 update_option('spark_search_user_copy_right', $option);//更新选项
             }
             //$option = get_option('spark_search_user_copy_right');//获取选项

             ?>

             <html>
         <body style="background-size:100% 100%;background-color:white;position: absolute;left:0px;top:78px;z-index: -1" onload="document.all['me'].selectall = 'true';">

                         <form method="post" name="spark_search_user" id="spark_search_user">
                             <h2>火花空间用户画像查询</h2>
                             <p>
                                 <label>
                                     <input name="spark_search_user_copy_right" size="40" value="<?php echo get_option('spark_search_user_copy_right'); ?>"/>
                                     请输入用户ID
                                 </label>
                             </p>
                             <p class="submit">
                                 <input type="submit" name="option_save" value="<?php _e('保存用户名'); ?>" />
                             </p>
                         </form>
             </body>
             </html>

             <?php
         }
