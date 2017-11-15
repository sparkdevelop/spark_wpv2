/**
 * Created by Administrator on 2017/5/3.
 */
jQuery(document).ready( function($) {

    $("button").click( function() {
        $.ajax({
            type: "POST",
            //data: {"start2": $("#start2").val()+"&action=view_action"},
            data: "start2=" +$("#start2").val() + "&action=view_action"+"&number="+$("#number").val()+"&action=view_action",
            url: ajaxurl,
            async:true,

            beforeSend: function() {
                $('#viewInfo').text('计算中');
            },
            success: function( data ) {
                $('#viewInfo').text(' ');
                var strs= new Array();
                strs=data.split(" ");
                //alert(strs[13]);
                //strs[13]=strs[13].Substring(0,strs[13].Length-1);
                var x1=parseInt(strs[0]);var x2=parseInt(strs[1]);var x3=parseInt(strs[2]);
                var x4=parseInt(strs[3]);var x5=parseInt(strs[4]);var x6=parseInt(strs[5]);
                var x7=parseInt(strs[6]);
                var y1=strs[7];var y2=strs[8];var y3=strs[9];
                var y4=strs[10];var y5=strs[11];var y6=strs[12];
                var y7=strs[13];
                var b=new Array();var c=new Array();

                b[0]=x1;b[1]=x2;b[2]=x3;b[3]=x4;b[4]=x5;b[5]=x6;b[6]=x7;
                c[0]=y1;c[1]=y2;c[2]=y3;c[3]=y4;c[4]=y5;c[5]=y6;c[6]=y7;


                var chart_view = new Highcharts.Chart('container_view', {
                    title: {
                        text: '七天用户浏览量变化图',
                        x: -20
                    },
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        categories: c
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
                        name: '浏览量',
                        data: b
                    }]
                });
            },

        });

    });
});
