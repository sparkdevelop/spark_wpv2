<?php ?>
<style>
    .btn-green{ width: 60px;height: 35px;float: right;font-size: 14px;margin-top: 0px  }
</style>
<script>
    function join_the_group($group_id) {
        //ajax
        var data = {
            action: 'join_the_group',
            group_id: $group_id
        };
        $.ajax({
            //async: false,    //否则永远返回false
            type: "POST",
            url: "<?=admin_url('admin-ajax.php');?>",
            data: data,
            success: function () {
                layer.msg("您已成功加入", {time: 2000, icon: 1});
                location.reload();
            },
            error:function () {
                alert("error");
            }
        });
    }
</script>
<div class="col-md-9 col-sm-9 col-xs-12"  id="col9">
    <div id="single-group-title">
        <div id="group-ava">
            <img src="<?=$group['group_cover']?>" style="width: 85px;height: 85px">
        </div>
        <div id="group-info" style="margin-left: 20px">
            <div class="group_title">
                <span id="h4_name"><?=$group['group_name']?></span>
                <span style="color: #fe642d;margin-left: 20px"><button onclick="join_the_group(<?=$group['ID']?>)">加入</button></span>
            </div>
            <div class="group_others">
                <span><?=$group['member_count']?>个成员</span>&nbsp;&nbsp;
                <span>管理员</span>
                <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$author;?>" style="color: #169bd5"><?php echo get_author_name($author)?></a>
            </div>
            <div class="group_create_time">
                <span>创建于:&nbsp;</span>
                <span><?=$group['create_date']?></span>
            </div>
        </div>
    </div>
    <div id="single-group-abstract">
        <p><span style="font-weight: bold">群组简介:</span><?=$group['group_abstract']?></p>
    </div>
    <div id="single-group-tab">
        <ul id="single-group-leftTab" class="nav nav-pills">
            <?php
            $current_url = curPageURL();
            $url_array=parse_url($current_url);
            $query_parse=explode("&",$url_array['query']);
            if(array_search("tab=member",$query_parse)){?>
                <li><a href="<?php echo esc_url(add_query_arg( array('tab'=>'task','paged'=>1 ) ) )?>">群组任务</a></li>
                <li class="active"><a href="<?php echo esc_url(add_query_arg( array('tab'=>'member','paged'=>1 ) ) )?>">成员列表</a></li>
            <?php } else{ ?>
                <li class="active"><a href="<?php echo esc_url(add_query_arg( array('tab'=>'task','paged'=>1 ) ) )?>">群组任务</a></li>
                <li><a href="<?php echo esc_url(add_query_arg( array('tab'=>'member','paged'=>1 ) ) )?>">成员列表</a></li>
            <?php } ?>
        </ul>

        <?php
        $tab = isset($_GET['tab']) && !empty($_GET['tab']) ? $_GET['tab'] : 'task';
        if ($tab=='task'){
            require 'group_task.php';
        }else{
            require 'group_member.php';
        }
        ?>
    </div>
</div>