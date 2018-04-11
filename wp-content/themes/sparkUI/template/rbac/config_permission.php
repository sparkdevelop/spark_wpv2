<?php
$type = 'role';
$role_id = $_GET['id'];
$permission = get_rbac_rp_relation($type, $role_id);
$admin_url = admin_url('admin-ajax.php');
?>
<div id="rl-table">
    <table id="rl-table-border" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>权限名称</th>
            <th>权限ID</th>
            <th>权限说明</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i = 0; $i < sizeof($permission); $i++) {   //一个i是一行?>
            <tr id="tr_<?=$permission[$i]?>">
                <?php $info = get_rbac_info('permission', $permission[$i]); ?>
                <td><?=$info->permission_name?></td>
                <td><?=$info->ID?></td>
                <td><?=$info->illustration?></td>
                <td><button class="btn btn-link" onclick="disassociate('<?=$role_id?>','<?=$info->ID?>','<?=$admin_url?>')"><span class="glyphicon glyphicon-trash"></span></button></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script>

</script>