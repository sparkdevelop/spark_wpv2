<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/10
 * Time: 15:23
 */
//function plugin4()
//{
//    wp_register_style('fep-style', plugins_url('bootstrap.min.css', __FILE__), array(), '1.6', 'all');
//    wp_register_style('datepicker-style', plugins_url('dateRange.css', __FILE__), array(), '1.6', 'all');
//    wp_register_style('main-style', plugins_url('main.css', __FILE__), array(), '1.0', 'all');
//    wp_register_style('table-style', plugins_url('table.css', __FILE__), array(), '1.6', 'all');
//    wp_register_style('user-style', plugins_url('user.css', __FILE__), array(), '1.6', 'all');
//    wp_register_style('tag-style', plugins_url('tagcloud.css', __FILE__), array(), '1.6', 'all');
//    wp_register_script("jquery-script", plugins_url('js/jquery-3.2.1.js', __FILE__), array('jquery'));
//    wp_register_script("date-script", plugins_url('js/dateRange.js', __FILE__), array('jquery'));
//    wp_register_script("tag-script", plugins_url('js/tagcloud.min.js', __FILE__), array('jquery'));
//    wp_register_script("ui-script", plugins_url('js/jquery-ui.js', __FILE__), array('jquery'));
//    wp_register_script("time-script", plugins_url('js/active.js', __FILE__), array('jquery'));
//    wp_register_script("view-script", plugins_url('js/view.js', __FILE__), array('jquery'));
//    wp_register_script("fep-script", plugins_url('js/bootstrap.min.js', __FILE__), array('jquery'));
//    wp_register_script("collapse-script", plugins_url('js/collapse.js', __FILE__), array('jquery'));
//    wp_register_script("high-script", plugins_url('js/highcharts.js', __FILE__), array('jquery'));
//    wp_register_script("highm-script", plugins_url('js/highcharts-more.js', __FILE__), array('jquery'));
////wp_register_script("increment-script", plugins_url('js/user_increment.js', __FILE__),array('jquery'));
//    wp_register_script("transition-script", plugins_url('js/transition.js', __FILE__), array('jquery'));
//    if (is_admin()) {
//        wp_enqueue_script("jquery-script");
//        wp_enqueue_script("fep-script");
//
//        wp_enqueue_script("tag-script");
//        wp_enqueue_script("time-script");
//        wp_enqueue_script("view-script");
//        wp_enqueue_script("high-script");
//        wp_enqueue_script("transition-script");
//        wp_enqueue_script("highm-script");
////    wp_enqueue_script("increment-script");
//        wp_enqueue_script("collapse-script");
//        wp_enqueue_script("date-script");
//        wp_enqueue_script("ui-script");
//
//        wp_enqueue_style('fep-style');
//        wp_enqueue_style('datepicker-style');
//        wp_enqueue_style('main-style');
//        wp_enqueue_style('table-style');
//        wp_enqueue_style('user-style');
//        wp_enqueue_style('tag-style');
//    }
//}
//require_once( ABSPATH . 'wp-admin/includes/admin.php' );
//add_action( 'admin_enqueue_scripts', 'plugin4' );

//require_once ('all_rank.php');
add_action('wp_ajax_view_action', 'view_ajax');
function view_ajax(){
    $time1 = isset($_POST['start2']) ? $_POST['start2'] : null;
    $id= isset($_POST['number']) ? $_POST['number'] : null;
    $time1 = date("Y-m-d", strtotime($time1));
    $time2 = date("Y-m-d", strtotime('+1 day', strtotime($time1)));
    $time3 = date("Y-m-d", strtotime('+2 day', strtotime($time1)));
    $time4 = date("Y-m-d", strtotime('+3 day', strtotime($time1)));
    $time5 = date("Y-m-d", strtotime('+4 day', strtotime($time1)));
    $time6 = date("Y-m-d", strtotime('+5 day', strtotime($time1)));
    $time7 = date("Y-m-d", strtotime('+6 day', strtotime($time1)));
    $timegeshi1 = (int)substr($time1, 0, 4) . substr($time1, 5, 2) . substr($time1, 8, 2);
    $timegeshi2 = (int)substr($time2, 0, 4) . substr($time2, 5, 2) . substr($time2, 8, 2);
    $timegeshi3 = (int)substr($time3, 0, 4) . substr($time3, 5, 2) . substr($time3, 8, 2);
    $timegeshi4 = (int)substr($time4, 0, 4) . substr($time4, 5, 2) . substr($time4, 8, 2);
    $timegeshi5 = (int)substr($time5, 0, 4) . substr($time5, 5, 2) . substr($time5, 8, 2);
    $timegeshi6 = (int)substr($time6, 0, 4) . substr($time6, 5, 2) . substr($time6, 8, 2);
    $timegeshi7 = (int)substr($time7, 0, 4) . substr($time7, 5, 2) . substr($time7, 8, 2);

    if($id!=0) {
        $id = explode(",", $id);
        $flag=0;
    }
    else{ $flag=1;}

    if($flag==0) {
        global $wpdb;
//    $c = get_option('spark_search_user_copy_right');
        $c = 5;
        $m = 0;
        while ($c > 0) {
            //需要更改匹配线上服务器
            $time = $wpdb->get_results("SELECT action_post_id ,action_time FROM `wp_user_history` WHERE `user_id` ='$id[$m]' and `action_post_type`!='page' and `action_post_id`!='0'");
            $n = 0;
            foreach ($time as $a) {
                $idlist[$m][$n] = $a->action_post_id;
                $historytime[$m][$n] = $a->action_time;
                $n++;
            }
            $m++;
            $c--;
        }
        $a = 5;
        $m = 0;
        $num = count($historytime,1);
        while ($a > 0) {
            $c = $num;
            $nn = 0;
            while ($c > 0) {
                $timegeshi_action[$m][$nn] = (int)substr($historytime[$m][$nn], 0, 4) . substr($historytime[$m][$nn], 5, 2) . substr($historytime[$m][$nn], 8, 2);
                $nn++;
                $c--;
            }
            $m++;
            $a--;
        }
        $a = 5;$m = 0;$idnum1 = 0;$idnum2 = 0;$idnum3 = 0;$idnum4 = 0;$idnum5 = 0;$idnum6 = 0;$idnum7 = 0;
        $idview1 = array();$idview2 = array();$idview3 = array();$idview4 = array();$idview5 = array();$idview6 = array();$idview7 = array();
        while ($a > 0) {
            $c = $num;
            $n = 0;
            while ($c > 0) {
                if ($timegeshi1 == $timegeshi_action[$m][$n]) {
                    $idview1[$idnum1] = $idlist[$m][$n];
                    $idnum1++;
                } else if ($timegeshi2 == $timegeshi_action[$m][$n]) {
                    $idview2[$idnum2] = $idlist[$m][$n];
                    $idnum2++;
                } else if ($timegeshi3 == $timegeshi_action[$m][$n]) {
                    $idview3[$idnum3] = $idlist[$m][$n];
                    $idnum3++;
                } else if ($timegeshi4 == $timegeshi_action[$m][$n]) {
                    $idview4[$idnum4] = $idlist[$m][$n];
                    $idnum4++;
                } else if ($timegeshi5 == $timegeshi_action[$m][$n]) {
                    $idview5[$idnum5] = $idlist[$m][$n];
                    $idnum5++;
                } else if ($timegeshi6 == $timegeshi_action[$m][$n]) {
                    $idview6[$idnum6] = $idlist[$m][$n];
                    $idnum6++;
                } else if ($timegeshi7 == $timegeshi_action[$m][$n]) {
                    $idview7[$idnum7] = $idlist[$m][$n];
                    $idnum7++;
                }
                $n++;
                $c--;
            }
            $m++;
            $a--;
        }
        $idview1=array_count_values ($idview1);$idview2=array_count_values ($idview2);$idview3=array_count_values ($idview3);$idview4=array_count_values ($idview4);
        $idview5=array_count_values ($idview5);$idview6=array_count_values ($idview6);$idview7=array_count_values ($idview7);
        arsort($idview1);arsort($idview2);arsort($idview3);arsort($idview4);arsort($idview5);arsort($idview6);arsort($idview7);
        $idview_val1=array_values($idview1);$idview_val2=array_values($idview2);$idview_val3=array_values($idview3);$idview_val4=array_values($idview4);
        $idview_val5=array_values($idview5);$idview_val6=array_values($idview6);$idview_val7=array_values($idview7);
        $idmax1=$idview_val1[0];$idmax2=$idview_val2[0];$idmax3=$idview_val3[0];$idmax4=$idview_val4[0];$idmax5=$idview_val5[0];$idmax6=$idview_val6[0];$idmax7=$idview_val7[0];
        $idview_key1=array_keys($idview1);$idview_key2=array_keys($idview2);$idview_key3=array_keys($idview3);$idview_key4=array_keys($idview4);
        $idview_key5=array_keys($idview5);$idview_key6=array_keys($idview6);$idview_key7=array_keys($idview7);
        $id1=$idview_key1[0];$id2=$idview_key2[0];$id3=$idview_key3[0];$id4=$idview_key4[0];$id5=$idview_key5[0];$id6=$idview_key6[0];$id7=$idview_key7[0];
        //需要更改匹配线上服务器
        $idname1=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id1'");
        $idname2=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id2'");
        $idname3=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id3'");
        $idname4=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id4'");
        $idname5=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id5'");
        $idname6=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id6'");
        $idname7=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id7'");
        $resulttime="$idmax1 $idmax2 $idmax3 $idmax4 $idmax5 $idmax6 $idmax7 $idname1 $idname2 $idname3 $idname4 $idname5 $idname6 $idname7";

        echo $resulttime;
    }
    else {
        global $wpdb;
        //需要更改匹配线上服务器
            $time = $wpdb->get_results("SELECT action_post_id ,action_time FROM `wp_user_history` where `action_post_type`!='page' and `action_post_id`!='0' ");
            $n = 0;
            foreach ($time as $time_a) {
                $idlist[$n] = $time_a->action_post_id;
                $historytime[$n] = $time_a->action_time;
                $n++;
            }
        $num = count($historytime);
            $c = $num;
            $nn = 0;

            while ($c > 0) {
                $timegeshi_action[$nn] = (int)substr($historytime[$nn], 0, 4) . substr($historytime[$nn], 5, 2) . substr($historytime[$nn], 8, 2);
                $nn++;
                $c--;
            }
        $idnum1 = 0;$idnum2 = 0;$idnum3 = 0;$idnum4 = 0;$idnum5 = 0;$idnum6 = 0;$idnum7 = 0;
        $n=0;$c=$num;
        $idview1 = array();$idview2 = array();$idview3 = array();$idview4 = array();$idview5 = array();$idview6 = array();$idview7 = array();
            while ($c > 0) {
                if ($timegeshi1 == $timegeshi_action[$n]) {
                    $idview1[$idnum1] = $idlist[$n];
                    $idnum1++;
                } else if ($timegeshi2 == $timegeshi_action[$n]) {
                    $idview2[$idnum2] = $idlist[$n];
                    $idnum2++;
                } else if ($timegeshi3 == $timegeshi_action[$n]) {
                    $idview3[$idnum3] = $idlist[$n];
                    $idnum3++;
                } else if ($timegeshi4 == $timegeshi_action[$n]) {
                    $idview4[$idnum4] = $idlist[$n];
                    $idnum4++;
                } else if ($timegeshi5 == $timegeshi_action[$n]) {
                    $idview5[$idnum5] = $idlist[$n];
                    $idnum5++;
                } else if ($timegeshi6 == $timegeshi_action[$n]) {
                    $idview6[$idnum6] = $idlist[$n];
                    $idnum6++;
                } else if ($timegeshi7 == $timegeshi_action[$n]) {
                    $idview7[$idnum7] = $idlist[$n];
                    $idnum7++;
                }
                $n++;
                $c--;
            }
        $idview1=array_count_values ($idview1);$idview2=array_count_values ($idview2);$idview3=array_count_values ($idview3);$idview4=array_count_values ($idview4);
        $idview5=array_count_values ($idview5);$idview6=array_count_values ($idview6);$idview7=array_count_values ($idview7);
        arsort($idview1);arsort($idview2);arsort($idview3);arsort($idview4);arsort($idview5);arsort($idview6);arsort($idview7);
        $idview_val1=array_values($idview1);$idview_val2=array_values($idview2);$idview_val3=array_values($idview3);$idview_val4=array_values($idview4);
        $idview_val5=array_values($idview5);$idview_val6=array_values($idview6);$idview_val7=array_values($idview7);
        $idmax1=$idview_val1[0];$idmax2=$idview_val2[0];$idmax3=$idview_val3[0];$idmax4=$idview_val4[0];$idmax5=$idview_val5[0];$idmax6=$idview_val6[0];$idmax7=$idview_val7[0];
        $idview_key1=array_keys($idview1);$idview_key2=array_keys($idview2);$idview_key3=array_keys($idview3);$idview_key4=array_keys($idview4);
        $idview_key5=array_keys($idview5);$idview_key6=array_keys($idview6);$idview_key7=array_keys($idview7);
        $id1=$idview_key1[0];$id2=$idview_key2[0];$id3=$idview_key3[0];$id4=$idview_key4[0];$id5=$idview_key5[0];$id6=$idview_key6[0];$id7=$idview_key7[0];
        //需要更改匹配线上服务器
        $idname1=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id1'");
        $idname2=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id2'");
        $idname3=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id3'");
        $idname4=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id4'");
        $idname5=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id5'");
        $idname6=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id6'");
        $idname7=$wpdb->get_var("SELECT post_title FROM `wp_posts` where ID='$id7'");
        $resulttime="$idmax1 $idmax2 $idmax3 $idmax4 $idmax5 $idmax6 $idmax7 $idname1 $idname2 $idname3 $idname4 $idname5 $idname6 $idname7";

        echo $resulttime;
    }

}
function spark_settings_submenu_page3(){

//    $vusername=explode(",",active_p());
//    $vusername0=$vusername[0];
//    $vusername1=$vusername[1];
//    $vusername2=$vusername[2];
//    $cusername=explode(",",create());
//    $cusername0=$cusername[0];
//    $cusername1=$cusername[1];
//    $cusername2=$cusername[2];
//    $qusername=explode(",",question());
//    $qusername0=$qusername[0];
//    $qusername1=$qusername[1];
//    $qusername2=$qusername[2];
//    $ausername=explode(",",answer());
//    $ausername0=$ausername[0];
//    $ausername1=$ausername[1];
//    $ausername2=$ausername[2];
//    $vusername=explode(",",active_before());
//    $vusername3=$vusername[0];
//    $vusername4=$vusername[1];
//    $vusername5=$vusername[2];
//    $cusername=explode(",",create_before());
//    $cusername3=$cusername[0];
//    $cusername4=$cusername[1];
//    $cusername5=$cusername[2];
//    $qusername=explode(",",question_before());
//    $qusername3=$qusername[0];
//    $qusername4=$qusername[1];
//    $qusername5=$qusername[2];
//    $ausername=explode(",",answer_before());
//    $ausername3=$ausername[0];
//    $ausername4=$ausername[1];
//    $ausername5=$ausername[2];

?>
    <!DOCTYPE html>
    <html >
   <head>
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>用户统计</title>

     </head>
   <body style=" background-color: #f1f2f7; ">

   <div class="container">
       <p style="font-size: 18px;    margin: 8px;">系统统计</p>
       <div class="row">
           <div class="col-md-6" style="background-color: white;width: 47%">
               <p style="margin-top: 20px; margin-left: 10px;">全网活跃统计(有待开发)</p>
               <table class="table ">
                   <tr>
                       <th>总计</th>
<!--                       <th>浏览</th>-->
                       <th>创建编辑</th>
                       <th>提问</th>
                       <th>回答</th>
                   </tr>
                   <tr>
                       <td>第一名</td>
<!--                       <td>--><?php //echo $vusername0?><!--</td>-->
<!--                       <td>--><?php //echo $cusername0?><!--</td>-->
<!--                       <td>--><?php //echo $qusername0?><!--</td>-->
<!--                       <td>--><?php //echo $ausername0?><!--</td>-->
                       <td>spark_admin</td>
                       <td>spark_admin</td>
                       <td>spark_admin</td>
                   </tr>
                   <tr>
                       <td>第二名</td>
<!--                       <td>--><?php //echo $vusername1?><!--</td>-->
<!--                       <td>--><?php //echo $cusername1?><!--</td>-->
<!--                       <td>--><?php //echo $qusername1?><!--</td>-->
<!--                       <td>--><?php //echo $ausername1?><!--</td>-->
                       <td>Test1</td>
                       <td>Test1</td>
                       <td>Test1</td>
                   </tr>
                   <tr>
                       <td>第三名</td>
<!--                       <td>--><?php //echo $vusername2?><!--</td>-->
<!--                       <td>--><?php //echo $cusername2?><!--</td>-->
<!--                       <td>--><?php //echo $qusername2?><!--</td>-->
<!--                       <td>--><?php //echo $ausername2?><!--</td>-->
                       <td>Cherie</td>
                       <td>Cherie</td>
                       <td>Cherie</td>
                   </tr>
               </table>
               </div>
           <div class="col-md-6" style="background-color: white;width: 47%">
               <p style="margin-top: 20px; margin-left: 10px;">近期三天活跃统计(有待开发)</p>
               <table class="table ">
                   <tr>
                       <th>总计</th>
                       <th>浏览</th>
                       <th>创建编辑</th>
                       <th>提问</th>
                       <th>回答</th>
                   </tr>
                   <tr>
                       <td>第一名</td>
<!--                       <td>--><?php //echo $vusername3?><!--</td>-->
<!--                       <td>--><?php //echo $cusername3?><!--</td>-->
<!--                       <td>--><?php //echo $qusername3?><!--</td>-->
<!--                       <td>--><?php //echo $ausername3?><!--</td>-->
                       <td>zyl</td>
                       <td>zyl</td>
                       <td>zyl</td>
                       <td>zyl</td>
                   </tr>
                   <tr>
                       <td>第二名</td>
<!--                       <td>--><?php //echo $vusername4?><!--</td>-->
<!--                       <td>--><?php //echo $cusername4?><!--</td>-->
<!--                       <td>--><?php //echo $qusername4?><!--</td>-->
<!--                       <td>--><?php //echo $ausername4?><!--</td>-->
                       <td>YANSHUAI</td>
                       <td>YANSHUAI</td>
                       <td>YANSHUAI</td>
                       <td>YANSHUAI</td>
                   </tr>
                   <tr>
                       <td>第三名</td>
<!--                       <td>--><?php //echo $vusername5?><!--</td>-->
<!--                       <td>--><?php //echo $cusername5?><!--</td>-->
<!--                       <td>--><?php //echo $qusername5?><!--</td>-->
<!--                       <td>--><?php //echo $ausername5?><!--</td>-->
                       <td>haoyi</td>
                       <td>haoyi</td>
                       <td>haoyi</td>
                       <td>haoyi</td>

                   </tr>
               </table>
           </div>
           </div>
       <div class="row">
           <label for="start2">起始日期：</label><input id="start2" name="start2" type="date" />
           <label for="id">用户id：</label><input id="number" name="text" multiple="multiple"type="text" />
           <label>可以输入五位用户的id,之间用逗号隔开；若不输入则默认全网用户</label>
           <div id="viewInfo">请输入起始日期和用户id,查询用户七天的浏览量变化</div>
           <button id="button">查询</button><p id="button1"></p>
           <div id="container_view" style="min-width:400px;height:400px;"></div>
       </div>
       </div>

   </body>
   </html>
<?php
}
