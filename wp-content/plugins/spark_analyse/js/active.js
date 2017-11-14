/**
 * Created by Administrator on 2017/5/3.
 */
jQuery(document).ready( function($) {

    $("input[name='start']").blur( function() {
        $.ajax({
            type: "POST",
            data: "start=" + $(this).val() + "&action=time_action",
            url: ajaxurl,
            async:false,

            beforeSend: function() {
                $('#emailInfo').text('计算中');
            },
            success: function( data ) {
                $('#emailInfo').text(' ');
                var strs= new Array();
                strs=data.split(" ");

                var x1=parseInt(strs[0]);var x2=parseInt(strs[1]);var x3=parseInt(strs[2]);
                var x4=parseInt(strs[3]);var x5=parseInt(strs[4]);var x6=parseInt(strs[5]);
                var x7=parseInt(strs[6]);

                 var b=new Array();

                b[0]=x1;b[1]=x2;b[2]=x3;b[3]=x4;b[4]=x5;b[5]=x6;b[6]=x7;


                var chart2 = new Highcharts.Chart('container2', {
                        title: {
                            text: '七天用户活跃度变化图',
                            x: -20
                        },
                        credits: {
                            enabled: false
                        },
                        xAxis: {
                            categories: ['一', '二', '三', '四', '五', '六', '七']
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
                            name: '活跃度',
                            data: b
            }]
            });
                }
        });
//        $.ajax({
//            url: "http://localhost/wordpress/wp-content/plugins/spark_analyse/active.php",
//            data: "start=" + $(this).val() + "&action=time_action",
//            type: "POST",
//            dataType: "json",
//            async: false,
//            success: function (data) {
//                // var data1 = eval(data);
//                $('#emailInfo').html(data);
//
//                //  alert('dadasf');
////                    $("#incr_data").text($a);
////                    $("#total_data").text(data["total_data"]);
//            },
//            error: function (data) {
//
//
//            },
//            always: function (data) {
//                // alert('dadasf');
//                // $("#incr_data").text(data["incr_data"]);
//                // $("#total_data").text(data["total_data"]);
//            }
//        });

    });
});
