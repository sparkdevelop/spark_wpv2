<?php
global $wpdb;
require_once(dirname(__FILE__) . '/admin.php');

$uvs_name = isset($_POST["uvs_name"]) ? $_POST["uvs_name"] : '';
$uvs_short = isset($_POST["uvs_short"]) ? strtolower($_POST["uvs_short"]) : '';
$time = date('Y-m-d H:i:s', time() + 8 * 3600);
//查找学校主页
$post_title = "精简版端到端实验%".strtoupper($uvs_short);
$sql_search = "select ID from wp_posts WHERE post_title LIKE '$post_title' and post_status = 'publish'";
$post_id = $wpdb->get_results($sql_search)[0];
$post_id = $post_id->ID;

$sql_insert = "INSERT INTO wp_ms VALUES ('','$uvs_name','$uvs_short',$post_id,'','$time')";
if ($uvs_name!='' && $uvs_short!='' && $post_id !=''){
    $wpdb->query($sql_insert);
}
?>
<script>
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
</script>
