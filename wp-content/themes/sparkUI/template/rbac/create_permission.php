<script>
    function checkSubmitPermission() {
        var pname = document.getElementById('pname');
        if (checkRbacName(pname.value,'permission')) {
            return true;
        } else {
            layer.alert('请修正错误');
            return false;
        }
    }
    function checkRbacName(Name,type) {
        flag_name = false;
        if (Name.length == 0) {
            <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
            $("#checkNamebox").html("<img src='<?=$url?>'><span>权限名称不能为空</span>");
            return flag_name;
        }
        else {
            var data = {
                action: 'check_rbac_name',
                Name: Name,
                part: type

            };
            $.ajax({
                async: false,    //否则永远返回false
                type: "POST",
                url: "<?=admin_url('admin-ajax.php');?>",
                data: data,
                success: function (response) {
                    if (response == false) {
                        <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                        $('#checkNamebox').html("<img src='<?=$url?>'><span>该权限已存在</span>");
                    } else {
                        <?php $url = get_template_directory_uri() . "/img/OK.png";?>
                        $('#checkNamebox').html("<img src='<?=$url?>'>");
                        flag_name = true;
                    }
                }
            });
            return flag_name;
        }
    }
    function addToPostList() {
        var creation = $("input[name='creation']:checked").val();
        var input_id = '#postname';
        var name = $(input_id).val();
        var data = {
            action: 'rbac_hasPost',
            creation: creation,
            word: name
        };
        $.ajax({
            type: 'post',
            url: '<?=admin_url('admin-ajax.php')?>',
            data: data,
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if(response==false){
                    layer.msg("无此资源", {time: 2000, icon: 2})
                }else{
                    for(var i=0;i<response.length;i++){
                        //获取类型
                        var post_id = response[i][0];
                        var post_type = response[i][1];
                        //把下拉菜单关上,输入框清空
                        $('#autocomplete-post').css('display', 'none');
                        $(input_id).val('');
                        //step1:执行逻辑是先加入一行,包括一个多选框和一个数据
                        var tr = '<tr class="warning" >' +
                            '<td id="hidden_id">' + post_id + '</td>' +
                            '<td>' + name + '</td>' +
                            '<td>' + post_type + '</td>' +
                            '</tr>';
                        $('#post-choose-table-border tbody:last').append(tr);    //添加数据
                        var $tbr = $('#post-choose-table-border tbody tr:last');
                        var $checkItemTd = $('<td><input type="checkbox" name="checkItem[]" value='+post_id+' checked/></td>');   //添加复选框
                        $tbr.prepend($checkItemTd);
                        $tbr.find('input').click(function (event) {
                            /*调整选中行的CSS样式*/
                            $(this).parent().parent().toggleClass('warning');
                            /*阻止向上冒泡，以防再次触发点击操作*/
                            event.stopPropagation();
                        });
//
                    }
                }
            }
        })
    }

    $(function () {   //模糊查询
        $("#postname").keyup(function () {
            var creation = $("input[name='creation']:checked").val();
            var word = $(this).val();
            var data = {
                action: 'rbac_post_autocomplete',
                creation:creation,
                word: word
            };
            $.ajax({
                type: 'post',
                url: '<?=admin_url('admin-ajax.php')?>',
                data: data,
                dataType: 'json',
                success: function (response) {
                    var arr = response;
                    var li = "";
                    var ac_id = "#autocomplete-post";
                    if (arr.length != 0) {
                        $.each(arr, function (i, val) {
                            if(creation=='name'){
                                li += "<li class='list-group-item'>" + val.post_title + "</li>";
                            } else {
                                li += "<li class='list-group-item'>" + val.name + "</li>";
                            }
                        });
                        $(ac_id + " ul").html(li);
                        $(ac_id).slideDown('fast');
                        //鼠标经过元素的背景颜色改变
                        $(ac_id + " ul li").bind('mouseenter', function () {
                            $(this).css({'background': '#e9e8e9'})
                        });
                        $(ac_id + " ul li").bind('mouseleave', function () {
                            $(this).css({'background': 'transparent'})
                        });
                        $(ac_id + " ul li").bind('click', function () {
                            $("#postname").val($(this).html());
                            $(ac_id).slideUp('fast');
                        });
                    }
                    else {
                        $(ac_id).slideUp('fast');
                    }
                }
            })
        });
    });
</script>
<style>
    #postname{
        width: 80%;
        display: inline;
    }
    .btn-green{
        margin: 0px 10px;
        height:34px;
    }
    #autocomplete-post {
        width: 80%;
        margin-top: -2px;
    }
</style>
<div class="col-md-12 col-sm-12 col-xs-12" id="col9">
    <h4 class="index_title">新建权限</h4>
    <div class="divline"></div>

    <form class="form-horizontal" role="form" name="profile" method="post" enctype="multipart/form-data"
          action="<?php echo esc_url(self_admin_url('process-permission.php')); ?>" onsubmit="return checkSubmitPermission();">
        <div class="form-group" style="margin: 20px 0px">
            <label for="pname" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">权限名称<span
                    style="color: red">*</span></label>
            <div class="col-sm-6 col-xs-12">
                <input type="text" class="form-control" name="pname" id="pname" placeholder="请输入权限名称" value=""
                       onblur="checkRbacName(this.value,'permisssion')"/>
            </div>
            <span style="line-height: 30px;height: 30px;" id="checkNamebox"></span>
        </div>
        <!--权限说明-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="pabstract" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">权限说明<span
                    style="color: red">*</span></label>
            <div class="col-sm-8 col-md-8 col-xs-12">
                <?php wp_editor('', 'pabstract', $settings = array(
                    'teeny' => true, 'textarea_rows' => 6)
                );
                ?>
            </div>
        </div>

<!--        创建方式-->
        <div class="form-group" style="margin: 20px 0px;margin-bottom: 0px">
            <label for="creation" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">创建方式
                <span style="color: red">*</span></label>
            <div class="col-sm-8 col-md-8 col-xs-12" style="margin-top: 7px">
                <input type="radio" id="byname" name="creation" value="name" style="display: inline-block" checked/><span> 按名称创建</span>&nbsp;&nbsp;
                <input type="radio" id="bycate" name="creation" value="cate" style="display: inline-block;margin-left: 30px"/><span> 按分类创建</span>&nbsp;&nbsp;
                <input type="radio" id="bytag" name="creation" value="tag" style="display: inline-block;margin-left: 30px"/><span> 按标签创建</span>
            </div>
        </div>

<!--        检索资源-->
        <div class="form-group" style="margin: 20px 0px;margin-bottom: 0px">
            <label for="searchpost" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">检索资源
                <span style="color: red">*</span></label>
            <div class="col-sm-8 col-md-8 col-xs-12">
                <input type="text" class="form-control" id='postname' placeholder="请输入资源标题/分类名称/标签名称">
                <input type="button" class="btn btn-green" onclick="addToPostList()" value="搜索">
                <div id="autocomplete-post" style="display: none">
                    <ul class="list-group"></ul>
                </div>
            </div>

        </div>

<!--        对应资源-->
        <div class="form-group" style="margin: 20px 0px;margin-bottom: 0px">
            <label for="showpost" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">对应资源
                <span style="color: red">*</span></label>
            <div class="col-sm-8 col-md-8 col-xs-12" style="margin-top: -10px">
<!--                资源展示table-->
                <div id="post-info-table">
                    <table id="post-choose-table-border" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th colspan="4">已选择资源</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>资源ID</th>
                            <th>资源名称</th>
                            <th>资源类型</th>
                        </tr>
                        </thead>
                        <tbody id="post_tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--        隐藏信息-->
        <div class="form-group">
            <input type="hidden" name="pauthor" value="<?= get_current_user_id() ?>">
            <input type="hidden" name="pcreatedate" value="<?= date("Y-m-d H:i:s", time() + 8 * 3600) ?>">
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" name="save-btn" id="save-btn" value="保存">
            </div>
        </div>
    </form>
</div>