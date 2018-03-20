/**
 * Created by zhangxue on 17/5/26.
 */

//个人主页和他人主页wiki收藏部分js
function get_favorite_wiki($user_id,$admin_url) {
    var data = {
        action: "get_user_favorite_wiki",
        user_ID: $user_id,
        get_wiki_type: "publish"
    };
    $.ajax({
        type: "POST",
        url: $admin_url,
        data: data,
        dataType: "json",
        success: function(data){
            $("#wiki_favorite").text(data.wikis.length);
            if(data.wikis.length!=0){
                $("#wiki_list").html("");
                for(var i=0;i<data.wikis.length;i++) {
                    $("#wiki_list").append("<p>"+"<a href=\"/?yada_wiki="+data.wikis[i].post_name+"\">"+data.wikis[i].post_title+"</a>"+"</p>");
                    $("#wiki_list").append("<p>"+data.wikis[i].post_content.substring(0, 30)+"..."+"</p>");
                    $("#wiki_list").append("<hr>");
                }
            }else{
                var html ='<div class="alert alert-info">'+
                    '<a href="#" class="close" data-dismiss="alert">&times;</a>'+
                    '<strong>Oops,还没有收藏!</strong>去wiki页面逛逛吧。'+
                    '</div>';
                $("#wiki_list").css('margin-top',"0px");
                $("#wiki_list").html(html);
            }
        },
        error: function() {
            alert("wiki获取失败!");
        }
    });
}

//个人主页和他人主页项目收藏部分js 改变翻页的位置css
function pageFavorite(flag) {
    if(flag==true) $("#page_favorite").css({"position":"absolute","bottom":"-15%","left":"40%"});
    else $("#page_favorite").css({"text-align":"center","margin-bottom":"20px"});
}

//header的选择搜索
function selectSearchCat(value) {
    var post_type= document.getElementById("selectPostType");
    if(value=="wiki"){
        post_type.value = "yada_wiki";
    } else if(value=="project"){
        post_type.value = "post";
    } else{
        post_type.value = "";
    }
}

//wiki和项目页面已收藏和未收藏
function setCSS(flag) {
    if(flag == 1){  //未收藏
        addFavorite();
    }else{
        cancelFavorite();
    }
}

//加入group
function join_the_group($group_id,$admin_url) {
    //ajax
    var data = {
        action: 'join_the_group',
        group_id: $group_id
    };
    $.ajax({
        //async: false,    //否则永远返回false
        type: "POST",
        url: $admin_url,
        data: data,
        dataType:"text",
        success: function (response) {
            if(response.trim()=='freejoin'){
                // var rongData = {
                //     action: 'rongCloudJoinGroup',
                //     group_id: $group_id
                // };
                // $.ajax({
                //     type: "POST",
                //     url: $admin_url,
                //     data: rongData,
                //     dataType:"json",
                //     success: function (res) {},
                //     error:function (XMLHttpRequest, textStatus, errorThrown) {
                //         // 状态码
                //         console.log(XMLHttpRequest.status);
                //         // 状态
                //         console.log(XMLHttpRequest.readyState);
                //         // 错误信息
                //         console.log(errorThrown);
                //     }
                // });
                layer.msg("您已成功加入", {time: 2000, icon: 1});
                location.reload();
            }else {
                layer.msg("申请已发送,等待管理员审核", {time: 3000, icon: 1});
            }
        },
        error:function (XMLHttpRequest, textStatus, errorThrown) {
            // 状态码
            console.log(XMLHttpRequest.status);
            // 状态
            console.log(XMLHttpRequest.readyState);
            // 错误信息
            console.log(errorThrown);
        }
    });
}

//退群
function quit_the_group($group_id,$admin_url) {
    //ajax
    var data = {
        action: 'quit_the_group',
        group_id: $group_id
    };
    $.ajax({
        //async: false,    //否则永远返回false
        type: "POST",
        url: $admin_url,
        data: data,
        success: function () {
            // var rongData = {
            //     action: 'rongCloudQuitGroup',
            //     group_id: $group_id
            // };
            // $.ajax({
            //     type: "POST",
            //     url: $admin_url,
            //     data: rongData,
            //     dataType:"json",
            //     success: function (res) {
            //     },
            //     error:function (XMLHttpRequest, textStatus, errorThrown) {
            //         // 状态码
            //         console.log(XMLHttpRequest.status);
            //         // 状态
            //         console.log(XMLHttpRequest.readyState);
            //         // 错误信息
            //         console.log(errorThrown);
            //     }
            // });
            layer.msg("您已成功退群", {time: 2000, icon: 1});
            location.reload();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            // 状态码
            console.log(XMLHttpRequest.status);
            // 状态
            console.log(XMLHttpRequest.readyState);
            // 错误信息
            console.log(errorThrown);
        }
    });
}

//验证加群
function verify_join_the_group($url) {
    layer.open({
        type: 2,
        title: "填写验证字段",
        content: $url,
        area: ['30%','66%'],
        closeBtn:1,
        shadeClose:true,
        shade:0.5,
        end:function () {}
    })
}

//邀请入群
function invitation_the_group($url) {
    layer.open({
        type: 2,
        title: "邀请他人加入群组",
        content: $url,
        area: ['30%','66%'],
        closeBtn:1,
        shadeClose:true,
        shade:0.5,
        end:function () {}
    })
}

//画出我的知识图谱
function myKnowledgeChart_old(jsonstring) {
    var myChart = echarts.init(document.getElementById('chart'));
    option = null;
    myChart.showLoading();
    myChart.hideLoading();
//处理json数据
    var wholedata = JSON.parse(jsonstring);
    console.log(wholedata);
    wholedata.nodes.forEach(function (node) {
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
    // option =
    // {
    //     title: {
    //         text: 'My Knowledge'
    //         //top: 'bottom',
    //         //left: 'right'
    //     },
    //     tooltip: {},
    //     legend: [
    //         {
    //         data: wholedata.categories.map(function(a) {
    //             return a.name;
    //         })
    //     }
    //     ],
    //     series: [{
    //         type: 'graph',      //关系图
    //         //name: 'My Knowledge',  //tooltip显示
    //         layout: 'force',  //布局怎么显示,
    //         animationDuration: 1500,
    //         animationEasingUpdate: 'quinticInOut',
    //         draggable: true, //节点可拖拽
    //         roam: 'move',     //鼠标缩放和平移漫游
    //         focusNodeAdjacency: 'true',  //是否在鼠标移到节点上的时候突出显示节点以及节点的边和邻接节点。
    //         smybol: 'circle',          //节点的形状'circle', 'rect', 'roundRect', 'triangle', 'diamond', 'pin', 'arrow'
    //         data: wholedata.nodes,
    //         links: wholedata.links,
    //         categories:wholedata.categories,
    //         force: {
    //             edgeLength: 100,//连线的长度
    //             repulsion: 100  //子节点之间的间距
    //         },
    //         label: {
    //             normal: {
    //                 position: 'right',
    //                 formatter: '{b}'
    //             }
    //         },
    //         lineStyle: {
    //             normal: {
    //                 curveness: 0.3
    //             }
    //         }
    //     }]
    // };
    myChart.setOption({
        title: {
            text: 'My Knowledge'
        },
        tooltip: {},
        legend: [
            {
                data: wholedata.categories.map(function(a) {
                    return a.name;
                })
            }
        ],
        series: [{
            type: 'graph',      //关系图
            //name: 'My Knowledge',  //tooltip显示
            layout: 'force',  //布局怎么显示,
            animationDuration: 1500,
            animationEasingUpdate: 'quinticInOut',
            draggable: true, //节点可拖拽
            roam: 'move',     //鼠标缩放和平移漫游
            focusNodeAdjacency: 'true',  //是否在鼠标移到节点上的时候突出显示节点以及节点的边和邻接节点。
            smybol: 'circle',          //节点的形状'circle', 'rect', 'roundRect', 'triangle', 'diamond', 'pin', 'arrow'
            data: wholedata.nodes,
            links: wholedata.links,
            categories:wholedata.categories,
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
    });
    //myChart.setOption(option);

    myChart.on('dblclick',function (params) {
        var data = params.data;
        //判断节点的相关数据是否正确
        if (data != null && data != undefined) {
            if (data.url != null && data.url != undefined) {
                //根据节点的扩展属性url打开新页面
                location.replace(data.url);
            }
        }
    });
}

function myKnowledgeChart(id,jsonstring) {
    var myChart = echarts.init(document.getElementById(id));
    option = null;
    myChart.showLoading();
    myChart.hideLoading();
//处理json数据
    var wholedata = JSON.parse(jsonstring);
    wholedata.nodes.forEach(function (node) {
        // if(node.value>100){
        //     node.symbolSize = node.value/15;
        // }else if(node.value<10){
        //     node.symbolSize = node.value*5;
        // }else{
        //     node.symbolSize = node.value;
        // }
        node.symbolSize = node.value;
        node.label = {
            normal:{
                show:true
            }
        };
        //console.log(node);
        // if(isEdgeNode(wholedata.links,node,wholedata.nodes)){
        //     console.log(wholedata.links);
        //     console.log(node);
        //     console.log(node.itemStyle.normal.opacity);
        //     //node.itemStyle.normal.opacity = 0;
        // }
    });
    // option =
    // {
    //     title: {
    //         text: 'My Knowledge'
    //         //top: 'bottom',
    //         //left: 'right'
    //     },
    //     tooltip: {},
    //     legend: [
    //         {
    //         data: wholedata.categories.map(function(a) {
    //             return a.name;
    //         })
    //     }
    //     ],
    //     series: [{
    //         type: 'graph',      //关系图
    //         //name: 'My Knowledge',  //tooltip显示
    //         layout: 'force',  //布局怎么显示,
    //         animationDuration: 1500,
    //         animationEasingUpdate: 'quinticInOut',
    //         draggable: true, //节点可拖拽
    //         roam: 'move',     //鼠标缩放和平移漫游
    //         focusNodeAdjacency: 'true',  //是否在鼠标移到节点上的时候突出显示节点以及节点的边和邻接节点。
    //         smybol: 'circle',          //节点的形状'circle', 'rect', 'roundRect', 'triangle', 'diamond', 'pin', 'arrow'
    //         data: wholedata.nodes,
    //         links: wholedata.links,
    //         categories:wholedata.categories,
    //         force: {
    //             edgeLength: 100,//连线的长度
    //             repulsion: 100  //子节点之间的间距
    //         },
    //         label: {
    //             normal: {
    //                 position: 'right',
    //                 formatter: '{b}'
    //             }
    //         },
    //         lineStyle: {
    //             normal: {
    //                 curveness: 0.3
    //             }
    //         }
    //     }]
    // };
    myChart.setOption({
        // title: {
        //     text: 'My Knowledge'
        // },
        tooltip: {},
        legend: [
            {
                data: wholedata.categories.map(function(a) {
                    return a.name;
                })
            }
        ],
        series: [{
            type: 'graph',      //关系图
            //name: 'My Knowledge',  //tooltip显示
            layout: 'force',  //布局怎么显示,
            animationDuration: 500,
            animationEasingUpdate: 'quinticInOut',
            draggable: true, //节点可拖拽
            roam: 'move',     //鼠标缩放和平移漫游
            focusNodeAdjacency: 'true',  //是否在鼠标移到节点上的时候突出显示节点以及节点的边和邻接节点。
            smybol: 'circle',          //节点的形状'circle', 'rect', 'roundRect', 'triangle', 'diamond', 'pin', 'arrow'
            nodes: wholedata.nodes,
            links: wholedata.links,
            categories:wholedata.categories,
            force: {
                edgeLength: 50,//连线的长度
                repulsion: 50  //子节点之间的间距
            },
            label: {
                normal: {
                    position: 'top',
                    formatter: '{b}'
                }
            },
            lineStyle: {
                normal: {
                    curveness: 0.3
                }
            }
        }]
    });
    //myChart.setOption(option);

    //双击打开链接
    myChart.on('dblclick',function (params) {
        var data = params.data;
        //判断节点的相关数据是否正确
        if (data != null && data != undefined) {
            if (data.url != null && data.url != undefined) {
                //根据节点的扩展属性url打开新页面
                location.replace(data.url);
            }
        }
    });

    //单击进行折叠
    myChart.on('click',function (param) {
        var option = myChart.getOption();           //获取所有option
        var nodesOption = option.series[0].nodes;   //获取node中的数据
        console.log(nodesOption);
        var linksOption = option.series[0].links;   //获取target,source信息
        var data = param.data;                      //点谁获取谁的node中对应的数据。是node中的子集

        if (data != null && data != undefined) {    //如果有这个节点
            /*
             * step1:查找所有下一级节点以及迭代下一级节点(how)
             * step2:若下一级节点的itemStyle.normal.opacity为0,则将下一级节点的itemStyle.normal.opacity设为1
             * step3:反之设为0.
             * */
            //如果下一级节点的状态是1,那么调用fold,反之

            if(nodeStatus(linksOption,data,nodesOption)==1){
                foldNode(linksOption,data,nodesOption);
            }
            else{
                openNode(linksOption,data,nodesOption);
                //openNodeOnce(linksOption,data,nodesOption);  //只打开一层
            }
        }
        myChart.setOption(option);
    });
}

//判断是否是边缘节点
function isEdgeNode(links,node,nodeoptions) {
    for(var j in links){
        if(links[j].source == node.id){return true;}
        else{return false;}
    }
}

//判断下一级节点状态
function nodeStatus(links,node,nodesOption){
    for(var i in links){
        if(links[i].source == node.id){
            return nodesOption[links[i].target].itemStyle.normal.opacity;
        }
    }
}

function openNode(links,node,nodesOption){  //可以考虑展开一层
    for (var i in links) {
        if (links[i].source == node.id) {
            if (!isEdgeNode(links, nodesOption[links[i].target], nodesOption)) {
                nodesOption[links[i].target].itemStyle.normal.opacity = 1;
                links[i].lineStyle.normal.opacity = 1;
                openNode(links, nodesOption[links[i].target], nodesOption);
            }
        }
    }
}

function foldNode(links,node,nodesOption) {
    for (var i in links) {
        if (links[i].source == node.id) {
            if (!isEdgeNode(links, nodesOption[links[i].target], nodesOption)) {
                nodesOption[links[i].target].itemStyle.normal.opacity = 0;
                links[i].lineStyle.normal.opacity = 0;
                foldNode(links, nodesOption[links[i].target], nodesOption);
            }
        }
    }
}

function openNodeOnce(links,node,nodesOption){  //可以考虑展开一层
    for (var i in links) {
        if (links[i].source == node.id) {
            nodesOption[links[i].target].itemStyle.normal.opacity = 1;
            links[i].lineStyle.normal.opacity = 1;
        }
    }
}

//画出项目页面的知识图谱
function sideChart(id,jsonstring) {
    var myChart = echarts.init(document.getElementById(id));
    option = null;
    myChart.showLoading();
    myChart.hideLoading();
    //处理json数据
    var jsondata = JSON.parse(jsonstring);
    jsondata.nodes.forEach(function (node) {
        // if (node.value > 50) {
        //     node.symbolSize = node.value / 25;
        // } else if (node.value < 10) {
        //     node.symbolSize = node.value * 5;
        // } else {
        //     node.symbolSize = node.value;
        // }
        node.symbolSize = node.value;
        node.label = {
            normal: {
                show: true
            }
        };
    });

    myChart.setOption({
        title: {
            //text: 'My Knowledge'
            //top: 'bottom',
            //left: 'right'
        },
        tooltip: {},
        legend: [
            // {
            //     data: jsondata.categories.map(function(a) {
            //         return a.name;
            //     })
            // }
        ],
        series: [{
            type: 'graph',      //关系图
            //name: 'My Knowledge',  //tooltip显示
            layout: 'force',  //布局怎么显示,
            animationDuration: 500,
            animationEasingUpdate: 'quinticInOut',
            draggable: true,
            roam: 'move',     //是否开启鼠标缩放和平移漫游。默认不开启。如果只想要开启缩放或者平移，可以设置成 'scale' 或者 'move'。设置成 true 为都开启
            focusNodeAdjacency: 'true',  //是否在鼠标移到节点上的时候突出显示节点以及节点的边和邻接节点。
            smybol: 'circle',          //节点的形状'circle', 'rect', 'roundRect', 'triangle', 'diamond', 'pin', 'arrow'
            nodes: jsondata.nodes,
            links: jsondata.links,
            //categories: jsondata.categories,
            force: {
                edgeLength: 80,//连线的长度
                repulsion: 80  //子节点之间的间距
            },
            label: {
                normal: {
                    position: 'top',
                    formatter: '{b}'
                }
            },
            lineStyle: {
                normal: {
                    curveness: 0.3
                }
            }
        }]
    });

    myChart.on('dblclick', function (params) {
        var data = params.data;
        //判断节点的相关数据是否正确
        if (data != null && data != undefined) {
            if (data.url != null && data.url != undefined) {
                //根据节点的扩展属性url打开新页面
                location.replace(data.url);
            }
        }
    });

    // myChart.on('click',function (param) {
    //     var option = myChart.getOption();           //获取所有option
    //     var nodesOption = option.series[0].nodes;   //获取node中的数据
    //     var linksOption = option.series[0].links;   //获取target,source信息
    //     var data = param.data;                      //点谁获取谁的node中对应的数据。是node中的子集
    //
    //     if (data != null && data != undefined) {    //如果有这个节点
    //         /*
    //          * step1:查找所有下一级节点以及迭代下一级节点(how)
    //          * step2:若下一级节点的itemStyle.normal.opacity为0,则将下一级节点的itemStyle.normal.opacity设为1
    //          * step3:反之设为0.
    //          * */
    //         //如果下一级节点的状态是1,那么调用fold,反之
    //
    //         if(nodeStatus(linksOption,data,nodesOption)==1){
    //             foldNode(linksOption,data,nodesOption);
    //         }
    //         else{
    //             openNode(linksOption,data,nodesOption);
    //             //openNodeOnce(linksOption,data,nodesOption);  //只打开一层
    //         }
    //     }
    //     myChart.setOption(option);
    // });
}

// function sideChart(id,jsonstring) {
//     var myChart = echarts.init(document.getElementById(id));
//     option = null;
//     myChart.showLoading();
//     myChart.hideLoading();
//     //处理json数据
//     var jsondata = JSON.parse(jsonstring);
//
//     jsondata.nodes.forEach(function (node) {
//         //node.symbolSize = node.value;
//         node.label = {
//             normal: {
//                 show: true,
//                 color: "#000"
//             }
//         };
//     });
//
//     var option = {
//         title: {
//             //text: 'Graph 简单示例'
//         },
//         tooltip: {},
//         series: [
//             {
//                 type: 'graph',
//                 layout: 'circular', //布局模式
//                 symbolSize: 50,     //点的大小
//                 roam: false,        //鼠标缩放和平移漫游
//                 label: {
//                     normal: {
//                         show: true,  //节点名称
//                         color: "#000"
//                     }
//                 },
//                 itemStyle: {
//                     normal: {
//                         //color: "#000"
//                     }
//                 },
//                 edgeSymbol: ['circle', 'arrow'],  //边两端的标记
//                 edgeSymbolSize: [4, 10],          //边两端标记的大小
//                 edgeLabel: {
//                     normal: {
//                         textStyle: {
//                             fontSize: 20          //边上的字大小
//                         }
//                     }
//                 },
//
//                 //data: [{"name":"1"},{"name":"2"}],
//                 data: jsondata.nodes,
//                 links: jsondata.links,
//                 lineStyle: {
//                     normal: {
//                         opacity: 0.9,
//                         width: 2,
//                         curveness: 0
//                     }
//                 }
//             }
//         ]
//     };
//     myChart.setOption(option);
//     myChart.on('dblclick', function (params) {
//         var data = params.data;
//         //判断节点的相关数据是否正确
//         if (data != null && data != undefined) {
//             if (data.url != null && data.url != undefined) {
//                 //根据节点的扩展属性url打开新页面
//                 location.replace(data.url);
//             }
//         }
//     });
// }



//发私信
function send_private_message($url){
    layer.open({
        type: 2,
        title: false,
        content: $url,
        area: ['60%','66%'],
        closeBtn:1,
        shadeClose:true,
        shade:0.5,
        end:function () {}
    })
}



//联想查询
function autoComplete(response, tab, part) {
    var arr = response.split("|");
    arr.pop();
    var li = "";
    var ac_id = "#autocomplete-" + part;
    if (arr.length != 0) {
        $.each(arr, function (i, val) {
            li += "<li class='list-group-item'>" + val + "</li>";
        });
        $(ac_id + " ul").html(li);
        $(ac_id).slideDown('fast');
        //鼠标经过元素的背景颜色改变
        $(ac_id + " ul li").bind('mouseenter', function () {
            $(this).css({'background': '#e9e8e9'})
        });
        $(ac_id + " ul li").bind('mouseleave', function () {
            $(this).css({'background': 'transparent'})
        });
        $(ac_id + " ul li").bind('click', function () {
            $("#" + tab + "-" + part + "-input").val($(this).html());
            $(ac_id).slideUp('fast');
        });
    }
    else {
        $(ac_id).slideUp('fast');
    }
}
//添加到选择table
function addToChosen(tab,type,url) {

    var input_id = '#'+tab+'-'+type+'-input';
    var name = $(input_id).val();
    var data = {
        action: 'rbac_hasItem',
        part:type,
        word: name
    };
    $.ajax({
        type: 'post',
        url: url,
        data: data,
        dataType: 'text',
        success: function (response) {
            if (response.trim() == 1) {  // 如果没有
                if (type == 'permission') {
                    layer.msg("无此权限", {time: 2000, icon: 2})
                }else if(type == 'user'){
                    layer.msg("无此用户", {time: 2000, icon: 2})
                }else{
                    layer.msg("无此角色", {time: 2000, icon: 2})
                }
            }
            else {
                //step1:执行逻辑是先加入一行,包括一个多选框和一个数据
                var tr = '<tr><td>' + name + '</td></tr>';
                $('#' + type + '-choose-table-border tbody:last').append(tr);    //添加数据
                var $tbr = $('#' + type + '-choose-table-border tbody tr:last');
                var $checkItemTd = $('<td><input type="checkbox" name="checkItem" checked/></td>');   //添加复选框
                $tbr.prepend($checkItemTd);
                $tbr.find('input').click(function (event) {
                    /*调整选中行的CSS样式*/
                    $(this).parent().parent().toggleClass('warning');
                    /*阻止向上冒泡，以防再次触发点击操作*/
                    event.stopPropagation();
                });
                /*点击每一行时也触发该行的选中操作*/
                // $tbr.click(function () {
                //     $(this).find('input').click();
                // });
                //step2:将事件绑定到刚刚添加的元素上
                var choose_table_id ='#' + type + '-choose-table-border';
                var show_table_id = '#'+type+'-info-table-border';
                addClickEvent(choose_table_id,type,show_table_id,url);
            }
        }
    })
}
//添加table中的data点击事件
function addClickEvent(choose_table_id,type,show_table_id,url) {
    $(choose_table_id+' tbody tr td').bind('click', function () {
        var name = this.innerText;
        var data = {
            action: 'rbac_get_info',
            part: type,
            word: name
        };
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            success: function (response) {
                var info = $(show_table_id +' tbody tr');
                for (var i=0;i<info.length;i++){
                    var tmp = info[i].childNodes[3].innerText;
                    info[i].childNodes[3].innerText = response[i];
                }
            }
        })
    })
}
