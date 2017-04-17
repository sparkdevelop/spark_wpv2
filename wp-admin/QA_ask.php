<?php
/*
本页面是我要提问页面的content
 */
?>
<div class="col-md-9 col-sm-9 col-xs-9"  id="col9">
    <h4 class="ask_topic">提 问</h4>
    <?php
    //    echo do_shortcode("[dwqa-submit-question-form]");
    //?>
    <style>
        #Spark_question_submit_form{margin-bottom: 30px}
    </style>

    <form method="post" class="dwqa-content-edit-form" id="Spark_question_submit_form" onsubmit="return SubmitCheck();">
        <!--    标题栏-->
        <p class="dwqa-search">
            <?php
            $title = isset($_POST['question-title'] ) ? sanitize_title( $_POST['question-title'] ) : ''; ?>
            <input type="text" style="margin-top: 20px;" data-nonce="<?php echo wp_create_nonce( '_dwqa_filter_nonce' ) ?>"
                   id="question-title" name="question-title" value="<?php echo $title ?>" tabindex="1" _moz_abspos=""  onkeydown="if(event.keyCode==13) return false;"/>
        </p>

        <?php $content = isset( $_POST['question-content'] ) ? sanitize_text_field( $_POST['question-content'] ) : ''; //如果没有内容应该跳出警告?>
        <p><?php //dwqa_init_tinymce_editor( array( 'content' => $content, 'textarea_name' => 'question-content', 'id' => 'question-content' ) ) ?></p>
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
            <!--            <select></select>-->

            <?php
            $Question_cat_ID = get_dwqa_cat_ID('Questions');
            echo "tags";
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
        <!--    tag部分-->
            <?php
            global $wpdb;
            $tag_id = array();
            $tag_name = array();//存储每个标签的名字;

            //==============获取所有tag信息===============
            $tag = get_terms( 'dwqa-question_tag', array_merge( array( 'orderby' => 'count', 'order' => 'DESC' )));
            ?>
        <p>
            <label for="question-tag"><?php _e( 'Tag', 'dwqa' ) ?></label>
            <input type="text" class="" name="question-tag" value="<?php echo $tags ?>" >
            <?php $tags = isset( $_POST['question_tag'] ) ? sanitize_text_field( $_POST['question_tag'] ) : ''; ?>

            <?php
            echo '<div>';
            foreach($tag as $key => $temp){
                $tag_id[]=$temp->term_id;
                $tag_name[]=$temp->name;?>
                <input type="checkbox" name="question-tag" value="<?=$tag_name[$key]?>"/>
                <span class="label label-default"><?=$tag_name[$key]?></span>
            <?php }
            echo '</div>';
            ?>
            <!--        修改value-->

        </p>
        <?php if ( dwqa_current_user_can( 'post_question' ) && !is_user_logged_in() ) : ?>
            <p>
                <label for="_dwqa_anonymous_email"><?php _e( 'Your Email', 'dwqa' ) ?></label>
                <?php $email = isset( $_POST['_dwqa_anonymous_email'] ) ? sanitize_email( $_POST['_dwqa_anonymous_email'] ) : ''; ?>
                <input type="email" class="" name="_dwqa_anonymous_email" value="<?php echo $email ?>" >
            </p>
            <p>
                <label for="_dwqa_anonymous_name"><?php _e( 'Your Name', 'dwqa' ) ?></label>
                <?php $name = isset( $_POST['_dwqa_anonymous_name'] ) ? sanitize_text_field( $_POST['_dwqa_anonymous_name'] ) : ''; ?>
                <input type="text" class="" name="_dwqa_anonymous_name" value="<?php echo $name ?>" >
            </p>
        <?php endif; ?>
        <?php wp_nonce_field( '_dwqa_submit_question' ) ?>
        <?php dwqa_load_template( 'captcha', 'form' ); ?>
        <?php do_action('dwqa_before_question_submit_button'); ?>

        <input type="submit" name="dwqa-question-submit" value="<?php _e( '提交问题', 'dwqa' ) ?>" class="btn-green">
        <input type="button" id="cancel" onclick="Cancel()" name="dwqa-question-submit" value="<?php _e( '取消', 'dwqa' ) ?>" class="btn-grey" style="float: right;" />
    </form>
</div>
<!--<script charset="utf-8" src="--><?php //bloginfo('url');?><!--/ueditor/editor_config.js"></script>-->
<!--<script charset="utf-8" src="--><?php //bloginfo('url');?><!--/ueditor/editor_all.js"></script>-->
<!--<link rel="stylesheet" type="text/css" href="--><?php //bloginfo('url');?><!--/ueditor/themes/default/ueditor.css"/>-->
<!--<!--style给定宽度可以影响编辑器的最终宽度-->-->
<!--<textarea name="info_content" id="info_content" style="width:520px;float:left;font-size:12px;"></textarea>-->
<!--<script type="text/javascript">-->
<!--    var editor_a = new baidu.editor.ui.Editor();-->
<!--    editor_a.render('info_content');-->
<!--</script>-->
<script language="javascript">
    function Cancel(){
        var url = '<?=site_url().get_page_address('qa')?>';
        location.href= url ;
    }

    function SubmitCheck() {
        var question_title = document.getElementById('question-title');
        var question_content = document.getElementById('question-content');
        var question_category = document.getElementById('question-category');
        var question_tags = document.getElementsByName('question-tag');

        if(question_title.length==0){
            alert("问题标题不能为空");
            return false;}
        if(question_content.length==0){
            alert("问题内容不能为空");
            return false;}
        if(question_category.length==0){
            alert("分类不能为空");
            return false;}
        if(question_tags.length==0||question_tags==false){
            alert("tag不能为空");
            return false;}
    }

    //    function tags() {
    //        obj = document.getElementsByName("question-tag");
    //        check_val = [];
    //        for(k in obj){
    //            if(obj[k].checked)
    //                check_val.push(obj[k].value);
    //        }
    //        var str = JSON.stringify(check_val);
    //        //alert(str);
    //        return str;
    //    }
    //    var question_tag;
    //    $.ajax({
    //        type:"post",
    //        data:{
    //            question_tag=tags();
    //        },
    //        success:function(data){
    //        }})
</script>