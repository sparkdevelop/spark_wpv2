<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/13
 * Time: 20:09
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
wp_register_script("increment-script", plugins_url('js/user_increment.js', __FILE__),array('jquery'));
wp_register_script("transition-script", plugins_url('js/transition.js', __FILE__), array('jquery'));
wp_enqueue_script("jquery-script");
wp_enqueue_script("fep-script");

wp_enqueue_script("tag-script");
wp_enqueue_script("time-script");
wp_enqueue_script("high-script");
wp_enqueue_script("transition-script");
wp_enqueue_script("highm-script");
wp_enqueue_script("increment-script");
wp_enqueue_script("collapse-script");
wp_enqueue_script("date-script");
wp_enqueue_script("ui-script");

wp_enqueue_style('fep-style');
wp_enqueue_style('datepicker-style');
wp_enqueue_style('main-style');
wp_enqueue_style('table-style');
wp_enqueue_style('user-style');
wp_enqueue_style('tag-style');
require_once('model_drawing.php');
function spark_settings_submenu_page2(){
    $socre=explode(",",getinterest());
    $phpcount=$socre[0];
    $htmlcount=$socre[1];
    $jscount=$socre[2];
    $mycookiecount=$socre[3];
    $danpianjicount=$socre[4];
    $csscount=$socre[5];
    $sqlcount=$socre[6];
    $duinocount=$socre[7];
    $androidcount=$socre[8];
    $ioscount=$socre[9];
    $pingtaicount=$socre[10];
    $webcount=$socre[11];
    $matlabcount=$socre[12];
    $socredesire=explode(",",getdesire());
    $phpcountdesire=$socredesire[0];
    $htmlcountdesire=$socredesire[1];
    $jscountdesire=$socredesire[2];
    $mycookiecountdesire=$socredesire[3];
    $danpianjicountdesire=$socredesire[4];
    $csscountdesire=$socredesire[5];
    $sqlcountdesire=$socredesire[6];
    $duinocountdesire=$socredesire[7];
    $androidcountdesire=$socredesire[8];
    $ioscountdesire=$socredesire[9];
    $pingtaicountdesire=$socredesire[10];
    $webcountdesire=$socredesire[11];
    $matlabcountdesire=$socredesire[12];
    $c=get_option('spark_search_user_copy_right');
    $sql=0;
    global $wpdb;
    $sql =$wpdb->get_var( "SELECT COUNT(*) FROM wp_count WHERE `user` = '$c'");
    // echo $sql;
    if ($sql!=0){
        $wpdb->update( 'wp_count', array( 'phpcount' => $phpcount, 'htmlcount' => $htmlcount, 'jscount' => $jscount
        , 'mycookiecount' => $mycookiecount, 'danpianjicount' => $danpianjicount, 'csscount' => $csscount
        , 'sqlcount' => $sqlcount, 'duinocount' => $duinocount, 'androidcount' => $androidcount, 'ioscount' => $ioscount
        , 'pingtaicount' => $pingtaicount, 'webcount' => $webcount, 'matlabcount' => $matlabcount), array( 'user' => $c ));
    }
    else{
        $wpdb->insert('wp_count', array('user'=>$c, 'phpcount' => $phpcount, 'htmlcount' => $htmlcount, 'jscount' => $jscount
        , 'mycookiecount' => $mycookiecount, 'danpianjicount' => $danpianjicount, 'csscount' => $csscount
        , 'sqlcount' => $sqlcount, 'duinocount' => $duinocount, 'androidcount' => $androidcount, 'ioscount' => $ioscount
        , 'pingtaicount' => $pingtaicount, 'webcount' => $webcount, 'matlabcount' => $matlabcount));
    }
    $s=0;
    $s =$wpdb->get_var( "SELECT COUNT(*) FROM wp_countdesire WHERE `user` = '$c'");
    // echo $sql;
    if ($s!=0){
        $wpdb->update( 'wp_countdesire', array( 'phpcount' => $phpcountdesire, 'htmlcount' => $htmlcountdesire, 'jscount' => $jscountdesire
        , 'mycookiecount' => $mycookiecountdesire, 'danpianjicount' => $danpianjicountdesire, 'csscount' => $csscountdesire
        , 'sqlcount' => $sqlcountdesire, 'duinocount' => $duinocountdesire, 'androidcount' => $androidcountdesire, 'ioscount' => $ioscountdesire
        , 'pingtaicount' => $pingtaicountdesire, 'webcount' => $webcountdesire, 'matlabcount' => $matlabcountdesire), array( 'user' => $c ));
    }
    else{
        $wpdb->insert('wp_countdesire', array('user'=>$c, 'phpcount' => $phpcountdesire, 'htmlcount' => $htmlcountdesire, 'jscount' => $jscountdesire
        , 'mycookiecount' => $mycookiecountdesire, 'danpianjicount' => $danpianjicountdesire, 'csscount' => $csscountdesire
        , 'sqlcount' => $sqlcountdesire, 'duinocount' => $duinocountdesire, 'androidcount' => $androidcountdesire, 'ioscount' => $ioscountdesire
        , 'pingtaicount' => $pingtaicountdesire, 'webcount' => $webcountdesire, 'matlabcount' => $matlabcountdesire));
    }

    $phpaverage=$wpdb->get_var( "SELECT round(avg(phpcount),2) FROM wp_count ");
    $htmlaverage=$wpdb->get_var( "SELECT round(avg(htmlcount),2) FROM wp_count ");
    $jsaverage=$wpdb->get_var( "SELECT round(avg(jscount),2) FROM wp_count ");
    $mycookieaverage=$wpdb->get_var( "SELECT round(avg(mycookiecount),2) FROM wp_count ");
    $danpianjiaverage=$wpdb->get_var( "SELECT round(avg(danpianjicount),2) FROM wp_count ");
    $cssaverage=$wpdb->get_var( "SELECT round(avg(csscount),2) FROM wp_count ");
    $sqlaverage=$wpdb->get_var( "SELECT round(avg(sqlcount),2) FROM wp_count ");
    $duinoaverage=$wpdb->get_var( "SELECT round(avg(duinocount),2) FROM wp_count ");
    $androidaverage=$wpdb->get_var( "SELECT round(avg(androidcount),2) FROM wp_count ");
    $iosaverage=$wpdb->get_var( "SELECT round(avg(ioscount),2) FROM wp_count ");
    $pingtaiaverage=$wpdb->get_var( "SELECT round(avg(pingtaicount),2) FROM wp_count ");
    $webaverage=$wpdb->get_var( "SELECT round(avg(webcount),2) FROM wp_count ");
    $matlabaverage=$wpdb->get_var( "SELECT round(avg(matlabcount),2) FROM wp_count ");


    $phpdesireaverage=$wpdb->get_var( "SELECT round(avg(phpcount),2) FROM wp_countdesire ");
    $htmldesireaverage=$wpdb->get_var( "SELECT round(avg(htmlcount),2) FROM wp_countdesire ");
    $jsdesireaverage=$wpdb->get_var( "SELECT round(avg(jscount),2) FROM wp_countdesire ");
    $mycookiedesireaverage=$wpdb->get_var( "SELECT round(avg(mycookiecount),2) FROM wp_countdesire ");
    $danpianjidesireaverage=$wpdb->get_var( "SELECT round(avg(danpianjicount),2) FROM wp_countdesire ");
    $cssdesireaverage=$wpdb->get_var( "SELECT round(avg(csscount),2) FROM wp_countdesire ");
    $sqldesireaverage=$wpdb->get_var( "SELECT round(avg(sqlcount),2) FROM wp_countdesire ");
    $duinodesireaverage=$wpdb->get_var( "SELECT round(avg(duinocount),2) FROM wp_countdesire ");
    $androiddesireaverage=$wpdb->get_var( "SELECT round(avg(androidcount),2) FROM wp_countdesire ");
    $iosdesireaverage=$wpdb->get_var( "SELECT round(avg(ioscount),2) FROM wp_countdesire ");
    $pingtaidesireaverage=$wpdb->get_var( "SELECT round(avg(pingtaicount),2) FROM wp_countdesire ");
    $webdesireaverage=$wpdb->get_var( "SELECT round(avg(webcount),2) FROM wp_countdesire ");
    $matlabdesireaverage=$wpdb->get_var( "SELECT round(avg(matlabcount),2) FROM wp_countdesire ");
    $tag=tag();
    ?>
<html>
<head>
<script type="text/javascript">
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
        $('#containersc').highcharts({
            chart: {
                polar: true,
                type: 'line'
            },
            title: {
                text: '用户推测系统',
                x: -80
            },
            credits: {
                enabled: false
            },
            pane: {
                size: '80%'
            },
            xAxis: {
                categories: ['php', 'html', 'js', 'mycookie',
                    '单片机', 'css','sql','microduino','android','ios','平台','web','matlab'],
                tickmarkPlacement: 'on',
                lineWidth: 0
            },
            yAxis: {
                gridLineInterpolation: 'polygon',
                lineWidth: 0,
                min: 0
            },
            tooltip: {
                shared: true,
                pointFormat: '<span style="color:{series.color}">{series.name}: <b>${point.y:,.0f}</b><br/>'
            },
            legend: {
                align: 'right',
                verticalAlign: 'top',
                y: 70,
                layout: 'vertical'
            },
            series: [{
                name: '用户擅长方向',
                data: [ <?php echo $phpcount?>,<?php echo $htmlcount?>, <?php echo $jscount?>, <?php echo $mycookiecount ?>,<?php echo $danpianjicount ?>, <?php echo $csscount ?>,<?php echo $sqlcount ?>,<?php echo $duinocount ?>,<?php echo $androidcount ?>,<?php echo $ioscount ?>, <?php echo $pingtaicount ?>,<?php echo $webcount ?>,<?php echo $matlabcount ?>],
                pointPlacement: 'on',
            }, {
                name: '平均值',
                data: [ <?php echo $phpaverage?>,<?php echo $htmlaverage?>, <?php echo $jsaverage?>, <?php echo $mycookieaverage ?>,<?php echo $danpianjiaverage ?>, <?php echo $cssaverage ?>,<?php echo $sqlaverage ?>,<?php echo $duinoaverage ?>,<?php echo $androidaverage ?>,<?php echo $iosaverage ?>, <?php echo $pingtaiaverage ?>,<?php echo $webaverage ?>,<?php echo $matlabaverage ?>],
                pointPlacement: 'on',
            }]
        });

        $('#containerxq').highcharts({
            chart: {
                polar: true,
                type: 'line'
            },
            title: {
                text: '用户推测系统',
                x: -80
            },
            credits: {
                enabled: false
            },
            pane: {
                size: '80%'
            },
            xAxis: {
                categories: ['php', 'html', 'js', 'mycookie',
                    '单片机', 'css','sql','microduino','android','ios','web','平台','matlab'],
                tickmarkPlacement: 'on',
                lineWidth: 0
            },
            yAxis: {
                gridLineInterpolation: 'polygon',
                lineWidth: 0,
                min: 0
            },
            tooltip: {
                shared: true,
                pointFormat: '<span style="color:{series.color}">{series.name}: <b>${point.y:,.0f}</b><br/>'
            },
            legend: {
                align: 'right',
                verticalAlign: 'top',
                y: 70,
                layout: 'vertical'
            },
            series: [{
                name: '用户兴趣方向',
                data: [ <?php echo $phpcountdesire?>,<?php echo $htmlcountdesire?>, <?php echo $jscountdesire?>, <?php echo $mycookiecountdesire ?>,<?php echo $danpianjicountdesire ?>, <?php echo $csscountdesire ?>,<?php echo $sqlcountdesire ?>,<?php echo $duinocountdesire ?>,<?php echo $androidcountdesire ?>,<?php echo $ioscountdesire ?>, <?php echo $pingtaicountdesire ?>,<?php echo $webcountdesire ?>,<?php echo $matlabcountdesire ?>],
                pointPlacement: 'on'
            },{
                name: '平均值',
                data: [ <?php echo $phpdesireaverage?>,<?php echo $htmldesireaverage?>, <?php echo $jsdesireaverage?>, <?php echo $mycookiedesireaverage ?>,<?php echo $danpianjidesireaverage ?>, <?php echo $cssdesireaverage ?>,<?php echo $sqldesireaverage ?>,<?php echo $duinodesireaverage ?>,<?php echo $androiddesireaverage ?>,<?php echo $iosdesireaverage ?>, <?php echo $pingtaidesireaverage ?>,<?php echo $webdesireaverage ?>,<?php echo $matlabdesireaverage ?>],
                pointPlacement: 'on'
            }]
        });

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
    };

    setInterval(update, 30);
    });

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

<body  style=" background-color: #f1f2f7; ">
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
        <div id="mokuai" class="col-md-6" style="background-color: white;width: 47%">
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
    <div class="row">

        <div   class="col-md-6" style="background-color: white;width: 47%">
            <p>用户擅长</p>
        </div>

        <div  class="col-md-6" style="background-color: white;width: 47%;">
       <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

           用户兴趣</p>


        </div>


    </div>
    <div class="row">

        <div   class="col-md-6" style="background-color: white;width: 47%">
            <div id="containersc" style="min-width:400px;height:400px"></div>
        </div>

        <div  class="col-md-6" style="background-color: white;width: 47%;position: absolute;height: 400px;left: 626px;top: 362px;">
            <div   class="col-md-6" style="background-color: white;width: 47%
               ">
                <div id="containerxq" style="min-width:400px;height:400px"></div>
            </div>


        </div>


    </div>
    <div class="row" style="    margin-top: 15px;">
        <div  class="col-md-6" style="background-color: white;width: 47%
               ">


            <p style="    margin-top: 20px;
    margin-left: 10px;">用户擅长统计表</p>
            <table class="table">
                <tr>
                    <th>类目</th>
                    <th>评分</th>
                    <th>平均分</th>
                </tr>
                <tr>
                    <td>php</td>
                    <td><?php echo $phpcount?></td>
                    <td><?php echo $phpaverage?></td>
                </tr>
                <tr>
                    <td>html</td>
                    <td><?php echo $htmlcount?></td>
                    <td><?php echo $htmlaverage?></td>
                </tr>
                <tr>
                    <td>js</td>
                    <td><?php echo $jscount?></td>
                    <td><?php echo $jsaverage?></td>
                </tr>
                <tr>
                    <td>microduino</td>
                    <td><?php echo $duinocount ?></td>
                    <td><?php echo $duinoaverage?></td>
                </tr>
                <tr>
                    <td>平台</td>
                    <td><?php echo $pingtaicount ?></td>
                    <td><?php echo $pingtaiaverage?></td>
                </tr>
                <tr>
                    <td>mycookie</td>
                    <td><?php echo $mycookiecount ?></td>
                    <td><?php echo $mycookieaverage?></td>
                </tr>
                <tr>
                    <td>单片机</td>
                    <td><?php echo $danpianjicount ?></td>
                    <td><?php echo $danpianjiaverage?></td>
                </tr>
                <tr>
                    <td>css</td>
                    <td><?php echo $csscount ?></td>
                    <td><?php echo $cssaverage?></td>
                </tr>
                <tr>
                    <td>sql</td>
                    <td><?php echo $sqlcount ?></td>
                    <td><?php echo $sqlaverage?></td>
                </tr>
                <tr>
                    <td>ios</td>
                    <td><?php echo $ioscount ?></td>
                    <td><?php echo $iosaverage?></td>
                </tr>
                <tr>
                    <td>andriod</td>
                    <td><?php echo $androidcount ?></td>
                    <td><?php echo $androidaverage?></td>
                </tr>
                <tr>
                    <td>web</td>
                    <td><?php echo $webcount ?></td>
                    <td><?php echo $webaverage?></td>
                </tr>
                <tr>
                    <td>matlab</td>
                    <td><?php echo $matlabcount ?></td>
                    <td><?php echo $matlabaverage?></td>
                </tr>
            </table>
        </div>
        <div  class="col-md-6" style="background-color: white;width: 47%;margin-left: 40px;">
            <p style="    margin-top: 20px;
    margin-left: 10px;">用户兴趣统计表</p>
            <table class="table">
                <tr>
                    <th>类目</th>
                    <th>评分</th>
                    <th>平均分</th>
                </tr>
                <tr>
                    <td>php</td>
                    <td><?php echo $phpcountdesire?></td>
                    <td><?php echo $phpdesireaverage?></td>
                </tr>
                <tr>
                    <td>html</td>
                    <td><?php echo $htmlcountdesire?></td>
                    <td><?php echo $htmldesireaverage?></td>
                </tr>
                <tr>
                    <td>js</td>
                    <td><?php echo $jscountdesire?></td>
                    <td><?php echo $jsdesireaverage?></td>
                </tr>
                <tr>
                    <td>microduino</td>
                    <td><?php echo $duinocountdesire ?></td>
                    <td><?php echo $duinodesireaverage?></td>
                </tr>
                <tr>
                    <td>平台</td>
                    <td><?php echo $pingtaicountdesire ?></td>
                    <td><?php echo $pingtaidesireaverage?></td>
                </tr>
                <tr>
                    <td>mycookie</td>
                    <td><?php echo $mycookiecountdesire ?></td>
                    <td><?php echo $mycookiedesireaverage?></td>
                </tr>
                <tr>
                    <td>单片机</td>
                    <td><?php echo $danpianjicountdesire ?></td>
                    <td><?php echo $danpianjidesireaverage?></td>
                </tr>
                <tr>
                    <td>css</td>
                    <td><?php echo $csscountdesire ?></td>
                    <td><?php echo $cssdesireaverage?></td>
                </tr>
                <tr>
                    <td>sql</td>
                    <td><?php echo $sqlcountdesire ?></td>
                    <td><?php echo $sqldesireaverage?></td>
                </tr>
                <tr>
                    <td>ios</td>
                    <td><?php echo $ioscountdesire ?></td>
                    <td><?php echo $iosdesireaverage?></td>
                </tr>
                <tr>
                    <td>andriod</td>
                    <td><?php echo $androidcountdesire ?></td>
                    <td><?php echo $androiddesireaverage?></td>
                </tr>
                <tr>
                    <td>web</td>
                    <td><?php echo $webcountdesire ?></td>
                    <td><?php echo $webdesireaverage?></td>
                </tr>
                <tr>
                    <td>matlab</td>
                    <td><?php echo $matlabcountdesire ?></td>
                    <td><?php echo $matlabdesireaverage?></td>
                </tr>
            </table>
        </div>
    </div>





</body>

</html>
<?php
}
function getinterest(){
    global $wpdb;
    //编辑模块
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts`WHERE `post_author` = '$sql'and post_status='publish' and post_type='post'");
    $c = $articulnum;
    $textid=$wpdb->get_results("SELECT ID FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type='post'");
    $m=0;
    foreach($textid as $a){
        $textlist2[$m]=$a->ID;
        $m++;
    }
    $m=0;
    global $textlist3;
    global $articul;
    $articul=0;
    while($c>0)  //$c是该用户一共有多少条编辑次数
    {
        $articul.= $wpdb->get_var("SELECT post_content FROM `$wpdb->posts` WHERE `ID` ='$textlist2[$m]'");
        //echo $articultext;
        $m++;
        $c--;
    }
    $phpnum1=substr_count($articul,'php')+substr_count($articul,'PHP')+substr_count($articul,'Php');
    $htmlnum1=substr_count($articul,'html')+substr_count($articul,'HTML')+substr_count($articul,'Html');
    $jsnum1=substr_count($articul,'javascript')+substr_count($articul,'js')+substr_count($articul,'JS')+substr_count($articul,'JavaScript')+substr_count($articul,'Javascript');
    $mycookienum1=substr_count($articul,'mycookie')+substr_count($articul,'Mycookie');
    $danpianjinum1=substr_count($articul,'单片机');
    $cssnum1=substr_count($articul,'css')+substr_count($articul,'CSS');
    $sqlnum1=substr_count($articul,'mysql')+substr_count($articul,'数据库')+substr_count($articul,'Mysql')+substr_count($articul,'phpmyadmin')
        +substr_count($articul,'Phpmyadmin')+substr_count($articul,'phpMyAdmin')+substr_count($articul,'sql')+substr_count($articul,'SQL')
        +substr_count($articul,'access')+substr_count($articul,'Access')+substr_count($articul,'oracle')+substr_count($articul,'Oracle')+substr_count($articul,'MySQL');
    $duinonum1=substr_count($articul,'duino');
    $android1=substr_count($articul,'android')+substr_count($articul,'Android');
    $iosnum1=substr_count($articul,'IOS')+substr_count($articul,'ios');
    $pingtainum1=substr_count($articul,'开放平台')+substr_count($articul,'硬件平台')+substr_count($articul,'开发平台');
    $webnum1=substr_count($articul,'web')+substr_count($articul,'Web')+substr_count($articul,'前端')+substr_count($articul,'后端');
    $matlabnum1=substr_count($articul,'matlab')+substr_count($articul,'MATLAB')+substr_count($articul,'Matlab');

    //回答模块
    ////

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts`WHERE `post_author` = '$sql'and post_status='publish' and post_type='dwqa_answer'");
    $c = $articulnum;
    $textid=$wpdb->get_results("SELECT ID,post_parent FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type='dwqa_answer'");
    $m=0;
    foreach($textid as $a){
        $textlist2[$m]=$a->ID;
        $textlist3[$m]=$a->post_parent;
        $m++;
    }
    $m=0;
    global $textlist3;
    global $articul;
    $articul=0;
    while($c>0)  //$c是该用户一共有多少条编辑次数
    {
        $articul.= $wpdb->get_var("SELECT post_content FROM `$wpdb->posts` WHERE `ID` ='$textlist2[$m]'");
        $articul.= $wpdb->get_var("SELECT post_content FROM `$wpdb->posts` WHERE `ID` ='$textlist3[$m]'");
        //echo $articultext;
        $m++;
        $c--;
    }
    $phpnum2=substr_count($articul,'php')+substr_count($articul,'PHP')+substr_count($articul,'Php');
    $htmlnum2=substr_count($articul,'html')+substr_count($articul,'HTML')+substr_count($articul,'Html');
    $jsnum2=substr_count($articul,'javascript')+substr_count($articul,'js')+substr_count($articul,'JS')+substr_count($articul,'JavaScript')+substr_count($articul,'Javascript');
    $mycookienum2=substr_count($articul,'mycookie')+substr_count($articul,'Mycookie');
    $danpianjinum2=substr_count($articul,'单片机');
    $cssnum2=substr_count($articul,'css')+substr_count($articul,'CSS');
    $sqlnum2=substr_count($articul,'mysql')+substr_count($articul,'数据库')+substr_count($articul,'Mysql')+substr_count($articul,'phpmyadmin')
        +substr_count($articul,'Phpmyadmin')+substr_count($articul,'phpMyAdmin')+substr_count($articul,'sql')+substr_count($articul,'SQL')
        +substr_count($articul,'access')+substr_count($articul,'Access')+substr_count($articul,'oracle')+substr_count($articul,'Oracle')+substr_count($articul,'MySQL');
    $duinonum2=substr_count($articul,'duino');
    $android2=substr_count($articul,'android')+substr_count($articul,'Android');
    $iosnum2=substr_count($articul,'IOS')+substr_count($articul,'ios');
    $pingtainum2=substr_count($articul,'开放平台')+substr_count($articul,'硬件平台')+substr_count($articul,'开发平台');
    $webnum2=substr_count($articul,'web')+substr_count($articul,'Web')+substr_count($articul,'前端')+substr_count($articul,'后端');
    $matlabnum2=substr_count($articul,'matlab')+substr_count($articul,'MATLAB')+substr_count($articul,'Matlab');
    //计算加权值
    global $phpcount,$htmlcount,$jscount,$mycookiecount,$danpianjicount,$csscount,$sqlcount,$duinocount,$androidcount,
           $ioscount,$pingtaicount,$webcount;
    $phpcount=$phpnum1*0.3+$phpnum2;
    $htmlcount=$htmlnum1*0.3+$htmlnum2;
    $jscount=$jsnum1*0.3+$jsnum2;
    $mycookiecount=$mycookienum1*0.3+$mycookienum2;
    $danpianjicount=$danpianjinum1*0.3+$danpianjinum2;
    $csscount=$cssnum1*0.3+$cssnum2;
    $sqlcount=$sqlnum1*0.3+$sqlnum2;
    $duinocount=$duinonum1*0.3+$duinonum2;
    $androidcount=$android1*0.3+$android2;
    $ioscount=$iosnum1*0.3+$iosnum2;
    $pingtaicount=$pingtainum1*0.3+$pingtainum2;
    $webcount=$webnum1*0.3+$webnum2;
    $matlabcount=$matlabnum1*0.3+$matlabnum2;

    return $score="$phpcount,$htmlcount,$jscount,$mycookiecount,$danpianjicount,$csscount,$sqlcount,$duinocount,$androidcount,$ioscount,$pingtaicount,$webcount,$matlabcount";

}
function getdesire(){
    global $wpdb;
    //问题模块
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->posts`WHERE `post_author` = '$sql'and post_status='publish' and post_type='dwqa-question'");
    $c = $articulnum;

    $textid=$wpdb->get_results("SELECT ID FROM `$wpdb->posts` WHERE `post_author` = '$sql'and post_status='publish' and post_type='dwqa-question'");
    $m=0;
    foreach($textid as $a){
        $textlist2[$m]=$a->ID;
        $m++;
    }
    $m=0;
    global $textlist3;
    global $articul;
    $articul=0;
    while($c>0)  //$c是该用户一共有多少条编辑次数
    {
        $articul.= $wpdb->get_var("SELECT post_content FROM `$wpdb->posts` WHERE `ID` ='$textlist2[$m]'");
        //echo $articultext;
        $m++;
        $c--;
    }
    $phpnum1=substr_count($articul,'php')+substr_count($articul,'PHP')+substr_count($articul,'Php');
    $htmlnum1=substr_count($articul,'html')+substr_count($articul,'HTML')+substr_count($articul,'Html');
    $jsnum1=substr_count($articul,'javascript')+substr_count($articul,'js')+substr_count($articul,'JS')+substr_count($articul,'JavaScript')+substr_count($articul,'Javascript');
    $mycookienum1=substr_count($articul,'mycookie')+substr_count($articul,'Mycookie');
    $danpianjinum1=substr_count($articul,'单片机');
    $cssnum1=substr_count($articul,'css')+substr_count($articul,'CSS');
    $sqlnum1=substr_count($articul,'mysql')+substr_count($articul,'数据库')+substr_count($articul,'Mysql')+substr_count($articul,'phpmyadmin')
        +substr_count($articul,'Phpmyadmin')+substr_count($articul,'phpMyAdmin')+substr_count($articul,'sql')+substr_count($articul,'SQL')
        +substr_count($articul,'access')+substr_count($articul,'Access')+substr_count($articul,'oracle')+substr_count($articul,'Oracle')+substr_count($articul,'MySQL');
    $duinonum1=substr_count($articul,'duino');
    $android1=substr_count($articul,'android')+substr_count($articul,'Android');
    $iosnum1=substr_count($articul,'IOS')+substr_count($articul,'ios');
    $pingtainum1=substr_count($articul,'开放平台')+substr_count($articul,'硬件平台')+substr_count($articul,'开发平台');
    $webnum1=substr_count($articul,'web')+substr_count($articul,'Web')+substr_count($articul,'前端')+substr_count($articul,'后端');
    $matlabnum1=substr_count($articul,'matlab')+substr_count($articul,'MATLAB')+substr_count($articul,'Matlab');

    //搜索模块
    ////

    $articulnum=$wpdb->get_var("SELECT COUNT(*) FROM " . SS_TABLE . " WHERE `user` = '$sql'");
    $c = $articulnum;
    $textid=$wpdb->get_results("SELECT id FROM " . SS_TABLE . " WHERE `user` = '$sql'");
    $m=0;
    foreach($textid as $a){
        $textlist2[$m]=$a->id;
        $m++;
    }

    $m=0;
    global $textlist3;
    global $articul;
    $articul=0;
    while($c>0)  //$c是该用户一共有多少条编辑次数
    {
        $count=$wpdb->get_var("SELECT repeat_count FROM " . SS_TABLE . " WHERE `id` ='$textlist2[$m]'");
        //echo $count;
        while($count>=0)
        {
            $articul.= $wpdb->get_var("SELECT keywords FROM " . SS_TABLE . " WHERE `id` ='$textlist2[$m]'");
            $count--;
        }

        $m++;
        $c--;
    }
    //echo $articul;
    $phpnum2=substr_count($articul,'php')+substr_count($articul,'PHP')+substr_count($articul,'Php');
    $htmlnum2=substr_count($articul,'html')+substr_count($articul,'HTML')+substr_count($articul,'Html');
    $jsnum2=substr_count($articul,'javascript')+substr_count($articul,'js')+substr_count($articul,'JS')+substr_count($articul,'JavaScript')+substr_count($articul,'Javascript');
    $mycookienum2=substr_count($articul,'mycookie')+substr_count($articul,'Mycookie');
    $danpianjinum2=substr_count($articul,'单片机');
    $cssnum2=substr_count($articul,'css')+substr_count($articul,'CSS');
    $sqlnum2=substr_count($articul,'mysql')+substr_count($articul,'数据库')+substr_count($articul,'Mysql')+substr_count($articul,'phpmyadmin')
        +substr_count($articul,'Phpmyadmin')+substr_count($articul,'phpMyAdmin')+substr_count($articul,'sql')+substr_count($articul,'SQL')
        +substr_count($articul,'access')+substr_count($articul,'Access')+substr_count($articul,'oracle')+substr_count($articul,'Oracle')+substr_count($articul,'MySQL');
    $duinonum2=substr_count($articul,'duino');
    $android2=substr_count($articul,'android')+substr_count($articul,'Android');
    $iosnum2=substr_count($articul,'IOS')+substr_count($articul,'ios');
    $pingtainum2=substr_count($articul,'开放平台')+substr_count($articul,'硬件平台')+substr_count($articul,'开发平台');
    $webnum2=substr_count($articul,'web')+substr_count($articul,'Web')+substr_count($articul,'前端')+substr_count($articul,'后端');
    $matlabnum2=substr_count($articul,'matlab')+substr_count($articul,'MATLAB')+substr_count($articul,'Matlab');
    //计算加权值
    global $phpcount,$htmlcount,$jscount,$mycookiecount,$danpianjicount,$csscount,$sqlcount,$duinocount,$androidcount,
           $ioscount,$pingtaicount,$webcount,$matlabcount;
    $phpcount=$phpnum1*2+$phpnum2;
    $htmlcount=$htmlnum1*2+$htmlnum2;
    $jscount=$jsnum1*2+$jsnum2;
    $mycookiecount=$mycookienum1*2+$mycookienum2;
    $danpianjicount=$danpianjinum1*2+$danpianjinum2;
    $csscount=$cssnum1*2+$cssnum2;
    $sqlcount=$sqlnum1*2+$sqlnum2;
    $duinocount=$duinonum1*2+$duinonum2;
    $androidcount=$android1*2+$android2;
    $ioscount=$iosnum1*2+$iosnum2;
    $pingtaicount=$pingtainum1*2+$pingtainum2;
    $webcount=$webnum1*2+$webnum2;
    $matlabcount=$matlabnum1*2+$matlabnum2;

    return $score="$phpcount,$htmlcount,$jscount,$mycookiecount,$danpianjicount,$csscount,$sqlcount,$duinocount,$androidcount,$ioscount,$pingtaicount,$webcount,$matlabcount";

}
function good(){
    $socre=explode(",",getinterest());
    $phpcount=$socre[0];
    $htmlcount=$socre[1];
    $jscount=$socre[2];
    $mycookiecount=$socre[3];
    $danpianjicount=$socre[4];
    $csscount=$socre[5];
    $sqlcount=$socre[6];
    $duinocount=$socre[7];
    $androidcount=$socre[8];
    $ioscount=$socre[9];
    $pingtaicount=$socre[10];
    $webcount=$socre[11];
    $matlabcount=$socre[12];
    global $wpdb;
    $phpaverage=$wpdb->get_var( "SELECT round(avg(phpcount),2) FROM wp_count ");
    $htmlaverage=$wpdb->get_var( "SELECT round(avg(htmlcount),2) FROM wp_count ");
    $jsaverage=$wpdb->get_var( "SELECT round(avg(jscount),2) FROM wp_count ");
    $mycookieaverage=$wpdb->get_var( "SELECT round(avg(mycookiecount),2) FROM wp_count ");
    $danpianjiaverage=$wpdb->get_var( "SELECT round(avg(danpianjicount),2) FROM wp_count ");
    $cssaverage=$wpdb->get_var( "SELECT round(avg(csscount),2) FROM wp_count ");
    $sqlaverage=$wpdb->get_var( "SELECT round(avg(sqlcount),2) FROM wp_count ");
    $duinoaverage=$wpdb->get_var( "SELECT round(avg(duinocount),2) FROM wp_count ");
    $androidaverage=$wpdb->get_var( "SELECT round(avg(androidcount),2) FROM wp_count ");
    $iosaverage=$wpdb->get_var( "SELECT round(avg(ioscount),2) FROM wp_count ");
    $pingtaiaverage=$wpdb->get_var( "SELECT round(avg(pingtaicount),2) FROM wp_count ");
    $webaverage=$wpdb->get_var( "SELECT round(avg(webcount),2) FROM wp_count ");
    $matlabaverage=$wpdb->get_var( "SELECT round(avg(matlabcount),2) FROM wp_count ");
    $average[0]=$phpaverage;$average[1]=$htmlaverage;$average[2]=$jsaverage;$average[3]=$mycookieaverage;$average[4]=$danpianjiaverage;
    $average[5]=$cssaverage;$average[6]=$sqlaverage;$average[7]=$duinoaverage;$average[8]=$androidaverage;$average[9]=$iosaverage;
    ;$average[10]=$pingtaiaverage;$average[11]=$webaverage;$average[12]=$matlabaverage;
    for ($i=0;$i<13;$i++){
        if ($socre[$i]>$average[$i])
            $strength[$i]=1;
        else
            $strength[$i]=0;
    }
    $strcount=0;
    for ($i=0;$i<13;$i++){
        if ($strength[$i]==1)
            $strcount++;
    }
    $des=0;
    for ($i=0;$i<13;$i++){
        if ($socre[$i]!=0)
            $des++;
    }
    if($strcount>6)
        $return="全面大神";
    else if(3<$strcount and $strcount<6)
        $return="优秀人才";
    else if($strcount<2)
        $return="还需努力";
    else if($des==0)
        $return="能力很差";
    echo $return;
}
function goodornot(){
    $socre=explode(",",getinterest());
    $phpcount=$socre[0];
    $htmlcount=$socre[1];
    $jscount=$socre[2];
    $mycookiecount=$socre[3];
    $danpianjicount=$socre[4];
    $csscount=$socre[5];
    $sqlcount=$socre[6];
    $duinocount=$socre[7];
    $androidcount=$socre[8];
    $ioscount=$socre[9];
    $pingtaicount=$socre[10];
    $webcount=$socre[11];
    $matlabcount=$socre[12];
    $good = array_search(max($socre), $socre);
    $notgood=array_search(min($socre), $socre);
    switch($good)
    {   case 0:    $goodat="php";    break;
        case 1:    $goodat="html";    break;
        case 2:    $goodat="js";      break;
        case 3:    $goodat="mycookie";      break;
        case 4:    $goodat="danpianji";      break;
        case 5:    $goodat="css";        break;
        case 6:    $goodat="sql";      break;
        case 7:    $goodat="duino类";      break;
        case 8:    $goodat="android";      break;
        case 9:    $goodat="ios";      break;
        case 10:    $goodat="pingtai";      break;
        case 11:    $goodat="web";      break;
        case 12:    $goodat="matlab";      break;
       }
    switch($notgood)
    {   case 0:    $ngoodat="php";    break;
        case 1:    $ngoodat="html";    break;
        case 2:    $ngoodat="js";      break;
        case 3:    $ngoodat="mycookie";      break;
        case 4:    $ngoodat="danpianji";      break;
        case 5:    $ngoodat="css";        break;
        case 6:    $ngoodat="sql";      break;
        case 7:    $ngoodat="duino类";      break;
        case 8:    $ngoodat="android";      break;
        case 9:    $ngoodat="ios";      break;
        case 10:    $ngoodat="pingtai";      break;
        case 11:    $ngoodat="web";      break;
        case 12:    $ngoodat="matlab";      break;
    }
    $goodornot[0]=$goodat;
    $goodornot[1]=$ngoodat;
    return $goodornot;
}
function desire(){
    $socredesire=explode(",",getdesire());
    global $wpdb;
    $phpdesireaverage=$wpdb->get_var( "SELECT round(avg(phpcount),2) FROM wp_countdesire ");
    $htmldesireaverage=$wpdb->get_var( "SELECT round(avg(htmlcount),2) FROM wp_countdesire ");
    $jsdesireaverage=$wpdb->get_var( "SELECT round(avg(jscount),2) FROM wp_countdesire ");
    $mycookiedesireaverage=$wpdb->get_var( "SELECT round(avg(mycookiecount),2) FROM wp_countdesire ");
    $danpianjidesireaverage=$wpdb->get_var( "SELECT round(avg(danpianjicount),2) FROM wp_countdesire ");
    $cssdesireaverage=$wpdb->get_var( "SELECT round(avg(csscount),2) FROM wp_countdesire ");
    $sqldesireaverage=$wpdb->get_var( "SELECT round(avg(sqlcount),2) FROM wp_countdesire ");
    $duinodesireaverage=$wpdb->get_var( "SELECT round(avg(duinocount),2) FROM wp_countdesire ");
    $androiddesireaverage=$wpdb->get_var( "SELECT round(avg(androidcount),2) FROM wp_countdesire ");
    $iosdesireaverage=$wpdb->get_var( "SELECT round(avg(ioscount),2) FROM wp_countdesire ");
    $pingtaidesireaverage=$wpdb->get_var( "SELECT round(avg(pingtaicount),2) FROM wp_countdesire ");
    $webdesireaverage=$wpdb->get_var( "SELECT round(avg(webcount),2) FROM wp_countdesire ");
    $matlabdesireaverage=$wpdb->get_var( "SELECT round(avg(matlabcount),2) FROM wp_countdesire ");
    $desire[0]=$phpdesireaverage;$desire[1]=$htmldesireaverage;$desire[2]=$jsdesireaverage;$desire[3]=$mycookiedesireaverage;
    $desire[4]=$danpianjidesireaverage;$desire[5]=$cssdesireaverage;$desire[6]=$sqldesireaverage;$desire[7]=$duinodesireaverage;
    $desire[8]=$androiddesireaverage;$desire[9]=$iosdesireaverage;$desire[10]=$pingtaidesireaverage;$desire[11]=$webdesireaverage;
    $desire[12]=$matlabdesireaverage;
    for ($i=0;$i<13;$i++){
        if ($socredesire[$i]>$desire[$i])
            $strength[$i]=1;
        else
            $strength[$i]=0;
    }
    $des=0;
    for ($i=0;$i<13;$i++){
        if ($socredesire[$i]!=0)
            $des++;
    }
    $strcount=0;
    for ($i=0;$i<13;$i++){
        if ($strength[$i]==1)
            $strcount++;
    }
    if($strcount>6)
        $return="渴望学习";
    else if(2<$strcount and $strcount<6)
        $return="喜欢学习";
    else if($strcount<2)
        $return="懈怠学习";
    else if($des==0)
        $return="完全不学习";
    echo $return;
}
function desireornot(){
    $socre=explode(",",getdesire());
    $phpcount=$socre[0];
    $htmlcount=$socre[1];
    $jscount=$socre[2];
    $mycookiecount=$socre[3];
    $danpianjicount=$socre[4];
    $csscount=$socre[5];
    $sqlcount=$socre[6];
    $duinocount=$socre[7];
    $androidcount=$socre[8];
    $ioscount=$socre[9];
    $pingtaicount=$socre[10];
    $webcount=$socre[11];
    $matlabcount=$socre[12];
    $desire = array_search(max($socre), $socre);
    $notdesire=array_search(min($socre), $socre);
    switch($desire)
    {   case 0:    $goodat="php";    break;
        case 1:    $goodat="html";    break;
        case 2:    $goodat="js";      break;
        case 3:    $goodat="mycookie";      break;
        case 4:    $goodat="danpianji";      break;
        case 5:    $goodat="css";        break;
        case 6:    $goodat="sql";      break;
        case 7:    $goodat="duino类";      break;
        case 8:    $goodat="android";      break;
        case 9:    $goodat="ios";      break;
        case 10:    $goodat="pingtai";      break;
        case 11:    $goodat="web";      break;
        case 12:    $goodat="matlab";      break;
    }
    switch($notdesire)
    {   case 0:    $ngoodat="php";    break;
        case 1:    $ngoodat="html";    break;
        case 2:    $ngoodat="js";      break;
        case 3:    $ngoodat="mycookie";      break;
        case 4:    $ngoodat="danpianji";      break;
        case 5:    $ngoodat="css";        break;
        case 6:    $ngoodat="sql";      break;
        case 7:    $ngoodat="duino类";      break;
        case 8:    $ngoodat="android";      break;
        case 9:    $ngoodat="ios";      break;
        case 10:    $ngoodat="pingtai";      break;
        case 11:    $ngoodat="web";      break;
        case 12:    $ngoodat="matlab";      break;
    }
    $goodornot[0]=$goodat;
    $goodornot[1]=$ngoodat;
    return $goodornot;
}
function level(){
    global $wpdb;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT ID FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $level =$wpdb->get_var( "SELECT meta_value FROM `$wpdb->usermeta` WHERE `user_id` = '$sql' and meta_key='wp_user_level'");
    if ($level==10)
        $userlevel="管理员";
    else if($level==7)
        $userlevel="编辑";
    else if($level==2)
        $userlevel="作者";
    else if($level==1)
        $userlevel="投稿者";
    else if($level==0)
        $userlevel="订阅者";
    echo $userlevel;
}
function year(){
    global $wpdb;
    $c=get_option('spark_search_user_copy_right');
    $sql =$wpdb->get_var( "SELECT user_registered FROM `$wpdb->users` WHERE `user_login` = '$c'");
    $useryear=substr($sql, 0, 4);
    $year=date("Y",time());
    if ($useryear!=$year)
        $usertime="往届生";
    else
        $usertime="应届生";
    echo $usertime;
}
