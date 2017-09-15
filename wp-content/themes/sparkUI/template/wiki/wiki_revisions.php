<?php
GLOBAL $wpdb;
$id = $_REQUEST['wiki_id'];
echo $name;
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
        <!--<td>Content</td>-->
    </tr>
    <?php
    for ($i = 0; $i < $count; $i++) {
        ?>
        <tr>
            <td><?php echo $revisions[$i]->ID ?></td>
            <td><?php echo get_the_author($revisions[$i]->post_author); ?></td>
            <td><?php echo $revisions[$i]->post_title ?></td>
            <td><a href="<?php echo site_url().get_page_address('wiki_revision').'&revision_id='.$revisions[$i]->ID.'&wiki_id='.$id?>"><?php echo $revisions[$i]->post_date ?></a></td>
            <td><?php// echo $revisions[$i]->post_content ?></td>
        </tr>
        <?php
    }
    ?>
</table>
