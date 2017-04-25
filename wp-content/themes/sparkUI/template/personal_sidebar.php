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
        </div>
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


                //            var Avatar = document.getElementById("avatar");
                //            Avatar.onmouseover= preChangeAvatar;
                //            Avatar.onmouseout = cancelChangeAvatar;
                ////            $('#avatar').on('click', '#changeAva', function() {
                ////                alert("change");
                ////            });
                //            function preChangeAvatar() {
                //                <?php //$url=get_template_directory_uri()."/img/changeAvatar.png";?>
                //                Avatar.innerHTML = "<input type=\"button\" id=\"changeAva\" value=\"changeAva\" onclick=\"changeAvatar()\">";
                ////                    "<img src=\"<?////=$url?>////\" class=\"avatar\" id=\"changeAva\">";
                ////                    " <input type='file' name='simple-local-avatar' id='simple-local-avatar'/>"+
                ////                changeAva.onclick = changeAvatar;
                ////                var changeAva =Avatar.getElementById("changeAva");
                ////                changeAva.onclick = changeAvatar;
                ////
                //            }
                //            function cancelChangeAvatar() {
                //                Avatar.innerHTML = "<?php //echo get_avatar($current_user->ID,100);?>//";
                //            }

            </script>
        </form>









        <p style="font-size: large;margin-top: 20px"><?php echo $current_user->data->display_name;?></p>
        <p style="margin-top: 10px;color: gray"><?php echo $user_description;?></p>
    </div>
    <div style="height: 1px;background-color: lightgray;"></div>
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
