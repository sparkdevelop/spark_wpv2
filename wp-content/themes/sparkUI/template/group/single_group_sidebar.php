<?php
/**
 * Created by PhpStorm.
 * User: zhangxue
 * Date: 17/6/28
 * Time: 下午2:46
 */
    //判断当前组的发布任务是只有管理员还是所有人都可以
    $group_id = isset($_GET['id']) ? $_GET['id'] : "";
    $group = get_group($group_id)[0];
    function saveToken($user_id){
        global $wpdb;
        $sql = "SELECT token FROM wp_token WHERE id=$user_id and t_type='user'";
        $token = $wpdb->get_results($sql,'ARRAY_A')[0]['token'];
        return $token;
    }
?>
    <script src="//cdn.ronghub.com/RongIMLib-2.2.8.min.js"></script>
    <!-- <script src="./libs/RongEmoji.js"></script> -->
    <script src="//cdn.ronghub.com/RongEmoji-2.2.6.min.js"></script>

    <script src="<?php bloginfo("template_url")?>/template/group/im/libs/utils.js"></script>
    <script src="<?php bloginfo("template_url")?>/template/group/im/libs/qiniu-upload.js"></script>

    <script src="<?php bloginfo("template_url")?>/template/group/im/template.js"></script>
    <script src="<?php bloginfo("template_url")?>/template/group/im/emoji.js"></script>
    <script src="<?php bloginfo("template_url")?>/template/group/im/im.js"></script>
    <div id="rcs-app"></div>
    <script>
        /*
         具体使用时：
         1：切换到自己的 key 和 token
         2：移除 im.js 里的 sendTextMessage(instance); 这行代码
         3：自行二次开发
         4：参考
         - 用户数据处理 http://support.rongcloud.cn/kb/NjQ5
         - 消息状态 http://support.rongcloud.cn/kb/NjMz
         - 集成指南 https://rongcloud.github.io/websdk-demo/integrate/guide.html
         - 其他 demo https://github.com/rongcloud/websdk-demo
         */
        (function(){
            var storage=window.localStorage;
            storage.removeItem("rctoken");
            var appKey = "82hegw5u8y3bx";
            var token = localStorage.getItem("rctoken"); //获取a的值
            if (token == null){
                token = '<?=saveToken(get_current_user_id())?>';
                localStorage.setItem("rctoken","gA9grfnhT4LnOVvuVRcK4pHrBPVEyM3UzgxIS2/6eJug9uAII/MGIXDGHAw1YIhGABxVJJsHAbn7T588cFsjIA==");
            }
            RCS.init({
                appKey: appKey,
                token: token,
                target: document.getElementById('rcs-app'),
                showConversitionList: true,
                templates: {
                    button: '<div class="rongcloud-consult rongcloud-im-consult">'+
                            '   <button onclick="RCS.showCommon()"><span class="rongcloud-im-icon">进入群聊</span></button>'+
                            '</div>'+
                            '<div class="customer-service" style="display: none;"></div>'    //"templates/button.html",
//
//                     button:"im/templates/button.html",
//                     chat: "im/templates/chat.html",
//                     closebefore: 'im/templates/closebefore.html',
//                     conversation: 'im/templates/conversation.html',
//                     endconversation: 'im/templates/endconversation.html',
//                     evaluate: 'im/templates/evaluate.html',
//                     imageView: 'im/templates/imageView.html',
//                     leaveword: 'im/templates/leaveword.html',
//                     main: 'im/templates/main.html',
//                     message: 'im/templates/message.html',
//                     messageTemplate: 'im/templates/messageTemplate.html',
//                     userInfo: 'im/templates/userInfo.html',
                },
                extraInfo: {
                    // 当前登陆用户信息
                    userInfo: {
                        name: "游客",
                        grade: "VIP"
                    },
                    // 产品信息
                    requestInfo: {
                        productId: "123",
                        referrer: "10001",
                        define: "" // 自定义信息
                    }
                }
            });
        })()


    </script>












<?php
    if($group['task_permission'] == 'all'){
        setcookie('group_id',$group_id);
        require "single_group_join_sidebar.php";
    }else{
        if(is_group_admin($group_id)){
            setcookie('group_id',$group_id);
            require "single_group_join_sidebar.php";
        }else{
            require "single_group_unjoin_sidebar.php";
        }
    }
