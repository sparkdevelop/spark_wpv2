<?php

add_action( 'dwqa_after_answers_list', 'dwqa_answer_paginate_link' );
function dwqa_answer_paginate_link() {
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
        echo '<div class="dwqa-pagination">';
        echo $paginate;
        echo '</div>';
    }
}

function dwqa_question_paginate_link() {
    global $wp_query, $dwqa_general_settings;

    $archive_question_url = get_permalink( $dwqa_general_settings['pages']['archive-question'] );
    $page_text = dwqa_is_front_page() ? 'page' : 'paged';
    $page = get_query_var( $page_text ) ? get_query_var( $page_text ) : 1;

    $tag = get_query_var( 'dwqa-question_tag' ) ? get_query_var( 'dwqa-question_tag' ) : false;
    $cat = get_query_var( 'dwqa-question_category' ) ? get_query_var( 'dwqa-question_category' ) : false;

    $url = $cat
        ? get_term_link( $cat, get_query_var( 'taxonomy' ) )
        : ( $tag ? get_term_link( $tag, get_query_var( 'taxonomy' ) ) : $archive_question_url );

    $args = array(
        'base' => add_query_arg( $page_text, '%#%', $url ),
        'format' => '',
        'current' => $page,
        'total' => $wp_query->dwqa_questions->max_num_pages
    );

    $paginate = paginate_links( $args );
    $paginate = str_replace( 'page-number', 'dwqa-page-number', $paginate );
    $paginate = str_replace( 'current', 'dwqa-current', $paginate );
    $paginate = str_replace( 'next', 'dwqa-next', $paginate );
    $paginate = str_replace( 'prev ', 'dwqa-prev ', $paginate );
    $paginate = str_replace( 'dots', 'dwqa-dots', $paginate );

    if ( $wp_query->dwqa_questions->max_num_pages > 1 ) {
        echo '<div class="dwqa-pagination">';
        echo $paginate;
        echo '</div>';
    }
}
