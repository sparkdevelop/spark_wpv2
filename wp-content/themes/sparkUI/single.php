<?php
/**单独的文章模板
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/7
 * Time: 16:52
 */
get_header(); ?>
<?php

wp_enqueue_script('fep-script');
wp_enqueue_media();

$current_user = wp_get_current_user();
//获取文章作者ID、用户名
$post_id = get_the_ID();
$author_id=get_post($post_id)->post_author;
$author_name=get_the_author_meta('user_login',$author_id);

//相关知识
$related_wiki = showProWiki(get_the_ID());
?>
<?php
//获取当前用户用户名
global $current_user;
get_currentuserinfo();
$current_user->user_login;
$admin_url=admin_url( 'admin-ajax.php' );
?>
<script>
    function addFavorite() {
        var data={
            action:'addFavorite',
            userID:'<?=$current_user->ID?>',
            postID:'<?=$post_id?>'
        };
        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: data,
            success: function(){
                layer.msg('收藏成功',{time:2000,icon:1});  //layer.msg(content, {options}, end) - 提示框
                var html = "<a onclick=\"setCSS(0)\" class=\"btn btn-default\" id=\"btn-add-favorite\">"+
                    "<span class=\"glyphicon glyphicon-star\"></span>已收藏"+"</a>";
                $("#addFavorite").html(html);
//                $("#btn-add-favorite").css({"color":"white",
//                    "background-color": "#fe642d",
//                    "border-color": "transparent"});
            },
            error:function () {
                alert("收藏失败");
            }
        });
    }
    function cancelFavorite() {
        var data={
            action:'cancelFavorite',
            userID:'<?=$current_user->ID?>',
            postID:'<?=$post_id?>'
        };
        $.ajax({
            type: "POST",
            url: "<?php echo $admin_url;?>",
            data: data,
            success: function(){
                layer.msg('已取消',{time:2000,icon:1});  //layer.msg(content, {options}, end) - 提示框
                var html = "<a onclick=\"setCSS(1)\" class=\"btn btn-default\" id=\"btn-add-favorite\">"+
                    "<span class=\"glyphicon glyphicon-star-empty\"></span>收藏"+"</a>";
                $("#addFavorite").html(html);
                //更改样式
//                $("#btn-add-favorite").css({ "color":"#fe642d",
//                    "background-color": "transparent",
//                    "border-color": "#fe642d"});
            },
            error:function () {
                alert("error");
            }
        });
    }
</script>

<div class="container" style="margin-top: 10px">
    <div class="row" style="width: 100%">
        <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
            <!--引入动态模板-->
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();?>
                <!--    文章内容-->
                <div style="display:inline-block;">
                    <h2><b><?php the_title(); ?></b></h2>
                </div>
                <?php if( !ifFavorite($current_user->ID,$post_id) ){ //未收藏
                    $flag = 1;
                    $avalue = "<span class=\"glyphicon glyphicon-star-empty\"></span>收藏";
                } else{
                    $flag = 0;
                    $avalue = "<span class=\"glyphicon glyphicon-star\"></span>已收藏";
                } ?>
                <div id="addFavorite">
                    <a onclick="setCSS(<?=$flag?>)" class="btn btn-default" id="btn-add-favorite">
                        <?php echo $avalue; ?>
                    </a>
                </div>
                <hr>
                <?php the_content(); ?><hr>
                <?php comments_template(); ?>
            <?php endwhile;?>
            <?php else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

            <?php endif; ?>

        </div>
        <div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
            <style type="text/css">
                .mulu a{
                    display: block;
                    border: #9ea7af 1px solid;
                    height: 50px;
                    padding-left: 30px;
                }
                .mulu .mulu_item{
                    display: block;
                    border: #9ea7af 1px solid;
                    height: 50px;
                    padding-left: 50px;
                }

            </style>

            <!--判断用户是否为项目发布者，若是，则显示编辑按钮,否则显示发布按钮-->
            <div class="sidebar_button" style="margin-top: 20px;margin-right: 15px;margin-left: -2px">
                <?php if($current_user->user_login  == $author_name) {
                    echo "<a href='?fep_action=edit&fep_id=$post_id&page_id=434' >编辑项目</a >";
                }else {
                    echo "<a href='".get_the_permalink(get_page_by_title('发布项目')). "' target='_blank' >发布项目</a>";
                }
                ?>
            </div>
            <div class="sidebar-grey-frame" style="margin-top: 30px">
                <p>发布者：
                    <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.get_post()->post_author.'&tab=project'?>"
                       class="author_link" style="color: #5e5e5e"><?php echo get_the_author();?>
                    </a>
                </p><br>
                <p>分类：</p>
                <span id="" ><?php the_category(', ') ?></span><br>
                <p>标签：</p>
                <span id=""><?php the_tags("", "  ",''); ?></span><br>
                <p>更新：</p>
                <span id="" ><?php the_modified_time('Y年n月j日 h:m:s'); ?></span><br>
                <p>浏览：</p>
                <span id=""><?php setProjectViews(get_the_ID()); ?><?php echo getProjectViews(get_the_ID()); ?> 次</span><br>
                <p>评论：</p>
                <span><?php comments_popup_link('0 条', '1 条', '% 条', '', '评论已关闭'); ?></span><br>
            </div><br>

            <?php $score = calScore($post_id);
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
                    var arr = ['内容太少','项目一般', '有点帮助','学到很多','强力推荐'];
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
                    <p>项目评分</p>
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

            <div class="related_questions">
                <div class="sidebar_list_header">
                    <p>相似项目</p>
                </div>
                <div style="height: 2px;background-color: lightgray"></div>
                <ul class="list-group" style="padding-left: 20px; ">
                    <?php related_project() ?>
                </ul>
            </div>


            <div class="related_wikis">
                <div class="sidebar_list_header">
                    <p>相关知识</p>
                    <a id="sidebar_list_link" onclick="show_more_wiki()">更多</a>
                </div>
                <!--分割线-->
                <div style="height: 2px;background-color: lightgray"></div>
                <div class="related_wiki" id="related_wiki">
                    <ul style="padding-left: 20px; ">
                        <?php
                        //控制条数
                        if(sizeof($related_wiki)<5){$length = sizeof($related_wiki);}
                        else{$length = 5;}
                        for($i=0;$i<$length;$i++){ ?>
                            <li class="list-group-item">
                                <a href="<?php echo get_permalink($related_wiki[$i]["wiki_id"]);?>" class="question-title">
                                    <?php echo get_the_title($related_wiki[$i]["wiki_id"]);?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="more_related_wiki" id="more_related_wiki" style="display: none">
                    <ul style="padding-left: 20px">
                        <?php
                        //控制条数
                        if(sizeof($related_wiki)>=15){$length = 15;}
                        else{$length = sizeof($related_wiki);}

                        for($i=0;$i<$length;$i++){ ?>
                            <li class="list-group-item">
                                <a href="<?php echo get_permalink($related_wiki[$i]["wiki_id"]);?>" class="question-title" id="more_wiki">
                                    <?php echo get_the_title($related_wiki[$i]["wiki_id"]);?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php //get_sidebar();?>
    </div>
</div>
<?php get_footer(); ?>
<div class="side-tool" id="side-tool-project">
    <ul>
        <li data-placement="left" data-toggle="tooltip" data-original-title="回到顶部"><a href="#" class="">顶部</a></li>
        <li data-placement="left" data-toggle="tooltip" data-original-title="点赞吐槽"><a href="#comments" class="">评论</a></li>

        <?php
        $current_url = curPageURL();
        $url_array=parse_url($current_url);
        $current_page_id=explode("=",$url_array['query'])[1];
        $current_page_type = get_post_type($current_page_id);
        ?>
        <?php if(is_user_logged_in()){ ?>
            <li data-placement="left" data-toggle="tooltip" data-original-title="不懂就问">
                <a onclick="addLayer()" id="ask_link">提问</a>
            </li>
        <?php }else{ ?>
            <li data-placement="left" data-toggle="tooltip" data-original-title="不懂就问">
                <a href="<?php echo wp_login_url( get_permalink() ); ?>">提问</a>
            </li>
        <?php } ?>

    </ul>
</div>

<div class="side-tool" id="m-side-tool-project">
    <ul>
        <?php if($current_user->user_login  == $author_name){
            echo "<li><a href='?fep_action=edit&fep_id=$post_id&page_id=434' ><i class='fa fa-pencil' aria-hidden = 'true' ></i ></a ></li>";
            echo "<li><a href='".get_the_permalink(get_page_by_title('发布项目')). "'><i class='fa fa-plus' aria-hidden='true'></i></a></li>";
        }else{
            echo "<li><a href='".get_the_permalink(get_page_by_title('发布项目')). "'><i class='fa fa-plus' aria-hidden='true'></i></a></li>";
        }
        ?>
    </ul>
</div>

<script type="text/javascript">
    $(function () { $("[data-toggle='tooltip']").tooltip(); });
</script>
<script>
    var flag=false;

    function show_more_wiki() {
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
    function addLayer() {
        layer.open({
            type : 2,
            title: "提问", //不显示title   //'layer iframe',
            content: '<?php echo site_url().get_page_address('ask_tiny')."&post_id=".$current_page_id."&type=".$current_page_type;?>', //iframe的url
            area: ['70%', '80%'],
            closeBtn:1,            //是0为不显示叉叉 可选1,2
            shadeClose: true,    //点击其他shade区域关闭窗口
            shade: 0.5,   //透明度
            end: function () {
                location.reload();
            }
        });
    }
</script>


