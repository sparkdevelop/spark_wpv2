<?php
require_once( dirname( __FILE__ ) . '/admin.php' );
$user_id=wp_get_current_user()->ID;
$page_address = get_page_address('personal');

if ( ! empty( $_FILES['simple-local-avatar']['name'] ) ) {
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif' => 'image/gif',
        'png' => 'image/png',
        'bmp' => 'image/bmp',
        'tif|tiff' => 'image/tiff'
    );

    // front end (theme my profile etc) support
    if ( ! function_exists( 'wp_handle_upload' ) )
        require_once( ABSPATH . 'wp-admin/includes/file.php' );

        avatar_delete( $user_id );	// delete old images if successful

        // need to be more secure since low privelege users can upload
        if ( strstr( $_FILES['simple-local-avatar']['name'], '.php' ) )
            wp_die('For security reasons, the extension ".php" cannot be in your file name.');

        $avatar = wp_handle_upload( $_FILES['simple-local-avatar'], array( 'mimes' => $mimes, 'test_form' => false, 'unique_filename_callback' => array( $this, 'unique_filename_callback' ) ) );

        if ( empty($avatar['file']) ) {		// handle failures
            switch ( $avatar['error'] ) {
                case 'File type does not meet security guidelines. Try another.' :
                    add_action( 'user_profile_update_errors', create_function('$a','$a->add("avatar_error",__("Please upload a valid image file for the avatar.","simple-local-avatars"));') );
                    break;
                default :
                    add_action( 'user_profile_update_errors', create_function('$a','$a->add("avatar_error","<strong>".__("There was an error uploading the avatar:","simple-local-avatars")."</strong> ' . esc_attr( $avatar['error'] ) . '");') );
            }
            exit;
        }
        update_user_meta( $user_id, 'simple_local_avatar', array( 'full' => $avatar['url'] ) );		// save user information (overwriting old)
    } elseif ( ! empty( $_POST['simple-local-avatar-erase'] ) ) {
        $this->avatar_delete( $user_id );
    }


$url= site_url().$page_address;
?>
<script language="javascript">
    location.replace("<?=$url?>");
</script>

<?php
function avatar_delete( $user_id ) {
    $old_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );
    $upload_path = wp_upload_dir();

    if ( is_array($old_avatars) ) {
        foreach ($old_avatars as $old_avatar ) {
            $old_avatar_path = str_replace( $upload_path['baseurl'], $upload_path['basedir'], $old_avatar );
            @unlink( $old_avatar_path );
        }
    }

    delete_user_meta( $user_id, 'simple_local_avatar' );
}

function unique_filename_callback( $dir, $name, $ext ) {
    $user = get_user_by( 'id', (int) $this->user_id_being_edited );
    $name = $base_name = sanitize_file_name( $user->display_name . '_avatar' );
    $number = 1;

    while ( file_exists( $dir . "/$name$ext" ) ) {
        $name = $base_name . '_' . $number;
        $number++;
    }

    return $name . $ext;
}