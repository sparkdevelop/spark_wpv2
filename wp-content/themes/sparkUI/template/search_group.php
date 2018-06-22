<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 2017/9/20
 * Time: 下午4:18
 */
$admin_url = admin_url('admin-ajax.php');
$group_ids = isset($_GET['r']) ? $_GET['r'] : "";
//拆分$group_id
if ($group_ids == '') {
    ?>
    <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
        <div class="alert alert-info">Oops, 没有搜索到群组,
            <a href="<?php echo site_url() . get_page_address('group') ?>"
               style="text-decoration:none;font-weight: bolder;color: #fe642d">
                返回</a>&nbsp;重新搜索
        </div>
    </div>
<?php } else {
    $group_ids = explode(",", $group_ids); ?>
    <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
        <ul class="list-group">
            <?php
            foreach ($group_ids as $value) {
                $group = get_group($value)[0];
                ?>

                <li class="list-group-item">
                    <div id="group-ava">
                        <img src="<?= $group['group_cover'] ?>" style="width: 85px;height: 85px">
                    </div>
                    <div id="group-info" style="margin-left: 20px">
                        <div class="group_title">
                            <?php
                            if ($group['group_status'] == "close") {
                                if (get_current_user_id() != $group['group_author']) { ?>
                                    <a class="group_name" href="#group-info"><h4><?= $group['group_name'] ?></h4></a>
                                <?php } else { ?>
                                    <a class="group_name"
                                       href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group['ID']; ?>">
                                        <h4><?= $group['group_name'] ?></h4>
                                    </a>
                                <?php } ?>
                            <?php } else { ?>
                                <a class="group_name"
                                   href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $group['ID']; ?>">
                                    <h4><?= $group['group_name'] ?></h4>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="group_abs">
                            <?php echo $group['group_abstract']; ?>
                        </div>
                        <div class="group_others">
                            <?php
                            if (is_group_member($group['ID'])) {
                                echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">已加入</span>&nbsp;&nbsp;';
                            } elseif ($group['group_status'] == "close") {
                                echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">已关闭</span>&nbsp;&nbsp;';
                            } else {
                                $verify_type = get_verify_type($group['ID']);
                                $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $group['ID'];
                                if ($verify_type == 'verifyjoin') { ?>
                                    <button id="group_join_btn"
                                            onclick="verify_join_the_group('<?= $verify_url ?>')">加入
                                    </button>
                                <?php } else { ?>
                                    <button id="group_join_btn"
                                            onclick="join_the_group(<?= $group['ID'] ?>,'<?= $admin_url ?>')">
                                        加入
                                    </button>&nbsp;&nbsp;
                                <?php }
                            }
                            ?>
                            <span><?= $group['member_count'] ?>个成员</span>&nbsp;&nbsp;
                            <span>管理员</span>
                            <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $group['group_author']; ?>"
                               style="color: #169bd5"><?php echo get_the_author_meta('user_login',$group['group_author']) ?></a>
                        </div>
                    </div>
                    <div id="latest-active">
                        <div>最近活跃</div>
                        <?php
                        $latest_active = get_latest_active($group['ID']);
                        for ($j = 0; $j < sizeof($latest_active); $j++) {
                            ?>
                            <div style="display: inline-block;margin-top: 15px">
                                <div style="text-align: center;margin-right: 10px">
                                    <?php echo get_avatar($latest_active[$j], 36, ''); ?>
                                    <p style="width: 55px;word-wrap: break-word;margin-bottom: 0px">
                                        <?php $user_name = get_user_by('ID', $latest_active[$j])->display_name;
                                        echo mb_strimwidth($user_name, 0, 7, ".."); ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="divline"></div>
                </li>
            <?php }
            ?>
        </ul>
    </div>
<?php }

?>

