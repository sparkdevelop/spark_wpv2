<?php
$tab = isset( $_GET['tab'] ) && !empty( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'qa';
$user_id = $_GET['id'];
if($user_id==get_current_user_id()){?>
    <script>
        var url = "<?=site_url().get_page_address('personal')?>";
        location.replace(url);
    </script>
<?php } else{ ?>
    <script>
        $(function () {
            $("#qa").removeClass("active");
            $("#<?=$tab?>").addClass("active");
        });
    </script>
    <div class="col-md-9 col-sm-9 col-xs-12"  id="col9" style="background-color: white">
        <?php
        if($tab=='wiki'){
            require "otherwiki.php";
        }
        if($tab=='qa'){
            require "otherqa.php";
        }
        if($tab=='project'){
            require "otherproject.php";
        }
        if($tab=='favorite'){
            require "otherfavorite.php";
        }
        ?>
    </div>
<?php } ?>