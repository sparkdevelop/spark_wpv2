<div id="col9">
    <h4 class="ask_topic">请填写学校的全称和简称</h4>
    <form class="form-horizontal" role="form" name="profile" method="post" enctype="multipart/form-data"
          action="<?php echo esc_url(self_admin_url('process-join_ms.php')); ?>">

        <div class="form-group" style="margin: 20px 0px">
            <label class="col-sm-2 col-md-2 col-xs-12 control-label"
                   style="float: left">学校全称
                <span style="color: red">*</span></label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="uvs_name" placeholder="如:北京邮电大学" value=""/>
            </div>
        </div>
        <div class="form-group" style="margin: 20px 0px">
            <label class="col-sm-2 col-md-2 col-xs-12 control-label"
                   style="float: left">学校简称
                <span style="color: red">*</span></label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="uvs_short" placeholder="如:bupt" value=""/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" name="save-btn" id="save-btn" value="提交">
            </div>
        </div>
    </form>
</div>