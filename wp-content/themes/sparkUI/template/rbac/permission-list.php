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
<h4>权限列表</h4>
<div class="divline"></div>
<div class="pl-search-box">
    <input type="text" id="<?=$tab ?>-permission-input" class="form-control <?=$tab ?>-text" placeholder="请输入权限名称/ID">
    <button class="btn btn-green" onclick="addToChosenList('<?= $tab ?>','permission','<?= $admin_url ?>')">搜索</button>
    <button class="btn btn-green" onclick="new_permission()">新建权限</button>
</div>
<div id="autocomplete-permission" style="display: none">
    <ul class="list-group"></ul>
</div>
<div id="pl-table" style="margin-top: 30px">
    <table id="pl-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>权限名称</th>
            <th>权限ID</th>
            <th>对应角色</th>
            <th>权限创建时间</th>
            <th>权限说明</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <tr>
        </tr>
        </tbody>
    </table>
</div>
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
    });
    function new_permission(){
        window.open('<?=site_url().get_page_address('create_permission')?>');
//        layer.open({
//            type: 2,
//            title: "新建权限",
//            content: '<?//=site_url().get_page_address('create_permission')?>//',
//            area: ['66%','66%'],
//            closeBtn:1,
//            shadeClose:true,
//            shade:0.5,
//            end:function () {}
//        })
    }
</script>


