<?php
//验证表单
$user_id = $_GET["user_id"];
$group_id = $_GET["group_id"];
setcookie("user_id", $user_id);
setcookie("group_id", $group_id);
$verify_field = get_verify_field($_GET['group_id'], 'group');
$admin_url = admin_url('admin-ajax.php');
?>
<div id="col9">
    <h4 class="ask_topic">请填写要邀请的成员用户名</h4>
    <form class="form-horizontal" role="form" name="profile" method="post" enctype="multipart/form-data"
          action="<?php echo esc_url(self_admin_url('process-invitation.php')); ?>"
          onkeydown="if(event.keyCode==13)return false;"
          onsubmit="return checkSubmitIn()">
        <div class="form-group" style="margin: 20px 0px">
            <label for="tabstract" class="col-sm-2 col-md-2 col-xs-12 control-label"
                   style="float: left">邀请成员<span
                    style="color: red">*</span></label>
            <div class="col-sm-8">
                <input type="button" id="addNewFieldBtn" value="+" style="display:none">
                <div style="display: inline">
                    <input type="text" class="form-control" name="invitation_member[]" id="invitation_member"
                           style="margin-right:0px;margin-bottom:10px;display:inline;width: 60%"
                           placeholder="邀请成员" value="" onblur="checkInUserName(this.value)"
                           />
                    <div id="ajax-response_0" style="display: inline;margin-left: 10px"></div>
                </div>
                <div id="addField" style="display:inline;margin-top: 7px;margin-left: -4px"></div>
            </div>
        </div>
        <!--        隐藏信息-->
        <div class="form-group">
            <input type="hidden" name="group_id" value="<?= $group_id ?>">
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" name="save-btn" id="save-btn" value="提交">
            </div>
        </div>
    </form>
</div>
<script>
    $(function () {
        var title = $('#ajax-response_0');//the element I want to monitor
        title.bind('DOMNodeInserted', function() {
            var src = $('#ajax-response_0').find('img').attr('src');
            <?php $url = get_template_directory_uri() . "/img/OK.png";?>
            if(src=='<?=$url?>'){
                $('#addNewFieldBtn').css('display','inline');
            }
        });
    });

    var i = 0; //response名字系统
    var j = 0; //response 显示
    $(document).on('click', '#addNewFieldBtn', function () {
        i=i+1;
        var rid = "ajax-response_" + i.toString();
        var input = '<div>' +
                        '<input type="text" class="form-control" name="invitation_member[]" id="invitation_member" ' +
                                'style="margin-left: 14%;margin-bottom:10px;width: 60%;display:inline" ' +
                                'placeholder="邀请成员" value="" onblur="checkInUserName(this.value)" ' +
                                'onfocus="saveid(this)"/>' +
                        '<div style="display: inline;margin-left: 10px" id=' + rid + '>' +
                        '</div>' +
                    '</div>';
        $("#addField").append(input);
    });
    function saveid(obj) {
        var nextNode = obj.nextSibling;
        var tmp = nextNode.id;
        var id = tmp.charAt(tmp.length-1);
        j = id;
    }
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
                    $('#ajax-response_' + j.toString()).html("<img src='<?=$url?>'><span>用户名错误</span>");
                } else if (response == 1) {
                    <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                    $('#ajax-response_' + j.toString()).html("<img src='<?=$url?>'><span>用户已经是组员了</span>");
                }
                else {
                    <?php $url = get_template_directory_uri() . "/img/OK.png";?>
                    $('#ajax-response_' + j.toString()).html("<img src='<?=$url?>'>");
                }
            }
        })
    }
    function checkSubmitIn() {

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
        if ($.inArray(1, result)==-1){
            return true;
        } else{
            layer.alert("请修正错误");
            return false;
        }
    }
</script>