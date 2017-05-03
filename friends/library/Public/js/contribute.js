$(function(){
    var $sureButton = $('.sure-submit');
    //点击提交按钮时的验证消息
    $sureButton.click(function(){
        var name = $('input[name="name"]').val();
        var img = $('input[name="imgpic"]').val();
        var number = $('input[name="number"]').val();
        var tag = $('[name="tag"]').val();
        var summary = $('[name="summary"]').val();
        if(name == "" || name == null){
            alert("请输入物品名称!");
            return false;
        }
        if(img == "" || img == null){
            alert("请选择物品图片!");
            return false;
        }
        if(number == "" || number == null){
            alert("请选择物品数量!");
            return false;
        }
        if(summary == "" || summary == null){
            alert("请选择物品简介!");
            return false;
        }
        $.ajax({
            url:'/library/index.php/Home/Index/doContribute',
            type:'post',
            datatype: 'json',
            data:{
                name: name,
                img: img,
                number: number,
                tag: tag,
                summary: summary
            },
            success:function(data){
                alert('上传成功');
                window.location.reload();
            }
        });
    });
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
                $('.img-result').attr('src',$('#public').val()+data.url);
                $('input[name="imgpic"]').attr('value',$('#public').val()+data.url);
            },
            error:function(){
                alert('上传失败');
            }
        });
    });
})