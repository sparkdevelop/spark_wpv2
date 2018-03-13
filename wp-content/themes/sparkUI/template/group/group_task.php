<style>
    .btn-green {
        width: 60px;
        height: 35px;
        float: right;
        font-size: 14px;
        margin-top: 0px
    }
    .btn-white{
        margin-right: 15px;
    }
</style>
<?php
    //获取该组的所有任务?未截止的?
    $all_task = get_task($group_id);
    $all_task = task_order($all_task);
    $admin_url = admin_url( 'admin-ajax.php' );
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
                            <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$all_task[$i]['task_author'];?>" style="color: #169bd5"><?php echo get_the_author_meta('user_login',$all_task[$i]['task_author'])?></a>
                            <?php $per_all = complete_percentage($group_id,$all_task[$i]['ID']);?>
                            <span id="group-task-status-info-status"><?=$per_all?>%成员已完成</span>
                        </div>
                            <div id="m-group-task-status-info-status"><span><?=$per_all?>%成员已完成</span></div>
                    </div>
                    <div class="group-task-btn">
                        <?php
                        if (is_group_member($group_id)) {
                            if (!is_overdue($all_task[$i]['ID'])) {
                                ?>
                                <button class="btn-green"
                                        onclick="location.href ='<?php echo site_url() . get_page_address('single_task') . '&id=' . $all_task[$i]['ID']; ?>'">
                                    去完成
                                </button>
                            <?php } else { ?>
                                <button class="btn-white">已截止</button>
                            <?php }
                        }
                        if(is_group_admin($group_id)){?>
                            <button class="btn-green" style="width: 80px"
                                    onclick="location.href ='<?php echo site_url() . get_page_address('update_task') . '&group_id='.$group_id.'&id=' . $all_task[$i]['ID']; ?>'">
                                设置任务
                            </button>
                            <button class="btn-green" style="width: 80px"
                                    onclick="deleteTask(<?=$all_task[$i]['ID']?>)">
                                删除任务
                            </button>
                        <?php } ?>
                    </div>
                    <div class="m-group-task-btn">
                        <?php
                        if (is_group_member($group_id)) {
                            if (!is_overdue($all_task[$i]['ID'])) {
                                ?>
                                <button class="m-btn-green"
                                        onclick="location.href ='<?php echo site_url() . get_page_address('single_task') . '&id=' . $all_task[$i]['ID']; ?>'">
                                    去完成
                                </button>
                            <?php } else { ?>
                                <button class="m-btn-white">已截止</button>
                            <?php }
                        }
                        if(is_group_admin($group_id)){?>
                            <button class="m-btn-green" style="width: 80px"
                                    onclick="location.href ='<?php echo site_url() . get_page_address('update_task') . '&group_id='.$group_id.'&id=' . $all_task[$i]['ID']; ?>'">
                                设置任务
                            </button>
                            <button class="m-btn-green" style="width: 80px"
                                    onclick="deleteTask(<?=$all_task[$i]['ID']?>)">
                                删除任务
                            </button>
                        <?php } ?>
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
<script>
    function deleteTask($task_id) {
        layer.confirm('确定删除当前任务?', {
            icon: 3,
            resize: false,
            move: false,
            title: false,
            btnAlign: 'c',
            btn: ['确认', '取消'],
            btn2: function (index) {   //取消的回调
                layer.close(index);
            },
            btn1: function () {   //确认的回调
                var data = {
                    action: 'delete_task',
                    task_id: $task_id,
                };
                $.ajax({
                    //async: false,    //否则永远返回false
                    type: "POST",
                    url: '<?=$admin_url?>',
                    data: data,
                    dataType: "text",
                    success: function () {
                        layer.msg('已删除', {time: 2000, icon: 1});
                        location.reload();
                    }
                });
            }
        });
    }
</script>

