/**
 * Created by Administrator on 2017/11/23.
 */
function change(){
    var x = document.getElementById("tidui");
    var y = document.getElementById("zhuangtai");
    y.options.length = 0; // 清除second下拉框的所有内容
    if(x.selectedIndex == 0)
    {
        y.options.add(new Option("繁忙", "0"));
        y.options.add(new Option("活跃", "1", false, true));  // 默认选中省会城市
    }

    if(x.selectedIndex == 1)
    {
        y.options.add(new Option("暂时搁置", "0"));
        y.options.add(new Option("努力", "1", false, true));  // 默认选中省会城市
        y.options.add(new Option("平稳", "2"));
    }
    if(x.selectedIndex == 2)
    {
        y.options.add(new Option("暂时搁置", "0"));
        y.options.add(new Option("努力", "1", false, true));  // 默认选中省会城市
        y.options.add(new Option("平稳", "2"));
    }
    if(x.selectedIndex == 3)
    {
        y.options.add(new Option("放弃", "0"));
    }
}

jQuery(document).ready( function($) {

    $("#button_tidui").click( function() {
        $.ajax({
            type: "POST",
            data: "tidui=" + $("#tidui").val() + "&action=tidui_action"+"&zhuangtai=" + $("#zhuangtai").val() + "&action=tidui_action",
            url: ajaxurl,
            async:false,

            beforeSend: function() {
                $('#tiduinum').text('计算中');
            },
            success: function( data ) {
                //console.log(data);
                var data2=data.split(" ");
                $('#tiduinum').text("该类用户共有： "+data2[0]);
                var data1 = data.split(" ")
                    .reduce(function (arr, word) {
                        var obj = arr.find(function (obj) {
                            return obj.name === word;
                        });
                        if (obj) {
                            obj.weight += 1;
                        } else {
                            obj = {
                                name: word,
                                weight: 1
                            };
                            arr.push(obj);
                        }
                        return arr;
                    }, []);
                var chart_tidui=new Highcharts.Chart('container_tidui', {
                    series: [{
                        type: 'wordcloud',
                        data: data1
                    }],
                    title: {
                        text: '词云图'
                    }
                });
            }
        });


    });
});