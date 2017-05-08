/**
 * Created by shuai on 2017/5/6.
 */


//---------------手机端搜索按钮点击-------------
$(function(){
    $(".m-fa-search").on("click",function () {
        $(".m_search_box").show();
        $(".m-fa-search").hide();
        $(".m-fa-remove").show();
    });

    $(".m-fa-remove").on("click",function () {
        $(".m_search_box").hide();
        $(".m-fa-search").show();
        $(".m-fa-remove").hide();
    });

    $(".m-nav-icon").on("click",function () {
        $(".m-left-collapse-menu").show();
    });

    $(".m-fa-remove").on("click",function () {
        $("m-left-collapse-menu").hide();
    });

    // //-----------------JS判断客户端是手机还是PC----------
    // (function IsPC() {
    //     var userAgentInfo = navigator.userAgent;
    //     var Agents = ["Android", "iPhone",
    //         "SymbianOS", "Windows Phone",
    //         "iPad", "iPod"];
    //     var flag = "电脑";
    //     for (var v = 0; v < Agents.length; v++) {
    //         if (userAgentInfo.indexOf(Agents[v]) > 0) {
    //             flag = "手机";
    //             var link = document.createElement( "link" );
    //             link.type = "text/css";
    //             link.rel = "stylesheet";
    //             link.href = 'http://localhost/spark_wpv2/wp-content/themes/sparkUI/css/mobile.css';
    //             document.getElementsByTagName( "head" )[0].appendChild( link );
    //             break;
    //         }
    //     }
    //     // return flag;
    // })()
})
