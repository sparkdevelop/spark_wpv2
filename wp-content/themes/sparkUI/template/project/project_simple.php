<!--
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/15
 * Time: 12:28
-->



<li style="list-style-type: none;">
    <div class="col-md-4 col-sm-4 col-xs-6" id="project-fluid">
        <div class="thumbnail">
            <?php
            if ( has_post_thumbnail() ) { ?>
                <a href="<?php the_permalink(); ?>" target="_blank"><?php the_post_thumbnail(array(220,150)); ?></a> <?php } else {?>
                <a href="<?php the_permalink(); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面" height="150"/></a>
            <?php } ?>
          <div style="height: 1px;background-color: lightgray"></div>
            <div class="caption">
               <div class="project-title"><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></div>
            <div class="project-info">
            <span class="fa fa-user-o pull-left">&nbsp;<?php the_author(); ?></span><span class="fa fa-bookmark-o pull-right" id="project-category-info" > <?php the_category(', ') ?></span><span class="fa fa-eye pull-right" id="m-project-views" > <?php echo getProjectViews(get_the_ID()); ?></span><br>
            <span class="fa fa-clock-o pull-left"> <?php echo date('n月j日 G:i',get_the_time('U'));?> </span><span class="fa fa-comments-o pull-right" > <?php comments_popup_link('0 ', '1 ', '% ', '', '评论已关闭'); ?></span><span class="fa fa-eye pull-right" id="web-project-views" > <?php echo getProjectViews(get_the_ID()); ?></span><br>
            </div>
          </div>
         </div>
    </div>
</li>

