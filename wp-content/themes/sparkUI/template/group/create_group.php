<?php ?>
<style>
    #gstatus-addon p {
        margin-top: 10px;
    }
</style>

<script>
    function checkSubmitGroup() {
        var index = layer.load(0, {shade: [0.5, '#ffffff']}); //0代表加载的风格，支持0-2
        var gname = document.getElementById('gname');
        var gabstract = document.getElementById('gabstract');
        if (checkGroupName(gname.value) && checkFile()) {
            return true;
        } else {
            layer.alert('请修正错误');
            return false;
        }
    }
    //    检查组名是否重复
    function checkGroupName(groupName) {
        flag_name = false;
        if (groupName.length == 0) {
            <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
            $("#checkGroupNamebox").html("<img src='<?=$url?>'><span>群组名称不能为空</span>");
            return flag_name;
        }
        else {
            var data = {
                action: 'checkGroupName',
                groupName: groupName
            };
            $.ajax({
                async: false,    //否则永远返回false
                type: "POST",
                url: "<?=admin_url('admin-ajax.php');?>",
                data: data,
                success: function (response) {
                    if (response == false) {
                        <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                        $('#checkGroupNamebox').html("<img src='<?=$url?>' style='margin-left:20px;'><span>该组名已经被占用</span>");
                    } else {
                        <?php $url = get_template_directory_uri() . "/img/OK.png";?>
                        $('#checkGroupNamebox').html("<img src='<?=$url?>' style='margin-left:20px;'>");
                        flag_name = true;
                    }
                }
            });
            return flag_name;
        }
    }

    function checkGroupAbs(groupAbs) {
        if (groupAbs.length == 0) {
            <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
            $('#checkGroupAbsbox').html("<img src='<?=$url?>' style='margin-left:20px;'><span>简介不能为空</span>");
            return false;
        }
        else {
            <?php $url = get_template_directory_uri() . "/img/OK.png";?>
            $('#checkGroupAbsbox').html("<img src='<?=$url?>' style='margin-left:20px;'>");
            return true;
        }
    }

    function checkFile() {
        var file = document.getElementById('gava');
        var fileData = file.files[0];
        var size = fileData.size;
        var maxSize = 512 * 1024;
        if (size < maxSize) {
            <?php $url = get_template_directory_uri() . "/img/OK.png";?>
            $('#checkFileBox').html("<img src='<?=$url?>'>");
            return true;
        } else {
            <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
            $('#checkFileBox').html("<img src='<?=$url?>'><span>图片过大</span>");
            return false;
        }
    }

</script>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <h4 class="index_title">填写群组信息</h4>
    <div class="divline"></div>

    <form class="form-horizontal" role="form" name="profile" method="post" enctype="multipart/form-data"
          action="<?php echo esc_url(self_admin_url('process-group.php')); ?>" onsubmit="return checkSubmitGroup();">
        <!--群组名称-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="gname" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">群组名称<span
                    style="color: red">*</span></label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="gname" id="gname" placeholder="请输入群组名称" value=""
                       onblur="checkGroupName(this.value)"/>
            </div>
            <span style="line-height: 30px;height: 30px;margin-left: 20px" id="checkGroupNamebox"></span>
        </div>
        <!--群组简介-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="gabstract" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">群组简介<span
                    style="color: red">*</span></label>
            <div class="col-sm-10">
                <?php wp_editor('', 'gabstract', $settings = array(
                    'teeny' => true, 'textarea_rows' => 6)
                );
                ?>
            </div>
            <span style="line-height: 30px;height: 30px" id="checkGroupAbsbox"></span>
        </div>
        <!--群组状态-->
        <div class="form-group" style="margin: 20px 0px;margin-bottom: 0px">
            <label for="gstatus" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">群组状态<span
                    style="color: red">*</span></label>
            <div class="col-sm-6" style="margin-top: 7px">
                <input type="radio" id="gopen" name="gstatus" value="open" style="display: inline-block" checked/><span>开启</span>&nbsp;&nbsp;
                <input type="radio" id="gclose" name="gstatus" value="close"
                       style="display: inline-block;margin-left: 30px"/><span>关闭</span>
                <p style="margin-top: 10px">注:关闭群组后仅管理员可见</p>
            </div>
        </div>
        <!--加入方式-->
        <div class="form-group" style="margin: 0px 0px">
            <label for="gjoin" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">加入方式<span
                    style="color: red">*</span></label>
            <div class="col-sm-6" style="margin-top: 7px">
                <input type="radio" id="freejoin" name="gjoin" value="freejoin" style="display: inline-block" checked/><span>自由加入</span>&nbsp;&nbsp;
                <input type="radio" id="verifyjoin" name="gjoin" value="verifyjoin" style="display: inline-block"/><span>检验审核加入</span>&nbsp;&nbsp;
                <input type="radio" id="verify" name="gjoin" value="verify" style="display: inline-block"/><span>审核加入</span>
                <script>
                    $(function () {
                        showAddon();
                        $("input[name=gjoin]").on('change', function () {
                            showAddon();
                        });
                        function showAddon() {
                            switch ($("input[name=gjoin]:checked").attr("id")) {   //根据id判断
                                case "freejoin":
                                    $("#gjoin-addon").html("<p>注:用户自由加入,无需审核</p>");
                                    break;
                                case "verifyjoin":
                                    var html = '<div style="background-color: #f2f2f2;padding-top: 10px">' +
                                        '<div id="insert-text">' +
                                        '<p style="margin: 10px 20px; margin-top: 0px">设置需要用户填写的验证字段,如:真实姓名、学号,该信息将在小组内公开</p>' +
                                        '<input type="text" class="form-control" name="g-ver-info[]" id="g-ver-info" style="margin-bottom:10px;margin-left:10px;display:inline;width: 85%" placeholder="真实姓名" value="真实姓名"/>' +
                                        '<input type="text" class="form-control" name="g-ver-info[]" id="g-ver-info" style="margin-bottom:10px;margin-left:10px;display:inline;width: 85%" placeholder="学号" value="学号"/>' +
                                        '<input type="button" id="addNewFieldBtn" value="+" style="margin-left:10px;display:inline">' +
                                        '</div>' +
                                        '</div>';
                                    $("#gjoin-addon").html(html);
                                    break;
                                case "verify":
                                    $("#gjoin-addon").html("<p>注:注册通过即可加入,无需填写验证信息</p>");
                                    break;
                            }
                        }

                        $(document).on('click', '#addNewFieldBtn', function () {
                            $("#addNewFieldBtn").hide();
                            var input = '<input type="text" class="form-control" name="g-ver-info[]" id="g-ver-info" style="margin-bottom:10px;margin-left:10px;display:inline;width: 85%" placeholder="" value=""/>' +
                                '<input type="button" id="addNewFieldBtn" value="+" style="margin-left:10px;display:inline">';
                            $("#insert-text").append(input);
                        })
                    })
                </script>
                <div id="gjoin-addon"></div>
            </div>
        </div>
        <!--发布任务-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="gstatustask" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">发布任务<span
                    style="color: red">*</span></label>
            <div class="col-sm-6" style="margin-top: 7px">
                <input type="radio" id="gadmin" name="gstatustask" value="admin" checked style="display: inline-block"/><span>仅管理员</span>
                <input type="radio" id="gall" name="gstatustask" value="all"
                       style="display: inline-block"/><span>所有组员</span>
            </div>
        </div>
        <!--群组图标-->
        <div class="form-group" style="margin: 20px 0px;margin-bottom: 0px">
            <label for="gava" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">群组图标<span
                    style="color: red">&nbsp;</span></label>
            <div class="col-sm-6" style="margin-top: 7px">
                <input type="file" id="gava" name="gava" onchange="checkFile()" style="display:inline;"/>
                <span id="checkFileBox"></span>
                <p style="margin-top: 5px">注:文件应小于512KB</p>
            </div>
        </div>
        <canvas width="100px" height="100px" id="canvas" style="margin-left: 160px"></canvas>
        <script>
            $(function () {
                $("#canvas").hide();
                $("#gava").change(function () {
                    var picurl = getObjectURL(this.files[0]);
                    var ctx = document.getElementById('canvas').getContext('2d');
                    var imageObj = new Image();
                    imageObj.onload = function () {
                        var img_w = this.width;
                        var img_h = this.height;
                        if (img_w >= img_h) {
                            ctx.drawImage(imageObj, ((img_w - img_h) / 2), 0, img_h, img_h, 0, 0, 100, 100);
                            //$("#canvas").css("-webkit-border-radius","60px");
                        }
                        else {
                            ctx.drawImage(imageObj, 0, ((img_h - img_w) / 2), img_w, img_w, 0, 0, 100, 100);
                            //$("#canvas").css("-webkit-border-radius","60px");
                        }
                    };
                    imageObj.src = picurl;
                    $("#canvas").show();
                })
            });

            function getObjectURL(file) {
                var url = null;
                if (window.createObjectURL != undefined) { // basic
                    url = window.createObjectURL(file);
                } else if (window.URL != undefined) { // mozilla(firefox)
                    url = window.URL.createObjectURL(file);
                } else if (window.webkitURL != undefined) { // webkit or chrome
                    url = window.webkitURL.createObjectURL(file);
                }
                return url;
            }
        </script>
        <!--        隐藏信息-->
        <div class="form-group">
            <input type="hidden" name="gauthor" value="<?= get_current_user_id() ?>">
            <input type="hidden" name="gcreatedate" value="<?= date("Y-m-d H:i:s", time() + 8 * 3600) ?>">
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" name="save-btn" id="save-btn" value="创建群组">
            </div>
        </div>
    </form>
</div>