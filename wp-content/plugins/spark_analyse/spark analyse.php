<?php
/**
Plugin Name: spark_analyse
Plugin URI: http://wordpress.org/plugins/spark_analyse/
Description: This is a plugin for spark analyse
Author: Mr.Zhang
Version: 1.0
Author URI: http://ma.tt/
 */
if ( ! function_exists( 'spark_settings_submenu_page' ) ) {
    require_once('analyseview.php');
}
require_once('infer.php');

     add_action( 'admin_menu', 'spark_create_menu1' );
     add_action('admin_menu', 'spark_create_submenu_page1');
     add_action('admin_menu', 'spark_create_submenu_page2');
    // add_filter('the_content','addContent');
    // add_filter('get_comment_author','authorUpperCase');
         function spark_create_menu1()
         {
             // 创建顶级菜单
             add_menu_page(
                 'My Plugin1',
                 '用户画像',
                 'administrator',
                 'spark analyse',
                 'spark_settings_menu1'
             );
         }
//add_action( 'admin_init', 'my_plugin_admin_init' );

         function spark_create_submenu_page1()
         {

             add_submenu_page(
                  'spark analyse',
                  '查看用户画像',
                  '查看用户画像',
                  'administrator',
                  'spark_analyse-submenu-page',
                  'spark_settings_submenu_page' );
          //add_action('admin_enqueue_scripts', 'wpjam_normal_script');
          }
         function spark_create_submenu_page2()
         {

             add_submenu_page(
                  'spark analyse',
                  '用户画像推测',
                  '用户画像推测',
                 'administrator',
                 'spark_analyse-submenu-page2',
                 'spark_settings_submenu_page2' );
    //add_action('admin_enqueue_scripts', 'wpjam_normal_script');
         }
define('COUNT_TABLE', $wpdb->prefix . 'count');
define('COUNTD_TABLE', $wpdb->prefix . 'countdesire');
register_activation_hook(__FILE__,'install_table1');
         function install_table1 ()
         {
             global $wpdb;
             //$table_name = $wpdb->prefix . "counts";
            // $table_name="wp_count";
             if ($wpdb->get_var("show tables like  '" . COUNT_TABLE . "'") != COUNT_TABLE) {
                 $sql = "CREATE TABLE IF NOT EXISTS " . COUNT_TABLE . " (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                user varchar(60) DEFAULT '0' NOT NULL,
                phpcount float NOT NULL,
                htmlcount float NOT NULL,
                jscount float NOT NULL,
                mycookiecount float NOT NULL,
                danpianjicount float NOT NULL,
                csscount float NOT NULL,
                sqlcount float NOT NULL,
                duinocount float NOT NULL,
                androidcount float NOT NULL,
                ioscount float NOT NULL,
                pingtaicount float NOT NULL,
                webcount float NOT NULL,
                matlabcount float NOT NULL,
                UNIQUE KEY id (id) );";
                 require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                 dbDelta($sql);
             }
         }
register_activation_hook(__FILE__,'install_table2');
function install_table2 ()
{
    global $wpdb;
   // $table_name = $wpdb->prefix . "countdesires";
    if ($wpdb->get_var("show tables like  '" . COUNTD_TABLE . "'") != COUNTD_TABLE) {
        $sql = "CREATE TABLE IF NOT EXISTS " . COUNTD_TABLE . " (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                user varchar(60) DEFAULT '0' NOT NULL,
                phpcount float NOT NULL,
                htmlcount float NOT NULL,
                jscount float NOT NULL,
                mycookiecount float NOT NULL,
                danpianjicount float NOT NULL,
                csscount float NOT NULL,
                sqlcount float NOT NULL,
                duinocount float NOT NULL,
                androidcount float NOT NULL,
                ioscount float NOT NULL,
                pingtaicount float NOT NULL,
                webcount float NOT NULL,
                matlabcount float NOT NULL,
                UNIQUE KEY id (id) );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
         function spark_settings_menu1()
         {

             ?>
             <?php
           //  update_option('spark_search_user_copy_right', 'root');
             $option =$_POST['option_save'];;//获取选项
             if( $option == '' ){
                 //设置默认数据
                $option = 'root';
                 update_option('spark_search_user_copy_right', $option);//更新选项
             }
             if(isset($_POST['option_save'])){
                 //处理数据
                 $option = stripslashes($_POST['spark_search_user_copy_right']);

                 update_option('spark_search_user_copy_right', $option);//更新选项
             }
//             $option = get_option('spark_search_user_copy_right');
//             $sql=0;
//             global $wpdb;
//             $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$option'");
//             if ($sql==0)
//                 echo "<script>alert('该用户不存在')</script>";;

             ?>

             <html>
         <body style="background-color: #f1f2f7" onload="document.all['me'].selectall = 'true';">
         <div style="text-align:center;background-color:rgb(100,201,202);margin-top: 22px;width: 93px;height: 93px;margin-left: 46%;border-radius: 50%;border: solid 1px rgb(100,201,202)"><i class="fa fa-user fa-5x " style="color:white;"></i></div>
         <h2 style="    text-align: center;margin: 20px;font-size: 20px;">火花空间用户画像查询</h2>
                         <form method="post" name="spark_search_user" id="spark_search_user">
                                     <input name="spark_search_user_copy_right" class="form-control" placeholder="username" size="40" style="    margin-left: 10%; width: 80%;"/>

                             <p class="submit" style="    text-align: center;">
                                 <button type="submit" class="btn btn-default" name="option_save" ><?php _e('保存用户名'); ?></button>
                             </p>
                         </form>
             </body>
             </html>

             <?php
         }
