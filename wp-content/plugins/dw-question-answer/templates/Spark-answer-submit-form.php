<?php
/**
 * The template for displaying answer submit form
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */
?>
<?php wp_enqueue_media();
$user_id = get_post_field('post_author', get_the_ID()) ? get_post_field('post_author', get_the_ID()) : 0;
?>
<div class="dwqa-answer-form">
    <?php do_action( 'dwqa_before_answer_submit_form' ); ?>
    <div class="dwqa-answer-form-title"><?php _e( 'Your Answer', 'dwqa' ) ?></div>
    <form name="dwqa-answer-form" id="dwqa-answer-form" method="post">
        <?php dwqa_print_notices();
        $current_user = wp_get_current_user();?>
        <?php $content = isset( $_POST['answer-content'] ) ? sanitize_text_field( $_POST['answer-content'] ) : ''; ?>
        <?php dwqa_init_tinymce_editor( array( 'content' => $content, 'textarea_name' => 'answer-content', 'id' => 'dwqa-answer-content' ) ) ?>
        <?php dwqa_load_template( 'captcha', 'form' ); ?>

<!--        <select class="dwqa-select" name="dwqa-status">-->
<!--            <optgroup label="--><?php //_e( 'Who can see this?', 'dwqa' ) ?><!--">-->
<!--                <option value="publish">--><?php //_e( 'Public', 'dwqa' ) ?><!--</option>-->
<!--                <option value="private">--><?php //_e( 'Only Me &amp; Admin', 'dwqa' ) ?><!--</option>-->
<!--            </optgroup>-->
<!--        </select>-->
        <input type="hidden" name="dwqa-status" value="publish">
        <input type="submit" name="submit-answer" class="dwqa-btn dwqa-btn-primary" value="提交回答" onclick="actionAnswer()">
        <input type="hidden" name="question_id" value="<?php the_ID(); ?>">
        <input type="hidden" name="dwqa-action" value="add-answer">
        <?php wp_nonce_field( '_dwqa_add_new_answer' ) ?>
    </form>
    <?php do_action( 'dwqa_after_answer_submit_form' ); ?>
</div>
<script>
    function actionAnswer() {



        var json = [];
        var row1 = {};
        var row2 = {};
        var row3 = {};
        var row4 = {};
        row1.userid=  <?php echo $current_user->ID;?>;
        row1.username="<?php echo $current_user->data->user_login;?>";
        row1.usersno="<?php echo get_user_meta( $current_user->ID, 'Sno');?>";
        row1.university="<?php echo get_user_meta( $current_user->ID, 'University');?>";
        row2.content =tinyMCE.activeEditor.getContent();
        row2.activity="reply";
        row2.time=getNowFormatDate();
        row2.url=null;
        row3.otherid=<?php echo $user_id;?>;
        row3.othercontent="<?php echo get_the_title();?>";
        row4.source="sparkspace";
        row4.userinfo=row1;
        row4.scene=row2;
        row4.otheruserinfo=row3

        // row1.likenum="";//被点赞数
        // row1.likename="";  //点赞项目名称

        json.push(row4);


        alert(JSON.stringify(json));


        document.cookie = "action=answer";
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
</script>