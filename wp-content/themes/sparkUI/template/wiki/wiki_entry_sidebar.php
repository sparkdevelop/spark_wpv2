<style type="text/css">
    .wiki-handle {
        margin-bottom: 10px;
        padding-left: 16px;
    }
    .edit-wiki{
        width:45%;
        height: 48px;
        background-color: #fe642d;
        -moz-box-shadow: 5px 5px 5px #ffd8cc;
        box-shadow: 5px 5px 5px #ffd8cc;
        text-align: center;
        font-size: large;
        margin: 10px 15px 15px 0px;
        border-radius: 5px;
        float: left;
    }
    .edit-wiki:hover{
        box-shadow: none;
    }
    .edit-wiki>a,.edit-wiki>a:hover{
        display: block;
        height: 100%;
        line-height: 48px;
        width: 100%;
        color: white;
        text-decoration: none;
    }
    .create-wiki{
        width:45%;
        height: 48px;
        -moz-box-shadow: 3px 3px 3px #ffe8e0;
        box-shadow: 5px 5px 5px #ffe8e0;
        text-align: center;
        font-size: large;
        margin: 10px 0px 15px 0px;
        border:1px solid #fe642d;
        border-radius: 5px;
        float: left;
    }
    .create-wiki:hover{
        box-shadow: none;
    }
    .create-wiki>a,.create-wiki>a:hover{
        display: block;
        height: 100%;
        line-height: 48px;
        width: 100%;
        color: #fe642d;
        text-decoration: none;
    }

    .wiki_entry_info {
        /*border:  1px solid #eee;*/
        border-top:1px solid #eee;
        border-bottom: 1px solid #eee;
        padding: 20px 20px 10px 20px;
    }
    .wiki_entry_info p{
        color: #333;
        font-size: 14px;
    }
    .wiki_entry_score {
        border: 1px solid #eee;
        margin-top: 30px;
        padding: 20px 20px 10px 20px;
    }
</style>
<?php
    global $post;
    $entry_title = $post->post_title;
    $entry_content = $post->post_content;
    $wiki_content = $post->post_content;
    $regex = "/(?:<h2>.*<\/h2>)/";
    $match = array();
    $entry_titles = array();
    preg_match_all($regex, $wiki_content, $match);
    for($i=0;$i<count($match[0]);$i++) {
        $wiki_title_item = trim($match[0][$i]);
        $wiki_format_title = substr($wiki_title_item, 4, -5);
        if (empty($wiki_format_title)) {
            continue;
        }
        $entry_titles[] = $wiki_format_title;
    }
    $_SESSION["entry_mulu"] = $entry_titles;
?>
<div class="wiki_sidebar_wrap">
    <div class="row wiki-handle">
        <div class="edit-wiki"><a href="<?php echo get_permalink( get_page_by_title( '编辑wiki' )); ?>&post_id=<?php echo $post->ID ?>">编辑 wiki</a></div>
        <div class="create-wiki"><a href="<?php echo get_permalink( get_page_by_title( '创建wiki' )); ?>">创建 wiki</a></div>
    </div>
<!--    <div class="list-group mulu">-->
<!--        <a href="#" class="list-group-item">-->
<!--            <span class="glyphicon glyphicon-align-left" aria-hidden="true"></span>-->
<!--            目录-->
<!--        </a>-->
<!--        --><?php
//            for($i=0; $i<count($entry_titles); $i++) {
//                ?>
<!--                <a href="#" class="list-group-item mulu_item">--><?php //echo $entry_titles[$i]; ?><!--</a>-->
<!--                --><?php
//            }
//        ?>
<!--    </div>-->
    <?php
        global $post;
        $admin_url=admin_url('admin-ajax.php');
    ?>
    <script type="text/javascript">
        $(function(){
            var get_post_info = {
                action: "get_post_info",
                post_id: <?php echo $post->ID; ?>
            };
            $.ajax({
                type: "POST",
                url: "<?php echo $admin_url;?>",
                data: get_post_info,
                dataType: "json",
                success: function(data){
                    var categories_show = "";
                    for (var i=0;i<data.categories.length;i++) {
                        categories_show = categories_show + data.categories[i] + "  ";
                    }
                    var tags_show = "";
                    for (var i=0;i<data.tags.length;i++) {
                        tags_show = tags_show + data.tags[i] + "  ";
                    }
                    $("#edit_nums").html("编辑: "+data.edit_author_nums+"人&nbsp;&nbsp;&nbsp;&nbsp;"+data.revision_nums+"个版本");
                    //$("#watch_nums").html("浏览: "+data);
                    $("#update_time").html("更新: "+data.time+"天前");
                    $("#categories_show").html("分类: "+categories_show);
                    $("#tags_show").html("标签: "+tags_show);
                    $("#watch_nums").html("浏览: "+data.watch_count+"次");
                },
                error: function() {
                    alert("数据加载失败!");
                }
            });

        });
    </script>
    <div class="wiki_entry_info">
        <p>创建:
            <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.get_post()->post_author.'&tab=wiki'?>"
               class="author_link"><?php echo get_the_author();?>
            </a>
        </p>
        <p id="edit_nums"></p>
        <p id="watch_nums"></p>
        <p id="update_time"></p>
        <p id="categories_show"></p>
        <p id="tags_show"></p>
    </div>

<!--    <div class="wiki_entry_score">-->
<!--        <p>学到好多: 有20人评分</p>-->
<!--    </div>-->
<!--    <div class="wiki_entry_share">-->
<!--        <p>QQ     WECHAT     WEIBO</p>-->
<!--    </div>-->

<!--评分-->
    <?php
    $post_id= $post->ID;
    $current_user = wp_get_current_user();
    $score = calScore($post_id);
    $starScore = round($score['score'])-1;
    $hasScore = hasScore($current_user->ID,$post_id);
    ?>
    <script>
        window.onload = function () {
            var flag;
            flag =<?=hasScore($current_user->ID,$post_id);?>;
            var score = document.getElementById('score');
            var oUl = document.getElementById('stars');
            var aLi = oUl.getElementsByTagName('li');
            var arr = ['毫无帮助','内容一般', '有点帮助','学到很多','强力推荐'];
            if(flag==true){ //未打分
                for (var i = 0; i < aLi.length; i++) {
                    aLi[i].index = i;
                    markOut(<?=$starScore?>);   //初始显示
                    aLi[i].onclick = function () {
                        markOver(this.index);  //this指的是aLi[i]
                        oUl.index = this.index;
                        var data = {
                            action: 'addScore',
                            userID: '<?=$current_user->ID?>',
                            postID: '<?=$post_id?>',
                            score: this.index + 1
                        };
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $admin_url;?>",
                            data: data,
                            success: function () {
                                layer.msg('打分成功', {time: 2000, icon: 1},function () {
                                    location.reload();
                                });  //layer.msg(content, {options}, end) - 提示框
                            },
                            error: function () {
                                alert("Oops,打分失败了T^T");
                            }
                        });
                    };
                    aLi[i].onmouseover = function () {
                        for (var i = 0; i < aLi.length; i++) {
                            aLi[i].style.color = '#ccc';
                        }
                        markOver(this.index);
                    };
                    aLi[i].onmouseout = function () {
                        for (var i = 0; i <= this.index; i++) {
                            aLi[i].style.color = '#ccc';
                        }
                        markOut(<?=$starScore?>);
                    };
                }
            }else{
                for (var i = 0; i < aLi.length; i++) {
                    aLi[i].index = i;
                    markOut(<?=$starScore?>);   //初始显示
                    aLi[i].onclick = function (){
                        layer.msg("你已经打过分了",{time:2000,icon:2});
                    }
                }
            }
            function markOver(index) {
                for (var i = 0; i <= index; i++) {
                    aLi[i].style.color = index < 2 ? 'gray' : '#fe642d';
                }
                score.innerHTML = arr[index] ? arr[index] :'<?=$score['score']?>';
            }
            function markOut(index) {
                for (var i = 0; i <= index; i++) {
                    aLi[i].style.color = index < 2 ? 'gray' : '#fe642d';
                }
                var html = arr[index]+"<span>~<?=$score['num']?>人评分</span>";
                if(index==-1){
                    html = "<span><?=$score['num']?>人评分</span>";
                }
                score.innerHTML =html;
            }
        }
    </script>
    <div id="proScore">
        <div class="sidebar_list_header">
            <p>wiki评分</p>
        </div>
        <div style="height: 2px;background-color: lightgray"></div>
        <div id="starsdiv">
            <div id="starsdivleft">
                <ul class="stars" id="stars">
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                    <li class="fa fa-star"></li>
                </ul>
                <div id="score">
                    <?=$score['score'];?>
                    <span>&nbsp;<?=$score['num']?>人评分</span>
                </div>
            </div>
        </div>
    </div>

<!--知识图谱-->
    <?php $jsonString = sideJSONGenerte($current_user->ID,"yada_wiki"); ?>
    <div class="wikiknowledge">
        <div class="sidebar_list_header">
            <p>学习路径</p>
        </div>
        <div style="height: 2px;background-color: lightgray"></div>
        <div id="sidechart" style="width:350px;height: 350px"></div>
    </div>
    <script>
        sideChart('<?=$jsonString?>');
    </script>
<!--    相关项目-->
    <?php
    $related_pros = wikiRelatedPro(get_the_ID()); ?>
    <div class="related_pros">
        <div class="sidebar_list_header">
            <p>相关项目</p>
            <a id="sidebar_list_link" onclick="show_more_pros()">更多</a>
        </div>
        <!--分割线-->
        <div style="height: 2px;background-color: lightgray"></div>
        <div class="related_pros" id="related_pros">
            <ul style="padding-left: 20px">
                <?php
                //控制条数
                if(sizeof($related_pros)<5){$length = sizeof($related_pros);}
                else{$length = 5;}
                for($i=0;$i<$length;$i++){ ?>
                    <li class="list-group-item">
                        <a href="<?php echo get_permalink($related_pros[$i]);?>" class="question-title">
                            <?php echo get_the_title($related_pros[$i]);?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="more_related_pros" id="more_related_pros" style="display: none">
            <ul style="padding-left: 20px">
                <?php
                //控制条数
                if(sizeof($related_pros)>=15){$length = 15;}
                else{$length = sizeof($related_pros);}

                for($i=0;$i<$length;$i++){ ?>
                    <li class="list-group-item">
                        <a href="<?php echo get_permalink($related_pros[$i]);?>" class="question-title">
                            <?php echo get_the_title($related_pros[$i]);?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<script>
    var flag=false;
    function show_more_pros() {
        var related_pros=document.getElementById('related_pros');
        var more_related_pros = document.getElementById('more_related_pros');
        if(flag){
            related_pros.style.display ="block";
            more_related_pros.style.display="none";
        }else{
            related_pros.style.display="none";
            more_related_pros.style.display="block";
        }
        flag=!flag;
    }
</script>
