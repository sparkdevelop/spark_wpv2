<?php
$state = isset($_GET['state']) ? $_GET['state'] : 'suspending';
?>
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
} ?>