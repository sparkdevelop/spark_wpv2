<?php
wp_enqueue_style('fep-style');
wp_enqueue_script('fep-script');
wp_enqueue_media();

?>
<style type="text/css">
    
</style>

<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
<div id="fep-new-post">
    <div id="ffff">
        <input type="text" name="wiki_entry_title" class="wiki_entry_title" placeholder="输入词条标题">
        <?php
        wp_editor("", 'wiki_content_editor', $settings = array('textarea_name' => 'post_content', 'textarea_rows' => 150));
        ?>
    </div>
</div>
</div>