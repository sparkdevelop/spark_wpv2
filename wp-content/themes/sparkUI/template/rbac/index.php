<?php
$tab = isset( $_GET['tab'] ) && !empty( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'gup';
?>
<script>
    $(function () {
        $("#gup").removeClass("active");
        $("#<?=$tab?>").addClass("active");
    });
</script>
<div class="col-md-9 col-sm-9 col-xs-12"  id="col9" style="background-color: white">
    <?php
    if($tab=='gur'){    //授予用户角色
        require "grant-user-role.php";
    }
    if($tab=='grp'){   //授予角色权限
        require "grant-role-permission.php";
    }
    if($tab=='gup'){   //授予用户权限
        require "grant-user-permission.php";
    }
    if($tab=='rl'){    //角色列表
        require "role-list.php";
    }
    if($tab=='pl'){    //权限列表
        require "permission-list.php";
    }
    if($tab=='search'){   //search
        require "search.php";
    }
    ?>
</div>
