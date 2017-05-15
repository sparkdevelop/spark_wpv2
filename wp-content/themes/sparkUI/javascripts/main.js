/**
 * Created by shuai on 2017/5/6.
 */
$(function(){
    //-----手机端搜索按钮点击-----
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


    //-----手机端导航按钮点击-----
    $(".m-nav-icon").on("click",function () {
        $(".m-left-collapse-menu").toggle();
    });

    $(".m-fa-remove").on("click",function () {
        $("m-left-collapse-menu").hide();
    });


    //------JS判断客户端是手机还是PC，并移除一些div-------
    (function IsPC() {
        var userAgentInfo = navigator.userAgent;
        var Agents = ["Android", "iPhone",
            "SymbianOS", "Windows Phone",
            "iPad", "iPod"];
        var flag = "电脑";
        for (var v = 0; v < Agents.length; v++) {
            if (userAgentInfo.indexOf(Agents[v]) > 0) {
                flag = "phone";
            }
        }
        if(flag == "phone"){
            $(".publish-project-choose").remove();
            $(".wiki_sidebar_wrap").remove();
        }else{
            $(".m-publish-project").remove();
            $(".m-edit-wiki-box").remove();
            $(".m-create-wiki-box").remove();
        }
    })()


});

function collapse() {
    $("#m-personal-nav").collapse("toggle");
}


