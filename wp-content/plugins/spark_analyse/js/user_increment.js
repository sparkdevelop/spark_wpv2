/**
 * Created by hmmoshang on 16/11/28.
 */
// require_once ("try.php");

$(function () {
    // 获取用户想要观察的数据源



        function  useIncrementAjax(time) {



            $.ajax({
                url: "http://localhost/wordpress/wp-content/plugins/user_active/try.php",
                data: time,
                type: "POST",
                dataType: "json",
                async: false,
                success: function (data) {
                    // var data1 = eval(data);

                    $("#result").text(data['incr']);
                    $("#result2").text(data['total']);


//                    $("#incr_data").text($a);
//                    $("#total_data").text(data["total_data"]);
                },
                error: function (data) {


                },
                always: function (data) {

                    // $("#incr_data").text(data["incr_data"]);
                    // $("#total_data").text(data["total_data"]);
                }
            })
        }

    var target_click;
    $(".table-hover th button:lt(2)").each(function () {
        $(this).click(function () {
            target_click = $(this).text();
        })
    });
    // 下拉列表的切换
    $(".table-hover th button:gt(2)").each(function () {
        $("ul li a").click(function () {
            $(this).parents("ul").siblings("button").find("a").text($(this).text());
            $(this).parents("ul").siblings("button").find("a").css("color", "white");
            // $(this).text($(this).parents("ul").siblings("button").text());
        })
    });


// 最开始数据的展现来源
    function jsonToArray(arr_like) {
        var length = arr_like.length;
        for (i = 0; i < length; i++) {
            arr_like[i] = parseInt(arr_like[i]);
        }
        return arr_like;
    }


    // obj_incr = {
    //     show_data: jsonToArray(JSON.parse($("#incr_data").text())),
    //     //show_data:[7.0, 6.9, 9.5c, 14.5, 18.2, 21.5, 25.2],
    //     show_date: $("#date1").val().split("至")[1]
    // };
    //
    // obj_tot = {
    //     show_data: JSON.parse($("#total_data").text()),
    //     show_date: $("#date1").val().split("至")[1]
    // };


// 获取最近七天,三天,现在,三十天的时间
    var myDate = new Date();
    var year = myDate.getFullYear();
    var month = myDate.getMonth() + 1;
    var date = myDate.getDate();
    // if (month >= 1 && month <= 9) {
    //     month = "0" + month;
    // }
    if (date >= 0 && date <= 9) {
        date = "0" + date;
    }
    var now = year + '-' + '0' + month + '-' + date;
    var myDate1 = new Date(myDate.getTime() - 6 * 24 * 3600 * 1000);
    var year1 = myDate1.getFullYear();
    var month1 = myDate1.getMonth() + 1;
    var date1 = myDate1.getDate();
    // if (month1 >= 1 && month1 <= 9) {
    //     month1 = "0" + month1;
    // }
    if (date1 >= 0 && date1 <= 9) {
        date1 = "0" + date1;
    }
    var se_before = year1 + '-' + '0' + month1 + '-' + date1;
    var myDate2 = new Date(myDate.getTime() - 2 * 24 * 3600 * 1000);
    var year2 = myDate2.getFullYear();
    var month2 = myDate2.getMonth() + 1;
    var date2 = myDate2.getDate();
    // if (month2 >= 1 && month2 <= 9) {
    //     month2 = "0" + month;
    // }
    if (date2 >= 0 && date2 <= 9) {
        date2 = "0" + date2;
    }
    var th_before = year2 + '-' + '0' + month2 + '-' + date2;
    var myDate3 = new Date(myDate.getTime() - 29 * 24 * 3600 * 1000);
    var year3 = myDate3.getFullYear();
    var month3 = myDate3.getMonth() + 1;
    var date3 = myDate3.getDate();
    // if (month3 >= 1 && month3 <= 9) {
    //     month3 = "0" + month;
    // }
    if (date3 >= 0 && date3 <= 9) {
        date3 = "0" + date3;
    }
    var ten_before = year3 + '-' + '0' + month3 + '-' + date3;
// 最开始绘图

    var tdate_start = se_before.split("-")[0] + se_before.split("-")[1] + se_before.split("-")[2];
    var tdate_end = now.split("-")[0] + now.split("-")[1] + now.split("-")[2];
    var period = tdate_end - tdate_start + 1;
    var time_p = [];
    var a, b, c;

    for (var i = 0; i < 7; i++) {
        a = parseInt(tdate_start) + i;
        c = a.toString();
        b = c.substr(0, 4) + '-' + c.substr(4, 2) + '-' + c.substr(6, 2);
        time_p.push(b);
    }
    for (var j = 0; j < 7; j++) {
        $(".table-bordered tbody").append("<tr><td>" + time_p[j] + "</td><td>3</td><td>5</td></tr>");
    }

// 选择栏选择样式切换
    $(".table-hover th button").each(function () {
        $(this).click(function () {
            // $(this).css("background-color","");
            // $(this).css("color","");
            $(this).find("a").css("color", "white");
            $(".table-hover th button").removeClass("clicking");
            $(this).parents("th").siblings("th").find("a").css("color", "black");
            $(this).addClass("clicking");
        })
    });


    var ajax_date = {
        stime: se_before,
        etime:now
    };

    console.info(ajax_date);

    useIncrementAjax(ajax_date);
    data = $("#result").text().split(",");
    var obj = {
        text: target_click,
        date: se_before,
        data: jsonToArray(data)
    };

    $('#container1').highcharts({
        credits:{
            enabled:false
        },
        title: {
            text: '用户变化曲线',
            x: -20 //center
        },
        subtitle: {
            text: '新增用户数',
            x: -20
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                day: '%Y-%m-%e'
            }},
        yAxis: {
            type: 'linear',
            tickColor:'red',
            tickLength:'20px',
            title: {
                text: '人数'
            },
            // plotLines: [{
            //     value: 3,
            //     width: 2,
            //     color: 'red',
            //     dashStyle:'solid'
            // }]
        },
        tooltip: {
            xDateFormat: '%Y-%m-%d'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '新增用户数',
            data: obj.data,
            pointStart: Date.UTC(obj.date.split("-")[0],obj.date.split("-")[1] - 1,obj.date.split("-")[2]),
            pointInterval: 24 * 3600 * 1000
        }]
    });
//
// 折线图函数
    function useIncrementChart(obj) {

        $('#container1').highcharts({
            credits: {
                enabled: false
            },
            title: {
                text: '用户变化曲线',
                x: -20 //center
            },
            subtitle: {
                text: obj.text,
                x: -20
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    day: '%Y-%m-%e'
                }
            },
            yAxis: {
                title: {
                    text: '人数'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {xDateFormat: '%Y-%m-%d'},
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                type: "line",
                name: obj.text,
                data: obj.data,
                pointStart: Date.UTC(obj.date.split('-')[0], obj.date.split('-')[1] - 1, obj.date.split('-')[2]),
                pointInterval: 24 * 3600 * 1000

            }]
        });


    }

// 柱状图函数
    function useIncrementChart1(obj) {

        $('#container2').highcharts({
            credits: {
                enabled: false
            },
            title: {
                text: '用户变化曲线',
                x: -20 //center
            },
            subtitle: {
                text: obj.text,
                x: -20
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    day: '%Y-%m-%e'
                }
            },
            yAxis: {
                title: {
                    text: '人数'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {xDateFormat: '%Y-%m-%d'},
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                type: "line",
                name: obj.text,
                data: obj.data,
                pointStart: Date.UTC(obj.date.split('-')[0], obj.date.split('-')[1] - 1, obj.date.split('-')[2]),
                pointInterval: 24 * 3600 * 1000

            }]
        });


    }

    function usebarChart(obj) {

        $('#container1').highcharts({
            credits: {
                enabled: false
            },
            title: {
                text: '用户变化曲线',
                x: -20 //center
            },
            subtitle: {
                text: obj.text,
                x: -20
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    day: '%Y-%m-%e'
                }
            },
            yAxis: {
                title: {
                    text: '人数'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {xDateFormat: '%Y-%m-%d'},
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                type: "column",
                name: obj.text,
                data: obj.data,
                pointStart: Date.UTC(obj.date.split('-')[0], obj.date.split('-')[1] - 1, obj.date.split('-')[2]),
                pointInterval: 24 * 3600 * 1000

            }]
        });


    }

    function usebarChart1(obj) {

        $('#container2').highcharts({
            credits: {
                enabled: false
            },
            title: {
                text: '用户变化曲线',
                x: -20 //center
            },
            subtitle: {
                text: obj.text,
                x: -20
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    day: '%Y-%m-%e'
                }
            },
            yAxis: {
                title: {
                    text: '人数'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {xDateFormat: '%Y-%m-%d'},
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                type: "column",
                name: obj.text,
                data: obj.data,
                pointStart: Date.UTC(obj.date.split('-')[0], obj.date.split('-')[1] - 1, obj.date.split('-')[2]),
                pointInterval: 24 * 3600 * 1000

            }]
        });


    }


    $("#new_increment").click(function () {

        if ($(".active th button:eq(2)").find("a").text() == "最近三十天") {
            var date = ten_before;
            var date1 = now;
        } else if ($(".active th button:eq(2)").find("a").text() == "最近三天") {
            var date = th_before;
            var date1 = now;
        } else if ($(".active th button:eq(2)").find("a").text() == "最近七天") {
            var date = se_before;
            var date1 = now;
        }
        // var date_start = date.split("-")[0] + date.split("-")[1] + date.split("-")[2];
        // var date_end = date1.split("-")[0] + date1.split("-")[1] + date1.split("-")[2];



        var ajax_date = {
            stime: date,
            etime: date1
        };

console.info(ajax_date);

        useIncrementAjax(ajax_date);
        console.info($("#result").text().split(","));

        var text = $("#new_increment").text();


        if ($.trim(text) == "新增用户数") {
            data = $("#result").text().split(",");

        }
        // else{
        //     data = $("#total_data").text();
        // }
        var obj = {
            text: text,
            date: date,
            data: jsonToArray(data)
        };


        if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
            usebarChart(obj);
        } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {

            useIncrementChart(obj);
        }

    });
    $("#retain").click(function () {
        if ($(".retain th button:eq(1)").find("a").text() == "最近三十天") {
            var date = ten_before;
            var date1 = now;
        } else if ($(".retain th button:eq(1)").find("a").text() == "最近三天") {
            var date = th_before;
            var date1 = now;
        } else if ($(".retain th button:eq(1)").find("a").text() == "最近七天") {
            var date = se_before;
            var date1 = now;
        }
        var date_start = date.split("-")[0] + date.split("-")[1] + date.split("-")[2];
        var date_end = date1.split("-")[0] + date1.split("-")[1] + date1.split("-")[2];



        var ajax_date = {
            start_date: date_start,
            end_date: date_end
        };

        useIncrementAjax(ajax_date);


        data = $("#incr_data").text();


        // else{
        //     data = $("#total_data").text();
        // }
        var obj = {
            text: text,
            date: date,
            data: jsonToArray(JSON.parse(data))
        };


        if ($(".retain th button:eq(2)").find("a").text() == "柱状图") {
            usebarChart1(obj);
        } else if ($(".retain th button:eq(2)").find("a").text() == "折线图") {
            useIncrementChart1(obj);
        }

    });
    // 时间对比点击
    $("#compare").click(function () {
        var date = $.trim($("#date1").text().split("至")[0]);
        var date1 = $.trim($("#date1").text().split("至")[1]);


        var ajax_date = {
            stime: date,
            etime: date1
        };
console.info(ajax_date);
        useIncrementAjax(ajax_date);

        var text = target_click;
        if (target_click == "新增用户数") {
            data = $("#result").text().split(",");
            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };
            if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
                usebarChart(obj);
            } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {
                useIncrementChart(obj);
            }
        } else if (target_click == "总用户数") {
            data = $("#result2").text().split(",");
            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };

            if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
                usebarChart(obj);
            } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {
                useIncrementChart(obj);
            }
        }


    });

    $("#compare1").click(function () {
        var date = $.trim($("#date1").text().split("至")[0]);
        var date1 = $.trim($("#date1").text().split("至")[1]);
        var date_start = date.split("-")[0] + date.split("-")[1] + date.split("-")[2];
        var date_end = date1.split("-")[0] + date1.split("-")[1] + date1.split("-")[2];


        var ajax_date = {
            start_date: date_start,
            end_date: date_end
        };

        useIncrementAjax(ajax_date);


        data = $("#incr_data").text();
        var obj = {
            text: "日留存率",
            date: date,
            data: jsonToArray(JSON.parse(data))
        };
        if ($(".retain th button:eq(2)").find("a").text() == "柱状图") {
            usebarChart1(obj);
        } else if ($(".retain th button:eq(2)").find("a").text() == "折线图") {
            useIncrementChart1(obj);
        }

    });
// 总用户数点击
    $("#total_num").click(function () {
        if ($(".active th button:eq(2)").find("a").text() == "最近三十天") {
            var date = ten_before;
            var date1 = now;
        } else if ($(".active th button:eq(2)").find("a").text() == "最近三天") {
            var date = th_before;
            var date1 = now;
        } else if ($(".active th button:eq(2)").find("a").text() == "最近七天") {
            var date = se_before;
            var date1 = now;
        }




        var ajax_date = {
            stime: date,
            etime: date1
        };

        useIncrementAjax(ajax_date);

        var text = $("#total_num").text();


        if ($.trim(text) == "总用户数") {
            data = $("#result2").text().split(",");
            console.info(data);
        }

        var obj = {
            text: text,
            date: date,
            data: jsonToArray(data)
        };

        if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
            usebarChart(obj);
        } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {
            useIncrementChart(obj);
        }

    });

    $("#three").click(function () {
        var date = th_before;
        var date1 = now;


        var ajax_date = {
            stime: date,
            etime:date1
        };
console.info(ajax_date);
        useIncrementAjax(ajax_date);

        var text = target_click;
        if (target_click == "新增用户数") {
            data = $("#result").text().split(",");
            console.info(data);
            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };

            if ($(".active th button:eq(3)").find("a").text() == "柱状图") {

                usebarChart(obj);
            } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {

                useIncrementChart(obj);
            }
        } else if (target_click == "总用户数") {
            data = $("#result2").text().split(",");
            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };

            if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
                usebarChart(obj);
            } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {
                useIncrementChart(obj);
            }
        }
        // else {
        //     data = $("#result").text().split(",");
        //     var obj = {
        //         text: "新增用户数",
        //         date: date,
        //         data: jsonToArray(data)
        //     };
        //
        //     if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
        //         usebarChart(obj);
        //     } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {
        //         useIncrementChart(obj);
        //     }
        // }


    });
    $("#rthree").click(function () {
        var date = th_before;
        var date1 = now;



        var ajax_date = {
            stime: date,
            etime: date1
        };

        useIncrementAjax(ajax_date);


        data = $("#incr_data").text();
        var obj = {
            text: "日留存率",
            date: date,
            data: jsonToArray(JSON.parse(data))
        };

        if ($(".retain th button:eq(2)").find("a").text() == "柱状图") {

            usebarChart1(obj);
        } else if ($(".retain th button:eq(2)").find("a").text() == "折线图") {

            useIncrementChart1(obj);
        }


        // var obj={
        //     text:text,
        //     date:date,
        //     data:jsonToArray(JSON.parse(data))
        // };
        //
        // useIncrementChart(obj);

    });

    $("#rseven").click(function () {
        var date = se_before;
        var date1 = now;
        var date_start = date.split("-")[0] + date.split("-")[1] + date.split("-")[2];
        var date_end = date1.split("-")[0] + date1.split("-")[1] + date1.split("-")[2];



        var ajax_date = {
            start_date: date_start,
            end_date: date_end
        };

        useIncrementAjax(ajax_date);


        data = $("#incr_data").text();
        var obj = {
            text: "日留存率",
            date: date,
            data: jsonToArray(JSON.parse(data))
        };

        if ($(".retain th button:eq(2)").find("a").text() == "柱状图") {

            usebarChart1(obj);
        } else if ($(".retain th button:eq(2)").find("a").text() == "折线图") {

            useIncrementChart1(obj);
        }




    });

    $("#rth_ten").click(function () {
        var date = ten_before;
        var date1 = now;
        var date_start = date.split("-")[0] + date.split("-")[1] + date.split("-")[2];
        var date_end = date1.split("-")[0] + date1.split("-")[1] + date1.split("-")[2];



        var ajax_date = {
            start_date: date_start,
            end_date: date_end
        };

        useIncrementAjax(ajax_date);


        data = $("#incr_data").text();
        var obj = {
            text: "日留存率",
            date: date,
            data: jsonToArray(JSON.parse(data))
        };
        if ($(".retain th button:eq(2)").find("a").text() == "柱状图") {

            usebarChart1(obj);
        } else if ($(".retain th button:eq(2)").find("a").text() == "折线图") {

            useIncrementChart1(obj);
        }


        // var obj={
        //     text:text,
        //     date:date,
        //     data:jsonToArray(JSON.parse(data))
        // };
        //
        // useIncrementChart(obj);

    });
    $("#th_ten").click(function () {
        var date = ten_before;
        var date1 = now;




        var ajax_date = {
            stime: date,
            etime: date1
        };
console.info(ajax_date);
        useIncrementAjax(ajax_date);

        var text = target_click;
        if (target_click == "新增用户数") {
            data = $("#result").text().split(",");

            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };

            if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
                usebarChart(obj);
            } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {
                useIncrementChart(obj);
            }
        } else if (target_click == "总用户数") {
            data =$("#result2").text().split(",");
            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };

            if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
                usebarChart(obj);
            } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {
                useIncrementChart(obj);
            }
        }
        // else {
        //     data = $("#result").text().split(",");
        //     var obj = {
        //         text: "新增用户数",
        //         date: date,
        //         data: jsonToArray(data)
        //     };
        //
        //     if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
        //         usebarChart(obj);
        //     } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {
        //         useIncrementChart(obj);
        //     }
        // }



    });
    $("#seven").click(function () {
        var date = se_before;
        var date1 = now;




        var ajax_date = {
            stime: date,
            etime: date1
        };

        useIncrementAjax(ajax_date);
        var text = target_click;
        if (target_click == "新增用户数") {
            data = $("#result").text().split(",");
            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };

            if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
                usebarChart(obj);
            } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {
                useIncrementChart(obj);
            }
        } else if (target_click == "总用户数") {
            data = $("#result2").text().split(",");
            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };
            if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
                usebarChart(obj);
            } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {
                useIncrementChart(obj);
            }
        }
        // else {
        //     data = $("#result").text().split(",");
        //     var obj = {
        //         text: "新增用户数",
        //         date: date,
        //         data: jsonToArray(data)
        //     };
        //
        //     if ($(".active th button:eq(3)").find("a").text() == "柱状图") {
        //         usebarChart(obj);
        //     } else if ($(".active th button:eq(3)").find("a").text() == "折线图") {
        //         useIncrementChart(obj);
        //     }
        // }


    });
    $("#line").click(function () {
        if ($(".active th button:eq(2)").find("a").text() == "最近三十天") {
            var date = ten_before;
            var date1 = now;
        } else if ($(".active th button:eq(2)").find("a").text() == "最近三天") {
            var date = th_before;
            var date1 = now;
        } else {
            var date = $.trim($("#date1").text().split("至")[0]);
            var date1 = $.trim($("#date1").text().split("至")[1]);
        }



        var ajax_date = {
            stime: date,
            etime: date1
        };

        useIncrementAjax(ajax_date);

        var text = target_click;

        if (target_click == "新增用户数") {
            data = $("#result").text().split(",");
            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };

            useIncrementChart(obj);
        } else if (target_click == "总用户数") {
            data = $("#result2").text().split(",");
            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };

            useIncrementChart(obj);
        }
        // else {
        //     data = $("#result").text().split(",");
        //     var obj = {
        //         text: "新增用户数",
        //         date: date,
        //         data: jsonToArray(data)
        //     };
        //
        //     useIncrementChart(obj);
        // }

    });
    $("#rline").click(function () {

        if ($(".retain th button:eq(1)").find("a").text() == "最近三十天") {
            var date = ten_before;
            var date1 = now;
        } else if ($(".retain th button:eq(1)").find("a").text() == "最近三天") {
            var date = th_before;
            var date1 = now;
        } else {
            var date = $.trim($("#date1").text().split("至")[0]);
            var date1 = $.trim($("#date1").text().split("至")[1]);
        }
        var date_start = date.split("-")[0] + date.split("-")[1] + date.split("-")[2];
        var date_end = date1.split("-")[0] + date1.split("-")[1] + date1.split("-")[2];



        var ajax_date = {
            start_date: date_start,
            end_date: date_end
        };

        useIncrementAjax(ajax_date);


        data = $("#incr_data").text();
        var obj = {
            text: "日留存率",
            date: date,
            data: jsonToArray(JSON.parse(data))
        };

        useIncrementChart1(obj);

    });

    $("#rsqure").click(function () {
        if ($(".retain th button:eq(1)").find("a").text() == "最近三十天") {
            var date = ten_before;
            var date1 = now;
        } else if ($(".retain th button:eq(1)").find("a").text() == "最近三天") {
            var date = th_before;
            var date1 = now;
        } else {
            var date = $.trim($("#date1").text().split("至")[0]);
            var date1 = $.trim($("#date1").text().split("至")[1]);
        }
        var date_start = date.split("-")[0] + date.split("-")[1] + date.split("-")[2];
        var date_end = date1.split("-")[0] + date1.split("-")[1] + date1.split("-")[2];



        var ajax_date = {
            start_date: date_start,
            end_date: date_end
        };

        useIncrementAjax(ajax_date);


        data = $("#incr_data").text();
        var obj = {
            text: "日留存率",
            date: date,
            data: jsonToArray(JSON.parse(data))
        };

        usebarChart1(obj);

    });
    $("#squre").click(function () {
        if ($(".active th button:eq(2)").find("a").text() == "最近三十天") {
            var date = ten_before;
            var date1 = now;
        } else if ($(".active th button:eq(2)").find("a").text() == "最近三天") {
            var date = th_before;
            var date1 = now;
        } else if ($(".active th button:eq(2)").find("a").text() == "最近七天"){
            var date = se_before;
            var date1 = now;
        }else{
            var date = $.trim($("#date1").text().split("至")[0]);
            var date1 = $.trim($("#date1").text().split("至")[1]);
        }




        var ajax_date = {
            stime: date,
            etime: date1
        };

        useIncrementAjax(ajax_date);

        var text = target_click;
        if (target_click == "新增用户数") {
            data = $("#result").text().split(",");

            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };

            usebarChart(obj);
        } else if (target_click == "总用户数") {
            data = $("#result2").text().split(",");
            var obj = {
                text: text,
                date: date,
                data: jsonToArray(data)
            };

            usebarChart(obj);
        }
        // else {
        //     data = $("#result").text().split(",");
        //     var obj = {
        //         text: "新增用户数",
        //         date: date,
        //         data: jsonToArray(data)
        //     };
        //
        //     usebarChart(obj);
        // }

    });
// });


});
