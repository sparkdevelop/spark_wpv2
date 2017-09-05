<?php
//验证表单
setcookie("user_id",$_GET["user_id"]);
setcookie("group_id",$_GET["group_id"]);
$verify_field = get_verify_field($_GET['group_id'],'group')
?>
<div id="col9">
    <h4 class="ask_topic">请填写需要的验证信息,以便管理员审核</h4>
    <form class="form-horizontal" role="form" name="profile" method="post" enctype="multipart/form-data"
          action="<?php echo esc_url(self_admin_url('process-verify.php')); ?>">
        <?php
        for ($i=0;$i<sizeof($verify_field);$i++){?>
            <div class="form-group" style="margin: 20px 0px">
                <label class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left"><?=$verify_field[$i]?>
                    <span style="color: red">*</span></label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="verify_<?=$i?>" id="verify_<?=$i?>" value=""/>
                </div>
            </div>
        <?php } ?>
        <!--        隐藏信息-->
        <div class="form-group">
            <input type="hidden" name="user_id" value="<?= get_current_user_id() ?>">
            <input type="hidden" name="group_id" value="<?= $_GET['group_id'] ?>">
            <input type="hidden" name="field_num" value="<?= sizeof($verify_field) ?>">
            <input type="hidden" name="apply_time" value="<?= date("Y-m-d H:i:s", time() + 8 * 3600) ?>">
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" name="save-btn" id="save-btn" value="提交">
            </div>
        </div>
    </form>
</div>
