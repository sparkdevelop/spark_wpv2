<?php
/*
Plugin Name:  Custom User Register
Plugin URI: http://www.ludou.org/wordpress-ludou-custom-user-register.html
Description: 修改默认的后台用户注册表单，用户可以自行输入密码，不必用Email接收密码，跳过Email验证。用户可自行选择注册的身份角色。带有验证码功能，防止恶意注册。
Version: 3.0
Author: Ludou
*/

if (!isset($_SESSION)) {
 	session_start();
	session_regenerate_id(TRUE);
}

/**
 * 后台注册模块，添加注册表单,修改新用户通知。
 */
if ( !function_exists('wp_new_user_notification') ) :
/**
 * Notify the blog admin of a new user, normally via email.
 *
 * @since 2.0
 *
 * @param int $user_id User ID
 * @param string $plaintext_pass Optional. The user's plaintext password
 */
function wp_new_user_notification($user_id, $plaintext_pass = '', $flag='') {
	if(func_num_args() > 1 && $flag !== 1)
		return;

	$user = new WP_User($user_id);

	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);

	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$message  = sprintf(__('New user registration on your site %s:'), $blogname) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
	$message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";

	@wp_mail(get_option('admin_email'), sprintf(__('[%s] New User Registration'), $blogname), $message);
	
	if ( empty($plaintext_pass) )
		return;

	// 你可以在此修改发送给用户的注册通知Email
	$message  = sprintf(__('Username: %s'), $user_login) . "\r\n";
	$message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n";
	$message .= '登陆网址: ' . wp_login_url() . "\r\n";

	// sprintf(__('[%s] Your username and password'), $blogname) 为邮件标题
	wp_mail($user_email, sprintf(__('[%s] 你的用户名和密码'), $blogname), $message);
    //让邮件支持html
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );
    function set_html_content_type() {
        return 'text/html';
    }
}
endif;
add_filter( 'send_password_change_email', '__return_false' );//禁用密码修改邮件通知 防止初次注册误导

//修改发件人为网站的名称
function new_from_name($email){
    $wp_from_name = get_option('blogname');
    return $wp_from_name;
}
add_filter('wp_mail_from_name', 'new_from_name');

//重置密码邮件修改
function reset_password_message( $message, $key ) {
    if ( strpos($_POST['user_login'], '@') ) {
        $user_data = get_user_by('email', trim($_POST['user_login']));
    } else {
        $login = trim($_POST['user_login']);
        $user_data = get_user_by('login', $login);
    }
    $user_login = $user_data->user_login; $msg = __('有人要求重设如下帐号的密码：'). "\r\n\r\n";
    $msg .= network_site_url() . "\r\n\r\n"; $msg .= sprintf(__('用户名：%s'), $user_login) . "\r\n\r\n";
    $msg .= __('若这不是您本人要求的，请忽略本邮件，一切如常。') . "\r\n\r\n";
    $msg .= __('要重置您的密码，请打开下面的链接：'). "\r\n\r\n";
    $msg .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') ;
    return $msg;
}
add_filter('retrieve_password_message', reset_password_message, null, 2);


/* 修改注册表单 */
function ludou_show_password_field() {
	define('LCR_PLUGIN_URL', plugin_dir_url( __FILE__ ));
	$ip = $_SERVER['REMOTE_ADDR'];
?>
<style type="text/css">
<!--
#user_role {
  padding: 2px;
  -moz-border-radius: 4px 4px 4px 4px;
  border-style: solid;
  border-width: 1px;
  line-height: 15px;
}

#user_role option {
	padding: 2px;
}
.captcha_button {
    height: 40px;
    background-color: #f0ad4e;
    -moz-box-shadow: 5px 5px 5px #ffd8cc;
    box-shadow: 5px 5px 5px #ffd8cc;
    text-align: center;
    font-size: medium;
    margin: 10px 0 15px 0;
    border-radius: 5px;
}
.captcha_button > a, .captcha_button > a:hover {
    display: block;
    height: 100%;
    line-height: 48px;
    width: 100%;
    color: white;
    text-decoration: none;
    cursor: pointer;
}
-->
</style>
    <script>
        window.callback = function(res){
            //console.log(res);
            // res（未通过验证）= {ret: 1, ticket: null}
            // res（验证成功） = {ret: 0, ticket: "String", randstr: "String"}
            if(res.ret === 0){
                //alert(res.ticket);  // 票据
                //alert("<?php echo $ip?>");
                var data = {
                    action: "captcha_ticket_verify",
                    aid: "2064745456",
                    AppSecretKey:"0gYKXqR_JlcD_v9YtKyF97w**",
                    Ticket:res.ticket,
                    Randstr:res.randstr,
                    UserIP:"<?php echo $ip?>"
                };
                jQuery.ajax({
                    type: "POST",
                    url:"<?=admin_url('admin-ajax.php');?>",//你的请求程序页面
                    data: data,//请求需要发送的处理数据
                    dataType: 'json',
                    success: function (msg) {
                        var judge = "1";
                       if(msg.response === judge){
                            jQuery("#captcha").val(msg.err_msg);
                        }else{
                           alert("验证失败");
                       }
                     /*console.log(msg);
                     console.log(typeof msg);
                     console.log(typeof msg.response);
                     console.log(msg.err_msg);*/
                    },
                    error: function () {
                        alert("error");
                    }
                });
            }
        }
    </script>
<!--<p>
	<label for="user_nick">昵称<br/>
		<input id="user_nick" class="input" type="text" size="25" value="<?php /*echo empty($_POST['user_nick']) ? '':$_POST['user_nick']; */?>" name="user_nick" />
	</label>
</p>-->
<p>
	<label for="user_pwd1">密码(至少6位)<br/>
		<input id="user_pwd1" class="input" type="password" size="25" value="" name="user_pass" />
	</label>
</p>
<p>
	<label for="user_pwd2">重复密码<br/>
		<input id="user_pwd2" class="input" type="password" size="25" value="" name="user_pass2" />
	</label>
</p>
<!--<p style="margin:0 0 10px;">
	<label>用户身份:
		<select name="user_role" id="user_role">
			<option value="subscriber" <?php /*if(!empty($_POST['user_role']) && $_POST['user_role'] == 'subscriber') echo 'selected="selected"';*/?>>订阅者</option>
			<option value="contributor" <?php /*if(!empty($_POST['user_role']) && $_POST['user_role'] == 'contributor') echo 'selected="selected"';*/?>>投稿者</option>
		</select>
	</label>
	<br />
</p>-->
<!--<p>
	<label for="CAPTCHA">验证码:<br />
		<input id="CAPTCHA" style="width:110px;*float:left;" class="input" type="text" size="10" value="" name="captcha_code" />
		看不清？<a href="javascript:void(0)" onclick="document.getElementById('captcha_img').src='<?php /*echo constant("LCR_PLUGIN_URL"); */?>/captcha/captcha.php?'+Math.random();document.getElementById('CAPTCHA').focus();return false;">点击更换</a>
	</label>
</p>
<p>
	<label>
	<img id="captcha_img" src="<?php /*echo constant("LCR_PLUGIN_URL"); */?>/captcha/captcha.php" title="看不清?点击更换" alt="看不清?点击更换" onclick="document.getElementById('captcha_img').src='<?php /*echo constant("LCR_PLUGIN_URL"); */?>/captcha/captcha.php?'+Math.random();document.getElementById('CAPTCHA').focus();return false;" />
	</label>
</p>-->
<input id="captcha" name="captcha_code" style="display: none" value="">
        <div class="captcha_button"><a id="TencentCaptcha"
                data-appid="2064745456"
                data-cbfn="callback"
            >点击验证</a></div>

<?php
}

/* 处理表单提交的数据 */
function ludou_check_fields($login, $email, $errors) {
	/*if(empty($_POST['captcha_code'])
		|| empty($_SESSION['ludou_lcr_secretword'])
		|| (trim(strtolower($_POST['captcha_code'])) != $_SESSION['ludou_lcr_secretword'])
		) {
		$errors->add('captcha_spam', "<strong>错误</strong>：验证码不正确");
	}
	unset($_SESSION['ludou_lcr_secretword']);*/
    if (!isset($_POST['captcha_code']) || trim($_POST['captcha_code']) == '' ||trim($_POST['captcha_code']) != 'OK')
        $errors->add('captcha_need', "<strong>错误</strong>：请进行验证");


/*	if (!isset($_POST['user_nick']) || trim($_POST['user_nick']) == '')
	  $errors->add('user_nick', "<strong>错误</strong>：昵称必须填写");*/
	  
	if(strlen($_POST['user_pass']) < 6)
		$errors->add('password_length', "<strong>错误</strong>：密码长度至少6位");
	elseif($_POST['user_pass'] != $_POST['user_pass2'])
		$errors->add('password_error', "<strong>错误</strong>：两次输入的密码必须一致");

	/*if($_POST['user_role'] != 'contributor' && $_POST['user_role'] != 'subscriber')
		$errors->add('role_error', "<strong>错误</strong>：不存在的用户身份");*/
}

/* 保存表单提交的数据 */
function ludou_register_extra_fields($user_id, $password="", $meta=array()) {
	$userdata = array();
	$userdata['ID'] = $user_id;
	$userdata['user_pass'] = $_POST['user_pass'];
//	$userdata['role'] = $_POST['user_role'];
//  $userdata['nickname'] = str_replace(array('<','>','&','"','\'','#','^','*','_','+','$','?','!'), '', $_POST['user_nick']);
  
	$pattern = '/[一-龥]/u';
  if(preg_match($pattern, $_POST['user_login'])) {
    $userdata['user_nicename'] = $user_id;
  }
  
	wp_new_user_notification( $user_id, $_POST['user_pass'], 1 );
	wp_update_user($userdata);
}

function remove_default_password_nag() {
	global $user_ID;
	delete_user_setting('default_password_nag', $user_ID);
	update_user_option($user_ID, 'default_password_nag', false, true);
}

function ludou_register_change_translated_text( $translated_text, $untranslated_text, $domain ) {
  if ( $untranslated_text === 'A password will be e-mailed to you.' )
    return '';
  else if ($untranslated_text === 'Registration complete. Please check your e-mail.')
    return '注册成功！';
  else
    return $translated_text;
}

add_filter('gettext', 'ludou_register_change_translated_text', 20, 3);
add_action('admin_init', 'remove_default_password_nag');
add_action('register_form','ludou_show_password_field');
add_action('register_post','ludou_check_fields',10,3);
add_action('user_register', 'ludou_register_extra_fields');

?>