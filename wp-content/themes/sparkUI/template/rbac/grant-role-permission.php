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
<h4>角色基本信息</h4>
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
            <th colspan="2">角色基本信息</th>
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

<h4>为角色配置权限</h4>
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
<button class="btn btn-orange" onclick="grantRPConfirm('<?= $admin_url ?>')">
    确认赋予权限
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
    function grantRPConfirm(url) {
        var td_role = [];
        var td_permission = [];
        td_role.push($('#role_tbody .warning'));
        td_permission.push($('#permission_tbody .warning'));
        var role_id = saveChecked(td_role).toString();
        var permission_id = saveChecked(td_permission).toString();
        var data = {
            action: 'grant_rp_confirm',
            role_id: role_id,
            permission_id: permission_id
        }
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            dataType: "text",
            success: function (response) {
                console.log(response);
                layer.msg('配置成功', {time: 2000, icon: 1});
                //location.reload();
            },
            error: function () {
                alert("error");
            }
        });
    }


</script>
