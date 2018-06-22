<?php
/**
 * 为所有现有用户创建token
 */

global $wpdb;
include_once 'rongcloud.php';
$appKey = 'e0x9wycfe4h8q';
$appSecret= 'gBasm0OQHKa';
$sql_user = "select ID,user_login from wp_users ORDER BY ID";
$result_user = $wpdb->get_results($sql_user);
$avatar_url =  site_url()."/wp-content/themes/sparkUI/img/rongcloud-avatar.png";
$RongCloud = new RongCloud($appKey,$appSecret);
foreach($result_user as $value){
    getUserToken($value->ID,$value->user_login,$avatar_url);
}



//创建群组
$sql_group = "select ID,group_name from wp_gp ORDER BY ID ASC";   //选择所有的组
$result_group = $wpdb->get_results($sql_group);
foreach($result_group as $value){     //每个组进行创建
    $sql_user = "SELECT user_id FROM wp_gp_member WHERE group_id = $value->ID and member_status = 0";  //获得每个组的用户
    $results = $wpdb->get_results($sql_user, 'ARRAY_A');
    $user_id = array_column($results,'user_id');    //将用户id做成集合
    foreach($user_id as $v){   //判断是否已经注册
        if(!hasToken($v)){
            $avatar_url =  site_url()."/wp-content/themes/sparkUI/img/rongcloud-avatar.png";
            $user_name = get_the_author_meta('user_login', $v);
            getUserToken($v,$user_name,$avatar_url);
        }
    }
    getGroupToken($user_id,$value->ID,$value->group_name);
}

//首次要同步
foreach($result_user as $value) {
    //选出一个用户所有的组
    $sql_ug = "select group_id from wp_gp_member WHERE user_id = $value->ID and member_status = 0";
    $result_ug = $wpdb->get_results($sql_ug,'ARRAY_A');
    $group_id = array_column($result_ug,'group_id');
    $groupInfo=[];
    foreach ($group_id as $g){
        $groupInfo[$g] = get_group($g)[0]['group_name'];
    }
    if (sizeof($groupInfo)!=0){
        $result = $RongCloud->group()->sync($value->ID, $groupInfo);
        $token_array = json_decode($result);
        if ($token_array->code !=200){
            echo "error:".$token_array->code;
        }else{
            echo "user:".$value->ID." 同步成功";
        }
    }
}
?>
