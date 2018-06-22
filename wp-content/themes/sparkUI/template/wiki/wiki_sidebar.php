<style type="text/css">
    .mulu a {
        display: block;
        border: 1px solid #dcdcdc;
        height: 50px;
        padding-left: 20px;
        color: #333;
        font-size: 18px;
    }

    .mulu .mulu_item {
        display: block;
        border: 1px solid #dcdcdc;
        height: 50px;
        padding-left: 50px;
        margin-bottom: -1px;
        color: #666;
        font-size: 16px;
    }
</style>
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
                array_push($top_wiki_id,get_the_ID_by_title('导论实验课'));
                array_push($top_wiki_id,get_the_ID_by_title('开放平台'));
                array_push($top_wiki_id,get_the_ID_by_title('炫彩LED灯'));
                array_push($top_wiki_id,get_the_ID_by_title('串口通信'));
                array_push($top_wiki_id,get_the_ID_by_title('自动控制路灯'));
                array_push($top_wiki_id,get_the_ID_by_title('中国5g联创进校园'));
                array_push($top_wiki_id,get_the_ID_by_title('wifi气象站(本地版)'));

                for($i=0;$i<sizeof($top_wiki_id);$i++){?>
                    <li class="list-group-item">
                        <div style="display: inline-block; vertical-align: baseline;">
                            <span class="fa fa-star pull-left" style="color: red">
                                &nbsp;&nbsp;
                            <a style="color:black;" href="<?php the_permalink($top_wiki_id[$i]);?>">
                                    <?php echo get_the_title($top_wiki_id[$i]); ?>
                            </a>
                            </span>
                            <!--传浏览量-->
                        </div>
<!--                        <span class="fa fa-star pull-left" style="color: red"-->
<!--                        <a href="--><?php //echo get_permalink($top_wiki_id[$i]);?><!--" class="question-title">-->
<!--                            --><?php //echo get_the_title($top_wiki_id[$i]); ?>
<!--                        </a>-->
                    </li>
                <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>