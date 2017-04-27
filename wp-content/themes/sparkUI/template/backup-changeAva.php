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