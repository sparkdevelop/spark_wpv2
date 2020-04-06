<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2020/4/6
 * Time: 20:24
 */
namespace app\api\controller;
use \think\Request;
class Statement extends Common {
    public function statement(){
        $data = $this->params;

        // 是否为 GET 请求
        if (Request::instance()->isGet()) echo "当前为 GET 请求";
        // 是否为 POST 请求
        if (Request::instance()->isPost()) echo "当前为 POST 请求";
        echo $data;

    }
}