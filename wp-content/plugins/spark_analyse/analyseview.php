<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/18
 * Time: 20:52
 */

wp_register_style('fep-style', plugins_url('bootstrap.min.css', __FILE__), array(), '1.6', 'all');
wp_register_style('datepicker-style', plugins_url('dateRange.css', __FILE__), array(), '1.6', 'all');
wp_register_style('main-style', plugins_url('main.css', __FILE__), array(), '1.0', 'all');
wp_register_style('table-style', plugins_url('table.css', __FILE__), array(), '1.6', 'all');
wp_register_style('user-style', plugins_url('user.css', __FILE__), array(), '1.6', 'all');
wp_register_style('tag-style', plugins_url('tagcloud.css', __FILE__), array(), '1.6', 'all');
wp_register_script("jquery-script", plugins_url('js/jquery-3.2.1.js', __FILE__), array('jquery'));
wp_register_script("date-script", plugins_url('js/dateRange.js', __FILE__), array('jquery'));
wp_register_script("tag-script", plugins_url('js/tagcloud.min.js', __FILE__), array('jquery'));
wp_register_script("ui-script", plugins_url('js/jquery-ui.js', __FILE__), array('jquery'));
wp_register_script("time-script", plugins_url('js/active.js', __FILE__), array('jquery'));
wp_register_script("fep-script", plugins_url('js/bootstrap.min.js', __FILE__), array('jquery'));
wp_register_script("collapse-script", plugins_url('js/collapse.js', __FILE__), array('jquery'));
wp_register_script("high-script", plugins_url('js/highcharts.js', __FILE__), array('jquery'));
wp_register_script("highm-script", plugins_url('js/highcharts-more.js', __FILE__), array('jquery'));
//wp_register_script("increment-script", plugins_url('js/user_increment.js', __FILE__),array('jquery'));
wp_register_script("transition-script", plugins_url('js/transition.js', __FILE__), array('jquery'));
if ( is_admin() ) {
    wp_enqueue_script("jquery-script");
    wp_enqueue_script("fep-script");

    wp_enqueue_script("tag-script");
    wp_enqueue_script("time-script");
    wp_enqueue_script("high-script");
    wp_enqueue_script("transition-script");
    wp_enqueue_script("highm-script");
//    wp_enqueue_script("increment-script");
    wp_enqueue_script("collapse-script");
    wp_enqueue_script("date-script");
    wp_enqueue_script("ui-script");

    wp_enqueue_style('fep-style');
    wp_enqueue_style('datepicker-style');
    wp_enqueue_style('main-style');
    wp_enqueue_style('table-style');
    wp_enqueue_style('user-style');
    wp_enqueue_style('tag-style');
}
if ( ! function_exists( 'model' ) ) {
    require_once('model_drawing.php');
}
if ( ! function_exists( 'timechart' ) ) {
    require_once('timechart.php');
}

//require_once('active.php');
global $time,$time1,$time2,$time3,$time4,$time5,$time6,$time7;
$time=explode(" ",timechart());
$time1=$time[0];
$time2=$time[1];
$time3=$time[2];
$time4=$time[3];
$time5=$time[4];
$time6=$time[5];
$time7=$time[6];
$vtime=explode(" ",wikiviewtimechart());
$vtime1=$vtime[0];
$vtime2=$vtime[1];
$vtime3=$vtime[2];
$vtime4=$vtime[3];
$vtime5=$vtime[4];
$vtime6=$vtime[5];
$vtime7=$vtime[6];
$qtime=explode(" ",questiontimechart());
$qtime1=$qtime[0];
$qtime2=$qtime[1];
$qtime3=$qtime[2];
$qtime4=$qtime[3];
$qtime5=$qtime[4];
$qtime6=$qtime[5];
$qtime7=$qtime[6];
$atime=explode(" ",answertimechart());
$atime1=$atime[0];
$atime2=$atime[1];
$atime3=$atime[2];
$atime4=$atime[3];
$atime5=$atime[4];
$atime6=$atime[5];
$atime7=$atime[6];
require 'infer.php';
add_action('wp_ajax_time_action', 'time_check');
function time_check()
{
    $time1 = isset($_POST['start']) ? $_POST['start'] : null;
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
    global $wpdb;
    $c = get_option('spark_search_user_copy_right');
    $sql = $wpdb->get_var("SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $acttime = $wpdb->get_results("SELECT action_time FROM `wp_user_history` WHERE `user_id` = '$sql'");
    $artnum = $wpdb->get_var("SELECT COUNT(*) FROM `wp_user_history` WHERE `user_id` = '$sql'");
    $m = 0;
    foreach ($acttime as $a) {
        $textlist[$m] = $a->action_time;
        $textlist1[$m] = substr($textlist[$m], 0, 10);
        $m++;
    }
    $m=0;
    $result = array(0, 0, 0, 0, 0, 0, 0);
    for ($i = 0; $i < $artnum; $i++) {

    if ($time1 == $textlist1[$i])
        $result[0]++;
    else if ($time2 == $textlist1[$i])
        $result[1]++;
    else if ($time3 == $textlist1[$i])
        $result[2]++;
    else if ($time4 == $textlist1[$i])
        $result[3]++;
    else if ($time5 == $textlist1[$i])
        $result[4]++;
    else if ($time6 == $textlist1[$i])
        $result[5]++;
    else if ($time7 == $textlist1[$i])
        $result[6]++;
    }

    $resulttime="$result[0] $result[1] $result[2] $result[3] $result[4] $result[5] $result[6]";

    echo $resulttime;

   // die();
}

function spark_settings_submenu_page()
{
    global $time1;
    $tag=tag();
//    $a=history();
    global $his;
    ?>
    <!DOCTYPE html>
    <html >
   <head>
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>用户画像</title>
<!--        <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">-->
<!--        <link rel="stylesheet" href="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">-->
<!--        <script src="https://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>-->
<!--        <script src="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<!--        <link rel="stylesheet" type="text/css" href="--><?php //echo plugins_url('miaov_style.css')?><!--" />-->
<!--       <script type="text/javascript" src="--><?php //echo site_url('wp-content/plugins/spark_analyse/miaov.js')?><!--"></script>-->
       <script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
<!---->

       <script type="text/javascript">
//           window.onload = function() {

$(function () {

    tagcloud({
        //参数名: 默认值
        fontsize: 18,       //基本字体大小
        radius: 100,         //滚动半径
        mspeed: "normal",   //滚动最大速度
        ispeed: "normal",   //滚动初速度
        direction: 135,     //初始滚动方向
        keep: true          //鼠标移出组件后是否继续随鼠标滚动
    });
//
               var chart = new Highcharts.Chart('container', {
                   title: {
                       text: '项目编辑评论时间分布图',
                       x: -20
                   },
                   credits: {
                       enabled: false
                   },
                   xAxis: {
                       categories: ['00-08', '08-11', '11-14', '14-17', '17-20', '20-22', '22-24']
                   },
                   yAxis: {
                       title: {
                           text: '次数'
                       },
                       plotLines: [{
                           value: 0,
                           width: 1,
                           color: '#808080'
                       }]
                   },
                   tooltip: {

                   },
                   legend: {
                       layout: 'vertical',
                       align: 'right',
                       verticalAlign: 'middle',
                       borderWidth: 0
                   },
                   series: [{
                       name: '编辑时间分布',
                       data: [<?php time1()?>, <?php time2()?>, <?php time3()?>, <?php time4()?>, <?php time5()?>, <?php time6()?>, <?php time7()?>]
                   }, {
                       name: '评论时间分布',
                       data: [<?php vtime1()?>, <?php vtime2()?>, <?php vtime3()?>, <?php vtime4()?>, <?php vtime5()?>, <?php vtime6()?>, <?php vtime7()?>]
                   }]
               });
               var chart1 = new Highcharts.Chart('container1', {
                   title: {
                       text: '问答时间分布图',
                       x: -20
                   },
                   credits: {
                       enabled: false
                   },
                   xAxis: {
                       categories: ['00-08', '08-11', '11-14', '14-17', '17-20', '20-22', '22-24']
                   },
                   yAxis: {
                       title: {
                           text: '次数'
                       },
                       plotLines: [{
                           value: 0,
                           width: 1,
                           color: '#808080'
                       }]
                   },
                   tooltip: {

                   },
                   legend: {
                       layout: 'vertical',
                       align: 'right',
                       verticalAlign: 'middle',
                       borderWidth: 0
                   },
                   series: [{
                       name: '提问时间分布',
                       data: [<?php qtime1()?>, <?php qtime2()?>, <?php qtime3()?>, <?php qtime4()?>, <?php qtime5()?>, <?php qtime6()?>, <?php qtime7()?>]
                   }, {
                       name: '回答时间分布',
                       data: [<?php atime1()?>, <?php atime2()?>, <?php atime3()?>, <?php atime4()?>, <?php atime5()?>, <?php atime6()?>, <?php atime7()?>]
                   }]

               });
//    var chart2 = new Highcharts.Chart('container2', {
//        title: {
//            text: '一周用户活跃度变化图',
//            x: -20
//        },
//        credits: {
//            enabled: false
//        },
//        yAxis: {
//            title: {
//                text: '次数'
//            },
//            plotLines: [{
//                value: 0,
//                width: 1,
//                color: '#808080'
//            }]
//        },
//        tooltip: {
//
//        },
//        legend: {
//            layout: 'vertical',
//            align: 'right',
//            verticalAlign: 'middle',
//            borderWidth: 0
//        },
//        data: {
//            table: 'datatable'
//        },
//    });







               oDiv = document.getElementById('mokuai');

               aA = oDiv.getElementsByTagName('a');


               for (i = 0; i < aA.length; i++) {
                   oTag = {};

                   oTag.offsetWidth = aA[i].offsetWidth;
                   oTag.offsetHeight = aA[i].offsetHeight;

                   mcList.push(oTag);
               }

               sineCosine(0, 0, 0);

               positionAll();

               oDiv.onmouseover = function () {
                   active = true;
               };

               oDiv.onmouseout = function () {
                   active = false;
               };

               oDiv.onmousemove = function (ev) {
                   var oEvent = window.event || ev;

                   mouseX = oEvent.clientX - (oDiv.offsetLeft + oDiv.offsetWidth / 2);
                   mouseY = oEvent.clientY - (oDiv.offsetTop + oDiv.offsetHeight / 2);

                   mouseX /= 5;
                   mouseY /= 5;
               }

               setInterval(update, 30);
           })







           var radius = 90;
           var dtr = Math.PI/180;
           var d=300;

           var mcList = [];
           var active = false;
           var lasta = 1;
           var lastb = 1;
           var distr = true;
           var tspeed=10;
           var size=250;

           var mouseX=0;
           var mouseY=0;

           var howElliptical=1;

           var aA=null;
           var oDiv=null;



           function update()
           {
               var a;
               var b;

               if(active)
               {
                   a = (-Math.min( Math.max( -mouseY, -size ), size ) / radius ) * tspeed;
                   b = (Math.min( Math.max( -mouseX, -size ), size ) / radius ) * tspeed;
               }
               else
               {
                   a = lasta * 0.98;
                   b = lastb * 0.98;
               }

               lasta=a;
               lastb=b;

               if(Math.abs(a)<=0.01 && Math.abs(b)<=0.01)
               {
                   return;
               }

               var c=0;
               sineCosine(a,b,c);
               for(var j=0;j<mcList.length;j++)
               {
                   var rx1=mcList[j].cx;
                   var ry1=mcList[j].cy*ca+mcList[j].cz*(-sa);
                   var rz1=mcList[j].cy*sa+mcList[j].cz*ca;

                   var rx2=rx1*cb+rz1*sb;
                   var ry2=ry1;
                   var rz2=rx1*(-sb)+rz1*cb;

                   var rx3=rx2*cc+ry2*(-sc);
                   var ry3=rx2*sc+ry2*cc;
                   var rz3=rz2;

                   mcList[j].cx=rx3;
                   mcList[j].cy=ry3;
                   mcList[j].cz=rz3;

                   per=d/(d+rz3);

                   mcList[j].x=(howElliptical*rx3*per)-(howElliptical*2);
                   mcList[j].y=ry3*per;
                   mcList[j].scale=per;
                   mcList[j].alpha=per;

                   mcList[j].alpha=(mcList[j].alpha-0.6)*(10/6);
               }

               doPosition();
               depthSort();
           }

           function depthSort()
           {
               var i=0;
               var aTmp=[];

               for(i=0;i<aA.length;i++)
               {
                   aTmp.push(aA[i]);
               }

               aTmp.sort
               (
                   function (vItem1, vItem2)
                   {
                       if(vItem1.cz>vItem2.cz)
                       {
                           return -1;
                       }
                       else if(vItem1.cz<vItem2.cz)
                       {
                           return 1;
                       }
                       else
                       {
                           return 0;
                       }
                   }
               );

               for(i=0;i<aTmp.length;i++)
               {
                   aTmp[i].style.zIndex=i;
               }
           }

           function positionAll()
           {
               var phi=0;
               var theta=0;
               var max=mcList.length;
               var i=0;

               var aTmp=[];
               var oFragment=document.createDocumentFragment();

               //随机排序
               for(i=0;i<aA.length;i++)
               {
                   aTmp.push(aA[i]);
               }

               aTmp.sort
               (
                   function ()
                   {
                       return Math.random()<0.5?1:-1;
                   }
               );

               for(i=0;i<aTmp.length;i++)
               {
                   oFragment.appendChild(aTmp[i]);
               }

               oDiv.appendChild(oFragment);

               for( var i=1; i<max+1; i++){
                   if( distr )
                   {
                       phi = Math.acos(-1+(2*i-1)/max);
                       theta = Math.sqrt(max*Math.PI)*phi;
                   }
                   else
                   {
                       phi = Math.random()*(Math.PI);
                       theta = Math.random()*(2*Math.PI);
                   }
                   //坐标变换
                   mcList[i-1].cx = radius * Math.cos(theta)*Math.sin(phi);
                   mcList[i-1].cy = radius * Math.sin(theta)*Math.sin(phi);
                   mcList[i-1].cz = radius * Math.cos(phi);

                   aA[i-1].style.left=mcList[i-1].cx+oDiv.offsetWidth/2-mcList[i-1].offsetWidth/2+'px';
                   aA[i-1].style.top=mcList[i-1].cy+oDiv.offsetHeight/2-mcList[i-1].offsetHeight/2+'px';
               }
           }

           function doPosition()
           {
               var l=oDiv.offsetWidth/2;
               var t=oDiv.offsetHeight/2;
               for(var i=0;i<mcList.length;i++)
               {
                   aA[i].style.left=mcList[i].cx+l-mcList[i].offsetWidth/2+'px';
                   aA[i].style.top=mcList[i].cy+t-mcList[i].offsetHeight/2+'px';

                   aA[i].style.fontSize=Math.ceil(12*mcList[i].scale/2)+8+'px';

                   aA[i].style.filter="alpha(opacity="+100*mcList[i].alpha+")";
                   aA[i].style.opacity=mcList[i].alpha;
               }
           }

           function sineCosine( a, b, c)
           {
               sa = Math.sin(a * dtr);
               ca = Math.cos(a * dtr);
               sb = Math.sin(b * dtr);
               cb = Math.cos(b * dtr);
               sc = Math.sin(c * dtr);
               cc = Math.cos(c * dtr);
           }

       </script>
    </head>

    <STYLE TYPE="text/css">
        body {background:blue;}
        #mokuai {position: absolute;height: 217px;left: 626px;top: 104px;}
        #mokuai a {position:absolute; top:0px; left:0px; font-family: Microsoft YaHei; color:#fff; font-weight:bold; text-decoration:none; padding: 3px 6px; }
        #mokuai a:hover {border: 1px solid #eee; background: #000; }
        #mokuai .blue {color:blue;}
        #mokuai .red {color:red;}
        #mokuai .yellow {color:yellow;}
        #mokuai1 .blue {color:blue;}
        #mokuai1 .red {color:red;}
        #mokuai1 .yellow {color:yellow;}
        #mokuai2 .blue {color:blue;}
        #mokuai2 .red {color:red;}
        #mokuai2 .yellow {color:yellow;}
        /*canvas {border:1px solid #4c4c4c;}*/
        p { font: 18px Microsoft YaHei; color: black; }
        p a { font-size: 14px; color: #ba0c0c; }
        p a:hover { color: red; }
        table {
            border-collapse: collapse;
            width:500px;
            height:300px;
        }
        table, td, th {
            border: 1px solid black;
            text-align:center;
            padding:50px;
        }

      /*  .grid-container{

            width: 100%;
            max-width: 1200px;
        }


        .row:before,
        .row:after {
            content:"";
            display: table ;
            clear:both;
        }

        [class*='col-'] {
            float: left;
            min-height: 1px;
            width: 16.66%;

            padding: 12px;
            background-color: white;
        }

        .col-3{ width: 45%;    }
*/




    </STYLE>

    <body style=" background-color: #f1f2f7; ">

      <div class="container">
          <p style="font-size: 18px;    margin: 8px;">用户画像</p>
        <div class="row">
<!--            <div class="col-md-6" style="background-color: white;box-shadow:-->
<!--         inset 1px -1px 1px #444, inset -1px 1px 1px #444;">-->
            <div class="col-md-6" style="background-color: white;width: 47%">
                <div style="text-align:center;background-color:rgb(100,201,202);margin-top: 22px;width: 93px;height: 93px;margin-left: 40%;border-radius: 50%;border: solid 1px rgb(100,201,202)"><i class="fa fa-user fa-5x " style="color:white;"></i></div>
                <div ><p style="position:relative;text-align:center;font-size:40px;top:20px"><?php echo get_option('spark_search_user_copy_right') ?></p></div>
                <br/>
                <br/>
            </div>
            <div id="mokuai" class="col-md-6" style="background-color: white;margin-left: -30px;width: 47%">
                <p style="    margin-top: 20px;
    margin-left: 10px;">用户标签云</p>
               <a class="red"><?php good()?></a>
                <a class="red"><?php echo "擅长"?><?php $goodornot=goodornot();echo $goodornot[0];?></a>
                <a class="red"><?php echo "不擅长"?><?php echo $goodornot[1]?></a>
                <a class="yellow"><?php desire()?></a>
                <a class="yellow"><?php echo "喜欢"?><?php $desireornot=desireornot();echo $desireornot[0];?></a>
                <a class="yellow"><?php echo "不喜欢"?><?php echo $desireornot[1]?></a>
                <a class="blue"><?php level()?></a>
                <a class="blue"><?php year()?></a>


            </div>
        </div>
          <p style="font-size: 18px;    margin: 8px;">Wiki</p>
        <div class="row">

                    <div   class="col-md-6" style="background-color: white;width: 47%">
                        <div id="container" style="min-width:450px;height:400px"></div>
                    </div>

                        <div id="mokuai1" class="col-md-6" style="background-color: white;margin-left: 40px;width: 47%;">
                            <p >经常搜索内容</p>
                            <div class="tagcloud">
                                <a class="red"><?php echo $tag[0]?></a>
                                <a class="red"><?php echo $tag[1]?></a>
                                <a class="red"><?php echo $tag[2]?></a>
                                <a class="yellow"><?php echo $tag[3]?></a>
                                <a class="yellow"><?php echo $tag[4]?></a>
                                <a class="yellow"><?php echo $tag[5]?></a>
                                <a class="blue"><?php echo $tag[6]?></a>
                                <a class="blue"><?php echo $tag[7]?></a>
                                <a class="blue"><?php echo $tag[8]?></a>
                                <a class="blue"><?php echo $tag[9]?></a>
                            </div>


                        </div>


        </div>

        <div class="row" style="    margin-top: 15px;">
                    <div  class="col-md-6" style="background-color: white;width: 47%
               ">


                        <p style="    margin-top: 20px;
    margin-left: 10px;">项目编辑创建词条数量统计表</p>
                        <table class="table ">
                            <tr>
                                <th></th>
                                <th>周</th>
                                <th>月</th>
                                <th>总计</th>
                            </tr>
                            <tr>
                                <td>编辑次数</td>
                                <td><?php edittimezhou()?></td>
                                <td><?php edittimemonth()?></td>
                                <td><?php editsum()?></td>
                            </tr>
                            <tr>
                                <td>创建次数</td>
                                <td><?php publishtimezhou()?></td>
                                <td><?php publishtimemonth()?></td>
                                <td><?php publishsum()?></td>
<!--                                <td>--><?php //history()?><!--</td>-->
                            </tr>
                        </table>
                    </div>
                    <div  class="col-md-6" style="background-color: white;width: 47%;margin-left: 40px;">
                        <p style="    margin-top: 20px;
    margin-left: 10px;">项目内容质量统计</p>
                        <table class="table ">
                            <tr>
                                <th>创建词条浏览量</th>
                                <th>发表评论</th>
                            </tr>
                            <tr>
                                <td>最高浏览量：<?php  wikiviewmost()?></td>
                                <td>发表评论总数：<?php  commentpost()?></td>
                            </tr>
                            <tr>
                                <td>平均浏览量: <?php wikiviewaverage()?></td>
                                <td>接收到的评论数: <?php getcomment()?></td>
                            </tr>
                        </table>
                    </div>
        </div>
          <p    style="font-size: 18px;    margin: 8px;">问答</p>
      <div class="row">

          <div   class="col-md-6" style="background-color: white;width: 47%
               ">
              <div id="container1" style="min-width:400px;height:400px"></div>
          </div>

                  <div  class="col-md-6" style="background-color: white;margin-left: 40px;width: 47%">
                      <label for="start">起始日期：</label><input id="start" name="start" type="date" />
                       <div id="emailInfo">请输入起始日期,查询用户七天的活跃度变化</div>
                      <div id="container2" style="min-width:400px;height:400px;"></div>
                  </div>


          </div>
      <div class="row" style="    margin-top: 15px;">

          <div   class="col-md-6" style="background-color: white;width: 47%">
              <p style="    margin-top: 20px;
    margin-left: 10px;">问答数量统计表</p>
              <table class="table ">
                  <tr>
                      <th></th>
                      <th>周</th>
                      <th>月</th>
                      <th>总计</th>
                  </tr>
                  <tr>
                      <td>提问次数</td>
                      <td><?php questiontimezhou()?></td>
                      <td><?php questiontimemonth()?></td>
                      <td><?php questionsum()?></td>
                  </tr>
                  <tr>
                      <td>回答次数</td>
                      <td><?php answertimezhou()?></td>
                      <td><?php answertimemonth()?></td>
                      <td><?php answersum()?></td>
                  </tr>
              </table>
          </div>
          <div  class="col-md-6" style="background-color: white;width: 47%;margin-left: 40px;">

              <p style="    margin-top: 20px;
    margin-left: 10px;">问答质量统计</p>
              <table class="table ">
                  <tr>
                      <th>问题浏览量</th>
                      <th>回答统计</th>
                  </tr>
                  <tr>
                      <td>最高浏览量：<?php  questionviewmost()?></td>
                      <td>被采纳个数：<?php  getchoice()?></td>
                  </tr>
                  <tr>
                      <td>平均浏览量: <?php questionviewaverage()?></td>
                      <td>收获赞同数: <?php getzan()?> </td>
                  </tr>
              </table>
          </div>
      </div>

    </div>


    </body>
    </html>
    <?php

}
