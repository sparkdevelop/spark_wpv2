<?php ?>
<style>
    #user-text {
        width: 50%;
        display: inline;
    }

    #user-search-box {
        margin-top: 30px;
    }

    .btn-green {
        margin-top: 0px;
        padding: 0 0;
        margin-left: 20px;
        margin-right: 0px;
    }
    #user-search-table table>tbody>tr>td{
        vertical-align: middle;
    }
    #user-search-table table{
        width: 45%;
        display: inline-table;
    }
    #user-permission-table-border{
        float:right;
        margin-right: 20px
    }
    #user-search-table table>thead{
        background-color: #FF9966;
    }
    #user-search-table table>thead>tr:nth-child(2) {
        background-color: #FFCC99
    }
</style>

<h4>查询用户权限</h4>
<div class="divline"></div>
<div id="user-search-box">
    <input type="text" id="user-text" class="form-control" placeholder="请输入用户名称/ID">
    <button class="btn btn-green">查询</button>
</div>
<div id="user-search-table" style="margin-top: 30px">
    <table id="user-info-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="2">用户信息</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>用户昵称</td>
            <td>Park</td>
        </tr>
        <tr>
            <td>用户ID</td>
            <td>5097</td>
        </tr>
        <tr>
            <td>注册时间</td>
            <td>2017-10-14</td>
        </tr>
        <tr>
            <td>归属角色</td>
            <td>学生<br>
                管理员<br>
                北邮<br>
                大四</td>
        </tr>
        </tbody>
    </table>
    <table id="user-permission-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th colspan="3">用户权限信息</th>
        </tr>
        <tr>
            <th>权限名</th>
            <th>权限ID</th>
            <th>权限说明</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>北邮</td>
            <td>001</td>
            <td>
                <button class="btn-green" style="margin-left: 0px">查看</button>
            </td>
        </tr>
        <tr>
            <td>大一</td>
            <td>002</td>
            <td>
                <button class="btn-green" style="margin-left: 0px">查看</button>
            </td>
        </tr>
        </tbody>
    </table>

</div>