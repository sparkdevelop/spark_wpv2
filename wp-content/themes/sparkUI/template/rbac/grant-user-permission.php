<?php

?>
<style>
    .gup-search-box {
        margin-top: 30px;
    }

    .gup-text {
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
    #user-info-table,
    #permission-info-table {
        margin-top: 30px;
        overflow: auto;
    }

    /*对表格的统一设置*/
    #user-info-table table,
    #permission-info-table table {
        width: 45%;
        display: inline-table;
    }

    /*表格文字水平居中*/
    #user-info-table table > tbody > tr > td,
    #permission-info-table table > tbody > tr > td {
        vertical-align: middle;
    }

    /*表头背景设置*/
    #user-info-table table > thead,
    #permission-info-table table > thead {
        background-color: #FF9966;
    }

    /*并列表格中,右侧的表格设置*/
    #user-info-table-border,
    #permission-info-table-border {
        float: right;
        margin-right: 20px
    }

    /*相关搜索下拉框样式*/
    #autocomplete{
        width: 50%;
        border:1px solid lightgray;
        border-radius: 0 0 5px 5px;
    }
    #autocomplete ul{
        padding: 0;
        margin:0;
    }
    #autocomplete ul>li{
        padding: 0;
        margin: 0;
        padding-left: 10px;
        height:30px;
        line-height: 30px;

    }

</style>
<h4>用户基本信息</h4>
<div class="divline"></div>
<div class="gup-search-box">
    <input type="text" class="form-control gup-text" placeholder="请输入用户名称/ID">
    <button class="btn btn-green">查询</button>
</div>
<div id="user-info-table">
    <table id="user-choose-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>已选择用户</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>piaoning</td>
        </tr>
        <tr>
            <td>zhangxue</td>
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
            <td>Park</td>
        </tr>
        <tr>
            <td>用户ID</td>
            <td>5097</td>
        </tr>
        <tr>
            <td>学校</td>
            <td>北邮</td>
        </tr>
        <tr>
            <td>性别</td>
            <td>男</td>
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
                大四
            </td>
        </tr>
        <tr>
            <td>拥有权限</td>
            <td>查看所有wiki<br>
                查看北邮项目
            </td>
        </tr>
        </tbody>
    </table>
</div>

<h4>为用户配置权限</h4>
<div class="divline"></div>
<div class="gup-search-box">
    <input type="text" class="form-control gup-text" id="gup-input" placeholder="请输入权限名称/ID">
    <button class="btn btn-green" onclick="addToChosen()">查询</button>
</div>
<div id="autocomplete" style="display: none">
    <ul class="list-group"></ul>
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
<button class="btn btn-orange">
    确认赋予权限
</button>


<script>
    $(function () {
        initTableCheckbox('#user-choose-table-border');
        initTableCheckbox('#permission-choose-table-border');
        $('#permission-choose-table-border')
    });
    $(function () {
        $("#gup-input").keyup(function () {
            var word = $(this).val();
            var data = {
                action: 'autocomplete_permission',
                word: word
            };
                $.ajax({
                    type:'post',
                    url:'<?=admin_url('admin-ajax.php')?>',
                    data:data,
                    dataType: 'text',
                    success: function (response) {
                        var arr = response.trim().split("|");
                        arr.pop();
                        var li = "";
                        if(arr.length!=0){
                            $.each(arr, function (i,val){
                                li += "<li class='list-group-item'>" + val + "</li>";
                            });
                            $("#autocomplete ul").html(li);
                            $("#autocomplete").slideDown('fast');
                            //鼠标经过元素的背景颜色改变
                            $("#autocomplete ul li").bind('mouseenter', function () {
                                $(this).css({'background': '#e9e8e9'})
                            });
                            $("#autocomplete ul li").bind('mouseleave', function () {
                                $(this).css({'background': 'transparent'})
                            });
                            $("#autocomplete ul li").bind('click', function () {
                                $("#gup-input").val($(this).html());
                                $("#autocomplete").slideUp('fast');
                            });
                        }
                        else{
                            $("#autocomplete").slideUp('fast');
                        }
                    }
                })
        })
    });
    function addToChosen() {
        //本函数中要加上判断
        var name= $('#gup-input').val();
        var data = {
            action: 'autocomplete_permission',
            word: name
        };
        $.ajax({
            type:'post',
            url:'<?=admin_url('admin-ajax.php')?>',
            data:data,
            dataType: 'text',
            success: function (response) {
                if(response.trim()==''){  // 如果没有
                    layer.msg("无此权限",{time:2000,icon:2})
                }
                else{
                    var tr = "<tr><td>"+name+"</td></tr>";
                    $('#permission-choose-table-border tbody:last').append(tr);
                }
            }
        })

    }

</script>
