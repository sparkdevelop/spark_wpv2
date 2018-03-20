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
    <input type="text" class="form-control <?= $tab ?>-text" id="<?= $tab ?>-user-input" placeholder="请输入用户名称/ID">
    <button class="btn btn-green" onclick="addToChosen('<?= $tab ?>','user','<?= $admin_url ?>')">查询</button>
</div>
<div id="autocomplete-user" style="display: none">
    <ul class="list-group"></ul>
</div>
<div id="user-info-table">
    <table id="user-choose-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="2">已选择用户</th>
        </tr>
        </thead>
        <tbody>
        <tr style="display: none">
            <td></td>
        </tr>
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
        <tr>
            <td>学校</td>
            <td></td>
        </tr>
        <tr>
            <td>性别</td>
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

<h4>为用户配置角色</h4>
<div class="divline"></div>
<div class="<?= $tab ?>-search-box">
    <input type="text" class="form-control <?= $tab ?>-text" id="<?= $tab ?>-role-input" placeholder="请输入角色名称/ID">
    <button class="btn btn-green" onclick="addToChosen('<?= $tab ?>','role','<?= $admin_url ?>')">查询</button>
</div>
<div id="autocomplete-role" style="display: none">
    <ul class="list-group"></ul>
</div>
<div id="role-info-table">
    <table id="role-choose-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="2">已选择角色</th>
        </tr>
        </thead>
        <tbody>
        <tr style="display:none;">
            <td></td>
        </tr>
        </tbody>
    </table>
    <table id="role-info-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="2">角色信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>角色名称</td>
            <td></td>
        </tr>
        <tr>
            <td>角色创建时间</td>
            <td></td>
        </tr>
        <tr>
            <td>角色关联权限</td>
            <td></td>
        </tr>
        <tr>
            <td>角色说明</td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>


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
</script>

