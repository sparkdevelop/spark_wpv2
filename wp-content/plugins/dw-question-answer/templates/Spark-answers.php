<?php
/**
 * The template for displaying answers
 *
 * @package DW Question & Answer
 * @since DW Question & Answer 1.4.3
 */


add_action('Spark_after_answers_list', 'Spark_answer_paginate_link');
function Spark_answer_paginate_link(){
    global $wp_query;
    $question_url = get_permalink();
    $page = isset( $_GET['ans-page'] ) ? intval( $_GET['ans-page'] ) : 1;

    $args = array(
        'base' => add_query_arg( 'ans-page', '%#%', $question_url ),
        'format' => '',
        'current' => $page,
        'total' => $wp_query->dwqa_answers->max_num_pages
    );

    $paginate = paginate_links( $args );
    $paginate = str_replace( 'page-number', 'dwqa-page-number', $paginate );
    $paginate = str_replace( 'current', 'dwqa-current', $paginate );
    $paginate = str_replace( 'next', 'dwqa-next', $paginate );
    $paginate = str_replace( 'prev ', 'dwqa-prev ', $paginate );
    $paginate = str_replace( 'dots', 'dwqa-dots', $paginate );

    if ( $wp_query->dwqa_answers->max_num_pages > 1 ) {
        echo '<div class="dwqa-pagination" style="text-align: center">';
        echo $paginate;
        echo '</div>';
    }
}
?>
<div class="dwqa-answers">
    <?php if ( dwqa_current_user_can( 'post_answer' ) && !dwqa_is_closed( get_the_ID() ) ) : ?>
        <?php dwqa_load_template( 'Spark-answer', 'submit-form' ) ?>
    <?php endif; ?>
    <?php do_action( 'dwqa_before_answers');?>
    <div class="divline"></div>
    <?php if ( dwqa_has_answers() ) : ?>
    <div class="dwqa-answers-title">
        <!--						显示几个answer-->
        <?php printf( __( '%s 个答案', 'dwqa' ), dwqa_question_answers_count( get_the_ID() ) ) ;?>
    </div>
        <div class="dwqa-answers-list">
            <?php do_action( 'dwqa_before_answers_list' ) ?>
            <?php while ( dwqa_has_answers() ) : dwqa_the_answers(); ?>
                <?php $question_id = get_post_meta( get_the_ID(), '_question', true ) ?>
                <?php if ( ( 'private' == get_post_status() &&
                        ( dwqa_current_user_can( 'edit_answer', get_the_ID() ) || dwqa_current_user_can( 'edit_question', $question_id ) ) )
                    || 'publish' == get_post_status() ) : ?>
                    <?php dwqa_load_template( 'Spark-content', 'single-answer' ); ?>
                <?php endif; ?>
            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>
            <?php do_action( 'Spark_after_answers_list' ) ?>
        </div>
    <?php endif; ?>
    <?php do_action( 'dwqa_after_answers' ); ?>
</div>
