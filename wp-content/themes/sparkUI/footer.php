<style>
    .list-group li a,p {color: #333;}
    .list-group li a:hover{text-decoration: none;  color: #fe642d;}
    /*.list-group li p{color: #333;}*/
</style>

<div class="footer">
    <div style="height:2px;background-color: #fe642d"></div>
    <div style="height:4px;background-color: #ffe9e1"></div>

    <div class="container" style="background-color: #fafafa;">
        <div class="row">

            <div class="col-md-9 col-sm-9 col-xs-9" id="col9">
                <div class="col-md-3 col-sm-3 col-xs-12" id="spark-foot-logo">
                    <a href="<?php echo site_url(); ?>"><img src="<?php bloginfo("template_url") ?>/img/logo.png"></a>
                </div>
                <div class="clearfix visible-xs"></div>
                <div class="col-md-1 col-sm-1 col-xs-12" class="foot-link" id="spark-nav">
                    <p>导航</p>
                    <ul class="list-group">
                        <li class="list-group-item" ><a href="<?php echo site_url() . get_page_address('wiki');?>" >wiki</a></li>
                        <li class="list-group-item" ><a href="<?php echo site_url() . get_page_address('qa');?>" >问答</a></li>
                        <li class="list-group-item" ><a href="<?php echo get_the_permalink( get_page_by_title( '项目' )); ?>">项目</a></li>
                    </ul>
                </div>
                <div class="clearfix visible-xs"></div>
                <div class="col-md-3 col-sm-3 col-xs-12" class="foot-link" id="contact-us">
                    <p>联系我们</p>
                    <ul class="list-group">
                        <li class="list-group-item"><a target="_blank" href="mailto:sparkdevelop@163.com">sparkdevelop@163.com</a></li>
                        <li class="list-group-item">
                            <a target="_blank" href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=JRQUEhcSFBUdFBFlVFQLRkpI" style="text-decoration:none;">
                                意见反馈
                            </a>
                        </li>
                        <li class="list-group-item"><a href="<?php echo site_url().get_page_address('info').'&tab=about'?>">关于我们</a></li>
                    </ul>
                </div>
                <div class="clearfix visible-xs"></div>
                <div class="col-md-2 col-sm-2 col-xs-12" class="foot-link" id="friend-link">
                    <p>友情链接</p>
                    <ul class="list-group">
                        <li class="list-group-item"><a href="https://www.ourspark.org/">涅槃之路</a></li>
                        <li class="list-group-item"><a href="http://internet.welishi.cn/">互联网简史</a></li>
                        <li class="list-group-item"><a href="http://invention.welishi.cn/">发明简史</a></li>
                    </ul>
                </div>
                <div class="clearfix visible-xs"></div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12" style="text-align: center;padding:0;">
                <img src="<?php bloginfo("template_url") ?>/img/address.png" class="spark-QRCode">
            </div>
            <div class="clearfix visible-xs"></div>
        </div>
        <div class="divline"></div>
        <div class="row">
            <div class="copyright">
                    <span>Copyright © 2017-2020 <a href="<?php echo site_url(); ?>" target="_blank">火花空间</a>. All Rights Reserved. </span>
                    <span><a href="http://www.beian.miit.gov.cn/" target="_blank">京ICP备19044946号-2</a></span>
            </div>
        </div>
    </div>
</div>

<?php wp_footer();
$userId=get_current_user_id();
$admin_url = admin_url('admin-ajax.php');
?>

<script src="<?php bloginfo('stylesheet_directory')?>/javascripts/main.js"></script>

<script>
    $(document).ready(function(){
        var all_a = $("a");
        host_url=window.location.host;
        for (var i = 0; i < all_a.length; i++) {
            if(all_a[i].href){
                var domain = all_a[i].href.split("/"); //以“/”进行分割
                if (domain[2] !== host_url) {
                    //console.log(all_a[i].href);
                    all_a[i].target = "_blank";
                    all_a.eq(i).click(function () {
                        chain_log(this.href,this.text)
                    });
                }
            }

        }

    });
    function chain_log(url,page) {
        var user_id = '<?php echo $userId;?>';
        var click_time = getCurrentDate();
        //console.log(click_time);
        var data = {
            action: "add_chain_log",
            user_id : user_id,
            click_time : click_time,
            url : url,
            page : page
        };
        $.ajax({
            type: "POST",
            url:"<?php echo $admin_url;?>",//你的请求程序页面
            //async:false,//同步：意思是当有返回值以后才会进行后面的js程序。
            data: data,//请求需要发送的处理数据
            dataType: "json",
            success: function (msg) {
                 //alert("success");
            },
            error: function () {
                // alert("error");
            }
        });

    }
    function getCurrentDate() {
        var now = new Date();
        var year = now.getFullYear(); //得到年份
        var month = now.getMonth();//得到月份
        var date = now.getDate();//得到日期
        var hour = now.getHours();//得到小时
        var minu = now.getMinutes();//得到分钟
        var sec = now.getSeconds();//得到秒
        month = month + 1;
        if (month < 10) month = "0" + month;
        if (date < 10) date = "0" + date;
        if (hour < 10) hour = "0" + hour;
        if (minu < 10) minu = "0" + minu;
        if (sec < 10) sec = "0" + sec;
        var time = "";
        time = year + "-" + month + "-" + date+ " " + hour + ":" + minu + ":" + sec;
        return time;
    }
    //google Analyze
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    <?php
    if (isset($userId)) {
        $gacode = "ga('create', 'UA-99600634-1', { 'userId': '%s' });";
        echo sprintf($gacode, $userId);
    } else {
        $gacode = "ga('create', 'UA-99600634-1');";
        echo sprintf($gacode);
    }
    ?>
    ga('send', 'pageview');

</script>


<!--暂时屏蔽北邮关键词-->
<script>
    var s= document.body.innerHTML;
    s=s.replace(/北邮/g,'B校');
    s=s.replace(/北京邮电大学/g,'B校');
    document.body.innerHTML=s;
</script>
</body>
</html>
