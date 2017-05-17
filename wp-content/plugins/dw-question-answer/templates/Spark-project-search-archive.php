<?php
$search_word=$_GET['s'];
?>

   <div style="margin-top: 20px;"class="clearfix">
        <div class="m-search-project-list" style="float: left;">
            <?php
            if ( has_post_thumbnail() ) { ?>
                <img src="<?php the_post_thumbnail_url('full')?>" style="height:100px;width:180px;display: block"/>
            <?php } else {?>
                <img src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面" height="100" width="180"/>
            <?php } ?>
        </div>
        <div class="search-project-text">
            <div class="project-title" id="m-project-title-box">
                <a class="project-title" id="m-project-title" href="<?php the_permalink(); ?>" style="color: black"><?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_title()); ?></a>
            </div>
            <p style="word-wrap: break-word"><?php echo str_replace($search_word,'<font color=red>'.$search_word.'</font>',get_the_excerpt()); ?><a href="<?php the_permalink(); ?>" class="button right" style="color: #fe642d;">阅读全文</a></p>
        </div>
        <div class="search-project-divline"></div>
    </div>

