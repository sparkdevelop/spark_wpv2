<?php
$group_id = $group['ID'];
$group_verify_field = get_verify_field($group_id, 'group');   //获取群组的验证字段作为表头
$member_info = get_member_info($group_id);
?>
<style>
    #member_manage_table{
        border: 1px solid lightgrey;
        margin: 20px 20px;
        width: 95%
    }
    .table,.table-striped,.table-bordered {
        margin: 20px 0px;
    }
    .table,.table-striped thead {
        border: 1px solid #f9f9f9;
    }
    .table,.table-bordered thead > tr >th {
        border-bottom-width: 1px;
        text-align: center;
    }
    .table,.table-striped thead > tr >th {
        text-align: center;
        border-bottom-width: 1px;
        border-right: 1px solid #f2f2f2;
    }
    .table,.table-striped tbody > tr >td {
        text-align: center;
        border: 1px solid #f2f2f2;
    }
</style>
<table class="table table-striped" id="member_manage_table">
    <thead>
    <tr>
        <th style="display: none">id</th>
        <th>用户名</th>
        <?php
        if(sizeof($group_verify_field)!=0){
            for ($i = 0; $i < sizeof($group_verify_field); $i++) {?>
                <th><?=$group_verify_field[$i]?></th>
            <?php }
        } ?>
        <th>身份</th>
    </tr>
    </thead>
    <tbody>

        <?php
        //外层循环控制几行
        for ($i = 0; $i < sizeof($member_info); $i++) {?>
        <tr>
            <td id="hidden_id" style="display: none"><?=$member_info[$i][0]?></td>
            <?php
            //内循环控制字段
            for ($j = 1; $j < sizeof($group_verify_field)+3; $j++) {?>
                <td><?=$member_info[$i][$j]?></td>
            <?php }
        } ?>
        </tr>
    </tbody>
</table>
<style>
    .btn-green{
        width: 100px;
        height: 35px;;
    }
</style>
<?php
//    $admin_url = admin_url('admin-ajax.php');
//    $user_id = $_POST['user_id'];
//?>
<div style="display: inline-block;vertical-align: super;margin-left: 20px">
    <button class="btn-green"  onclick="changeIndentity('<?=$admin_url?>','admin',<?=$group_id?>)">设为管理员</button>
    <button class="btn-green" onclick="changeIndentity('<?=$admin_url?>','member',<?=$group_id?>)">设为普通成员</button>
    <button class="btn-green" onclick="kick_out_the_group('<?=$admin_url?>',<?=$group_id?>)">踢出群组</button>
</div>

<script>
    $(function(){
        function initTableCheckbox() {
            var $thr = $('table thead tr');
            var $checkAllTh = $('<th><input type="checkbox" id="checkAll" name="checkAll" /></th>');
            /*将全选/反选复选框添加到表头最前，即增加一列*/
            $thr.prepend($checkAllTh);
            /*全选框*/
            var $checkAll = $thr.find('input'); //checkbox
            $checkAll.click(function(event){
                /*将所有行的选中状态设成全选框的选中状态*/
                $tbr.find('input').prop('checked',$(this).prop('checked'));
                /*并调整所有选中行的CSS样式*/
                if ($(this).prop('checked')) {
                    $tbr.find('input').parent().parent().addClass('warning');
                } else{
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
            $checkAllTh.click(function(){
                $(this).find('input').click();
            });
            var $tbr = $('table tbody tr');
            var $checkItemTd = $('<td><input type="checkbox" name="checkItem" /></td>');
            /*每一行都在最前面插入一个选中复选框的单元格*/
            $tbr.prepend($checkItemTd);
            /*点击每一行的选中复选框时*/
            $tbr.find('input').click(function(event){
                /*调整选中行的CSS样式*/
                $(this).parent().parent().toggleClass('warning');
                /*如果已经被选中行的行数等于表格的数据行数，将全选框设为选中状态，否则设为未选中状态*/
                $checkAll.prop('checked',$tbr.find('input:checked').length == $tbr.find('input').length ? true : false);
                /*阻止向上冒泡，以防再次触发点击操作*/
                event.stopPropagation();
            });
            /*点击每一行时也触发该行的选中操作*/
            $tbr.click(function(){
                $(this).find('input').click();
            });
        }
        initTableCheckbox();

    });
    function saveChecked(td) {
        var user_id = [];
        //td是很多td组成的,其中需要的是#hidden_id的数据组成数组
        for(var j=0;j<td[0].length;j++){
            var loc = td[0][j];
            user_id.push($(loc).children('#hidden_id').text());
        }
        return user_id;
    }

    function changeIndentity(url,indentity,group_id) {
        var td = [];
        td.push($('.warning'));
        var user_id = saveChecked(td);
        var data = {
            action: 'changeIndentity',
            indentity: indentity,
            group_id: group_id,
            user_id: user_id
        };
        $.ajax({
            //async: false,    //否则永远返回false
            type: "POST",
            url: url,
            data: data,
            dataType:"text",
            success: function () {
                layer.msg('修改成功', {time: 2000, icon: 1});
                location.reload();
            },
            error:function () {
                alert("error");
            }
        });
    }

    function kick_out_the_group(url,group_id){
        var td = [];
        td.push($('.warning'));
        var user_id = saveChecked(td);
        var data = {
            action: 'kick_out_the_group',
            group_id: group_id,
            user_id: user_id
        };
        $.ajax({
            //async: false,    //否则永远返回false
            type: "POST",
            url: url,
            data: data,
            dataType:"text",
            success: function (response) {
                if(response.trim()=="success") {
                    layer.msg('已移除', {time: 2000, icon: 1});
                    location.reload();
                }else{
                    layer.msg('不能将唯一的管理员剔出群组', {time: 2000, icon: 2});
                    location.reload();
                }
            },
            error:function () {
                alert("error");
            }
        });
    }
</script>