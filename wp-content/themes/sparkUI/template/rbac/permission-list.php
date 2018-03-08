<?php ?>
<style>
    #pl-text {
        width: 50%;
        display: inline;
    }

    #pl-search-box {
        margin-top: 30px;
    }

    #pl-table-border thead{
        background-color: #f2f2f2;
    }

    .btn-green {
        margin-top: 0px;
        padding: 0 0;
        margin-left: 20px;
        margin-right: 0px;
    }
    .table>tbody>tr>td{
        vertical-align: middle;
    }
    .table-hover>tbody>tr:hover{
        background-color: lightgoldenrodyellow;
    }
    .table>tbody>tr>td a{
        color: #333333;
    }
    .table>tbody>tr>td a:focus,span:focus, a:hover,span:hover {
        color: #fe642d;
        text-decoration: none;
    }
</style>
<h4>权限列表</h4>
<div class="divline"></div>
<div id="pl-search-box">
    <input type="text" id="pl-text" class="form-control" placeholder="请输入权限名称/ID">
    <button class="btn btn-green">搜索</button>
    <button class="btn btn-green">新建角色</button>
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
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>北邮项目读取</td>
            <td>001</td>
            <td>
                <button class="btn-green" style="margin-left: 0px">查看</button>
            </td>
            <td>2017-01-01</td>
            <td>赋予用户该权限后,用户有权查看北邮的私有项目</td>
        </tr>
        </tbody>
    </table>
</div>


