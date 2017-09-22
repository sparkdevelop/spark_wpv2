<?php
    //获取该组的所有任务?未截止的?
    $all_task = get_task($group_id);
    if (sizeof($all_task) != 0 ){?>
        <div>
            <?php for($i=0;$i<sizeof($all_task);$i++){  //没有翻页?>
                <div style="height: 1px;background-color: lightgray"></div>
                <div class="group-task">
                    <div class="group-task-status-info">
                        <?php
                        if(is_group_member($group_id)){?>
                            <h4><a style="color: black" href="<?php echo site_url().get_page_address('single_task').'&id='.$all_task[$i]['ID'];?>"><?=$all_task[$i]['task_name']?></a></h4>
                        <?php }else{ ?>
                            <h4><a style="color: black;cursor: pointer" onclick="layer.msg('还未加入群组,不能查看任务', {time: 2000, icon: 4});"><?=$all_task[$i]['task_name']?></a></h4>
                        <?php } ?>
                        <div style="margin-top: 10px">
                            <span>发布人:</span>
                            <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$all_task[$i]['task_author'];?>" style="color: #169bd5"><?php echo get_author_name($all_task[$i]['task_author'])?></a>
                            <?php $per_all = complete_percentage($group_id,$all_task[$i]['ID']);?>
                            <span id="group-task-status-info-status"><?=$per_all?>%成员已完成</span>
                        </div>
                            <div id="m-group-task-status-info-status"><span><?=$per_all?>%成员已完成</span></div>
                    </div>
                    <div class="group-task-btn">
                        <?php
                            if(is_group_member($group_id)){
                                if(!is_overdue($all_task[$i]['ID'])){?>
                                    <button class="btn-green" onclick="location.href ='<?php echo site_url().get_page_address('single_task').'&id='.$all_task[$i]['ID'];?>'">去完成</button>
                                <?php } else{ ?>
                                    <button class="btn-white">已截止</button>
                                <?php }
                            } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
<?php
    } else {
        echo '<div class="divline" style="margin-top: 0px"></div>';
        echo '<div class="alert alert-info" style="margin-top: 20px">Oops, 该群组还没有任务</div>';
    }
?>

