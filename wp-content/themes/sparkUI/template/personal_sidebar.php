<?php $current_user = wp_get_current_user();
      $user_description = get_user_meta($current_user->ID,'description',true);

?>

<?php
$admin_url=admin_url('admin-ajax.php');
?>
<!--<script type="text/javascript">

    function get_notice() {
        var get_contents = {
            action: "get_notice",
        };
        $.ajax({
            type: "POST",
            url: "<?php /*echo $admin_url;*/?>",
            data: get_contents,
            dataType: "json",
            beforeSend: function () {
            },
            success: function(data){
                alert(data.new_comments.length);
            },
            error: function() {
                alert("消息提醒 获取失败!");
            }
        });
    }

    $(function(){
        get_notice();
    });
</script>-->

<div class="col-md-3 col-sm-3 col-xs-3 right" id="col3">
    <div id="user-profile">
        <div id="avatar">
            <?php echo get_avatar($current_user->ID,100);?>
            <img id="previewAva"/>
            <div class="change" id="setPhoto"><i class="fa fa-camera" aria-hidden="true"></i></div>
        </div>
        <div id="changeAvaDiv" style="display: none;margin-top: 20px;">
            <form class="form-horizontal" role="form" name="updateAva" enctype="multipart/form-data" method="post" action="<?php echo esc_url(self_admin_url('profile-process-avatar.php')); ?>">
                <a href="javascript:;" class="a-upload">修改头像<input type='file' name='simple-local-avatar'id='simple-local-avatar'/></a>
                <a href="javascript:;" class="a-upload">保存<input type='submit' class='btn btn-default' name='submit' value='保存'/></a>
                <input type="text" placeholder="文件名" id="aim" class="upload-filename"/>
            </form>
        </div>
        <script>
            window.onload = function(){
                var ms = document.getElementById("avatar");
                var add = document.getElementById("setPhoto");
                ms.onmouseover = function(){
                    add.style.display = "block";
                };
                ms.onmouseout = function(){
                    add.style.display = "none";
                };
            };
        </script>
        <script>
            var Avatar = document.getElementById("avatar");
            Avatar.onclick = preChangeAvatar;
            function preChangeAvatar() {
                $("#avatar img").hide(1000);
                $("#changeAvaDiv").toggle(1000);
                $("#simple-local-avatar").change(function() {
                    var file,img;
                    if(file=this.files[0]){
                        console.log("ok1");
                        //获取图片url
                        var picurl = getObjectURL(this.files[0]);
                        $("#previewAva").attr("src", picurl).load(function () {
                            var img_w = this.width;
                            var img_h = this.height;
                            if (img_w >= img_h) {
                                $("#previewAva").width(img_w * 100 / img_h).height(100);
                                var x1 = (img_w - img_h) / 2;
                                var x2 = (img_w - img_h) / 2 + img_h;
                                $("#previewAva").attr("src", picurl).css({
                                    //"position": "absolute",
                                    "clip": "rect(0px " + x2 + "px " + img_h + "px " + x1 + "px)",
                                    "-webkit-border-radius": "60px"
                                });
                                console.log(img_h);
                            } else{
                                $("#previewAva").width(img_h * 100 / img_w).height(100);
                                var y1 = (img_h - img_w) / 2;
                                var y2 = (img_h - img_w) / 2 + img_w;
                                $("#previewAva").attr("src", picurl).css({
                                    //"position": "absolute",
                                    "clip": "rect(" + y1 + "px "+ img_w + "px " + y2 + "px " + "0px)",
                                    "-webkit-border-radius": "60px"
                                });
                            }
                            //显示
                            $("#previewAva").show();
                        });
                    }
//                    $("#previewAva").attr("src", picurl);
//                    //获取图片宽和高 写函数?
//                    getImageWidthAndHeight('simple-local-avatar', function (obj) {
//                        console.log('width:' + obj.width + '-----height:' + obj.height);
////                        var img_w = obj.width;
////                        var img_h = obj.height;
////                        //处理图片,设置css
////                        if (img_w >= img_h) {
////                            var x1 = (img_w - img_h) / 2;
////                            var x2 = (img_w - img_h) / 2 + img_h;
////                            $("#previewAva").attr("src", picurl).css({
////                                "position": "absolute",
////                                "clip": "rect(0px " + x1 + "px " + img_h + "px " + x2 + "px)"
////                            });
////                        } else {
////                            var y1 = (img_h - img_w) / 2;
////                            var y2 = (img_h - img_w) / 2 + img_w;
////                            $("#previewAva").attr("src", picurl).css({
////                                "position": "absolute",
////                                "clip": "rect(" + y1 + "px 0px" + y2 + "px " + img_w + "px)"
////                            });
////                        }
////                        //显示
////                        $("#previewAva").show();
//                    });
                });
            }

//                    getPicSize("previewAva",picurl,function () {
//                        if (picurl) {
//                            if (img_w >= img_h) {
//                                var x1 = (img_w - img_h) / 2;
//                                var x2 = (img_w - img_h) / 2 + img_h;
//                                $(this).attr("src", picurl).css({
//                                    "position": "absolute",
//                                    "clip": "rect(0px " + x1 + "px " + img_h + "px " + x2 + "px)"
//                                });
//                                console.log($("#previewAva").width());
//                            }else{
//                                var y1 = (img_h - img_w) / 2;
//                                var y2 = (img_h - img_w) / 2 + img_w;
//                                $(this).attr("src", picurl).css({
//                                    "position": "absolute",
//                                    "clip": "rect("+ y1 + "px 0px" + y2 + "px " + img_w + "px)"
//                                });
//                                console.log($("#previewAva").width());
//                            }
//                            $(this).css({"width":"100px","height":"100px","-webkit-border-radius": "60px"});
//                            console.log($("#previewAva").width());
//                        }
//




//                        if(img_w>w||img_h>h){//如果图片宽度超出容器宽度--要撑破了
//                            var height = (w*img_h)/img_w; //高度等比缩放
//                            var width = (h*img_w)/img_h; //宽度等比缩放
//                            $("#previewAva").show().attr("src",picurl).css({"width":width,"height":height,"-webkit-border-radius": "60px"});
//                            //$(this).css({"width":w,"height":height});//设置缩放后的宽度和高度
//                        }
//                        else{
//                            $("#previewAva").show().attr("src",picurl).css({"width":"100px","height":"100px","-webkit-border-radius": "60px"});
//                        }


            //------------------获取图片url地址---------------
            function getObjectURL(file) {
                var url = null;
                if (window.createObjectURL!=undefined) { // basic
                    url = window.createObjectURL(file) ;
                } else if (window.URL!=undefined) { // mozilla(firefox)
                    url = window.URL.createObjectURL(file) ;
                } else if (window.webkitURL!=undefined) { // webkit or chrome
                    url = window.webkitURL.createObjectURL(file) ;
                }
                return url ;
            }
            //获取input图片宽高和大小
            function getImageWidthAndHeight(id, callback) {
                var _URL = window.URL || window.webkitURL;
                $("#" + id).change(function (e) {
                    var file, img;
                    if ((file = this.files[0])) {
                        img = new Image();
                        img.onload = function () {
                            callback && callback({"width": this.width, "height": this.height});
                        };
                        img.src = _URL.createObjectURL(file);
                    }
                });
            }

        </script>
        <script type="text/javascript">
            var file = $('#simple-local-avatar'),
                aim = $('#aim');
            file.on('change', function( e ){
                //e.currentTarget.files 是一个数组，如果支持多个文件，则需要遍历
                var name = e.currentTarget.files[0].name;
                aim.val( name );
            });
        </script>
        <p style="font-size: large;margin-top: 20px"><?php echo $current_user->data->display_name;?></p>
        <p style="margin-top: 10px;color: gray"><?php echo $user_description;?></p>
    </div>
    <ul id="personal_nav" class="nav nav-pills nav-stacked">
        <li id="notification">
            <img src="<?php bloginfo("template_url")?>/img/notification.png">
            <span>
                <a href="<?php echo esc_url(add_query_arg(array('tab'=>'notification')))?>">消息提醒</a>
            </span>
        </li>
        <li id="wiki">
            <img src="<?php bloginfo("template_url")?>/img/wiki.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'wiki')))?>">我的wiki</a></span>
        </li>
        <li class="active" id="qa">
            <img src="<?php bloginfo("template_url")?>/img/qa.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'qa')))?>">我的问答</a></span>
        </li>
        <li id="project">
            <img src="<?php bloginfo("template_url")?>/img/project.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'project')))?>">我的项目</a></span>
        </li>
        <li id="profile">
            <img src="<?php bloginfo("template_url")?>/img/profile.png">
            <span><a href="<?php echo esc_url(add_query_arg(array('tab'=>'profile')))?>">个人资料</a></span>
        </li>
    </ul>
</div>
