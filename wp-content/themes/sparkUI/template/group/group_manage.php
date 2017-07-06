<!--群组管理界面-->
<div>
    <div style="height: 1px;background-color: lightgray"></div>
    <ul id="groupManageTab" class="nav nav-tabs">
        <li class="active"><a href="#group_form" data-toggle="tab">群组设置</a></li>
        <li><a href="#member_verify" data-toggle="tab">成员审核</a></li>
        <li><a href="#member_management" data-toggle="tab">成员管理</a></li>
    </ul>
    <div id="groupManageTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="group_form">
            <?php require 'set_group.php';?>
        </div>
        <div class="tab-pane fade" id="member_verify">
            <?php require 'create_task.php';?>
        </div>
        <div class="tab-pane fade" id="member_management">
            <?php require 'index.php';?>
        </div>
    </div>

</div>