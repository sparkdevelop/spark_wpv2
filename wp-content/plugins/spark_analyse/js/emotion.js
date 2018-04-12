/**
 * Created by Administrator on 2018/3/27/027.
 */
jQuery(document).ready( function($) {

    $("#button_group").click( function() {
        $.ajax({
            type: "POST",
            data: "group_number="+$("#group_number").val()+"&action=emotion_action",
            url: ajaxurl,
            async:true,

            beforeSend: function() {
                $('#emotion_buff').text('查询中');
                button_group.disabled =true;
            },
            success: function( data ) {
                $('#emotion_buff').text(' ');
                button_group.disabled = false;
                console.log(data);
                var a=eval(data);
                console.log( a);

                var chart = Highcharts.chart('container_emotion1', {
                    chart: {
                        type: 'spline'
                    },
                    title: {
                        text: a[0]
                    },
                    xAxis: {
                        categories: a[1]
                    },
                    yAxis: {
                        title: {
                            text: '分数'
                        }
                    },
                    tooltip: {
                        crosshairs: true,
                        shared: true
                    },
                    plotOptions: {
                        spline: {
                            marker: {
                                radius: 4,
                                lineColor: '#666666',
                                lineWidth: 1
                            }
                        }
                    },
                    series: [{
                        name: '情感',
                        marker: {
                            symbol: 'square'
                        },
                        data: a[2]
                    }]
                });
///////////////////////////////////////////////////////////////////////////
//                var time2_old =
//
//                var time2 = [];
//                for (var i2 in time) {
//                    time2.push(time[i2]); //属性
//                }
//                var score2_old =
//
//                var score2 = [];
//                var j2;
//                for (var ii2 in score) {
//                    j2 = parseFloat(score[ii2]);
//                    score2.push(j2); //属性
//                }
                var chart2 = Highcharts.chart('container_emotion2', {
                    chart: {
                        type: 'spline'
                    },
                    title: {
                        text: a[3]
                    },
                    xAxis: {
                        categories: a[4]
                    },
                    yAxis: {
                        title: {
                            text: '分数'
                        }
                    },
                    tooltip: {
                        crosshairs: true,
                        shared: true
                    },
                    plotOptions: {
                        spline: {
                            marker: {
                                radius: 4,
                                lineColor: '#666666',
                                lineWidth: 1
                            }
                        }
                    },
                    series: [{
                        name: '情感',
                        marker: {
                            symbol: 'square'
                        },
                        data: a[5]
                    }]
                });
                //////////////////////////////////////////////////////

                var chart3 = Highcharts.chart('container_emotion3', {
                    chart: {
                        type: 'spline'
                    },
                    title: {
                        text: a[6]
                    },
                    xAxis: {
                        categories: a[7]
                    },
                    yAxis: {
                        title: {
                            text: '分数'
                        }
                    },
                    tooltip: {
                        crosshairs: true,
                        shared: true
                    },
                    plotOptions: {
                        spline: {
                            marker: {
                                radius: 4,
                                lineColor: '#666666',
                                lineWidth: 1
                            }
                        }
                    },
                    series: [{
                        name: '情感',
                        marker: {
                            symbol: 'square'
                        },
                        data: a[8]
                    }]
                });
                ///////////////////////////////////////////////////////////////
                //var time4_old =
                //<
                //? php echo
                //json_encode($time);
                //?
                //>
                //;
                //var time4 = [];
                //for (var i4 in time) {
                //    time4.push(time[i4]); //属性
                //}
                //var score4_old =
                //<
                //? php echo
                //json_encode($score);
                //?
                //>
                //;
                //var score4 = [];
                //var j4;
                //for (var ii4 in score) {
                //    j4 = parseFloat(score[ii4]);
                //    score4.push(j4); //属性
                //}
                if(a.length>9) {
                    var chart4 = Highcharts.chart('container_emotion4', {
                        chart: {
                            type: 'spline'
                        },
                        title: {
                            text: a[9]
                        },
                        xAxis: {
                            categories: a[10]
                        },
                        yAxis: {
                            title: {
                                text: '分数'
                            }
                        },
                        tooltip: {
                            crosshairs: true,
                            shared: true
                        },
                        plotOptions: {
                            spline: {
                                marker: {
                                    radius: 4,
                                    lineColor: '#666666',
                                    lineWidth: 1
                                }
                            }
                        },
                        series: [{
                            name: '情感',
                            marker: {
                                symbol: 'square'
                            },
                            data: a[11]
                        }]
                    });
                    if(a.length>12) {
                        var chart5 = Highcharts.chart('container_emotion5', {
                            chart: {
                                type: 'spline'
                            },
                            title: {
                                text: a[12]
                            },
                            xAxis: {
                                categories: a[13]
                            },
                            yAxis: {
                                title: {
                                    text: '分数'
                                }
                            },
                            tooltip: {
                                crosshairs: true,
                                shared: true
                            },
                            plotOptions: {
                                spline: {
                                    marker: {
                                        radius: 4,
                                        lineColor: '#666666',
                                        lineWidth: 1
                                    }
                                }
                            },
                            series: [{
                                name: '情感',
                                marker: {
                                    symbol: 'square'
                                },
                                data: a[14]
                            }]
                        });
                    }
                }
            }
            })

        });

    });

