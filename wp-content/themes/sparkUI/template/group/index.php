<!-- 本页面是群组的主页,按照我的收藏写翻页-->
<style>
    #group-ava{
        display: inline-block;
        float: left;
        width: 10%;
    }
    #group-info{
        display: inline-block;
        width: 60%;
    }
    #latest-active{
        display: inline-block;
        float: right;
    }
    .group_title h4{
        margin-bottom: 10px;
        margin-top: 0px;
    }
    .group_others{
        margin-top: 10px;
    }
</style>
<div class="col-md-9 col-sm-9 col-xs-12"  id="col9">
    <h4 class="index_title" style="margin-left: 20px">所有群组</h4>
    <div class="divline"></div>
    <ul class="list-group">
    <?php
    //翻页
    $total_group = 18;
    $perpage = 10;
    $total_page = ceil($total_group/$perpage); //计算总页数
    if(!$_GET['paged']){
        $current_page = 1;
    }
    else{
        $page_num=$_GET['paged'];
        $current_page = $page_num;
    }
    if($total_group!=0) {
        $temp = $total_group < $perpage * $current_page ? $total_group : $perpage * $current_page;

        for ($i=$perpage*($current_page-1);$i<$temp;$i++) {
            $group_name = "造梦空间";
            $member = 32;
            ?>
            <li class="list-group-item">
                <div id="group-ava">
                    <img src="<?php bloginfo("template_url") ?>/img/group_ava.png">
                </div>
                <div id="group-info">
                    <div class="group_title">
                        <a class="group_name" href="#"><h4><?= $group_name ?></h4></a>
                    </div>
                    <div class="group_abs">
                        所谓造梦，造的不是浑浑噩噩的白日梦，而是一个个鲜活的梦想
                    </div>
                    <div class="group_others">
                        <span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">已加入</span>&nbsp;&nbsp;
                        <span><?= $member ?>个成员</span>&nbsp;&nbsp;
                        <span>管理员</span>
                        <a href="#" style="color: #169bd5">如影随风</a>
                    </div>
                </div>
                <div id="latest-active">
                    <div>最近活跃</div>
                    <?php
                    for ($j = 0; $j < 3; $j++) {
                        ?>
                        <div style="display: inline-block;margin-top: 10px">
                            <div style="text-align: center">
                                <?php echo get_avatar(get_current_user_id(), 30, ''); ?>
                            </div>
                            <?php
                            echo wp_get_current_user()->display_name;
                            ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="divline"></div>
            </li>
        <?php }
    } ?>
    </ul>
    <?php
    if($total_page>1){?>
    <div id="group-pagination" style="text-align:center;margin-bottom: 20px">
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
