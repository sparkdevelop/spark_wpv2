<?php

?>

<div>
    <?php for($i=0;$i<5;$i++){?>
        <div style="height: 1px;background-color: lightgray"></div>
        <div style="margin: 20px 20px">
            <div style="width: 90%;display:inline-block;;">
                <h4><a style="color: black" href="#">来SAE搭建一个WordPre博客吧</a></h4>
                <div style="margin-top: 10px">
                    <span>发布人:</span>
                    <a href="<?php echo site_url().get_page_address('otherpersonal').'&id='.$author;?>" style="color: #169bd5"><?php echo get_author_name($author)?></a>
                    <span style="margin-left: 40px">80%成员已完成</span>
                </div>
            </div>
            <div style="display: inline-block;vertical-align: super">
                <button class="btn-green">去完成</button>
            </div>
        </div>
    <?php } ?>
</div>
