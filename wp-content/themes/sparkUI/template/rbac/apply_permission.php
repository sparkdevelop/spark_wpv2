<?php
$post_id = $_GET['id'];
$admin_url = admin_url('admin-ajax.php');
//print_r(apply_permission($post_id));
$arr = apply_permission($post_id);
$role = $arr['role_id'][0];
//echo $role;
?>
<div class="col-md-12 col-sm-12 col-xs-12" id="col9">
    <h4 class="index_title">申请权限</h4>
    <div class="divline"></div>

    <form class="form-horizontal" role="form" name="profile" method="post" enctype="multipart/form-data"
          action="<?php echo esc_url(self_admin_url('process-apply-permission.php')); ?>">
        <!--        资源名称-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="pname" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">资源名称</label>
            <div class="col-sm-6 col-xs-12">
                <p style="padding-top: 7px;"><?= get_post($post_id)->post_title ?></p>
                <input type="hidden" name="postId" value="<?= $post_id ?>">
            </div>
        </div>

        <!--资源对应的权限和角色信息-->
        <div class="form-group" style="margin: 20px 0px;margin-bottom: 0px">
            <label for="showpermission" class="col-sm-2 col-md-2 col-xs-12 control-label"
                   style="float: left">对应权限</label>
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
            <div class="col-sm-offset-2 col-sm-2">
                <input type="submit" class="btn btn-default" name="save-btn" id="save-btn"
                       value="确认申请">
            </div>
            <div class="col-sm-2">
                <button class="btn btn-default"  name="offer-btn" type="button"
                       id="offer-btn" onclick="offerUnlock()">
                    <img src="<?php bloginfo("template_url")?>/img/integral/offers.png" style="width:20px">
                    <span>6积分/权限解锁</span>
                </button>
            </div>
            <?php if($role == 1){?>
            <div class="col-sm-offset-2 col-sm-2">
                <button  class="btn btn-default"  name="offer-btn" type="button" id="offer-btn" onclick="addprofile()">
                    填写北邮学生信息解锁
                </button>
            </div>
            <?php }?>
        </div>
    </form>
</div>
<script>
    $(function () {
        //获取对应这个资源的信息
        applyPermission('<?=$admin_url?>',<?=$post_id?>)

    });
    function offerUnlock(){
        var permission_id = [];
        $('input[name="pcheckItem[]"]:checked').each(function(){
            permission_id.push($(this).val());
        });
        var data = {
            action:'offer_unlock_ajax',
            permission_id : permission_id
        };
        $.ajax({
            type:'POST',
            url:'<?=$admin_url?>',
            data:data,
            dataType:'text',
            success:function (response) {
                if(response.trim()==1){
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.layer.close(index);
                    parent.layer.msg("已解锁", {time: 2000, icon: 1});
                    location.reload();
                }else{
                    parent.layer.msg("积分不足", {time: 2000, icon: 1});
                }
            }
        })
    }
  function addprofile(){
       // var index = parent.layer.getFrameIndex(window.name);
        //parent.layer.close(index);
        parent.location.href="<?php echo site_url() . get_page_address("personal") . '&tab=profile' ?>";
    }
</script>