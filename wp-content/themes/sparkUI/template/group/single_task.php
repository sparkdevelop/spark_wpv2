<?php
//获取当前群组唯一标识符 id 进而获取所有group信息
$task_id = isset($_GET['id']) ? $_GET['id'] : "";
$admin_url=admin_url( 'admin-ajax.php' );
if($task_id != ""){
    $group_id = get_task_group($task_id);
    $task = get_task($group_id, $task_id);
    $task = $task[0];
    if ($task['task_type'] == 'tread') {
        require "single_task_read.php";
    } elseif ($task['task_type'] == 'tpro') {
        require "single_task_pro.php";
    } else {
        require "single_task_other.php";
    }
    //判断当前user是否是管理员  后续还有
}else{
    echo "非法跳转";
}
?>

