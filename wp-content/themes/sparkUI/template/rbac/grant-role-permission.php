<?php ?>
<style>
    .grp-search-box {
        margin-top: 30px;
    }

    .grp-text {
        width: 50%;
        display: inline;
    }

    .btn-green {
        margin-top: 0px;
        padding: 0 0;
        margin-left: 20px;
        margin-right: 0px;
    }

    /*并列表格的包裹div*/
    #role-info-table,
    #permission-info-table {
        margin-top: 30px;
        overflow: auto;
    }

    /*对表格的统一设置*/
    #role-info-table table,
    #permission-info-table table {
        width: 45%;
        display: inline-table;
    }

    /*表格文字水平居中*/
    #role-info-table table > tbody > tr > td,
    #permission-info-table table > tbody > tr > td {
        vertical-align: middle;
    }

    /*表头背景设置*/
    #role-info-table table > thead,
    #permission-info-table table > thead {
        background-color: #FF9966;
    }

    /*并列表格中,右侧的表格设置*/
    #role-info-table-border,
    #permission-info-table-border {
        float: right;
        margin-right: 20px
    }

</style>
<h4>角色基本信息</h4>
<div class="divline"></div>
<div class="grp-search-box">
    <input type="text" class="form-control grp-text" placeholder="请输入角色名称/ID">
    <button class="btn btn-green">查询</button>
</div>
<div id="role-info-table">
    <table id="role-choose-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>已选择角色</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>北邮</td>
        </tr>
        <tr>
            <td>学生</td>
        </tr>
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
            <td>北邮</td>
        </tr>
        <tr>
            <td>角色创建时间</td>
            <td>2018-03-01</td>
        </tr>
        <tr>
            <td>角色关联权限</td>
            <td>阅读北邮相关wiki<br>
                阅读北邮相关问答<br>
                阅读北邮相关项目
            </td>
        </tr>
        <tr>
            <td>角色说明</td>
            <td>
                <button class="btn-green" style="margin-left: 0px">查看</button>
            </td>
        </tr>
        </tbody>
    </table>
</div>

<h4>为角色配置权限</h4>
<div class="divline"></div>
<div class="grp-search-box">
    <input type="text" class="form-control grp-text" placeholder="请输入权限名称/ID">
    <button class="btn btn-green">查询</button>
</div>
<div id="permission-info-table">
    <table id="permission-choose-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>已选择权限</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>北邮</td>
        </tr>
        <tr>
            <td>大一</td>
        </tr>
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
            <td>阅读北邮相关wiki</td>
        </tr>
        <tr>
            <td>权限创建时间</td>
            <td>2018-03-01</td>
        </tr>
        <tr>
            <td>权限关联角色</td>
            <td>北邮<br>
                学生<br>
            </td>
        </tr>
        <tr>
            <td>权限说明</td>
            <td>
                <button class="btn-green" style="margin-left: 0px">查看</button>
            </td>
        </tr>
        </tbody>
    </table>
</div>


<script>
    $(function () {
        var $thr = $('#user-choose-table-border thead tr');
        console.log($thr);

        function initTableCheckbox() {
            var $thr = $('#user-choose-table-border thead tr');
            var $checkAllTh = $('<th><input type="checkbox" id="checkAll" name="checkAll" /></th>');
            /*将全选/反选复选框添加到表头最前，即增加一列*/
            $thr.prepend($checkAllTh);
            /*全选框*/
            var $checkAll = $thr.find('input'); //checkbox
            $checkAll.click(function (event) {
                /*将所有行的选中状态设成全选框的选中状态*/
                $tbr.find('input').prop('checked', $(this).prop('checked'));
                /*并调整所有选中行的CSS样式*/
                if ($(this).prop('checked')) {
                    $tbr.find('input').parent().parent().addClass('warning');
                } else {
                    $tbr.find('input').parent().parent().removeClass('warning');
                }
                /*保存选中行的数据  每点击一次,push 一个id进来*/
//                var td = new Array();
//                td.push($('.warning'));
//                saveChecked(td);
                /*阻止向上冒泡，以防再次触发点击操作*/
                event.stopPropagation();
            });
            /*点击全选框所在单元格时也触发全选框的点击操作*/
            $checkAllTh.click(function () {
                $(this).find('input').click();
            });
            var $tbr = $('#user-choose-table-border tbody tr');
            var $checkItemTd = $('<td><input type="checkbox" name="checkItem" /></td>');
            /*每一行都在最前面插入一个选中复选框的单元格*/
            $tbr.prepend($checkItemTd);
            /*点击每一行的选中复选框时*/
            $tbr.find('input').click(function (event) {
                /*调整选中行的CSS样式*/
                $(this).parent().parent().toggleClass('warning');
                /*如果已经被选中行的行数等于表格的数据行数，将全选框设为选中状态，否则设为未选中状态*/
                $checkAll.prop('checked', $tbr.find('input:checked').length == $tbr.find('input').length ? true : false);
                /*阻止向上冒泡，以防再次触发点击操作*/
                event.stopPropagation();
            });
            /*点击每一行时也触发该行的选中操作*/
            $tbr.click(function () {
                $(this).find('input').click();
            });
        }

        initTableCheckbox();
    });
</script>
