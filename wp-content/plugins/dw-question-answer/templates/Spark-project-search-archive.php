<?php
$search_word=$_GET['s'];
?>

   <div style="margin-top: 20px;"class="clearfix">
        <div style="float: left;">
            <?php
            if ( has_post_thumbnail() ) { ?>
                <?php the_post_thumbnail(array(220,150)); ?> <?php } else {?>
                <img src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面" height="100" width="180"/>
            <?php } ?>
        </div>
        <div style="float: left;margin-left:20px;width: 76%;">
            <div class="project-title">
                <a class="project-title" href="<?php the_permalink(); ?>" style="color: black"><?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_title()); ?></a>
            </div>
            <p style="word-wrap: break-word"><?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_excerpt()); ?><a href="<?php the_permalink(); ?>" class="button right" style="color: #fe642d;">阅读全文</a></p>
        </div>
        <div style="height: 1px;background-color: #dcdcdc;margin-top: 120px"></div>
    </div>

