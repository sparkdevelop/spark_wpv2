function check(){
    var $username = $("input[name='username']").val();
    var $password = $("input[name='password']").val();
    if($username == "" || $username == null){
        alert("请输入用户名!");
        return false;
    }
    if($password == "" || $password == null){
        alert("请输入密码!!");
        return false;
    }
    return true;
}
