<!-- 本页面是群组的主页,按照我的收藏写翻页-->
<?php $admin_url=admin_url( 'admin-ajax.php' );?>
<style></style>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <h4 class="index_title" style="margin-left: 20px">所有群组</h4>
    <div class="divline"></div>
    <ul class="list-group">
        <?php
        $all_group = get_group();
        //翻页
        $total_group = sizeof($all_group);
        $perpage = 5;
        $total_page = ceil($total_group / $perpage); //计算总页数
        if (!$_GET['paged']) {
            $current_page = 1;
        } else {
            $page_num = $_GET['paged'];
            $current_page = $page_num;
        }
        if ($total_group != 0) {
            $temp = $total_group < $perpage * $current_page ? $total_group : $perpage * $current_page;

            for ($i = $perpage * ($current_page - 1); $i < $temp; $i++) {
                $group_name = $all_group[$i]['group_name'];
                $member = $all_group[$i]['member_count'];
                $author = $all_group[$i]['group_author'];
                ?>
                <li class="list-group-item">
                    <div id="group-ava">
                        <img src="<?= $all_group[$i]['group_cover'] ?>" style="width: 85px;height: 85px">
                    </div>
                    <div id="group-info" style="margin-left: 20px">
                        <div class="group_title">
                            <?php
                            if ($all_group[$i]['group_status'] == "close") {
                                if (get_current_user_id() != $author) {?>
                                    <a class="group_name" href="#group-info"><h4><?=$group_name?></h4></a>
                                <?php } else { ?>
                                    <a class="group_name" href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $all_group[$i]['ID']; ?>">
                                        <h4><?= $group_name ?></h4>
                                    </a>
                                <?php } ?>
                            <?php } else { ?>
                                <a class="group_name" href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $all_group[$i]['ID']; ?>">
                                    <h4><?= $group_name ?></h4>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="group_abs">
                            <?php echo $all_group[$i]['group_abstract']; ?>
                        </div>
                        <div class="group_others">
                            <?php
                            if (is_group_member($all_group[$i]['ID'])) {
                                echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">已加入</span>&nbsp;&nbsp;';
                            } elseif ($all_group[$i]['group_status'] == "close") {
                                echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">已关闭</span>&nbsp;&nbsp;';
                            } else {
                                $verify_type = get_verify_type($all_group[$i]['ID']);
                                $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $all_group[$i]['ID'];
                                if ($verify_type == 'verifyjoin') { ?>
                                    <button id="group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                                <?php } else { ?>
                                    <button id="group_join_btn" onclick="join_the_group(<?= $all_group[$i]['ID'] ?>,'<?= $admin_url ?>')">+加入</button>&nbsp;&nbsp;
                                <?php }
                            }
                            ?>
                            <span><?= $member ?>个成员</span>&nbsp;&nbsp;
                            <span>管理员</span>
                            <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $author; ?>"
                               style="color: #169bd5"><?php echo get_author_name($author) ?></a>
                        </div>
                    </div>
                    <div id="latest-active">
                        <div>最近活跃</div>
                        <?php
                        $latest_active = get_latest_active($all_group[$i]['ID']);
                        for ($j = 0; $j < sizeof($latest_active); $j++) {
                            ?>
                            <div style="display: inline-block;margin-top: 15px">
                                <div style="text-align: center;margin-right: 10px">
                                    <?php echo get_avatar($latest_active[$j], 36, ''); ?>
                                    <p style="width: 48px;word-wrap: break-word;margin-bottom: 0px">
                                        <?php $user_name = get_user_by('ID',$latest_active[$j])->display_name;
                                        echo mb_strimwidth($user_name, 0, 7,".."); ?>
                                    </p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="divline"></div>
                </li>
            <?php }
        } ?>
    </ul>
    <?php
    if ($total_page > 1) {
        ?>
        <div id="group-pagination" style="text-align:center;margin-bottom: 20px">
            <!--翻页-->
            <?php if ($current_page == 1) { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) ?>">下一页&nbsp;&raquo;</a>
            <?php } elseif ($current_page == $total_page) { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) ?>">&laquo;&nbsp;上一页</a>
            <?php } else { ?>
                <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) ?>">&laquo;&nbsp;上一页&nbsp;</a>
                <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) ?>">&nbsp;下一页&nbsp;&raquo;</a>
            <?php } ?>
        </div>
    <?php } ?>
</div>
