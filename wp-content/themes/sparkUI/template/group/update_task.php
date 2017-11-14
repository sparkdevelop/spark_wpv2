<script>
    function checkSubmitTask() {
        var tname = document.getElementById('tname');
        var tabstract = document.getElementById('tabstract');
        var tprolink = document.getElementById('tprolink');
        var tproabstract = document.getElementById('tproabstract');
        if(checkLength(tname.value,'checkTaskNamebox')&&checkLength(tabstract.value,'checkGroupAbsbox')
            &&checkLength(tprolink.value,'checkProNamebox')&&checkLength(tproabstract.value,'checkProAbsbox')){
            return true;
        }else{
            layer.alert("请修正错误");
            return false;
        }
    }
    function checkLength(taskname,boxid) {
        var id = "#"+boxid;
        if(taskname.length == 0){
            <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
            $(id).html("<img src='<?=$url?>' style='margin-left:20px;'><span>该项不能为空</span>");
            return false;
        }else{
            <?php $url = get_template_directory_uri() . "/img/OK.png";?>
            $(id).html("<img src='<?=$url?>' style='margin-left:20px;'>");
            return true;
        }
    }
</script>
<?php
$group_id = isset($_GET['group_id']) ? $_GET['group_id'] : '';
$task_id = isset($_GET['id']) ? $_GET['id'] : '';
$task_info = get_task($group_id,$task_id)[0];
wp_enqueue_media();
?>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <h4 class="index_title" style="margin-left: 20px">更新任务信息</h4>
    <div class="divline"></div>

    <form class="form-horizontal" role="form" name="profile" method="post" onsubmit="return checkSubmitTask()"
          action="<?php echo esc_url(self_admin_url('process-update_task.php')); ?>">
        <!--任务名称-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="tname" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">任务名称<span
                    style="color: red">*</span></label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="tname" id="tname" placeholder="请输入任务名称" value="<?=$task_info['task_name']?>"
                       onblur="checkLength(this.value,'checkTaskNamebox')"/>
            </div>
            <span style="line-height: 30px;height: 30px" id="checkTaskNamebox"></span>
        </div>
        <!--任务简介-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="tabstract" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">任务详情<span
                    style="color: red">*</span></label>
            <div class="col-sm-8">
                <?php wp_editor($task_info["task_content"], 'tabstract', $settings = array(
                    'teeny' => true, 'textarea_rows' => 6)
                );
                ?>
            </div>
            <span style="line-height: 30px;height: 30px" id="checkGroupAbsbox"></span>
        </div>
        <!--任务类型-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="ttype" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">任务类型<span
                    style="color: red">*</span></label>
            <div class="col-sm-8" style="margin-top: 7px">
                <input type="radio" id="tread" name="ttype" value="tread" style="display: inline-block"/><span>阅读站内文章</span>&nbsp;&nbsp;
                <input type="radio" id="tpro" name="ttype" value="tpro" style="display: inline-block"/><span>提交项目</span>
                <input type="radio" id="tother" name="ttype" value="tother" style="display: inline-block"/><span>其他</span>
                <script>
                    $(function () {
                        var type = "<?=$task_info['task_type']?>";
                        var input_type = document.getElementById(type);
                        input_type.checked = "checked";
                        var ban_update = document.getElementsByName('ttype');
                        for(var i=0; i<ban_update.length;i++){
                            ban_update[i].disabled = true;
                        }
                    })
                </script>
                <div id="ttype-addon"></div>
            </div>
        </div>
        <!--截止时间-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="tdeadline" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">截止时间<span
                    style="color: red">*</span></label>
            <div class="col-sm-9" id="tcheckways" style="margin-top: 7px">
                <div id="form_datetime" class="input-group date form_datetime col-md-4" style="width:40%" data-link-field="dtp_input1">
                    <input class="form-control" size="16" name="tdeadline" type="text"
                           value="<?=$task_info['deadline']?>">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-remove" style="margin-right: 0px;"></span>
                    </span>
                </div>
                <input type="hidden" id="dtp_input1" value=""/><br/>
            </div>
            <script>
                jQuery('#form_datetime').datetimepicker({
                    format: "yyyy-mm-dd",
                    weekStart: 7,
                    startDate: new Date(),
                    autoclose: 1,
                    startView: 2,
                    minView: 2,         //日期时间选择器所能够提供的最精确的时间选择视图。
                    todayBtn: 1,
                    todayHighlight: 1,
                    forceParse: 0,      //默认值
                    showMeridian: 0,
                    pickerPosition: "top-left"
                });
            </script>
        </div>
        <div class="form-group">
            <input type="hidden" name="belong_to" value="<?=$group_id?>"/>
            <input type="hidden" name="task_id" value="<?=$task_id?>"/>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" id="save-btn" value="更新任务">
            </div>
        </div>
    </form>
</div>