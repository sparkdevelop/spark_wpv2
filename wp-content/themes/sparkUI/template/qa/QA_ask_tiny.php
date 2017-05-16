<?php //在项目或者wiki提问?>
<?php
    session_start();
    $_SESSION["post_id"] = $_GET["post_id"];
    $_SESSION["post_type"] = isset($_GET["type"]) ? $_GET["type"] : "post";
?>
<div id="col9">
    <h4 class="ask_topic">提 问</h4>

    <style>
        #Spark_question_submit_form{margin-bottom: 30px;}
    </style>


    <form method="post" class="dwqa-content-edit-form" id="Spark_question_submit_form" onsubmit="return SubmitCheck();">
        <!--    标题栏-->
        <p class="dwqa-search">
            <?php
            $title = isset($_POST['question-title'] ) ? sanitize_title( $_POST['question-title'] ) : ''; ?>
            <input type="text" style="margin-top: 20px;" data-nonce="<?php echo wp_create_nonce( '_dwqa_filter_nonce' ) ?>"
                   id="question-title" name="question-title" value="<?php echo $title ?>" tabindex="1" _moz_abspos=""  onkeydown="if(event.keyCode==13) return false;"/>
            <span id="title_none"></span>
        </p>

        <?php $content = isset( $_POST['question-content'] ) ? sanitize_text_field( $_POST['question-content'] ) : ''; //如果没有内容应该跳出警告?>
        <p>
            <?php dwqa_init_tinymce_editor( array( 'content' => $content, 'textarea_name' => 'question-content', 'id' => 'question-content' ) ) ?>
        </p>

        <?php global $dwqa_general_settings; ?>
        <?php if ( isset( $dwqa_general_settings['enable-private-question'] ) && $dwqa_general_settings['enable-private-question'] ) : ?>
            <p>
                <label for="question-status"><?php _e( 'Status', 'dwqa' ) ?></label>
                <select class="dwqa-select" id="question-status" name="question-status">
                    <optgroup label="<?php _e( 'Who can see this?', 'dwqa' ) ?>">
                        <option value="publish"><?php _e( 'Public', 'dwqa' ) ?></option>
                        <option value="private"><?php _e( 'Only Me &amp; Admin', 'dwqa' ) ?></option>
                    </optgroup>
                </select>
            </p>
        <?php endif; ?>
        <!--    分类部分-->
        <p>
            <label for="question-category">选择问题分类</label>

            <?php
            $Question_cat_ID = get_dwqa_cat_ID('Questions');
            wp_dropdown_categories( array(
                //'show_option_all'=>__( 'Select question category', 'dwqa' ),
                'name'          => 'question-category',
                'id'            => 'question-category',
                'taxonomy'      => 'dwqa-question_category',
                //'show_option_none' => __( 'Select question category', 'dwqa' ),
                'show_option_none' => '',
                'hide_empty'    => 0,
                'show_count'    =>true,
                'child of'      => 2,
                'exclude'       =>$Question_cat_ID,
                // 'quicktags'     => array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,spell,close' ),
                'selected'      => isset( $_POST['question-category'] ) ? sanitize_text_field( $_POST['question-category'] ) : false,
            ) );
            ?>
        </p>
        <span id="category_none"></span>
        <!--    tag部分-->

        <?php
        global $wpdb;
        $tag_id = array();
        $tag_name = array();//存储每个链接的名字;
        //==============获取所有tag信息===============
        $tag = get_terms( 'dwqa-question_tag', array_merge( array( 'orderby' => 'count', 'order' => 'DESC' )));
        ?>
        <p>
            <label for="question-tag"><?php _e( 'Tag', 'dwqa' ) ?></label>
            <input type="text" class="" name="question-tag"
                   id="Spark_question-tag" value=""
                   onkeyup="checkTagNum(this.value)" placeholder="标签之间用逗号隔开">
        <h5>常用标签:</h5>
        <?php $tags = isset( $_POST['question_tag'] ) ? sanitize_text_field( $_POST['question_tag'] ) : ''; ?>
        <?php
        echo '<div>';
        for($i=0;$i<10;$i++){?>
            <input type="button" name="add-question-tag" class="btn btn-default"
                   style="background-color:#ffe9e1;border-color:transparent;color:#fe642d;outline: none"
                   id="addTag_<?=$i?>" value="<?=$tag[$i]->name?>"
                   onclick="addTag_<?=$tag[$i]->name?>(this.value)"/>
            <script>
                function addTag_<?=$tag[$i]->name?>(value) {
                    var tag = document.getElementById('Spark_question-tag');
                    var alertTag = document.getElementById("alertTag");
                    var addTag = document.getElementById("addTag_<?=$i?>");

                    if(judgeRepeatTag(value)==false){ //如果是相同的点击,不在计数里判断
                        tag.value=tag.value.replace(value+',',''); //去掉当前的重复值
                        addTag.style.border="1px solid"; //若取消选择,style。恢复未选择状态
                        addTag.style.borderColor="transparent";
                        addTag.style.background="";
                        addTag.style.backgroundColor="#ffe9e1";
                        addTag.style.color="#fe642d";
                        tag.readOnly = false; //可以继续输入。
                    }
                    else{ //若是添加新标签
                        if(tag.value.length==0||tag.value.split(",").length<=3){
                            tag.readOnly = false; //可以继续输入
                            tag.value = tag.value+value+","; //添加标签
                            addTag.style.border="1px solid";
                            addTag.style.borderColor="#fe642d";
                            addTag.style.color="white";
                            addTag.style.background = "url('<?php bloginfo("template_url")?>/img/check.png') no-repeat scroll top right #fe642d";
                            checkTagNum(tag.value);
                        }
                        else{
                            checkTagNum(tag.value);
                        }
                    }
                }
                function judgeRepeatTag(value) {
                    var tag = document.getElementById('Spark_question-tag');
                    var split_value = tag.value.split(",");
                    var flag = true;
                    for(i=1;i<=split_value.length;i++){
                        if(split_value[i-1]==value){
                            flag = false;
                        }
                    }
                    return flag;
                }
            </script>
        <?php }
        echo '</div>';
        ?>
        <span id="alertTag"></span>
        <span><input type="button" class="btn btn-default" id="deleteTag" onclick="deleteTags()" style="display: none" value="删除标签"/></span>
        </p>
        <?php if ( dwqa_current_user_can( 'post_question' ) && !is_user_logged_in() ) : ?>
            <p>
                <label for="_dwqa_anonymous_email"><?php _e( 'Your Email', 'dwqa' ) ?></label>
                <?php $email = isset( $_POST['_dwqa_anonymous_email'] ) ? sanitize_email( $_POST['_dwqa_anonymous_email'] ) : ''; ?>
                <input type="email" class="" name="_dwqa_anonymous_email" value="<?php echo $email ?>" />
            </p>
            <p>
                <label for="_dwqa_anonymous_name"><?php _e( 'Your Name', 'dwqa' );?></label>
                <?php $name = isset( $_POST['_dwqa_anonymous_name'] ) ? sanitize_text_field( $_POST['_dwqa_anonymous_name'] ) : ''; ?>
                <input type="text" class="" name="_dwqa_anonymous_name" value="<?php echo $name ?>" />
            </p>
        <?php endif; ?>
        <?php wp_nonce_field( '_dwqa_submit_question' ) ;?>
        <?php dwqa_load_template( 'captcha', 'form' ); ?>
        <?php do_action('dwqa_before_question_submit_button'); ?>

        <input type="submit" name="dwqa-question-submit" value="<?php _e( '提交问题', 'dwqa' ) ?>" class="btn-green" style="float: right;"/>
<!--        <input type="button" id="cancel" onclick="Cancel()" name="dwqa-question-submit" value="--><?php //_e( '取消', 'dwqa' ) ?><!--" class="btn-grey"  />-->
    </form>
</div>

<script language="javascript">
    function Cancel(){
        layer.close(layer.index);
//        var url = "<?//=site_url()?>///?p=<?//=$post_id?>//";
//        location.href= url ;
    }

    function SubmitCheck() {
        var question_title = document.getElementById('question-title');
        var title_none = document.getElementById("title_none");

        if(question_title.value.length==0){
            title_none.innerHTML="<p style='color:red;margin-top:20px;margin-left: 20px'>问题标题不能为空</p>";
            return false;
        } else{
            return true;
        }
    }

    function checkTagNum(value) {
        var tag = document.getElementById('Spark_question-tag');
        var alertTag = document.getElementById("alertTag");
        var deleteTag = document.getElementById("deleteTag");

        if(value.split(",").length>3){
            tag.readOnly = true;
            alertTag.innerHTML="<p style='color:red;margin:20px 20px'>最多添加3个标签</p>";
            deleteTag.style.display = "block";
        } else{
            tag.readOnly = false;
            alertTag.innerHTML = "";
            deleteTag.style.display = "none";
        }
    };

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
</script>