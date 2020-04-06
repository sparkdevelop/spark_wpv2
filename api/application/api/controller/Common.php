<?php

namespace app\api\controller;

use think\Controller;
use think\Image;
use think\Request;
use think\Validate;

class Common extends Controller
{
    protected $request; // 用来处理参数
    protected $validater; // 用来验证数据/参数
    protected $params; // 过滤后符合要求的参数
    protected $rules = array(
        'User' => array(
            'test' => array(
                'id' => 'require',
            ),
            'user' => array(
                'token' =>'require',
                'user_id' =>'require',
            ),
            'get_register_time' => array(
                'token' =>'require',
              //  'user_id' =>'require',
              //  'start_time' => 'require',
               // 'end_time' => 'require',
            ),
            'get_user_post_ids' => array(
                'token' => 'require',
                //  'user_id' =>'require',
                //  'start_time' => 'require',
                // 'end_time' => 'require',
            ),
            'get_online_info' => array(
                'token' => 'require',
                //  'user_id' =>'require',
                //  'start_time' => 'require',
                // 'end_time' => 'require',
            ),
            'posts_count' => array(
                'token' =>'require',
                'user_id' =>'require',
                'start_time' => 'require',
            ),
            'points' => array(
                'token' =>'require',
                'user_id' =>'require',
            ),
            'posts_browse' => array(
                'token' =>'require',
                'user_id' =>'require',
                'start_time' => 'require',
            )
        ),
        'Post' => array(
            'keywords' => array(
                'token' => 'require',
                'start_time' => 'require',
              //  'end_time' => 'require',
            ),
        ),
        'Statement' => array(
            'index' => array(

            )
        )
    );

    protected function _initialize()
    {
        parent::_initialize();
        $this->request = Request::instance();
        // $this->check_time($this->request->only(['time']));
        // $this->check_token($this->request->param());
//        $this->params = $this->check_params($this->request->param(true));
    }

    /**
     * 验证请求是否超时
     * @param  [array] $arr [包含时间戳的参数数组]
     * @return [json]      [检测结果]
     */
    public function check_time($arr)
    {
        if (!isset($arr['time']) || intval($arr['time']) <= 1) {
            $this->return_msg(400, '时间戳不正确!');
        }
        if (time() - intval($arr['time']) > 60) {
            $this->return_msg(400, '请求超时!');
        }
    }

    /**
     * api 数据返回
     * @param  [int] $code [结果码 200:正常/4**数据问题/5**服务器问题]
     * @param  [string] $msg  [接口要返回的提示信息]
     * @param  [array]  $data [接口要返回的数据]
     * @return [string]       [最终的json数据]
     */
    public function return_msg($code, $msg = '', $data = [])
    {
        /*********** 组合数据  ***********/
        $return_data['code'] = $code;
        $return_data['msg'] = $msg;
        $return_data['data'] = $data;
        /*********** 返回信息并终止脚本  ***********/
        echo json_encode($return_data, JSON_UNESCAPED_UNICODE);
        die;
    }

    /**
     * 验证token(防止篡改数据)
     * @param  [array] $arr [全部请求参数]
     * @return [json]      [token验证结果]
     */
    public function check_token($arr)
    {
        /*********** api传过来的token  ***********/
        if (!isset($arr['token']) || empty($arr['token'])) {
            $this->return_msg(400, 'token不能为空!');
        }
        $app_token = $arr['token']; // api传过来的token
        /*********** 服务器端生成token  ***********/
        unset($arr['token']);
        $service_token = 'sparkspace';
        $service_token = md5($service_token); // 服务器端即时生成的token
        /*********** 对比token,返回结果  ***********/
        if ($app_token !== $service_token) {
            $this->return_msg(400, 'token值不正确!');
        }
    }

    /**
     * 验证参数 参数过滤
     * @param  [array] $arr [除time和token外的所有参数]
     * @return [return]      [合格的参数数组]
     */
    public function check_params($arr)
    {
        /*********** 获取参数的验证规则  ***********/
        $rule = $this->rules[$this->request->controller()][$this->request->action()];
        /*********** 验证参数并返回错误  ***********/
        $this->validater = new Validate($rule);
        if (!$this->validater->check($arr)) {
            $this->return_msg(1002, $this->validater->getError());
        }
        /*********** 如果正常,通过验证  ***********/
        return $arr;
    }

    /**
     * 提取多维数组键值
     */
    public function array_select($arr){
        $temp = array();
        foreach($arr as $list=>$things){
            if(is_array($things)){
                foreach($things as $newlist=>$counter){
                    $temp[] =  $counter;
                }
            }
        }
        return $temp;
    }


}