$(function(){
    var allcookies = document.cookie;
    function getCookie(cookie_name)
    {
        var allcookies = document.cookie;
        var cookie_pos = allcookies.indexOf(cookie_name);   //索引的长度
        if (cookie_pos != -1)
        {
// 把cookie_pos放在值的开始，只要给值加1即可。
            cookie_pos += cookie_name.length + 1;      //这里我自己试过，容易出问题，所以请大家参考的时候自己好好研究一下。。。
            var cookie_end = allcookies.indexOf(";", cookie_pos);
            if (cookie_end == -1)
            {
                cookie_end = allcookies.length;
            }
            var value = unescape(allcookies.substring(cookie_pos, cookie_end)); //这里就可以得到你想要的cookie的值了。。。
        }
        return value;
    }
    var cookie_val = getCookie("username");
    //////借用

    var minus = $('[data-role="minus"]');
    minus.on('click', function(){
        if(!cookie_val){
            alert('请先登录');
            return;
        }
        var _this = $(this);
        var input = _this.next();
        var number = Math.floor(input.val());
        number -= 1;
        if(number < 0){
            return;
        }else{
            input.val(number);
        }
    });
    var plus = $('[data-role="plus"]');
    plus.on('click', function(){
        if(!cookie_val){
            alert('请先登录');
            return;
        }
        var _this = $(this);
        var input = _this.prev();
        var number = Math.floor(input.val());
        var left_number = _this.next().val();
        number += 1;
        if(number > left_number){
            return;
        }else{
            input.val(number);
        }
    });
    var numberUsing = $('[data-role="number"]');
    numberUsing.on('blur', function(){
        if(!cookie_val){
            alert('请先登录');
            return;
        }
        var _this = $(this);
        var left = Math.floor(_this.next().next().val());
        if(Math.floor(_this.val()) > left){
            alert('请小于库存量！');
            _this.val(left);
            return;
        }
    });
    var borrowNumber = $('.attention');
    borrowNumber.on('click', function(){
        if(!cookie_val){
            alert('请先登录');
            return;
        }
        var _this = $(this);
        var number_borrow = _this.siblings('[data-role="number"]').val();
        if(number_borrow <1 ){
            alert('借用数量大于0！');
            return;
        }
        var comId = _this.next().val();
        $.ajax({
            url: '/library/index.php/Home/Index/shop',
            type: 'POST',
            datatype: 'json',
            data:{
                val: number_borrow,
                id: comId
            },
            success:function(res){
                if(res.code == 200){
                    alert('已经加入购物车，请进入购物车进行借用确认！');
                    window.location.reload();    
                }  
            }
        });
    });

    // 物品分类
    var comUl = $('.com_ul li');
    comUl.on('click',function(){
        var type = $(this).html();
        $.ajax({
            url: '/library/index.php/Home/Index/share',
            type: 'POST',
            datatype: 'json',
            data:{
                type: $.trim(type)
            },
            success:function(res){ 
                window.location.href = '/library/index.php/Home/Index/share?type='+type
            }
        });
    });

    ////仅显示可借
    // var $input = $(".checkbox input");
    // $data = $input.is(':checked');
    // $input.click(function(event){
    //     //var index = $li.index(this);
    //     if($data){
    //         $val = 0;
    //         $.ajax({
    //             url: '/library/index.php/Home/Index/share',
    //             type: 'POST',
    //             datatype: 'jsonp',
    //             data:{
    //                 flag: $val
    //             },
    //             success:function(){
    //                 location.href="/library/index.php/Home/Index/share?flag="+$val;
    //             }
    //         });
    //     }else{
    //         $val = 1;
    //         $.ajax({
    //             url: '/library/index.php/Home/Index/share',
    //             type: 'POST',
    //             datatype: 'jsonp',
    //             data:{
    //                 flag: $val
    //             },
    //             success:function(){
    //                 location.href="/library/index.php/Home/Index/share?flag="+$val;
    //             }
    //         });
    //     }
    // });
})