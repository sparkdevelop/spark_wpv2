<?php
    $tab = isset( $_GET['tab'] ) && !empty( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'qa';
?>
<script>
    $(function () {
        $("#qa").removeClass("active");
        $("#<?=$tab?>").addClass("active");
    });
</script>
<div class="col-md-9 col-sm-9 col-xs-12"  id="col9" style="background-color: white">
    <?php
    if($tab=='notification'){
        require "mynotification.php";
    }
    if($tab=='wiki'){
        require "mywiki.php";
    }
    if($tab=='qa'){
        require "myqa.php";
    }
    if($tab=='project'){
        require "myproject.php";
    }
    if($tab=='favorite'){
        require "myfavorite.php";
    }
    if($tab=='profile'){
        require "profile.php";
    }
    if($tab=='knowledge'){
        require "myknowledge.php";
    }
    ?>
</div>
