<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2018/4/17
 * Time: 9:44
 */
//获取最近登录时间喝当前时间差值
function login_time_compare($lastest_login_time){
    $current_time = date('Y-m-d H:i:s');
    if(strtotime($current_time)-strtotime($lastest_login_time<8*3600)){  //判断时间差是否小于8小时
        $res='1';                            //8小时内允许直接登录
    }else{
        $res='0';                              //否则拒绝登录
    }
    return $res;
}
$sno = $_REQUEST["sno"];
//$sno = json_decode($sno);
//$sno = '2017180026';
if(!empty($sno)){
    $user_id = sno_to_id($sno);
    $lastest_login_time = get_lastest_login($user_id);
    echo $lastest_login_time;
    $res["sno"] = login_time_compare($lastest_login_time);
    echo json_encode($res);
}else{
    $res["sno"] = '-1';
    echo json_encode($res);
}
