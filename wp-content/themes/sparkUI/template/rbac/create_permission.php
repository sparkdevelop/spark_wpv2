<script>
    function checkSubmitRole() {
        var pname = document.getElementById('pname');
        if (checkRbacName(pname.value,'permission')) {
            return true;
        } else {
            layer.alert('请修正错误');
            return false;
        }
    }
    function checkRbacName(Name,type) {
        flag_name = false;
        if (Name.length == 0) {
            <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
            $("#checkNamebox").html("<img src='<?=$url?>'><span>权限名称不能为空</span>");
            return flag_name;
        }
        else {
            var data = {
                action: 'check_rbac_name',
                Name: Name,
                part: type

            };
            $.ajax({
                async: false,    //否则永远返回false
                type: "POST",
                url: "<?=admin_url('admin-ajax.php');?>",
                data: data,
                success: function (response) {
                    if (response == false) {
                        <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                        $('#checkNamebox').html("<img src='<?=$url?>'><span>该权限已存在</span>");
                    } else {
                        <?php $url = get_template_directory_uri() . "/img/OK.png";?>
                        $('#checkNamebox').html("<img src='<?=$url?>'>");
                        flag_name = true;
                    }
                }
            });
            return flag_name;
        }
    }
</script>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <h4 class="index_title">新建权限</h4>
    <div class="divline"></div>

    <form class="form-horizontal" role="form" name="profile" method="post" enctype="multipart/form-data"
          action="<?php echo esc_url(self_admin_url('process-permission.php')); ?>" onsubmit="return checkSubmitRole();">
        <div class="form-group" style="margin: 20px 0px">
            <label for="pname" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">权限名称<span
                    style="color: red">*</span></label>
            <div class="col-sm-6 col-xs-7">
                <input type="text" class="form-control" name="pname" id="pname" placeholder="请输入权限名称" value=""
                       onblur="checkRbacName(this.value,'permisssion')"/>
            </div>
            <span style="line-height: 30px;height: 30px;" id="checkNamebox"></span>
        </div>
        <!--群组简介-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="pabstract" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">权限说明<span
                    style="color: red">*</span></label>
            <div class="col-sm-10">
                <?php wp_editor('', 'pabstract', $settings = array(
                    'teeny' => true, 'textarea_rows' => 6)
                );
                ?>
            </div>
        </div>
        <!--        隐藏信息-->
        <div class="form-group">
            <input type="hidden" name="pauthor" value="<?= get_current_user_id() ?>">
            <input type="hidden" name="pcreatedate" value="<?= date("Y-m-d H:i:s", time() + 8 * 3600) ?>">
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" name="save-btn" id="save-btn" value="保存">
            </div>
        </div>
    </form>
</div>