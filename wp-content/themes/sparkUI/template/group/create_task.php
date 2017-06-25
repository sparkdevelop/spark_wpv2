<?php //未写JS ?>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <h4 class="index_title" style="margin-left: 20px">填写任务信息</h4>
    <div class="divline"></div>

    <form class="form-horizontal" role="form" name="profile" method="post"
          action="<?php echo esc_url(self_admin_url('process-group.php')); ?>" onsubmit="return checkSubmitGroup();">
        <!--任务名称-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="tname" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">任务名称<span
                    style="color: red">*</span></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="tname" id="tname" placeholder="" value=""/>
            </div>
            <span style="line-height: 30px;height: 30px" id="checkTaskNamebox"></span>
        </div>
        <!--任务简介-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="tabstract" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">任务简介<span
                    style="color: red">*</span></label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="5" name="tabstract" id="tabstract" placeholder=""></textarea>
            </div>
            <span style="line-height: 30px;height: 30px" id="checkGroupAbsbox"></span>
        </div>
        <!--任务类型-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="ttype" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">任务类型<span
                    style="color: red">*</span></label>
            <div class="col-sm-9" style="margin-top: 7px">
                <input type="radio" id="tread" name="ttype" value="tread" style="display: inline-block" checked/><span>阅读站内文章</span>&nbsp;&nbsp;
                <input type="radio" id="tpro" name="ttype" value="tpro" style="display: inline-block"/><span>提交项目</span>
                <input type="radio" id="tother" name="ttype" value="tother"
                       style="display: inline-block"/><span>其他</span>
                <p style="margin-top: 5px">注:可用于检查组员阅读wiki教程,查看<a href="#">任务示例</a></p>
            </div>
        </div>
        <!--检查方式-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="gstatus" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">检查方式<span
                    style="color: red">*</span></label>
            <div class="col-sm-9" style="margin-top: 7px">
                <p>自动检查,仅支持站内文章,请在下框中填写文章链接</p>
                <?php
                    for($i=0;$i<3;$i++){?>
                        <input type="text" class="form-control" name="tlink" id="tlink" style="margin-bottom:10px;display:inline;width: 90%" placeholder="" value=""/>
                <?php } ?>
                <input type="button" value="+" style="display:inline">
            </div>
        </div>
        <!--截止时间-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="gstatustask" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">截止时间<span
                    style="color: red">*</span></label>
            <div id="form_datetime" class="input-group date form_datetime col-md-3" data-link-field="dtp_input1">
                <input class="form-control" size="16" type="text" value="<?= date("Y-m-d", time() + 3600 * 24) ?>">
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
                pickerPosition: "bottom-left"
            });
        </script>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" id="save-btn" value="创建群组">
            </div>
        </div>
    </form>
</div>