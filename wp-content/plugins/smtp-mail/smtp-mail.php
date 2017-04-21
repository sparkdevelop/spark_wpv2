<?php
/**
 * Plugin Name: SMTP发送邮件
 * Plugin URI:  http://www.wordpressKT.com
 * Description: 使用已有的邮箱帐号（如，qq邮箱、163邮箱）发送邮件
 * Author:      凌风
 * Author URI:  http://www.wordpressKT.com
 * Version:     1.0
 */
if (!function_exists('get_option')) {
  header('HTTP/1.0 403 Forbidden');
  die;  //禁止直接访问
}

//定义常量
define('SMTP_PLUGIN_FILE', basename(__FILE__));
define('SMTP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SMTP_PLUGIN_BASE_NAME', plugin_basename(__FILE__));

/*后台界面*/
//创建设置页面
function lf_add_smtp_page(){
    add_options_page(
            'SMTP邮件发送设置', 
            'SMTP邮件发送设置', 
            'activate_plugins', 
            'settings-'.SMTP_PLUGIN_FILE,
            'lf_smtp_page_display'
    );
}
add_action('admin_menu','lf_add_smtp_page');
//用于显示页面内容的回调函数
function lf_smtp_page_display() {
    require SMTP_PLUGIN_PATH.'smtp-options.php';
}
//给SMTP页面注册新的settings，用于自动保存
add_action('admin_init','lf_smtp_settings');
function lf_smtp_settings(){
    add_settings_section('smtp-settings', 'SMTP发件设置', 'lf_smtp_sec_html', 'settings-'.SMTP_PLUGIN_FILE);
    #SMTP服务器
    add_settings_field('smtp-host', 'SMTP服务器', 'lf_smtp_host_html', 'settings-'.SMTP_PLUGIN_FILE, 'smtp-settings');
    #SMTP安全方式
    add_settings_field('smtp-secure', 'SMTP安全方式', 'lf_smtp_secure_html', 'settings-'.SMTP_PLUGIN_FILE, 'smtp-settings');
    #SMTP端口号
    add_settings_field('smtp-port', 'SMTP端口号', 'lf_smtp_port_html', 'settings-'.SMTP_PLUGIN_FILE, 'smtp-settings');
    #SMTP发件帐号
    add_settings_field('smtp-account', 'SMTP邮箱帐号', 'lf_smtp_account_html', 'settings-'.SMTP_PLUGIN_FILE, 'smtp-settings');
    #SMTP发件帐号密码
    add_settings_field('smtp-pwd', 'SMTP邮箱密码', 'lf_smtp_pwd_html', 'settings-'.SMTP_PLUGIN_FILE, 'smtp-settings');
    register_setting('settings-'.SMTP_PLUGIN_FILE, 'lf_smtp_opts');
}
function lf_smtp_sec_html(){}
function lf_smtp_host_html(){
    $values = get_option('lf_smtp_opts');
    $html = "<input size='45' id='smtp-host' type='text' name='lf_smtp_opts[smtp_host]' value='{$values[smtp_host]}' />";
    $html .= "<p>例如，smtp.163.com（163邮箱）， smtp.qq.com（QQ邮箱）</p>";
    echo $html;
}
function lf_smtp_secure_html(){
    $values = get_option('lf_smtp_opts');   
    if ($values['smtp_secure'] == 0) {
        $secure_1 = "checked='checked'";
    }else if($values['smtp_secure'] == 1){
        $secure_2 = "checked='checked'";
    }else if($values['smtp_secure'] == 2){
        $secure_3 = "checked='checked'";
    }
    $html = "<input type='radio' name='lf_smtp_opts[smtp_secure]' {$secure_1}  value='0' />无&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $html .= "<input type='radio' name='lf_smtp_opts[smtp_secure]' {$secure_2} value='1' />ssl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $html .= "<input type='radio' name='lf_smtp_opts[smtp_secure]' {$secure_3} value='2' />tls&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $html .= "<p>选择ssl或tls，需要服务器支持ssl加密</p>";
    echo $html;
}
function lf_smtp_port_html(){
    $values = get_option('lf_smtp_opts'); 
    $html = "<input size='45' id='smtp-port' type='text' name='lf_smtp_opts[smtp_port]' value='{$values[smtp_port]}' />";
    $html .= "<p>1、如果安装方式选为“无”，则端口号为25；选择ssl或tls，则端口好为465或587,具体情况请咨询邮件服务商</p>";
    $html .= "<p>2、163邮箱具体设置为：安全方式选择为“无”，则端口号为25；安装方式选择为“tls”，端口号为587</p>";
    $html .= "<p>3、QQ邮箱具体设置为：安装方式为“无”，则无法正常发送邮件；安装方式选择为“ssl”，则端口号为465</p>";
    echo $html;    
}
function lf_smtp_account_html(){
    $values = get_option('lf_smtp_opts'); 
    $html = "<input size='45' id='smtp-port' type='text' name='lf_smtp_opts[smtp_account]' value='{$values[smtp_account]}' />";
    $html .= "<p>填写用于发信的邮箱帐号，如xxx@163.com </p>";
    echo $html;    
}
function lf_smtp_pwd_html(){
    $values = get_option('lf_smtp_opts'); 
    $html = "<input size='45' id='smtp-port' type='password' name='lf_smtp_opts[smtp_pwd]' value='{$values[smtp_pwd]}' />";
    $html .= "<p>注意：这里的密码和你邮箱帐号密码，可能并不相同。 </p>";
    $html .= "<p>出于安全考虑，163邮箱和QQ邮箱，都需要单独设定SMTP发件密码。其他邮箱未做测试</p>";
    echo $html;     
}

/*邮件发送*/
function my_way_mail($phpmailer){
    $smtp_opts = get_option('lf_smtp_opts');
    $phpmailer->isSMTP();                                       //使用SMTP方式发送邮件
    $phpmailer->Host = $smtp_opts['smtp_host'];                  //设置SMTP服务器
    $phpmailer->SMTPAuth = true;                        //使用SMTP发送邮件需要验证码？true：需要
    switch ($smtp_opts['smtp_secure']) {
        case 0:
            $phpmailer->SMTPSecure = ''; 
            break;
        case 1:
            $phpmailer->SMTPSecure = 'ssl';
            break;
        case 2:
            $phpmailer->SMTPSecure = 'tls';
            break;
    }   
    $phpmailer->port = $smtp_opts['smtp_port'];              //邮件发送端口，和安全方式对应：25, 465, 587
    $phpmailer->Username = $smtp_opts['smtp_account'];       //设置发送邮件账户的地址
    $phpmailer->Password = $smtp_opts['smtp_pwd'];             //设置发送邮件账户的密码
    $phpmailer->From = $smtp_opts['smtp_account'];           //设置发件人账户信息
}
add_action('phpmailer_init','my_way_mail');

/*提醒用户设置*/
add_filter('plugin_action_links_'. SMTP_PLUGIN_BASE_NAME, 'lf_smtp_action_links', 10, 1);
function lf_smtp_action_links($links){
    $settings_link = "<a href='options-general.php?page=settings-" . SMTP_PLUGIN_FILE . "'>设置</a>";
    array_unshift($links, $settings_link);
    return $links;
    
}
