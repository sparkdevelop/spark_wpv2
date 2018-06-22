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
<h4>角色列表</h4>
<div class="divline"></div>
<div class="rl-search-box">
    <input type="text" id="<?= $tab ?>-role-input" class="form-control <?= $tab ?>-text" placeholder="请输入角色名称">
    <button class="btn btn-green" onclick="addToChosenList('<?= $tab ?>','role','<?= $admin_url ?>')">搜索</button>
    <button class="btn btn-green" onclick="new_role()">新建角色</button>
</div>
<div id="autocomplete-role" style="display: none">
    <ul class="list-group"></ul>
</div>
<div id="rl-table" style="margin-top: 30px">
    <table id="rl-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>角色名称</th>
            <th>角色ID</th>
            <th>对应权限</th>
            <th>角色创建时间</th>
            <th>角色说明</th>
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

        var url ='<?=$admin_url?>';
        var type = 'role';
        var data = {
            action: 'rbac_get_list_info',
            part: type,
            word: ''
        };
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            success: function (res) {
                for(var j =0;j<res.length;j++){
                    var id = "#" + tab + "-table-border";
                    var info = $(id + ' thead tr th');
                    var tr_id = type + '_' + res[j][1];
                    var tr = '<tr id=' + tr_id + '>';
                    $(id + ' tbody').append(tr);
                    for (var i = 0; i < info.length - 1; i++) {
                        var td = '<td>' + res[j][i] + '</td>';
                        $(id + ' tbody tr:last').append(td);
                    }
                    var append = '<td>' +
                        '<button class="btn btn-link" onclick="layerConfirmConfig(' + '\'' + tab + '\',' + '\'' + type + '\',' + res[j][1] + ',\'' + url + '\')"><span class="glyphicon glyphicon-edit"></span></button>' +
                        '<button class="btn btn-link" onclick="layerConfirmDelete(' + '\'' + type + '\',' + res[j][1] + ',\'' + url + '\')"><span class="glyphicon glyphicon-trash"></span></button>' +
                        '</td></tr>';
                    $(id + ' tbody tr:last').append(append);
                }
            }
        })
    });

    function new_role() {
        layer.open({
            type: 2,
            title: "新建角色",
            content: '<?=site_url() . get_page_address('create_role')?>',
            area: ['60%', '66%'],
            closeBtn: 1,
            shadeClose: true,
            shade: 0.5,
            end: function () {
            }
        })
    }

</script>
