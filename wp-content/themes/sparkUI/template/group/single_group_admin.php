<style>
    #invitation_join_btn{
        border: 1px solid transparent;
        background-color: #1fbba6;
        color: #fff;
        border-radius: 5px;
    }
</style>
<?php
    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'task';
?>
<div class="col-md-9 col-sm-9 col-xs-12"  id="col9">
    <div id="single-group-title">
        <div id="group-ava">
            <?php get_group_ava($group['ID'],85)?>
        </div>
        <div id="group-info">
            <div class="group_title">
                <span id="h4_name"><?=$group['group_name']?></span>
                <span style="color: #fe642d;margin-left: 10px">已加入&nbsp;&nbsp;&nbsp;
                    <?php
                    $verify_type = get_verify_type($group['ID']);
                    $invitation_url = site_url() . get_page_address("invitation") . "&user_id=" . get_current_user_id() . "&group_id=" . $group['ID'];
                    if ($verify_type == "freejoin") {
                        ?>
                        <button id="invitation_join_btn"
                                onclick="invitation_the_group('<?=$invitation_url ?>')">邀请
                        </button>
                    <?php } ?>
                </span>
            </div>
            <div class="group_others">
                <span><?=$group['member_count']?>个成员</span>&nbsp;&nbsp;
                <span>创建者</span>
                <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$group['group_author'];?>" style="color: #169bd5"><?php echo get_the_author_meta('user_login',$group['group_author'])?></a>
            </div>
            <div class="group_create_time">
                <span>创建于:&nbsp;</span>
                <span><?=$group['create_date']?></span>
            </div>
        </div>
    </div>
    <div id="single-group-abstract">
        <p><span style="font-weight: bold">群组简介:</span><?=$group['group_abstract']?></p>
    </div>
    <div id="single-group-tab">
        <ul id="single-group-leftTab" class="nav nav-pills">
            <li class="<?php echo $tab == 'task' ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(add_query_arg(array('tab' => 'task'), remove_query_arg(array('paged')))); ?>">群组任务</a>
            </li>
            <li class="<?php echo $tab == 'member' ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(add_query_arg(array('tab' => 'member'), remove_query_arg(array('paged')))); ?>">成员列表</a>
            </li>
            <li class="<?php echo $tab == 'manage' ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(add_query_arg(array('tab' => 'manage'), remove_query_arg(array('paged')))); ?>">群组管理
                    <? if(hasGPNotice($group['ID'])){?>
                        <i id="red-point" style="right: 5px;top: 5px;"></i>
                    <? } ?>
                </a>
            </li>
            <li class="<?php echo $tab == 'analyze' ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(add_query_arg(array('tab' => 'analyze'), remove_query_arg(array('paged')))); ?>">统计信息</a>
            </li>
        </ul>
        <?php
        $tab = isset($_GET['tab']) && !empty($_GET['tab']) ? $_GET['tab'] : 'task';
        if($tab=='task'){
            require 'group_task.php';
        }elseif ($tab=='member'){
            require 'group_member.php';
        }elseif($tab=='manage'){
            require 'group_manage.php';
        }else{
            require get_stylesheet_directory().'/template/student_management/management.php';
            //require get_stylesheet_directory().'/template/student_management/alert.php';
        }
        ?>
    </div>
</div>