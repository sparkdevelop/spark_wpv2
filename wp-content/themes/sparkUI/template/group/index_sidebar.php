<?php
//本页面是群组首页的侧边栏
?>
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <div class="alert alert-info">本版块还在开发中, 意见及建议可
        <a target="_blank" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=JRQUEhcSFBUdFBFlVFQLRkpI"
           style="text-decoration:none;font-weight: bolder;color: #fe642d">
            联系我们</a>
    </div>
    <?php if(is_user_logged_in()){ ?>
        <div class="sidebar_button">
            <a href="<?php echo site_url().get_page_address("creategroup");?>" style="color: white">创建群组</a>
        </div>
    <?php }else{ ?>
        <div class="sidebar_button">
            <a href="<?php echo wp_login_url( get_permalink() ); ?>" style="color: white">创建群组</a>
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
            $notification = get_gp_notification();
            for($i=0;$i<min(5,sizeof($notification));$i++){
                $task_author= $notification[$i]['task_author'];
                $task_identity= $notification[$i]['task_identity'];
                $group_name = $notification[$i]['group_name'];
                $task_name = $notification[$i]['task_name'];
                $task_address = $notification[$i]['task_address'];
//                ?>
<!--                <li class="list-group-item">-->
<!--                    <span>--><?//=$task_identity.$task_author?><!--在<span style="font-weight: bolder;">--><?//=$group_name?><!--</span>发布了任务</span>-->
<!--                    <span><a href="--><?//=$task_address?><!--" style="color: #169bd5">--><?//=$task_name?><!--</a></span>-->
<!--                </li>-->
                <li class="list-group-item">
                    <?php if($notification[$i]['notice_type'] == 1){ ?>
                        <span><?=$task_identity.$task_author?>在<span style="font-weight: bolder;"><?=$group_name?></span>发布了任务</span>
                        <span><a href="<?=$task_address?>" style="color: #169bd5"><?=$task_name?></a></span>
                    <?php }else if ($notification[$i]['notice_type'] == 2){ ?>
                        <span><?=$task_author?>加入了群组</span>
                        <span><a href="<?=$task_address?>" style="color: #169bd5"><?=$group_name?></a></span>
                    <?php }else if($notification[$i]['notice_type'] == 3){ ?>
                        <span><?=$task_author?>创建了群组</span>
                        <span><a href="<?=$task_address?>" style="color: #169bd5"><?=$group_name?></a></span>
                    <?PHP } else if($notification[$i]['notice_type'] == 4){?>
                        <span><?=$task_author?>完成了任务</span>
                        <span><a href="<?=$task_address?>" style="color: #169bd5"><?=$task_name?></a></span>
                    <?php }?>

                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>
<script>
    var flag_group = false;
    function show_all_groups() {
        var $all_groups=document.getElementById('all_groups');
        var $joined_groups = document.getElementById('joined_groups');
        if(flag_group){
            $all_groups.style.display ="block";
            $joined_groups.style.display="none";
        }else{
            $all_groups.style.display="none";
            $joined_groups.style.display="block";
        }
        flag_group =! flag_group;
    }
</script>
