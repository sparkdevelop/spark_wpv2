$(document).ready(function(){
    function __del_repair(){
    
    }

    function __del_user(){
    
    }

    //checkbox全选与取消全选
    $("#all").click(function(){   
        if(this.checked){   
           $(".check").prop("checked", true);  
        }else{   
           $(".check").prop("checked", false);
        }   
    });
    
    //归还js
    $('.back-link').click(function(){
        name=$(this).data('name');
        $('#backNumStr').html(name);
        number = $(this).data('number');
        $('#backNum').val(number)
        $('.main-tan').show();
    });
    $('.back-link').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
    $('#backNumAck').click(function(){
        backNum=$('#backNum').val();
        if(backNum > number){
            alert('数量请小于在借数量！');
            return false;
        }
        if(backNum < 1){
            alert('请填写正数！');
            return false;
        }
        $.ajax({
            url: '/library/index.php/Home/Index/back',
            type: 'POST',
            datatype: 'json',
            data:{
                num: backNum,
                name: name
            },
            success:function(res){ 
                if(res.code = 200){
                    alert('已成功归还！'); 
                    window.location.reload();                   
                }else{
                    alert('操作失败！');
                    window.location.reload();
                }
            }
        });
        // window.location.href='/library/index.php/Home/Index/back/num/'+backNum+'/name/'+name;
    });
    $('.closetrouble').click(function(){
     $('#backmodal').css('display','none');
        $('.main-tan').hide();
    });

    //报修js
    $('.trouble-link').click(function(){
        $('.main-tan').show();
        name=$(this).data('name');
        number = $(this).data('number');
        $('#troubleNum').val(number);
        $('#troubleNumStr').html(name);
    });
    $('.trouble-link').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
    $('#troubleNumAck').click(function(){

        troubleNum=$('#troubleNum').val();
        if(troubleNum > number){
            alert('数量请小于在借数量！');
            return false;
        }
        if(troubleNum < 1){
            alert('请填写正数！');
            return false;
        }
        $.ajax({
            url: '/library/index.php/Home/Index/trouble',
            type: 'POST',
            datatype: 'json',
            data:{
                num: troubleNum,
                name: name
            },
            success:function(res){ 
                if(res.code = 200){
                    alert('报修成功！'); 
                    window.location.reload();                   
                }else{
                    alert('操作失败！');
                    window.location.reload();
                }
            }
        });
        // window.location.href='/library/index.php/Home/Index/trouble/num/'+troubleNum+'/name/'+name;
    });
    $('.closetrouble').click(function(){
     $('#troublemodal').css('display','none');
        $('.main-tan').hide();
    });

    //借用js
    $('.reback-link').click(function(){
        name=$(this).data('name');
        $('#rebackNumStr').html(name);
        number = $(this).data('number');
        rebackNum=$('#rebackNum').val(number);
        $('.main-tan').show();
    });
    $('.reback-link').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
    $('#rebackNumAck').click(function(){
        rebackNum=$('#rebackNum').val();
        if(rebackNum > number){
            alert('数量请小于在借数量！');
            return false;
        }
        if(rebackNum < 1){
            alert('请填写正数！');
            return false;
        }
        $.ajax({
            url: '/library/index.php/Home/Index/reback',
            type: 'POST',
            datatype: 'json',
            data:{
                num: rebackNum,
                name: name
            },
            success:function(res){ 
                if(res.code = 200){
                    alert('借用成功！'); 
                    window.location.reload();                   
                }else{
                    alert('操作失败！');
                    window.location.reload();
                }
            }
        });
        // window.location.href='/library/index.php/Home/Index/reback/num/'+rebackNum+'/name/'+name;
    });
    $('.closetrouble').click(function(){
     $('#rebackmodal').css('display','none');
        $('.main-tan').hide();
    });


    // 回收
    $('.link-update').click(function(){
        var username = $(this).data('name');
        var name = $(this).data('role');
        var number = $(this).data('number');
        $.ajax({
            url: '/library/index.php/Home/Index/doRecovery',
            type: 'POST',
            datatype: 'json',
            data:{
                name: name,
                username: username,
                number: number
            },
            success:function(res){ 
                if(res.code = 200){
                    alert('已添加到待审核物品中！'); 
                    window.location.reload();                   
                }else{
                    alert('操作失败！');
                    window.location.reload();
                }
            }
        });
    });
    // 入库
    $('.link-examine').click(function(){
        var name = $(this).data('name');
        var username = $(this).data('username');
        var number = $(this).data('number');
        $.ajax({
            url: '/library/index.php/Home/Index/doExamine',
            type: 'POST',
            datatype: 'json',
            data:{
                name: name,
                username: username,
                number: number
            },
            success:function(res){ 
                if(res.code = 200){
                    alert('入库成功！');  
                    window.location.reload();                  
                }else{
                    alert('操作失败！');
                    window.location.reload();
                }
            }
        });
    });
    // 取消保修
    $('.link-canl').click(function(){
        $('.main-tan').show();
        $('#cancelmodal').css('display','');
        name = $(this).data('name');
        number = $(this).data('number');
    });
    $('.link-canl').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
    $('#cancelNumAck').click(function(){
        $.ajax({
            url: '/library/index.php/Home/Index/cancel',
            type: 'POST',
            datatype: 'json',
            data:{
                number: number,
                name: name
            },
            success:function(res){ 
                if(res.code == 200){
                    $('#cancelmodal').css('display','none');
                    alert('操作成功！');
                    window.location.reload();
                }else{
                    alert('操作失败！');
                    window.location.reload();
                }
            }
        });
    });
    $('.closetrouble').click(function(){
        $('#cancelmodal').css('display','none');
        $('.main-tan').hide();
    });
    // 删除用户
    $('.del-user').click(function(){
        $('.main-tan').show();
        $('#delmodal').css('display','');
        id = $(this).data('id');
    });
    $('.del-user').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
    $('#delNumAck').click(function(){
        $.ajax({
            url: '/library/index.php/Home/Index/deluser',
            type: 'POST',
            datatype: 'json',
            data:{
                id: id
            },
            success:function(res){ 
                if(res.code == 200){
                    $('#delmodal').css('display','none');
                    alert('操作成功！');
                    window.location.reload();
                }else{
                    alert('操作失败！');
                    window.location.reload();
                }
            }
        });
    });
    $('.closetrouble').click(function(){
        $('#delmodal').css('display','none');
        $('.main-tan').hide();
    });
    // 后台保修操作
    $('.link-guarantee').click(function(){
        $('.main-tan').show();
        $('#guaranteemodal').css('display','');
        username = $(this).data('username');
        name = $(this).data('name');
        number = $(this).data('number');
        role = $(this).data('role');
    });
    $('.link-guarantee').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
    $('#guaranteeNumAck').click(function(){
        $.ajax({
            url: '/library/index.php/Home/Index/confirm',
            type: 'POST',
            datatype: 'json',
            data:{
                username: username,
                name: name,
                number: number,
                role: role
            },
            success:function(res){ 
                if(res.code == 200){
                    $('#guaranteemodal').css('display','none');
                    alert('操作成功！');
                    window.location.reload();
                }else{
                    alert('操作失败！');
                    window.location.reload();
                }
            }
        });
    });
    $('.closetrouble').click(function(){
        $('#guaranteemodal').css('display','none');
        $('.main-tan').hide();
    });
    // 确认借用
    $('.conborrow-link').click(function(){
        $('.main-tan').show();
        $('#conborrowmodal').css('display','');
        username = $(this).data('username');
        name = $(this).data('name');
        number = $(this).data('number');
    });
    $('#conborrowAck').click(function(){
        var remarkName = $('#remarkName').val();
        $.ajax({
            url: '/library/index.php/Home/Index/conborrow',
            type: 'POST',
            datatype: 'json',
            data:{
                username: username,
                name: name,
                number: number,
                remark: remarkName
            },
            success:function(res){ 
                if(res.code == 200){
                    $('#conborrowmodal').css('display','none');
                    alert('借用成功！');
                    window.location.reload();
                }else{
                    alert('操作失败！');
                    window.location.reload();
                }
            }
        });
    });
    $('.conborrow-link').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
    $('.closetrouble').click(function(){
        $('#conborrowmodal').css('display','none');
        $('.main-tan').hide();
    });
    // 删除借用
    $('.delborrow-link').click(function(){
        $('.main-tan').show();
        $('#delborrowmodal').css('display','');
        username = $(this).data('username');
        name = $(this).data('name');
        number = $(this).data('number');
    });
    $('#delborrowAck').click(function(){
        // var remarkName = $('#remarkName');
        $.ajax({
            url: '/library/index.php/Home/Index/delborrow',
            type: 'POST',
            datatype: 'json',
            data:{
                username: username,
                name: name,
                number: number
            },
            success:function(res){ 
                if(res.code == 200){
                    $('#delborrowmodal').css('display','none');
                    alert('删除成功！');
                    window.location.reload();
                }else{
                    alert('操作失败！');
                    window.location.reload();
                }
            }
        });
    });
    $('.delborrow-link').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
    $('.closetrouble').click(function(){
        $('#delborrowmodal').css('display','none');
        $('.main-tan').hide();
    });
}); 
