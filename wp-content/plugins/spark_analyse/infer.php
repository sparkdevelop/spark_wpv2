<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/13
 * Time: 20:09
 */
//header("Content-type:text/html;charset=utf-8");
require_once( ABSPATH . 'wp-admin/includes/admin.php' );
//function plugin3()
//{
//    wp_register_style('zhyfep-style', plugins_url('bootstrap.min.css', __FILE__), array(), '1.6', 'all');
//    wp_register_style('zhydatepicker-style', plugins_url('dateRange.css', __FILE__), array(), '1.6', 'all');
//    wp_register_style('zhymain-style', plugins_url('main.css', __FILE__), array(), '1.0', 'all');
//    wp_register_style('zhytable-style', plugins_url('table.css', __FILE__), array(), '1.6', 'all');
//    wp_register_style('zhyuser-style', plugins_url('user.css', __FILE__), array(), '1.6', 'all');
//    wp_register_style('zhytag-style', plugins_url('tagcloud.css', __FILE__), array(), '1.6', 'all');
//    wp_register_script("zhyjquery-script", plugins_url('js/jquery-3.2.1.js', __FILE__), array('jquery'));
//    wp_register_script("zhydate-script", plugins_url('js/dateRange.js', __FILE__), array('jquery'));
//    wp_register_script("zhytag-script", plugins_url('js/tagcloud.min.js', __FILE__), array('jquery'));
//    wp_register_script("zhyui-script", plugins_url('js/jquery-ui.js', __FILE__), array('jquery'));
//    wp_register_script("zhytime-script", plugins_url('js/active.js', __FILE__), array('jquery'));
//    wp_register_script("zhyfep-script", plugins_url('js/bootstrap.min.js', __FILE__), array('jquery'));
//    wp_register_script("zhyview-script", plugins_url('js/view.js', __FILE__), array('jquery'));
//    wp_register_script("zhycollapse-script", plugins_url('js/collapse.js', __FILE__), array('jquery'));
//    wp_register_script("zhyhigh-script", plugins_url('js/highcharts.js', __FILE__), array('jquery'));
//    wp_register_script("zhyhighm-script", plugins_url('js/highcharts-more.js', __FILE__), array('jquery'));
////wp_register_script("increment-script", plugins_url('js/user_increment.js', __FILE__),array('jquery'));
//    wp_register_script("zhytransition-script", plugins_url('js/transition.js', __FILE__), array('jquery'));
//
//    wp_enqueue_script("zhyjquery-script");
//    wp_enqueue_script("zhyfep-script");
//
//    wp_enqueue_script("zhytag-script");
//    wp_enqueue_script("zhytime-script");
//    wp_enqueue_script("zhyview-script");
//    wp_enqueue_script("zhyhigh-script");
//    wp_enqueue_script("zhytransition-script");
//    wp_enqueue_script("zhyhighm-script");
////    wp_enqueue_script("increment-script");
//    wp_enqueue_script("zhycollapse-script");
//    wp_enqueue_script("zhydate-script");
//    wp_enqueue_script("zhyui-script");
//
//    wp_enqueue_style('zhyfep-style');
//    wp_enqueue_style('zhydatepicker-style');
//    wp_enqueue_style('zhymain-style');
//    wp_enqueue_style('zhytable-style');
//    wp_enqueue_style('zhyuser-style');
//    wp_enqueue_style('zhytag-style');
//}

//add_action( 'admin_enqueue_scripts', 'plugin3' );
require_once('model_drawing.php');
require_once ('userhistory.php');
require_once ('all_rank.php');
function spark_settings_submenu_page2(){
//    $history_key=array_keys(history());
//    $c=count($history_key);
    $history_value=history_value();
    $timelong1=$history_value[0]; $timelong2=$history_value[1]; $timelong3=$history_value[2]; $timelong4=$history_value[3];
    $history=history();
    $history0=$history[0]; $history1=$history[1]; $history2=$history[2]; $history3=$history[3]; $history4=$history[4];
    $history5=$history[5]; $history6=$history[6]; $history7=$history[7]; $history8=$history[8]; $history9=$history[9];
    $socre=explode(",",getinterest());
    $jiqixuexicount=$socre[0];
    $jisuanjishijuecount=$socre[1];
    $tuijiancount=$socre[2];
    $dianlufenxicount=$socre[3];
    $danpianjicount=$socre[4];
    $shuzidianlucount=$socre[5];
    $tongyuancount=$socre[6];
    $tongxincount=$socre[7];
    $diancicount=$socre[8];
    $bianchengcount=$socre[9];
    $jisuanjijichucount=$socre[10];
    $webcount=$socre[11];
    $socred=explode(",",getdesire());
    $jiqixuexicountd=$socred[0];
    $jisuanjishijuecountd=$socred[1];
    $tuijiancountd=$socred[2];
    $dianlufenxicountd=$socred[3];
    $danpianjicountd=$socred[4];
    $shuzidianlucountd=$socred[5];
    $tongyuancountd=$socred[6];
    $tongxincountd=$socred[7];
    $diancicountd=$socred[8];
    $bianchengcountd=$socred[9];
    $jisuanjijichucountd=$socred[10];
    $webcountd=$socred[11];
    $c=get_option('spark_search_user_copy_right');
    $sql=0;
    global $wpdb;
    $sql =$wpdb->get_var( "SELECT COUNT(*) FROM ".COUNT_TABLE." WHERE `user` = '$c'");
//     echo $sql;

    if ($sql!=0){
        $wpdb->update( 'wp_count_sec' , array( 'jiqixuexicount' => $jiqixuexicount, 'jisuanjishijuecount' => $jisuanjishijuecount, 'tuijiancount' => $tuijiancount
        , 'dianlufenxicount' => $dianlufenxicount, 'danpianjicount' => $danpianjicount, 'shuzidianlucount' => $shuzidianlucount
        , 'tongyuancount' => $tongyuancount, 'tongxincount' => $tongxincount, 'diancicount' => $diancicount, 'bianchengcount' => $bianchengcount
        , 'jisuanjijichucount' => $jisuanjijichucount, 'webcount' => $webcount), array( 'user' => $c ));
    }
    else{
        $wpdb->insert('wp_count_sec', array('user'=>$c,  'jiqixuexicount' => $jiqixuexicount, 'jisuanjishijuecount' => $jisuanjishijuecount, 'tuijiancount' => $tuijiancount
        , 'dianlufenxicount' => $dianlufenxicount, 'danpianjicount' => $danpianjicount, 'shuzidianlucount' => $shuzidianlucount
        , 'tongyuancount' => $tongyuancount, 'tongxincount' => $tongxincount, 'diancicount' => $diancicount, 'bianchengcount' => $bianchengcount
        , 'jisuanjijichucount' => $jisuanjijichucount, 'webcount' => $webcount));
    }
    $s=0;
    $s =$wpdb->get_var( "SELECT COUNT(*) FROM ".COUNTD_TABLE." WHERE `user` = '$c'");
    // echo $sql;
    if ($s!=0){
        $wpdb->update( 'wp_countdesire_sec', array( 'jiqixuexicount' => $jiqixuexicountd, 'jisuanjishijuecount' => $jisuanjishijuecountd, 'tuijiancount' => $tuijiancountd
        , 'dianlufenxicount' => $dianlufenxicountd, 'danpianjicount' => $danpianjicountd, 'shuzidianlucount' => $shuzidianlucountd
        , 'tongyuancount' => $tongyuancountd, 'tongxincount' => $tongxincountd, 'diancicount' => $diancicountd, 'bianchengcount' => $bianchengcountd
        , 'jisuanjijichucount' => $jisuanjijichucountd, 'webcount' => $webcountd), array( 'user' => $c ));
    }
    else{
        $wpdb->insert("wp_countdesire_sec", array('user'=>$c, 'jiqixuexicount' => $jiqixuexicountd, 'jisuanjishijuecount' => $jisuanjishijuecountd, 'tuijiancount' => $tuijiancountd
        , 'dianlufenxicount' => $dianlufenxicountd, 'danpianjicount' => $danpianjicountd, 'shuzidianlucount' => $shuzidianlucountd
        , 'tongyuancount' => $tongyuancountd, 'tongxincount' => $tongxincountd, 'diancicount' => $diancicountd, 'bianchengcount' => $bianchengcountd
        , 'jisuanjijichucount' => $jisuanjijichucountd, 'webcount' => $webcountd));
    }

    $jiqixuexiaverage=$wpdb->get_var( "SELECT round(avg(jiqixuexicount),2) FROM ".COUNT_TABLE." ");
    $jisuanjishijueaverage=$wpdb->get_var( "SELECT round(avg(jisuanjishijuecount),2) FROM ".COUNT_TABLE." ");
    $tuijianaverage=$wpdb->get_var( "SELECT round(avg(tuijiancount),2) FROM ".COUNT_TABLE." ");
    $dianlufenxiaverage=$wpdb->get_var( "SELECT round(avg(dianlufenxicount),2) FROM ".COUNT_TABLE." ");
    $danpianjiaverage=$wpdb->get_var( "SELECT round(avg(danpianjicount),2) FROM ".COUNT_TABLE." ");
    $shuzidianluaverage=$wpdb->get_var( "SELECT round(avg(shuzidianlucount),2) FROM ".COUNT_TABLE." ");
    $tongyuanaverage=$wpdb->get_var( "SELECT round(avg(tongyuancount),2) FROM ".COUNT_TABLE." ");
    $tongxinaverage=$wpdb->get_var( "SELECT round(avg(tongxincount),2) FROM ".COUNT_TABLE." ");
    $dianciaverage=$wpdb->get_var( "SELECT round(avg(diancicount),2) FROM ".COUNT_TABLE." ");
    $bianchengaverage=$wpdb->get_var( "SELECT round(avg(bianchengcount),2) FROM ".COUNT_TABLE." ");
    $jisuanjijichuaverage=$wpdb->get_var( "SELECT round(avg(jisuanjijichucount),2) FROM ".COUNT_TABLE." ");
    $webaverage=$wpdb->get_var( "SELECT round(avg(webcount),2) FROM ".COUNT_TABLE." ");


    $jiqixuexiaveraged=$wpdb->get_var( "SELECT round(avg(jiqixuexicount),2) FROM ".COUNTD_TABLE." ");
    $jisuanjishijueaveraged=$wpdb->get_var( "SELECT round(avg(jisuanjishijuecount),2) FROM ".COUNTD_TABLE." ");
    $tuijianaveraged=$wpdb->get_var( "SELECT round(avg(tuijiancount),2) FROM ".COUNTD_TABLE." ");
    $dianlufenxiaveraged=$wpdb->get_var( "SELECT round(avg(dianlufenxicount),2) FROM ".COUNTD_TABLE." ");
    $danpianjiaveraged=$wpdb->get_var( "SELECT round(avg(danpianjicount),2) FROM ".COUNTD_TABLE." ");
    $shuzidianluaveraged=$wpdb->get_var( "SELECT round(avg(shuzidianlucount),2) FROM ".COUNTD_TABLE." ");
    $tongyuanaveraged=$wpdb->get_var( "SELECT round(avg(tongyuancount),2) FROM ".COUNTD_TABLE." ");
    $tongxinaveraged=$wpdb->get_var( "SELECT round(avg(tongxincount),2) FROM ".COUNTD_TABLE." ");
    $dianciaveraged=$wpdb->get_var( "SELECT round(avg(diancicount),2) FROM ".COUNTD_TABLE." ");
    $bianchengaveraged=$wpdb->get_var( "SELECT round(avg(bianchengcount),2) FROM ".COUNTD_TABLE." ");
    $jisuanjijichuaveraged=$wpdb->get_var( "SELECT round(avg(jisuanjijichucount),2) FROM ".COUNTD_TABLE." ");
    $webaveraged=$wpdb->get_var( "SELECT round(avg(webcount),2) FROM ".COUNTD_TABLE." ");
    $tag=tag();
//    $data=history_value();
//    $datajson=json_encode($data)
    ?>


<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="css-folder/aristo/jquery-ui-1.8.5.custom.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="css-folder/Timeglider.css" type="text/css" media="screen" title="no title" charset="utf-8">
    <script src="/your_js_folder/jquery.js" type='text/javascript'></script>
        <script src="your_js_folder/timeglider.min.js" type='text/javascript'></script>
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
        $('#containerb').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '用户浏览量占比'
            },
            tooltip: {
                headerFormat: '{series.name}<br>',
                pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: '用户浏览量占比',
                data: [
                    ['<?php echo $history0 ?>',   <?php echo $history5?>],
                    ['<?php echo $history1 ?>',   <?php echo $history6?>],
                    ['<?php echo $history2 ?>',   <?php echo $history7?>],
                    ['<?php echo $history3 ?>',   <?php echo $history8?>],
                    ['<?php echo $history4 ?>',   <?php echo $history9?>]
                ]
            }]
        });
        var timelong1 = <?php echo json_encode($timelong1);?>;
        var timelong2=<?php echo json_encode($timelong2);?>;
        var timelong3=<?php echo json_encode($timelong3);?>;
        var timelong4=<?php echo json_encode($timelong4);?>;
        $('#containerzx').highcharts(
{

            chart: {
                zoomType: 'x'
            },
            title: {
                text: '用户兴趣变化图'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    '鼠标拖动可以进行缩放' : '手势操作进行缩放'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    millisecond: '%H:%M:%S.%L',
                    second: '%H:%M:%S',
                    minute: '%H:%M',
                    hour: '%H:%M',
                    day: '%m-%d',
                    week: '%m-%d',
                    month: '%Y-%m',
                    year: '%Y'
                }
            },
            tooltip: {
                dateTimeLabelFormats: {
                    millisecond: '%H:%M:%S.%L',
                    second: '%H:%M:%S',
                    minute: '%H:%M',
                    hour: '%H:%M',
                    day: '%Y-%m-%d',
                    week: '%m-%d',
                    month: '%Y-%m',
                    year: '%Y'
                }
            },
            yAxis: {
                title: {
                    text: '次数'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
            series: [{
            name: '计算机',
            data: timelong4,
            pointInterval: 24 * 3600 * 1000,
                pointStart: Date.UTC(2017, 5, 1),
        }, {
            name: '电子',
            data: timelong2,
            pointInterval: 24 * 3600 * 1000,
                pointStart: Date.UTC(2017, 5, 1),
        }, {
            name: '人工智能',
            data: timelong1,
                pointInterval: 24 * 3600 * 1000,
                pointStart: Date.UTC(2017, 5, 1),
        }, {
            name: '通信',
            data: timelong3,
                pointInterval: 24 * 3600 * 1000,
                pointStart: Date.UTC(2017, 5, 1),
        }],


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
                categories: ['机器学习', '计算机视觉', '推荐系统', '电路分析',
                    '单片机', '数字电路','通信原理','移动通信','电磁波','编程语言','计算机基础','网络'],
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
                data: [ <?php echo $jiqixuexicount?>,<?php echo $jisuanjishijuecount?>, <?php echo $tuijiancount?>, <?php echo $dianlufenxicount ?>,<?php echo $danpianjicount ?>, <?php echo $shuzidianlucount ?>,<?php echo $tongyuancount ?>,<?php echo $tongxincount ?>,<?php echo $diancicount ?>,<?php echo $bianchengcount ?>, <?php echo $jisuanjijichucount ?>,<?php echo $webcount ?>],
                pointPlacement: 'on',
            }, {
                name: '平均值',
                data: [ <?php echo $jiqixuexiaverage?>,<?php echo $jisuanjishijueaverage?>, <?php echo $tuijianaverage?>, <?php echo $dianlufenxiaverage ?>,<?php echo $danpianjiaverage ?>, <?php echo $shuzidianluaverage ?>,<?php echo $tongyuanaverage ?>,<?php echo $tongxinaverage ?>,<?php echo $dianciaverage ?>,<?php echo $bianchengaverage ?>, <?php echo $jisuanjijichuaverage ?>,<?php echo $webaverage ?>],
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
                categories: ['机器学习', '计算机视觉', '推荐系统', '电路分析',
                '单片机', '数字电路','通信原理','移动通信','电磁波','编程语言','计算机基础','网络'],
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
                data: [ <?php echo $jiqixuexicountd?>,<?php echo $jisuanjishijuecountd?>, <?php echo $tuijiancountd?>, <?php echo $dianlufenxicountd ?>,<?php echo $danpianjicountd ?>, <?php echo $shuzidianlucountd ?>,<?php echo $tongyuancountd ?>,<?php echo $tongxincountd ?>,<?php echo $diancicountd ?>,<?php echo $bianchengcountd ?>, <?php echo $jisuanjijichucountd ?>,<?php echo $webcountd ?>],
                pointPlacement: 'on'
            },{
                name: '平均值',
                data: [ <?php echo $jiqixuexiaveraged?>,<?php echo $jisuanjishijueaveraged?>, <?php echo $tuijianaveraged?>, <?php echo $dianlufenxiaveraged ?>,<?php echo $danpianjiaveraged ?>, <?php echo $shuzidianluaveraged ?>,<?php echo $tongyuanaveraged ?>,<?php echo $tongxinaveraged ?>,<?php echo $dianciaveraged ?>,<?php echo $bianchengaveraged ?>, <?php echo $jisuanjijichuaveraged ?>,<?php echo $webaveraged ?>],
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
        $(document).ready(function () {
                    var data=[1,2,3,4,5];
            data=JSON.stringify( data );
            var tg1 = $("#placement").timeline({
                "data_source":data,
                "min_zoom ":15,
                "max_zoom ":60,
            });
        });
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
        <div class="col-md-6" style="background-color: white;width: 48%">
            <div style="text-align:center;background-color:rgb(100,201,202);margin-top: 22px;width: 93px;height: 93px;margin-left: 40%;border-radius: 50%;border: solid 1px rgb(100,201,202)"><i class="fa fa-user fa-5x " style="color:white;"></i></div>
            <div ><p style="position:relative;text-align:center;font-size:40px;top:20px"><?php echo get_option('spark_search_user_copy_right') ?></p></div>
            <br/>
            <br/>
        </div>
        <div id="mokuai" class="col-md-6" style="background-color: white;width: 48%">
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

        <div   class="col-md-6" style="background-color: white;width: 48%">
            <p>用户擅长</p>
        </div>

        <div   class="col-md-6" style="background-color: white;margin-left: 30px;width: 48%;">
       <p>

           用户兴趣</p>


        </div>


    </div>
    <div class="row">

        <div   class="col-md-6" style="background-color: white;width: 48%">
            <div id="containersc" style="min-width:400px;height:400px"></div>
        </div>

<!--        <div  class="col-md-6" style="background-color: white;width: 47%;position: absolute;height: 400px;left: 626px;top: 362px;">-->
            <div   class="col-md-6" style="background-color: white;margin-left: 30px;width: 48%">
                <div id="containerxq" style="min-width:400px;height:400px"></div>
            </div>


<!--        </div>-->


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
                    <td>机器学习</td>
                    <td><?php echo $jiqixuexicount?></td>
                    <td><?php echo $jiqixuexiaverage?></td>
                </tr>
                <tr>
                    <td>计算机视觉</td>
                    <td><?php echo $jisuanjishijuecount?></td>
                    <td><?php echo $jisuanjishijueaverage?></td>
                </tr>
                <tr>
                    <td>推荐系统</td>
                    <td><?php echo $tuijiancount?></td>
                    <td><?php echo $tuijianaverage?></td>
                </tr>
                <tr>
                    <td>电路分析</td>
                    <td><?php echo $dianlufenxicount ?></td>
                    <td><?php echo $dianlufenxiaverage?></td>
                </tr>
                <tr>
                    <td>单片机</td>
                    <td><?php echo $danpianjicount ?></td>
                    <td><?php echo $danpianjiaverage?></td>
                </tr>
                <tr>
                    <td>数字电路</td>
                    <td><?php echo $shuzidianlucount ?></td>
                    <td><?php echo $shuzidianluaverage?></td>
                </tr>
                <tr>
                    <td>通信原理</td>
                    <td><?php echo $tongyuancount ?></td>
                    <td><?php echo $tongyuanaverage?></td>
                </tr>
                <tr>
                    <td>移动通信</td>
                    <td><?php echo $tongxincount ?></td>
                    <td><?php echo $tongxinaverage?></td>
                </tr>
                <tr>
                    <td>电磁波</td>
                    <td><?php echo $diancicount ?></td>
                    <td><?php echo $dianciaverage?></td>
                </tr>
                <tr>
                    <td>编程语言</td>
                    <td><?php echo $bianchengcount ?></td>
                    <td><?php echo $bianchengaverage?></td>
                </tr>
                <tr>
                    <td>计算机基础</td>
                    <td><?php echo $jisuanjijichucount ?></td>
                    <td><?php echo $jisuanjijichuaverage?></td>
                </tr>
                <tr>
                    <td>网络</td>
                    <td><?php echo $webcount ?></td>
                    <td><?php echo $webaverage?></td>
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
                    <td>机器学习</td>
                    <td><?php echo $jiqixuexicountd?></td>
                    <td><?php echo $jiqixuexiaveraged?></td>
                </tr>
                <tr>
                    <td>计算机视觉</td>
                    <td><?php echo $jisuanjishijuecountd?></td>
                    <td><?php echo $jisuanjishijueaveraged?></td>
                </tr>
                <tr>
                    <td>推荐系统</td>
                    <td><?php echo $tuijiancountd?></td>
                    <td><?php echo $tuijianaveraged?></td>
                </tr>
                <tr>
                    <td>电路分析</td>
                    <td><?php echo $dianlufenxicountd ?></td>
                    <td><?php echo $dianlufenxiaveraged?></td>
                </tr>
                <tr>
                    <td>单片机</td>
                    <td><?php echo $danpianjicountd ?></td>
                    <td><?php echo $danpianjiaveraged?></td>
                </tr>
                <tr>
                    <td>数字电路</td>
                    <td><?php echo $shuzidianlucountd ?></td>
                    <td><?php echo $shuzidianluaveraged?></td>
                </tr>
                <tr>
                    <td>通信原理</td>
                    <td><?php echo $tongyuancountd ?></td>
                    <td><?php echo $tongyuanaveraged?></td>
                </tr>
                <tr>
                    <td>移动通信</td>
                    <td><?php echo $tongxincountd ?></td>
                    <td><?php echo $tongxinaveraged?></td>
                </tr>
                <tr>
                    <td>电磁波</td>
                    <td><?php echo $diancicountd ?></td>
                    <td><?php echo $dianciaveraged?></td>
                </tr>
                <tr>
                    <td>编程语言</td>
                    <td><?php echo $bianchengcountd ?></td>
                    <td><?php echo $bianchengaveraged?></td>
                </tr>
                <tr>
                    <td>计算机基础</td>
                    <td><?php echo $jisuanjijichucountd ?></td>
                    <td><?php echo $jisuanjijichuaveraged?></td>
                </tr>
                <tr>
                    <td>网络</td>
                    <td><?php echo $webcountd ?></td>
                    <td><?php echo $webaveraged?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">

        <div   class="col-md-6" style="background-color: white;width: 48%">
            <div id="containerb" style="min-width:400px;height:400px"></div>
        </div>
        <div   class="col-md-6" style="background-color: white;margin-left: 30px;width: 48%">
            <div id="containerzx" style="min-width:400px;height:400px"></div>
        </div>


        <!--        </div>-->


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
    $jiqixuexinum1=substr_count($articul,'聚类')+substr_count($articul,'算法')+substr_count($articul,'贝叶斯')+substr_count($articul,'神经网络')+substr_count($articul,'决策树');
    $jisuanjishijuenum1=substr_count($articul,'图像')+substr_count($articul,'识别')+substr_count($articul,'监督')+substr_count($articul,'特征');
    $tuijiannum1=substr_count($articul,'用户')+substr_count($articul,'属性')+substr_count($articul,'冷启动')+substr_count($articul,'推荐')+substr_count($articul,'画像');
    $danpianjinum1=substr_count($articul,'引脚')+substr_count($articul,'mCookie')+substr_count($articul,'Arduino')+substr_count($articul,'pin')+substr_count($articul,'串口')+substr_count($articul,'单片机')+substr_count($articul,'led');
    $dianlufenxinum1=substr_count($articul,'电路')+substr_count($articul,'电流')+substr_count($articul,'电阻')+substr_count($articul,'戴维南')+substr_count($articul,'电极')+substr_count($articul,'等效');
    $shuzidianlunum1=substr_count($articul,'MOS')+substr_count($articul,'半导体')+substr_count($articul,'三极管')+substr_count($articul,'电平')+substr_count($articul,'译码器')+substr_count($articul,'场效应管');
    $tongyuannum1=substr_count($articul,'卷积')+substr_count($articul,'互信息')+substr_count($articul,'傅里叶')+substr_count($articul,'傅立叶')
        +substr_count($articul,'信道')+substr_count($articul,'信源')+substr_count($articul,'香农')+substr_count($articul,'噪声')
        +substr_count($articul,'滤波')+substr_count($articul,'IIR')+substr_count($articul,'量化')+substr_count($articul,'FIR')+substr_count($articul,'载波');
    $tongxinnum1=substr_count($articul,'以太网')+substr_count($articul,'衰落')+substr_count($articul,'复用')+substr_count($articul,'GSM')+substr_count($articul,'4G')+substr_count($articul,'5G')+substr_count($articul,'蜂窝')+substr_count($articul,'基站')
        +substr_count($articul,'多径')+substr_count($articul,'扩频');
    $diancinum1=substr_count($articul,'电荷')+substr_count($articul,'磁场')+substr_count($articul,'线圈')+substr_count($articul,'电势')+substr_count($articul,'麦克斯韦')+substr_count($articul,'通量')+substr_count($articul,'库伦');
    $bianchengnum1=substr_count($articul,'指针')+substr_count($articul,'变量')+substr_count($articul,'类型')+substr_count($articul,'数组')+substr_count($articul,'PHP')+substr_count($articul,'php')+substr_count($articul,'Pyhton')+substr_count($articul,'python')
        +substr_count($articul,'html')+substr_count($articul,'Html')+substr_count($articul,'js')+substr_count($articul,'JS')+substr_count($articul,'javascript')+substr_count($articul,'css')+substr_count($articul,'chart');
    $jisuanjijichunum1=substr_count($articul,'操作系统')+substr_count($articul,'Linux')+substr_count($articul,'DOS')+substr_count($articul,'微软')+substr_count($articul,'CPU')+substr_count($articul,'磁场');
    $webnum1=substr_count($articul,'路由器')+substr_count($articul,'网络拓扑')+substr_count($articul,'OSPFv2')+substr_count($articul,'SFC')+substr_count($articul,'组播');


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
    $jiqixuexinum2=substr_count($articul,'聚类')+substr_count($articul,'算法')+substr_count($articul,'贝叶斯')+substr_count($articul,'神经网络')+substr_count($articul,'决策树');
    $jisuanjishijuenum2=substr_count($articul,'图像')+substr_count($articul,'识别')+substr_count($articul,'监督')+substr_count($articul,'特征');
    $tuijiannum2=substr_count($articul,'用户')+substr_count($articul,'属性')+substr_count($articul,'冷启动')+substr_count($articul,'推荐')+substr_count($articul,'画像');
    $danpianjinum2=substr_count($articul,'引脚')+substr_count($articul,'mCookie')+substr_count($articul,'Arduino')+substr_count($articul,'pin')+substr_count($articul,'串口')+substr_count($articul,'单片机')+substr_count($articul,'led');
    $dianlufenxinum2=substr_count($articul,'电路')+substr_count($articul,'电流')+substr_count($articul,'电阻')+substr_count($articul,'戴维南')+substr_count($articul,'电极')+substr_count($articul,'等效');
    $shuzidianlunum2=substr_count($articul,'MOS')+substr_count($articul,'半导体')+substr_count($articul,'三极管')+substr_count($articul,'电平')+substr_count($articul,'译码器')+substr_count($articul,'场效应管');
    $tongyuannum2=substr_count($articul,'卷积')+substr_count($articul,'互信息')+substr_count($articul,'傅里叶')+substr_count($articul,'傅立叶')
        +substr_count($articul,'信道')+substr_count($articul,'信源')+substr_count($articul,'香农')+substr_count($articul,'噪声')
        +substr_count($articul,'滤波')+substr_count($articul,'IIR')+substr_count($articul,'量化')+substr_count($articul,'FIR')+substr_count($articul,'载波');
    $tongxinnum2=substr_count($articul,'以太网')+substr_count($articul,'衰落')+substr_count($articul,'复用')+substr_count($articul,'GSM')+substr_count($articul,'4G')+substr_count($articul,'5G')+substr_count($articul,'蜂窝')+substr_count($articul,'基站')
        +substr_count($articul,'多径')+substr_count($articul,'扩频');
    $diancinum2=substr_count($articul,'电荷')+substr_count($articul,'磁场')+substr_count($articul,'线圈')+substr_count($articul,'电势')+substr_count($articul,'麦克斯韦')+substr_count($articul,'通量')+substr_count($articul,'库伦');
    $bianchengnum2=substr_count($articul,'指针')+substr_count($articul,'变量')+substr_count($articul,'类型')+substr_count($articul,'数组')+substr_count($articul,'PHP')+substr_count($articul,'php')+substr_count($articul,'Pyhton')+substr_count($articul,'python')
        +substr_count($articul,'html')+substr_count($articul,'Html')+substr_count($articul,'js')+substr_count($articul,'JS')+substr_count($articul,'javascript')+substr_count($articul,'css')+substr_count($articul,'chart');
    $jisuanjijichunum2=substr_count($articul,'操作系统')+substr_count($articul,'Linux')+substr_count($articul,'DOS')+substr_count($articul,'微软')+substr_count($articul,'CPU')+substr_count($articul,'磁场');
    $webnum2=substr_count($articul,'路由器')+substr_count($articul,'网络拓扑')+substr_count($articul,'OSPFv2')+substr_count($articul,'SFC')+substr_count($articul,'组播');
    //计算加权值
    global $jiqixuexicount,$jisuanjishijuecount,$tuijiancount,$danpianjicount,$dianlufenxicount,$shuzidianlucount,$tongyuancount,$tongxincount,$diancicount,
           $bianchengcount,$jisuanjijichucount,$webcount;
    $jiqixuexicount=$jiqixuexinum1*0.3+$jiqixuexinum2;
    $jisuanjishijuecount=$jisuanjishijuenum1*0.3+$jisuanjishijuenum2;
    $tuijiancount=$tuijiannum1*0.3+$tuijiannum2;
    $dianlufenxicount=$dianlufenxinum1*0.3+$dianlufenxinum2;
    $danpianjicount=$danpianjinum1*0.3+$danpianjinum2;
    $shuzidianlucount=$shuzidianlunum1*0.3+$shuzidianlunum2;
    $tongyuancount=$tongyuannum1*0.3+$tongyuannum2;
    $tongxincount=$tongxinnum1*0.3+$tongxinnum2;
    $diancicount=$diancinum1*0.3+$diancinum2;
    $bianchengcount=$bianchengnum1*0.3+$bianchengnum2;
    $jisuanjijichucount=$jisuanjijichunum1*0.3+$jisuanjijichunum2;
    $webcount=$webnum1*0.3+$webnum2;

    return $score="$jiqixuexicount,$jisuanjishijuecount,$tuijiancount,$dianlufenxicount,$danpianjicount,$shuzidianlucount,$tongyuancount,$tongxincount,$diancicount,$bianchengcount,$jisuanjijichucount,$webcount";

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
    $jiqixuexinum1=substr_count($articul,'聚类')+substr_count($articul,'算法')+substr_count($articul,'贝叶斯')+substr_count($articul,'神经网络')+substr_count($articul,'决策树');
    $jisuanjishijuenum1=substr_count($articul,'图像')+substr_count($articul,'识别')+substr_count($articul,'监督')+substr_count($articul,'特征');
    $tuijiannum1=substr_count($articul,'用户')+substr_count($articul,'属性')+substr_count($articul,'冷启动')+substr_count($articul,'推荐')+substr_count($articul,'画像');
    $danpianjinum1=substr_count($articul,'引脚')+substr_count($articul,'mCookie')+substr_count($articul,'Arduino')+substr_count($articul,'pin')+substr_count($articul,'串口')+substr_count($articul,'单片机')+substr_count($articul,'led');
    $dianlufenxinum1=substr_count($articul,'电路')+substr_count($articul,'电流')+substr_count($articul,'电阻')+substr_count($articul,'戴维南')+substr_count($articul,'电极')+substr_count($articul,'等效');
    $shuzidianlunum1=substr_count($articul,'MOS')+substr_count($articul,'半导体')+substr_count($articul,'三极管')+substr_count($articul,'电平')+substr_count($articul,'译码器')+substr_count($articul,'场效应管');
    $tongyuannum1=substr_count($articul,'卷积')+substr_count($articul,'互信息')+substr_count($articul,'傅里叶')+substr_count($articul,'傅立叶')
        +substr_count($articul,'信道')+substr_count($articul,'信源')+substr_count($articul,'香农')+substr_count($articul,'噪声')
        +substr_count($articul,'滤波')+substr_count($articul,'IIR')+substr_count($articul,'量化')+substr_count($articul,'FIR')+substr_count($articul,'载波');
    $tongxinnum1=substr_count($articul,'以太网')+substr_count($articul,'衰落')+substr_count($articul,'复用')+substr_count($articul,'GSM')+substr_count($articul,'4G')+substr_count($articul,'5G')+substr_count($articul,'蜂窝')+substr_count($articul,'基站')
        +substr_count($articul,'多径')+substr_count($articul,'扩频');
    $diancinum1=substr_count($articul,'电荷')+substr_count($articul,'磁场')+substr_count($articul,'线圈')+substr_count($articul,'电势')+substr_count($articul,'麦克斯韦')+substr_count($articul,'通量')+substr_count($articul,'库伦');
    $bianchengnum1=substr_count($articul,'指针')+substr_count($articul,'变量')+substr_count($articul,'类型')+substr_count($articul,'数组')+substr_count($articul,'PHP')+substr_count($articul,'php')+substr_count($articul,'Pyhton')+substr_count($articul,'python')
        +substr_count($articul,'html')+substr_count($articul,'Html')+substr_count($articul,'js')+substr_count($articul,'JS')+substr_count($articul,'javascript')+substr_count($articul,'css')+substr_count($articul,'chart');
    $jisuanjijichunum1=substr_count($articul,'操作系统')+substr_count($articul,'Linux')+substr_count($articul,'DOS')+substr_count($articul,'微软')+substr_count($articul,'CPU')+substr_count($articul,'磁场');
    $webnum1=substr_count($articul,'路由器')+substr_count($articul,'网络拓扑')+substr_count($articul,'OSPFv2')+substr_count($articul,'SFC')+substr_count($articul,'组播');


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
    $jiqixuexinum2=substr_count($articul,'聚类')+substr_count($articul,'算法')+substr_count($articul,'贝叶斯')+substr_count($articul,'神经网络')+substr_count($articul,'决策树');
    $jisuanjishijuenum2=substr_count($articul,'图像')+substr_count($articul,'识别')+substr_count($articul,'监督')+substr_count($articul,'特征');
    $tuijiannum2=substr_count($articul,'用户')+substr_count($articul,'属性')+substr_count($articul,'冷启动')+substr_count($articul,'推荐')+substr_count($articul,'画像');
    $danpianjinum2=substr_count($articul,'引脚')+substr_count($articul,'mCookie')+substr_count($articul,'Arduino')+substr_count($articul,'pin')+substr_count($articul,'串口')+substr_count($articul,'单片机')+substr_count($articul,'led');
    $dianlufenxinum2=substr_count($articul,'电路')+substr_count($articul,'电流')+substr_count($articul,'电阻')+substr_count($articul,'戴维南')+substr_count($articul,'电极')+substr_count($articul,'等效');
    $shuzidianlunum2=substr_count($articul,'MOS')+substr_count($articul,'半导体')+substr_count($articul,'三极管')+substr_count($articul,'电平')+substr_count($articul,'译码器')+substr_count($articul,'场效应管');
    $tongyuannum2=substr_count($articul,'卷积')+substr_count($articul,'互信息')+substr_count($articul,'傅里叶')+substr_count($articul,'傅立叶')
        +substr_count($articul,'信道')+substr_count($articul,'信源')+substr_count($articul,'香农')+substr_count($articul,'噪声')
        +substr_count($articul,'滤波')+substr_count($articul,'IIR')+substr_count($articul,'量化')+substr_count($articul,'FIR')+substr_count($articul,'载波');
    $tongxinnum2=substr_count($articul,'以太网')+substr_count($articul,'衰落')+substr_count($articul,'复用')+substr_count($articul,'GSM')+substr_count($articul,'4G')+substr_count($articul,'5G')+substr_count($articul,'蜂窝')+substr_count($articul,'基站')
        +substr_count($articul,'多径')+substr_count($articul,'扩频');
    $diancinum2=substr_count($articul,'电荷')+substr_count($articul,'磁场')+substr_count($articul,'线圈')+substr_count($articul,'电势')+substr_count($articul,'麦克斯韦')+substr_count($articul,'通量')+substr_count($articul,'库伦');
    $bianchengnum2=substr_count($articul,'指针')+substr_count($articul,'变量')+substr_count($articul,'类型')+substr_count($articul,'数组')+substr_count($articul,'PHP')+substr_count($articul,'php')+substr_count($articul,'Pyhton')+substr_count($articul,'python')
        +substr_count($articul,'html')+substr_count($articul,'Html')+substr_count($articul,'js')+substr_count($articul,'JS')+substr_count($articul,'javascript')+substr_count($articul,'css')+substr_count($articul,'chart');
    $jisuanjijichunum2=substr_count($articul,'操作系统')+substr_count($articul,'Linux')+substr_count($articul,'DOS')+substr_count($articul,'微软')+substr_count($articul,'CPU')+substr_count($articul,'磁场');
    $webnum2=substr_count($articul,'路由器')+substr_count($articul,'网络拓扑')+substr_count($articul,'OSPFv2')+substr_count($articul,'SFC')+substr_count($articul,'组播');
    global $jiqixuexicount,$jisuanjishijuecount,$tuijiancount,$danpianjicount,$dianlufenxicount,$shuzidianlucount,$tongyuancount,$tongxincount,$diancicount,
           $bianchengcount,$jisuanjijichucount,$webcount;
    $jiqixuexicount=$jiqixuexinum1*2+$jiqixuexinum2;
    $jisuanjishijuecount=$jisuanjishijuenum1*2+$jisuanjishijuenum2;
    $tuijiancount=$tuijiannum1*2+$tuijiannum2;
    $dianlufenxicount=$dianlufenxinum1*2+$dianlufenxinum2;
    $danpianjicount=$danpianjinum1*2+$danpianjinum2;
    $shuzidianlucount=$shuzidianlunum1*2+$shuzidianlunum2;
    $tongyuancount=$tongyuannum1*2+$tongyuannum2;
    $tongxincount=$tongxinnum1*2+$tongxinnum2;
    $diancicount=$diancinum1*2+$diancinum2;
    $bianchengcount=$bianchengnum1*2+$bianchengnum2;
    $jisuanjijichucount=$jisuanjijichunum1*2+$jisuanjijichunum2;
    $webcount=$webnum1*2+$webnum2;

    return $score="$jiqixuexicount,$jisuanjishijuecount,$tuijiancount,$dianlufenxicount,$danpianjicount,$shuzidianlucount,$tongyuancount,$tongxincount,$diancicount,$bianchengcount,$jisuanjijichucount,$webcount";

}
function good(){
    $socre=explode(",",getinterest());
    $jiqixuexicount=$socre[0];
    $jisuanjishijuecount=$socre[1];
    $tuijiancount=$socre[2];
    $dianlufenxicount=$socre[3];
    $danpianjicount=$socre[4];
    $shuzidianlucount=$socre[5];
    $tongyuancount=$socre[6];
    $tongxincount=$socre[7];
    $diancicount=$socre[8];
    $bianchengcount=$socre[9];
    $jisuanjijichucount=$socre[10];
    $webcount=$socre[11];
    global $wpdb;
    $jiqixuexiaverage=$wpdb->get_var( "SELECT round(avg(jiqixuexicount),2) FROM ".COUNT_TABLE." ");
    $jisuanjishijueaverage=$wpdb->get_var( "SELECT round(avg(jisuanjishijuecount),2) FROM ".COUNT_TABLE." ");
    $tuijianaverage=$wpdb->get_var( "SELECT round(avg(tuijiancount),2) FROM ".COUNT_TABLE." ");
    $dianlufenxiaverage=$wpdb->get_var( "SELECT round(avg(dianlufenxicount),2) FROM ".COUNT_TABLE." ");
    $danpianjiaverage=$wpdb->get_var( "SELECT round(avg(danpianjicount),2) FROM ".COUNT_TABLE." ");
    $shuzidianluaverage=$wpdb->get_var( "SELECT round(avg(shuzidianlucount),2) FROM ".COUNT_TABLE." ");
    $tongyuanaverage=$wpdb->get_var( "SELECT round(avg(tongyuancount),2) FROM ".COUNT_TABLE." ");
    $tongxinaverage=$wpdb->get_var( "SELECT round(avg(tongxincount),2) FROM ".COUNT_TABLE." ");
    $dianciaverage=$wpdb->get_var( "SELECT round(avg(diancicount),2) FROM ".COUNT_TABLE." ");
    $bianchengaverage=$wpdb->get_var( "SELECT round(avg(bianchengcount),2) FROM ".COUNT_TABLE." ");
    $jisuanjijichuaverage=$wpdb->get_var( "SELECT round(avg(jisuanjijichucount),2) FROM ".COUNT_TABLE." ");
    $webaverage=$wpdb->get_var( "SELECT round(avg(webcount),2) FROM ".COUNT_TABLE." ");
    $average[0]=$jiqixuexiaverage;$average[1]=$jisuanjishijueaverage;$average[2]=$tuijianaverage;$average[3]=$dianlufenxiaverage;$average[4]=$danpianjiaverage;
    $average[5]=$shuzidianluaverage;$average[6]=$tongyuanaverage;$average[7]=$tongxinaverage;$average[8]=$dianciaverage;$average[9]=$bianchengaverage;
    ;$average[10]=$jisuanjijichuaverage;$average[11]=$webaverage;
    for ($i=0;$i<12;$i++){
        if ($socre[$i]>$average[$i])
            $strength[$i]=1;
        else
            $strength[$i]=0;
    }
    $strcount=0;
    for ($i=0;$i<12;$i++){
        if ($strength[$i]==1)
            $strcount++;
    }
    $des=0;
    for ($i=0;$i<12;$i++){
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
    $jiqixuexicount=$socre[0];
    $jisuanjishijuecount=$socre[1];
    $tuijiancount=$socre[2];
    $dianlufenxicount=$socre[3];
    $danpianjicount=$socre[4];
    $shuzidianlucount=$socre[5];
    $tongyuancount=$socre[6];
    $tongxincount=$socre[7];
    $diancicount=$socre[8];
    $bianchengcount=$socre[9];
    $jisuanjijichucount=$socre[10];
    $webcount=$socre[11];
    $good = array_search(max($socre), $socre);
    $notgood=array_search(min($socre), $socre);
    switch($good)
    {   case 0:    $goodat="机器学习";    break;
        case 1:    $goodat="计算机视觉";    break;
        case 2:    $goodat="推荐系统";      break;
        case 3:    $goodat="电路分析";      break;
        case 4:    $goodat="单片机";      break;
        case 5:    $goodat="数字电路";        break;
        case 6:    $goodat="通信原理";      break;
        case 7:    $goodat="移动通信";      break;
        case 8:    $goodat="电磁波";      break;
        case 9:    $goodat="编程语言";      break;
        case 10:    $goodat="计算机基础";      break;
        case 11:    $goodat="网络";      break;
       }
    switch($notgood)
    {   case 0:    $ngoodat="机器学习";    break;
        case 1:    $ngoodat="计算机视觉";    break;
        case 2:    $ngoodat="推荐系统";      break;
        case 3:    $ngoodat="电路分析";      break;
        case 4:    $ngoodat="单片机";      break;
        case 5:    $ngoodat="数字电路";        break;
        case 6:    $ngoodat="通信原理";      break;
        case 7:    $ngoodat="移动通信";      break;
        case 8:    $ngoodat="电磁波";      break;
        case 9:    $ngoodat="编程语言";      break;
        case 10:    $ngoodat="计算机基础";      break;
        case 11:    $ngoodat="网络";      break;
    }
    $goodornot[0]=$goodat;
    $goodornot[1]=$ngoodat;
    return $goodornot;
}
function desire(){
    $socredesire=explode(",",getdesire());
    global $wpdb;
    $jiqixuexiaverage=$wpdb->get_var( "SELECT round(avg(jiqixuexicount),2) FROM ".COUNT_TABLE." ");
    $jisuanjishijueaverage=$wpdb->get_var( "SELECT round(avg(jisuanjishijuecount),2) FROM ".COUNT_TABLE." ");
    $tuijianaverage=$wpdb->get_var( "SELECT round(avg(tuijiancount),2) FROM ".COUNT_TABLE." ");
    $dianlufenxiaverage=$wpdb->get_var( "SELECT round(avg(dianlufenxicount),2) FROM ".COUNT_TABLE." ");
    $danpianjiaverage=$wpdb->get_var( "SELECT round(avg(danpianjicount),2) FROM ".COUNT_TABLE." ");
    $shuzidianluaverage=$wpdb->get_var( "SELECT round(avg(shuzidianlucount),2) FROM ".COUNT_TABLE." ");
    $tongyuanaverage=$wpdb->get_var( "SELECT round(avg(tongyuancount),2) FROM ".COUNT_TABLE." ");
    $tongxinaverage=$wpdb->get_var( "SELECT round(avg(tongxincount),2) FROM ".COUNT_TABLE." ");
    $dianciaverage=$wpdb->get_var( "SELECT round(avg(diancicount),2) FROM ".COUNT_TABLE." ");
    $bianchengaverage=$wpdb->get_var( "SELECT round(avg(bianchengcount),2) FROM ".COUNT_TABLE." ");
    $jisuanjijichuaverage=$wpdb->get_var( "SELECT round(avg(jisuanjijichucount),2) FROM ".COUNT_TABLE." ");
    $webaverage=$wpdb->get_var( "SELECT round(avg(webcount),2) FROM ".COUNT_TABLE." ");
    $average[0]=$jiqixuexiaverage;$average[1]=$jisuanjishijueaverage;$average[2]=$tuijianaverage;$average[3]=$dianlufenxiaverage;$average[4]=$danpianjiaverage;
    $average[5]=$shuzidianluaverage;$average[6]=$tongyuanaverage;$average[7]=$tongxinaverage;$average[8]=$dianciaverage;$average[9]=$bianchengaverage;
    ;$average[10]=$jisuanjijichuaverage;$average[11]=$webaverage;
    for ($i=0;$i<12;$i++){
        if ($socredesire[$i]>$average[$i])
            $strength[$i]=1;
        else
            $strength[$i]=0;
    }
    $des=0;
    for ($i=0;$i<12;$i++){
        if ($socredesire[$i]!=0)
            $des++;
    }
    $strcount=0;
    for ($i=0;$i<12;$i++){
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
    {   case 0:    $goodat="机器学习";    break;
        case 1:    $goodat="计算机视觉";    break;
        case 2:    $goodat="推荐系统";      break;
        case 3:    $goodat="电路分析";      break;
        case 4:    $goodat="单片机";      break;
        case 5:    $goodat="数字电路";        break;
        case 6:    $goodat="通信原理";      break;
        case 7:    $goodat="移动通信";      break;
        case 8:    $goodat="电磁波";      break;
        case 9:    $goodat="编程语言";      break;
        case 10:    $goodat="计算机基础";      break;
        case 11:    $goodat="网络";      break;
    }
    switch($notdesire)
    {   case 0:    $ngoodat="机器学习";    break;
        case 1:    $ngoodat="计算机视觉";    break;
        case 2:    $ngoodat="推荐系统";      break;
        case 3:    $ngoodat="电路分析";      break;
        case 4:    $ngoodat="单片机";      break;
        case 5:    $ngoodat="数字电路";        break;
        case 6:    $ngoodat="通信原理";      break;
        case 7:    $ngoodat="移动通信";      break;
        case 8:    $ngoodat="电磁波";      break;
        case 9:    $ngoodat="编程语言";      break;
        case 10:    $ngoodat="计算机基础";      break;
        case 11:    $ngoodat="网络";      break;
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
