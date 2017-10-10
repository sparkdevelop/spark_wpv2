<!-- 本页面是群组的主页,按照我的收藏写翻页-->
<?php $admin_url = admin_url('admin-ajax.php');
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'all';
?>

<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <?php if ($tab == 'all') { ?>
        <ul id="leftTab" class="nav nav-pills" style="display: inline-block">
            <li class="active"><a href="<?php echo site_url() . get_page_address('group') . '&tab=all' ?>">所有群组</a></li>
            <li><a href="<?php echo site_url() . get_page_address('group') . '&tab=budao' ?>">布道师大赛</a></li>
        </ul>
        <div class="input-group col-sm-3" id="search-group">
            <form class="navbar-form" role="search" method="get"
                  action="<?php echo esc_url(self_admin_url('process-search-group.php')); ?>"
                  style="width: 120%;float: right;padding-left: 0px;padding-right: 0px;margin-top: -3px">
                <input type="text" class="form-control" id="search-content" placeholder="搜索群组名称,关键词用空格分开" name="sg"/>
                <button type="submit" class="btn btn-default btn-sm" id="search-btn">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>
        </div>
        <div class="input-group col-sm-3" id="m-search-group">
            <form class="navbar-form" role="search" method="get"
                  action="<?php echo esc_url(self_admin_url('process-search-group.php')); ?>"
                  style="float: right;padding-left: 0px;padding-right: 0px;margin-top: -3px">
                <input type="text" class="form-control" id="search-content" style="width: 85%" placeholder="搜索群组"
                       name="sg"/>
                <button type="submit" class="btn btn-default btn-sm" id="search-group-btn">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>
        </div>

        <div id="leftTabContent" class="tab-content" style="margin-top: 42px; border-top:1px solid lightgrey">

            <?php
            //获取布道师群组
            //global $budao_official;
            $official_group = get_group(get_group_id_by_name($budao_official))[0];
            $group_name = $official_group['group_name'];
            $member = $official_group['member_count'];
            $author = $official_group['group_author'];
            ?>
            <li class="list-group-item">
                <div id="group-ava">
                    <?php get_group_ava($official_group['ID'],85)?>
                </div>
                <div id="group-info">
                    <div class="group_title" style="margin-bottom: 0px">
                        <a class="group_name" style="color:#333;display: inline-block"
                           href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $official_group['ID']; ?>">
                            <h4><?= $group_name ?></h4>
                        </a>
                        <span style="color: #fe642d;">【置顶】</span>
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
                            <?php } elseif ($verify_type == 'verify') { ?>
                                    <button id="group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                            <?php } else { ?>
                                    <button id="group_join_btn" onclick="join_the_group('<?= $official_group['ID'] ?>','<?= $admin_url ?>')">加入</button>
                            <?php }
                        }
                        ?>
                        <span><?= $member ?>个成员</span>&nbsp;&nbsp;
                        <span>管理员</span>
                        <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $author; ?>"
                           style="color: #169bd5"><?php echo get_author_name($author) ?></a>
                    </div>
                </div>

                <div id="m-group-btn">
                    <?php
                    if (is_group_member($official_group['ID'])) {
                        echo '<span class="badge" id="m-my_group_badge" style="float: inherit;margin-top: 0px">已加入</span>';
                    } elseif ($official_group['group_status'] == "close") {
                        echo '<span class="badge" id="m-my_group_badge" style="float: inherit;margin-top: 0px">已关闭</span>';
                    } else {
                        $verify_type = get_verify_type($official_group['ID']);
                        $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $official_group['ID'];
                        if ($verify_type == 'verifyjoin') { ?>
                            <button id="m-group_join_btn"
                                    onclick="verify_join_the_group('<?= $verify_url ?>')">加入
                            </button>
                        <?php } elseif($verify_type == 'verify'){ ?>
                            <button id="m-group_join_btn"
                                    onclick="verify_join_the_group('<?= $verify_url ?>')">加入
                            </button>
                        <?php } else { ?>
                            <button id="m-group_join_btn"
                                    onclick="join_the_group(<?= $official_group['ID'] ?>,'<?= $admin_url ?>')">加入
                            </button>
                        <?php }
                    }
                    ?>
                </div>

                <?php
                $latest_active = get_latest_active($official_group['ID']); ?>
                <?php
                if (sizeof($latest_active) != 0) {
                    ?>
                    <div id="latest-active">
                        <div>最近活跃</div>
                        <?php
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
                        <?php }
                        ?>
                    </div>
                <?php } ?>
                <div class="divline"></div>
            </li>

            <div class="tab-pane fade in active" id="allgroups">
                <ul class="list-group">
                    <?php
                    $all_group = get_group();
                    foreach ($all_group as $key => $values) {
                        if ($values['group_name'] == $budao_official) {
                            array_splice($all_group, $key, 1);
                        }
                    }
                    //翻页
                    $total_group = sizeof($all_group);
                    $perpage = 10;
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
                                    <?php get_group_ava($all_group[$i]['ID'],85)?>
                                </div>
                                <div id="group-info">
                                    <div class="group_title">
                                        <?php
                                        if ($all_group[$i]['group_status'] == "close") {
                                            if (get_current_user_id() != $author) { ?>
                                                <a class="group_name" href="#group-info"><h4><?= $group_name ?></h4></a>
                                            <?php } else { ?>
                                                <a class="group_name"
                                                   href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $all_group[$i]['ID']; ?>">
                                                    <h4><?= $group_name ?></h4>
                                                </a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a class="group_name"
                                               href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $all_group[$i]['ID']; ?>">
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
                                            echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0;">已加入</span>&nbsp;&nbsp;';
                                        } elseif ($all_group[$i]['group_status'] == "close") {
                                            echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0;">已关闭</span>&nbsp;&nbsp;';
                                        } else {
                                            $verify_type = get_verify_type($all_group[$i]['ID']);
                                            $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $all_group[$i]['ID'];
                                            if ($verify_type == 'verifyjoin') { ?>
                                                <button id="group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                                            <?php } elseif ($verify_type == 'verify') { ?>
                                                <button id="group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                                            <?php } else { ?>
                                                <button id="group_join_btn" onclick="join_the_group(<?= $all_group[$i]['ID'] ?>,'<?= $admin_url ?>')">加入</button>&nbsp;&nbsp;
                                            <?php }
                                        }
                                        ?>

                                        <span><?= $member ?>个成员</span>&nbsp;&nbsp;
                                        <span>管理员</span>
                                        <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $author; ?>"
                                           style="color: #169bd5"><?php echo get_author_name($author) ?></a>

                                    </div>
                                    <div class="m-group_others">
                                        <span><?= $member ?>个成员</span>&nbsp;&nbsp;
                                        <span>管理员</span>
                                        <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $author; ?>"
                                           style="color: #169bd5"><?php echo get_author_name($author) ?></a>

                                    </div>
                                </div>

                                <div id="m-group-btn">
                                    <?php
                                    if (is_group_member($all_group[$i]['ID'])) {
                                        echo '<span class="badge" id="m-my_group_badge" style="float: inherit;margin-top: 0px">已加入</span>';
                                    } elseif ($all_group[$i]['group_status'] == "close") {
                                        echo '<span class="badge" id="m-my_group_badge" style="float: inherit;margin-top: 0px">已关闭</span>';
                                    } else {
                                        $verify_type = get_verify_type($all_group[$i]['ID']);
                                        $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $all_group[$i]['ID'];
                                        if ($verify_type == 'verifyjoin') { ?>
                                            <button id="m-group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                                        <?php } elseif($verify_type == 'verify'){?>
                                            <button id="m-group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                                        <?php } else { ?>
                                            <button id="m-group_join_btn" onclick="join_the_group(<?= $all_group[$i]['ID'] ?>,'<?= $admin_url ?>')">加入</button>
                                        <?php }
                                    }
                                    ?>
                                </div>

                                <?php
                                $latest_active = get_latest_active($all_group[$i]['ID']); ?>
                                <?php
                                if (sizeof($latest_active) != 0) {
                                    ?>
                                    <div id="latest-active">
                                        <div>最近活跃</div>
                                        <?php
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
                                        <?php }
                                        ?>
                                    </div>
                                <?php } ?>
                                <div class="divline"></div>
                            </li>
                        <?php }
                    } ?>
                </ul>
                <?php if ($total_page > 1) {
                    ?>
                    <div id="group-pagination" style="text-align:center;margin-bottom: 20px">
                        <!--翻页-->
                        <?php if ($current_page == 1) { ?>
                            <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) ?>">下一页&nbsp;&raquo;</a>
                        <?php } elseif ($current_page == $total_page) { ?>
                            <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) ?>">&laquo;&nbsp;上一页</a>
                        <?php } else { ?>
                            <a href="<?php echo add_query_arg(array('paged' => $current_page - 1)) ?>">&laquo;&nbsp;上一页&nbsp;</a>
                            <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) ?>">
                                &nbsp;下一页&nbsp;&raquo;</a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="side-tool" id="m-side-tool-project">
                    <ul>
                        <li><a href="<?php echo site_url() . get_page_address("creategroup"); ?>"
                               style="color: white"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    <?php }
    else { ?>
        <ul id="leftTab" class="nav nav-pills">
            <li><a href="<?php echo site_url() . get_page_address('group') . '&tab=all' ?>">所有群组</a></li>
            <li class="active"><a href="<?php echo site_url() . get_page_address('group') . '&tab=budao' ?>">布道师大赛</a>
            </li>
        </ul>
        <div class="input-group col-sm-3" id="search-group">
            <form class="navbar-form" role="search" method="get"
                  action="<?php echo esc_url(self_admin_url('process-search-group.php')); ?>"
                  style="width: 120%;float: right;padding-left: 0px;padding-right: 0px;margin-top: -3px">
                <input type="text" class="form-control" id="search-content" placeholder="搜索群组名称,关键词用空格分开" name="sg"/>
                <button type="submit" class="btn btn-default btn-sm" id="search-btn">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>
        </div>
        <div class="input-group col-sm-3" id="m-search-group">
            <form class="navbar-form" role="search" method="get"
                  action="<?php echo esc_url(self_admin_url('process-search-group.php')); ?>"
                  style="float: right;padding-left: 0px;padding-right: 0px;margin-top: -3px">
                <input type="text" class="form-control" id="search-content" style="width: 85%" placeholder="搜索群组"
                       name="sg"/>
                <button type="submit" class="btn btn-default btn-sm" id="search-group-btn">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </form>
        </div>

        <div id="leftTabContent" class="tab-content" style="margin-top: 42px; border-top:1px solid lightgrey">
            <div class="alert alert-success" style="margin-top: 20px;margin-bottom:10px">了解大赛详情, 请移步
                <a href="<?php echo site_url() . get_page_address('budao_index') ?>"
                   style="text-decoration:none;font-weight: bolder;color: #fe642d;">
                    大赛说明</a>
            </div>
            <?php
            //获取布道师群组
            $official_group = get_group(get_group_id_by_name($budao_official))[0];
            $group_name = $official_group['group_name'];
            $member = $official_group['member_count'];
            $author = $official_group['group_author'];
            ?>
            <li class="list-group-item">
                <div id="group-ava">
                    <?php get_group_ava($official_group['ID'],85)?>
                </div>
                <div id="group-info">
                    <div class="group_title" style="margin-bottom: 0;display: inline-block">
                        <a class="group_name" style="color:#333;display: inline-block"
                           href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $official_group['ID']; ?>">
                            <h4><?= $group_name ?></h4>
                        </a>
                        <span style="color: #fe642d;">【置顶】</span>
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
                            <?php } elseif ($verify_type == 'verify') { ?>
                                <button id="group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                            <?php } else { ?>
                                <button id="group_join_btn" onclick="join_the_group(<?= $official_group['ID'] ?>,'<?= $admin_url ?>')">加入</button>&nbsp;&nbsp;
                            <?php }
                        }
                        ?>
                        <span><?= $member ?>个成员</span>&nbsp;&nbsp;
                        <span>管理员</span>
                        <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $author; ?>"
                           style="color: #169bd5"><?php echo get_author_name($author) ?></a>
                    </div>
                    <div class="m-group_others">
                        <span><?= $member ?>个成员</span>&nbsp;&nbsp;
                        <span>管理员</span>
                        <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $author; ?>"
                           style="color: #169bd5"><?php echo get_author_name($author) ?></a>
                    </div>
                </div>

                <div id="m-group-btn">
                    <?php
                    if (is_group_member($official_group['ID'])) {
                        echo '<span class="badge" id="m-my_group_badge" style="float: inherit;margin-top: 0px">已加入</span>';
                    } elseif ($official_group['group_status'] == "close") {
                        echo '<span class="badge" id="m-my_group_badge" style="float: inherit;margin-top: 0px">已关闭</span>';
                    } else {
                        $verify_type = get_verify_type($official_group['ID']);
                        $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $official_group['ID'];
                        if ($verify_type == 'verifyjoin') { ?>
                            <button id="m-group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                        <?php } elseif ($verify_type == 'verify'){?>
                            <button id="m-group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                        <?php } else { ?>
                            <button id="m-group_join_btn" onclick="join_the_group(<?= $official_group['ID'] ?>,'<?= $admin_url ?>')">加入</button>
                        <?php }
                    }
                    ?>
                </div>

                <?php
                $latest_active = get_latest_active($official_group['ID']); ?>
                <?php
                if (sizeof($latest_active) != 0) {
                    ?>
                    <div id="latest-active">
                        <div>最近活跃</div>
                        <?php
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
                        <?php }
                        ?>
                    </div>
                <?php } ?>
                <div class="divline"></div>
            </li>

            <div class="tab-pane fade in active" id="budao">
                <ul class="list-group">
                    <?php
                    $all_budao_group = get_budao_group();
                    //翻页
                    $total_group = sizeof($all_budao_group);
                    $perpage = 10;
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
                            $group_name = $all_budao_group[$i]['group_name'];
                            $member = $all_budao_group[$i]['member_count'];
                            $author = $all_budao_group[$i]['group_author'];
                            ?>
                            <li class="list-group-item">
                                <div id="group-ava">
                                    <?php get_group_ava($all_budao_group[$i]['ID'],85)?>
                                </div>
                                <div id="group-info">
                                    <div class="group_title">
                                        <?php
                                        if ($all_budao_group[$i]['group_status'] == "close") {
                                            if (get_current_user_id() != $author) { ?>
                                                <a class="group_name" href="#group-info"><h4><?= $group_name ?></h4></a>
                                            <?php } else { ?>
                                                <a class="group_name"
                                                   href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $all_budao_group[$i]['ID']; ?>">
                                                    <h4><?= $group_name ?></h4>
                                                </a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a class="group_name"
                                               href="<?php echo site_url() . get_page_address('single_group') . '&id=' . $all_budao_group[$i]['ID']; ?>">
                                                <h4><?= $group_name ?></h4>
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <div class="group_abs">
                                        <?php echo $all_budao_group[$i]['group_abstract']; ?>
                                    </div>
                                    <div class="group_others">
                                        <?php
                                        if (is_group_member($all_budao_group[$i]['ID'])) {
                                            echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">已加入</span>&nbsp;&nbsp;';
                                        } elseif ($all_budao_group[$i]['group_status'] == "close") {
                                            echo '<span class="badge" id="my_group_badge" style="float: inherit;margin-top: 0px">已关闭</span>&nbsp;&nbsp;';
                                        } else {
                                            $verify_type = get_verify_type($all_budao_group[$i]['ID']);
                                            $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $all_group[$i]['ID'];
                                            if ($verify_type == 'verifyjoin') { ?>
                                                <button id="group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                                            <?php } elseif ($verify_type == 'verify'){?>
                                                <button id="group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                                            <?php }else { ?>
                                                <button id="group_join_btn" onclick="join_the_group(<?= $all_budao_group[$i]['ID'] ?>,'<?= $admin_url ?>')">加入</button>&nbsp;&nbsp;
                                            <?php }
                                        }
                                        ?>
                                        <span><?= $member ?>个成员</span>&nbsp;&nbsp;
                                        <span>管理员</span>
                                        <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $author; ?>"
                                           style="color: #169bd5"><?php echo get_author_name($author) ?></a>
                                        <div class="m-group_others">
                                            <span><?= $member ?>个成员</span>&nbsp;&nbsp;
                                            <span>管理员</span>
                                            <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $author; ?>"
                                               style="color: #169bd5"><?php echo get_author_name($author) ?></a>
                                        </div>
                                    </div>
                                </div>

                                <div id="m-group-btn">
                                    <?php
                                    if (is_group_member($all_budao_group[$i]['ID'])) {
                                        echo '<span class="badge" id="m-my_group_badge" style="float: inherit;margin-top: 0px">已加入</span>';
                                    } elseif ($all_budao_group[$i]['group_status'] == "close") {
                                        echo '<span class="badge" id="m-my_group_badge" style="float: inherit;margin-top: 0px">已关闭</span>';
                                    } else {
                                        $verify_type = get_verify_type($all_budao_group[$i]['ID']);
                                        $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $all_budao_group[$i]['ID'];
                                        if ($verify_type == 'verifyjoin') { ?>
                                            <button id="m-group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                                        <?php } elseif ($verify_type == 'verify'){ ?>
                                            <button id="m-group_join_btn" onclick="verify_join_the_group('<?= $verify_url ?>')">加入</button>
                                        <?php } else { ?>
                                            <button id="m-group_join_btn" onclick="join_the_group(<?= $all_budao_group[$i]['ID'] ?>,'<?= $admin_url ?>')">加入</button>
                                        <?php }
                                    }
                                    ?>
                                </div>

                                <?php
                                $latest_active = get_latest_active($all_group[$i]['ID']); ?>
                                <?php
                                if (sizeof($latest_active) != 0) {
                                    ?>
                                    <div id="latest-active">
                                        <div>最近活跃</div>
                                        <?php
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
                                        <?php }
                                        ?>
                                    </div>
                                <?php } ?>
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
                            <a href="<?php echo add_query_arg(array('paged' => $current_page + 1)) ?>">
                                &nbsp;下一页&nbsp;&raquo;</a>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="side-tool" id="m-side-tool-project">
                    <ul>
                        <li><a href="<?php echo site_url() . get_page_address("creategroup"); ?>"
                               style="color: white"><i
                                    class="fa fa-plus" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
