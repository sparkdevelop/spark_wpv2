<style>

</style>
<?php
/* 群组管理Tab下的成员审核tab
 * 首先要获取该群组的审核方式,如果不需要审核
 * */
$group_id = $group['ID'];
$verify_type = get_verify_type($group_id);
$admin_url = admin_url('admin-ajax.php');

if ($verify_type == 'freejoin') {
    echo '<div class="alert alert-info" style="margin-top: 20px">本群组自由加入,没有成员需要审核</div>';
}
elseif ($verify_type == 'verify') {
    $member_verify_info = get_member_verify_tmp($group_id);
    if (sizeof($member_verify_info) == 0) {
        echo '<div class="alert alert-info" style="margin-top: 20px">没有需要审核的成员</div>';
    } else { ?>
        <div id="all_verify">
            <a onclick="verify_pass(<?= $group_id ?>,'','','<?= $admin_url ?>')">全部通过</a>
            <span>|</span>
            <a onclick="verify_ignore(<?= $group_id ?>,'','','<?= $admin_url ?>')">全部忽略</a>
        </div>
        <div id="member_verify">
            <div style="display: block">
                <?php //获取所有需要审核的成员
                for ($k = 0; $k < sizeof($member_verify_info); $k++) { ?>
                    <div id="verify-display_<?=$k?>" style="display: block">
                        <hr style="height:1px;border:none;border-top:1px dashed lightgrey;"/>
                        <div id="verify-ava">
                            <?php echo get_avatar($member_verify_info[$k]['user_id'], 48, '') ?>
                        </div>
                        <div id="verify-info">
                            <div>
                                <span><?php echo get_user_by('ID', $member_verify_info[$k]['user_id'])->display_name ?></span>
                                &nbsp; &nbsp; &nbsp;
                                <span>(<?= $member_verify_info[$k]['apply_time'] ?>)</span>
                            </div>
                            <div id="verify-field">
                                <p>验证信息 : <?= $member_verify_info[$k]['verify_info']?></p>
                            </div>
                            <div style="display: block">
                                <button class="btn-green"
                                        onclick="verify_pass(<?= $group_id ?>,<?=$k?>,<?= $member_verify_info[$k]['user_id'] ?>,'<?= $admin_url ?>')">
                                    通过
                                </button>
                                <button class="btn-green"
                                        onclick="verify_ignore(<?= $group_id ?>,<?=$k?>,<?= $member_verify_info[$k]['user_id'] ?>,'<?= $admin_url ?>')">
                                    忽略
                                </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php }
}
else {
    $member_verify_info = get_member_verify_tmp($group_id);     //获取需要审核的成员信息
    if (sizeof($member_verify_info) == 0) {                     //如果没有需要审核的成员
        echo '<div class="alert alert-info" style="margin-top: 20px">没有需要审核的成员</div>';
    } else {        //显示审核信息  ?>
        <div id="all_verify">
            <a onclick="verify_pass(<?= $group_id ?>,'','','<?= $admin_url ?>')">全部通过</a>
            <span>|</span>
            <a onclick="verify_ignore(<?= $group_id ?>,'','','<?= $admin_url ?>')">全部忽略</a>
        </div>
        <div id="member_verify">
            <div style="display: block">
                <?php
                for ($k = 0; $k < sizeof($member_verify_info); $k++) {
                    $verify_field_tmp = $member_verify_info[$k]['verify_info'];     //成员填写的审核信息
                    $verify_arr = explode(',', $verify_field_tmp);             //拆分成为数组
                    $display_id = "verify-display_".$k;
                    ?>
                    <div id='<?=$display_id?>' style="display: block">
                        <hr style="height:1px;border:none;border-top:1px dashed lightgrey;"/>
                        <div id="verify-ava">
                            <?php echo get_avatar($member_verify_info[$k]['user_id'], 48, '') ?>
                        </div>
                        <div id="verify-info">
                            <div>
                                <span><?php echo get_user_by('ID', $member_verify_info[$k]['user_id'])->user_login ?></span>
                                &nbsp; &nbsp; &nbsp;
                                <span>(<?= $member_verify_info[$k]['apply_time'] ?>)</span>
                            </div>
                            <div id="verify-field">
                                <?php $verify_field = get_verify_field($group_id,'group');
                                    for($z=0;$z<sizeof($verify_field);$z++){ ?>
                                        <p><?=$verify_field[$z]?> : <?=$verify_arr[$z]?></p>
                                    <?php } ?>
                            </div>
                            <div style="display: block">
                                <button class="btn-green" onclick="verify_pass(<?= $group_id ?>,'<?=$k?>',<?= $member_verify_info[$k]['user_id'] ?>,'<?= $admin_url ?>')">通过</button>
                                <button class="btn-green" onclick="verify_ignore(<?= $group_id ?>,'<?=$k?>',<?= $member_verify_info[$k]['user_id'] ?>,'<?= $admin_url ?>')">忽略</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php }
} ?>
<script>
    function verify_pass($group_id, $did, $user_id, $admin_url) {
        var data = {
            action: 'verify_pass',
            group_id: $group_id,
            user_id: $user_id,
            budao_official:'<?=$budao_official;?>'
        };
        $.ajax({
            type: "POST",
            url: $admin_url,
            data: data,
            dataType: "text",
            success: function () {
                if($did!=''){
                    var tmp_id = '#verify-display_'+$did.toString();
                    $(tmp_id).css('display', 'none');
                }else{
                    var info_size = <?=sizeof($member_verify_info)?>;
                    for(var k=0;k<info_size;k++){
                        var all_id = '#verify-display_'+k.toString();
                        $(all_id).css('display', 'none');
                    }
                }
                layer.msg("审核通过", {time: 2000, icon: 1});
            },
            error: function () {
                alert("error");
            }
        });
    }
    function verify_ignore($group_id, $did, $user_id, $admin_url) {
        var data = {
            action: 'verify_ignore',
            group_id: $group_id,
            user_id: $user_id
        };
        $.ajax({
            type: "POST",
            url: $admin_url,
            data: data,
            dataType: "text",
            success: function () {
                if($did!=''){
                    var tmp_id = '#verify-display_'+$did.toString();
                    $(tmp_id).css('display', 'none');
                }else{
                    for(var k=0;k<<?=sizeof($member_verify_info)?>;k++){
                        var all_id = '#verify-display_'+k.toString();
                        $(all_id).css('display', 'none');
                    }
                }
                layer.msg("审核已忽略", {time: 2000, icon: 1});
            },
            error: function () {
                alert("error");
            }
        });
    }
</script>

