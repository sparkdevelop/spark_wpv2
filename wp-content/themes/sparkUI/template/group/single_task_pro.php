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
            <span>群组: <a href="<?php echo site_url().get_page_address('single_group').'&id='.$group['ID']?>"><?= $group['group_name'] ?></a></span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
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
        <div id="m-task-info">
            <span>群组: <?= $group['group_name'] ?></span><br>
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
            <span style="font-size: 14px">(截止日期前仅项目链接可修改,项目成员写该用户在火花的用户名)</span>
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
                            <div>
                                <input type="text" class="form-control" name="team_member[]" id="team_member"
                                       value="<?= get_author_name($value) ?>"
                                       style="margin-left: 0px;" readonly/>
                            </div>
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
                            <input type="submit" class="btn-green" style="margin-top: 0;" id="apply-btn" value="更新任务">
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
                        <div style="display: inline">
                            <input type="text" class="form-control" name="team_member[]" id="team_member"
                                   style="margin-left: 0px;margin-right: 5px"
                                   placeholder="请填写本组成员火花用户名(请注意填写后不可更改!!)" value="" onblur="checkUserName(this.value)"
                                   onfocus="saveid(this)"
                            />
                            <div id="ajax-response_0" style="display: inline;margin-left: 10px"></div>
                        </div>
                        <div id="addField" style="display:inline;margin-top: 7px;margin-left: -4px"></div>
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

    <?php
    $table_content = pro_table($group_id, $task_id);
    ?>
    <div id="single-task-member-complete" style="margin-top: 30px">
        <?php $per_all = complete_percentage($group_id, $task_id) ?>
        <h4>组员完成情况 : <span style="font-size: 14px"><?= $per_all ?>%组员已完成</span></h4>
        <div id="task-pro-complete-table" class="table-responsive">
            <table id="task-complete-table-border" class="table table-bordered">
                <thead>
                <tr>
                    <th>组号</th>
                    <th style="display:none">id</th>
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
                <?php
                if (sizeof($table_content['team']) != 0) {  //存在已经组成了的队伍
                    foreach ($table_content['team'] as $key => $team) {  //对于每个team,每个team也有多行
                        $team_size = sizeof($team);  //一个team有几行
                        for ($i = 0; $i < $team_size; $i++) {  //每一行的内容
                            if ($i == 0) {  //每个team的第一行要显示更多的东西,比如组号,链接和评价
                                ?>
                                <tr>
                                    <td id="team_id" rowspan="<?= $team_size ?>"><?= $key + 1 ?>组</td>
                                    <td style="display: none"><?= $team[$i][0] ?></td>
                                    <td><?php echo the_author_meta('display_name',$team[$i][0]) ?></td>
                                    <?php for ($j = 2; $j < sizeof($team[$i]) - 2; $j++) { ?>
                                        <td><?= $team[$i][$j] ?></td>
                                    <?php } ?>
                                    <td id="pro_link" rowspan="<?= $team_size ?>"><a target="_blank"
                                            href="<?= $team[$i]['apply_content'] ?>"><?= $team[$i]['apply_content'] ?></a>
                                    </td>
                                    <?php
                                    if (is_group_admin($group_id)) { ?>
                                        <td id="grade" rowspan="<?= $team_size ?>">
                                            <script>
                                                $(function () {
                                                    var sel_id = '<?=$team[$i]['completion']?>';
                                                    document.getElementById("change_grade_<?=$key?>")[sel_id].selected = true;
                                                })
                                            </script>
                                            <select class="form-control" id="change_grade_<?= $key ?>"
                                                    onchange="change_grade(this.value,'<?= $key ?>')">
                                                <option value="0">待审核</option>
                                                <option value="1">不合格</option>
                                                <option value="2">合格</option>
                                                <option value="3">一般</option>
                                                <option value="4">良好</option>
                                                <option value="5">优秀</option>
                                                <option value="6">特优</option>
                                            </select>
                                        </td>
                                    <?php } else {
                                        $grade = transform_grade($team[$i]['completion']) //将数字转化为文字?>
                                        <td id="grade" rowspan="<?= $team_size ?>"><?= $grade ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } else { //team中的其他行,只显示基本信息
                                ?>
                                <tr>
                                    <td style="display: none"><?= $team[$i][0] ?></td>
                                    <td><?= $team[$i][1] ?></td>
                                    <?php for ($j = 2; $j < sizeof($team[$i]) - 2; $j++) { ?>
                                        <td><?= $team[$i][$j] ?></td>
                                    <?php } ?>
                                </tr>
                            <?php }
                        }
                    }
                }
                if (sizeof($table_content['ungroup']) != 0) {  //如果有未组队的人
                    $ungroup = $table_content['ungroup'];
                    for ($i = 0; $i < sizeof($ungroup); $i++) {
                        if ($i == 0) {  //每个team的第一行要显示更多的东西,比如组号,链接和评价
                            ?>
                            <tr>
                                <td id="team_id" rowspan="<?= sizeof($ungroup) ?>">未分组</td>
                                <td style="display: none"><?= $ungroup[$i][0] ?></td>
                                <td><?php echo the_author_meta('display_name',$ungroup[$i][0]) ?></td>
                                <?php for ($j = 2; $j < sizeof($ungroup[$i]) - 2; $j++) { ?>
                                    <td><?= $ungroup[$i][$j] ?></td>
                                <?php } ?>
                                <td id="pro_link" rowspan="<?= sizeof($ungroup) ?>"><a target="_blank"
                                        href="<?= $ungroup[$i]['apply_content'] ?>"><?= $ungroup[$i]['apply_content'] ?></a>
                                </td>
                                <td id="grade" rowspan="<?= sizeof($ungroup) ?>"><?= $ungroup[$i]['completion'] ?></td>
                            </tr>
                        <?php } else { //team中的其他行,只显示基本信息
                            ?>
                            <tr>
                                <td style="display: none"><?= $ungroup[$i][0] ?></td>
                                <td><?= $ungroup[$i][1] ?></td>
                                <?php for ($j = 2; $j < sizeof($ungroup[$i]) - 2; $j++) { ?>
                                    <td><?= $ungroup[$i][$j] ?></td>
                                <?php } ?>
                            </tr>
                        <?php }
                    }
                } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("[rowspan]").css({"vertical-align": "middle", "text-align": "center"});
        $("tbody tr td").css("vertical-align", 'middle');
    });

    var i = 0; //response名字系统
    var j = 0; //response 显示

    $(document).on('click', '#addNewFieldBtn', function () {
        i = i + 1;
        var rid = "ajax-response_" + i.toString();
        var input = '<div>' +
            '<input type="text" class="form-control" name="team_member[]" id="team_member" ' +
            'placeholder="本组成员" value="" onblur="checkUserName(this.value)" ' +
            'onfocus="saveid(this)"/>' +
            '<div style="display: inline;margin-left: 10px" id=' + rid + '>' +
            '</div>' +
            '</div>';
        $("#addField").append(input);


//        var input = '<input type="text" class="form-control" name="team_member[]" id="team_member" '  +
//            'placeholder="本组成员" value="" onblur="checkUserName(this.value)" />';
//        $("#addField").append(input);
    });
    function saveid(obj) {
        var nextNode = obj.nextSibling.nextSibling;  //ajax-response_0
        console.log(nextNode);
        if (nextNode == null) {   //1……
            var nextNode = obj.nextSibling;
        }
        var tmp = nextNode.id;
        var id = tmp.charAt(tmp.length - 1);
        j = id;
        console.log(j);

    }
    function checkLength(taskname, boxid) {
        var id = "#" + boxid;
        if (taskname.length == 0) {
            <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
            $(id).html("<img src='<?=$url?>' style='margin-left:20px;'><span>该项不能为空</span>");
            return false;
        } else {
            <?php $url = get_template_directory_uri() . "/img/OK.png";?>
            $(id).html("<img src='<?=$url?>' style='margin-left:20px;'>");
            return true;
        }
    }
    function checkUserName(name) {
        var data = {
            action: "checkUserName",
            name: name,
            group_id: '<?=$group_id?>',
            task_id : '<?=$task_id?>'
        };
        $.ajax({
            type: 'POST',
            url: '<?=$admin_url?>',
            data: data,
            success: function (response) {
                if (response == 0) {
                    <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                    $('#ajax-response_' + j.toString()).html("<img src='<?=$url?>'><span>用户名错误</span>");
                } else if (response == 1) {
                    <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                    $('#ajax-response_' + j.toString()).html("<img src='<?=$url?>'><span>用户不是本组组员</span>");
                } else if (response == 3){
                    <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                    $('#ajax-response_' + j.toString()).html("<img src='<?=$url?>'><span>用户已经组队了</span>");
                }
                else {
                    <?php $url = get_template_directory_uri() . "/img/OK.png";?>
                    $('#ajax-response_' + j.toString()).html("<img src='<?=$url?>'>");
                }
            }
        })
    }
    function checkSubmitPro() {
        var result = [];
        for (var k = 0; k < i; k++) {
            tmp = k.toString();
            var ajax_id = 'ajax-response_' + tmp;
            var ajax = document.getElementById(ajax_id);
            var tmp = $(ajax).find('img').attr('src');
            <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
            if (tmp != '<?=$url?>') {
                result.push(0);
            } else {
                result.push(1);
            }
        }
        var tname = document.getElementById('prolink');
        if ($.inArray(1, result) == -1 && checkLength(tname.value, 'checkTaskNamebox')) {
            return true;
        } else {
            layer.alert("请修正错误");
            return false;
        }
//        var ajax = document.getElementById('ajax-response');
//        var tmp = $(ajax).find('img').attr('src');
//        <?php //$url = get_template_directory_uri() . "/img/ERROR.png";?>
//        if ( && tmp != '<?//=$url?>//') {
//            return true;
//        } else {
//            layer.alert("请修正错误");
//            return false;
//        }
    }
    function change_grade(grade, team_id) {
        var data = {
            action: "change_grade",
            grade: grade,
            task_id: '<?=$task_id?>',
            team_id: team_id
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
</script>