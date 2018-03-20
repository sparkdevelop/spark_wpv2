<?php ?>
<style>
    #rl-text {
        width: 50%;
        display: inline;
    }

    #rl-search-box {
        margin-top: 30px;
    }
    .btn-green {
        margin-top: 0px;
        padding: 0 0;
        margin-left: 20px;
        margin-right: 0px;
    }

    #rl-table-border thead{
        background-color: #f2f2f2;
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
<h4>角色列表</h4>
<div class="divline"></div>
<div id="rl-search-box">
    <input type="text" id="rl-text" class="form-control" placeholder="请输入角色名称/ID">
    <button class="btn btn-green">搜索</button>
    <button class="btn btn-green" onclick="window.open('<?=site_url().get_page_address('create_role')?>')">新建角色</button>
</div>
<div id="rl-table" style="margin-top: 30px">

<!--    <div id="task-pro-complete-table" class="table-responsive">-->
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
            <tr>
                <td>北邮大一</td>
                <td>001</td>
                <td>
                    <button class="btn-green" style="margin-left: 0px">查看</button>
                </td>
                <td>2017-01-01</td>
                <td>北邮的大一新生</td>
                <td>
                    <a href="#">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="#">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
<!--    </div>-->
</div>


