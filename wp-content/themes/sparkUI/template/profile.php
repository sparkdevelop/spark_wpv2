<?php
$profile_page_address = get_page_address('profile');

$current_user = wp_get_current_user();
$user_description = get_user_meta($current_user->ID,'description',true);
$admin_url=admin_url( 'admin-ajax.php' );
?>
<script>
    function checkPassword(password) {
        if(password.length==0){
            document.getElementById("checkpassword").innerHTML="";
            return;
        }
        jQuery(document).ready(function($){
            var data={
                action:'checkPass',
                oldpassword : password
            };
            $.post(
                    "<?php echo $admin_url;?>",
                    data,
                    function(response) {
                        if(response == false){
                            <?php $url=get_template_directory_uri()."/img/ERROR.png";?>
                            document.getElementById("checkpassword").innerHTML="<img src='<?=$url?>'><span>密码错误</span>";
                            $('#newPassword').attr("disabled",true);
                            $('#repectNewPassword').attr("disabled",true);
                        }else{
                            <?php $url=get_template_directory_uri()."/img/OK.png";?>
                            document.getElementById("checkpassword").innerHTML="<img src='<?=$url?>'>";
                            $('#newPassword').attr("disabled",false);
                            $('#repectNewPassword').attr("disabled",false);
                        }
                    }
                  );
        });
    }
    function checkemail(email){
        var hint = document.getElementById('checkemailbox');
        if (email.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1) {
            hint.innerHTML = '<img src="<?php bloginfo("template_url")?>/img/OK.png">';
            return true;
        } else {
            hint.innerHTML = '<img src="<?php bloginfo("template_url")?>/img/ERROR.png">&nbsp<span>请输入有效的邮件地址</span>';
            return false;}
    }
    function checkNewPassword(newpassword){
        var hint = document.getElementById('checknewpassword');
        if(newpassword != ""){
            hint.innerHTML = '<img src="<?php bloginfo("template_url")?>/img/OK.png">';
            return true;
        }else{
            hint.innerHTML = '<img src="<?php bloginfo("template_url")?>/img/ERROR.png">&nbsp<span>密码不能为空</span>';
            return false;
        }
    }
    function checkRepeatPassword(repeatpassword){
        var hint = document.getElementById('repectPassword');
        var newpassword = document.getElementById('newPassword');
        if(newpassword.value == repeatpassword && repeatpassword.length != 0){
            hint.innerHTML = '<img src="<?php bloginfo("template_url")?>/img/OK.png">';
            return true;
        }else if(repeatpassword.length==0){
            hint.innerHTML = '<img src="<?php bloginfo("template_url")?>/img/ERROR.png">&nbsp<span>密码不能为空</span>';
            return false;
        }else{
            hint.innerHTML = '<img src="<?php bloginfo("template_url")?>/img/ERROR.png">&nbsp<span>密码不一致</span>';
            return false;
        }
    }
    function checkSubmitprofile() {
        var email = document.getElementById("email");
        if(checkemail(email.value)){
            return true;
        }else{
            layer.msg("请修正错误", {time: 2000, icon: 2});
            return false;
        }
    }
    function checkSubmitpassword() {
        var newPassword = document.getElementById("newPassword");
        var repectPassword = document.getElementById("repectPassword");
        if(checkNewPassword(newPassword.value) &&checkRepeatPassword(repectPassword.value)){
            return true;
        }else{
            layer.msg("请修正错误", {time: 2000, icon: 2});
            return false;
        }
    }
</script>
    <h4 style="color: #fe642d">个人资料</h4>
    <div class="divline"></div>

    <form class="form-horizontal" role="form" name="profile"
          method="post" action="<?php echo esc_url( self_admin_url('profile-process.php') ); ?>"
          onsubmit="return checkSubmitprofile();">
<!--        电子邮件-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="email" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">电子邮件</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="email" id="email"
                       placeholder="<?=$current_user->user_email?>"
                       value="<?=$current_user->user_email?>"
                       onfocus="javascript:if(this.value=='<?=$current_user->user_email?>') this.value=''"
                       onmouseout="javascript:if(this.value=='') this.value='<?=$current_user->user_email?>'"
                       onblur="checkemail(this.value)"/>
            </div>
            <span style="line-height: 30px;height: 30px" id="checkemailbox"></span>
        </div>

<!--        签名-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="description" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">个性签名</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="description" name="description" placeholder="<?=$user_description?>"
                    value="<?=$user_description?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" id="save-btn" value="保存修改">
            </div>
        </div>
    </form>

        <h4 style="color: #fe642d">修改密码</h4>
        <div class="divline"></div>

        <form class="form-horizontal" role="form" name="password"
              method="post" action="<?php echo esc_url( self_admin_url('profile-process-password.php') ); ?>"
              onsubmit="return checkSubmitpassword();">
<!--        原密码-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="old-password" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">原密码</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="inputPassword"
                       placeholder="请输入密码(微信登陆用户此项为空即可)" value=""
                       onblur="checkPassword(this.value);">
            </div>
            <span style="line-height: 30px;height: 30px" id="checkpassword"></span>
        </div>

<!--        新密码-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="description" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">新密码</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="newPassword" name="newPassword"
                       placeholder="请输入密码" value=""
                       onblur="checkNewPassword(this.value);">
            </div>
            <span style="line-height: 30px;height: 30px" id="checknewpassword"></span>
        </div>

<!--        重复新密码-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="description" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">确认密码</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="repectNewPassword" placeholder="请输入密码" value=""
                        onblur="checkRepeatPassword(this.value);">
            </div>
            <span style="line-height: 30px;height: 30px" id="repectPassword" ></span>
        </div>

<!--        提交按钮-->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" id="save-btn" value="保存修改">
            </div>
        </div>
    </form>
