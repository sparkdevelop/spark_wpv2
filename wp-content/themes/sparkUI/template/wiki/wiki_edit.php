<?php
wp_enqueue_style('fep-style');
wp_enqueue_script('fep-script');
wp_enqueue_media();
//$entry_title = $_GET['entry_title'];
//$entry_content = $_GET['entry_content'];
$post_id = $_GET["post_id"];
$wiki_post = get_post($post_id);

?>
<style type="text/css">
    .wp-editor-container {
        border: solid 1px #f5f5f5;
    }
</style>
    <div id="fep-new-post">
        <div id="ffff">
            <label for="wiki_content_editor"><?php echo $wiki_post->post_title ?></label>
            <?php
            wp_editor($wiki_post->post_content, 'wiki_content_editor', $settings = array('textarea_name' => 'post_content', 'textarea_rows' => 15));
            ?>
        </div>
    </div>
<?php
$post->ID = $post_id;
$_SESSION['post_title'] = $wiki_post->post_title;
$_SESSION['post_name'] = $wiki_post->post_name;
?>