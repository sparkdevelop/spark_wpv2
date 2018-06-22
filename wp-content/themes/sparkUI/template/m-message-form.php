<?php
//私信表单
$receiver = $_GET['ruser_id'];
$flag = isset($_GET['f']) ? $_GET['f'] : '';
?>

<div id="col9">
    <h4 class="ask_topic">
        发信给: <?=get_the_author_meta('user_login', $receiver);?>
    </h4>
    <form class="form-horizontal" role="form" name="profile" method="post" enctype="multipart/form-data"
          action="<?php echo esc_url(self_admin_url('process-message.php')); ?>">
        <div class="form-group" style="margin: 20px 0px">
            <div class="col-sm-12">
                <?php wp_editor('', 'pmessage', $settings = array(
                    'teeny' => true, 'textarea_rows' => 6)
                );
                ?>
            </div>
        </div>
        <!--        隐藏信息-->
        <div class="form-group">
            <input type="hidden" name="receiver_id" value="<?= $receiver ?>">
            <input type="hidden" name="flag" value="<?= $flag ?>">
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="submit" class="btn btn-default" name="save-btn" id="save-btn" value="提交">
            </div>
        </div>
    </form>
</div>