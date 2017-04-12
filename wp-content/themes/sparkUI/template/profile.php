<?php
$current_user = wp_get_current_user();
$user_description = get_user_meta($current_user->ID,'description',true);
?>
    <h4 style="color: #fe642d">个人资料</h4>
    <div class="divline"></div>

    <form class="form-horizontal" role="form">
        <div class="form-group" style="margin: 20px 0px">
            <label for="email" class="col-sm-2 col-md-2 col-xs-2 control-label" style="float: left">电子邮件</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="email" placeholder="<?=$current_user->user_email?>">
            </div>
        </div>
        <div class="form-group" style="margin: 20px 0px">
            <label for="description" class="col-sm-2 col-md-2 col-xs-2 control-label" style="float: left">个性签名</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="description" placeholder="<?=$user_description?>">
            </div>
        </div>

     <h4 style="color: #fe642d">修改密码</h4>
        <div class="divline"></div>
        <div class="form-group" style="margin: 20px 0px">
            <label for="description" class="col-sm-2 col-md-2 col-xs-2 control-label" style="float: left">原密码</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="inputPassword" placeholder="请输入密码">
            </div>
        </div>
        <div class="form-group" style="margin: 20px 0px">
            <label for="description" class="col-sm-2 col-md-2 col-xs-2 control-label" style="float: left">新密码</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="inputPassword" placeholder="请输入密码">
            </div>
        </div>
        <div class="form-group" style="margin: 20px 0px">
            <label for="description" class="col-sm-2 col-md-2 col-xs-2 control-label" style="float: left">确认密码</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="inputPassword" placeholder="请输入密码">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">保存修改</button>
            </div>
        </div>
    </form>