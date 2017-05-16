<!--
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/15
 * Time: 12:28
-->



<li style="list-style-type: none;">
    <div class="col-md-4 col-sm-4 col-xs-6" id="project-fluid">
        <div class="thumbnail" >
            <?php
            if ( has_post_thumbnail() ) { ?>
                <a href="<?php the_permalink(); ?>" target="_blank"><img src="<?php the_post_thumbnail_url('full')?>" class="cover" /></a>
            <?php } else {?>
                <a href="<?php the_permalink(); ?>" target="_blank"><img src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面" class="cover" /></a>
            <?php } ?>
            <div style="height: 1px;background-color: lightgray"></div>
            <div class="caption">
                <div class="project-title"><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></div>
                <div>
                    <span class="fa fa-user-o pull-left" >&nbsp;<?php the_author(); ?></span><span class="fa fa-bookmark-o pull-right" > <?php the_category(', ') ?></span><br>
                    <span class="fa fa-clock-o pull-left" > <?php the_time('Y年n月j日') ?> </span><span class="fa fa-comments-o pull-right" > <?php comments_popup_link('0 条', '1 条', '% 条', '', '评论已关闭'); ?></span><span class="fa fa-eye pull-right" style="font-size: 12px;color: gray"> <?php echo getProjectViews(get_the_ID()); ?></span><br>
                </div>
            </div>
        </div>
    </div>
</li>

