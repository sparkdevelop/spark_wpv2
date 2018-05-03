<?php
$solved_info = rbac_get_solved_info();
?>

<div class="divline" style="margin-top: 0px;margin-bottom: -11px"></div>
<table class="table table-striped" id="apply_manage_table">
    <thead>
    <tr>
        <th>申请人</th>
        <th>申请内容名称</th>
        <th>申请内容类型</th>
        <th>申请理由</th>
        <th>操作人</th>
        <th>状态</th>
        <th>处理日期</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i = 0; $i < sizeof($solved_info); $i++) {?>
        <tr>
            <td id="uid" style="display: none"><?=$solved_info[$i]['user_id']?></td>
            <td id="stype" style="display: none"><?=$solved_info[$i]['source_type']?></td>
            <td id="sid" style="display: none"><?=$solved_info[$i]['source_id']?></td>
            <td><?=$solved_info[$i]['applyer']?></td>
            <td><?=$solved_info[$i]['item_name']?></td>
            <td><?=$solved_info[$i]['item_type']?></td>
            <td><?=$solved_info[$i]['reason']?></td>
            <td><?=$solved_info[$i]['manager']?></td>
            <td><?=$solved_info[$i]['t_state']?></td>
            <td><?=$solved_info[$i]['modified_time']?></td>
        </tr>
    <? } ?>
    </tbody>
</table>
<!--<div>-->
<!--    <div class="col-md-4 col-sm-4 col-xs-4">-->
<!--        <button class="btn-green"-->
<!--                onclick="setAsSolved('pass')">通过申请</button>-->
<!--    </div>-->
<!--    <div class="col-md-4 col-sm-4 col-xs-4">-->
<!--        <button class="btn-green"-->
<!--                onclick="setAsSolved('deny')">驳回申请</button>-->
<!--    </div>-->
<!--</div>-->
<!--<script>-->
<!--    $(function(){-->
<!--        function initTableCheckbox() {-->
<!--            var $thr = $('table thead tr');-->
<!--            var $checkAllTh = $('<th><input type="checkbox" id="checkAll" name="checkAll" /></th>');-->
<!--            /*将全选/反选复选框添加到表头最前，即增加一列*/-->
<!--            $thr.prepend($checkAllTh);-->
<!--            /*全选框*/-->
<!--            var $checkAll = $thr.find('input'); //checkbox-->
<!--            $checkAll.click(function(event){-->
<!--                /*将所有行的选中状态设成全选框的选中状态*/-->
<!--                $tbr.find('input').prop('checked',$(this).prop('checked'));-->
<!--                /*并调整所有选中行的CSS样式*/-->
<!--                if ($(this).prop('checked')) {-->
<!--                    $tbr.find('input').parent().parent().addClass('warning');-->
<!--                } else{-->
<!--                    $tbr.find('input').parent().parent().removeClass('warning');-->
<!--                }-->
<!--                /*保存选中行的数据  每点击一次,push 一个id进来*/-->
<!--//                var td = new Array();-->
<!--//                td.push($('.warning'));-->
<!--//                saveChecked(td);-->
<!--                /*阻止向上冒泡，以防再次触发点击操作*/-->
<!--                event.stopPropagation();-->
<!--            });-->
<!--            /*点击全选框所在单元格时也触发全选框的点击操作*/-->
<!--            $checkAllTh.click(function(){-->
<!--                $(this).find('input').click();-->
<!--            });-->
<!--            var $tbr = $('table tbody tr');-->
<!--            var $checkItemTd = $('<td><input type="checkbox" name="checkItem" /></td>');-->
<!--            /*每一行都在最前面插入一个选中复选框的单元格*/-->
<!--            $tbr.prepend($checkItemTd);-->
<!--            /*点击每一行的选中复选框时*/-->
<!--            $tbr.find('input').click(function(event){-->
<!--                /*调整选中行的CSS样式*/-->
<!--                $(this).parent().parent().toggleClass('warning');-->
<!--                /*如果已经被选中行的行数等于表格的数据行数，将全选框设为选中状态，否则设为未选中状态*/-->
<!--                $checkAll.prop('checked',$tbr.find('input:checked').length == $tbr.find('input').length ? true : false);-->
<!--                /*阻止向上冒泡，以防再次触发点击操作*/-->
<!--                event.stopPropagation();-->
<!--            });-->
<!--            /*点击每一行时也触发该行的选中操作*/-->
<!--            $tbr.click(function(){-->
<!--                $(this).find('input').click();-->
<!--            });-->
<!--        }-->
<!--        initTableCheckbox();-->
<!--    });-->
<!---->
<!--    function saveApplyChecked(td) {-->
<!--        var data = [];-->
<!--        //td是很多td组成的,其中需要的是#hidden_id的数据组成数组-->
<!--        for(var j=0;j<td[0].length;j++){-->
<!--            var loc = td[0][j];-->
<!--            var user_id = $(loc).children('#uid').text();-->
<!--            var source_type = $(loc).children('#stype').text();-->
<!--            var source_id = $(loc).children('#sid').text();-->
<!--            var td_info = [user_id,source_type,source_id];-->
<!--            data.push(td_info);-->
<!--        }-->
<!--        return data;-->
<!--    }-->
<!---->
<!--    function setAsSolved(state) {-->
<!--        var td = [];-->
<!--        td.push($('.warning'));-->
<!--        var info = saveApplyChecked(td);-->
<!--        var data = {-->
<!--            action: 'set_as_solved',-->
<!--            state: state,-->
<!--            info: info-->
<!--        };-->
<!--        $.ajax({-->
<!--            type: "POST",-->
<!--            url: url,-->
<!--            data: data,-->
<!--            dataType:"text",-->
<!--            success: function (response) {-->
<!--                layer.msg('修改成功', {time: 2000, icon: 1});-->
<!--                location.reload();-->
<!--            },-->
<!--            error:function () {-->
<!--                alert("error");-->
<!--            }-->
<!--        });-->
<!--    }-->
<!--</script>-->