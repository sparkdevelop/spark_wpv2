<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/6/30
 * Time: 下午7:22
 */
//print_r($task);
$group = get_group($group_id)[0];
$post_link = get_verify_field($task['ID'],'task');
//print_r($group);
//print_r($post_link);
?>
<style>
    #single-task-abstract p {
        background: #f9f9f9;
        padding: 20px 20px;
        margin-top: 10px;
    }

    #single-task-abstract {
        margin-top: 20px;
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
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <div id="single-task-title">
        <h3>任务 : <?= $task['task_name'] ?></h3>
        <div id="task-info" style="margin-top: 20px">
            <span>群组: <?= $group['group_name'] ?></span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
            <span>截止: <?= $task['deadline'] ?></span>&nbsp;&nbsp;
            <span>还剩x天</span>
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
            for ($i=0;$i<sizeof($post_link);$i++){ ?>
                <tr>
                    <td><?=$i+1?></td>
                    <td><a href="<?=$post_link[$i]?>">link名字</a></td>
                    <td>未完成</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div id="single-task-member-complete">
        <h4>组员完成情况 : </h4>
        <span>80%组员已完成</span>
        <table class="table table-bordered">
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