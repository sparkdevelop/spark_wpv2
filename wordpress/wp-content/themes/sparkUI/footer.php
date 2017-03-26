<?php
    global $wiki_page_ID;
    global $qa_page_ID;
    global $project_page_ID;
    global $ask_page_ID;
    $wiki_page_ID= "?page_id=46";
    $qa_page_ID="?page_id=55";
    $project_page_ID="?page_id=62";

?>
<div class="footer" style="height:160px;background-color: #fafafa">
    <div style="height:2px;background-color: #fe642d"></div>
    <div style="height:3px;background-color: #ffe9e1"></div>
    <div class="col-md-3 col-sm-3 col-xs-3">
        <a href="<?php echo site_url(); ?>"><img src="<?php bloginfo("template_url")?>/img/logo.png" style="vertical-align:middle;padding:15px 10px 10px 40px;display: inline-block;float: right"></a>
    </div>
    <div class="clearfix visible-xs"></div>
    <div class="col-md-1 col-sm-1 col-xs-1" style="text-align: right">
        <p style="font-size: medium;font-weight: bold;color: #fe642d;margin-top: 15px">导航</p>
        <ul class="list-group">
            <li class="list-group-item" style="background-color: #fafafa"><a href="<?php echo site_url().$wiki_page_ID;?>" style="margin-bottom: 5px">wiki</a></li>
            <li class="list-group-item" style="background-color: #fafafa"><a href="<?php echo site_url().$qa_page_ID; ?>" style="margin-bottom: 5px">问答</a></li>
            <li class="list-group-item" style="background-color: #fafafa"><a href="<?php echo site_url().$project_page_ID; ?>" style="margin-bottom: 5px">项目</a></li>
        </ul>
    </div>
    <div class="clearfix visible-xs"></div>
    <div class="col-md-2 col-sm-2 col-xs-2" style="text-align: center">
        <p style="font-size: medium;font-weight: bold;color: #fe642d;margin-top: 15px">联系我们</p>
        <ul class="list-group">
            <li class="list-group-item" style="background-color: #fafafa"><p style="margin-bottom: 5px;color: gray">sparkspace@163.com</p></li>
            <li class="list-group-item" style="background-color: #fafafa"><p style="margin-bottom: 5px;color: gray">2038448066</p></li>
        </ul>
    </div>
    <div class="clearfix visible-xs"></div>
    <div class="col-md-2 col-sm-2 col-xs-2">
        <p style="font-size: medium;font-weight: bold;color: #fe642d;margin-top: 15px">友情链接</p>
        <ul class="list-group">
            <li class="list-group-item" style="background-color: #fafafa"><a href="https://www.microduino.cc/" style="margin-bottom: 5px">microduino官网</a></li>
            <li class="list-group-item" style="background-color: #fafafa"><a href="https://cn.wordpress.org/" style="margin-bottom: 5px">Wordpress</a></li>
        </ul>
    </div>
    <div class="clearfix visible-xs"></div>
    <div class="col-md-4 col-sm-4 col-xs-4" style="text-align: center">
        <img src="<?php bloginfo("template_url")?>/img/address.png" style="margin-top: 23px">
    </div>
    <div class="clearfix visible-xs"></div>
</div>
<?php wp_footer();?>
</body>
</html>
