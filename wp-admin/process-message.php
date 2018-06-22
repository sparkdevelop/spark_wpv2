<?php
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');

$from_id = get_current_user_id();
$to_id = isset($_POST["receiver_id"]) ? $_POST["receiver_id"] : '';
$content = isset($_POST["pmessage"]) ? $_POST["pmessage"] : '';
$modified_time = date("Y-m-d H:i:s", time() + 8 * 3600);
$flag = isset($_POST["flag"]) ? $_POST["flag"] : '';

if ($to_id !='' && $from_id != '' && $content != '' && $modified_time !=''){
    $sql = "INSERT INTO wp_pmessage VALUES ('',$from_id,$to_id,'$content',0,'$modified_time')";
    $wpdb->query($sql);
}
if ($flag !=''){
    $sql_update = "UPDATE wp_pmessage SET message_status = 1 WHERE ID = $flag";
    $wpdb->query($sql_update);
}

?>
<script>
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
    parent.layer.msg("发送成功", {time: 2000, icon: 1});
</script>