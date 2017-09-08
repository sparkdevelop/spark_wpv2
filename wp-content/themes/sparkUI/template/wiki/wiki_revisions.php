<?php
GLOBAL $wpdb;
$id = $_REQUEST['wiki_id'];
$sql = $wpdb->prepare("select * from $wpdb->posts where post_parent = %s", $id);
$revisions = $wpdb->get_results($sql);
$count = count($revisions);
?>
<table style="width:100%;">
    <tr>
        <td>ID</td>
        <td>Author</td>
        <td>Title</td>
        <td>Date</td>
    </tr>
    <?php
    for ($i = 0; $i < $count; $i++) {
        ?>
        <tr>
            <td><?php echo $revisions[$i]->ID ?></td>
            <td><?php echo $revisions[$i]->post_author ?></td>
            <td><?php echo $revisions[$i]->post_title ?></td>
            <td><?php echo $revisions[$i]->post_date ?></td>
        </tr>
        <?php
    }
    ?>
</table>
