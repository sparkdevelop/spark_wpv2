<?php
$state = isset($_GET['state']) ? $_GET['state'] : 'suspending';
?>
    <div>
        <div class="badge" id="my_group_badge"
             style="cursor:pointer;float: right;margin-right: 5px"
             onclick="update_user_post_table()">
            更新用户可获得资源
        </div>
    </div>
    <ul id="approveTab" class="nav nav-pills">
        <li class="<?php echo $state == 'suspending' ? 'active' : ''; ?>">
            <a href="<?php echo esc_url(add_query_arg(array('state' => 'suspending'), remove_query_arg(array('paged')))); ?>">待审批</a>
        </li>
        <li class="<?php echo $state == 'solved' ? 'active' : ''; ?>">
            <a href="<?php echo esc_url(add_query_arg(array('state' => 'solved'), remove_query_arg(array('paged')))); ?>">已审批</a>
        </li>
    </ul>
<?php
if ($state == 'suspending') {
    require 'approve-suspending.php';
} else {
    require 'approve-solved.php';
}
////计算一遍所有用户可看的资源
//init_user_post_table();
?>
<script>
    function update_user_post_table() {
        var data = {
            action: 'update_user_post_table_ajax' //用于返回该资源的信息(权限,角色)
        };
        $.ajax({
            type: 'post',
            url: '<?=admin_url('admin-ajax.php');?>',
            data: data,
            dataType: 'json',
            success: function () {
                layer.msg('更新成功',{time:2000,icon:1})
            }
        });
    }
</script>
