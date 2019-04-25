<?php
$faq_id = $related_faq_id[$i];
$author_info =Spark_get_author($faq_id);
?>
<div id="faq_<?php echo $i;?>" style="margin-top: 20px;">
    <!--    获取提问者头像-->
    <div class="comment-avatar">
        <?php echo get_avatar($author_info['id'],48,'');?>
    </div>
    <div class="qa_show">
        <!--        获取提问者名字、提问时间-->
        <div class="qa_time">
            <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$author_info['id'];?>" class="author_link"><?php echo $author_info['name'];?></a>
            <?php
            $user_level = get_user_level($author_info['id']);
            $img_url = $user_level.".png";
            ?>
            <img src="<?php bloginfo("template_url")?>/img/integral/<?=$img_url?>" style="width: 20px;margin-left: -20px">

            <span><?php echo date('n月j日 G:i',get_the_time('U',$faq_id));?>  </span>&nbsp;&nbsp;
            <!--            -->
            <span>分享</span>
        </div>
    <div style="width: 100%;margin-top: 10px;">
        <div class="project-title" style="height: 30px;">
            <a class="project-title" href="<?php the_permalink($faq_id); ?>" style="color: black"><?php echo get_the_title($faq_id); ?></a>
        </div>
        <div>
            <?php
            $faq = get_post($faq_id);
            $faq_content = strip_tags($faq->post_content);
            echo mb_strimwidth($faq_content, 0, 100,"...");?>
        </div>
    </div>
    <div style="height: 1px;background-color: #dcdcdc;margin-top: 20px"></div>
    </div>
</div>

