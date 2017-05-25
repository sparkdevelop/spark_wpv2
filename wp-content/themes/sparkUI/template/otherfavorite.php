<?php
wp_enqueue_style('fep-style');
wp_enqueue_script('fep-script');
wp_enqueue_media();
$admin_url=admin_url( 'admin-ajax.php' );

$current_user = wp_get_current_user();
$user_id = isset($_GET["id"]) ? $_GET["id"] : $current_user->ID ;
$faverite_pro = showFavorite($user_id);

$origin_url = get_permalink(); //当前url
$length = sizeof($faverite_pro); //收藏项目总数
$perpage = 12;       //12
$total_page = ceil($length/$perpage); //计算总页数
if(!$_GET['paged']){
    $current_page = 1;
}
else{
    $page_num=$_GET['paged'];
    $current_page = $page_num;?>
<?php } ?>

<style type="text/css">
    #close-icon{
        position: absolute;
        display: block;
        top: 6px;
        right: 20px;
        color: lightgrey;
    }
    #close-icon:hover{
        color: #fe642d;
        cursor: pointer;
    }
</style>

<script type="text/javascript">
    //鼠标划过事件
    $(".thumbnail").mouseover(function () {
        //$(this).addClass("border");
        //显示删除叉
        $(this).getElementById("close-icon").css("display", "block");
    });
    $(".thumbnail").mouseleave(function () {
        //$(this).removeClass("border");
        //隐藏删除叉
        $(this).find("#close-icon").css("display", "none");

    });
    function delete_confirm() {

    }
</script>

<ul id="leftTab" class="nav nav-pills" style="height: 42px">
    <li class="active"><a href="#my-favorite-project" data-toggle="tab">项目收藏(<?=$length?>)</a></li>
    <li><a href="#my-favorite-wiki" data-toggle="tab">wiki收藏(0)</a></li>
</ul>

<div id="rightTabContent" class="tab-content" >
    <div class="tab-pane fade in active" id="my-favorite-project" style="padding-top: 40px;">
        <div style="height: 1px;background-color: lightgray;"></div><br>
        <ul class="list-group">
            <?php
            if($length!=0){
                $temp = $length < $perpage*$current_page ? $length : $perpage*$current_page;
                for($i=$perpage*($current_page-1);$i<$temp;$i++){?>
                    <li style="list-style-type: none;">
                        <div class="col-md-4 col-sm-4 col-xs-6" id="project-fluid">
                            <div class="thumbnail" id="project-div-fluid">
                        <span >
                             <?php
                             $url = get_bloginfo('url');
                             if (current_user_can('edit_post', $faverite_pro[$i])){
                                 echo '<a class="fa fa-trash-o fa-lg" id="close-icon" class="post-delete" style="font-size:15px" onclick="return confirm(\'确认删除吗？\')" href="';
                                 echo wp_nonce_url("$url/wp-admin/post.php?action=delete&post=$id", 'delete-post_' . $faverite_pro[$i]);
                                 echo '"></a>';
                             }
                             ?>
                        </span> <!--删除文章-->
                                <?php
                                if ( has_post_thumbnail() ) { ?>
                                    <a href="<?php the_permalink($faverite_pro[$i]); ?>" target="_blank"><img src="<?php the_post_thumbnail_url('full')?>" class="cover" /></a>
                                <?php } else {?>
                                    <a href="<?php the_permalink($faverite_pro[$i]); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面" class="cover" /></a>
                                <?php } ?>
                                <div style="height: 1px;background-color: lightgray"></div>
                                <div class="caption">
                                    <div class="project-title"><a href="<?php the_permalink($faverite_pro[$i]); ?>" target="_blank"><?php echo get_the_title($faverite_pro[$i]); ?></a></div>
                                    <div>
                                        <span class="fa fa-user-o pull-left">&nbsp;<?php the_author($faverite_pro[$i]); ?></span><span class="fa fa-bookmark-o pull-right" id="project-category-info" > <?php the_category(', ') ?></span><span class="fa fa-eye pull-right" id="m-project-views" > <?php echo getProjectViews(get_the_ID()); ?></span><br>
                                        <span class="fa fa-clock-o pull-left"> <?php echo date('n月j日 G:i',get_the_time('U',$faverite_pro[$i]));?> </span><span class="fa fa-comments-o pull-right" > <?php comments_popup_link('0 ', '1 ', '% ', '', '评论已关闭'); ?></span><span class="fa fa-eye pull-right" id="web-project-views" > <?php echo getProjectViews($faverite_pro[$i]); ?></span><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php }
            }else{ ?>
                <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>  <!--关闭按钮-->
                    <strong>Oops,TA还没有收藏!</strong>去项目页面逛逛吧。
                </div>
            <?php } ?>
        </ul>
        <?php
        if($total_page>1){?>
            <div id="page_favorite" style="text-align:center;margin-bottom: 20px">
                <!--翻页-->
                <?php if($current_page==1){?>
                    <a href="<?php echo add_query_arg(array('paged'=>$current_page+1))?>">下一页&nbsp;&raquo;</a>
                <?php }elseif($current_page==$total_page){ ?>
                    <a href="<?php echo add_query_arg(array('paged'=>$current_page-1))?>">&laquo;&nbsp;上一页</a>
                <?php }else{?>
                    <a href="<?php echo add_query_arg(array('paged'=>$current_page-1))?>">&laquo;&nbsp;上一页&nbsp;</a>
                    <a href="<?php echo add_query_arg(array('paged'=>$current_page+1))?>">&nbsp;下一页&nbsp;&raquo;</a>
                <?php }?>
            </div>
        <?php } ?>
    </div>
    <div class="tab-pane fade" id="my-favorite-wiki" style="display: none;padding-top: 40px;">
        <div style="height: 1px;background-color: lightgray;"></div><br>
        <div id="wiki_list"></div>
        <script>
            $(function () {
                get_publish_wiki(<?=$current_user->ID?>);
            });
            function get_publish_wiki($user_id) {
                var get_contents = {
                    action: "get_user_related_wiki",
                    get_wiki_type: "publish",
                    userID: $user_id
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
                            $("#wiki_list").append("<p>"+"<a href=\"/?yada_wiki="+data.wikis[i].post_name+"\">"+data.wikis[i].post_title+"</a>"+"</p>");
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
        </script>
    </div>
</div>