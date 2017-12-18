/**
 * Created by Administrator on 2017/5/3.
 */
jQuery(document).ready( function($) {

    $("#button_team").click( function() {
        $.ajax({
            type: "POST",
            data: "team_number="+$("#team_number").val()+"&action=team_action",
            url: ajaxurl,
            async:false,

            beforeSend: function() {
                $('#team_Info').text('计算中');
            },
            success: function( data ) {
                $('#team_Info').text(' ');
                var strs= new Array();
                strs=data.split(" ");
                console.log(strs);
                var key=[];
                var value=[];
                for(var i=0;i<strs.length/2;i++){
                    key.push(strs[strs.length/2+i]);
                    value.push(parseInt(strs[i]));
                }
                console.log(key);
                console.log(value);
                $('#container_team').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: '组内成员浏览量'
                    },
                    xAxis: {
                        categories: key,
                        crosshair: true
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '浏览量'
                        }
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0,
                            borderWidth: 25
                        }
                    },
                    series: [{
                        name: '浏览量',
                        data: value
                    }]
                });

            }

        });

    });
});
