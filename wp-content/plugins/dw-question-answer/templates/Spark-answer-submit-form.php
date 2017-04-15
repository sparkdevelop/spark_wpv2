<?php
/**
 * The template for displaying answer submit form
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */
?>

<div class="dwqa-answer-form">
    <?php do_action( 'dwqa_before_answer_submit_form' ); ?>
    <div class="dwqa-answer-form-title"><?php _e( 'Your Answer', 'dwqa' ) ?></div>
    <form name="dwqa-answer-form" id="dwqa-answer-form" method="post">
        <?php dwqa_print_notices(); ?>
        <?php $content = isset( $_POST['answer-content'] ) ? sanitize_text_field( $_POST['answer-content'] ) : ''; ?>
        <?php dwqa_init_tinymce_editor( array( 'content' => $content, 'textarea_name' => 'answer-content', 'id' => 'dwqa-answer-content' ) ) ?>
        <?php dwqa_load_template( 'captcha', 'form' ); ?>

<!--        <select class="dwqa-select" name="dwqa-status">-->
<!--            <optgroup label="--><?php //_e( 'Who can see this?', 'dwqa' ) ?><!--">-->
<!--                <option value="publish">--><?php //_e( 'Public', 'dwqa' ) ?><!--</option>-->
<!--                <option value="private">--><?php //_e( 'Only Me &amp; Admin', 'dwqa' ) ?><!--</option>-->
<!--            </optgroup>-->
<!--        </select>-->
        <input type="hidden" name="dwqa-status" value="='publish">
        <input type="submit" name="submit-answer" class="dwqa-btn dwqa-btn-primary" value="提交回答">
        <input type="hidden" name="question_id" value="<?php the_ID(); ?>">
        <input type="hidden" name="dwqa-action" value="add-answer">
        <?php wp_nonce_field( '_dwqa_add_new_answer' ) ?>
    </form>
    <?php do_action( 'dwqa_after_answer_submit_form' ); ?>
</div>
