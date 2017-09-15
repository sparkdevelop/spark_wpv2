<?php
/**
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/9/14
 * Time: 10:17
 */

$revision_id= $_REQUEST['revision_id'];
$sql = $wpdb->prepare("select * from $wpdb->posts where ID = %s", $revision_id);
$revision = $wpdb->get_results($sql);
$title =  $revision[0]->post_title;
$author_id =  $revision[0]->post_author;
$author = get_the_author_meta('user_login',$author_id);
$content = $revision[0]->post_content;
$wiki_id = $_REQUEST['wiki_id'];
$admin_url = admin_url('admin-ajax.php');
$origin_title =get_the_title($wiki_id);
?>

<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <h2><a href="<?php echo get_permalink($wiki_id);?>"><?php echo $origin_title ;?></a>的历史版本</h2>
    <div class="divline"></div>
    <h2><b><?php echo $title ;?></b></h2>
    <?php echo $content ; ?>
</div>

<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <div class="sidebar_button">
        <a onclick="restore_revision('<?=$admin_url?>','<?=$revision_id?>')"  class="restore-revision button button-primary" role="button">恢复到此版本</a>
    </div>
    <div class="sidebar-grey-frame" style="margin-top: 30px">
       <p>此版本作者：<a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$author_id.'&tab=wiki'?>"
                  class="author_link"><?php echo $author?></a>
       </p>
        <p><?php echo $revision[0]->post_date ?></p>
    </div>
</div>
<script>
    function restore_revision() {
        var data = {
            action: "restore_post_revision",
            revision_id: <?php echo $revision_id;?>
        };
        $.ajax({
            type: "POST",
            url:"<?php echo $admin_url;?>",//你的请求程序页面
            //async:false,//同步：意思是当有返回值以后才会进行后面的js程序。
            data: data,//请求需要发送的处理数据
            //dataType: "text",
            success: function () {
                    window.location.href = "<?php echo get_permalink( $wiki_id ) ;?>";
            },
            error: function () {
                alert("error");
            }
        });
    }
</script>