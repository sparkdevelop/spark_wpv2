<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/6/28
 * Time: 下午2:46
 */
    //判断当前组的发布任务是只有管理员还是所有人都可以
    $group_id = isset($_GET['id']) ? $_GET['id'] : "";
    $group = get_group($group_id);
    if($group[0]['task_permission'] == 'all'){
        setcookie('group_id',$group_id);
        require "single_group_join_sidebar.php";
    }else{
        if(get_current_user_id() == $group[0]['group_author']){
            setcookie('group_id',$group_id);
            require "single_group_join_sidebar.php";
        }else{
            require "single_group_unjoin_sidebar.php";
        }
    }