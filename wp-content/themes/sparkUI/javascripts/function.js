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

//项目页显示更多相关wiki
function show_more_wiki(flag) {
    var related_wiki=document.getElementById('related_wiki');
    var more_related_wiki = document.getElementById('more_related_wiki');
    if(flag){
        related_wiki.style.display ="block";
        more_related_wiki.style.display="none";
    }else{
        related_wiki.style.display="none";
        more_related_wiki.style.display="block";
    }
    flag=!flag;
}
