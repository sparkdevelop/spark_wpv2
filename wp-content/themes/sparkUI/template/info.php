<?php
/**
 *  本页面是footer部分的解释说明部分
 *  sidebar导航
 */
$tab = isset( $_GET['tab'] ) && !empty( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'about';
?>
<script>
    $(function () {
        $("#contact").removeClass("active");
        $("#<?=$tab?>").addClass("active");
    });
</script>
<style>
    #contact_index{
        text-align: center;
        height: -webkit-fill-available;
    }
    #contact_index >li {
        margin: 10px 0px;
        font-size: 20px;
    }

</style>
<div class="col-md-9 col-sm-9 col-xs-12"  id="col9" style="background-color: white">
    <?php
    if($tab=='contact'){?>
        <h4>联系方式</h4>
        <div class="divline"></div>
        <ul class="list-group" id="contact_index">
            <li class="list-group-item">邮箱: sparkdevelop@163.com</li>
            <li class="list-group-item">QQ: 1172710814</li>
        </ul>
    <?php }
    if($tab=='about'){?>
        <h4 style="text-align: center">关于我们</h4>
        <div class="divline"></div>
    <?php } ?>
</div>
