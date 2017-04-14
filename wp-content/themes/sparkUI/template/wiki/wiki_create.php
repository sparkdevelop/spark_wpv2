<?php
wp_enqueue_style('fep-style');
wp_enqueue_script('fep-script');
wp_enqueue_media();

?>
<style type="text/css">
    .wiki_entry_title {
        margin-bottom: 15px;
        width: 200px;
    }
    .wp-editor-container {
        border: solid 1px #f5f5f5;
    }
</style>

<div id="fep-new-post">
    <div id="ffff">
        <input type="text" name="wiki_entry_title" class="wiki_entry_title" placeholder="输入词条标题">
        <?php
        wp_editor("", 'wiki_content_editor', $settings = array('textarea_name' => 'post_content', 'textarea_rows' => 15));
        ?>
    </div>
</div>
