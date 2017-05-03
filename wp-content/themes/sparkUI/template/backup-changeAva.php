<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/4/25
 * Time: 下午11:08
 */
?>
<form class="form-horizontal" role="form" name="updateAva" enctype="multipart/form-data"
      method="post"
      action="<?php echo esc_url( self_admin_url('profile-process-avatar.php') ); ?>">
    <input type="button" class="btn btn-default" id="changeAva" value="changeAva" onclick="changeAvatar()">
    <p id="inner"></p>
    <script>
        function changeAvatar() {
            var file_button = document.getElementById("inner");
            file_button.innerHTML =
                "<input type=\"file\" name=\"simple-local-avatar\" id=\"simple-local-avatar\"/>"+
                "<input type=\"submit\" name='submit' value=\"修改\">";
        }
    </script>
</form>



    <input type="button" class="btn btn-default" id="changeAva" value="更换头像"
           style="display: none;margin-left: 90px;margin-top: 20px"
           onclick="ChangeAvatar()"/>
    <p id="inner" style="display: none;"><p>

<script>
            function ChangeAvatar() {
                //弹出选择文件框
                var changeAvaBtn = document.getElementById('changeAva');
                var file_button = document.getElementById("inner");
                changeAvaBtn.style.display = "none";
                if(file_button.style.display == "none"){
                    file_button.style.display = "block";
                    file_button.innerHTML =
                        '<form class="form-horizontal" role="form" name="updateAva" enctype="multipart/form-data" method="post" action="<?php echo esc_url(self_admin_url('profile-process-avatar.php')); ?>//">'+
                            "<input type='file' name='simple-local-avatar' id='simple-local-avatar' style='margin-top:20px;margin-left:30px'/>"+
                            "<input type='submit' class='btn btn-default' name='submit' value='修改'>"+
                            "</form>"
                }else{
                    file_button.style.display = "none";}
            }





            var Avatar = document.getElementById("avatar");
            $("#avatar").on('mouseenter',function () {
                Avatar.innerHTML =
                    '<form class="form-horizontal" role="form" name="updateAva" enctype="multipart/form-data" method="post" action="<?php echo esc_url(self_admin_url('profile-process-avatar.php')); ?>">' +
                        '<input type="button" class="btn btn-default" id="changeAva" value="changeAva"/> ' +
                        '<p id="inner"><p>'+
                            '</form>';

                $("#changeAva").on("click",function(){
                    alert("ok");
                });
            });
                .on('mouseleave',function () {
                Avatar.innerHTML = "<?php echo get_avatar($current_user->ID,100);?>";
            });






                var Avatar = document.getElementById("avatar");
                Avatar.innerHTML =
                    '<form class="form-horizontal" role="form" name="updateAva" enctype="multipart/form-data" method="post" action="<?php echo esc_url( self_admin_url('profile-process-avatar.php') ); ?>">'+
                        '<input type="button" class="btn btn-default" id="changeAva" value="changeAva"> </form>';
                $("#changeAva").on("click",function(){
                    $("#changeAva").append("<p id='inner'><p>");
                        document.write("ok");
                    });
                }).on('mouseleave',function () {
                    var Avatar = document.getElementById("avatar");
                    Avatar.innerHTML = "<?php echo get_avatar($current_user->ID,100);?>";
                });

                var Avatar = document.getElementById("avatar");

                Avatar.onmousedown= preChangeAvatar;
                Avatar.onmouseout = cancelChangeAvatar;
                $('#avatar').on('click', '#changeAva', function() {
                    alert("change");
                });
                function preChangeAvatar() {

                    <?php $url=get_template_directory_uri()."/img/changeAvatar.png";?>
                                    "<img src=\"<?=$url?>\" class=\"avatar\" id=\"changeAva\">";

                }
                function cancelChangeAvatar() {

                }
                function changeAvatar() {
                    var file_button = document.getElementById("inner");
                    file_button.innerHTML =
                        "<input type=\"file\" name=\"simple-local-avatar\" id=\"simple-local-avatar\"/>"+
                        "<input type=\"submit\" name='submit' value=\"修改\">";
                }
</script>
    <script>
                                $("#previewAva").attr("src", picurl).load(function () {
                                    var img_w = this.width;
                                    var img_h = this.height;
                                    if (img_w >= img_h) {
                                        $("#previewAva").width(img_w * 100 / img_h).height(100);
                                        var x1 = (img_w - img_h) / 2;
                                        var x2 = (img_w - img_h) / 2 + img_h;
                                        $("#previewAva").attr("src", picurl).css({
                                            "position": "absolute",
                                            "clip": "rect(0px " + x2 + "px " + img_h + "px " + x1 + "px)",
                                            //"-webkit-border-radius": "60px"
                                        });
                                    } else{
                                        $("#previewAva").width(img_h * 100 / img_w).height(100);
                                        var y1 = (img_h - img_w) / 2;
                                        var y2 = (img_h - img_w) / 2 + img_w;
                                        $("#previewAva").attr("src", picurl).css({
                                            "position": "absolute",
                                            "clip": "rect(" + y1 + "px "+ img_w + "px " + y2 + "px " + "0px)",
                                            //"-webkit-border-radius": "60px"
                                        });
                                    }
                                    //显示
                                    $("#previewAva").show();
                                });
                            $("#previewAva").attr("src", picurl);
                            //获取图片宽和高 写函数?
                            getImageWidthAndHeight('simple-local-avatar', function (obj) {
                                console.log('width:' + obj.width + '-----height:' + obj.height);
        //                        var img_w = obj.width;
        //                        var img_h = obj.height;
        //                        //处理图片,设置css
        //                        if (img_w >= img_h) {
        //                            var x1 = (img_w - img_h) / 2;
        //                            var x2 = (img_w - img_h) / 2 + img_h;
        //                            $("#previewAva").attr("src", picurl).css({
        //                                "position": "absolute",
        //                                "clip": "rect(0px " + x1 + "px " + img_h + "px " + x2 + "px)"
        //                            });
        //                        } else {
        //                            var y1 = (img_h - img_w) / 2;
        //                            var y2 = (img_h - img_w) / 2 + img_w;
        //                            $("#previewAva").attr("src", picurl).css({
        //                                "position": "absolute",
        //                                "clip": "rect(" + y1 + "px 0px" + y2 + "px " + img_w + "px)"
        //                            });
        //                        }
        //                        //显示
        //                        $("#previewAva").show();
                            }
    </script>