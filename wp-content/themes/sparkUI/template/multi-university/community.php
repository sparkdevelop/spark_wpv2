<style>
    .school-entry-class img {
        width: 100%;
        height: 100%;
        border: 1px solid lightgray;
        border-radius: 10px;
    }

    .school-entry-class {
        padding: 20px 10px;
    }
</style>
<div id="community_index">
    <h3>入驻高校</h3>
    <ul class="list-group">
        <?php
        for ($i = 0; $i < 14; $i++) {
            if ($i >= 9){?>
                <style>
                    #school-entry-<?=$i?>{
                        display: none;
                    }
                </style>
            <?php } ?>
            <li class="list-group-item col-md-4 col-sm-4 col-xs-6 school-entry-class" id="school-entry-<?=$i?>">
                <img src="<?php bloginfo('template_url'); ?>/img/univerisity-logo/bupt.png"
                onclick="window.open('<?php the_permalink(235)?>')"
                >
            </li>
        <?php } ?>
        <style>
            .more{
                margin-top: 10px;
                height: 36px;
                line-height: 36px;
                text-align: center;
                font-size: 20px;
                cursor: pointer;
                color: #fe642d;
            }
        </style>
        <div style="clear: both"></div>
        <div class="more">显示全部高校</div>

    </ul>

    <h3>联盟简介</h3>
    我们对学生的希望：<br><br>
    自学的能力是最重要的能力；<br>
    要让学生有终身学习的意识与习惯；<br>
    学生毕业的时候对自己有信心。<br><br>

    <b>对应的我们就需要创新、需要冒险，要“做到以往没想过的、认为不可能的”。</b>
</div>
<script>
    $(document).on('click','.more',function () {
        $(".school-entry-class").css('display','block');
        $(".more").css('display','none')
    })
</script>
