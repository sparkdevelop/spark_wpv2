<?php
$group = get_group($group_id)[0];
$countdown = countDown($task_id);
$member_info = get_member_info($group_id);
$group_verify_field = get_verify_field($group_id, 'group');
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
            <span style="font-size: 14px">(截止日期前项目链接均可修改,项目成员写该用户在火花的用户名)</span>
        </h4>
        <?php if (is_complete_task($task_id, get_current_user_id())) { //更新 ?>
            <form class="form-horizontal" role="form" name="profile" method="post" onsubmit="return checkSubmitPro()"
                  action="<?php echo esc_url(self_admin_url('process-update_pro.php')); ?>">
                <!--项目链接-->
                <div class="form-group" style="margin: 20px 0px">
                    <label for="proname" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">项目链接<span
                            style="color: red">*</span></label>
                    <div class="col-sm-5">
                        <?php $value = get_user_task_content($task_id); ?>
                        <input type="text" class="form-control" name="prolink" id="prolink" placeholder="请输入项目链接"
                               value="<?= $value['apply_content'] ?>"
                               onblur="checkLength(this.value,'checkLinkbox')"/>
                    </div>
                    <span style="line-height: 30px;height: 30px" id="checkLinkbox"></span>
                </div>
                <!--项目成员-->
                <div class="form-group" style="margin: 20px 0px">
                    <label for="tabstract" class="col-sm-2 col-md-2 col-xs-12 control-label"
                           style="float: left">项目成员<span
                            style="color: red">*</span></label>
                    <div class="col-sm-8">
                        <?php $team_member = get_team_member($task_id);
                        foreach ($team_member as $value) {
                            ?>
                            <input type="text" class="form-control" name="team_member[]" id="team_member"
                                   style="margin-right:0px;margin-bottom:10px;display:inline;width: 15%"
                                   value="<?= get_author_name($value[0]) ?>" readonly/>
                        <? } ?>
                    </div>
                </div>
                <div class="form-group" style="display: none">
                    <?php $team_id = get_team_id($task_id); ?>
                    <input type="hidden" name="task_id" value="<?= $task_id ?>"/>
                    <input type="hidden" name="team_id" value="<?= $team_id ?>"/>
                </div>
                <?php
                if (!is_overdue($task_id)) {
                    ?>
                    <div class="form-group" style="margin-bottom: 30px">
                        <div class="col-sm-offset-1 col-sm-10">
                            <input type="submit" class="btn-green" style="margin-top: 0px" id="apply-btn" value="更新任务">
                        </div>
                    </div>
                <? } ?>
            </form>
        <?php } else { // 首次插入?>
            <form class="form-horizontal" role="form" name="profile" method="post" onsubmit="return checkSubmitPro()"
                  action="<?php echo esc_url(self_admin_url('process-apply_pro.php')); ?>">
                <!--项目链接-->
                <div class="form-group" style="margin: 20px 0px">
                    <label for="proname" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">项目链接<span
                            style="color: red">*</span></label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="prolink" id="prolink" placeholder="请输入项目链接"
                               value=""
                               onblur="checkLength(this.value,'checkLinkbox')"/>
                    </div>
                    <span style="line-height: 30px;height: 30px" id="checkLinkbox"></span>
                </div>
                <!--项目成员-->
                <div class="form-group" style="margin: 20px 0px">
                    <label for="tabstract" class="col-sm-2 col-md-2 col-xs-12 control-label"
                           style="float: left">项目成员<span
                            style="color: red">*</span></label>
                    <div class="col-sm-8">
                        <input type="button" id="addNewFieldBtn" value="+" style="display:inline">
                        <input type="text" class="form-control" name="team_member[]" id="team_member"
                               style="margin-right:0px;margin-bottom:10px;display:inline;width: 15%"
                               placeholder="本组成员" value="" onblur="checkUserName(this.value)"/>
                        <div id="addField" style="display:inline;margin-top: 7px;margin-left: -4px"></div>
                        <div id="ajax-response" style="display: inline;margin-left: 10px"></div>
                    </div>
                </div>
                <div class="form-group" style="display: none">
                    <input type="hidden" name="task_id" value="<?= $task_id ?>"/>
                </div>
                <?php
                if (!is_overdue($task_id)) {
                    ?>
                    <div class="form-group" style="margin-bottom: 30px">
                        <div class="col-sm-offset-1 col-sm-10">
                            <input type="submit" class="btn-green" style="margin-top: 0px" id="apply-btn" value="提交任务">
                        </div>
                    </div>
                <?php } ?>
            </form>
        <?php } ?>
    </div>
    <div class="divline"></div>



    <div id="single-task-member-complete" style="margin-top: 30px">
        <?php $per_all = complete_percentage($group_id,$task_id)?>
        <h4>组员完成情况 : <span style="font-size: 14px"><?=$per_all?>%组员已完成</span></h4>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>组号</th>
                <th>用户名</th>
                <?php //验证字段
                if (sizeof($group_verify_field) != 0) {
                    for ($i = 0; $i < sizeof($group_verify_field); $i++) { ?>
                        <th><?= $group_verify_field[$i] ?></th>
                    <?php }
                } ?>
                <th>项目链接</th>
                <th>评分</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td id="team_id" rowspan="3">1组</td>
                <td>lyl222</td>
                <?php for ($j = 2; $j < sizeof($group_verify_field) + 2; $j++) { ?>
                    <td><?= $member_info[0][$j] ?></td>
                <?php } ?>
                <td id="pro_link" rowspan="3">http://localhost/wordpress/?p=248</td>
                <td id="grade" rowspan="3">perfect</td>
            </tr>
            <tr>
                <td>如影随风</td>
                <?php for ($j = 2; $j < sizeof($group_verify_field) + 2; $j++) { ?>
                    <td><?= $member_info[1][$j] ?></td>
                <?php } ?>
            </tr>
            <tr>
                <td>黄冰瑶</td>
                <?php for ($j = 2; $j < sizeof($group_verify_field) + 2; $j++) { ?>
                    <td><?= $member_info[2][$j] ?></td>
                <?php } ?>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function () {
        $("[rowspan]").css({"vertical-align": "middle", "text-align": "center"});
    });
    $(document).on('click', '#addNewFieldBtn', function () {
        var input = '<input type="text" class="form-control" name="team_member[]" id="team_member" ' +
            'style="margin-left: 10px;margin-bottom:10px;display:inline;width: 15%" ' +
            'placeholder="本组成员" value="" onblur="checkUserName(this.value)" />';
        $("#addField").append(input);
    });
    function checkLength(taskname, boxid) {
        var id = "#" + boxid;
        if (taskname.length == 0) {
            <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
            $(id).html("<img src='<?=$url?>'><span>该项不能为空</span>");
            return false;
        } else {
            <?php $url = get_template_directory_uri() . "/img/OK.png";?>
            $(id).html("<img src='<?=$url?>'>");
            return true;
        }
    }
    function checkUserName(name) {
        var data = {
            action: "checkUserName",
            name: name,
            group_id: '<?=$group_id?>'
        };
        $.ajax({
            type: 'POST',
            url: '<?=$admin_url?>',
            data: data,
            success: function (response) {
                if (response == false) {
                    <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                    $('#ajax-response').html("<img src='<?=$url?>'><span>用户名错误</span>");
                } else {
                    <?php $url = get_template_directory_uri() . "/img/OK.png";?>
                    $('#ajax-response').html("<img src='<?=$url?>'>");
                }
            }
        })
    }
    function checkSubmitPro() {
        var tname = document.getElementById('prolink');
        var ajax = document.getElementById('ajax-response');
        var tmp = $(ajax).find('img').attr('src');
        <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
        if (checkLength(tname.value, 'checkTaskNamebox') && tmp != '<?=$url?>') {
            return true;
        } else {
            layer.alert("请修正错误");
            return false;
        }
    }
</script>