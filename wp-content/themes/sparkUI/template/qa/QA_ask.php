<?php
/*
本页面是我要提问页面的content
 */
global $post;
wp_enqueue_media();
$admin_url = admin_url('admin-ajax.php');
?>
<div class="col-md-9 col-sm-9 col-xs-12" id="col9">
    <h4 class="ask_topic">提 问</h4>

    <style>
        #Spark_question_submit_form {
            margin-bottom: 30px;
        }

        .btn-green {
            width: 120px;
            height: 45px;
            border: 1px solid #e5e5e5;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 30px;
        }
    </style>


    <form method="post" class="dwqa-content-edit-form" id="Spark_question_submit_form"
          onsubmit="return submitCheckQA();">
        <!--    标题栏-->
        <p class="dwqa-search">
            <?php
            $current_user = wp_get_current_user();

            $title = isset($_POST['question-title']) ? sanitize_title($_POST['question-title']) : ''; ?>
            <input type="text" style="margin-top: 20px;"
                   data-nonce="<?php echo wp_create_nonce('_dwqa_filter_nonce') ?>"
                   id="question-title" name="question-title" value="<?php echo $title ?>" tabindex="1" _moz_abspos=""
                   onkeydown="if(event.keyCode==13) return false;"/>
            <span id="title_none"></span>
        </p>

        <?php $content = isset($_POST['question-content']) ? sanitize_text_field($_POST['question-content']) : ''; //如果没有内容应该跳出警告?>
        <p>
            <?php dwqa_init_tinymce_editor(array('content' => $content, 'textarea_name' => 'question-content', 'id' => 'question-content')) ?>
        </p>

        <?php global $dwqa_general_settings; ?>
        <?php if (isset($dwqa_general_settings['enable-private-question']) && $dwqa_general_settings['enable-private-question']) : ?>
            <p>
                <label for="question-status"><?php _e('Status', 'dwqa') ?></label>
                <select class="dwqa-select" id="question-status" name="question-status">
                    <optgroup label="<?php _e('Who can see this?', 'dwqa') ?>">
                        <option value="publish"><?php _e('Public', 'dwqa') ?></option>
                        <option value="private"><?php _e('Only Me &amp; Admin', 'dwqa') ?></option>
                    </optgroup>
                </select>
            </p>
        <?php endif; ?>
        <!--    分类部分-->
        <p>
            <label for="question-category">选择问题分类</label>

            <?php
            $Question_cat_ID = get_dwqa_cat_ID('Questions');
            wp_dropdown_categories(array(
                //'show_option_all'=>__( 'Select question category', 'dwqa' ),
                'name' => 'question-category',
                'id' => 'question-category',
                'taxonomy' => 'dwqa-question_category',
                //'show_option_none' => __( 'Select question category', 'dwqa' ),
                'show_option_none' => '',
                'hide_empty' => 0,
                'show_count' => true,
                'child of' => 2,
                'exclude' => $Question_cat_ID,
                // 'quicktags'     => array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,spell,close' ),
                'selected' => isset($_POST['question-category']) ? sanitize_text_field($_POST['question-category']) : false,
            ));
            ?>
        </p>
        <span id="category_none"></span>
        <!--    tag部分-->

        <?php
        global $wpdb;
        $tag_id = array();
        $tag_name = array();//存储每个链接的名字;
        //==============获取所有tag信息===============
        $tag = get_terms('dwqa-question_tag', array_merge(array('orderby' => 'count', 'order' => 'DESC')));
        ?>
        <p style="margin-bottom: 0px">
            <label for="question-tag"><?php _e('Tag', 'dwqa') ?></label>
            <input type="text" class="" name="question-tag"
                   id="Spark_question-tag" value="" onkeyup="checkTagNum(this.value)" placeholder="标签之间用逗号隔开"/>

            <label for="question-popular-tag" style="margin-top: 10px">常用标签:</label>
            <?php $tags = isset($_POST['question_tag']) ? sanitize_text_field($_POST['question_tag']) : ''; ?>
        <div>
            <?php for ($i = 0; $i < 10; $i++) { ?>
                <input type="button" name="add-question-tag" class="btn btn-default"
                       style="background-color:#ffe9e1;border-color:transparent;color:#fe642d;outline: none"
                       id="addTag_<?= $i ?>" value="<?= $tag[$i]->name ?>"
                       onclick="addTag_<?= $tag[$i]->name ?>(this.value)"/>
                <script>
                    function addTag_<?=$tag[$i]->name?>(value) {
                        var tag = document.getElementById('Spark_question-tag');
                        var alertTag = document.getElementById("alertTag");
                        var addTag = document.getElementById("addTag_<?=$i?>");

                        if (judgeRepeatTag(value) == false) { //如果是相同的点击,不在计数里判断
                            tag.value = tag.value.replace(value + ',', ''); //去掉当前的重复值
                            addTag.style.border = "1px solid"; //若取消选择,style。恢复未选择状态
                            addTag.style.borderColor = "transparent";
                            addTag.style.background = "";
                            addTag.style.backgroundColor = "#ffe9e1";
                            addTag.style.color = "#fe642d";
                            tag.readOnly = false; //可以继续输入。
                        }
                        else { //若是添加新标签
                            if (tag.value.length == 0 || tag.value.split(",").length <= 3) {
                                tag.readOnly = false; //可以继续输入
                                tag.value = tag.value + value + ","; //添加标签
                                addTag.style.border = "1px solid";
                                addTag.style.borderColor = "#fe642d";
                                addTag.style.color = "white";
                                addTag.style.background = "url('<?php bloginfo("template_url")?>/img/check.png') no-repeat scroll top right #fe642d";
                                checkTagNum(tag.value);
                            }
                            else {
                                checkTagNum(tag.value);
                            }
                        }
                    }
                    function judgeRepeatTag(value) {
                        var tag = document.getElementById('Spark_question-tag');
                        var split_value = tag.value.split(",");
                        var flag = true;
                        for (i = 1; i <= split_value.length; i++) {
                            if (split_value[i - 1] == value) {
                                flag = false;
                            }
                        }
                        return flag;
                    }
                </script>
            <?php } ?>
        </div>
        <span id="alertTag"></span>
        <span><input type="button" class="btn btn-default" id="deleteTag" onclick="deleteTags()" style="display: none"
                     value="删除标签"/></span>
        </p>

        <p>
            <label for="question-score">悬赏分:</label>
            <input type="text" placeholder="如不悬赏,可不填写" id="offer" name= "offer" onblur="checkScore(this.value)"
                   value="" style="width: 20%"/>
            <span id="score-flag"></span>
        </p>


        <?php if (dwqa_current_user_can('post_question') && !is_user_logged_in()) : ?>
            <p>
                <label for="_dwqa_anonymous_email"><?php _e('Your Email', 'dwqa') ?></label>
                <?php $email = isset($_POST['_dwqa_anonymous_email']) ? sanitize_email($_POST['_dwqa_anonymous_email']) : ''; ?>
                <input type="email" class="" name="_dwqa_anonymous_email" value="<?php echo $email ?>"/>
            </p>
            <p>
                <label for="_dwqa_anonymous_name"><?php _e('Your Name', 'dwqa'); ?></label>
                <?php $name = isset($_POST['_dwqa_anonymous_name']) ? sanitize_text_field($_POST['_dwqa_anonymous_name']) : ''; ?>
                <input type="text" class="" name="_dwqa_anonymous_name" value="<?php echo $name ?>"/>
            </p>
        <?php endif; ?>
        <?php wp_nonce_field('_dwqa_submit_question'); ?>
        <?php dwqa_load_template('captcha', 'form'); ?>
        <?php do_action('dwqa_before_question_submit_button'); ?>

        <input type="submit" name="dwqa-question-submit" onclick="jilu()" value="<?php _e('提交问题', 'dwqa') ?>" class="btn-green"/>
        <input type="button" id="cancel" onclick="Cancel()" name="dwqa-question-submit"
               value="<?php _e('取消', 'dwqa') ?>" class="btn-grey" style="float: right;"/>
    </form>


</div>

<script language="javascript">
    function Cancel() {
        var url = '<?=site_url() . get_page_address('qa')?>';
        location.href = url;
    }
    function jilu() {

        var json = [];
        var row1 = {};
        var row2 = {};
        var row3 = {};
        var row4 = {};
        row1.userid=  <?php echo $current_user->ID;?>;
        row1.username="<?php echo $current_user->data->user_login;?>";
        row1.usersno="<?php echo get_user_meta( $current_user->ID, 'Sno');?>";
        row1.university="<?php echo get_user_meta( $current_user->ID, 'University');?>";
        row2.content = document.getElementById("search-content").value;;
        row2.activity="qa";
        row2.time=getNowFormatDate();
        row2.url=null;
        row3.otherid=null;
        row3.othercontent=null;
        row4.source="sparkspace";
        row4.userinfo=row1;
        row4.scene=row2;
        row4.otheruserinfo=row3

        // row1.likenum="";//被点赞数
        // row1.likename="";  //点赞项目名称

        json.push(row4);


        alert(JSON.stringify(json));

    }
    function getNowFormatDate() {//获取当前时间

        var date = new Date();

        var seperator1 = "-";

        var seperator2 = ":";

        var month = date.getMonth() + 1<10? "0"+(date.getMonth() + 1):date.getMonth() + 1;

        var strDate = date.getDate()<10? "0" + date.getDate():date.getDate();

        var currentdate = date.getFullYear() + seperator1  + month  + seperator1  + strDate

            + " "  + date.getHours()  + seperator2  + date.getMinutes()

            + seperator2 + date.getSeconds();

        return currentdate;

    }
    function submitCheckQA(){

        var flag = false;
        var qt = document.getElementById('question-title');
        var offer = document.getElementById('offer');
        if (qt.value.length == 0) {
            $('#title_none').html("<p style='color:red;margin-top:20px;margin-left: 20px'>问题标题不能为空</p>");
        } else if(!checkScore(offer.value)) {
            alert('请修正错误');
        }else{
            actionAsk();
            flag = true
        }

        return flag
    }
    function actionAsk() {
        document.cookie = "action=ask";
    }
    function checkTagNum(value) {
        var tag = document.getElementById('Spark_question-tag');
        var alertTag = document.getElementById("alertTag");
        var deleteTag = document.getElementById("deleteTag");

        if (value.split(",").length > 3) {
            tag.readOnly = true;
            alertTag.innerHTML = "<p style='color:red;margin:20px 20px'>最多添加3个标签</p>";
            deleteTag.style.display = "block";
        } else {
            tag.readOnly = false;
            alertTag.innerHTML = "";
            deleteTag.style.display = "none";
        }
    }
    function deleteTags() {
        for (var i = 0; i < 10; i++) {
            var addTag = document.getElementById('addTag_' + i);
            addTag.style.border = "1px solid"; //若取消选择,style。恢复未选择状态
            addTag.style.borderColor = "transparent";
            addTag.style.background = "";
            addTag.style.backgroundColor = "#ffe9e1";
            addTag.style.color = "#fe642d";
        }
        var tag = document.getElementById('Spark_question-tag');
        tag.value = "";
        tag.readOnly = false;
    }
    function checkScore(value) {
        var flag = false;
        //检查value是否是合理值
        var ex = /^\d+$/;
        if ((ex.test(value) && value!= 0) || value=='') {
            //分值够不够
            var data = {
                action: "check_score",
                offer: value,
                user_id: '<?=get_current_user_id()?>'
            };
            $.ajax({
                async:false,
                type: 'POST',
                url: '<?=$admin_url?>',
                data: data,
                success: function (response) {
                    if (response.trim() == 0) {
                        <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
                        $('#score-flag').html("<img src='<?=$url?>'><span>您没有足够的积分</span>");
                    } else {
                        <?php $url = get_template_directory_uri() . "/img/OK.png";?>
                        $('#score-flag').html("<img src='<?=$url?>'>");
                        flag = true
                    }
                }
            })
        } else {
            <?php $url = get_template_directory_uri() . "/img/ERROR.png";?>
            $('#score-flag').html("<img src='<?=$url?>'><span>请输入合理悬赏值</span>")
        }
        return flag;
    }
</script>