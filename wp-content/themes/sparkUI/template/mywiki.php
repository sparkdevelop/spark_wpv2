<?php
?>
<?php
$admin_url=admin_url('admin-ajax.php');
?>
<script type="text/javascript">

    function get_publish_wiki() {
        var get_contents = {
            action: "get_user_related_wiki",
            get_wiki_type: "publish"
        };
        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: get_contents,
            dataType: "json",
            beforeSend: function () {
                $("#wiki_list").html("");
                $("#wiki_list").append("<p>"+"获取信息中..."+"</p>");
            },
            success: function(data){
                //alert(data.wikis.length);
                $("#wiki_list").html("");
                for(var i=0;i<data.wikis.length;i++) {
                    $("#wiki_list").append("<p>"+"<a href=\"/spark_wpv2/?yada_wiki="+data.wikis[i].post_name+"\">"+data.wikis[i].post_title+"</a>"+"</p>");
                    $("#wiki_list").append("<p>"+data.wikis[i].post_content.substring(0, 30)+"..."+"</p>");
                    $("#wiki_list").append("<hr>");
                    //alert(data.wikis[i].post_title);
                }
            },
            error: function() {
                alert("wiki获取失败!");
            }
        });
    }

    function get_inherit_wiki(){
        var get_contents = {
            action: "get_user_related_wiki",
            get_wiki_type: "inherit"
        };
        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: get_contents,
            dataType: "json",
            beforeSend: function () {
                $("#wiki_list").html("");
                $("#wiki_list").append("<p>"+"获取信息中..."+"</p>");
            },
            success: function(data){
                //alert(data.wikis.length);
                $("#wiki_list").html("");
                for(var i=0;i<data.wikis.length;i++) {
                    $("#wiki_list").append("<p>"+"<a href=\"/spark_wpv2/?yada_wiki="+data.wikis[i].post_name+"\">"+data.wikis[i].post_title+"</a>"+"</p>");
                    $("#wiki_list").append("<p>"+data.wikis[i].post_content.substring(0, 50)+"..."+"</p>");
                    $("#wiki_list").append("<hr>");
                    //alert(data.wikis[i].post_title);
                }
            },
            error: function() {
                alert("wiki获取失败!");
            }
        });
    }

    $(function(){
        get_publish_wiki();
        $("#publish_wiki").on("click", function() {
            get_publish_wiki();
            document.getElementById("li_publish_wiki").className="active";
            document.getElementById("li_inherit_wiki").className="";
        });
        $("#inherit_wiki").on("click", function () {
            get_inherit_wiki();
            document.getElementById("li_publish_wiki").className="";
            document.getElementById("li_inherit_wiki").className="active";
        });
    });
</script>
    <ul id="personalTab" class="nav nav-pills">
      <li class="active" id="li_publish_wiki"><a id="publish_wiki">我创建的wiki</a></li>
      <li id="li_inherit_wiki"><a id="inherit_wiki">参与编辑的wiki</a></li>
    </ul>
    <div style="height: 1px;background-color: lightgrey;"></div>
    <div id="wiki_list"></div>

