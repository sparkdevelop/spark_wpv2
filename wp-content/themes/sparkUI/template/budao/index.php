<?php
/**
 * 布道大赛的主页
 */
$admin_url = admin_url('admin-ajax.php');
$official_group = get_group(get_group_id_by_name('布道师大赛'))[0];
?>
<style>
    .group_name {color: #333;}
    .group_name:hover{text-decoration: none;  color: #fe642d;}
</style>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <div id="group-ava">
        <img src="<?= $official_group['group_cover'] ?>" style="width: 85px;height: 85px"></div>
    <div id="group-info" style="margin-left: 20px">
        <div class="group_title">
            <?php
            if ($official_group['group_status'] == "close") {
                if (get_current_user_id() != $author) { ?>
                    <a class="group_name" href="#group-info"><h4><?= $official_group['group_name'] ?></h4></a>
                <?php } else { ?>
                    <a class="group_name"
                       href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $official_group['ID']; ?>">
                        <h4><?= $official_group['group_name'] ?></h4>
                    </a>
                <?php } ?>
            <?php } else { ?>
                <a class="group_name"
                   href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $official_group['ID']; ?>">
                    <h4><?= $official_group['group_name'] ?></h4>
                </a>
            <?php } ?>
        </div>
        <div class="group_abs">
            <?php echo $official_group['group_abstract']; ?>
        </div>
        <div class="group_others">
            <?php
            if (is_group_member($official_group['ID'])) {
                echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">已加入</span>&nbsp;&nbsp;';
            } elseif ($official_group['group_status'] == "close") {
                echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">已关闭</span>&nbsp;&nbsp;';
            } else {
                $verify_type = get_verify_type($official_group['ID']);
                $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $official_group['ID'];
                if ($verify_type == 'verifyjoin') { ?>
                    <button id="group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                <?php } else { ?>
                    <button id="group_join_btn"
                            onclick="join_the_group(<?= $official_group['ID'] ?>,'<?= $admin_url ?>')">加入
                    </button>&nbsp;&nbsp;
                <?php }
            }
            ?>
            <span><?= $official_group['member_count'] ?>个成员</span>&nbsp;&nbsp;
            <span>管理员</span>
            <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $author; ?>"
               style="color: #169bd5"><?php echo get_author_name($author) ?></a>
        </div>
    </div>
    <div class="divline"></div>
    <h4 style="text-align: center">布道师大赛细则!</h4>

</div>

