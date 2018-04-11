<?php
$type = 'permission';
$permission_id = $_GET['id'];
$role = get_rbac_rp_relation($type, $permission_id);
?>
<div id="pl-table">
    <table id="pl-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>角色名称</th>
            <th>角色ID</th>
            <th>角色说明</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < sizeof($role); $i++) {   //一个i是一行?>
            <tr id="tr_<?=$role[$i]?>">
                <?php $info = get_rbac_info('role', $role[$i]); ?>
                <td><?=$info->role_name?></td>
                <td><?=$info->ID?></td>
                <td><?=$info->illustration?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>