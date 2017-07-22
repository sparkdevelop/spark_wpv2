<style>
    #member_verify {
        margin: 0px 10px;
    }

    #all_verify {
        text-align: right;
        margin-top: 20px;
        margin-right: 10px;
    }

    #all_verify a {
        cursor: pointer;
    }

    #verify-ava {
        display: inline-block;
    }

    #verify-info {
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }

    .btn-green {
        float: none;
        margin-right: 15px;
        width: 80px;
        height: 30px;
        margin-top: 10px;
    }
</style>
<script>
    function verify_pass($group_id, $user_id, $admin_url) {
        var data = {
            action: 'verify_pass',
            group_id: $group_id,
            user_id: $user_id
        };
        $.ajax({
            type: "POST",
            url: $admin_url,
            data: data,
            dataType: "text",
            success: function () {
                layer.msg("审核通过", {time: 2000, icon: 1});
                $('#verify-display').css('display', 'none');
            },
            error: function () {
                alert("error");
            }
        });
    }
    function verify_ignore($group_id, $user_id, $admin_url) {
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
                $('#verify-display').css('display', 'none');
                layer.msg("审核已忽略", {time: 2000, icon: 1});
            },
            error: function () {
                alert("error");
            }
        });
    }
</script>
<?php
/* 群组管理Tab下的成员审核tab
 * 首先要获取该群组的审核方式,如果不需要审核
 * */
$group_id = $group['ID'];
$verify_type = get_verify_type($group_id);
$admin_url = admin_url('admin-ajax.php');

if ($verify_type == 'freejoin') {
    echo '<div class="alert alert-info" style="margin-top: 20px">本群组自由加入,没有成员需要审核</div>';
} elseif ($verify_type == 'verify') {
    $member_verify_info = get_member_verify_tmp($group_id);
    if (sizeof($member_verify_info) == 0) {
        echo '<div class="alert alert-info" style="margin-top: 20px">没有需要审核的成员</div>';
    } else { ?>
        <div id="all_verify">
            <a onclick="verify_pass(<?= $group_id ?>,'','<?= $admin_url ?>')">全部通过</a>
            <span>|</span>
            <a onclick="verify_ignore(<?= $group_id ?>,'','<?= $admin_url ?>')">全部忽略</a>
        </div>
        <div id="member_verify">
            <div style="display: block">
                <?php //获取所有需要审核的成员
                for ($k = 0; $k < sizeof($member_verify_info); $k++) { ?>
                    <div id="verify-display" style="display: block">
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
                            <div style="display: block">
                                <button class="btn-green"
                                        onclick="verify_pass(<?= $group_id ?>,<?= $member_verify_info[$k]['user_id'] ?>,'<?= $admin_url ?>')">
                                    通过
                                </button>
                                <button class="btn-green"
                                        onclick="verify_ignore(<?= $group_id ?>,<?= $member_verify_info[$k]['user_id'] ?>,'<?= $admin_url ?>')">
                                    忽略
                                </button>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    <?php } ?>
<?php } else {
    $member_verify_info = get_member_verify_tmp($group_id);
    if (sizeof($member_verify_info) == 0) {
        echo '<div class="alert alert-info" style="margin-top: 20px">没有需要审核的成员</div>';
    } else { ?>
        <div id="all_verify">
            <a onclick="verify_pass(<?= $group_id ?>,'','<?= $admin_url ?>')">全部通过</a>
            <span>|</span>
            <a onclick="verify_ignore(<?= $group_id ?>,'','<?= $admin_url ?>')">全部忽略</a>
        </div>
        <div id="member_verify">
            <div style="display: block">
                <?php //获取所有需要审核的成员
                for ($k = 0; $k < sizeof($member_verify_info); $k++) { ?>
                    <div id="verify-display" style="display: block">
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
                            <div style="display: block">
                                <button class="btn-green"
                                        onclick="verify_pass(<?= $group_id ?>,<?= $member_verify_info[$k]['user_id'] ?>,'<?= $admin_url ?>')">
                                    通过
                                </button>
                                <button class="btn-green"
                                        onclick="verify_ignore(<?= $group_id ?>,<?= $member_verify_info[$k]['user_id'] ?>,'<?= $admin_url ?>')">
                                    忽略
                                </button>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    <?php }
} ?>


