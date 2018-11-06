<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2018/4/17
 * Time: 9:44
 */
$appid = $_REQUEST['appid'];
$check = 'wx20c87eea3546120a';
$res = get_student_goal();
if(strcmp($appid,$check)==0){
    $return = array('code'=>'1','msg'=>'获取成功','data'=>$res);
    echo json_encode($return);
}else{
    $err = array('code'=>'0','msg'=>'appid不正确','data'=>'');
    echo json_encode($err);
};
