<?php
?>
<script>
    flag = false;
    function show_all_groups() {
        var $all_groups = document.getElementById('all_groups');
        var $joined_groups = document.getElementById('joined_groups');
        if (flag) {
            $all_groups.style.display = "block";
            $joined_groups.style.display = "none";
        } else {
            $all_groups.style.display = "none";
            $joined_groups.style.display = "block";
        }
        flag = !flag;
    }
</script>

<style>
    #my_group_badge {
        color: #fe642d;
        border: solid 1px;
        border-color: #fe642d;
        float: right;
        margin-top: 10px;
    }

    #li_joined_groups {
        display: inline-block;
        width: 80%;
        float: right
    }

    #li_joined_groups a {
        margin-left: 10px;
        font-size: medium;
        font-weight: bold;
        height: 40px;
        line-height: 40px;
    }
</style>
<div class="side-tool" id="m-side-tool-project">

    <?php if (is_user_logged_in()) { ?>
        <ul>
            <li><a href="<?php echo site_url() . get_page_address("createtask"); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
        </ul>
            <?php } else { ?>
        <ul>
            <li><a href="<?php echo wp_login_url(get_permalink()); ?>"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
        </ul>
    <?php } ?>
</div>
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">

    <?php if (is_user_logged_in()) { ?>
        <div class="sidebar_button">
            <a href="<?php echo site_url() . get_page_address("createtask"); ?>" style="color: white">发布任务</a>
        </div>
    <?php } else { ?>
        <div class="sidebar_button">
            <a href="<?php echo wp_login_url(get_permalink()); ?>" style="color: white">发布任务</a>
        </div>
    <?php } ?>

    <!--    我加入了群组-->
    <div class="sidebar_list">
        <div class="sidebar_list_header">
            <p>我加入的群组</p>
            <a id="sidebar_list_link" onclick="show_all_groups()">全部群组</a>
        </div>
        <!--分割线-->
        <div class="sidebar_divline"></div>
        <?php $all_joined_group = get_current_user_group();?>
        <div id="joined_groups" style="word-wrap: break-word; word-break: keep-all;">
            <ul class="list-group">
                <?php
                $length = min(5,sizeof($all_joined_group));
                for($i=0;$i<$length;$i++){?>
                    <li class="list-group-item" style="width: 100%">
                        <div style="display: inline-block;width:20%">
                            <img src="<?=$all_joined_group[$i]['group_cover']?>" style="width: 40px;height: 40px">
                        </div>
                        <div id="li_joined_groups">
                            <a href="<?php echo site_url().get_page_address('single_group').'&id='.$all_joined_group[$i]['ID'];?>">
                                <?php echo mb_strimwidth($all_joined_group[$i]['group_name'] , 0, 16,"..");?>
                            </a>
                            <!--                            判断是否是该群群主-->
                            <?php
                            if(get_current_user_id() == $all_joined_group[$i]['group_author']){
                                echo '<span class="badge" id="my_group_badge">我创建的</span>';
                            } ?>
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>

        <div id="all_groups" style="display: none;word-wrap: break-word; word-break: keep-all;">
            <ul class="list-group">
                <?php
                foreach($all_joined_group as $value){?>
                    <li class="list-group-item">
                        <div style="display: inline-block;vertical-align: baseline">
                            <img src="<?=$value['group_cover']?>" style="width: 40px;height: 40px">
                        </div>
                        <div id="li_joined_groups">
                            <a href="<?php echo site_url().get_page_address('single_group').'&id='.$value['ID'];?>">
                                <?php echo mb_strimwidth($value['group_name'] , 0, 16,"..");?>
                            </a>
                            <!--                            判断是否是该群群主-->
                            <?php
                            if(get_current_user_id() == $value['group_author']){
                                echo '<span class="badge" id="my_group_badge">我创建的</span>';
                            } ?>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <!--最近加入  选取member中最后加入的四个   -->
    <div class="sidebar_list">
        <div class="sidebar_list_header">
            <p>最近加入</p>
        </div>
        <!--分割线-->
        <div class="sidebar_divline"></div>

        <div id="latestJoin">
            <?php
            $latest_active = get_latest_active($group_id);
            for ($j = 0; $j < min(5,sizeof($latest_active)); $j++) { ?>
                <div style="display: inline-block;margin-top: 10px">
                    <div style="text-align: center;width: 50px">
                        <?php echo get_avatar($latest_active[$j], 30, ''); ?>
                        <p style="width: 70px;word-wrap: break-word;margin-bottom: 0px">
                            <?php
                            $user_name = get_user_by('ID',$latest_active[$j])->display_name;
                            echo mb_strimwidth($user_name, 0, 7,".."); ?>
                        </p>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>

    <!--    群组动态-->
    <div class="sidebar_list">
        <div class="sidebar_list_header">
            <p>群组动态</p>
        </div>
        <!--分割线 下面的是列表-->
        <div class="sidebar_divline"></div>
        <!--列表内容 需要填写的都用php提取出来就行-->
        <ul class="list-group">
            <?php
            $notification = get_gp_notification($group_id);
            for($i=0;$i<min(5,sizeof($notification));$i++){
                $task_author= $notification[$i]['task_author'];
                $task_identity= $notification[$i]['task_identity'];
                $group_name = $notification[$i]['group_name'];
                $task_name = $notification[$i]['task_name'];
                $task_address = $notification[$i]['task_address'];
                ?>
                <li class="list-group-item">
                    <?php if($notification[$i]['notice_type'] == 1){ ?>
                        <span><?=$task_identity.$task_author?>发布了任务</span>
                        <span><a href="<?=$task_address?>" style="color: #169bd5"><?=$task_name?></a></span>
                    <?php }else if ($notification[$i]['notice_type'] == 2){ ?>
                        <span><?=$task_author?>加入了本组</span>
                    <?php } else if($notification[$i]['notice_type'] == 4){?>
                        <span><?=$task_author?>完成了任务</span>
                        <span><a href="<?=$task_address?>" style="color: #169bd5"><?=$task_name?></a></span>
                    <?php } ?>
                </li>
                <?php } ?>
        </ul>
    </div>
</div>
