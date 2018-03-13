<?php
$group = get_group($group_id)[0];
$countdown = countDown($task_id);
wp_enqueue_media();
$admin_url = admin_url('admin-ajax.php');
?>
<style>
    .wp-editor-container {
        border: 1px solid lightgray;
        border-top: none;
    }
</style>
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
            <span style="font-size: 14px">(截止日期前均可修改)</span> &nbsp;&nbsp;&nbsp;&nbsp;
            <span style="font-size: 15px;line-height: 30px;height: 30px" id="checkLinkbox"></span>
        </h4>
    </div>
    <?php
    //控制截止
    if (is_complete_task($task_id, get_current_user_id())) { //更新
        ?>
        <form class="form-horizontal" role="form" name="profile" method="post" onsubmit="return checkSubmitOther()"
              action="<?php echo esc_url(self_admin_url('process-update_other.php')); ?>">
            <!--任务内容-->
            <div class="form-group" style="margin: 20px 0px">
                <?php $value = get_user_task_content($task_id); ?>
                <?php wp_editor($value['apply_content'], 'task_other_editor', array(
                        'teeny' => true, 'textarea_rows' => 6)
                );
                ?>
            </div>
            <!--项目成员:如果有成员则显示,否则不显示-->
            <?php $team_member = get_team_member($task_id);
            if (sizeof($team_member) != 0) { ?>
                <div class="form-group" style="margin: 20px 0px">
                    <label for="tabstract" class="col-sm-2 col-md-2 col-xs-4 control-label"
                           style="float: left;text-align: left;">项目成员</label>
                    <div class="col-sm-8">
                        <?php foreach ($team_member as $value) { ?>
                            <div>
                                <input type="text" class="form-control" name="team_member[]" id="team_member"
                                       value="<?= get_the_author_meta('user_login',$value) ?>"
                                       style="margin-left: 0px;" readonly/>
                            </div>
                        <? } ?>
                    </div>
                </div>
            <?php } ?>
            <div class="form-group" style="display: none">
                <?php $team_id = get_team_id($task_id); ?>
                <input type="hidden" name="task_id" value="<?= $task_id ?>"/>
                <input type="hidden" name="team_id" value="<?= $team_id ?>"/>
            </div>

            <div class="form-group" style="margin-bottom: 30px">
                <div class="col-sm-10">
                    <?php if (!is_overdue($task_id)) {
                        echo '<input type="submit" class="btn-green" style="margin-top: 0px" id="apply-btn" value="更新任务">';
                    } else {
                        echo '<input type="submit" class="btn-green" style="margin-top: 0px" id="apply-btn" disabled value="已截止">';
                    } ?>
                </div>
            </div>
        </form>
    <?php }
    else { //首次插入 ?>
        <form class="form-horizontal" role="form" name="profile" method="post" onsubmit="return checkSubmitOther()"
              action="<?php echo esc_url(self_admin_url('process-apply_other.php')); ?>">
            <!--任务内容-->
            <div class="form-group" style="margin: 20px 0px">
                <?php wp_editor('', 'task_other_editor', $settings = array(
                    'teeny' => true, 'textarea_rows' => 6)
                );
                ?>
            </div>
            <!--项目成员-->
            <div class="form-group" style="margin: 20px 0px">
                <label for="tabstract" class="col-sm-2 col-md-2 col-xs-12 control-label"
                       style="float: left;text-align: left;width: 11%">任务成员<span
                        style="color: red">*</span></label>
                <div class="col-sm-8">
<!--                    <input type="button" id="addNewFieldBtn" value="+" style="display:inline">-->
                    <div style="display: inline">
                        <input type="text" class="form-control" name="team_member[]" id="team_member"
                               style="margin-left: 0px;margin-right: 5px"
                               placeholder="必填项, 填写任务小组组长用户名" value="" onblur="checkUserName(this.value)"
                               onfocus="saveid(this)"
                        />
                        <div id="ajax-response_0" style="display: inline;margin-left: 10px"></div>
                    </div>
                    <div id="addField" style="display:inline;margin-top: 7px;margin-left: -4px"></div>
                </div>
            </div>

            <div class="form-group" style="display: none">
                <input type="hidden" name="task_id" value="<?= $task_id ?>"/>
                <!--                <input type="hidden" name="user_id" value="-->
                <? //=get_current_user_id();?><!--"/>-->
            </div>
            <div class="form-group" style="margin-bottom: 30px">
                <div class="col-sm-10">
                    <?php if (!is_overdue($task_id)) {
                        echo '<input type="submit" class="btn-green" style="margin-top: 0px" id="apply-btn" value="提交任务">';
                    } else {
                        echo '<input type="submit" class="btn-green" style="margin-top: 0px" id="apply-btn" disabled value="已截止">';
                    } ?>
                </div>
            </div>
        </form>
    <?php } ?>

    <div class="divline"></div>

    <div id="single-task-member-complete" style="margin-top: 30px">
        <?php $per_all = complete_percentage($group_id, $task_id) ?>
        <h4>优秀任务展示 : <span class="pull-right" style="font-size: 14px"><?= $per_all ?>%组员已完成</span></h4>
    </div>
    <br>
    <div class="single-task-member-complete-list">
        <?
        //置顶自己的作业
        $user_complete = task_complete_other($task_id,get_current_user_id())[0];
        if(is_complete_task($task_id,get_current_user_id())){?>
            <div class="dwqa-answer-item" style="padding: 15px 0px">
                <!--头像-->
                <div style="display: inline-block;vertical-align: top;margin-left: 30px">
                    <?php echo get_avatar($user_complete['user_id'], 36, ''); ?>
                </div>
                <!--内容-->
                <div style="display: inline-block;vertical-align: top;width: 90%">
                    <!--审核状态-->
                    <?php $grade = transform_grade($user_complete['completion']) //将数字转化为文字
                    ?>
                    <div class="dropdown" style="float: right" id="grade"><?= $grade ?></div>
                    <div style="color:gray">
                        <div style="margin-bottom: 10px">
                            <!--提交者信息--->
                            <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $user_complete['user_id']; ?>"
                               class="ask-author" style="margin-left: 20px;">
                                <?php echo get_the_author_meta('user_login',$user_complete['user_id']) ?>
                            </a>
                        </div>
                        <!--提交时间-->
                        <p class="ask_date" style="margin-left: 20px;"><?= $user_complete['complete_time'] ?></p>
                    </div>
                    <!--任务内容-->
                    <div style="color: gray;margin-left: 20px;font-size: 16px;">
                        <p><?= $user_complete['apply_content'] ?></p>
                    </div>
                    <!--任务点评编辑框-->
                    <div id="remark_window_<?= $user_complete['user_id'] ?>" style="display: none; margin: 10px 0 0 15px;">
                        <div class="task-remark-form">
                                <textarea id="remark-text_<?= $user_complete['user_id'] ?>" name="remark-text" placeholder="点评"
                                          rows="3" aria-required="true" style="height: 100%;width: 100%"></textarea>
                            <button name="remark-submit" id="btn-remark-submit" value="发表点评" class="btn-green"
                                    onclick="remark_submit(<?= $user_complete['user_id'] ?>)">发表点评
                            </button>
                        </div>
                    </div>
                    <!--任务点评内容-->
                    <div id="task_remark_<?= $user_complete['user_id'] ?>">
                        <?php if (has_remark($task_id, $user_complete['user_id'])) {
                            echo '<div class="remark" id="remark_' . $user_complete['user_id'] . '">点评：';
                            echo $user_complete['remark'];
                            echo '</div>';
                        } ?>
                    </div>
                </div>
            </div>
        <?php }
        else{
            echo '<div class="divline" style="margin-top: 0px"></div>';
            echo '<div class="alert alert-info" style="margin-top: 20px">你还没有提交任务,请尽快提交</div>';
        }
        if (is_group_admin($group_id)) {
            $all_complete = task_complete_other($task_id);
            foreach ($all_complete as $value) { ?>
                <div class="dwqa-answer-item" style="padding: 15px 0px">
                    <!--头像-->
                    <div style="display: inline-block;vertical-align: top;margin-left: 30px">
                        <?php echo get_avatar($value['user_id'], 36, ''); ?>
                    </div>
                    <!--内容-->
                    <div style="display: inline-block;vertical-align: top;width: 90%">
                        <!--审核状态-->
                        <?php
                        if (is_group_admin($group_id)) { ?>
                            <button class="btn btn-default" id="btn-remark" style="display: inline-block;float: right"
                                    onclick="task_remark(<?= $value['user_id'] ?>)">点评
                            </button>
                            <div class="dropdown" style="float: right;margin-right: 20px">
                                <script>
                                    $(function () {
                                        var sel_id = '<?=$value['completion']?>';
                                        document.getElementById("other_<?=$value['user_id']?>")[sel_id].selected = true;
                                    })
                                </script>
                                <select class="form-control" id="other_<?= $value['user_id'] ?>"
                                        onchange="change_grade_other(this.value,<?= $value['user_id'] ?>)">
                                    <option value="0">待审核</option>
                                    <option value="1">不合格</option>
                                    <option value="2">合格</option>
                                    <option value="3">一般</option>
                                    <option value="4">良好</option>
                                    <option value="5">优秀</option>
                                    <option value="6">特优</option>
                                </select>
                                <script>
                                    $(function () {
                                        document.getElementById("remark-text_<?=$value['user_id']?>").value = "<?=$value['remark']?>";
                                    })
                                </script>
                            </div>
                        <?php } else {
                            $grade = transform_grade($value['completion']) //将数字转化为文字?>
                            <div class="dropdown" style="float: right" id="grade"><?= $grade ?></div>
                        <?php } ?>
                        <div style="color:gray">
                            <div style="margin-bottom: 10px">
                                <!--提交者信息--->
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $value['user_id']; ?>"
                                   class="ask-author" style="margin-left: 20px;">
                                    <?php echo get_the_author_meta('user_login',$value['user_id']) ?>
                                </a>
                            </div>
                            <!--提交时间-->
                            <p class="ask_date" style="margin-left: 20px;"><?= $value['complete_time'] ?></p>
                        </div>
                        <!--任务内容-->
                        <div style="color: gray;margin-left: 20px;font-size: 16px;">
                            <p><?= $value['apply_content'] ?></p>
                        </div>
                        <!--任务点评编辑框-->
                        <div id="remark_window_<?= $value['user_id'] ?>" style="display: none; margin: 10px 0 0 15px;">
                            <div class="task-remark-form">
                                <textarea id="remark-text_<?= $value['user_id'] ?>" name="remark-text" placeholder="点评"
                                          rows="3" aria-required="true" style="height: 100%;width: 100%"></textarea>
                                <button name="remark-submit" id="btn-remark-submit" value="发表点评" class="btn-green"
                                        onclick="remark_submit(<?= $value['user_id'] ?>)">发表点评
                                </button>
                            </div>
                        </div>
                        <!--任务点评内容-->
                        <div id="task_remark_<?= $value['user_id'] ?>">
                            <?php if (has_remark($task_id, $value['user_id'])) {
                                echo '<div class="remark" id="remark_' . $value['user_id'] . '">点评：';
                                echo $value['remark'];
                                echo '</div>';
                            } ?>
                        </div>
                    </div>
                </div>
            <?php }
        }
        else {
            $all_recommand = get_recommand_task($task_id);
            foreach ($all_recommand as $value) {
                if($value['user_id'] != get_current_user_id()){ ?>
                    <div class="dwqa-answer-item" style="padding: 15px 0px">
                        <!--头像-->
                        <div style="display: inline-block;vertical-align: top;margin-left: 30px">
                            <?php echo get_avatar($value['user_id'], 36, ''); ?>
                        </div>
                        <!--内容-->
                        <div style="display: inline-block;vertical-align: top;width: 90%">
                            <!--审核状态-->
                            <?php $grade = transform_grade($value['completion']) //将数字转化为文字
                            ?>
                            <div class="dropdown" style="float: right" id="grade"><?= $grade ?></div>
                            <?php //}
                            ?>
                            <div style="color:gray">
                                <div style="margin-bottom: 10px">
                                    <!--提交者信息--->
                                    <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $value['user_id']; ?>"
                                       class="ask-author" style="margin-left: 20px;">
                                        <?php echo get_the_author_meta('user_login',$value['user_id']) ?>
                                    </a>
                                </div>
                                <!--提交时间-->
                                <p class="ask_date" style="margin-left: 20px;"><?= $value['complete_time'] ?></p>
                            </div>
                            <!--任务内容-->
                            <div style="color: gray;margin-left: 20px;font-size: 16px;">
                                <p><?= $value['apply_content'] ?></p>
                            </div>
                            <!--任务点评编辑框-->
                            <div id="remark_window_<?= $value['user_id'] ?>" style="display: none; margin: 10px 0 0 15px;">
                                <div class="task-remark-form">
                                <textarea id="remark-text_<?= $value['user_id'] ?>" name="remark-text" placeholder="点评"
                                          rows="3" aria-required="true" style="height: 100%;width: 100%"></textarea>
                                    <button name="remark-submit" id="btn-remark-submit" value="发表点评" class="btn-green"
                                            onclick="remark_submit(<?= $value['user_id'] ?>)">发表点评
                                    </button>
                                </div>
                            </div>
                            <!--任务点评内容-->
                            <div id="task_remark_<?= $value['user_id'] ?>">
                                <?php if (has_remark($task_id, $value['user_id'])) {
                                    echo '<div class="remark" id="remark_' . $value['user_id'] . '">点评：';
                                    echo $value['remark'];
                                    echo '</div>';
                                } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php }
        } ?>
    </div>
</div>
<script>
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
    });
    function saveid(obj) {
        var nextNode = obj.nextSibling.nextSibling;  //ajax-response_0
        console.log(nextNode);
        if (nextNode == null) {   //1……
            nextNode = obj.nextSibling;
        }
        var tmp = nextNode.id;
        var id = tmp.charAt(tmp.length - 1);
        j = id;
        console.log(j);

    }
    function change_grade_other(grade, user_id) {
        var data = {
            action: "change_grade_other",
            grade: grade,
            group_id:'<?=$group_id?>',
            task_id: '<?=$task_id?>',
            user_id: user_id
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
    function checkSubmitOther() {
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
        var user_name = document.getElementById("team_member");
        if ($.inArray(1, result) == -1 && user_name.value != "") {
            return true;
        } else {
            layer.alert("请修正错误");
            return false;
        }
    }
    function task_remark(user_id) {
        var temp = document.getElementById('remark_window_' + user_id);

        if (temp.style.display == "block") {
            temp.style.display = "none";
        } else {
            temp.style.display = "block";
        }
    }
    function remark_submit(user_id) {
        var temp = document.getElementById('remark_window_' + user_id);
        var remark = $("#remark-text_" + user_id).val();
        var temp2 = document.getElementById('remark_' + user_id);
        var temp3 = document.getElementById('task_remark_' + user_id);
        var data = {
            action: "task_remark_submit",
            remark: remark,
            task_id: '<?=$task_id?>',
            user_id: user_id
        };
        $.ajax({
            data: data,
            type: "POST",
            url: "<?php echo $admin_url;?>",
            success: function (data) {
                layer.msg("点评成功", {time: 1000, icon: 1});
                temp.style.display = "none";
                if (!temp2) {
                    var newremark = document.createElement("div");
                    newremark.id = 'remark_' + user_id;
                    newremark.innerHTML = '点评：' + data;
                    newremark.className = 'remark';
                    temp3.appendChild(newremark);
                } else {
                    temp2.innerHTML = '点评：' + data;
                }
            },
            error: function () {
                layer.msg("点评失败", {time: 1000, icon: 2});
            }
        })
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
                if (response == 0) {
                    <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                    $('#ajax-response_' + j.toString()).html("<img src='<?=$url?>'><span>用户名错误</span>");
                } else if (response == 1) {
                    <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                    $('#ajax-response_' + j.toString()).html("<img src='<?=$url?>'><span>用户不是本组组员</span>");
                }
                else {
                    <?php $url = get_template_directory_uri() . "/img/OK.png";?>
                    $('#ajax-response_' + j.toString()).html("<img src='<?=$url?>'>");
                }
            }
        })
    }
</script>