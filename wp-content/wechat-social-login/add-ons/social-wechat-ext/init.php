<?php 
if (! defined ( 'ABSPATH' ))
    exit (); // Exit if accessed directly
require_once 'abstract-xh-add-ons-api.php';
require_once XH_SOCIAL_DIR.'/includes/class-xh-helper.php';
/**
 * 微信登录
 * 
 * @author ranj
 * @since 1.0.0
 */
class XH_Social_Add_On_Social_Wechat_Ext extends Abstract_XH_Social_Add_Ons_Wechat_Ext_Api{
    /**
     * The single instance of the class.
     *
     * @since 1.0.0
     * @var XH_Social_Add_On_Social_Wechat_Ext
     */
    private static $_instance = null;
    /**
     * 插件目录
     * @var string
     * @since 1.0.0
     */
    public $dir;
    
    /**
     * Main Social Instance.
     *
     * @since 1.0.0
     * @static
     * @return XH_Social_Add_On_Social_Wechat_Ext
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    protected function __construct(){
        $this->id='wechat_social_add_ons_social_wechat_ext';
        $this->title=__('Wechat Senior Extension',XH_SOCIAL);
        $this->description=__('无需开发者认证，微信登录自动关注微信公众号。',XH_SOCIAL);
        $this->version='1.1.1';
        
        $this->min_core_version = '1.1.6';
        $this->author=__('xunhuweb',XH_SOCIAL);
        $this->author_uri='https://www.wpweixin.net';
        $this->plugin_uri="https://www.wpweixin.net/product/1135.html";
        $this->depends['add_ons_social_wechat']=array(
            'title'=>__('Wechat',XH_SOCIAL)
        );
        
        $this->dir= rtrim ( trailingslashit( dirname( __FILE__ ) ), '/' );
        parent::__construct();
        
        $this->init_form_fields();
        $this->enabled = 'yes'==$this->get_option('enabled');
    }
    
    
    
    //兼容红包等支付插件，跨域的调用
    public function get_option($key, $empty_value = null){
        if($key=='enabled_cross_domain'){
            $enabled =XH_Social_Channel_Wechat::instance()->get_option('mp_enabled_cross_domain',$empty_value);
            return $enabled=='mp_cross_domain_enabled'?'cross_domain_enabled':'cross_domain_disabled';
        }
    
        if($key=='cross_domain_url'){
            return XH_Social_Channel_Wechat::instance()->get_option('mp_cross_domain_url',$empty_value);
        }
    
        return parent::get_option($key,$empty_value);
    }
    
    public function on_update($old_version){
        if(version_compare($old_version,'1.0.2','<' )){
            try {
                $db = new XH_Social_Channel_Wechat_Model_Ext();
                $db->on_version_102();
            } catch (Exception $e) {
                XH_Social::instance()->WP->wp_die($e->getMessage());
            }
        }
        
        if(version_compare($old_version,'1.0.3','<' )){
            $auto_login = $this->get_option('auto_login');
            if($auto_login==2){
                $this->update_option('auto_login', 1);
            }
        }
    }
    public function on_install(){
        $api = new XH_Social_Channel_Wechat_Model_Ext();
        $api->init();
        $this->init_page_qrcode();
    }
    
    public function on_load(){
        $this->m1();
    }
    
    public function xh_social_share_content(){
        if(!XH_Social_Helper_Uri::is_wechat_app()){return;}
        $api = XH_Social::instance()->channel->get_social_channel('social_wechat');
        if(!$api){
            return;
        }
        
        $channel_share_enableds = XH_Social_Settings_Default_Other_Share::instance()->get_option('share');
       
        if(!$channel_share_enableds||!is_array($channel_share_enableds)||!in_array($api->id, $channel_share_enableds)){
            return;
        }
        
        //判断当前用户有没有启用跨域，跨域无法在二级网站进行分享
        if($api->get_option('mp_enabled_cross_domain')=='mp_cross_domain_enabled'){
            return;
        }

        global $wp_query;
        $img_url = $wp_query->post? get_the_post_thumbnail_url($wp_query->post,array(300,300)):null;
        $title = $wp_query->post?$wp_query->post->post_title:null;
        $desc =  $wp_query->post?$wp_query->post->post_excerpt:null;
       
        
        $appid =$api ->get_option('mp_id');
        $appsecret =$api ->get_option('mp_secret');
        require_once 'includes/class-wechat-token.php';
        $token_api = new XH_Social_Wechat_Token($appid,$appsecret);
        
        try {
            $ticket = $token_api->jsapi_ticket();
            if($ticket instanceof XH_Social_Error){
                return;
            }
            $url = XH_Social_Helper_Uri::get_location_uri();
            
            $timestamp = time();
            $nonceStr = str_shuffle(time());
            $string = "jsapi_ticket=$ticket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";         
            $signature = sha1($string);
            
            $signPackage = array(
                "appId"     => $appid,
                "nonceStr"  => "$nonceStr",
                "timestamp" => "$timestamp",
                "url"       => $url,
                "signature" => $signature,
                "rawString" => $string
            );
            ?>
            <script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
            <script type="text/javascript">
                wx.config({
                    //debug: true,
                    appId: '<?php echo $signPackage["appId"];?>',
                    timestamp: '<?php echo $signPackage["timestamp"];?>',
                    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
                    signature: '<?php echo $signPackage["signature"];?>',
                    jsApiList: [
                      // 所有要调用的 API 都要加到这个列表中
                      'onMenuShareTimeline',
                	  'onMenuShareAppMessage',
                	  'onMenuShareQQ',
                	  'onMenuShareWeibo',
                	  'onMenuShareQZone'
                    ]
                  });
                  wx.ready(function () {
					  var img_url = '<?php echo $img_url;?>';
                      if(!img_url){
                          if(jQuery){  
                          	jQuery('img').each(function(){
								var $img = $(this);
								if($img.attr('src')){
									img_url=$img.attr('src');
									return false;
								}
                            });
                          }
                      }
                      var title="<?php echo esc_attr($title)?>";
                      var desc="<?php echo esc_attr($desc)?>";
                      if(!title){title = jQuery('title').text();}

                      
                      if(!desc){
                          var $desc =jQuery('meta[name=description]');
                    	  desc =  $desc.length>0? $desc.attr('content'):null;
                    	  if(!desc){desc =title;}
                      }
                      var share = {
                    		  title:title,
                    		  link:'<?php echo esc_attr($url)?>',
                    		  desc:desc,
                    		  imgUrl:img_url,
                    		  type:'link',
                    		  success: function () { 
                          	       // 用户确认分享后执行的回调函数
                          	  },
                          	  cancel: function () { 
                          	        // 用户取消分享后执行的回调函数
                          	  }
                      };
                	  wx.onMenuShareTimeline(share);
                	  wx.onMenuShareAppMessage(share);
                	  wx.onMenuShareQQ(share);
                	  wx.onMenuShareWeibo(share);
                	  wx.onMenuShareQZone(share);
                  });
			</script>
            <?php 
            
        } catch (Exception $e) {
            XH_Social_Log::error($e);
        }
    }
    
    private function checkSignature()
    {
        //先获取到这三个参数
        $signature = $_GET['signature'];
        $nonce = $_GET['nonce'];
        $timestamp = $_GET['timestamp'];
    
        //把这三个参数存到一个数组里面
        $tmpArr = array($timestamp,$nonce,$this->get_option('token'));
        //进行字典排序
        sort($tmpArr);
    
        //把数组中的元素合并成字符串，impode()函数是用来将一个数组合并成字符串的
        $tmpStr = implode($tmpArr);
    
        //sha1加密，调用sha1函数
        $tmpStr = sha1($tmpStr);
        //判断加密后的字符串是否和signature相等
        if($tmpStr == $signature)
        {
            return true;
        }
        return false;
    }
    
    public function on_wechat_service_load(){
        ob_clean();
        header("Content-Type:text/html; charset=utf-8");
        
        //此处不做
        if(isset($_GET["echostr"])
            &&isset($_GET['signature'])
            &&isset($_GET['nonce'])
            &&isset($_GET['timestamp'])){
            if($this->checkSignature()){
               
                echo $_GET["echostr"];
                exit;
            }
        }
       
        require_once 'includes/class-wechat-msg-receive.php';
        $api = XH_Social_Channel_Wechat::instance();
        $event =new XH_Social_Wechat_Event(
            $api->get_option('mp_id'),
            $api->get_option('mp_secret'),
            $this->get_option('token'),
            $this->get_option('EncodingAESKey'));
        $event->hook();
    }
    
    public function on_init(){
       $this->m2();
    }
    
    /**
     * 
     * @param array $data
     * @param XH_Social_Wechat_Event $handler
     */
    public function wechat_receive_event($data,$handler){
        if(!isset($data['Event'])){
            return;
        }
     
        switch ($data['Event']){
            case 'subscribe':
               
                if(isset($data['EventKey'])&&!empty($data['EventKey'])){
                    $this->on_scan_qrcode_subscribe($handler,$data['EventKey'],$data['FromUserName']);
                }
        
                do_action('xh_social_channel_wechat_receive_event_subscribe',$data,$handler);
                break;
            case 'SCAN':
               
                if(isset($data['EventKey'])&&!empty($data['EventKey'])){
                    $this->on_scan_qrcode_subscribe($handler,$data['EventKey'],$data['FromUserName']);
                }
                
                do_action('xh_social_channel_wechat_receive_event_scan',$data,$handler);
                break;
        }
    }
    
    private function on_scan_qrcode_subscribe($handler,$uid,$openid){
        if(empty($uid)){
            return;
        }
        if(strpos($uid, 'qrscene_')===0){
            $uid = substr($uid,8 );
        }
        
        $api =XH_Social_Channel_Wechat::instance(); 
        $user_handler = new XH_Social_Wechat_User($api->get_option('mp_id'),$api->get_option('mp_secret'));
        $user_info = $user_handler->get_user($openid);
        if($user_info instanceof XH_Social_Error){
            $user_info = array(
                'openid'=>$openid
            );
        }
    
        try {
            global $wpdb;
            $queue =$wpdb->get_row($wpdb->prepare(
               "select id,
                       user_id
                from {$wpdb->prefix}xh_social_channel_wechat_queue
                where id=%s
                limit 1;", $uid));
    
            if(!$queue){
                return;
            }
            
            $ext_user_id = XH_Social_Channel_Wechat::instance()->create_ext_user_info('mp',$user_info,$queue->user_id, XH_Social_Helper_String::guid());
         
            $wpdb->update("{$wpdb->prefix}xh_social_channel_wechat_queue", array(
                'ext_user_id'=>$ext_user_id
            ), array(
                'id'=>$uid
            ));
    
            if(!empty($wpdb->last_error)){
                throw new Exception($wpdb->last_error,500);
            }
        } catch (Exception $e) {
            XH_Social_Log::error($e);
            $msg =$e->getMessage();
            if($e->getCode()==500){
                $msg= XH_Social_Error::err_code(500)->errmsg;
            }
            $handler->response($msg);
            exit;
        }
    }
    
    public function on_subscribe($data,$handler){
        $handler->response($this->get_option('welcome_msg'));
        exit;
    }
    
    public function hook_wechat_login(){
       if(!isset($_GET['x'])){
           return;
       } 
     
       
       $x = $_GET['x'];
       $len =strlen($x);
       if($len<=6){
           return;
       }
       
       $uid = substr($x, 0,$len-6);
       $h = substr($x, $len-6);
       
       $hash = XH_Social_Helper::generate_hash(array(
           'uid'=>$uid
       ), XH_Social::instance()->get_hash_key()); 
       if(substr($hash, 6,6)!=$h){
           return;
       }
     
       global $wpdb;
       $ext_mp_user =$wpdb->get_row($wpdb->prepare(
                   "select *
                    from {$wpdb->prefix}xh_social_channel_wechat_queue
                    where id=%s
                    limit 1;", $uid));
      
       if(!$ext_mp_user||empty($ext_mp_user->uid)){
           XH_Social::instance()->WP->wp_die(XH_Social_Error::err_code(404)->errmsg);
           exit;
       }
      
       //如果手机页面已有用户登录，且不是桌面用户，那么退出登录
        $wp_user_id = $ext_mp_user->user_id?$ext_mp_user->user_id:0;
        if(
            //wp_user_id>0 且登录用户id不等于wp_user_id
            ($wp_user_id>0&&is_user_logged_in()&&$wp_user_id!=get_current_user_id())
            ||
            //已登录的情况
            $wp_user_id<=0&&is_user_logged_in()
            ){
            
            if(isset($_GET['social_logout'])){
                wp_redirect(wp_logout_url(XH_Social_Helper_Uri::get_location_uri()));
                exit;
            }
            wp_logout();
            
            $params = array();
            $url = XH_Social_Helper_Uri::get_uri_without_params(XH_Social_Helper_Uri::get_location_uri(),$params);
            $params['social_logout']=1;
            wp_redirect($url."?".http_build_query($params));
            exit;
        }
    
       $redirect_uri =XH_Social_Channel_Wechat::instance()->login_get_wechatclient_authorization_uri($ext_mp_user->user_id,$ext_mp_user->uid); 
       wp_redirect($redirect_uri);
       exit;
    }
    
    public function add_menus($menus){
        $menus[]=$this;
        return $menus;
    }
    
    public function init_form_fields(){
        $fields = array();
        $fields['enabled']=array(
                'title' => __ ( 'Enable/Disable', XH_SOCIAL ),
                'type' => 'checkbox',
                'label' => __ ( 'Enable wechat extension', XH_SOCIAL ),
                'default' => 'yes'
        );
        
        $fields['page_qrcode']=array(
            'title'=>__('Qrcode Page',XH_SOCIAL),
            'type'=>'select',
            'func'=>true,
            'options'=>array($this,'get_page_options')
        );
        
        $fields['auto_login']= array (
            'title' => __ ( 'Auto Login', XH_SOCIAL ),
            'type' => 'select',
            'options'=>array(
                0=> __('Disabled',XH_SOCIAL),
                1=> __('Enable wechat auto login in wechat client',XH_SOCIAL),
                //2=> __('Enable wechat auto login in wechat client,desktop forbidden.',XH_SOCIAL),
            ),
            'description'=>__('仅对(home、category(tag)、author、single post)页面进行登录检查(避免不可预测的错误)。',XH_SOCIAL)
        );
        
        $fields['enabled_ip_check']=array(
            'title'=>__('Enabled IP Check',XH_SOCIAL),
            'type'=>'checkbox',
            'description'=>__('在扫描二维码登录时，匹配用户ip增强安全性(网站启用了CDN，请不要开启此项)')
        );
        
        $fields['subtitle1']=array(
            'title'=>__('Login Settings',XH_SOCIAL),
            'type'=>'subtitle'
        );
        
        $fields['login_type']=array(
            'title'=>__('Login Model',XH_SOCIAL),
            'type'=>'section',
            'options'=>array(
               'none'=>__('Model one',XH_SOCIAL),
                0=>__('Model two',XH_SOCIAL),
                1=>__('Model three',XH_SOCIAL),
            ),
            'description'=>__('模式一：桌面端<b>(开放平台API)</b>扫码登录，移动端<b>(公众平台API)</b>网页授权登录。<br/>
                                                                                             模式二：<b>(公众平台API)</b>手机扫描桌面登录二维码后，桌面端自动登录，移动端自动登录且进入网站。<br/>
                                                                                             模式三：<b>(公众平台API)</b>手机扫描桌面登录二维码后，移动端显示关注公众号界面(若已关注，直接进入公众号聊天界面)，(已)关注后，桌面端自动登录。',XH_SOCIAL)
        );
        
        $protocol = (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
        $home_url =  rtrim($protocol.$_SERVER['HTTP_HOST'],'/');
        
        $fields['url1']=array(
            'tr_css'=>'section-login_type section-1',
            'title'=>__('URL',XH_SOCIAL),
            'type'=>'text',
            'default'=>$home_url."/wsocial-wechat-receive.php",
            'disabled'=>'disabled',
            'description'=>sprintf(__('(拷贝文件<code>%s</code>到网站根目录)<br/><a href="https://mp.weixin.qq.com" target="_blank">微信公众平台</a>>基本设置>服务器配置',XH_SOCIAL),'social-wechat-ext/wsocial-wechat-receive.php')
        );
        
        $fields['token']=array(
            'tr_css'=>'section-login_type section-1',
            'title'=>__('Token',XH_SOCIAL),
            'type'=>'text'
        );
        
        $fields['EncodingAESKey']=array(
            'tr_css'=>'section-login_type section-1',
            'title'=>__('EncodingAESKey',XH_SOCIAL),
            'type'=>'text'
        );
        
        $fields['welcome_msg']=array(
            'tr_css'=>'section-login_type section-1',
            'title'=>__('Welcome Message',XH_SOCIAL),
            'placeholder'=>__('optional',XH_SOCIAL),
            'type'=>'textarea'
        );

        $this->form_fields = $fields;
    }
    /**
     * ajax
     * @param array $shortcodes
     * @return array
     * @since 1.0.0
     */
    public function ajax($shortcodes){
        $shortcodes["xh_social_{$this->id}"]=array($this,'do_ajax');
        return $shortcodes;
    }
    
    /**
     * 短代码
     * @param array $shortcodes
     * @return array
     * @since 1.0.0
     */
    public function shortcodes($shortcodes){
        $shortcodes['xh_social_page_wechat_qrcode']=array($this,'page_wechat_qrcode');
        return $shortcodes;
    }
  
    public function do_ajax(){
        ob_clean();
        $tab = isset($_REQUEST['tab'])?$_REQUEST['tab']:'';
    
        switch ($tab){
            case 'service':
                //此处不做
                if(isset($_GET["echostr"])){
                    echo $_GET["echostr"];
                    exit;
                }
                
                require_once 'includes/class-wechat-msg-receive.php';
                $api = XH_Social_Channel_Wechat::instance();      
                $event =new XH_Social_Wechat_Event(
                    $api->get_option('mp_id'),
                    $api->get_option('mp_secret'),
                    $this->get_option('token'),
                    $this->get_option('EncodingAESKey'));
                $event->hook();
                return;
            case 'connect':
                $action ="xh_social_{$this->id}";
                $datas=shortcode_atts(array(
                    'notice_str'=>null,
                    'action'=>$action,
                    $action=>null,
                    'tab'=>null,
                    'time'=>null,
                    'uid'=>null,
                    'uuid'=>null
                ), stripslashes_deep($_REQUEST));
                
                $validate =XH_Social::instance()->WP->ajax_validate($datas,isset($_REQUEST['hash'])?$_REQUEST['hash']:null,true);
                if(!$validate){
                    echo (XH_Social_Error::err_code(701)->to_json());
                    exit;
                }
              
                $wp_user_id = $datas['uuid'];
                if(
                    //wp_user_id>0 且登录用户id不等于wp_user_id
                    ($wp_user_id>0&&is_user_logged_in()&&$wp_user_id!=get_current_user_id())
                    ||
                    //已登录的情况
                    $wp_user_id<=0&&is_user_logged_in()
                    ){
                        wp_logout();
                        echo XH_Social_Error::error_custom(__('Sorry! You have logged in,Refresh the page and try again.',XH_SOCIAL))->to_json();
                        exit;
                }
                
                //已超时访问
                $now = time();
                if(!is_numeric($datas['time'])|| $datas['time']<($now-30*60)||$datas['time']>($now+30*60)){
                    echo (XH_Social_Error::err(701)->to_json());
                    exit;
                }
                
                $uid =$datas['uid'];
                if(empty($uid)){
                    $error = new XH_Social_Error(404,'uid is empty');
                    echo $error->to_json();
                    exit;
                }
                
                global $wpdb;
                $ext_mp_user =$wpdb->get_row($wpdb->prepare(
                   "select *
                    from {$wpdb->prefix}xh_social_channel_wechat_queue
                    where id=%s
                    limit 1;", $uid));
                
                if(!$ext_mp_user){
                    $error = new XH_Social_Error(701,'wechat euque not found');
                    echo $error->to_json();
                    exit;
                }
                
                if($wp_user_id>0&&$wp_user_id!=$ext_mp_user->user_id){
                    //未知错误！！
                    $error = new XH_Social_Error(701,'wechat euque wp_user_id not equals to request data');
                    echo $error->to_json();
                    exit;
                }
                
                if('yes'==$this->get_option('enabled_ip_check')){
                    //检查ip地址是否更改
                    if($ext_mp_user->ip!=$_SERVER["REMOTE_ADDR"]){
                        $error = new XH_Social_Error(500,"invalid ip request");
                        echo $error->to_json();
                        exit;
                    }
                }

                $login_type = $this->get_option('login_type','none');           
                switch ($login_type){
                    //模式二登录
                    case 0:
                        if(empty($ext_mp_user->uid)){
                            $error = new XH_Social_Error(701,'ext_mp_user uid is empty');
                            echo $error->to_json();
                            exit;
                        }
                        
                        $wp_user = XH_Social_Channel_Wechat::instance()->get_wp_user('uid',$ext_mp_user->uid);
                        if(!$wp_user){
                            echo XH_Social_Error::err_code(404)->to_json();
                            exit;
                        }
                        
                        if($wp_user_id>0&&$wp_user->ID!=$wp_user_id){
                            //未知错误！！
                            $error = new XH_Social_Error(701,'logon user_id not equals to request data');
                            echo $error->to_json();
                            exit;
                        }
                        
                        XH_Social::instance()->WP->do_wp_login($wp_user);
                        echo XH_Social_Error::success()->to_json();
                        exit;
                        //模式三登录
                    case 1:
                        global $wpdb;
                        if(!$ext_mp_user->ext_user_id){
                            echo XH_Social_Error::err_code(404)->to_json();
                            exit;
                        }
                        
                        $api = XH_Social_Channel_Wechat::instance();
                        if($wp_user_id>0){
                            $wp_user =$api->get_wp_user_info($ext_mp_user->ext_user_id);
                            if(!$wp_user||$wp_user->ID!=$wp_user_id){
                               //未知错误！！
                                $error = new XH_Social_Error(701,'logon user_id not equals to request data');
                                echo $error->to_json();
                                exit;
                            }
                            
                            XH_Social::instance()->WP->do_wp_login($wp_user);
                            echo XH_Social_Error::success()->to_json();
                            exit;
                        }
                        
                        $redirect_uri = $api->process_login($ext_mp_user->ext_user_id);
                        $error = XH_Social::instance()->WP->get_wp_error($redirect_uri);
                        if(!empty($error)){
                            echo XH_Social_Error::error_custom($error)->to_json();
                            exit;
                        }
                        
                        echo XH_Social_Error::success($redirect_uri)->to_json();
                        exit;
                }
                
        }
    }
    
    public function page_wechat_qrcode($atts=array(), $content=null){
        XH_Social_Temp_Helper::set('atts', array(
            'atts'=>$atts,
            'content'=>$content
        ),'templete');
        
        ob_start();
        if(method_exists(XH_Social::instance()->WP, 'get_template')){
            require XH_Social::instance()->WP->get_template($this->dir, 'account/wechat/qrcode-content.php');
        }else{
            require $this->dir.'/templates/account/wechat/qrcode-content.php';
        }
        return ob_get_clean();
    }
    
    public function wechat_form_fields($fields){
        return $fields;
    }
    
    public function login_get_authorization_uri($redirect_uri,$login_redirect_uri,$state,$uid,$wp_user_id){     
        switch ($state){
            case 'op':
                $login_type = $this->get_option('login_type','none');
                switch ($login_type){
                    default:
                    case 'none':
                        return $redirect_uri;
                    case 0:
                    case 1:
                        $page_qrcode = $this->get_page_qrcode();
                        if(!$page_qrcode){
                            XH_Social::instance()->WP->wp_die(__('wechat qrcode page not found!',XH_SOCIAL));
                        }
                
                        $params = array();
                        $url = XH_Social_Helper_Uri::get_uri_without_params(get_page_link($page_qrcode),$params);
                        
                        $params1=array();
                        $params1['uid'] =$wp_user_id;
                        $params1['notice_str']=str_shuffle(time());
                        $params1['hash'] =XH_Social_Helper::generate_hash($params1 ,XH_Social::instance()->get_hash_key());

                        return $url."?".http_build_query(array_merge($params,$params1));
                }
                break;
        }
        
        return $redirect_uri; 
    }
    
    /**
     * 页面模板
     * @param array $templetes
     * @return array
     * @since 1.0.0
     */
    public function page_templetes($templetes){
        $templetes[$this->dir]['social/account/wechat/qrcode.php']=__('Social - Wechat Qrcode',XH_SOCIAL);
        return $templetes;
    }
    
    /**
     * 获取qrcode page
     * @return WP_Post|NULL
     * @since 1.0.0
     */
    public function get_page_qrcode(){
        $page_id =intval($this->get_option('page_qrcode',0));
    
        if($page_id<=0){
            return null;
        }
    
        return get_post($page_id);
    }
   
    /**
     * 初始化 account page
     * @return bool
     *  @since 1.0.0
     */
    private function init_page_qrcode(){
        $page_id =intval($this->get_option('page_qrcode',0));
    
        $page=null;
        if($page_id>0){
            return true;
        }
    
        $page_id =wp_insert_post(array(
            'post_type'=>'page',
            'post_name'=>'wechat-qrcode',
            'post_title'=>__('Social - Wechat Qrcode',XH_SOCIAL),
            'post_content'=>'[xh_social_page_wechat_qrcode]',
            'post_status'=>'publish',
            'meta_input'=>array(
                '_wp_page_template'=>'social/account/wechat/qrcode.php'
            )
        ),true);
    
        if(is_wp_error($page_id)){
            XH_Social_Log::error($page_id);
            throw new Exception($page_id->get_error_message());
        }
    
        $this->update_option('page_qrcode', $page_id,true);
        return true;
    }
 
    /**
     * 微信中自动登录
     * @since 1.0.0
     */
    public function auto_login_in_wechat(){
        $this->_auto_login_in_wechat();
        do_action('xh_social_auto_login_in_wechat');
    }
    
    private function _enabled_auto_login_in_wechat(){
        $auto_login =$this->get_option('auto_login',0);
        switch ($auto_login){
            default:
            case 0:
                return false;
            case 1:
                if(!XH_Social_Helper_Uri::is_wechat_app()){
                    return false;
                }
                break;
        }
        
        return true;
    }
    
    private function _auto_login_in_wechat(){
        if(is_user_logged_in()){
            return;
        }

        if(headers_sent()){
            return;
        }

        if(defined('DOING_AJAX')|| is_admin()){
            return;
        }
        
        global $post;
        if($post&&$post->post_type==='page'){
            if(!(is_home() || is_front_page())){
                return;
            }
        }
       
        $enabled = apply_filters('xh_social_channel_wechat_enabled_auto_login_in_wechat', $this->_enabled_auto_login_in_wechat()) ;
        if(!$enabled){
            return;
        }
        
        $login_location_uri = XH_Social_Helper_Uri::get_location_uri();
        XH_Social::instance()->session->set('social_login_location_uri', $login_location_uri);
        $login_redirect_uri = XH_Social_Channel_Wechat::instance()->generate_authorization_uri(0,$login_location_uri);
        wp_redirect($login_redirect_uri);
        exit;
    }
    
    public function gc(){
        global $wpdb;
        $now = date('Y-m-d H:i:s',current_time( 'timestamp' )-60*60);
        $wpdb->query("delete from `{$wpdb->prefix}xh_social_channel_wechat_queue` where created_date<='$now';");
        $dbname = DB_NAME;
        //若索引超过数据库最大值，则情况数据库
        $table =$wpdb->get_row(
           "select `auto_increment` as id
            from `information_schema`.`tables` 
            where `table_name` = '{$wpdb->prefix}xh_social_channel_wechat_queue'  
                   and `table_schema` = '$dbname'
            limit 1;");
        
        //当id字段已很长，情况数据库
        if($table&&$table->id&&$table->id>9999999999){
             $wpdb->query("truncate table `{$wpdb->prefix}xh_social_channel_wechat_queue`;");   
        }
    }
}
require_once XH_SOCIAL_DIR.'/includes/abstracts/abstract-xh-schema.php';
class XH_Social_Channel_Wechat_Model_Ext extends Abstract_XH_Social_Schema{
    /**
     * {@inheritDoc}
     * @see Abstract_XH_Social_Schema::init()
     */
    public function init(){
        $this->on_version_102();
    }
    
    public function on_version_102(){
        $collate=$this->get_collate();
        global $wpdb;   
        $wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}xh_social_channel_wechat_queue`(
                    	`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
                    	`ext_user_id` BIGINT(20) NULL DEFAULT NULL,
                    	`user_id` BIGINT(20) NULL DEFAULT NULL,
                    	`ip` varchar(32) NULL DEFAULT NULL,
                    	`uid` varchar(32) NULL DEFAULT NULL,
                    	`created_date` DATETIME NOT NULL,
                    	 PRIMARY KEY (`id`),
                         UNIQUE INDEX `uid_unique` (`uid`)
                    )
                    $collate;");
        
        if(!empty($wpdb->last_error)){
            XH_Social_Log::error($wpdb->last_error);
            throw new Exception($wpdb->last_error);
        }
    }
}
return XH_Social_Add_On_Social_Wechat_Ext::instance();
?>