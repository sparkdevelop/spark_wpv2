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
    #hidden_id{
        display:none
    }
</style>

<h4>查询用户权限</h4>
<div class="divline"></div>
<div class="<?= $tab ?>-search-box">
    <input type="text" class="form-control <?= $tab ?>-text" id="<?= $tab ?>-user-input" placeholder="请输入用户名称">
    <button class="btn btn-green" onclick="addToUserTable('<?= $tab ?>','user','<?= $admin_url ?>')">查询</button>
</div>
<div id="autocomplete-user" style="display: none">
    <ul class="list-group"></ul>
</div>
<div id="ul-table" style="margin-top: 30px">
    <table id="ul-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="5">用户的角色&权限信息</th>
        </tr>
        <tr style="background-color: #ffe9e1">
            <th style="display: none">角色ID</th>
            <th>角色名称</th>
            <th style="display: none">权限ID</th>
            <th>权限名称</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script>
    $(function () {   //模糊查询
        var tab = '<?=$tab?>';
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
        });
    });
</script>