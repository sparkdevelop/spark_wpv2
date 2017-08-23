<?php
    //获取该组的所有任务?未截止的?
    $all_task = get_task($group_id);
    if (sizeof($all_task) != 0 ){?>
        <div>
            <?php for($i=0;$i<sizeof($all_task);$i++){  //没有翻页?>
                <div style="height: 1px;background-color: lightgray"></div>
                <div style="margin: 20px 20px">
                    <div style="width: 90%;display:inline-block;;">
                        <h4><a style="color: black" href="<?php echo site_url().get_page_address('single_task').'&id='.$all_task[$i]['ID'];?>"><?=$all_task[$i]['task_name']?></a></h4>
                        <div style="margin-top: 10px">
                            <span>发布人:</span>
                            <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$all_task[$i]['task_author'];?>" style="color: #169bd5"><?php echo get_author_name($all_task[$i]['task_author'])?></a>
                            <span style="margin-left: 40px">80%成员已完成</span>
                        </div>
                    </div>
                    <div style="display: inline-block;vertical-align: super">
                        <button class="btn-green" onclick="location.href ='<?php echo site_url().get_page_address('single_task').'&id='.$all_task[$i]['ID'];?>'">去完成</button>
                    </div>
                </div>
            <?php } ?>
        </div>
<?php
    } else {
        echo '<div class="divline" style="margin-top: 0px"></div>';
        echo '<div class="alert alert-info" style="margin-top: 20px">Oops, 该群组还没有任务</div>';
    }
?>

