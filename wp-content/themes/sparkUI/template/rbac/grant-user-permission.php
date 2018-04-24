<?php
$tab = isset($_GET['tab']) && !empty($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'gup';
$admin_url = admin_url('admin-ajax.php'); ?>
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
    <input type="text" class="form-control <?= $tab ?>-text" id="<?= $tab ?>-user-input" placeholder="请输入用户名称">
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
            <th colspan="3">用户信息</th>
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

<h4>为用户配置权限</h4>
<div class="divline"></div>
<div class="<?= $tab ?>-search-box">
    <input type="text" class="form-control <?= $tab ?>-text" id="<?= $tab ?>-permission-input" placeholder="请输入权限名称">
    <button class="btn btn-green" onclick="addToChosen('<?= $tab ?>','permission','<?= $admin_url ?>')">查询</button>
</div>
<div id="autocomplete-permission" style="display: none">
    <ul class="list-group"></ul>
</div>
<div id="permission-info-table">
    <table id="permission-choose-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="3">已选择权限</th>
        </tr>
        </thead>
        <tbody id="permission_tbody">
        </tbody>
    </table>
    <table id="permission-info-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="2">权限信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>权限名称</td>
            <td></td>
        </tr>
        <tr>
            <td>权限ID</td>
            <td></td>
        </tr>
        <tr>
            <td>权限关联角色</td>
            <td></td>
        </tr>
        <tr>
            <td>权限创建时间</td>
            <td></td>
        </tr>
        <tr>
            <td>权限说明</td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>
<button class="btn btn-orange" onclick="grantUPConfirm('<?= $admin_url ?>')">
    确认赋予权限
</button>


<script>
    $(function () {   //模糊查询
        var tab = '<?=$tab?>';
        $("#<?=$tab?>-permission-input").keyup(function () {
            var word = $(this).val();
            var data = {
                action: 'rbac_autocomplete',
                part: 'permission',
                word: word
            };
            $.ajax({
                type: 'post',
                url: '<?=admin_url('admin-ajax.php')?>',
                data: data,
                dataType: 'text',
                success: function (response) {
                    var part = 'permission';
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
    function grantUPConfirm(url) {
        var td_user = [];
        var td_pms = [];
        td_user.push($('#user_tbody .warning'));
        td_pms.push($('#permission_tbody .warning'));
        var user_id = saveChecked(td_user).toString();
        var pms_id = saveChecked(td_pms).toString();
        var data = {
            action: 'grant_up_confirm',
            user_id: user_id,
            permission_id: pms_id
        };
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: "text",
            success: function () {
                layer.msg('配置成功', {time: 2000, icon: 1});
                location.reload();

            },
            error: function () {
                alert("error");
            }
        });
    }
</script>
