<?php
/**
 * Created by PhpStorm.
 * User: zylbl
 * Date: 2020/4/6
 * Time: 20:24
 */

namespace app\api\controller;

use think\Request;

class Statement extends Common
{
    public function user()
    {
        // 是否为 GET 请求
        if (Request::instance()->isGet()) {
            //获取请求参数
            $data = $this->params;
            $this->check_token($data);
            $where = array(
                "authority" => ['=', $data['authority']]
            );
            if (isset($data['since']) && !isset($data['until'])) {
                $since = (int)$data['since'];
                $where['timestamp'] = ['>', $since];
            }
            if (isset($data['until']) && !isset($data['since'])) {
                $until = (int)$data['until'];
                $where['timestamp'] = ['<', $until];
            }
            if (isset($data['until']) && isset($data['since'])) {
                $since = (int)$data['since'];
                $until = (int)$data['until'];
                $where['timestamp'] = [['>', $since], ['<', $until]];
            }
            if (isset($data['verb'])) {
                $where['verb'] = ['=', $data['verb']];
            }

            $page = isset($data['page']) ? (int)$data['page'] : 0;
            $offsetNum = $page * 10;

            $db_res = db('standard_history')
                ->where($where)
                ->limit($offsetNum,10)->select();
            if (!$db_res) {
                $this->return_msg(400, '获取数据失败!');
            } else {
                $this->return_msg(200, '获取数据成功!', $db_res);
            }
        }
    }

    public function  application()
    {
        // 是否为 POST 请求
        if (Request::instance()->isPost()) {
            //获取请求参数
            $data = $this->params;
            $this->check_token($data);
//            $data['timestamp'] = (int)$data['timestamp'];
            $res = db('standard_history')->insert($data);
            if (!$res) {
                $this->return_msg(400, '上传数据失败!');
            } else {
                $this->return_msg(200, '上传数据成功!');
            }
        }
    }
}