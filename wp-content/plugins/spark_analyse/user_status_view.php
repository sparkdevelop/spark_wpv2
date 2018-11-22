<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/10/010
 * Time: 11:06
 */

//
//    $time_score=get_method();
//    $time=$time_score[0];
//    $score=$time_score[1];
//    get_method(35);
//    $c=count($a);
//require_once('user_status.php');
function spark_settings_submenu_page5(){
?>
    <!DOCTYPE html>
    <html >
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>用户分析</title>
        <script type="text/javascript">

        </script>
    </head>

    <body style=" background-color: #f1f2f7; ">
    <div class="container">
        <p style="font-size: 18px;    margin: 8px;">系统统计</p>
        <div class="row">
            <div class="col-md-6" style="background-color: white;width: 47%">
                <p style="margin-top: 20px; margin-left: 10px;">学生学习进度(内链)</p>
                <ul class="disc">
                    <li><?php $c=history_show(); echo $c[0]?></li>
                    <li><?php  echo $c[1]?></li>
                    <li><?php  echo $c[2]?></li>
                    <li><?php  echo $c[3]?></li>
                    <li><?php  echo $c[4]?></li>
                    <li><?php  echo $c[5]?></li>
                    <li><?php  echo $c[6]?></li>
                    <li><?php  echo $c[7]?></li>
                    <li><?php  echo $c[8]?></li>
                    <li><?php  echo $c[9]?></li>
                </ul>

            </div>
            <div class="col-md-6" style="background-color: white;width: 47%">
                <p style="margin-top: 20px; margin-left: 10px;">学生学习进度（外链）</p>

                <ul class="circle">
                    <li><?php $c=chain_backward(); echo $c[0]?></li>
                    <li><?php  echo $c[1]?></li>
                    <li><?php  echo $c[2]?></li>
                    <li><?php echo $c[3]?></li>
                    <li><?php echo $c[4]?></li>
                    <li><?php  echo $c[5]?></li>
                    <li><?php  echo $c[6]?></li>
                    <li><?php  echo $c[7]?></li>
                    <li><?php  echo $c[8]?></li>
                    <li><?php  echo $c[9]?></li>
                </ul>
            </div>
        </div>
        <div class="row">

            <div class="col-md-6" style="background-color: white;width: 47%">
                <p style="margin-top: 20px; margin-left: 10px;">毫无进度的学生</p>
                    <?php $noundata= noundata(); ?>
                共有：<?php echo $c=count($noundata);?>人
                分别是：
                <?php print_r($noundata)?>
            </div>
            <div class="col-md-6" style="background-color: white;width: 47%">
                <p style="margin-top: 20px; margin-left: 10px;">进度落后的学生</p>
                <?php $user_backward=is_user_backward();?>
                共有：<?php echo $c=count($user_backward);?>人
                分别是：
                <?php print_r($user_backward)?>
            </div>
        </div>
    </div>


    </body>
    </html>
<?php
}
