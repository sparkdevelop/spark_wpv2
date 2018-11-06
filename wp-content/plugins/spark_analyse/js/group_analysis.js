/**
 * Created by Administrator on 2017/5/3.
 */
jQuery(document).ready( function($) {

    $("#group_buff").click( function() {
        $.ajax({
            type: "POST",
            data: "group_number="+$("#group_number").val()+"&action=group_action",
            url: ajaxurl,
            async:false,

            beforeSend: function() {
                $('#group_Info').text('计算中');
            },
            success: function( data ) {
                $('#group_Info').text(' ');
                var strs= new Array();
                strs=data.split(" ");
                console.log(strs);
                var user=strs[0];
                console.log(user);
                if(user==0){
                    $('#is_user_low').text("查无此组");
                    $('#user_low').text("");
                }else if(user==1){
                    $('#is_user_low').text("本组低于四分的人有：0人");
                    $('#user_low').text("");
                }else if(user.length>0){
                    $('#is_user_low').text("本组低于四分的人有：");
                    for(var i=0;i<user.length;i++){
                        $('#user_low').text(user);
                    }
                }
                console.log(strs[1]);
                strs[1]=parseFloat(strs[1]); strs[2]=parseFloat(strs[2]);strs[3]=parseFloat(strs[3]);
                strs[4]=parseFloat(strs[4]); strs[5]=parseFloat(strs[5]); strs[6]=parseFloat(strs[6]);

                $('#container_team').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: '近七天的浏览量'
                    },
                    xAxis: {
                        categories: [
                            '小组平均浏览量','全网平均浏览量',strs[7],strs[8],strs[9],strs[10]
                        ],
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '浏览量'
                        }
                    },
                    tooltip: {
                        // head + 每个 point + footer 拼接成完整的 table
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} 次</b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            borderWidth: 0
                        }
                    },
                    series: [{
                        data: [strs[1],strs[2],strs[3], strs[4], strs[5], strs[6]]
                    }]
                });

            }

        });

    });
});
