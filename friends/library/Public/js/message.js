function check(){
    var $password = $("input[name='password']").val();
    var $rpassword = $("input[name='rpassword']").val();
    var $length = $password.length;
    if($password == "" || $password == null){
        alert("请输入原密码!!");
        return false;
    }
    if($rpassword == "" || $rpassword == null){
        alert("请输入新密码!!");
        return false;
    }
    if($length<6 || $length>16){
        alert("密码长度为6到16位！");
        return false;
    }
    if($rpassword.length<6 || $rpassword.length>16){
        alert("密码长度为6到16位！");
        return false;
    }
    return true;
}
function check1(){
    var $textarea = $(".textarea").val();
    if($textarea == "" || $textarea == null){
        alert("请输入个人描述!!");
        return false;
    }
    return true;
}
function check2(){
    var $imgresult = $('.img-result').attr('src');
    if($imgresult == "" || $imgresult == null){
        alert("选择头像!!");
        return false;
    }
    return true;
}
function check3(){
    // var $username = $("input[name='username']").val();
    var $phone = $("input[name='phone']").val();
    var $address = $("input[name='address']").val();
    var moblie= /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
    // if($username == "" || $username == null){
    //     alert("请输入用户名!");
    //     return false;
    // }
    if($phone == "" || $phone == null){
        alert("请输入手机号!!");
        return false;
    }
    if(!moblie.test($phone)){
        alert("请输入有效的手机号！");
        return false;
    }
    if($address == '' || $address == null ){
        alert("请输入地址！");
        return false;
    }
    return true;
}
$(function(){
    var $messageli = $('.message ul li');
    $messageli.click(function(){
        $(this).addClass("activecolor");
        $(this).siblings().removeClass("activecolor");
        var index = $messageli.index(this);
        $('.second-navigate > div').eq(index).show().siblings().hide();
    })
    $('.user_pic').change(function(){
        var $img = $('.changeimg');
        var fd=new FormData();
        fd.append('pic',$(this)[0].files[0]);
        $.ajax({
            type: 'POST',
            url:'/library/index.php/Home/Index/uploadUserPic',
            data:fd,
            contentType:false,
            cache: false,
            processData: false,
            success: function (data) {
                $('.file-img').attr('src',$('#public').val()+data.url);
                $('.img-result').attr('src',$('#public').val()+data.url);
                $img.val($('#public').val()+data.url);
            },
            error:function(){
                alert('上传失败');
            }
        });
    });
    //修改联系方式
    var $change1 = $('.change-message1');
    $change1.click(function(){
        $('.form').toggle();
        var $id = $(this).next().val();
        var $submit = $('.submit');
        $submit.click(function(){
            // var $username = $("input[name='username']").val();
            var $phone = $("input[name='phone']").val();
            var $select = $("[name='select']").val();
            var $building = $("input[name='building']").val();
            var $room = $("input[name='room']").val();
            $address = $select + $building + '楼' + $room + '室';
            var moblie= /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
            // if($username == "" || $username == null){
            //     alert("请输入用户名!");
            //     return false;
            // }
            if($phone == "" || $phone == null){
                alert("请输入手机号!!");
                return false;
            }
            if(!moblie.test($phone)){
                alert("请输入有效的手机号！");
                return false;
            }
            if($building == '' || $building == null ){
                alert("请输入地址！");
                return false;
            }
            if($room == '' || $room == null ){
                alert("请输入地址！");
                return false;
            }
            console.log($id);
            $.ajax({
                url:'/library/index.php/Home/Index/usermessage',
                type:'POST',
                datatype: 'json',
                data:{
                    phone: $phone,
                    address: $address,
                    id: $id
                },
                success:function(data){
                    if(data['flag'] == 1){
                        location.href='/library/index.php/Home/Index/message';
                    }else{
                        alert('修改失败！');
                    }
                }
            });
        });
    });

});
