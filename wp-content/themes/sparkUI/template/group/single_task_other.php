<?php
$group = get_group($group_id)[0];
$countdown = countDown($task_id);
?>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <div id="single-task-title">
        <h3>任务 : <?= $task['task_name'] ?></h3>
        <div id="task-info" style="margin-top: 20px">
            <span>群组: <?= $group['group_name'] ?></span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
            <span>截止: <?= $task['deadline'] ?></span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
            <?php
            if ($countdown != 0) {
                $countdown = "还剩 " . $countdown . " 天";
            } else {
                $countdown = "已截止";
            }
            ?>
            <span style="color: #fe642d"><?= $countdown ?></span>
        </div>
    </div>
    <div class="divline"></div>
    <div id="single-task-abstract">
        <h4>任务详情: </h4>
        <p><?= $task['task_content'] ?></p>
    </div>
    <div id="single-task-complete">
        <h4 style="margin-top: 25px">完成任务&nbsp;&nbsp;
            <span style="font-size: 14px">(截止日期前均可修改)</span> &nbsp;&nbsp;&nbsp;&nbsp;
            <span style="font-size: 15px;line-height: 30px;height: 30px" id="checkLinkbox"></span>
        </h4>
    </div>
    <?php
    //控制截止

    if (is_complete_task($task_id, get_current_user_id())){ //更新?>
        <form class="form-horizontal" role="form" name="profile" method="post" onsubmit="return checkSubmitTask()"
          action="<?php echo esc_url(self_admin_url('process-update_other.php')); ?>">
        <!--任务内容-->
        <div class="form-group" style="margin: 20px 0px">
            <?php $value = get_user_task_content($task_id); ?>
            <textarea class="form-control" rows="6" name="othercontent" onblur="checkLength(this.value,'checkLinkbox')"><?= $value['apply_content'] ?></textarea>
        </div>
        <div class="form-group" style="display: none">
            <input type="hidden" name="task_id" value="<?= $task_id ?>"/>
            <input type="hidden" name="user_id" value="<?=get_current_user_id();?>"/>
        </div>
        <div class="form-group" style="margin-bottom: 30px">
            <div class="col-sm-10">
                <?php if(!is_overdue($task_id)){
                    echo '<input type="submit" class="btn-green" style="margin-top: 0px" id="apply-btn" value="更新任务">';
                } else {
                    echo '<input type="submit" class="btn-green" style="margin-top: 0px" id="apply-btn" disabled value="已截止">';
                }?>
            </div>
        </div>
    </form>
    <?php }
    else { //首次插入 ?>
        <form class="form-horizontal" role="form" name="profile" method="post" onsubmit="return checkSubmitTask()"
              action="<?php echo esc_url(self_admin_url('process-apply_other.php')); ?>">
            <!--任务内容-->
            <div class="form-group" style="margin: 20px 0px">
                <textarea class="form-control" rows="6" name="othercontent" onblur="checkLength(this.value,'checkLinkbox')"></textarea>
            </div>
            <div class="form-group" style="display: none">
                <input type="hidden" name="task_id" value="<?= $task_id ?>"/>
                <input type="hidden" name="user_id" value="<?=get_current_user_id();?>"/>
            </div>
            <div class="form-group" style="margin-bottom: 30px">
                <div class="col-sm-10">
                    <?php if(!is_overdue($task_id)){
                        echo '<input type="submit" class="btn-green" style="margin-top: 0px" id="apply-btn" value="提交任务">';
                    } else{
                        echo '<input type="submit" class="btn-green" style="margin-top: 0px" id="apply-btn" disabled value="已截止">';
                    }?>
                </div>
            </div>
        </form>
    <?php } ?>

    <div class="divline"></div>

    <div id="single-task-member-complete" style="margin-top: 30px">
        <?php $per_all = complete_percentage($group_id, $task_id) ?>
        <h4>组员完成情况 : <span class="pull-right" style="font-size: 14px" ><?=$per_all?>%组员已完成</span> </h4>
    </div><br>
    <div class="dwqa-answers-list">
        <?php $all_complete = task_complete_other($task_id);
        foreach ($all_complete as $value){ ?>
            <div class="dwqa-answer-item" style="padding: 15px 0px">
                <!--头像-->
                <div style="display: inline-block;vertical-align: top;margin-left: 30px">
                    <?php echo get_avatar($value['user_id'],36,'');?>
                </div>
                <!--内容-->
                <div style="display: inline-block;vertical-align: top;width: 95%">
                    <!--审核状态-->
                    <?php
                    if (is_group_admin($group_id)) { ?>
                    <div class="dropdown" style="float: right">
                        <script>
                            $(function () {
                                var sel_id = '<?=$value['completion']?>';
                                document.getElementById("other_<?=$value['user_id']?>")[sel_id].selected = true;
                            })
                        </script>
                        <select class="form-control" id="other_<?=$value['user_id']?>"
                                onchange="change_grade_other(this.value,<?=$value['user_id']?>)">
                            <option value="0">待审核</option>
                            <option value="1">pass</option>
                            <option value="2">good</option>
                            <option value="3">great</option>
                            <option value="4">perfect</option>
                        </select>
                    </div>
                    <?php } else {
                        $grade = transform_grade($value['completion']) //将数字转化为文字?>
                        <div class="dropdown" style="float: right" id="grade"><?=$grade?></div>
                    <?php } ?>
                    <div style="color:gray">
                        <div style="margin-bottom: 10px">
                            <!--提交者信息--->
                            <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$value['user_id']; ?>" class="ask-author" style="margin-left: 20px;">
                                <?php echo get_author_name($value['user_id'])?>
                            </a>
                        </div>
                        <!--提交时间-->
                        <p class="ask_date" style="margin-left: 20px;"><?=$value['complete_time']?></p>
                    </div>
                    <!--任务内容-->
                    <div style="color: gray;margin-left: 20px;font-size: 16px;">
                        <p><?=$value['apply_content']?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

</div>
<script>
    function change_grade_other(grade, user_id) {
        var data = {
            action: "change_grade_other",
            grade: grade,
            task_id: '<?=$task_id?>',
            user_id:user_id
        };
        $.ajax({
            data: data,
            type: "POST",
            url: '<?=$admin_url?>',
            success: function (response) {
                layer.msg("审核成功", {time: 2000, icon: 1});
            },
            error: function () {
                layer.msg("操作失败", {time: 2000, icon: 2});
            }
        })
    }
    function checkLength(taskname,boxid) {
        var id = "#"+boxid;
        if(taskname.length == 0){
            <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
            $(id).html("<img src='<?=$url?>'><span>提交的任务内容不能为空</span>");
            return false;
        }else{
            <?php $url = get_template_directory_uri() . "/img/OK.png";?>
            $(id).html("<img src='<?=$url?>'>");
            return true;
        }
    }
</script>