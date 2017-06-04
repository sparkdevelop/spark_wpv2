<?php
$user_id = get_current_user_id();
$jsonString = jsonGenerate($user_id);
?>
<div id="chart" style="width:800px;height: 700px"></div>
<script>
    var myChart = echarts.init(document.getElementById('chart'));
    option = null;
    myChart.showLoading();
    //var jsonURL = "<?php//get_template_directory_uri()?>/asset/test.json";
    //$.get(jsonURL, function (data) {

    var jsonString = '<?=$jsonString?>';
        myChart.hideLoading();
        //处理json数据
        var data = JSON.parse(jsonString);
        data.nodes.forEach(function (node) {
            if(node.value>100){
                node.symbolSize = node.value/15;
            }else if(node.value<10){
                node.symbolSize = node.value*5;
            }else{
                node.symbolSize = node.value;
            }
            node.label = {
                normal:{
                    show:true
                }
            }
        });
        option = {
            title: {
                text: 'My Knowledge'
                //top: 'bottom',
                //left: 'right'
            },
            tooltip: {},
            legend: [{
                data: data.categories.map(function(a) {
                    return a.name;
                })
            }],
            series: [{
                type: 'graph',      //关系图
                //name: 'My Knowledge',  //tooltip显示
                layout: 'force',  //布局怎么显示,
                animationDuration: 1500,
                animationEasingUpdate: 'quinticInOut',
                //draggable: true,
                roam: true,     //鼠标缩放和平移漫游
                focusNodeAdjacency: 'true',  //是否在鼠标移到节点上的时候突出显示节点以及节点的边和邻接节点。
                smybol: 'circle',          //节点的形状'circle', 'rect', 'roundRect', 'triangle', 'diamond', 'pin', 'arrow'
                data: data.nodes,
                links: data.links,
                categories:data.categories,
                force: {
                    edgeLength: 100,//连线的长度
                    repulsion: 100  //子节点之间的间距
                },
                label: {
                    normal: {
                        position: 'right',
                        formatter: '{b}'
                    }
                },
                lineStyle: {
                    normal: {
                        curveness: 0.3
                    }
                }
            }]
        };

        myChart.setOption(option);
    //});
</script>