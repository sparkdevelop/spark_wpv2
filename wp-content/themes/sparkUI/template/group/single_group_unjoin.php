<?php
$admin_url = admin_url('admin-ajax.php');
$verify_type = get_verify_type($group['ID']);
$verify_url = site_url().get_page_address("verify_form")."&user_id=".get_current_user_id()."&group_id=".$group['ID'];
?>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <div id="single-group-title">
        <div id="group-ava">
            <?php get_group_ava($group['ID'],85)?>
        </div>
        <div id="single-group-info">
            <div class="group_title">
                <span id="h4_name"><?= $group['group_name'] ?></span>
                <?php
                if ($verify_type == 'verifyjoin') { ?>
                    <span style="color: #fe642d;margin-left: 20px">
                        <button id="group_join_btn" onclick="verify_join_the_group('<?=$verify_url?>')">加入</button>
                        <button id="m-group_join_btn" onclick="verify_join_the_group('<?=$verify_url?>')">加入</button>
                    </span>
                <?php } elseif ($verify_type == 'verify'){ ?>
                    <span style="color: #fe642d;margin-left: 20px">
                        <button id="group_join_btn" onclick="verify_join_the_group('<?=$verify_url?>')">加入</button>
                        <button id="m-group_join_btn" onclick="verify_join_the_group('<?=$verify_url?>')">加入</button>
                    </span>
                <?php } else { ?>
                    <span style="color: #fe642d;margin-left: 20px">
                        <button id="group_join_btn" onclick="join_the_group('<?=$group['ID'] ?>','<?= $admin_url ?>')">加入</button>
                        <button id="m-group_join_btn" onclick="join_the_group(<?=$group['ID'] ?>,'<?= $admin_url ?>')">加入</button>
                    </span>
                <?php } ?>
            </div>
            <div class="group_others">
                <span><?= $group['member_count'] ?>个成员</span>&nbsp;&nbsp;
                <span>创建者</span>
                <a href="<?php echo site_url() . get_page_address('otherpersonal') . '&id=' . $group['group_author']; ?>"
                   style="color: #169bd5"><?php echo get_the_author_meta('user_login',$group['group_author']) ?></a>
            </div>
            <div class="m-group_others">
                <span><?=$group['member_count']?>个成员</span>&nbsp;&nbsp;
                <span>创建者</span>
                <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$group['group_author'];?>" style="color: #169bd5"><?php echo get_the_author_meta('user_login',$group['group_author'])?></a>
            </div>
            <div class="group_create_time">
                <span>创建于:&nbsp;</span>
                <span><?= $group['create_date'] ?></span>
            </div>
        </div>
    </div>
    <div id="single-group-abstract">
        <p><span style="font-weight: bold">群组简介:</span><?= $group['group_abstract'] ?></p>
    </div>
    <div id="single-group-tab">
        <ul id="single-group-leftTab" class="nav nav-pills">
            <?php
            $current_url = curPageURL();
            $url_array = parse_url($current_url);
            $query_parse = explode("&", $url_array['query']);
            if (array_search("tab=member", $query_parse)) {
                ?>
                <li><a href="<?php echo esc_url(add_query_arg(array('tab' => 'task', 'paged' => 1))) ?>">群组任务</a></li>
                <li class="active"><a
                        href="<?php echo esc_url(add_query_arg(array('tab' => 'member', 'paged' => 1))) ?>">成员列表</a>
                </li>
            <?php } else { ?>
                <li class="active"><a href="<?php echo esc_url(add_query_arg(array('tab' => 'task', 'paged' => 1))) ?>">群组任务</a>
                </li>
                <li><a href="<?php echo esc_url(add_query_arg(array('tab' => 'member', 'paged' => 1))) ?>">成员列表</a></li>
            <?php } ?>
        </ul>

        <?php
        $tab = isset($_GET['tab']) && !empty($_GET['tab']) ? $_GET['tab'] : 'task';
        if ($tab == 'task') {
            require 'group_task.php';
        } else {
            require 'group_member.php';
        }
        ?>
    </div>
</div>