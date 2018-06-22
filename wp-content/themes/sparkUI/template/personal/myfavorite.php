<?php
wp_enqueue_style('fep-style');
wp_enqueue_script('fep-script');
wp_enqueue_media();
$admin_url=admin_url( 'admin-ajax.php' );

$user_id =isset($_GET["id"]) ? $_GET["id"] : get_current_user_id();
$faverite_pro = showFavorite($user_id);

$origin_url = get_permalink(); //当前url
$pro_length = sizeof($faverite_pro); //收藏项目总数
$perpage = 12;       //12
$total_page = ceil($pro_length/$perpage); //计算总页数
if(!$_GET['paged']){
    $current_page = 1;
}
else{
    $page_num=$_GET['paged'];
    $current_page = $page_num;?>
<?php } ?>

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
</script>
<ul id="leftTab" class="nav nav-pills" style="height: 42px">
    <li class="active"><a href="#my-favorite-project" data-toggle="tab">项目收藏(<?=$pro_length?>)</a></li>
    <li><a href="#my-favorite-wiki" data-toggle="tab">wiki收藏(<span id="wiki_favorite"></span>)</a></li>
</ul>

<div id="rightTabContent" class="tab-content" >
    <div class="tab-pane fade in active" id="my-favorite-project" style="padding-top: 40px;">
        <div style="height: 1px;background-color: lightgray;"></div><br>
        <ul class="list-group">
            <?php
            if($pro_length!=0){
                $temp = $pro_length < $perpage*$current_page ? $pro_length : $perpage*$current_page;
                for($i=$perpage*($current_page-1);$i<$temp;$i++){?>
                    <li style="list-style-type: none;">
                        <div class="col-md-4 col-sm-4 col-xs-6" id="project-fluid">
                            <div class="thumbnail" id="project-div-fluid">
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
                                        <span class="fa fa-user-o pull-left">&nbsp;<?php the_author($faverite_pro[$i]); ?></span>
                                        <span class="fa fa-bookmark-o pull-right" id="project-category-info" ><?php the_category(', ','',$faverite_pro[$i]) ?></span>
                                        <span class="fa fa-eye pull-right" id="m-project-views" > <?php echo getProjectViews(get_the_ID()); ?></span>
                                        <br>
                                        <span class="fa fa-clock-o pull-left"> <?php echo date('n月j日 G:i',get_the_time('U',$faverite_pro[$i]));?> </span>
                                        <span class="fa fa-comments-o pull-right" ><?php Spark_comments_popup_link('0 ', '1 ', '% ', '', '评论已关闭',$faverite_pro[$i]); ?></span>
                                        <span class="fa fa-eye pull-right" id="web-project-views" ><?php echo getProjectViews($faverite_pro[$i]); ?></span><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php }
            }else{ ?>
                <div class="alert alert-info">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>  <!--关闭按钮-->
                    <strong>Oops,还没有收藏!</strong>去项目页面逛逛吧。
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
        <?php }

        if($current_page==$total_page && $pro_length%3!=0){?>
            <script>
                var flag=true;
                pageFavorite(flag);
            </script>
        <?php } ?>
    </div>
    <div class="tab-pane fade" id="my-favorite-wiki" style="padding-top: 40px;">
        <div style="height: 1px;background-color: lightgray;"></div><br>
        <div id="wiki_list"></div>
        <script>
            $(function () {
                get_favorite_wiki(<?=$user_id?>,'<?=$admin_url?>');
            });
        </script>
    </div>
</div>