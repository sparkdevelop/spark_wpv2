<?php
/**
 * Handles Comment Post to WordPress and prevents duplicate comment posting.
 *
 * @package WordPress
 */

if ('POST' != $_SERVER['REQUEST_METHOD']) {
    $protocol = $_SERVER['SERVER_PROTOCOL'];
    if (!in_array($protocol, array('HTTP/1.1', 'HTTP/2', 'HTTP/2.0'))) {
        $protocol = 'HTTP/1.0';
    }

    header('Allow: POST');
    header("$protocol 405 Method Not Allowed");
    header('Content-Type: text/plain');
    exit;
}

/** Sets up the WordPress Environment. */
require(dirname(__FILE__) . '/wp-load.php');

nocache_headers();

$comment = wp_handle_comment_submission(wp_unslash($_POST));
if (is_wp_error($comment)) {
    $data = intval($comment->get_error_data());
    if (!empty($data)) {
        wp_die('<p>' . $comment->get_error_message() . '</p>', __('Comment Submission Failure'), array('response' => $data, 'back_link' => true));
    } else {
        exit;
    }
}

$user = wp_get_current_user();

//add notice type1和2
global $wpdb;
$noticeuser_id = get_post($comment->comment_post_ID)->post_author;    //原wiki、项目的作者$comment->comment_post_ID是原词条、项目
$current_time = get_current_date();
if($comment->comment_parent ==0){
    $notice_type = 1;
}else{
    $notice_type = 2;
}
$sql_add_notice = "INSERT INTO wp_notification VALUES ('',$noticeuser_id,$notice_type,'$comment->comment_ID',0,'$current_time')";
$wpdb->get_results($sql_add_notice);


//添加积分
global $integral_system;
add_user_integral($comment->user_id,$integral_system['comment']);


/**
 * Perform other actions when comment cookies are set.
 *
 * @since 3.4.0
 *
 * @param WP_Comment $comment Comment object.
 * @param WP_User $user User object. The user may not exist.
 */
do_action('set_comment_cookies', $comment, $user);

$location = empty($_POST['redirect_to']) ? get_comment_link($comment) : $_POST['redirect_to'] . '#comment-' . $comment->comment_ID;

/**
 * Filters the location URI to send the commenter after posting.
 *
 * @since 2.0.5
 *
 * @param string $location The 'redirect_to' URI sent via $_POST.
 * @param WP_Comment $comment Comment object.
 */
$location = apply_filters('comment_post_redirect', $location, $comment);

wp_safe_redirect($location);
exit;
