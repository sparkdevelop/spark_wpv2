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
    //点击动态、我的书房等切换
    var $li = $('.navigate ul li');
    $li.click(function(){
        $(this).addClass("border");
        $(this).siblings().removeClass("border");
        var index = $li.index(this);
        $('.subnavigate > div').eq(index).show().siblings().hide();
    })
    //点击私人书籍等切换
    var $shareli = $('.bookmessage li');
    $shareli.click(function(){
        //$(this).addClass("activecolor");
        $(this).addClass("activecolor");
        $(this).siblings().removeClass("activecolor");
        var index = $shareli.index(this);
        $('.mybook > div').eq(index).show().siblings().hide();
    })
    //想读在读已读
    var $booktags = $('.booktags .bookmessage-nav>ul li');
    $booktags.click(function(){
        $(this).addClass("activecolor");
        $(this).siblings().removeClass("activecolor");
        var index = $booktags.index(this);
        $('.booktags .mybook  .submybook').eq(index).show().siblings().hide();
    });
    //取消关注
    var $cancel = $('.focus-bd .btn .cancel-btn');
    var $number = $('.focus-hd-number');
    var $friendnumber = $('.friend-number');
    $cancel.click(function(){
        var $id = $(this).next().val();
        var $friendname = $(this).next().next().val();
        $.ajax({
            url: 'http://www.makerway.space/makerway/index.php/Home/Index/friendhandle',
            type: 'POST',
            datatype: 'jsonp',
            data:{
                id: $id,
            }
        })
        $(this).parent().parent().remove();
        var $numbervalue = $number.text();
        $number.text(Number($numbervalue)-1);
        var $friendvalue = $friendnumber.text();
        $friendnumber.text(Number($friendvalue)-1);
    });
    //加关注
        var $addfriend = $('.add-attention');
        $addfriend.click(function(){
            if(cookie_val){
                var $friendname = $(this).next().text();
                if($(this).val() == '加关注'){
                    $.ajax({
                        url: 'http://www.makerway.space/makerway/index.php/Home/Index/friendhandle_add',
                        type: 'POST',
                        datatype: 'json',
                        data:{
                            friendname: $friendname,
                        },
                    })
                    $(this).val('已关注');
                    $(this).css('backgroundColor', '#5e99b3');
                }
            }else{
                alert("您还没有登录!!");
            }
        });

    //借阅书籍中的选择问题
    var $radio = $('.toTake form ul li');
    var $checkbox = $('.toTake form ul li input');
    var $allcheck = $('#allcheck');
    $radio.click(function(){
        $check = $(this).find('input');
        if($check.prop('checked')){
            $check.prop('checked',false);
        }else{
            $check.prop('checked',true);
        }
        if($radio.size() == $radio.find('input:checked').size()){
            $allcheck.prop('checked',true);
        }else{
            $allcheck.prop('checked',false);
        }
    })
    $checkbox.click(function(){
        $check = $(this).find('input');
        if($(this).prop('checked')){
            $(this).prop('checked',false);
        }else{
            $(this).prop('checked',true);
        }
        if($radio.size() == $radio.find('input:checked').size()){
            $allcheck.prop('checked',true);
        }else{
            $allcheck.prop('checked',false);
        }
    })
    $allcheck.click(function(){
        $(this).prop("checked",this.checked);
        if($(this).prop('checked')){
            $radio.find('input').prop('checked',true)
        }else{
            $radio.find('input').prop('checked',false)
        }
    });
    //写笔记的操作
    var $btn = $('.comment-message');
    var $comment = $('.do-comment');
    var $submybook = $('.submybook-first');
    var $exit = $('.exit');
    var $com = $('.com-n');
    var $writeexit = $('.write-exit');
    var $comm = $('.comment-comment-ul');
    $btn.click(function(){
        $comment.toggle();
        $submybook.hide();
    })
    $writeexit.click(function(){
        //$comment.toggle();
        var index = $writeexit.index(this);
        $comm.eq(index).hide();
    })
    $exit.click(function(){
        $comment.hide();
    })
    $com.click(function(){
        var index = $com.index(this);
        $comm.eq(index).toggle();
    })
    //赞同的操作
    var $commentspan = $(".comment-zannum");
    $commentspan.click(function(){
        var index = $commentspan.index(this);
        var $kk = $(this).attr("title");
            var $num = $('.comment-spannum').eq(index).text();
            var $note_id = $(this).parent().next().val();
            $.ajax({
                url: 'http://www.makerway.space/makerway/index.php/Home/Index/dobooknote_approve',
                type: 'POST',
                datatype: 'jsonp',
                data:{
                    note_id: $note_id,
                    num: Number($num),
                    val: $kk
                }
            });
            if($kk==""){
                $(this).attr("title","取消赞同");
                $('.comment-spannum').eq(index).text(Number($num)+1);
            }else if($kk=="取消赞同"){
                $(this).attr("title","");
                $('.comment-spannum').eq(index).text(Number($num)-1);
            }
    })
    //点击向下的图标显示相应的操作
    var $selectimg = $('.select-nav img');
    $selectimg.click(function(){
        $(this).next().toggle();
    });
    var $select = $('.select-nav ul li');
    $select.click(function(){
        var $selectvalue = $(this).text();
        var $book_id = $(this).next().text();
        console.log($book_id);
        var that = this;
        if($selectvalue != '写笔记'){
            $.ajax({
                url: 'http://www.makerway.space/makerway/index.php/Home/Index/personHandle',
                type: 'POST',
                datatype: 'json',
                data:{
                    book_id: $book_id,
                    method: $selectvalue
                },
                success:function(){
                    $(that).parent().parent().parent().remove();
                    if($selectvalue == '共享'){
                        var $personnumber = $('.personnumber').text();
                        $('.personnumber').text(Number($personnumber)-1);
                    }else if($selectvalue == '收回'){
                        var $sharenumber = $('.sharenumber').text();
                        $('.sharenumber').text(Number($sharenumber)-1);
                    }else if($selectvalue == '完成阅读'){
                        var $readingnumber = $('.readingnumber').text();
                        $('.readingnumber').text(Number($readingnumber)-1);
                    } else if($selectvalue == '开始阅读'){
                        var $wantnumber = $('.wantnumber').text();
                        $('.wantnumber').text(Number($wantnumber)-1);
                    }
                }
            });
        }
    });
})