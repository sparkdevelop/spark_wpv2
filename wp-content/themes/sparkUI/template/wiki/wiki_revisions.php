<?php
GLOBAL $wpdb;
$id = $_REQUEST['wiki_id'];

$sql = $wpdb->prepare("select * from $wpdb->posts where post_parent = %s", $id);
$revisions = $wpdb->get_results($sql);
$count = count($revisions);
$title =  get_the_title($id);
?>
<div class="table-responsive">
    <h2><a href="<?php echo get_permalink($id);?>"><?php echo $title ;?></a>的历史版本</h2>
    <table class="table">
        <thead>
        <tr>
            <td><b>标题</b></td>
            <td><b>作者</b></td>
            <td><b>修改日期</b></td>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i = 0; $i < $count; $i++) {
            ?>
            <tr>
                <td><?php echo $revisions[$i]->post_title ?></td>
                <td><?php echo get_the_author_meta('user_login',$revisions[$i]->post_author); ?></td>
                <td><a href="<?php echo site_url().get_page_address('wiki_revision').'&revision_id='.$revisions[$i]->ID.'&wiki_id='.$id?>"><?php echo $revisions[$i]->post_date ?></a></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
