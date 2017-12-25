<?php

$allMsg_ini = get_allMsg();
$allMsg = processMsg($allMsg_ini);

$pro_length = count($allMsg);
$perpage = 10;
$total_page = ceil($pro_length / $perpage);

if (!$_GET['paged']) {
    $current_page = 1;
} else {
    $page_num = $_GET['paged'];
    $current_page = $page_num;
}
?>
<style>
    #notice-ava {
        display: inline-block;
        vertical-align: top;
        margin-top: 4px;
        margin-left: 10px
    }

    #ava-img {
        width: 40px;
        height: 40px;
        -webkit-border-radius: 10px;
        margin-left: 5px;
    }
</style>
<script>
    function all_read_delete() {
        layer.confirm('确定删除所有已读群消息?', {
            icon: 3,
            resize:false,
            move:false,
            title:false,
            btnAlign: 'c',
            btn: ['确认', '取消'],
            btn2: function (index) {   //取消的回调
                layer.close(index);
            },
            btn1: function () {   //确认的回调
                var data = {
                    action: 'all_read_delete'
                };
                $.ajax({
                    type: "POST",
                    url: '<?=admin_url('admin-ajax.php')?>',
                    data: data,
                    dataType: "text",
                    success: function () {
                        layer.msg('删除成功!', {time: 2000, icon: 1});
                        location.reload();
                    },
                    error: function () {
                        alert("error");
                    }
                });
            }
        })
    }

    function all_set_as_read() {
        var data = {
            action: 'all_set_as_read'
        };
        $.ajax({
            //async: false,    //否则永远返回false
            type: "POST",
            url: '<?=admin_url('admin-ajax.php')?>',
            data: data,
            dataType: "text",
            success: function () {
                layer.msg('全部设为已读', {time: 2000, icon: 1});
                location.reload();
            },
            error: function () {
                alert("error");
            }
        });
    }

    function set_as_read(url,group_id,notice_type,notice_content) {
        var data = {
            action: 'set_as_read',
            group_id :group_id,
            notice_type : notice_type,
            notice_content : notice_content
        };
        $.ajax({
            type: "POST",
            url: '<?=admin_url('admin-ajax.php')?>',
            data: data,
            dataType: "text",
            success: function () {
                location.href = url
            },
        });
    }

</script>
<div>
    <div class="badge" id="my_group_badge"
         style="cursor:pointer;float: right;margin-top: -27px;margin-right: 5px"
         onclick="all_set_as_read()">
        全部设为已读
    </div>
    <div class="badge" id="my_group_badge"
         style="cursor:pointer;float: right;margin-top: -27px;margin-right: 110px"
         onclick="all_read_delete()">
        删除全部已读
    </div>
</div>

<div class="divline" style="margin-top: 0px;margin-bottom: -11px"></div>
<div id="rightTabContent" class="tab-content">
    <ul class="list-group">
        <?php if (count($allMsg) > 0) {
            //显示一页的东西
            $min_temp = $pro_length < $perpage * $current_page ? $pro_length : $perpage * $current_page;
            for ($i = $perpage * ($current_page - 1); $i < $min_temp; $i++) {
                if ($allMsg[$i]['notice_status'] == 0) {
                    ?>
                    <style>
                        #notice-li-<?=$i?> {
                            background-color: #fafbe9;
                            margin-top: 11px;
                            padding-bottom: 0px;
                        }
                    </style>
                <?php } else {
                    ?>
                    <style>
                        #notice-li-<?=$i?> {
                            background-color: transparent;
                            margin-top: 11px;
                            padding-bottom: 0px;
                        }
                    </style>
                <?php }
                ?>
                <li class="list-group-item" id="notice-li-<?= $i ?>">
                    <?php if ($allMsg[$i]['notice_type'] == 1) {  //自由加入群组有人加入群组
                        // XX加入了你的群组XX
                        $joiner = $allMsg[$i]['notice_content'];   //加入人的id 是否需要转换
                        //$joiner为一个字符串,要转化成为数组。
                        $joiner_main = explode(',',$joiner);
                        $joiner_num = sizeof($joiner_main);
                        $joiner_name = get_the_author_meta('user_login', $joiner_main[0]);  ###########
                        $group_id = $allMsg[$i]['group_id'];      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $time = $allMsg[$i]['modified_time'];  //操作的时间
                        $group_ava = get_group($group_id)[0]['group_cover']; //相关群组的头像
                        $person_url = site_url() . get_page_address('otherpersonal') . '&id=' . $joiner;
                        $group_url = site_url() . get_page_address('single_group') . '&id=' . $group_id . '&tab=member';
                        ?>
                        <div id="notice-ava">
                            <img src="<?= $group_ava ?>" id="ava-img">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a style="color: #169bd5;cursor: pointer"
                                   onclick="set_as_read('<?=$person_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content'] ?>')">
                                    <?= $joiner_name ?>
                                </a>
                                <?
                                if ($joiner_num>1){?>
                                    <span>&nbsp;<span style="font-weight: bolder">等<?=$joiner_num?>人加入</span>了您的群组</span>
                                <?php } else{?>
                                    <span>&nbsp;<span style="font-weight: bolder">加入</span>了您的群组</span>
                                <?php } ?>
                                <span><a style="color:#169bd5;cursor: pointer"
                                         onclick="set_as_read('<?=$group_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content'] ?>')"><?= $group_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right;margin-right: 5px">
                                <div style="text-align: right">
                                    <?
                                    if (time() - strtotime($time) > 24 * 3600) {
                                        echo date('Y年n月j日', strtotime($time));
                                    } else {
                                        echo date('H:i:s', strtotime($time));
                                    }
                                    ?>
                                </div>
                                <div style="float: right;margin-top: 10px;margin-right: 8px">
                                    <img src="<?php bloginfo("template_url") ?>/img/group-icon.png" style="width: 16px;height: 16px">
                                </div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]['notice_type'] == 2) {
                        // XX退出了你的群组XX
                        $joiner = $allMsg[$i]['notice_content'];   //加入人的id 是否需要转换
                        $joiner_main = explode(',',$joiner);
                        $joiner_num = sizeof($joiner_main);
                        $joiner_name = get_the_author_meta('user_login', $joiner_main[0]);  ###########
                        $group_id = $allMsg[$i]['group_id'];      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $person_url = site_url() . get_page_address('otherpersonal') . '&id=' . $joiner;
                        $group_url = site_url() . get_page_address('single_group') . '&id=' . $group_id . '&tab=member';
                        $group_ava = get_group($group_id)[0]['group_cover']; //相关群组的头像
                        $time = $allMsg[$i]['modified_time'];  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?= $group_ava ?>" id="ava-img">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a onclick="set_as_read('<?=$person_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content'] ?>')"
                                   style="color: #169bd5;cursor: pointer"><?= $joiner_name ?></a>
                                <?
                                if ($joiner_num>1){?>
                                    <span>&nbsp;<span style="font-weight: bolder">等<?=$joiner_num?>人退出</span>了您的群组</span>
                                <?php } else{?>
                                    <span>&nbsp;<span style="font-weight: bolder">退出</span>了您的群组</span>
                                <?php } ?>
                                <span><a
                                        onclick="set_as_read('<?=$group_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                        style="color:#169bd5;cursor: pointer"><?= $group_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right;margin-right: 5px">
                                <div style="text-align: right">
                                    <?
                                    if (time() - strtotime($time) > 24 * 3600) {
                                        echo date('Y年n月j日', strtotime($time));
                                    } else {
                                        echo date('H:i:s', strtotime($time));
                                    }
                                    ?>
                                </div>
                                <div style="float: right;margin-top: 10px;margin-right: 8px">
                                    <img src="<?php bloginfo("template_url") ?>/img/group-icon.png" style="width: 16px;height: 16px">
                                </div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]['notice_type'] == 3) {
                        //XX申请加入你的群组XX
                        $joiner = $allMsg[$i]['notice_content'];   //加入人的id 是否需要转换
                        //$joiner为一个字符串,要转化成为数组。
                        $joiner_main = explode(',',$joiner);
                        $joiner_num = sizeof($joiner_main);
                        $joiner_name = get_the_author_meta('user_login', $joiner_main[0]);  ###########
                        $group_id = $allMsg[$i]['group_id'];      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $group_url = site_url() . get_page_address('single_group') . '&id=' . $group_id . '&tab=manage';
                        $group_ava = get_group($group_id)[0]['group_cover']; //相关群组的头像
                        $person_url = site_url() . get_page_address('otherpersonal') . '&id=' . $joiner;
                        $time = $allMsg[$i]['modified_time'];  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?= $group_ava ?>" id="ava-img">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a onclick="set_as_read('<?=$person_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                   style="color: #169bd5;cursor: pointer"><?= $joiner_name ?></a>
                                <?
                                if ($joiner_num>1){?>
                                    <span>&nbsp;<span style="font-weight: bolder">等<?=$joiner_num?>人申请加入</span>您的群组</span>
                                <?php } else{?>
                                    <span>&nbsp;<span style="font-weight: bolder">申请加入</span>您的群组</span>
                                <?php } ?>
                                <span><a
                                        onclick="set_as_read('<?=$group_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                        style="color: #169bd5;cursor: pointer"><?= $group_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right;margin-right: 5px">
                                <div style="text-align: right">
                                    <?
                                    if (time() - strtotime($time) > 24 * 3600) {
                                        echo date('Y年n月j日', strtotime($time));
                                    } else {
                                        echo date('H:i:s', strtotime($time));
                                    }
                                    ?>
                                </div>
                                <div style="float: right;margin-top: 10px;margin-right: 8px">
                                    <img src="<?php bloginfo("template_url") ?>/img/group-icon.png" style="width: 16px;height: 16px">
                                </div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]['notice_type'] == 4) {
                        // XX发布在群XX中发布了任务XX  //无需更新
                        $group_id = $allMsg[$i]['group_id'];      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $group_ava = get_group($group_id)[0]['group_cover']; //相关群组的头像
                        $group_url = site_url() . get_page_address('single_group') . '&id=' . $group_id;//群组链接
                        $task_id = $allMsg[$i]['notice_content'];   //任务id
                        $task_info = get_task($group_id, $task_id)[0];
                        $task_name = $task_info['task_name'];    //任务名称
                        $task_author_id = $task_info['task_author'];  //任务发布者
                        $task_author_name = get_the_author_meta('user_login', $task_author_id);   //发布者name
                        $task_url = site_url() . get_page_address('single_task') . '&id=' . $task_id;
                        $time = $allMsg[$i]['modified_time'];  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?= $group_ava ?>" id="ava-img">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $task_author_id; ?>"
                                   style="color: #169bd5"><?= $task_author_name ?></a>
                                <span>在群</span>
                                <span><a onclick="set_as_read('<?=$group_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                        style="color: #169bd5;cursor: pointer"><?= $group_name ?></a></span>
                                <span>中&nbsp;<span style="font-weight: bolder">发布</span>了任务</span>
                                <span><a onclick="set_as_read('<?=$task_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                         style="color: #169bd5;cursor: pointer"><?= $task_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right;margin-right: 5px">
                                <div style="text-align: right">
                                    <?
                                    if (time() - strtotime($time) > 24 * 3600) {
                                        echo date('Y年n月j日', strtotime($time));
                                    } else {
                                        echo date('H:i:s', strtotime($time));
                                    }
                                    ?>
                                </div>
                                <div style="float: right;margin-top: 10px;margin-right: 8px">
                                    <img src="<?php bloginfo("template_url") ?>/img/task.png" style="width: 16px;height: 16px">
                                </div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]['notice_type'] == 5) {
                        //你在群XX的任务XX已被审核,请查看!  //更新合并已经完成
                        $group_id = $allMsg[$i]['group_id'];      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $group_ava = get_group($group_id)[0]['group_cover']; //相关群组的头像
                        $group_url = site_url() . get_page_address('single_group') . '&id=' . $group_id;//群组链接
                        $task_id = $allMsg[$i]['notice_content'];   //任务id
                        $task_info = get_task($group_id, $task_id)[0];
                        $task_name = $task_info['task_name'];    //任务名称
                        $task_url = site_url() . get_page_address('single_task') . '&id=' . $task_id;//任务链接
                        $time = $allMsg[$i]['modified_time'];  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?= $group_ava ?>" id="ava-img">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <span>你在群</span>
                                <span><a onclick="set_as_read('<?=$group_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                         style="color: #169bd5;cursor: pointer"><?= $group_name ?></a></span>
                                <span>提交的任务</span>
                                <span><a onclick="set_as_read('<?=$task_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                         style="color: #169bd5;cursor: pointer"><?= $task_name ?></a></span>
                                <span>已被<span style="font-weight: bolder">审核</span>,请查看!</span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right;margin-right: 5px">
                                <div style="text-align: right">
                                    <?
                                    if (time() - strtotime($time) > 24 * 3600) {
                                        echo date('Y年n月j日', strtotime($time));
                                    } else {
                                        echo date('H:i:s', strtotime($time));
                                    }
                                    ?>
                                </div>
                                <div style="float: right;margin-top: 10px;margin-right: 8px">
                                    <img src="<?php bloginfo("template_url") ?>/img/task.png" style="width: 16px;height: 16px">
                                </div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]['notice_type'] == 6) {
                        //管理员XX将你在群XX的权限变更为XX  //多条信息合并
                        $group_id = $allMsg[$i]['group_id'];      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $group_ava = get_group($group_id)[0]['group_cover']; //相关群组的头像
                        $group_url = site_url() . get_page_address('single_group') . '&id=' . $group_id;//群组链接
                        $admin = $allMsg[$i]['notice_content'];   //管理员XXid
                        $admin_name = get_the_author_meta('user_login', $admin);  //管理员XX名字
                        $person_url = site_url() . get_page_address('otherpersonal') . '&id=' . $admin;
                        $identity = get_member_identity($group_id, $allMsg[$i]['user_id']);
                        if ($identity == 'admin') {
                            $identity = "管理员";
                        } else {
                            $identity = "普通成员";
                        }
                        $time = $allMsg[$i]['modified_time'];  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?= $group_ava ?>" id="ava-img">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <span>管理员</span>
                                <a style="color: #169bd5;cursor: pointer"
                                   onclick="set_as_read('<?=$person_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')">
                                    <?= $admin_name ?>
                                </a>
                                <span>将你在群</span>
                                <span><a onclick="set_as_read('<?=$group_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                         style="color: #169bd5;cursor: pointer"><?= $group_name ?></a></span>
                                <span>的<span style="font-weight: bolder">权限变更</span>为&nbsp;<?= $identity ?></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right;margin-right: 5px">
                                <div style="text-align: right">
                                    <?
                                    if (time() - strtotime($time) > 24 * 3600) {
                                        echo date('Y年n月j日', strtotime($time));
                                    } else {
                                        echo date('H:i:s', strtotime($time));
                                    }
                                    ?>
                                </div>
                                <div class="glyphicon glyphicon-user"
                                     style="float: right;margin-top: 10px;color: darkgray"></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]['notice_type'] == 7) {
                        //管理员XX将你移出了群XX   //不需要消息合并
                        $group_id = $allMsg[$i]['group_id'];      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $group_ava = get_group($group_id)[0]['group_cover']; //相关群组的头像
                        $group_url = site_url() . get_page_address('single_group') . '&id=' . $group_id;//群组链接
                        $admin = $allMsg[$i]['notice_content'];   //管理员XXid
                        $admin_name = get_the_author_meta('user_login', $admin);  //管理员XX名字
                        $person_url = site_url() . get_page_address('otherpersonal') . '&id=' . $admin;
                        $time = $allMsg[$i]['modified_time'];  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?= $group_ava ?>" id="ava-img">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <span>管理员</span>
                                <a style="color: #169bd5;cursor: pointer"
                                   onclick="set_as_read('<?=$person_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')">
                                    <?= $admin_name ?>
                                </a>
                                <span>将你<span style="font-weight: bolder">移出了</span>群</span>
                                <span><a onclick="set_as_read('<?=$group_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                         style="color: #169bd5;cursor: pointer"><?= $group_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right;margin-right: 5px">
                                <div style="text-align: right">
                                    <?
                                    if (time() - strtotime($time) > 24 * 3600) {
                                        echo date('Y年n月j日', strtotime($time));
                                    } else {
                                        echo date('H:i:s', strtotime($time));
                                    }
                                    ?>
                                </div>
                                <div style="float: right;margin-top: 10px;margin-right: 8px">
                                    <img src="<?php bloginfo("template_url") ?>/img/group-icon.png" style="width: 16px;height: 16px">
                                </div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]['notice_type'] == 8) {
                        // XX修改了群XX的设置  //已完成多消息合并
                        $group_id = $allMsg[$i]['group_id'];      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $group_ava = get_group($group_id)[0]['group_cover']; //相关群组的头像
                        $group_url = site_url() . get_page_address('single_group') . '&id=' . $group_id;//群组链接
                        $admin = $allMsg[$i]['notice_content'];   //修改人的id
                        $admin_name = get_the_author_meta('user_login', $admin);
                        $person_url = site_url() . get_page_address('otherpersonal') . '&id=' . $admin;
                        $time = $allMsg[$i]['modified_time'];  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?= $group_ava ?>" id="ava-img">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a style="color: #169bd5;cursor: pointer"
                                   onclick="set_as_read('<?=$person_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')">
                                    <?= $admin_name ?>
                                </a>
                                <span><span style="font-weight: bolder">修改</span>了群</span>
                                <span><a onclick="set_as_read('<?=$group_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                         style="color: #169bd5;cursor: pointer"><?= $group_name ?></a></span>
                                <span>的设置</span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right;margin-right: 5px">
                                <div style="text-align: right">
                                    <?
                                    if (time() - strtotime($time) > 24 * 3600) {
                                        echo date('Y年n月j日', strtotime($time));
                                    } else {
                                        echo date('H:i:s', strtotime($time));
                                    }
                                    ?>
                                </div>
                                <div class="glyphicon glyphicon-refresh"
                                     style="float: right;margin-top: 10px;color: darkgray"></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]['notice_type'] == 9) {
                        // 你加入的群XX的任务XX信息被修改,请查看 //多次合并已做
                        $group_id = $allMsg[$i]['group_id'];      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $group_ava = get_group($group_id)[0]['group_cover']; //相关群组的头像
                        $group_url = site_url() . get_page_address('single_group') . '&id=' . $group_id;//群组链接
                        $task_id = $allMsg[$i]['notice_content'];   //任务id
                        $task_info = get_task($group_id, $task_id)[0];
                        $task_name = $task_info['task_name'];    //任务名称
                        $task_url = site_url() . get_page_address('single_task') . '&id=' . $task_id;//任务链接
                        $time = $allMsg[$i]['modified_time'];  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?= $group_ava ?>" id="ava-img">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <span>你加入的群</span>
                                <span><a onclick="set_as_read('<?=$group_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                         style="color: #169bd5;cursor: pointer"><?= $group_name ?></a></span>
                                <span>的任务</span>
                                <span><a onclick="set_as_read('<?=$task_url?>',<?= $group_id ?>,<?= $allMsg[$i]['notice_type'] ?>,'<?= $allMsg[$i]['notice_content']?>')"
                                         style="color: #169bd5;cursor: pointer"><?= $task_name ?></a></span>
                                <span>信息已被<span style="font-weight: bolder">更新</span>,请查看!</span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right;margin-right: 5px">
                                <div style="text-align: right">
                                    <?
                                    if (time() - strtotime($time) > 24 * 3600) {
                                        echo date('Y年n月j日', strtotime($time));
                                    } else {
                                        echo date('H:i:s', strtotime($time));
                                    }
                                    ?>
                                </div>
                                <div class="glyphicon glyphicon-refresh"
                                     style="float: right;margin-top: 10px;color: darkgray"></div>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <div class="divline"></div>
                </li>
            <?php }
        } else { ?>
            <div style="height: 1px;background-color: lightgray;"></div>
            <div class="alert alert-info" style="margin-top: 20px">Oops,还没有收到消息</div>
        <?php } ?>
    </ul>
    <?php if ($total_page > 1) { ?>
        <div id="page_favorite" style="text-align:center;margin-bottom: 20px">
            <!--翻页的超链接-->
            <a href="<?php echo add_query_arg(array('paged' => 1)) ?>">首页</a>
            <?php if ($current_page == 1) { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) ?>">下一页&nbsp;&raquo;</a>
            <?php } elseif ($current_page == $total_page) { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) ?>">&laquo;&nbsp;上一页</a>
            <?php } else { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) ?>">&laquo;&nbsp;上一页&nbsp;</a>
                <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) ?>">&nbsp;下一页&nbsp;&raquo;</a>
            <?php } ?>
            <a href="<?php echo add_query_arg(array('paged' => $total_page)) ?>">尾页</a>
            共<?= $total_page ?>页
        </div>
    <?php } ?>
</div>