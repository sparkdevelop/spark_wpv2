<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/6/29
 * Time: 下午5:05
 */
$task_id = isset($_GET['id']) ? $_GET['id'] : "";
$group_id = get_task_group($task_id);
$task = get_task($group_id, $task_id);
$group = get_group($group_id);
?>
<style>
    #my_group_badge {
        color: #fe642d;
        border: solid 1px;
        border-color: #fe642d;
        float: right;
        margin-top: 10px;
    }

    #li_joined_groups {
        display: inline-block;
        width: 80%;
        float: right
    }

    #li_joined_groups a {
        margin-left: 20px;
        font-size: medium;
        font-weight: bold;
        height: 40px;
        line-height: 40px;
    }
</style>
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <!--我加入的群组-->
    <div class="sidebar_list">
        <div class="sidebar_list_header">
            <p>我加入的群组</p>
        </div>
        <!--分割线-->
        <div class="sidebar_divline"></div>

        <div id="joined_groups" style="word-wrap: break-word; word-break: keep-all;">
            <ul class="list-group">
                <?php
                for ($i = 0; $i < 5; $i++) {
                    ?>
                    <li class="list-group-item" style="width: 100%">
                        <div style="display: inline-block;width:20%">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="li_joined_groups">
                            <a href="#">造梦空间</a>
                            <!--                            判断是否是该群群主-->
                            <span class="badge" id="my_group_badge">我创建的</span>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <!--未完成任务-->
    <div class="sidebar_list">
        <div class="sidebar_list_header">
            <p>未完成任务</p>
        </div>
        <div class="sidebar_divline"></div>
        <ul class="list-group">
            <?php
            for ($i = 0; $i < 5; $i++) {
                ?>
                <li class="list-group-item">
                    <span><a href="#">学习wiki课程“电子电路基础”</a></span>
                    <span style="float: right">1天</span>
                </li>
            <?php } ?>
        </ul>
    </div>

    <!--群组动态-->
    <div class="sidebar_list">
        <div class="sidebar_list_header">
            <p>群组动态</p>
        </div>
        <!--分割线 下面的是列表-->
        <div class="sidebar_divline"></div>
        <!--列表内容 需要填写的都用php提取出来就行-->
        <ul class="list-group">
            <?php
            $task_author = "黄冰瑶";
            $task_identity = "管理员";
            $group_name = "造梦空间";
            $task_name = "学习导论实践课wiki的基础课程";
            $task_address = "#";
            for ($i = 0; $i < 5; $i++) {
                ?>
                <li class="list-group-item">
                    <span><?= $task_identity . $task_author ?>发布了任务:</span>
                    <span><a href="<?= $task_address ?>" style="color: #169bd5"><?= $task_name ?></a></span>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
</div>