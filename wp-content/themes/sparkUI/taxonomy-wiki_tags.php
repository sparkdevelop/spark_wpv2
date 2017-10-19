<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2017/10/16
 * Time: 16:20
 */
get_header() ?>
<?php $tag = $_GET['wiki_tags']; ?>
    <div class="container" style="margin-top: 10px">
        <div class="row" style="width: 100%">
            <div class="col-md-9 col-sm-9 col-xs-12" id="col9">
                <ul id="leftTab" class="nav nav-pills" style="height: 42px;margin-top: 10px">
                    <li class="active" style="margin-left: 0px;font-size:larger"><p>标签：<?php echo $tag; ?></p></li>
                </ul>

                <div id="rightTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="my-publish" style="padding-top: 50px;">
                        <div style="height: 2px;background-color: lightgray;"></div>
                        <ul class="list-group">
                            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <!-- 文章 -->
                                <div class="wiki-title">
                                    <a class="wiki-title" href="<?php the_permalink(); ?>"
                                       style="color: black;font-size:large"><?php echo get_the_title(); ?></a> </div>
                                <div class="wiki-excerpt">
                                    <p style="word-wrap: break-word;"><?php echo get_the_excerpt(); ?>
                                        <a href="<?php the_permalink(); ?>" class="button right" style="color: #fe642d;font-weight:bold;">阅读全文</a>
                                    </p>
                                </div>
                                <div class="wiki-info">
                                    <span class="fa fa-clock-o"> <?php echo date('y年n月j日 G:i', get_the_time('U')); ?> &nbsp;&nbsp; </span>
                                    <span class="fa fa-bookmark-o" >&nbsp;<?php the_terms('0','wiki_tags','','，',''); ?></span>
                                </div>
                                <div style="height: 1px;background-color: lightgray;"></div>
                                <!-- 文章end -->
                            <?php endwhile;endif; ?>
                            <?php project_custom_pagenavi($wp_query, 4); ?>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
                <div class="wiki_sidebar_wrap">
                    <div class="sidebar_button">
                        <a href="<?php echo get_permalink(get_page_by_title('创建wiki')); ?>">创建 wiki</a>
                    </div>
                    <!--    精品词条-->
                    <div class="top_wikis">
                        <div class="sidebar_list_header">
                            <p>精品词条</p>
                        </div>
                        <!--分割线-->
                        <div style="height: 2px;background-color: lightgray"></div>
                        <div class="top_wiki_list" id="top_wiki_list">
                            <ul style="padding-left: 0px">
                                <?php
                                $top_wiki_id = array();
                                array_push($top_wiki_id, get_the_ID_by_title('导论实验课'));
                                array_push($top_wiki_id, get_the_ID_by_title('开放平台'));
                                array_push($top_wiki_id, get_the_ID_by_title('炫彩LED灯'));
                                array_push($top_wiki_id, get_the_ID_by_title('串口通信'));
                                array_push($top_wiki_id, get_the_ID_by_title('自动控制路灯'));
                                array_push($top_wiki_id, get_the_ID_by_title('中国5g联创进校园'));
                                array_push($top_wiki_id, get_the_ID_by_title('wifi气象站(本地版)'));

                                for ($i = 0; $i < sizeof($top_wiki_id); $i++) {
                                    ?>
                                    <li class="list-group-item">
                                        <div style="display: inline-block; vertical-align: baseline;">
                            <span class="fa fa-star pull-left" style="color: red">
                                &nbsp;&nbsp;
                            <a style="color:black;" href="<?php the_permalink($top_wiki_id[$i]); ?>">
                                    <?php echo get_the_title($top_wiki_id[$i]); ?>
                            </a>
                            </span>

                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>