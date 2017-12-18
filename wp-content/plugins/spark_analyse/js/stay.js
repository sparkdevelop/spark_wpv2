/**
 * Created by Administrator on 2017/5/3.
 */
jQuery(document).ready( function($) {

    $("#button_stay").click( function() {
        $.ajax({
            type: "POST",
            data: "number2="+$("#number2").val()+"&action=stay_action",
            url: ajaxurl,
            async:true,

            beforeSend: function() {
                $('#stayInfo').text('计算中');
            },
            success: function(data) {
                $('#stayInfo').text(' ');
                console.log(data);
            //    var strs= new Array();
            //    strs=data.split(" ");
            //
            //    var x1=parseInt(strs[0]);var x2=parseInt(strs[1]);var x3=parseInt(strs[2]);
            //    var x4=parseInt(strs[3]);var x5=parseInt(strs[4]);var x6=parseInt(strs[5]);
            //    var x7=parseInt(strs[6]);
            //    var y1=strs[7];var y2=strs[8];var y3=strs[9];
            //    var y4=strs[10];var y5=strs[11];var y6=strs[12];
            //    var y7=strs[13];
            //    var yzhou=new Array();var xzhou=new Array();
            //
            //    yzhou[0]=x1;yzhou[1]=x2;yzhou[2]=x3;yzhou[3]=x4;yzhou[4]=x5;yzhou[5]=x6;yzhou[6]=x7;
            //    xzhou[0]=y1;xzhou[1]=y2;xzhou[2]=y3;xzhou[3]=y4;xzhou[4]=y5;xzhou[5]=y6;xzhou[6]=y7;
            //
            //
            //    var chart_stay = new Highcharts.Chart('container_stay', {
            //        title: {
            //            text: '用户停留时间图',
            //            x: -20
            //        },
            //        credits: {
            //            enabled: false
            //        },
            //        xAxis: {
            //            categories: xzhou
            //        },
            //        yAxis: {
            //            title: {
            //                text: '秒'
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
            //
            //        series: [{
            //            name: '停留时间',
            //            data: yzhou
            //        }]
            //    });
            }

        });

    });
});
