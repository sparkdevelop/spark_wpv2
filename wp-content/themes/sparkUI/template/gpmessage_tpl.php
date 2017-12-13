<?php

$allMsg = get_allMsg();
function get_allMsg()
{
    global $wpdb;
    $current_user_id = get_current_user_id();
    $sql = "SELECT * FROM wp_gp_notice WHERE user_id = $current_user_id ORDER BY modified_time DESC";
    $result = $wpdb->get_results($sql);
    return $result;
}

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
</style>

<div class="divline" style="margin-top: 0px"></div>
<div id="rightTabContent" class="tab-content">
    <ul class="list-group">
        <?php if (count($allMsg) > 0) {
            //显示一页的东西
            $min_temp = $pro_length < $perpage * $current_page ? $pro_length : $perpage * $current_page;
            for ($i = $perpage * ($current_page - 1); $i < $min_temp; $i++) {?>
                <li class="list-group-item">
                    <?php if ($allMsg[$i]->notice_type == 1) {  //自由加入群组有人加入群组
                        // XX加入了你的群组XX
                        $joiner = $allMsg[$i]->notice_content;   //加入人的id 是否需要转换
                        $joiner_name = get_the_author_meta('user_login',$joiner);  ###########
                        $group_id = $allMsg[$i]->group_id;      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $time = $allMsg[$i]->modified_time;  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $joiner; ?>"
                                   style="color: #169bd5"><?= $joiner_name ?></a>
                                <span>&nbsp;<span style="font-weight: bolder">加入</span>了您的群组</span>
                                <span><a
                                        href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group_id ?>"
                                        style="color:#169bd5"><?= $group_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">设为已读</div>
                                <div style="margin-top: 30px"><?= $time ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->notice_type == 2) {
                        // XX退出了你的群组XX
                        $joiner = $allMsg[$i]->notice_content;   //加入人的id 是否需要转换
                        $joiner_name = get_the_author_meta('user_login',$joiner);  ###########
                        $group_id = $allMsg[$i]->group_id;      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $time = $allMsg[$i]->modified_time;  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $joiner; ?>"
                                   style="color: #169bd5"><?= $joiner_name ?></a>
                                <span>&nbsp;<span style="font-weight: bolder">退出</span>了您的群组</span>
                                <span><a
                                        href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group_id ?>"
                                        style="color:#169bd5"><?= $group_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">设为已读</div>
                                <div style="margin-top: 30px"><?= $time ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->notice_type == 3) {
                        //XX申请加入你的群组XX
                        $joiner = $allMsg[$i]->notice_content;   //加入人的id 是否需要转换
                        $joiner_name = get_the_author_meta('user_login',$joiner);  ###########
                        $group_id = $allMsg[$i]->group_id;      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $time = $allMsg[$i]->modified_time;  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $joiner; ?>"
                                   style="color: #169bd5"><?= $joiner_name ?></a>
                                <span>&nbsp;<span style="font-weight: bolder">申请加入</span>您的群组</span>
                                <span><a
                                        href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group_id .'&tab=manage' ?>"
                                        style="color:#169bd5"><?= $group_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">设为已读</div>
                                <div style="margin-top: 30px"><?= $time ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->notice_type == 4) {
                        // XX发布在群XX中发布了任务XX
                        $group_id = $allMsg[$i]->group_id;      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $task_id =  $allMsg[$i]->notice_content;   //任务id
                        $task_info = get_task($group_id,$task_id)[0];
                        $task_name = $task_info['task_name'];    //任务名称
                        $task_author_id = $task_info['task_author'];  //任务发布者
                        $task_author_name = get_the_author_meta('user_login',$task_author_id);   //发布者name
                        $time = $allMsg[$i]->modified_time;  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $task_author_id; ?>"
                                   style="color: #169bd5"><?= $task_author_name ?></a>
                                <span>在群</span>
                                <span><a href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group_id ?>"
                                        style="color:#169bd5"><?= $group_name ?></a></span>
                                <span>中&nbsp;<span style="font-weight: bolder">发布</span>了任务</span>
                                <span><a href="<?php echo site_url() . get_page_address('single_task') . '&id=' . $task_id ?>"
                                        style="color:#169bd5"><?= $task_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">设为已读</div>
                                <div style="margin-top: 30px"><?= $time ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->notice_type == 5) {
                        //你在群XX的任务XX已被审核,请查看!
                        $group_id = $allMsg[$i]->group_id;      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $task_id =  $allMsg[$i]->notice_content;   //任务id
                        $task_info = get_task($group_id,$task_id)[0];
                        $task_name = $task_info['task_name'];    //任务名称
                        $time = $allMsg[$i]->modified_time;  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <span>你在群</span>
                                <span><a href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group_id ?>"
                                         style="color:#169bd5"><?= $group_name ?></a></span>
                                <span>提交的任务</span>
                                <span><a href="<?php echo site_url() . get_page_address('single_task') . '&id=' . $task_id ?>"
                                         style="color:#169bd5"><?= $task_name ?></a></span>
                                <span>已被<span style="font-weight: bolder">审核</span>,请查看!</span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">设为已读</div>
                                <div style="margin-top: 30px"><?= $time ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->notice_type == 6) {
                        //管理员XX将你在群XX的权限变更为XX
                        $group_id = $allMsg[$i]->group_id;      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $admin = $allMsg[$i]->notice_content;   //管理员XXid
                        $admin_name = get_the_author_meta('user_login',$admin);  //管理员XX名字
                        $identity =get_member_identity($group_id,$allMsg[$i]->user_id);
                        if($identity=='admin'){
                            $identity = "管理员";
                        }else{
                            $identity = "普通成员";
                        }
                        $time = $allMsg[$i]->modified_time;  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <span>管理员</span>
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $admin; ?>"
                                   style="color: #169bd5"><?= $admin_name ?></a>
                                <span>将你在群</span>
                                <span><a
                                        href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group_id ?>"
                                        style="color:#169bd5"><?= $group_name ?></a></span>
                                <span>的<span style="font-weight: bolder">权限变更</span>为&nbsp;<?=$identity?></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">设为已读</div>
                                <div style="margin-top: 30px"><?= $time ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->notice_type == 7) {
                        //管理员XX将你移出了群XX
                        $group_id = $allMsg[$i]->group_id;      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $admin = $allMsg[$i]->notice_content;   //管理员XXid
                        $admin_name = get_the_author_meta('user_login',$admin);  //管理员XX名字
                        $time = $allMsg[$i]->modified_time;  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <span>管理员</span>
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $admin; ?>"
                                   style="color: #169bd5"><?= $admin_name ?></a>
                                <span>将你<span style="font-weight: bolder">移出了</span>群</span>
                                <span><a
                                        href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group_id ?>"
                                        style="color:#169bd5"><?= $group_name ?></a></span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">设为已读</div>
                                <div style="margin-top: 30px"><?= $time ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->notice_type == 8) {
                        // XX修改了群XX的设置
                        $group_id = $allMsg[$i]->group_id;      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $admin = $allMsg[$i]->notice_content;   //修改人的id
                        $admin_name = get_the_author_meta('user_login',$admin);
                        $time = $allMsg[$i]->modified_time;  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $admin; ?>"
                                   style="color: #169bd5"><?= $admin_name ?></a>
                                <span><span style="font-weight: bolder">修改</span>了群</span>
                                <span><a href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group_id ?>"
                                         style="color:#169bd5"><?= $group_name ?></a></span>
                                <span>的设置</span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">设为已读</div>
                                <div style="margin-top: 30px"><?= $time ?></div>
                            </div>
                        </div>
                    <?php }
                    else if ($allMsg[$i]->notice_type == 9) {
                        // 你加入的群XX的任务XX信息被修改,请查看
                        $group_id = $allMsg[$i]->group_id;      //相关群组的id
                        $group_name = get_group($group_id)[0]['group_name']; //相关群组的名称
                        $task_id =  $allMsg[$i]->notice_content;   //任务id
                        $task_info = get_task($group_id,$task_id)[0];
                        $task_name = $task_info['task_name'];    //任务名称
                        $time = $allMsg[$i]->modified_time;  //操作的时间
                        ?>
                        <div id="notice-ava">
                            <img src="<?php bloginfo("template_url") ?>/img/avatar.png">
                        </div>
                        <div id="notice-content" style="display: inline-block;width:92%;">
                            <div id="notice-info" style="display: inline-block;margin-left: 3%">
                                <span>你加入的群</span>
                                <span><a href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group_id ?>"
                                         style="color:#169bd5"><?= $group_name ?></a></span>
                                <span>的任务</span>
                                <span><a href="<?php echo site_url() . get_page_address('single_task') . '&id=' . $task_id ?>"
                                         style="color:#169bd5"><?= $task_name ?></a></span>
                                <span>信息已被<span style="font-weight: bolder">更新</span>,请查看!</span>
                            </div>
                            <div id="notice-time" style="display: inline-block;float: right">
                                <div class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">设为已读</div>
                                <div style="margin-top: 30px"><?= $time ?></div>
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