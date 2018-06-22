<?php
require_once(dirname(__FILE__) . '/admin.php');

$search_word = isset($_GET['sg'])&&!empty($_GET['sg'])&&!ctype_space($_GET['sg']) ? $_GET['sg'] : '';
if($search_word==''){
    wp_redirect(home_url());
}
$group_ids = get_search_group_ids($search_word);

$url= site_url().get_page_address('search_group').'&r='.$group_ids;
?>
<script>
    location='<?=$url?>';
</script>