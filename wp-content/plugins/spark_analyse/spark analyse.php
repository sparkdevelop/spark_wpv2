<?php
/**
Plugin Name: spark_analyse
Plugin URI: http://wordpress.org/plugins/spark_analyse/
Description: This is a plugin for spark analyse
Author: ruler
Version: 2.0
Author URI: http://ma.tt/
 */
header("Content-type:text/html;charset=utf-8");
//require_once( ABSPATH . 'wp-admin/includes/admin.php' );
function plugin2()
{
    wp_register_style('zhyfep-style', plugins_url('bootstrap.min.css', __FILE__), array(), '1.6', 'all');
    wp_register_style('zhydatepicker-style', plugins_url('dateRange.css', __FILE__), array(), '1.6', 'all');
    wp_register_style('zhymain-style', plugins_url('main.css', __FILE__), array(), '1.0', 'all');
    wp_register_style('zhytable-style', plugins_url('table.css', __FILE__), array(), '1.6', 'all');
    wp_register_style('zhyuser-style', plugins_url('user.css', __FILE__), array(), '1.6', 'all');
    wp_register_style('zhytag-style', plugins_url('tagcloud.css', __FILE__), array(), '1.6', 'all');
    wp_register_script("zhyjquery-script", plugins_url('js/jquery-3.2.1.js', __FILE__), array('jquery'));
    wp_register_script("zhydate-script", plugins_url('js/dateRange.js', __FILE__), array('jquery'));
    wp_register_script("zhytag-script", plugins_url('js/tagcloud.min.js', __FILE__), array('jquery'));
    wp_register_script("zhyui-script", plugins_url('js/jquery-ui.js', __FILE__), array('jquery'));
    wp_register_script("zhytime-script", plugins_url('js/active.js', __FILE__), array('jquery'));
    wp_register_script("zhyfep-script", plugins_url('js/bootstrap.min.js', __FILE__), array('jquery'));
    wp_register_script("zhyview-script", plugins_url('js/view.js', __FILE__), array('jquery'));
    wp_register_script("zhycollapse-script", plugins_url('js/collapse.js', __FILE__), array('jquery'));
    wp_register_script("zhyhigh-script", plugins_url('js/Highcharts-6.0.3/code/highcharts.js', __FILE__), array('jquery'));
    wp_register_script("zhyhighm-script", plugins_url('js/Highcharts-6.0.3/code/highcharts-more.js', __FILE__), array('jquery'));
//wp_register_script("increment-script", plugins_url('js/user_increment.js', __FILE__),array('jquery'));
    wp_register_script("zhyexp-script", plugins_url('js/Highcharts-6.0.3/code/modules/exporting.js', __FILE__), array('jquery'));
    wp_register_script("zhywor-script", plugins_url('js/Highcharts-6.0.3/code/modules/wordcloud.js', __FILE__), array('jquery'));
    wp_register_script("zhyold-script", plugins_url('js/Highcharts-6.0.3/code/modules/oldie.js', __FILE__), array('jquery'));
    wp_register_script("zhytransition-script", plugins_url('js/transition.js', __FILE__), array('jquery'));
    wp_register_script("zhytidui-script", plugins_url('js/tidui.js', __FILE__), array('jquery'));
    wp_register_script("zhystay-script", plugins_url('js/stay.js', __FILE__), array('jquery'));
    wp_register_script("zhyteamview-script", plugins_url('js/team_view.js', __FILE__), array('jquery'));
    wp_register_script("zhyemotionview-script", plugins_url('js/emotion.js', __FILE__), array('jquery'));
    wp_register_script("zhygroup-script", plugins_url('js/group_analysis.js', __FILE__), array('jquery'));

    wp_enqueue_script("zhyjquery-script");
    wp_enqueue_script("zhyfep-script");

    wp_enqueue_script("zhyhigh-script");
    wp_enqueue_script("zhyhighm-script");
    wp_enqueue_script("zhytag-script");
    wp_enqueue_script("zhytime-script");
    wp_enqueue_script("zhyview-script");
    wp_enqueue_script("zhytransition-script");

//    wp_enqueue_script("increment-script");
    wp_enqueue_script("zhycollapse-script");
    wp_enqueue_script("zhydate-script");
    wp_enqueue_script("zhyui-script");
    wp_enqueue_script("zhytidui-script");
    wp_enqueue_script("zhyteamview-script");
    wp_enqueue_script("zhystay-script");
    wp_enqueue_script("zhyexp-script");
    wp_enqueue_script("zhywor-script");
    wp_enqueue_script("zhyold-script");
    wp_enqueue_script("zhyemotionview-script");
    wp_enqueue_script("zhygroup-script");


    wp_enqueue_style('zhyfep-style');
    wp_enqueue_style('zhydatepicker-style');
    wp_enqueue_style('zhymain-style');
    wp_enqueue_style('zhytable-style');
    wp_enqueue_style('zhyuser-style');
    wp_enqueue_style('zhytag-style');
}

add_action( 'admin_enqueue_scripts', 'plugin2' );

require_once('analyseview.php');
require_once('group_view');
require_once('infer.php');
require_once('all_statistic.php');
require_once('user_status_view.php');

     add_action( 'admin_menu', 'spark_create_menu1' );
     add_action('admin_menu', 'spark_create_submenu_page1');
     add_action('admin_menu', 'spark_create_submenu_page2');
     add_action('admin_menu', 'spark_create_submenu_page3');
     add_action('admin_menu', 'spark_create_submenu_page4');
     add_action('admin_menu', 'spark_create_submenu_page5');
    // add_filter('the_content','addContent');
    // add_filter('get_comment_author','authorUpperCase');
         function spark_create_menu1()
         {
             // 创建顶级菜单
             add_menu_page(
                 'My Plugin1',
                 '用户画像',
                 'read',
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
                  'read',
                  'spark_analyse_submenu_page',
                  'spark_settings_submenu_page' );
          //add_action('admin_enqueue_scripts', 'wpjam_normal_script');
          }
         function spark_create_submenu_page2()
         {

             add_submenu_page(
                  'spark analyse',
                  '用户画像推测',
                  '用户画像推测',
                 'read',
                 'spark_analyse_submenu_page2',
                 'spark_settings_submenu_page2' );
    //add_action('admin_enqueue_scripts', 'wpjam_normal_script');
         }
         function spark_create_submenu_page3()
         {

              add_submenu_page(
                   'spark analyse',
                   '系统统计',
                   '系统统计',
                   'read',
                   'spark_analyse_submenu_page3',
                   'spark_settings_submenu_page3' );
    //add_action('admin_enqueue_scripts', 'wpjam_normal_script');
         }
         function spark_create_submenu_page4()
         {

               add_submenu_page(
                    'spark analyse',
                    '群组分析',
                    '群组分析',
                    'read',
                    'spark_analyse_submenu_page4',
                    'spark_settings_submenu_page4' );
    //add_action('admin_enqueue_scripts', 'wpjam_normal_script');
          }
         function spark_create_submenu_page5()
         {

                add_submenu_page(
                      'spark analyse',
                      '用户分析',
                      '用户分析',
                      'read',
                      'spark_analyse_submenu_page5',
                      'spark_settings_submenu_page5' );
    //add_action('admin_enqueue_scripts', 'wpjam_normal_script');
         }


define('COUNT_TABLE', $wpdb->prefix . 'count_sec');
define('COUNTD_TABLE', $wpdb->prefix . 'countdesire_sec');
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
                jiqixuexicount float NOT NULL,
                jisuanjishijuecount float NOT NULL,
                tuijiancount float NOT NULL,
                dianlufenxicount float NOT NULL,
                danpianjicount float NOT NULL,
                shuzidianlucount float NOT NULL,
                tongyuancount float NOT NULL,
                tongxincount float NOT NULL,
                diancicount float NOT NULL,
                bianchengcount float NOT NULL,
                jisuanjijichucount float NOT NULL,
                webcount float NOT NULL,
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
                 jiqixuexicount float NOT NULL,
                jisuanjishijuecount float NOT NULL,
                tuijiancount float NOT NULL,
                dianlufenxicount float NOT NULL,
                danpianjicount float NOT NULL,
                shuzidianlucount float NOT NULL,
                tongyuancount float NOT NULL,
                tongxincount float NOT NULL,
                diancicount float NOT NULL,
                bianchengcount float NOT NULL,
                jisuanjijichucount float NOT NULL,
                webcount float NOT NULL,
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
                $option = 'spark_admin';
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
         <body style="background-color: #f1f2f7" >
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
