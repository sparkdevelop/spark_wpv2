<?php
/*
本页面是我要提问页面的content
 */
?>
<div class="col-md-8 col-sm-8 col-xs-8">
<h4 style="margin-left: 20px">提 问</h4>
<?php
//    echo do_shortcode("[dwqa-submit-question-form]");
//?>
<style>
    #Spark_question_submit_form{margin-left: 20px;margin-bottom: 20px}
</style>
<form method="post" class="dwqa-content-edit-form" id="Spark_question_submit_form">
<!--    标题栏-->
    <p class="dwqa-search">
<!--        改成非search框 input框样式改-->
<!--        <label for="question_title">--><?php //_e( 'Title', 'dwqa' ) ?><!--</label>-->
        <?php $title = isset( $_POST['question-title'] ) ? sanitize_title( $_POST['question-title'] ) : ''; ?>
        <input type="text" style="margin-top: 20px;" data-nonce="<?php echo wp_create_nonce( '_dwqa_filter_nonce' ) ?>" id="question-title" name="question-title" value="<?php echo $title ?>" tabindex="1">
    </p>
    <?php $content = isset( $_POST['question-content'] ) ? sanitize_text_field( $_POST['question-content'] ) : ''; //如果没有内容应该跳出警告?>
    <p><?php dwqa_init_tinymce_editor( array( 'content' => $content, 'textarea_name' => 'question-content', 'id' => 'question-content' ) ) ?></p>
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
<!--        <label for="question-category">--><?php //_e( 'Category', 'dwqa' ) ?><!--</label>-->
        <label for="question-category">选择问题分类</label>
<!--            <select></select>-->

        <?php
        wp_dropdown_categories( array(
            'show_option_all'=>__( 'Select question category', 'dwqa' ),
            'name'          => 'question-category',
            'id'            => 'question-category',
            'taxonomy'      => 'dwqa-question_category',
            //'show_option_none' => __( 'Select question category', 'dwqa' ),
            'show_option_none' => '',
            'hide_empty'    => 0,
            'child of'      => 2,
            'quicktags'     => array( 'buttons' => 'strong,em,link,block,del,ins,img,ul,ol,li,code,spell,close' ),
            'selected'      => isset( $_POST['question-category'] ) ? sanitize_text_field( $_POST['question-category'] ) : false,
        ) );
        ?>
    </p>
<!--    tag部分-->
    <p>
        <label for="question-tag"><?php _e( 'Tag', 'dwqa' ) ?></label>
        <?php $tags = isset( $_POST['question-tag'] ) ? sanitize_text_field( $_POST['question-tag'] ) : ''; ?>
        <input type="text" class="" name="question-tag" value="<?php echo $tags ?>" >
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
    <input type="submit" name="dwqa-question-submit" value="<?php _e( 'Submit', 'dwqa' ) ?>" >
</form>
</div>
