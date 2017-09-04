<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/6/28
 * Time: 下午2:03
 */
    //获取当前群组唯一标识符 id 进而获取所有group信息
    $group_id = isset($_GET['id']) ? $_GET['id'] : "";
    $group = get_group($group_id)[0];    //group的相关信息

    //判断当前user是否是管理员
    if(is_group_admin($group_id)){
        require "single_group_admin.php";
    }elseif(is_group_member($group_id)){
        require "single_group_common.php";
    }else{
        require "single_group_unjoin.php";
    }
