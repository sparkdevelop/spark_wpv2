<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/6/29
 * Time: 上午9:29
 */
//获取本群组所有的成员信息,一并返回admin和member
$member_list = get_group_member($group_id);
$admin_list = $member_list['admin'];
$common_list = $member_list['common'];
?>
<style>
    #member_list {
        margin: 30px 30px;
    }
    #ml_admin p, #ml_member p {
        color: #169BD5;
        font-weight: bold;
    }
    #ml_avatar{
        margin-bottom: 25px;
        margin-right: 30px;
    }
</style>
<div class="divline" style="margin-top: 0px"></div>
<div id="member_list">
    <div id="ml_admin">
        <p>管理员(<?=sizeof($admin_list)?>)</p>
        <?php for ($j = 0; $j < sizeof($admin_list); $j++) { ?>
            <div id="ml_avatar" style="display: inline-block;margin-top: 10px">
                <div style="text-align: center;width: 45px">
                    <?php echo get_avatar($admin_list[$j]['user_id'], 48, ''); ?>
                </div>
                <h5 style="text-align:center;word-wrap: break-word"><?php echo mb_strimwidth(get_user_by('ID',$admin_list[$j]['user_id'])->display_name, 0, 7,"..") ?></h5>
            </div>
        <?php } ?>
    </div>
    <div id="ml_member">
        <p>成员(<?=sizeof($common_list)?>)</p>
        <?php for ($j = 0; $j < sizeof($common_list); $j++) { ?>
            <div id="ml_avatar" style="display: inline-block;margin-top: 10px">
                <div style="text-align: center;width: 45px">
                    <?php echo get_avatar($common_list[$j]['user_id'], 48, ''); ?>
                </div>
                <h5 style="text-align:center;word-wrap: break-word">
                    <?php echo mb_strimwidth(get_user_by('ID',$common_list[$j]['user_id'])->display_name, 0, 7,"..") ?>
                </h5>
            </div>
        <?php } ?>
    </div>
</div>
