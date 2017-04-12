<?php
    $tab = isset( $_GET['tab'] ) && !empty( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'qa';
?>
<script>
    window.onload=function(){
        var li=document.getElementById("<?=$tab?>");
        var li_default= document.getElementById("qa");
        li_default.className = "";
        li.className="active";
    }
</script>
<style>
    /*.container{background-color: #fafafa}*/
</style>
<div class="col-md-9 col-sm-9 col-xs-9"  id="col9" style="background-color: white">
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
    if($tab=='profile'){
        require "profile.php";
    }
    ?>
</div>
