/**
 * Created by huran on 2016/12.
 */
function check(){
    var $username = $("input[name='username']").val();
    var $password = $("input[name='password']").val();
    var $repwd = $("input[name='repwd']").val();
    var $length = $password.length;
    var $studentnumber = $("input[name='studentnumber']").val();
    var $phonenum = $("input[name='phone']").val();
    var $building = $("[name='building']").val();
    var $room = $("[name='room']").val();
    var $sex = $("input[name='sex']").val();
    var moblie= /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
    if($username == "" || $username == null){
        alert("请输入真实姓名!");
        return false;
    }
    if($studentnumber == "" || $studentnumber == null){
        alert("请输入学号!!");
        return false;
    }
    if($phonenum == "" || $phonenum == null){
        alert("请输入手机号!!");
        return false;
    }
    if(!moblie.test($phonenum)){
        alert("请输入有效的手机号！");
        return false;
    }
    if($password == "" || $password == null){
        alert("请输入密码!!");
        return false;
    }
    if($length<6 || $length>16){
        alert("密码长度为6到16位！");
        return false;
    }
    if($building == '' || $building == null ){
        alert("请输入楼号！");
        return false;
    }
    if($room == '' || $room == null ){
        alert("请输入室号！");
        return false;
    }
    if($password != $repwd){
        alert("两次密码不一致！");
        return false;
    }
    return true;
}