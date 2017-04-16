<!--
 * Created by PhpStorm.
 * User: Bless
 * Date: 2017/4/15
 * Time: 12:28
-->



<li style="list-style-type: none;">
    <div class="col-md-4 col-sm-4 col-xs-4">
        <div class="thumbnail" style="height: 270px">
            <?php
            if ( has_post_thumbnail() ) { ?>
                <?php the_post_thumbnail(array(220,150)); ?> <?php } else {?>
                <img src="<?php bloginfo('template_url'); ?>/img/thumbnail.png" alt="封面" height="150"/>
            <?php } ?>
          <div style="height: 1px;background-color: lightgray"></div>
            <div class="caption">
               <div class="project-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
            <div>
           <span class="fa fa-user-o pull-left" style="font-size: 12px;color: gray">&nbsp;<?php the_author(); ?></span><span class="fa fa-bookmark-o pull-right" style="font-size: 12px;color: gray"> <?php the_category(', ') ?></span>
            </div><br>
            <div style="display: inline;">
            <span class="fa fa-clock-o pull-left" style="font-size: 12px;color: gray"> <?php the_time('Y年n月j日') ?> </span><span class="fa fa-comments-o pull-right" style="font-size: 12px;color: gray"> <?php comments_popup_link('0 条', '1 条', '% 条', '', '评论已关闭'); ?></span><span class="fa fa-eye pull-right" style="font-size: 12px;color: gray"> <?php echo getProjectViews(get_the_ID()); ?></span><br>
             </div>
          </div>
         </div>
    </div>
</li>

