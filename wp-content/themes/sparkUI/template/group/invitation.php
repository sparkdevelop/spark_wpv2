<?php
//验证表单
$user_id = $_GET["user_id"];
$group_id = $_GET["group_id"];
setcookie("user_id",$user_id);
setcookie("group_id",$group_id);
$verify_field = get_verify_field($_GET['group_id'],'group');
$admin_url=admin_url( 'admin-ajax.php' );
?>
<div id="col9">
    <h4 class="ask_topic">请填写要邀请的成员用户名</h4>
    <form class="form-horizontal" role="form" name="profile" method="post" enctype="multipart/form-data"
          action="<?php echo esc_url(self_admin_url('process-invitation.php')); ?>" onsubmit="return checkSubmitIn()">
        <div class="form-group" style="margin: 20px 0px">
            <label for="tabstract" class="col-sm-2 col-md-2 col-xs-12 control-label"
                   style="float: left">邀请成员<span
                    style="color: red">*</span></label>
            <div class="col-sm-8">
                <input type="button" id="addNewFieldBtn" value="+" style="display:inline">
                <input type="text" class="form-control" name="invitation_member[]" id="invitation_member"
                       style="margin-right:0px;margin-bottom:10px;display:inline;width: 30%"
                       placeholder="邀请成员" value="" onblur="checkInUserName(this.value)"/>
                <div id="addField" style="display:inline;margin-top: 7px;margin-left: -4px"></div>
                <div id="ajax-response" style="display: inline;margin-left: 10px"></div>
            </div>
        </div>
        <!--        隐藏信息-->
        <div class="form-group">
            <input type="hidden" name="group_id" value="<?= $group_id?>">
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" name="save-btn" id="save-btn" value="提交">
            </div>
        </div>
    </form>
</div>
<script>
    $(document).on('click', '#addNewFieldBtn', function () {
        var input = '<input type="text" class="form-control" name="invitation_member[]" id="invitation_member" ' +
            'style="margin-left: 10%;margin-bottom:10px;width: 30%" ' +
            'placeholder="邀请成员" value="" onblur="checkInUserName(this.value)" />';
        $("#addField").append(input);
    });
    function checkInUserName(name) {
        var data = {
            action: "checkInUserName",
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
                    $('#ajax-response').html("<img src='<?=$url?>'><span>用户名错误</span>");
                } else if(response == 1){
                    <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                    $('#ajax-response').html("<img src='<?=$url?>'><span>用户已经是组员了</span>");
                }
                else {
                    <?php $url = get_template_directory_uri() . "/img/OK.png";?>
                    $('#ajax-response').html("<img src='<?=$url?>'>");
                }
            }
        })
    }
    function checkSubmitIn() {
        var ajax = document.getElementById('ajax-response');
        var tmp = $(ajax).find('img').attr('src');
        <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
        if (tmp != '<?=$url?>') {
            return true;
        } else {
            layer.alert("请修正错误");
            return false;
        }
    }
</script>