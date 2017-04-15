<?php
$search_word=$_GET['s'];
?>

<div class="container">
    <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-2">
            <?php
            if ( has_post_thumbnail() ) { ?>
                <?php the_post_thumbnail(array(220,150)); ?> <?php } else {?>
                <img src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面" height="150"/>
            <?php } ?>
        </div>
        <div class="col-md-7 col-sm-7 col-xs-7">
            <div style="height: 1px;background-color: lightgray"></div>

            <div style="height: 50px;font-size: 20px;color: black;">
                <b><a href="<?php the_permalink(); ?>" style="color: black"><?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_title()); ?></a></b>
            </div>

            <p><?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_excerpt()); ?><a href="<?php the_permalink(); ?>" class="button right">阅读全文</a></p>
        </div>
    </div>
</div>

