<div class="col-md-4 col-sm-4 col-xs-4 right">
    <div class="sidebar_list">
        <div class="sidebar_list_header">
            <p>大家都在搜</p>
            <!--列表头-->
            <ul id="askerTab" class="nav nav-pills" style="float: right">
                <li><a href="#searchday" data-toggle="tab" style="width: 20px;margin-top: 5px;">日</a></li>
                <li class="active"><a href="#searchweek" data-toggle="tab" style="width: 20px;margin-top: 5px;">周</a></li>
            </ul>
        </div>
        <!--分割线-->
        <div class="sidebar_divline"></div><!--下面的是列表

        <!--列表内容 需要填写的都用php提取出来就行-->
        <div id="askerTabContent" class="tab-content">
            <div class="tab-pane fade" id="searchday">
                <ul class="list-group">
                    <?php
                    $from_day=strtotime("-1 day")+8*3600;
                    $ask_most =array();
                    $ask_most=dwqa_user_most_ask(10,$from_day);
                    $ask_most_author_id = $ask_most[0]['post_author'];
                    for($i=0;$i<10;$i++){
                        ?>
                        <li class="list-group-item">
                            <img src="<?php bloginfo("template_url")?>/img/n<?php echo $i+1;?>.png" style="display: inline-block;margin-right: 10px;">
                            <?php echo get_avatar($ask_most[$i]['post_author'],20,'');?>
                            <a href="<?php echo dwqa_get_author_link($ask_most[$i]['post_author']);?>" style="display:inline-block;"><?php echo get_userdata($answer_most[$i]['post_author'])->display_name;?></a>
                            <p style="display: inline-block;float: right"><?php echo $ask_most[$i]['ask_count'];?>问</p>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="tab-pane fade in active" id="searchweek">
                <ul class="list-group">
                    <?php
                    $from_week=strtotime("-1 week")+8*3600;
                    $ask_most_this_week = array();
                    $ask_most_this_week = dwqa_user_most_ask(10,$from_week);
                    //$answer_most_this_week_author_id = $answer_most_this_week[0]['post_author'];
                    for($i=0;$i<10;$i++){
                        ?>
                        <li class="list-group-item">
                            <img src="<?php bloginfo("template_url")?>/img/n<?php echo $i+1;?>.png" style="display: inline-block;margin-right: 10px;"/>
                            <?php echo get_avatar($ask_most_this_week[$i]['post_author'],20,'');?>
                            <a href="<?php echo dwqa_get_author_link($ask_most_this_week[$i]['post_author']);?>" style="display:inline-block;">
                                <?php echo get_userdata($ask_most_this_week[$i]['post_author'])->display_name;?>
                            </a>
                            <p style="display: inline-block;float: right"><?php echo $ask_most_this_week[$i]['ask_count'];?>次
                            </p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div><!--asker-->
</div>