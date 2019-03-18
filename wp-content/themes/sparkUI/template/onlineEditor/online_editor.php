<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2019/3/14
 * Time: 16:14
 */
$user_id = get_current_user_id();
$admin_url = admin_url('admin-ajax.php');
?>
<style>
    *	{
        margin:0;
        padding:0;
        border:0;
        background-color:transparent;
    }
    div#editor_butt	{
        height:50px;
        border-bottom: 1px solid #c5c5c5;
        background:#fff;
    }

    div#editor_butt input {
        margin:10px 0 0 10px;
        background:red;
        color:#fff;
        width:150px;
        height:30px;
        font:14px Verdana, Arial, Helvetica, sans-serif;
    }

    div#editor_CodeArea	{
        float:left;
        height:435px;
        width:50%;
        margin-left:5px;
    }

    #editor_CodeArea h2	{
        margin:10px 0 6px 5px;
        color:red;
        font-size:14px;
    }

    #editor_CodeArea textarea{
        width:100%;
        height:400px;
        overflow:auto;
        border:1px solid #c5c5c5;
        border-right:0;

        font:14px "Courier New", Courier, monospace;
    }

    div#editor_result	{
        float:left;
        height:435px;
        width:49%;
    }

    #editor_result h2	{
        margin:10px 0 6px 5px;
        color:red;
        font-size:14px;
    }

    #editor_result iframe{
        width:100%;
        height:400px;
        border:1px solid #c5c5c5;
    }

    #editor_footer	{
        clear:both;
        background:#fff;
        border:1px solid #f5f5f5;
        text-align:left;
        background: #f5f5f5;
    }

    #editor_footer	p {
        margin:10px;
        color: #000000;
        font-weight:bold;
    }



</style>
<div id="editor_tryitform" name="tryitform" target="i">

    <div id="editor_butt">
        <input type="button" value="提交代码" onclick="submitTryit()">
    </div>

    <div id="editor_CodeArea">
        <h2>编辑您的代码：</h2>
        <textarea id="TestCode" wrap="logical">&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
&lt;title&gt;文档的标题&lt;/title&gt;
&lt;/head&gt;

&lt;body&gt;
文档的内容......
&lt;/body&gt;

&lt;/html&gt;
</textarea>
    </div>

    <input type="hidden" id="code" name="code">
    <input type="hidden" id="bt" name="bt">

</div>

<div id="editor_result">
    <h2>查看结果:</h2>
    <iframe id="resultTab" src="<?php bloginfo("template_url")?>/template/onlineEditor/saved_resource.html"></iframe>
</div>

<div id="editor_footer">
    <p>请在上面的文本框中编辑您的HTML/CSS/JS代码，然后单击提交按钮测试结果。</p>
</div>
<script type="text/javascript">

    var repeatObj = {repeatTemp:[]};

    var check = {
        repeat:function(s){//限制执行频率，默认为60秒 允许执行时返回false
            t = 1000;//毫秒
            var time = new Date().getTime();
            if(!repeatObj.repeatTemp[s]){
                repeatObj.repeatTemp[s] = time;
                return false;//允许
            }else{
                var ts = t - (time -repeatObj.repeatTemp[s]);
                if(ts > 0){
                    alert("请勿频繁提交，至少间隔1秒！");
                    return true;//禁止执行
                }else{
                    repeatObj.repeatTemp[s] = time;//更新时间
                    return false;//允许
                }
            }
        }
    };
    function submitTryit()
    {
        var editor_butt = check.repeat('editor_butt');
        if(!editor_butt){
            var t=document.getElementById("TestCode").value;
            document.getElementById("resultTab").contentWindow.document.open();
            document.getElementById("resultTab").contentWindow.document.write(t);
            document.getElementById("resultTab").contentWindow.document.close();


            var user_id = '<?php echo $user_id;?>';
            var submit_time = getCurrentDate();
            var data = {
                action: "restore_code_submit",
                user_id : user_id,
                submit_time : submit_time,
                submit_code : t
            };
            $.ajax({
                type: "POST",
                url:"<?php echo $admin_url;?>",//你的请求程序页面
                //async:false,//同步：意思是当有返回值以后才会进行后面的js程序。
                data: data,//请求需要发送的处理数据
                dataType: "json",
                success: function (msg) {
                   // alert("success");
                },
                error: function () {
                   // alert("error");
                }
            });
        }

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

</script>