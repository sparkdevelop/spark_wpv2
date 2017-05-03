<?php
namespace Home\Controller;
use Think\Controller;
header('Content-Type:text/html; charset=utf-8');


class IndexController extends Controller {
    public function register(){
        $this->display();
    }
    //注册处理界面
    public function register_handle()
    {
        $username = I("username");
        $password = I("password");
        $studentnumber = I("studentnumber");
        $phonenum = I("phone");
        $select = I("select");
        $building = I("building");
        $room = I("room");
        $address = $select.$building.'楼'.$room.'室';
        $password = md5($password);
        $user = M('userinfo');
        $map['username'] = $username;
        $mapp['phone'] = $phonenum;
        $data = $user->where($map)->find();
        $data2 = $user->where($mapp)->find();
        $time = time();
        if ($data) {
            $this->error('注册姓名已存在，请重新注册', U(register), 1);
        } else if ($data2) {
            $this->error('手机号已绑定其它用户名，请重新注册', U(register), 1);
        } else {
            $datauser['username'] = $username;
            $datauser['password'] = $password;
            $datauser['phone'] = $phonenum;
            $datauser['address'] = $address;
            // $datauser['flag'] = 1;
            $datauser['number'] = $studentnumber;
            // $datauser['time'] = date('Y-m-d l h:i:s A',$time);
            $registerresult = $user->add($datauser);

            if ($registerresult) {
                $this->success("注册成功", U(login), 1);
            } else {
                $this->error("注册失败", U(register), 1);
            }
        }
    }
    public function forget(){
        $this->display();
    }
    // //gorget处理逻辑
    public function forget_handle()
    {
        $username = I("username");
        $password = I("password");
        $password = md5($password);
        $studentnumber = I("studentnumber");
        $phonenum = I("phone");
        $user = M('userinfo');
        $map['username'] = $username;
        $map['phone'] = $phonenum;
        $map['studentnumber'] = $studentnumber;
        $mapresult = $user->where($map)->find();
        if (!$mapresult) {
            $this->error("未找到用户!", U(forget, array('openid' => $openid, 'flag' => $flag)), 1);
        } else {
            $mapchange['password'] = $password;
            $changeresult = $user->where($map)->save($mapchange);
            if ($changeresult) {
                $this->success("修改成功!", U(login, array('openid' => $openid, 'flag' => $flag)), 1);
            } else {
                $this->error("修改失败!", U(forget, array('openid' => $openid, 'flag' => $flag)), 1);
            }
        }
    }
    // 登录界面
    public function login(){
        $this->display();
    }
    public function login_handle(){
        $username = I("username");
        $password = I("password");
        $password =  md5($password);
        $m=M('userinfo');
        $data=array(
            "username"=>$username,
            "password"=>$password
        );
        $dataresult = $m->where($data)->find();
            if(!$dataresult){
                $this->error("登录失败!",U(login),1);
            }
            else{
                cookie("username",$dataresult["username"],time()+60*60*24*30 ,'/');
                $this->redirect(share);
            }
    }
    //注销
    public function logout(){
        if(cookie('username')){
            cookie('username',null);
            $this->redirect(share);
        }else{
            $this->redirect(share);
        }
    }
    public function search(){
        $user=M('userinfo');
        $component=M('component');
        $where=1;
        if($search=I('search'))
        {
            $where.=' AND name LIKE "%'.$search.'%"';
        }
        // $waitborrow=M('book_wait_borrow');
        $username = cookie('username');
               //管理员
         $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;
        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();
        // $bi=M('bookinfo');
        $count = $component->where($where)->count();
        $page = new \Think\Page($count ,9);
        $limit = $page->firstRow . ',' . $page->listRows;
        $comlist = $component->where($where)->limit($limit)->select();
        $this->page = $page->show();

        $this->component = $comlist;
        $this->user = $userresult;
        $this->search = $search;
//         print_r($bookhot);
        $this->display();
    }
    public function person(){
        $username = cookie('username');
               //管理员
         $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;
        if($username){
            $user = M('userinfo');
            $log = M('component_log');
            $userinfo = $user->where(Array("username" => $username))->find();
            $id=I('id');
            if($id){
                $userdetails = $user->where(Array('id'=>$id))->find();
                $username2 = $userdetails['username'];
                $userlog = $log->where(Array("keeper_name" => $username2))->order('id desc')->select();
                $this->userdetails= $userdetails;
            }else{
                $userlog = $log->where(Array("keeper_name" => $username))->order('id desc')->select();
                $this->userdetails= $userinfo;
            }
            //用户读书的log信息
            // $booklog = Array(
            //     'keeper_name'=>$username
            // );
            // $booklog = $log->where($booklog)->order('log_id desc')->select();
            // foreach($booklog as $key=>$value){
            //     $bookid = Array(
            //         "book_id"=>$value['book_id']
            //     );
            //     $bookmessage = $book->where($bookid)->find();
            //     $isbn = Array(
            //         'isbn'=>$bookmessage['isbn']
            //     );
            //     $booktitle = $bookinfo->where($isbn)->find();
            //     $booklog[$key]['booklog']=$booktitle;
            // }
            $this->user= $userinfo;
            $this->userlog=$userlog;
            $this->display();
        }else{
            $this->redirect(share);
        }
    }
    public function message(){
        $username = cookie('username');
               //管理员
         $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;
        if($username){
            $user = M('userinfo');
            $datauser['username'] = $username;
            $userresult = $user->where($datauser)->find();
            $this->user= $userresult;
            // print_r($userresult);
            $this->display();
        }else{
            $this->redirect(share);
        }
    }
    //修改用户基本信息，学号、性别等
    public function basicmessage(){
        $describe =  I("describe");
        $user = M('book_user_info');
        $username = cookie('username');
        $username = getusernameBynickname($username);
        $datafind['username'] = $username;
        $datauser['describe'] = $describe;
        $addresult = $user->where($datafind)->save($datauser);
        if ($addresult) {
            $this->success("保存成功！",U(message),1);
        }else{
            $this->success("保存失败！",U(message),1);
        }
    }
    //修改用户头像信息
    public function imgmessage(){
        $img = I("changeimg");
        $user = M('userinfo');
        $username = cookie('username');
        $datafind['username'] = $username;
        $datauser['img'] = $img;
        $addresult = $user->where($datafind)->save($datauser);
        if ($addresult) {
            $this->success("保存成功！",U(message),1);
        }else{
            $this->success("保存失败！",U(message),1);
        }
    }
    public function usermessage(){
        $username = I('username');
        $phone = I('phone');
        $address = I('address');
        $id = I('id');
        $usermessage = M('userinfo');
        $datafind['id'] = $id;
        // $datauser['username'] = $username;
        $datauser['id'] = $id;
        $datauser['phone'] = $phone;
        $datauser['address'] = $address;
        $saveresult = $usermessage->where($datafind)->save($datauser);
        if($saveresult){
            $r_data['flag'] = 1;
            $this->ajaxReturn($r_data, 'JSON');
        }
    }
    public function usemessage(){
        $username = cookie('username');
        $password =  I("password");
        $password =  md5($password);
        $fpassword =  I("rpassword");
        $fpassword =  md5($fpassword);
        $m=M('userinfo');
        $data=array(
            "username"=>$username,
            "password"=>$password
        );
        $name = Array(
            "username"=>$username,
            "password"=>$fpassword
        );
        $datanum = $m->where($data)->find();
        if($datanum){
            $dataresult = $m->where($data)->save($name);
            if($dataresult){
                $this->success("修改成功",U(message),3);
            }else{
                $this->error("修改失败",U(message),3);
            }
        }else{
            $this->error("原密码错误",U(message),3);
        }
    }
    public function share(){
        // $book=M('book');
        $flag=I('flag');
        $user=M('userinfo');
        $component=M('component');
        $where=1;
        // if($kw=I('kw'))
        // {
        //     $where.=' AND name LIKE "%'.$kw.'%"';
        // }
        $username = cookie('username');


        //管理员
         $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;

        // 点击物品分类
        $type = I('type');
        if($type){
            $where = Array(
                'tag'=> $type
            );
        }else{
            $where = Array(
                'tag'=> '材料'
            );
        }
        // $waitborrow=M('book_wait_borrow');
        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();
        // $bi=M('bookinfo');
        $count = $component->where($where)->count();
        $page = new \Think\Page($count ,12);
        $limit = $page->firstRow . ',' . $page->listRows;
        $comlist = $component->where($where)->limit($limit)->select();
        $this->page = $page->show();

        $this->component = $comlist;
        $this->user = $userresult;
//         print_r($bookhot);
        $this->display();
    }
    public function contribute(){
        $username = cookie('username');
         $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;
        // $usermessage = M('book_usermessage');
        $user = M('userinfo');
        // $book = M('book');
        // $connectmessage = M('book_connectmessage');
        if($username == "" || $username == null){
            $this->error("您未登录!",U(share),2);
//            $this->display();
        }else{
            $data = Array(
                "username"=>$username
            );
            $userinfo = $user->where($data)->find();
            // print_r($userinfo);
            $this->user = $userinfo;
            $this->display();
        }
    }
    //处理贡献的界面
    public function doContribute(){
        $component = M('component');
        $username = cookie('username');
        $name = I('name');
        $img = I('img');
        $number = I('number');
        $tag = I('tag');
        $summary = I('summary');
        $data = Array(
            'name' => $name,
            'img' => $img,
            'number' => $number,
            'tag' => $tag,
            'summary' => $summary,
            'owner_name' => $username,
            'number_left' => $number,
        );
        $datafind = Array(
            'name' => $name
        );
        $result = $component->where($datafind)->find();
        if(!$result){
            $component->add($data);
        }else{
            $data['number'] = $result['number'] + $data['number'];
            $data['number_left'] = $result['number_left'] + $data['number_left'];
            $component->where($datafind)->save($data);
        }
    }
    //物品的主页
    public function componentInfo(){
        $userinfo = M('userinfo');
        $username = cookie('username');
        $component = M('component');
        $componentStatus = M('component_status');
        $datauser['username'] = $username;
        $userresult = $userinfo->where($datauser)->find();
        $com_id=intval(I('id'));
        $comData = Array(
            'id' => $com_id
        );
        $com_info = $component->where($comData)->find();
        $logInfoData = Array(
            'name'=>$com_info['name']
        );
        $componentStatusResult = $componentStatus->where($logInfoData)->select();
        // print_r($componentStatusResult);
        foreach($componentStatusResult as $key=>$value){
            $nameData = Array(
                'username'=>$value['username']
            );
            $usermessage = $userinfo->where($nameData)->find();
            $componentStatusResult[$key]['address'] = $usermessage['address'];
        }
        $this->cominfo = $com_info;
        $this->user = $userresult;
        // print_r($componentStatusResult);
        $this->comLog = $componentStatusResult;
        $this->display();
    }
    public function uploadUserPic(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize = 10485760;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './Public'; // 设置附件上传根目录
        $upload->savePath = '/Uploads/'; // 设置附件上传目录
        // 上传文件
        $info = $upload->upload();
        if (!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        } else {// 上传成功
            $res['url']=$info['pic']['savepath'].$info['pic']['savename'];
            $this->ajaxReturn($res,"JSON");
        }
    }
    public function shop(){
        $username = cookie('username');
        $number = I('val');
        $id = I('id');
        $componentShop = M('component_shop');
        $component = M('component');
        $componentLog = M('component_log');
        $dataQuery = Array(
            'id' => $id
        );
        $result = $component->where($dataQuery)->find();
        $dataBorrow = Array(
            'username' => $username,
            'name' => $result['name']
        );
        $resultBorrow = $componentShop->where($dataBorrow)->find();
        if($resultBorrow){
            $borrowNumber = $resultBorrow['number'];
            $number = $number + $borrowNumber;
            $data = Array(
                'username' => $username,
                'number' => $number,
                'name' => $result['name']
            );
            $saveresult = $componentShop->where($dataBorrow)->save($data);
        } else {
            $data = Array(
                'username' => $username,
                'number' => $number,
                'name' => $result['name']
            );
            $saveresult = $componentShop->add($data); 
        }
        $time = time();
        $dataLog = Array(
            'name' => $result['name'],
            'status' => 2,
            'time' => date('Y-m-d H:i',$time),
            'keeper_name' => $username,
            'number' => $number
        );
        // $componentLog->add($dataLog);
        if($saveresult){
            $r_data['code'] = 200;
            $this->ajaxReturn($r_data, 'JSON');
        }else{
            $r_data['code'] = 400;
            $this->ajaxReturn($r_data, 'JSON');
        }
    }
    //系统概貌-全部物品页面
    public function system(){    
        
        $component=M('component');
        $component_status=M('component_status');
        $user = M('userinfo');
        $username = cookie('username');
        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();
        $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;
        if(!$adminresult){
            $this->redirect(share);
        }
        $where=1;
        if($kw=I('kw'))
        {
            $where.=' AND name LIKE "%'.$kw.'%"';
        }
        
        
        $borrow=$where .' AND status=2';
        $sumborrow = $component_status->where($borrow)->sum('nownumber'); // sumborrow物品的总借出量

        $keep=$where .' AND status=3';
        $sumkeep = $component_status->where($keep)->sum('nownumber');// sumkeep物品的总保管量

        $repair=$where .' AND status=4';
        $sumrepair = $component_status->where($repair)->sum('nownumber');// sumrepair物品的总报修量

        
        //将$var中name相同且status相同的数据合并，nownumber相加，得到某种物品的各个状态下数量
        $varb = $component_status->field('name,nownumber')->where($borrow)->select();
        $arrb = array();
          foreach($varb as $v){
                if(!(isset ($arrb[$v['name']])))
                    $arrb[$v['name']] = $v;
                else  $arrb[$v['name']]['nownumber'] += $v['nownumber'];
          }

        $vark = $component_status->field('name,nownumber')->where($keep)->select();
        $arrk = array();
          foreach($vark as $v){
                if(!(isset ($arrk[$v['name']])))
                    $arrk[$v['name']] = $v;
                else $arrk[$v['name']]['nownumber'] += $v['nownumber'];
          }

        $varr = $component_status->field('name,nownumber')->where($repair)->select();
        $arrr = array();
          foreach($varr as $v){
                if(!(isset ($arrr[$v['name']])))
                    $arrr[$v['name']] = $v;
                else $arrr[$v['name']]['nownumber'] += $v['nownumber'];
          }
        
        $count=$component->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出

        $sumcom = $count;   // $sumcom物品的种类个数        
        $sumnum = $component->where($where)->sum('number');  // $sumnum物品的总数量
        $sumleft = $component->where($where)->sum('number_left');  // $sumleft物品的总库存量
        
        $list = $component->field('id,img,name,number,number_left')->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        
        $this->assign('user',$userresult);
        $this->assign('list',$list);// 赋值数据集
        $this->assign('arrb',$arrb);// 赋值数据集
        $this->assign('arrk',$arrk);// 赋值数据集
        $this->assign('arrr',$arrr);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('sumcom',$sumcom);
        $this->assign('sumnum',$sumnum);        
        $this->assign('sumleft',$sumleft);
        $this->assign('sumborrow',$sumborrow);
        $this->assign('sumkeep',$sumkeep);
        $this->assign('sumrepair',$sumrepair);       

        $this->display();
    }
    
    //系统概貌-报修物品页面
    public function repair(){  
        $user=M('userinfo');
        $component=M('component');
        $component_status=M('component_status');
        $component_log=M('component_log');
        $username = cookie('username');
        $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;

        if(!$adminresult){
            $this->redirect(share);
        }

        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();

        $where='status=4';
        $where2='a.status=4';
        
        if($kw=I('kw'))
        {
            $where.=' AND name LIKE "%'.$kw.'%"';
            $where2.=' AND name LIKE "%'.$kw.'%"';
        }
        
        $list = $component_status->field('a.name,a.username,a.conditions,a.status,b.img,c.number,c.time,d.address,d.phone')->alias('a')->join('LEFT JOIN lib_component b ON a.name=b.name')->join('LEFT JOIN lib_component_log c ON b.name=c.name and a.status=c.status and a.username=c.keeper_name')->join('LEFT JOIN lib_userinfo d ON a.username=d.username')->where($where2)->limit($Page->firstRow.','.$Page->listRows)->select();
        
         //$info存储用户信息
        $info=array();
        foreach ($list as $v) {
            if(!(isset ($info[$v['username']])))
                    $info[$v['username']] = $v;
                
        }

        $count=$component_status->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        
        $this->assign('user',$userresult);
        $this->assign('list',$list);// 赋值数据集
        $this->assign('info',$info);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }

       //确认报修——待解决
    public function confirm(){
        $username = I('username');
        $name = I('name');
        $number = I('number');
        $role = I('role');
        $componentStatus = M('component_status');
        $component = M('component');
        $data = Array(
            'username'=>$username,
            'name'=>$name,
            'nownumber'=>$number
        );
        if($role == 0){
            $dataSave = Array(
                'username'=>$username,
                'name'=>$name,
                'nownumber'=>$number,
                'conditions'=>1
            );
            $saveresult = $componentStatus->where($data)->save($dataSave);
        } elseif($role == 1){
            $deleteData = Array(
                'name'=>$name
            );
            // $component->where($deleteData)->setDec('number_left',$number);
            // 删除报修信息
            // $findresult = $componentStatus->where($data)->find();

            // if($findresult['status'] == 4){

            // }
            $data['status'] = 4;
            $saveresult = $componentStatus->where($data)->delete();
        } elseif($role == 2){
            $dataSave = Array(
                'username'=>$username,
                'name'=>$name,
                'nownumber'=>$number,
                'status'=>2
            );
            $dataBorrow = Array(
                'username'=>$username,
                'name'=>$name,
                'status'=>2
            );
            $findresult = $componentStatus->where($dataBorrow)->find();
            if($findresult){
                $saveresult = $componentStatus->where($dataBorrow)->setInc('number',$number);
            }else{
                $data['status'] = 4;
                $saveresult = $componentStatus->where($data)->save($dataSave);
                // $saveresult = $componentStatus->where($data)->delete();
            }
        }
        if($saveresult){
            $r_data['code'] = 200;
            $this->ajaxReturn($r_data, 'JSON');
        }else{
            $r_data['code'] = 400;
            $this->ajaxReturn($r_data, 'JSON');
        }
    }

        //删除物品——待解决
    // public function delrep(){

    // }

        //加入库存——待解决
    // public function add(){

    // }

    
    //系统概貌-用户管理页面
    public function uadmin(){
        $component_status=M('component_status');
        $user = M('userinfo');
        $username = cookie('username');
        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();
        $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;

        if(!$adminresult){
            $this->redirect(share);
        }
        $where=1;
        if($kw=I('kw'))
        {
            $where.=' AND username LIKE "%'.$kw.'%"';
        }
        $count=$user->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        $list = $user->field('id,username,number,phone')->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('id desc')->select();
        
        $borrow=$where .' AND status=2';
        $keep=$where .' AND status=3';
        $repair=$where .' AND status=4';

        //将$var中username相同且status相同的数据合并，nownumber相加，得到某个用户所关联物品的各个状态下总数量
        $varb = $component_status->field('username,nownumber')->where($borrow)->select();
        $arrb = array();
          foreach($varb as $v){
                if(!(isset ($arrb[$v['username']])))
                    $arrb[$v['username']] = $v;
                else  $arrb[$v['username']]['nownumber'] += $v['nownumber'];
          }

        $vark = $component_status->field('username,nownumber')->where($keep)->select();
        $arrk = array();
          foreach($vark as $v){
                if(!(isset ($arrk[$v['username']])))
                    $arrk[$v['username']] = $v;
                else $arrk[$v['username']]['nownumber'] += $v['nownumber'];
          }

        $varr = $component_status->field('username,nownumber')->where($repair)->select();
        $arrr = array();
          foreach($varr as $v){
                if(!(isset ($arrr[$v['username']])))
                    $arrr[$v['username']] = $v;
                else $arrr[$v['username']]['nownumber'] += $v['nownumber'];
          }
        
        $this->assign('user',$userresult);
        $this->assign('list',$list);// 赋值数据集
        $this->assign('arrb',$arrb);// 赋值数据集
        $this->assign('arrk',$arrk);// 赋值数据集
        $this->assign('arrr',$arrr);// 赋值数据集
        $this->assign('firstRow',$Page->firstRow);
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('count',$count);
        $this->display();
    }
         //删除用户信息
    public function deluser(){ 
        $id=I('id');
        $userinfo=M('userinfo');
        $component_status=M('component_status');

        //拿到删除用户的username，从而在对应的compon_status表中删除对应数据
        $user=$userinfo->field('username')->where("id=$id")->find();
        $username=$user['username'];
        $component_status->where("username='$username'")->delete();
        
        if($userinfo->delete($id)){
            $r_data['code'] = 200;
            $this->ajaxReturn($r_data, 'JSON');
        }else{
            $r_data['code'] = 400;
            $this->ajaxReturn($r_data, 'JSON');
        }
    }
          //批量删除用户信息
    public function bdeluser()
    {
        $ids=I('ids');
        $userinfo=M('userinfo');
        $ids=implode(',', $ids);
        if($userinfo->delete($ids))
        {
            $this->success('删除用户成功！',U('uadmin'));
        }else
        {
            $this->error('删除用户失败！');
        }
    }

    
    //系统概貌-借用记录页面
    public function record(){
        $component_log=M('component_log');
        $user = M('userinfo');
        $username = cookie('username');
        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();
        $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;

        if(!$adminresult){
            $this->redirect(share);
        }

        $where='status =2';
        if($kw=I('kw'))
        {
            $where.=' AND keeper_name LIKE "%'.$kw.'%"';
        }
        $count=$component_log->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        $list = $component_log->field('a.id,a.keeper_name,a.name,a.number,a.time,a.remark,b.phone,b.address')->alias('a')->join('LEFT JOIN lib_userinfo b ON a.keeper_name=b.username')->where($where)->limit($Page->firstRow.','.$Page->listRows)->order('time desc')->select();
        
        $this->assign('user',$userresult);
        $this->assign('list',$list);// 赋值数据集
        $this->assign('firstRow',$Page->firstRow);
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }

    
    //管理中心-待取物品页面
    public function mywait(){ 
        $user = M('userinfo');
        $username=cookie('username');   
               //管理员
         $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;
        // 测试用 $username='Yui';  假设Yui已登录
        $component_shop=M('component_shop');
        $component=M('component');
        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();
        $component_status=M('component_status');
        // $admin=$user->where("username='huran'")->find();
        $keep="a.username='$username' AND status=3";
        $where="username='$username'";
        if($kw=I('kw'))
        {
            $where.=' AND name LIKE "%'.$kw.'%"';
            $keep.=' AND name LIKE "%'.$kw.'%"';
        }
        $count=$component_shop->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(6)
        $show = $Page->show();// 分页显示输出

        //judge判断是否有保管人符合借用条件
        $judge=$component_shop->field('a.name,a.number,b.nownumber,b.username,c.address,c.phone,d.img')->alias('a')->join('lib_component_status b ON a.name=b.name and a.number<b.nownumber and a.username!=b.username')->join('lib_userinfo c ON b.username=c.username')->join('lib_component d ON a.name=d.name')->where($keep)->order('a.id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        //list1判断实验室库存是否符合借用条件
        $list1 = $component_shop->field('a.name,a.number,b.img,b.number_left')->alias('a')->join('lib_component b ON a.name=b.name and a.number<b.number_left')->where($where)->order('a.id desc')->limit($Page->firstRow.','.$Page->listRows)->select();   
        
        if($list1){
            $list2 = array();
            //给$list1加键值对，存储保管人信息
            foreach ($list1 as $key => $v) {
                $userCom = $component->where("name='$v[name]'")->find();
                $userinfo = $user->where("username='$userCom[owner_name]'")->find();
                $list1[$key]['username']=$userinfo['username'];
                $list1[$key]['address']=$userinfo['address'];
                $list1[$key]['phone']=$userinfo['phone'];
            }
            foreach ($list1 as $v) {
               if(!(isset ($list2[$v['username']]))){
                    $list2[$v['username']] = $v;
               }else{
                    $list2[$v['username']]['nownumber'] = $v['nownumber'];
               }
            }

        }elseif($judge){
            $list1 = array();
            foreach ($judge as $v) {
               if(!(isset ($list1[$v['name']]))){
                $list1[$v['name']] = $v;
               }
               else $list1[$v['name']]['nownumber'] = $v['nownumber'];
            }

            $list2 = array();
            foreach ($list1 as $v) {
               if(!(isset ($list2[$v['username']]))){
                $list2[$v['username']] = $v;
               }
               else $list2[$v['username']]['nownumber'] = $v['nownumber'];
            }
        }else{
   
            
        }
        $this->assign('user',$userresult);
        $this->assign('list1',$list1);// 赋值数据集
        $this->assign('list2',$list2);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }

        //批量删除待取物品——未做
    // public function bdelwait(){

    // }

        //确认借用物品
    public function conborrow(){
        $name=I('name');
        $number=I('number');
        $remark=I('remark');
        $component_shop=M('component_shop');
        $component=M('component');
        $component_status=M('component_status');
        $component_log=M('component_log');
        $username=cookie('username');
        //测试用$username='Yui';
        $where['username']=$username;
        $where['name']=$name;

        //component_shop中删除该条数据
        $resultDel = $component_shop->where($where)->delete();
 

        //component中number_left减少
        $component->where("name='$name'")->setDec('number_left',$number);
        
        //component_log中写入借用记录
        $time=date("Y-m-d H:i");
        $data['name']=$name;
        $data['status']=2;
        $data['time']=$time;
        $data['keeper_name']=$username;
        $data['number']=$number;
        $data['remark']=$remark;
        $component_log->add($data);
        
        //component_status中更新数据(判断status表中是否有借用记录)
        $where2['status']=2;
        $where2['username']=$username;
        $where2['name']=$name;
        $where2['remark']=$remark;
             //查询记录
        $var=$component_status->where($where2)->find();
        $data2['name']=$name;
        $data2['status']=2;
        $data2['conditions']=0;
        $data2['username']=$username;
        $data2['nownumber']=$number;
        $data2['remark']=$remark;
        if($var){
            $result = $component_status->where($where2)->setInc('nownumber',$number);
        }
        else{
            $result = $component_status->add($data2);
        }
        if($result && $resultDel){
            $r_data['code'] = 200;
            $this->ajaxReturn($r_data, 'JSON');
        }else{
            $r_data['code'] = 400;
            $this->ajaxReturn($r_data, 'JSON');
        }
        
    }
 
         //删除借用物品
    public function delborrow(){
        $name=I('name');
        $component_shop=M('component_shop');
        $username=cookie('username');
        // 测试用$username='Yui';
        $where['username']=$username;
        $where['name']=$name;
        if($component_shop->where($where)->delete()){
            $r_data['code'] = 200;
            $this->ajaxReturn($r_data, 'JSON');
        }else{
            $r_data['code'] = 400;
            $this->ajaxReturn($r_data, 'JSON');
        }
    }


    
    //管理中心-已借物品页面
    public function myborrow(){ 
        $component_log=M('component_log');
        $component_status=M('component_status');
        $user = M('userinfo');
        $username = cookie('username');
               //管理员
         $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;
        //测试用 $username = 'Yui';  暂时假设Yui已登录
        
        $where2="a.username = '$username'".' AND a.status=2';
        $where3="keeper_name = '$username'";
        
        if($kw=I('kw'))
        {            
            $where2.=' AND a.name LIKE "%'.$kw.'%"';
            $where3.=' AND name LIKE "%'.$kw.'%"';
        }        
        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();
        

        $count = $component_status->field('a.id,a.name,a.nownumber,a.remark,b.img')->alias('a')->join('lib_component b ON a.name=b.name')->where($where2)->count();
        $Page = new \Think\Page($count,4);// 实例化分页类 传入总记录数和每页显示的记录数(6)

        $list = $component_status->field('a.id,a.name,a.nownumber,a.remark,b.img')->alias('a')->join('lib_component b ON a.name=b.name')->where($where2)->limit($Page->firstRow.','.$Page->listRows)->select();
          //$list2是将$list中name相同的物品合并在一起
        $list2=array();
          foreach($list as $v){
                if(!(isset ($list2[$v['name']])))
                    $list2[$v['name']] = $v;
                else $list2[$v['name']]['nownumber'] = $v['nownumber'];
          }


        $list3=$component_log->where($where3)->order('time desc')->select();
        
        $show = $Page->show();// 分页显示输出
        $this->assign('user',$userresult);
        $this->assign('list2',$list2);// 赋值数据集
        $this->assign('list3',$list3);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }
            //归还
    public function back(){
        $username = cookie('username');        
        $name=I('name');
        $number=I('num');
        $id=I('id');
        $component=M('component');
        $component_status=M('component_status');
        $component_log=M('component_log');
        $borrow['username']=$username;
        $borrow['name']=$name;
        $borrow['status']=3;
        $borrow['id']=$id;
        
        $where['name']=$name;
        //componert中库存量更新
        $component->where($where)->setInc('number_left',$number);

        //component_status中更新数据(判断status表中是否有归还记录)
        $component_status->where($borrow)->setInc('nownumber',$number);

        $keep['status']=2;
        $keep['username']=$username;
        $keep['name']=$name;
             //查询记录
        $var=$component_status->where($keep)->find();
        $data2['name']=$name;
        $data2['status']=3;
        $data2['conditions']=0;
        $data2['username']=$username;
        // $data2['nownumber']=$number;
        if($var){
            $component_status->where($keep)->setDec('nownumber',$number);
            $Decmessage = $component_status->where($keep)->find();
            if($Decmessage['nownumber'] == 0){
                $component_status->where($keep)->delete();
            }
            $result = $component_status->where($data2)->find();
            if($result){
                $component_status->where($data2)->setInc('nownumber',$number);    
            }else{
                $data2['nownumber']=$number;
                $component_status->add($data2);                
            }
        }
            

        //component_log中写入归还记录
        $time=date("Y-m-d H:i");
        $data['name']=$name;
        $data['status']=3;
        $data['time']=$time;
        $data['keeper_name']=$username;
        $data['number']=$number;
        
        if($component_log->add($data)){
            $r_data['code'] = 200;
            $this->ajaxReturn($r_data, 'JSON');
        }else{
            $r_data['code'] = 400;
            $this->ajaxReturn($r_data, 'JSON');
        }
    }
    
            //报修
    public function trouble(){

        $username = cookie('username');
        // $username = 'Yui';  //暂时假设Yui已登录 
        
        $name=I('name');
        $number=I('num');
        $component_status=M('component_status');
        $component_log=M('component_log');
        $borrow['username']=$username;
        $borrow['name']=$name;
        $borrow['status']=2;

        //component_status中更新数据(判断status表中是否有报修记录)
        $component_status->where($borrow)->setDec('nownumber',$number);
        $resultBorrow = $component_status->where($borrow)->find();
        if($resultBorrow['nownumber'] == 0){
            $component_status->where($borrow)->delete();
        }


        $repair['status']=4;
        $repair['username']=$username;
        $repair['name']=$name;
        $repair['conditions']=0;
             //查询记录
        $var=$component_status->where($repair)->find();
        $data2['name']=$name;
        $data2['status']=4;
        $data2['conditions']=0;
        $data2['username']=$username;
        $data2['nownumber']=$number;
        if($var){
            $component_status->where($repair)->setInc('nownumber',$number);
        }
        else{
            $component_status->add($data2);
        }

        //component_log中写入归还记录
        $time=date("Y-m-d H:i");
        $data['name']=$name;
        $data['status']=4;
        $data['time']=$time;
        $data['keeper_name']=$username;
        $data['number']=$number;
        
        if($component_log->add($data)){
            $r_data['code'] = 200;
            $this->ajaxReturn($r_data, 'JSON');
        }else{
            $r_data['code'] = 400;
            $this->ajaxReturn($r_data, 'JSON');
        }
    }
    //管理中心-报修物品页面
    public function myrepair(){
        $component_status=M('component_status');
        $user = M('userinfo');
        $username = cookie('username');
               //管理员
         $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;
        //测试用 $username = 'Yui';   暂时假设Yui已登录

        $where="username = '$username'".' AND status=4';
        $where2="a.username = '$username'".' AND a.status=4';
        $component=M('component');
        $componentLog=M('component_log');
        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();
        if($kw=I('kw'))
        {
            $where.=' AND name LIKE "%'.$kw.'%"';
            $where2.=' AND name LIKE "%'.$kw.'%"';
        }
        $count=$component_status->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出

        // 先从status表中找出报修的物品
        $data = Array(
            'username'=>$username,
            'status'=>4
        );
        $dataresult = $component_status->where($data)->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach( $dataresult as $key=>$value){
            $componentData = Array(
                'name'=>$value['name']
            );
            $componentResult = $component->where($componentData)->find();
            $logList = $componentLog->where($data)->order('time desc')->find();
            $dataresult[$key]['time'] = $logList['time'];
            $dataresult[$key]['img'] = $componentResult['img'];
        }
        $list = $dataresult;

        // $list = $component_status->field('a.name,a.conditions,a.status,b.img,c.number,c.time')->alias('a')->join('LEFT JOIN lib_component b ON a.name=b.name')->join('LEFT JOIN lib_component_log c ON b.name=c.name and a.status=c.status and a.username=c.keeper_name')->where($where2)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('user',$userresult);
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }
              //取消报修
    public function cancel(){ 
        $username = cookie('username');
        //测试用 $username = 'Yui';  暂时假设Yui已登录

        // $time=I('time');
        $number=I('number');
        $name=I('name');
        $component_log=M('component_log');
        $component_status=M('component_status');
        // $data = Array(
        //     'time'=>$time,
        //     'keeper_name'=>$username
        // );
        // $cancel=$component_log->where($data)->order('time desc')->find();
        $where['name']=$name;
        $where['username']=$username;
        $where['status']=4;
        // print_r($where);
        $cancelResult = $component_status->where($where)->setDec('nownumber',$number);
        if($cancelResult['number'] == 0){
            $component_status->where($where)->delete();
        }
        $data = Array(
            'name'=>$name,
            'username'=>$username,
            'status'=>2
        );

        $findResult = $component_status->where($data)->find();
        if($findResult){
            $dataresult = $component_status->where($data)->setInc('nownumber',$number);
        }else{
            $data['nownumber']=$number;
            $dataresult = $component_status->add($data);
        }

        if($dataresult){
            $r_data['code'] = 200;
            $this->ajaxReturn($r_data, 'JSON');
        }else{
            $r_data['code'] = 400;
            $this->ajaxReturn($r_data, 'JSON');
        }
        
    }

               //批量取消报修------未做
    // public function bcancel()
    // {
    //     $times=I('times');
    //     $component_log=M('component_log');
    //     $times=implode(',', $times);
        
    //     if($component_log->where("time='$times'")->delete())
    //     {
    //         $this->success('取消报修成功！',U('myrepair'));
    //     }else
    //     {
    //         $this->error('取消报修失败！');
    //     }
    // }


    //管理中心-保管物品页面
    public function mykeep(){
        $component_log=M('component_log');
        $component_status=M('component_status');
        $user = M('userinfo');
        $username = cookie('username');
               //管理员
         $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;
        //测试用 $username = 'Yui';  暂时假设Yui已登录
        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();
        $where2="a.username = '$username'".' AND a.status=3';
        $where3="keeper_name = '$username'";
        
        
        if($kw=I('kw'))
        {
            $where2.=' AND a.name LIKE "%'.$kw.'%"';
            $where3.=' AND name LIKE "%'.$kw.'%"';
        }                    

        $list = $component_status->field('a.name,a.nownumber,b.img')->alias('a')->join('lib_component b ON a.name=b.name')->where($where2)->limit($Page->firstRow.','.$Page->listRows)->select();

        $count=count($list);// 查询满足要求的总记录数
        $Page = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(6)
        $show = $Page->show();// 分页显示输出

        $list = $component_status->field('a.name,a.nownumber,b.img')->alias('a')->join('lib_component b ON a.name=b.name')->join('lib_component_log c ON b.name=c.name')->where($where2)->limit($Page->firstRow.','.$Page->listRows)->select();
          //$list2是将$list中name相同的物品合并在一起
        $list2=array();
          foreach($list as $v){
                if(!(isset ($list2[$v['name']])))
                    $list2[$v['name']] = $v;
                else $list2[$v['name']]['nownumber'] = $v['nownumber'];
          }
        $list3=$component_log->where($where3)->order('time desc')->select();
        $this->assign('user',$userresult);
        $this->assign('list2',$list2);// 赋值数据集
        $this->assign('list3',$list3);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }

    //           借用:先做成借用全部保管数量
    public function borrow(){ 
        $username = cookie('username');
        //测试用 $username = 'Yui';   暂时假设Yui已登录
        
        $name=I('name');
        $component_status=M('component_status');
        $component_log=M('component_log');
        $back=$component_log->where("time='$time'")->find();
        $where['name']=$cancel[name];
        $where['$username']=$cancel[keeper_name];
        $where['status']=4;
        $number=$cancel[number];


        $component_status->where($where)->setDec('number',$number);

        if($userinfo->delete($id))
        {
            $this->success('删除用户成功！',U('uadmin'));
        }else
        {
            $this->error('删除用户失败！');
        }
    }
     // 借用
    public function reback(){ 
        $username = cookie('username');        
        $name=I('name');
        $number=I('num');
        $component=M('component');
        $component_status=M('component_status');
        $component_log=M('component_log');
        
        
        $where['name']=$name;
        
        //componert中库存量更新
        $component->where($where)->setDec('number_left',$number);

        //component_status中更新数据(判断status表中是否有借用、保管记录)
        $borrow['username']=$username;
        $borrow['name']=$name;
        $borrow['status']=2;
             //查询借用记录
        $var1=$component_status->where($borrow)->find();
        $data1['name']=$name;
        $data1['status']=2;
        $data1['conditions']=0;
        $data1['username']=$username;
        $data1['nownumber']=$number;
        if($var1){
            $component_status->where($borrow)->setInc('nownumber',$number);
        }
        else{
            $component_status->add($data1);
        }      

        $keep['status']=3;
        $keep['username']=$username;
        $keep['name']=$name;
             //查询保管记录
        $var2 = $component_status->where($keep)->find();
        $data2['name']=$name;
        $data2['status']=3;
        $data2['conditions']=0;
        $data2['username']=$username;
        $data2['nownumber']=$number;
        if($var2){
            $deldata = $component_status->where($keep)->setDec('nownumber',$number);
            if($deldata['number'] == 0){
                $component_status->where($keep)->delete();
            }
        }
        else{
            $component_status->add($data2);
        }

        //component_log中写入借用记录
        $time=date("Y-m-d H:i");
        $data['name']=$name;
        $data['status']=2;
        $data['time']=$time;
        $data['keeper_name']=$username;
        $data['number']=$number;
        
        if($component_log->add($data)){
            $r_data['code'] = 200;
            $this->ajaxReturn($r_data, 'JSON');
        }else{
            $r_data['code'] = 400;
            $this->ajaxReturn($r_data, 'JSON');
        }
    }
    public function recovery(){
        $user=M('userinfo');
        $component=M('component');
        $component_status=M('component_status');
        $component_log=M('component_log');
        $username = cookie('username');
        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();

        $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;

        if(!$adminresult){
            $this->redirect(share);
        }

        $where='status=3 and recovery=0';
        $where2='a.status=3 and a.recovery=0';
        
        if($kw=I('kw'))
        {
            $where.=' AND name LIKE "%'.$kw.'%"';
            $where2.=' AND name LIKE "%'.$kw.'%"';
        }
        
        $list = $component_status->field('a.name,a.username,a.conditions,a.nownumber,a.status,b.img,d.address,d.phone')->alias('a')->join('LEFT JOIN lib_component b ON a.name=b.name')->join('LEFT JOIN lib_userinfo d ON a.username=d.username')->where($where2)->limit($Page->firstRow.','.$Page->listRows)->select();
         //$info存储用户信息
        $info=array();
        foreach ($list as $v) {
            if(!(isset ($info[$v['username']])))
                    $info[$v['username']] = $v;
                
        }

        $count=$component_status->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        
        $this->assign('user',$userresult);
        $this->assign('list',$list);// 赋值数据集
        $this->assign('info',$info);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }
    public function examine(){
        $user=M('userinfo');
        $component=M('component');
        $recovery = M('recovery');
        $username = cookie('username');
        $userdata['username'] = $username;
        $userresult = $user->where($userdata)->find();

        $admin=M('admin');
        $admindata = Array(
            'username'=> $username
        );
        $adminresult = $admin->where($admindata)->find();
        $this->admin = $adminresult;

        if(!$adminresult){
            $this->redirect(share);
        }

        // $where='status=3';
        // $where2='a.status=3';
        
        
        $list = $recovery->field('a.name,a.username,a.number,b.img,d.address,d.phone')->alias('a')->join('LEFT JOIN lib_component b ON a.name=b.name')->join('LEFT JOIN lib_userinfo d ON a.username=d.username')->limit($Page->firstRow.','.$Page->listRows)->select();
         //$info存储用户信息
        $info=array();
        foreach ($list as $v) {
            if(!(isset ($info[$v['username']])))
                    $info[$v['username']] = $v;
                
        }

        $count=$recovery->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();// 分页显示输出
        
        $this->assign('user',$userresult);
        $this->assign('list',$list);// 赋值数据集
        $this->assign('info',$info);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出

        $this->display();
    }
    public function doRecovery(){
        $name = I('name');
        $username = I('username');
        $number = I('number');
        $recovery = M('recovery');
        $componentStatus = M('component_status');
        $data = Array(
            'name'=> $name,
            'username'=> $username,
            'number'=> $number
        );
        $dataRecovery = Array(
            'name'=> $name,
            'username'=> $username,
            'number'=> $number,
            'recovery'=>1
        );
        $componentStatus->where($data)->save($dataRecovery);
        $result = $recovery->add($data);
        if($result){
            $r_data['code'] = 200;
            $this->ajaxReturn($r_data, 'JSON');
        }else{
            $r_data['code'] = 400;
            $this->ajaxReturn($r_data, 'JSON');
        }
    }
    public function doExamine(){
        $name = I('name');
        $username = I('username');
        $number = I('number');
        $recovery = M('recovery');
        $componentStatus = M('component_status');
        $componentLog = M('component_log');
        $data = Array(
            'name'=> $name,
            'username'=> $username,
            'number'=> $number
        );
        $result = $recovery->where($data)->delete();
        $usernameadmin = cookie('username');
        $dataSave = Array(
            'name'=> $name,
            'username'=> $usernameadmin,
            'number'=> $number
        );
        $message = Array(
            'name'=>$name,
            'username'=>$usernameadmin,
            'status'=>3
        );
        $findResult = $componentStatus->where($message)->find();
        if($findResult){
            $data['status']=3;
            $componentStatus->where($data)->delete();           
            $componentStatus->where($message)->setInc('nownumber',$number);
        }else{
            $data['status']=3;
            $componentStatus->where($data)->save($dataSave);            
        }
        $addmessage = Array(
            'name'=>$name,
            'keeper_name'=>$usernameadmin,
            'status'=>3,
            'number'=>$number,
            'time'=>date('Y-m-d H:i',time()),
        );
        $componentLog->add($addmessage);
        if($result){
            $r_data['code'] = 200;
            $this->ajaxReturn($r_data, 'JSON');
        }else{
            $r_data['code'] = 400;
            $this->ajaxReturn($r_data, 'JSON');
        }
    }
}