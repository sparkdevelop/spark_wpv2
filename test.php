<?php
    if(!$_GET['paged']){
        $page = 0;
        echo $page;
    }
    else{
    $page=$_GET['paged'];
        echo $page;
    }
?>
<?php
if($page==0){
    ?>
    <button class="btn btn-default" onclick="turn_next_page(<?=$page?>)">Next</button>
    <?php
}elseif($page==$hardware_last_page){ ?>
    <button class="btn btn-default" onclick="turn_last_page(<?=$page?>)">Before</button>
<?php }else { ?>
    <button class="btn btn-default" onclick="turn_last_page(<?=$page?>)">Before</button>
    <button class="btn btn-default" onclick="turn_next_page(<?=$page?>)">Next</button>
<?php }
?>
