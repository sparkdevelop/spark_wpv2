<style>
    .btn-green{ width: 60px;height: 35px;float: right;font-size: 14px;margin-top: 0px  }
</style>
<div class="col-md-9 col-sm-9 col-xs-12"  id="col9">
    <div id="single-group-title">
        <div id="group-ava">
            <img src="<?=$group['group_cover']?>" style="width: 85px;height: 85px">
        </div>
        <div id="group-info" style="margin-left: 20px">
            <div class="group_title">
                <span id="h4_name"><?=$group['group_name']?></span>
                <span style="color: #fe642d;margin-left: 20px">已加入</span>
            </div>
            <div class="group_others">
                <span><?=$group['member_count']?>个成员</span>&nbsp;&nbsp;
                <span>管理员</span>
                <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$group['group_author'];?>" style="color: #169bd5"><?php echo get_author_name($group['group_author'])?></a>
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
            <li><a href="<?php echo esc_url(add_query_arg( array('tab'=>'manage','paged'=>1 ) ) )?>">群组管理</a></li>
        <?php } elseif(array_search("tab=manage",$query_parse)){?>
            <li><a href="<?php echo esc_url(add_query_arg( array('tab'=>'task','paged'=>1 ) ) )?>">群组任务</a></li>
            <li><a href="<?php echo esc_url(add_query_arg( array('tab'=>'member','paged'=>1 ) ) )?>">成员列表</a></li>
            <li class="active"><a href="<?php echo esc_url(add_query_arg( array('tab'=>'manage','paged'=>1 ) ) )?>">群组管理</a></li>
        <?php } else{ ?>
            <li class="active"><a href="<?php echo esc_url(add_query_arg( array('tab'=>'task','paged'=>1 ) ) )?>">群组任务</a></li>
            <li><a href="<?php echo esc_url(add_query_arg( array('tab'=>'member','paged'=>1 ) ) )?>">成员列表</a></li>
            <li><a href="<?php echo esc_url(add_query_arg( array('tab'=>'manage','paged'=>1 ) ) )?>">群组管理</a></li>
        <?php } ?>
        </ul>

        <?php
        $tab = isset($_GET['tab']) && !empty($_GET['tab']) ? $_GET['tab'] : 'task';
        if($tab=='task'){
            require 'group_task.php';
        }elseif ($tab=='member'){
            require 'group_member.php';
        }else{
            require 'group_manage.php';
        }
        ?>
    </div>
</div>