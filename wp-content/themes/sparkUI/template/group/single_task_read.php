<?php
$group = get_group($group_id)[0];
$post_link = get_verify_field($task['ID'],'task');
$countdown = countDown($task_id);
$group_verify_field = get_verify_field($group_id, 'group');   //获取群组的验证字段作为表头
$member_info = get_member_info($group_id);
$per_all = complete_percentage($group_id,$task_id);
?>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <div id="single-task-title">
        <h3>任务 : <?= $task['task_name'] ?></h3>
        <div id="task-info" style="margin-top: 20px">
            <span>群组: <?= $group['group_name'] ?></span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
            <span>截止: <?= $task['deadline'] ?></span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
            <?php
                if($countdown!=0){
                    $countdown = "还剩 ".$countdown." 天";
                }else{
                    $countdown = "已截止";
                }
            ?>
            <span style="color: #fe642d"><?=$countdown?></span>
        </div>
    </div>
    <div class="divline"></div>
    <div id="single-task-abstract">
        <h4>任务详情: </h4>
        <p><?= $task['task_content'] ?></p>
    </div>
    <div id="single-task-complete">
        <h4 style="margin-top: 25px">完成情况 : </h4>
        <table class="table table-striped">
            <thead>
            <tr>
                <th style="width: 10%">序号</th>
                <th>需阅读文章链接</th>
                <th style="width: 15%">完成情况</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $complete_single = complete_single($task_id);
            for ($i=0;$i<sizeof($post_link);$i++){ ?>
                <tr>
                    <td><?=$i+1?></td>
                    <?php
                    if(is_overdue($task_id)){?>
                        <td><a href="<?=$post_link[$i]?>"><?=$post_link[$i]?></a></td>
                    <?php }else{ ?>
                        <td><a style ="cursor: pointer" onclick="complete_read_task('<?=$post_link[$i]?>','<?=$i?>')"><?=$post_link[$i]?></a></td>
                    <?php } ?>
                    <td id="cmp_<?=$i?>"><?=$complete_single[$i]?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div id="single-task-member-complete">
        <h4>组员完成情况 : </h4>
        <span><?=$per_all?>%组员已完成</span>
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
                <th>完成情况</th>
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
                for ($j = 1; $j < sizeof($group_verify_field)+2; $j++) {?>
                    <td><?=$member_info[$i][$j]?></td>
                <?php }
                    $per = complete_all_read($task_id,$member_info[$i][0]);
                    if($per==100){
                        $url = get_template_directory_uri() . "/img/complete.png";
                        echo '<td><img src="'.$url.'"></td>';
                    }else{
                        echo '<td>'.$per.'%</td>';
                    }
            } ?>
            </tr>
            </tbody>
        </table>

        <table style="display: none" class="table table-bordered">
            <thead>
            <tr>
                <th>序号</th>
                <th>用户名</th>
                <th>真实姓名</th>
                <th>班级</th>
                <th>学号</th>
                <th>完成情况</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Tanmay</td>
                <td>Bangalore</td>
                <td>560001</td>
            </tr>
            <tr>
                <td>Sachin</td>
                <td>Mumbai</td>
                <td>400003</td>
            </tr>
            <tr>
                <td>Uma</td>
                <td>Pune</td>
                <td>411027</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    function complete_read_task(link,id) {
        //把阅读过的链接存到tmp表中
        //比对tmp的链接和verify_field比对,若一致就可以更改成员-任务表的完成情况了
        var data = {
            action: 'complete_read_task',
            task_id : '<?=$task_id?>',
            complete_content:link,
            id: 'cmp_'+id
        };
        $.ajax({
            type:'POST',
            url:'<?=$admin_url?>',
            data:data,
            dataType:"text",
            success:function (response) {
                <?php $url = get_template_directory_uri() . "/img/complete.png";?>
                $(response).html("<img src='<?=$url?>'>");
                window.open(link);
            },
            error: function () {
                alert('error')
            }
        })
    }
</script>