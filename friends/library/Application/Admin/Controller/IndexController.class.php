<?php
/**
 * Author: huran
 * CreateTime: 2016/4/13 9:21
 * description:
 */
namespace Admin\Controller;
use Think\Controller;
header('Content-Type:text/html; charset=utf-8');
class IndexController extends Controller {
	//首页的header，包括makerway，用户管理，书籍管理等。
	public function header(){
		$this->display();
	}
	//登录界面
	public function login(){
		$this->display();
	}
	//点击注销，登出
	public function logout(){
		$adminname = cookie("adminname");
		if($adminname){
			cookie('adminname',null);
			$this->redirect(login);
		}else{
			$this->redirect(login);
		}
	}
	//验证登录用户名和密码，验证成功跳转
	public function loginCheck(){
		$adminname = I('adminname');
		$password = I('password');
		$userInfo = M('book_admin');
		$userData["username"] = $adminname;
		$nameresult = $userInfo->where($userData)->find();
		if(!$nameresult){
			$this->error("用户名不存在！！",U(login),1);
		}
		$userData["password"] = $password;
		$result = $userInfo->where($userData)->find();
		if(!$result){
			$this->error("密码不正确！！",U(login),1);
		}
		cookie("adminname",$adminname,'/');
		$this->success("登录成功！！",U(index),1);
	}
	//后台主页面
	public function index(){
		$adminname = cookie("adminname");
		if($adminname){
			$this->display();
		}else{
			$this->redirect(login);
		}
	}




    public function books(){
    	$b=M('book');
    	$bl=M('booklog');
    	$bi=M('bookinfo');
    	$books=$b->order('book_id asc')->select();
    	foreach ($books as $id => $book) {
    		$booklog=$bl->where(array('book_id'=>$book['book_id']))->order('log_id asc')->select();
    		$books[$id]['booklog']=$booklog;
    		$bookinfo=$bi->where(array('isbn'=>$book['isbn']))->find();
    		$books[$id]['bookinfo']=$bookinfo;
    	}
    	$this->books=$books;
    	$this->display();
    }
    public function deleteBook(){
    	$b=M('book');
    	$bl=M('booklog');
    	if ($b->where(I())->delete()) {
    		$bl->where(I())->delete();
    		$this->success('删除书成功',U(books),3);
    	}else{
    		$this->error('删除书失败',U(books),3);
    	}
    }
    public function users(){
    	$b=M('book');
    	$bl=M('booklog');
    	$bi=M('bookinfo');
    	$bu=M('book_user_info');
    	$users=$bu->order('book_user_info_id asc')->select();
    	foreach ($users as $key => $user) {
    		$books=$b->where(array('owner_name'=>$user['username']))->select();
    		$users[$key]['books']=$books;
    		foreach ($users[$key]['books'] as $id => $book) {
    		$booklog=$bl->where(array('book_id'=>$book['book_id']))->order('log_id asc')->select();
    		$users[$key]['books'][$id]['booklog']=$booklog;
    		$bookinfo=$bi->where(array('isbn'=>$book['isbn']))->find();
    		$users[$key]['books'][$id]['bookinfo']=$bookinfo;
	    	}
    	}
    	$this->users=$users;
    	$this->display();
    }
    public function deleteUser(){
    	$b=M('book');
    	$bl=M('booklog');
    	$bi=M('bookinfo');
    	$bu=M('book_user_info');
    	$user=$bu->where(I())->find();

    	if($bu->where(I())->delete()){
    		$books=$b->where(array('owner_name'=>$user['username']))->select();
    		$b->where(array('owner_name'=>$user['username']))->delete();
    		foreach ($books as $key => $book) {
    			$bl->where(array('book_id'=>$book['book_id']))->delete();
    		}
    		$this->success('删除用户成功',U(users),3);
    	}else{
    		$this->error('删除用户失败',U(users),3);
    	}

    }

}