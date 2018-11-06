<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2018/10/25
 * Time: 11:24
 */
$id = $_REQUEST['id'];
$later_id= $_REQUEST['later'];
$earlier_id= $_REQUEST['earlier'];
$title =  get_the_title($id);
global $wpdb;
$later_sql = $wpdb->prepare("select * from $wpdb->posts where ID = %s", $later_id);
$later= $wpdb->get_results($later_sql);
$later_title =  $later[0]->post_title;
$later_content = $later[0]->post_content;

$earlier_sql = $wpdb->prepare("select * from $wpdb->posts where ID = %s", $earlier_id);
$earlier= $wpdb->get_results($earlier_sql);
$earlier_title =  $earlier[0]->post_title;
$earlier_content = $earlier[0]->post_content;

// Include the diff class
require_once dirname(__FILE__).'/../../algorithm/lib/Diff.php';

// Include two sample files for comparison
//$a = explode("</p>",$later_content);
//$b = explode("</p>", $earlier_content);
$a = preg_split('/(<[^>]*[^\/]>)/i', $earlier_content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
$b = preg_split('/(<[^>]*[^\/]>)/i', $later_content, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

// Options for generating the diff
$options = array(
    'ignoreWhitespace' => true,
    //'ignoreCase' => true,
);

// Initialize the diff class
$diff = new Diff($a, $b, $options);
?>
<h2>比较《<a href="<?php echo get_permalink($id);?>"><?php echo $title ;?></a>》的历史版本</h2>
<div class="col-md-6 col-sm-6 col-xs-6">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <td><b>更新时间</b></td>
                <td><b>作者</b></td>
                <td><b>版本</b></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $earlier[0]->post_date;?></td>
                <td><?php echo  get_the_author_meta('user_login',$earlier[0]->post_author);?></td>
                <td><a href="<?php echo site_url().get_page_address('wiki_revision').'&revision_id='.$earlier_id.'&wiki_id='.$id?>">查看</a></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="col-md-6 col-sm-6 col-xs-6">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <td><b>更新时间</b></td>
                <td><b>作者</b></td>
                <td><b>版本</b></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $later[0]->post_date;?></td>
                <td><?php echo  get_the_author_meta('user_login',$later[0]->post_author);?></td>
                <td><a href="<?php echo site_url().get_page_address('wiki_revision').'&revision_id='.$later_id.'&wiki_id='.$id?>">查看</a></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<?php

// Generate a side by side diff
require_once dirname(__FILE__).'/../../algorithm/lib/Diff/Renderer/Html/SideBySide.php';
$renderer = new Diff_Renderer_Html_SideBySide;
echo $diff->Render($renderer);

?>
