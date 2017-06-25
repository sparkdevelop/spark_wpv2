<?php //未写JS ?>
<div class="col-md-9 col-sm-9 col-xs-12"  id="col9">
    <h4 class="index_title" style="margin-left: 20px">填写群组信息</h4>
    <div class="divline"></div>

    <form class="form-horizontal" role="form" name="profile" method="post"
          action="<?php echo esc_url( self_admin_url('process-group.php') );?>" onsubmit="return checkSubmitGroup();">
        <!--群组名称-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="gname" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">群组名称<span style="color: red">*</span></label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="gname" id="gname" placeholder=""  value=""/>
            </div>
            <span style="line-height: 30px;height: 30px" id="checkGroupNamebox"></span>
        </div>
        <!--群组简介-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="gabstract" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">群组简介<span style="color: red">*</span></label>
            <div class="col-sm-6">
                <textarea class="form-control" rows="5" name="gabstract" id="gabstract" placeholder=""></textarea>
            </div>
            <span style="line-height: 30px;height: 30px" id="checkGroupAbsbox"></span>
        </div>
        <!--群组状态-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="gstatus" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">群组状态<span style="color: red">*</span></label>
            <div class="col-sm-6" style="margin-top: 7px">
                <input type="radio" id="gopen" name="gstatus" value="open" style="display: inline-block" checked/><span>开启</span>&nbsp;&nbsp;
                <input type="radio" id="gclose" name="gstatus" value="close" style="display: inline-block" /><span>关闭</span>
                <p style="margin-top: 5px">注:关闭群组后仅管理员可见</p>
            </div>
        </div>
        <!--加入方式-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="gstatus" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">加入方式<span style="color: red">*</span></label>
            <div class="col-sm-6" style="margin-top: 7px">
                <input type="radio" id="freejoin" name="gjoin" value="freejoin" style="display: inline-block"/> <span>自由加入</span>&nbsp;&nbsp;
                <input type="radio" id="verifyjoin" name="gjoin" value="verifyjoin" style="display: inline-block" checked /><span>检验审核加入</span>&nbsp;&nbsp;
                <input type="radio" id="verify" name="gjoin" value="verify" style="display: inline-block" /><span>审核加入</span>
            </div>
        </div>
        <!--发布任务-->
        <div class="form-group" style="margin: 20px 0px">
            <label for="gstatustask" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">发布任务<span style="color: red">*</span></label>
            <div class="col-sm-6" style="margin-top: 7px">
                <input type="radio" id="gadmin" name="gstatustask" value="admin" checked style="display: inline-block"/><span>仅管理员</span>
                <input type="radio" id="gall" name="gstatustask" value="all" style="display: inline-block" /><span>所有组员</span>
            </div>
        </div>
        <!--群组图标-->
        <div class="form-group" style="margin: 20px 0px;margin-bottom: 0px">
            <label for="gava" class="col-sm-2 col-md-2 col-xs-12 control-label" style="float: left">发布任务<span style="color: red">*</span></label>
            <div class="col-sm-6" style="margin-top: 7px">
                <input type="file" id="gava"/>
                <p style="margin-top: 5px">注:文件应小于512KB</p>
            </div>
        </div>
        <canvas width="100px" height="100px" id="canvas" style="margin-left: 160px"></canvas>
        <script>
            $(function () {
                $("#canvas").hide();
                $("#gava").change(function () {
                    var picurl = getObjectURL(this.files[0]);
                    var ctx = document.getElementById('canvas').getContext('2d');
                    var imageObj = new Image();
                    imageObj.onload = function() {
                        var img_w =this.width;
                        var img_h =this.height;
                        if(img_w>=img_h){
                            ctx.drawImage(imageObj,((img_w-img_h) / 2),0,img_h,img_h,0,0,100,100);
                            //$("#canvas").css("-webkit-border-radius","60px");
                        }
                        else{
                            ctx.drawImage(imageObj,0,((img_h-img_w) / 2),img_w,img_w,0,0,100,100);
                            //$("#canvas").css("-webkit-border-radius","60px");
                        }
                    };
                    imageObj.src = picurl;
                    $("#canvas").show();
                })
            });

            function getObjectURL(file) {
                var url = null;
                if (window.createObjectURL!=undefined) { // basic
                    url = window.createObjectURL(file) ;
                } else if (window.URL!=undefined) { // mozilla(firefox)
                    url = window.URL.createObjectURL(file) ;
                } else if (window.webkitURL!=undefined) { // webkit or chrome
                    url = window.webkitURL.createObjectURL(file) ;
                }
                return url ;
            }
        </script>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-default" id="save-btn" value="创建群组">
            </div>
        </div>
    </form>
</div>