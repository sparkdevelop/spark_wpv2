<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/6/28
 * Time: 下午2:03
 */
    //获取当前群组唯一标识符 id 进而获取所有group信息
    $group_id = isset($_GET['id']) ? $_GET['id'] : "";
    $group = get_group($group_id);

    //判断当前user是否是管理员  后续还有
    if(get_current_user_id() == $group[0]['group_author']){
        require "single_group_admin.php";
    }else{
        require "single_group_common.php";
    }
    //还有一种未加入的暂时没有模板