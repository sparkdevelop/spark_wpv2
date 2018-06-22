<?php
/**
 * 布道师主页侧边栏
 */
$official_group = get_group(get_group_id_by_name($budao_official))[0];
?>
<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <?php if (is_user_logged_in()) {
        $verify_url = site_url() . get_page_address("verify_form") . "&user_id=" . get_current_user_id() . "&group_id=" . $official_group['ID']; ?>
        <div class="sidebar_button">
            <a style="color: white" onclick="verify_create_group('<?= $verify_url ?>')">加入官方群</a>
        </div>
    <?php } else { ?>
        <div class="sidebar_button">
            <a href="<?php echo wp_login_url(get_permalink()); ?>" style="color: white">加入官方群</a>
        </div>
    <?php } ?>
</div>

<script>
    function verify_create_group($url) {
        layer.open({
            type: 2,
            title: "填写验证字段",
            content: $url,
            area: ['30%', '66%'],
            closeBtn: 1,
            shadeClose: true,
            shade: 0.5,
            end: function () {
            }
        })
    }
</script>