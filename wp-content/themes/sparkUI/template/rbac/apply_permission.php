<?php
$post_id = $_GET['id'];
$admin_url = admin_url('admin-ajax.php');
?>
<script>
    $(function () {
        applyPermission('<?=$admin_url?>',<?=$post_id?>)
    })
</script>
<div class="col-md-12 col-sm-12 col-xs-12" id="col9">
    <h4 class="index_title">申请权限</h4>
    <div class="divline"></div>

    <form class="form-horizontal" role="form" name="profile" method="post" enctype="multipart/form-data"
          action="<?php echo esc_url(self_admin_url('process-apply-permission.php')); ?>">
<!--        资源名称-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="pname" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">资源名称</label>
            <div class="col-sm-6 col-xs-12">
                <p style="padding-top: 7px;"><?=get_post($post_id)->post_title ?></p>
                <input type="hidden" name="postId" value="<?=$post_id?>">
            </div>
        </div>

        <!--资源对应的权限和角色信息-->
        <div class="form-group" style="margin: 20px 0px;margin-bottom: 0px">
            <label for="showpermission" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">对应权限</label>
            <div class="col-sm-8 col-md-8 col-xs-12" style="margin-top: -10px">
                <!--                资源展示table-->
                <div id="apply-permission-info-table">
                    <table id="apply-permission-choose-table-border" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="3" style="background-color: lightgrey;">请选择要申请的权限</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>权限名称</th>
                            <th>权限说明</th>
                        </tr>
                        </thead>
                        <tbody id="permission_tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-group" style="margin: 20px 0px;margin-bottom: 0px">
            <label for="showrole" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">对应角色</label>
            <div class="col-sm-8 col-md-8 col-xs-12" style="margin-top: -10px">
                <!--                资源展示table-->
                <div id="apply-role-info-table">
                    <table id="apply-role-choose-table-border" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="3" style="background-color: lightgrey;">请选择要申请的角色</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>角色名称</th>
                            <th>角色说明</th>
                        </tr>
                        </thead>
                        <tbody id="role_tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="form-group" style="margin: 20px 0px">
            <label for="reason" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">申请理由</label>
            <div class="col-sm-6 col-xs-12">
                <input type="text" class="form-control" name="reason" id="reason" placeholder="请输入申请理由" value=""/>
            </div>
        </div>


        <!--        隐藏信息-->
        <div class="form-group">
            <input type="hidden" name="applyer" value="<?= get_current_user_id() ?>">
            <input type="hidden" name="pcreatedate" value="<?= date("Y-m-d H:i:s", time() + 8 * 3600) ?>">
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" name="save-btn" id="save-btn" value="确认申请">
            </div>
        </div>
    </form>
</div>