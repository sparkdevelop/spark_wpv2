<?php ?>
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
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <h4 class="index_title" style="margin-left: 20px">填写任务信息</h4>
    <div class="divline"></div>

    <form class="form-horizontal" role="form" name="profile" method="post" onsubmit="return checkSubmitTask()"
          action="<?php echo esc_url(self_admin_url('process-task.php')); ?>">
        <!--任务名称-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="tname" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">任务名称<span
                    style="color: red">*</span></label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="tname" id="tname" placeholder="请输入任务名称" value=""
                onblur="checkLength(this.value,'checkTaskNamebox')"/>
            </div>
            <span style="line-height: 30px;height: 30px" id="checkTaskNamebox"></span>
        </div>
        <!--任务简介-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="tabstract" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">任务详情<span
                    style="color: red">*</span></label>
            <div class="col-sm-8">
                <textarea class="form-control" rows="5" name="tabstract" id="tabstract" placeholder=""
                          onblur="checkLength(this.value,'checkGroupAbsbox')"></textarea>
            </div>
            <span style="line-height: 30px;height: 30px" id="checkGroupAbsbox"></span>
        </div>
        <!--任务类型-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="ttype" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">任务类型<span
                    style="color: red">*</span></label>
            <div class="col-sm-8" style="margin-top: 7px">
                <input type="radio" id="tread" name="ttype" value="tread" style="display: inline-block" checked/><span>阅读站内文章</span>&nbsp;&nbsp;
                <input type="radio" id="tpro" name="ttype" value="tpro" style="display: inline-block"/><span>提交项目</span>
                <input type="radio" id="tother" name="ttype" value="tother" style="display: inline-block"/><span>其他</span>
                <script>
                    $(function () {
                        showAddon();
                        $("input[name=ttype]").on('change', function () {
                            showAddon();
                        });
                        function showAddon() {
                            switch ($("input[name=ttype]:checked").attr("id")) {   //根据id判断
                                case "tread":
                                    var html = '<p>自动检查,仅支持站内文章,请在下框中填写文章链接</p>'+
                                               '<input type="button" id="addNewFieldBtn" value="+" >'+
                                               '<input type="text" class="form-control" name="tlink[]" id="tlink" ' +
                                                        'style="margin-bottom:10px;display:inline;width: 90%" placeholder="" value=""/>';
                                    $("#ttype-addon").html('<p style="margin-top: 5px">注:可用于检查组员阅读wiki教程,查看<a href="#">任务示例</a></p>');
                                    $("#tcheckways").html(html);
                                    break;
                                case "tpro":
                                    var html ='<p>组员将填写项目链接和项目组成员信息</p>';
//                                            '<div class="form-group" style="margin: 20px 0px">'+
//                                                '<label for="tprolink" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">项目链接</label>'+
//                                                '<div class="col-sm-7">'+
//                                                    '<input type="text" class="form-control" name="tprolink" id="tprolink" style="margin-bottom:10px;display:inline" placeholder="" value="" ' +
//                                                            'onblur="checkLength(this.value,\'checkProNamebox\')"/>'+
//                                                '</div>'+
//                                                '<span style="line-height: 30px;height: 30px" id="checkProNamebox"></span>'+
//                                            '</div>'+
//                                            ' <div class="form-group" style="margin: 20px 0px">'+
//                                                '<label for="tprabstract" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">项目简介</label>'+
//                                                '<div class="col-sm-7">'+
//                                                    '<textarea class="form-control" rows="3" name="tproabstract" id="tproabstract" style="display: inline" placeholder="" ' +
//                                                                'onblur="checkLength(this.value,\'checkProAbsbox\')"></textarea>'+
//                                                '</div>'+
//                                                '<span style="line-height: 30px;height: 30px" id="checkProAbsbox"></span>'+
//                                            '</div>';
                                    $("#ttype-addon").html('<p style="margin-top: 5px">注:可用于检查组员阅读wiki教程,查看<a href="#">任务示例</a></p>');
                                    $("#tcheckways").html(html);
                                    break;
                                case "tother":
                                    $("#ttype-addon").html('<p style="margin-top: 5px">注:灵活设置任务类型,查看<a href="#">任务示例</a></p>');
                                    $("#tcheckways").html('<p>手动检查,组员将通过文本框编辑提交任务完成信息</p>');
                                    break;
                            }
                        }
                        $(document).on('click', '#addNewFieldBtn', function () {
                            var input = '<input type="text" class="form-control" name="tlink[]" id="tlink" ' +
                                        'style="margin-left: 35px;margin-bottom:10px;display:inline;width: 90%" ' +
                                        'placeholder="" value=""/>';
                            $("#tcheckways").append(input);
                        })
                    })
                </script>
                <div id="ttype-addon"></div>
            </div>
        </div>
        <!--检查方式-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="tlink" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">检查方式<span
                    style="color: red">*</span></label>
            <div class="col-sm-8" id="tcheckways" style="margin-top: 7px"></div>
        </div>
        <!--截止时间-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="tdeadline" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">截止时间<span
                    style="color: red">*</span></label>
            <div class="col-sm-9" id="tcheckways" style="margin-top: 7px">
                <div id="form_datetime" class="input-group date form_datetime col-md-4" data-link-field="dtp_input1">
                    <input class="form-control" size="16" name="tdeadline" type="text"
                           value="<?= date("Y-m-d", time() + 3600 * 24) ?>">
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
            <input type="hidden" name="belong_to" value="<?=$_COOKIE['group_id']?>"/>
            <input type="hidden" name="tauthor" value="<?=get_current_user_id()?>">
            <input type="hidden" name="tcreatedate" value="<?=date("Y-m-d")?>">
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" id="save-btn" value="发布任务">
            </div>
        </div>
    </form>
    <?php setcookie('group_id','');?>
</div>