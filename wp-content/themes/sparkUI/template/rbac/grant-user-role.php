<?php
$tab = isset($_GET['tab']) && !empty($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'gup';
$admin_url = admin_url('admin-ajax.php');
?>
<style>
    .btn-green {
        margin-top: 0px;
        padding: 0 0;
        margin-left: 20px;
        margin-right: 0px;
    }

</style>
<h4>用户基本信息</h4>
<div class="divline"></div>
<div class="<?= $tab ?>-search-box">
    <input id="<?= $tab ?>-user-input" type="text" class="form-control <?= $tab ?>-text"  placeholder="请输入用户名称">
    <button class="btn btn-green" onclick="addToChosen('<?= $tab ?>','user','<?= $admin_url ?>')">查询</button>
</div>
<div id="autocomplete-user" style="display: none">
    <ul class="list-group"></ul>
</div>
<div id="user-info-table">
    <table id="user-choose-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="3">已选择用户</th>
        </tr>
        </thead>
        <tbody id="user_tbody">
        </tbody>
    </table>
    <table id="user-info-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="2">用户信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>用户昵称</td>
            <td></td>
        </tr>
        <tr>
            <td>用户ID</td>
            <td></td>
        </tr>
<!--        <tr>-->
<!--            <td>学校</td>-->
<!--            <td></td>-->
<!--        </tr>-->
<!--        <tr>-->
<!--            <td>性别</td>-->
<!--            <td></td>-->
<!--        </tr>-->
        <tr>
            <td>注册时间</td>
            <td></td>
        </tr>
        <tr>
            <td>归属角色</td>
            <td></td>
        </tr>
        <tr>
            <td>拥有权限</td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>

<h4>为用户配置角色</h4>
<div class="divline"></div>
<div class="<?= $tab ?>-search-box">
    <input type="text" class="form-control <?= $tab ?>-text" id="<?= $tab ?>-role-input" placeholder="请输入角色名称">
    <button class="btn btn-green" onclick="addToChosen('<?= $tab ?>','role','<?= $admin_url ?>')">查询</button>
</div>
<div id="autocomplete-role" style="display: none">
    <ul class="list-group"></ul>
</div>
<div id="role-info-table">
    <table id="role-choose-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="3">已选择角色</th>
        </tr>
        </thead>
        <tbody id="role_tbody">
        </tbody>
    </table>
    <table id="role-info-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="3">角色信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>角色名称</td>
            <td></td>
        </tr>
        <tr>
            <td>角色ID</td>
            <td></td>
        </tr>
        <tr>
            <td>角色关联权限</td>
            <td></td>
        </tr>
        <tr>
            <td>角色创建时间</td>
            <td></td>
        </tr>
        <tr>
            <td>角色说明</td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>
<button class="btn btn-orange" onclick="grantURConfirm('<?= $admin_url ?>')">
    确认赋予角色
</button>

<script>
    $(function () {   //模糊查询
        var tab = '<?=$tab?>';
        $("#<?=$tab?>-role-input").keyup(function () {
            var word = $(this).val();
            var data = {
                action: 'rbac_autocomplete',
                part: 'role',
                word: word
            };
            $.ajax({
                type: 'post',
                url: '<?=admin_url('admin-ajax.php')?>',
                data: data,
                dataType: 'text',
                success: function (response) {
                    var part = 'role';
                    autoComplete(response.trim(), tab, part);
                }
            })
        });
        $("#<?=$tab?>-user-input").keyup(function () {
            var word = $(this).val();
            var data = {
                action: 'rbac_autocomplete',
                part: 'user',
                word: word
            };
            $.ajax({
                type: 'post',
                url: '<?=admin_url('admin-ajax.php')?>',
                data: data,
                dataType: 'text',
                success: function (response) {
                    var part = 'user';
                    autoComplete(response.trim(), tab, part);
                }
            })
        })
    });
    function saveChecked(td) {
        var id = [];
        //td是很多td组成的,其中需要的是#hidden_id的数据组成数组
        for (var j = 0; j < td[0].length; j++) {
            var loc = td[0][j];
            id.push($(loc).children('#hidden_id').text());
        }
        return id;
    }
    function grantURConfirm(url) {
        var td_user = [];
        var td_role = [];
        td_user.push($('#user_tbody .warning'));
        td_role.push($('#role_tbody .warning'));
        var user_id = saveChecked(td_user).toString();
        var role_id = saveChecked(td_role).toString();
        var data = {
            action: 'grant_ur_confirm',
            user_id: user_id,
            role_id: role_id
        }
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: "text",
            success: function (response) {
                //console.log(response);
                layer.msg('配置成功', {time: 2000, icon: 1});
                location.reload();
            },
            error: function () {
                alert("error");
            }
        });
    }
</script>

