
<h2><?php _e( 'Name' ); ?></h2>

<table class="form-table">
    <tr class="user-user-login-wrap">
        <th><label for="user_login"><?php _e('Username'); ?></label></th>
        <td><input type="text" name="user_login" id="user_login" value="<?php echo esc_attr($profileuser->user_login); ?>" disabled="disabled" class="regular-text" /> <span class="description"><?php _e('Usernames cannot be changed.'); ?></span></td>
    </tr>

    <?php if ( !IS_PROFILE_PAGE && !is_network_admin() ) : ?>
        <tr class="user-role-wrap"><th><label for="role"><?php _e('Role') ?></label></th>
            <td><select name="role" id="role">
                    <?php
                    // Compare user role against currently editable roles
                    $user_roles = array_intersect( array_values( $profileuser->roles ), array_keys( get_editable_roles() ) );
                    $user_role  = reset( $user_roles );

                    // print the full list of roles with the primary one selected.
                    wp_dropdown_roles($user_role);

                    // print the 'no role' option. Make it selected if the user has no role yet.
                    if ( $user_role )
                        echo '<option value="">' . __('&mdash; No role for this site &mdash;') . '</option>';
                    else
                        echo '<option value="" selected="selected">' . __('&mdash; No role for this site &mdash;') . '</option>';
                    ?>
                </select></td></tr>
    <?php endif; //!IS_PROFILE_PAGE

    if ( is_multisite() && is_network_admin() && ! IS_PROFILE_PAGE && current_user_can( 'manage_network_options' ) && !isset($super_admins) ) { ?>
        <tr class="user-super-admin-wrap"><th><?php _e('Super Admin'); ?></th>
            <td>
                <?php if ( $profileuser->user_email != get_site_option( 'admin_email' ) || ! is_super_admin( $profileuser->ID ) ) : ?>
                    <p><label><input type="checkbox" id="super_admin" name="super_admin"<?php checked( is_super_admin( $profileuser->ID ) ); ?> /> <?php _e( 'Grant this user super admin privileges for the Network.' ); ?></label></p>
                <?php else : ?>
                    <p><?php _e( 'Super admin privileges cannot be removed because this user has the network admin email.' ); ?></p>
                <?php endif; ?>
            </td></tr>
    <?php } ?>

    <tr class="user-first-name-wrap">
        <th><label for="first_name"><?php _e('First Name') ?></label></th>
        <td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($profileuser->first_name) ?>" class="regular-text" /></td>
    </tr>

    <tr class="user-last-name-wrap">
        <th><label for="last_name"><?php _e('Last Name') ?></label></th>
        <td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($profileuser->last_name) ?>" class="regular-text" /></td>
    </tr>

    <tr class="user-nickname-wrap">
        <th><label for="nickname"><?php _e('Nickname'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
        <td><input type="text" name="nickname" id="nickname" value="<?php echo esc_attr($profileuser->nickname) ?>" class="regular-text" /></td>
    </tr>

    <tr class="user-display-name-wrap">
        <th><label for="display_name"><?php _e('Display name publicly as') ?></label></th>
        <td>
            <select name="display_name" id="display_name">
                <?php
                $public_display = array();
                $public_display['display_nickname']  = $profileuser->nickname;
                $public_display['display_username']  = $profileuser->user_login;

                if ( !empty($profileuser->first_name) )
                    $public_display['display_firstname'] = $profileuser->first_name;

                if ( !empty($profileuser->last_name) )
                    $public_display['display_lastname'] = $profileuser->last_name;

                if ( !empty($profileuser->first_name) && !empty($profileuser->last_name) ) {
                    $public_display['display_firstlast'] = $profileuser->first_name . ' ' . $profileuser->last_name;
                    $public_display['display_lastfirst'] = $profileuser->last_name . ' ' . $profileuser->first_name;
                }

                if ( !in_array( $profileuser->display_name, $public_display ) ) // Only add this if it isn't duplicated elsewhere
                    $public_display = array( 'display_displayname' => $profileuser->display_name ) + $public_display;

                $public_display = array_map( 'trim', $public_display );
                $public_display = array_unique( $public_display );

                foreach ( $public_display as $id => $item ) {
                    ?>
                    <option <?php selected( $profileuser->display_name, $item ); ?>><?php echo $item; ?></option>
                    <?php
                }
                ?>
            </select>
        </td>
    </tr>
</table>

<h2><?php _e( 'Contact Info' ); ?></h2>

<table class="form-table">
    <tr class="user-email-wrap">
        <th><label for="email"><?php _e('Email'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
        <td><input type="email" name="email" id="email" value="<?php echo esc_attr( $profileuser->user_email ) ?>" class="regular-text ltr" />
            <?php
            $new_email = get_user_meta( $current_user->ID, '_new_email', true );
            if ( $new_email && $new_email['newemail'] != $current_user->user_email && $profileuser->ID == $current_user->ID ) : ?>
                <div class="updated inline">
                    <p><?php
                        printf(
                        /* translators: %s: new email */
                            __( 'There is a pending change of your email to %s.' ),
                            '<code>' . esc_html( $new_email['newemail'] ) . '</code>'
                        );
                        printf(
                            ' <a href="%1$s">%2$s</a>',
                            esc_url( wp_nonce_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ), 'dismiss-' . $current_user->ID . '_new_email' ) ),
                            __( 'Cancel' )
                        );
                        ?></p>
                </div>
            <?php endif; ?>
        </td>
    </tr>

    <tr class="user-url-wrap">
        <th><label for="url"><?php _e('Website') ?></label></th>
        <td><input type="url" name="url" id="url" value="<?php echo esc_attr( $profileuser->user_url ) ?>" class="regular-text code" /></td>
    </tr>

    <?php
    foreach ( wp_get_user_contact_methods( $profileuser ) as $name => $desc ) {
        ?>
        <tr class="user-<?php echo $name; ?>-wrap">
            <th><label for="<?php echo $name; ?>">
                    <?php
                    /**
                     * Filters a user contactmethod label.
                     *
                     * The dynamic portion of the filter hook, `$name`, refers to
                     * each of the keys in the contactmethods array.
                     *
                     * @since 2.9.0
                     *
                     * @param string $desc The translatable label for the contactmethod.
                     */
                    echo apply_filters( "user_{$name}_label", $desc );
                    ?>
                </label></th>
            <td><input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr($profileuser->$name) ?>" class="regular-text" /></td>
        </tr>
        <?php
    }
    ?>
</table>

<h2><?php IS_PROFILE_PAGE ? _e( 'About Yourself' ) : _e( 'About the user' ); ?></h2>

<table class="form-table">
    <tr class="user-description-wrap">
        <th><label for="description"><?php _e('Biographical Info'); ?></label></th>
        <td><textarea name="description" id="description" rows="5" cols="30"><?php echo $profileuser->description; // textarea_escaped ?></textarea>
            <p class="description"><?php _e('Share a little biographical information to fill out your profile. This may be shown publicly.'); ?></p></td>
    </tr>

    <?php if ( get_option( 'show_avatars' ) ) : ?>
        <tr class="user-profile-picture">
            <th><?php _e( 'Profile Picture' ); ?></th>
            <td>
                <?php echo get_avatar( $user_id ); ?>
                <p class="description"><?php
                    if ( IS_PROFILE_PAGE ) {
                        /* translators: %s: Gravatar URL */
                        $description = sprintf( __( 'You can change your profile picture on <a href="%s">Gravatar</a>.' ),
                            __( 'https://en.gravatar.com/' )
                        );
                    } else {
                        $description = '';
                    }

                    /**
                     * Filters the user profile picture description displayed under the Gravatar.
                     *
                     * @since 4.4.0
                     * @since 4.7.0 Added the `$profileuser` parameter.
                     *
                     * @param string  $description The description that will be printed.
                     * @param WP_User $profileuser The current WP_User object.
                     */
                    echo apply_filters( 'user_profile_picture_description', $description, $profileuser );
                    ?></p>
            </td>
        </tr>
    <?php endif; ?>

    <?php
    /**
     * Filters the display of the password fields.
     *
     * @since 1.5.1
     * @since 2.8.0 Added the `$profileuser` parameter.
     * @since 4.4.0 Now evaluated only in user-edit.php.
     *
     * @param bool    $show        Whether to show the password fields. Default true.
     * @param WP_User $profileuser User object for the current user to edit.
     */
    if ( $show_password_fields = apply_filters( 'show_password_fields', true, $profileuser ) ) :
    ?>
</table>

<h2><?php _e( 'Account Management' ); ?></h2>

<table class="form-table">
    <tr id="password" class="user-pass1-wrap">
        <th><label for="pass1"><?php _e( 'New Password' ); ?></label></th>
        <td>
            <input class="hidden" value=" " /><!-- #24364 workaround -->
            <button type="button" class="button wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password' ); ?></button>
            <div class="wp-pwd hide-if-js">
			<span class="password-input-wrapper">
				<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
			</span>
                <button type="button" class="button wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password' ); ?>">
                    <span class="dashicons dashicons-hidden"></span>
                    <span class="text"><?php _e( 'Hide' ); ?></span>
                </button>
                <button type="button" class="button wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Cancel password change' ); ?>">
                    <span class="text"><?php _e( 'Cancel' ); ?></span>
                </button>
                <div style="display:none" id="pass-strength-result" aria-live="polite"></div>
            </div>
        </td>
    </tr>
    <tr class="user-pass2-wrap hide-if-js">
        <th scope="row"><label for="pass2"><?php _e( 'Repeat New Password' ); ?></label></th>
        <td>
            <input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
            <p class="description"><?php _e( 'Type your new password again.' ); ?></p>
        </td>
    </tr>
    <tr class="pw-weak">
        <th><?php _e( 'Confirm Password' ); ?></th>
        <td>
            <label>
                <input type="checkbox" name="pw_weak" class="pw-checkbox" />
                <span id="pw-weak-text-label"><?php _e( 'Confirm use of potentially weak password' ); ?></span>
            </label>
        </td>
    </tr>
    <?php endif; ?>


</table>


                <?php
                if ( IS_PROFILE_PAGE ) {
                    /**
                     * Fires after the 'About Yourself' settings table on the 'Your Profile' editing screen.
                     *
                     * The action only fires if the current user is editing their own profile.
                     *
                     * @since 2.0.0
                     *
                     * @param WP_User $profileuser The current WP_User object.
                     */
                    do_action( 'show_user_profile', $profileuser );
                } else {
                    /**
                     * Fires after the 'About the User' settings table on the 'Edit User' screen.
                     *
                     * @since 2.0.0
                     *
                     * @param WP_User $profileuser The current WP_User object.
                     */
                    do_action( 'edit_user_profile', $profileuser );
                }
                ?>

                <?php
                /**
                 * Filters whether to display additional capabilities for the user.
                 *
                 * The 'Additional Capabilities' section will only be enabled if
                 * the number of the user's capabilities exceeds their number of
                 * roles.
                 *
                 * @since 2.8.0
                 *
                 * @param bool    $enable      Whether to display the capabilities. Default true.
                 * @param WP_User $profileuser The current WP_User object.
                 */
                if ( count( $profileuser->caps ) > count( $profileuser->roles )
                    && apply_filters( 'additional_capabilities_display', true, $profileuser )
                ) : ?>
                    <h2><?php _e( 'Additional Capabilities' ); ?></h2>
                    <table class="form-table">
                        <tr class="user-capabilities-wrap">
                            <th scope="row"><?php _e( 'Capabilities' ); ?></th>
                            <td>
                                <?php
                                $output = '';
                                foreach ( $profileuser->caps as $cap => $value ) {
                                    if ( ! $wp_roles->is_role( $cap ) ) {
                                        if ( '' != $output )
                                            $output .= ', ';
                                        $output .= $value ? $cap : sprintf( __( 'Denied: %s' ), $cap );
                                    }
                                }
                                echo $output;
                                ?>
                            </td>
                        </tr>
                    </table>
                <?php endif; ?>

                <input type="hidden" name="action" value="update" />
                <input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr($user_id); ?>" />

                <?php //submit_button( IS_PROFILE_PAGE ? __('Update Profile') : __('Update User') ); ?>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" name="Submit" id="form_profile" class="btn btn-default" value="保存修改"/>
                    </div>
                </div>

</form>


    <script type="text/javascript">
        if (window.location.hash == '#password') {
            document.getElementById('pass1').focus();
        }
    </script>




<?php echo esc_attr( wp_generate_password( 24 ) );// 生成24位密码?>
<script>
if(response){
                            <?php //$url=get_template_directory_uri()."/img/ERROR.png";?>
                            document.getElementById("checkpassword").innerHTML= "error";
////                            //'<img src=<?php //////$url?>////';
//                            $('#newPassword').attr("disabled",true);
////                            //var newpass = document.getElementById('newPassword');
////                            //newpass.disabled ="disabled";
//                        }else{
////                            <?php ////$url=get_template_directory_uri()."/img/OK.png";?>
//                            document.getElementById("checkpassword").innerHTML="ok";
//                            $('#newPassword').attr("disabled",false);
//                        }



    function checkPassword(password) {
//            var xmlhttp;
//            if(password.length==0){
//                document.getElementById("checkpassword").innerHTML="";
//                return;
//            }
//            if(window.XMLHttpRequest){
//                xmlhttp=new XMLHttpRequest();
//            }else{
//                xmlhttp=new ActiveXObject(Microsoft.XMLHTTP);
//            }
//            xmlhttp.onreadystatechange=function(){
//                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
//                    document.getElementById("checkpassword").innerHTML= xmlhttp.responseText;
//                }
//            };
//        xmlhttp.open("get","<?php //echo esc_url( get_template_directory_uri())?>///template/profile-process-password.php?password="+password,true);
//
//        //xmlhttp.open("get","<?php//// echo esc_url( self_admin_url('profile-process-password.php') )?>//?password="+password,true);
////        xmlhttp.open("POST","<?php ////echo esc_url( self_admin_url('profile-process-password.php') )?>////",true);
////        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
////        xmlhttp.send("password="+password);
//        xmlhttp.send();
//        }

</script>


<!--        <script>-->
<!--            var newpass = document.getElementById('newPassword');-->
<!--            newpass.disabled ="disabled";-->
<!--
   </script>-->








































<script>

function addTag_<?=$tag[$i]->name?>(value) {
var tag = document.getElementById('Spark_question-tag');
var alertTag = document.getElementById("alertTag");
var addTag = document.getElementById("addTag_<?=$i?>");
    if(tag.value.length==0||tag.value.split(",").length<=3){
        var split_value = tag.value.split(",");
        for(i=1;i<split_value.length;i++){
            if(split_value[i-1]==value){
                alertTag.innerHTML="<p style='color:red;margin-top:20px;margin-left: 20px'>不能输入相同的标签</p>";
                var flag = false;
            }
        }
if(flag!=false){
tag.value = tag.value+value+",";
addTag.style.backgroundColor="transparent";
addTag.style.background = "url('<?php bloginfo("template_url")?>/img/OK.png') no-repeat scroll right center transparent";
}
}
    else{
        checkTagNum(tag.value);
    }
}
}
</script>





function addTag_<?//=$tag[$i]->name?>//(value) {
//                        var tag = document.getElementById('Spark_question-tag');
//                        var alertTag = document.getElementById("alertTag");
//                        var addTag = document.getElementById("addTag_<?//=$i?>//");
//                        if(tag.value.length==0||tag.value.split(",").length<=3){
//                            var split_value = tag.value.split(",");
//                            for(i=1;i<split_value.length;i++){
//                                if(split_value[i-1]==value){
//                                    alertTag.innerHTML="<p style='color:red;margin-top:20px;margin-left: 20px'>不能输入相同的标签</p>";
//                                    var flag = false;
//                                }
//                            }
//                            if(flag!=false){
//                                tag.value = tag.value+value+",";
//                                addTag.style.backgroundColor="transparent";
//                                addTag.style.background = "url('<?php //bloginfo("template_url")?>///img/OK.png') no-repeat scroll right center transparent";
//                            }
//                        }
//                        else{
//                            checkTagNum(tag.value);
//                        }
//                    }
//                    }
//                    function addTag_<?//=$tag[$i]->name?>//(value) {
//                        var tag = document.getElementById('Spark_question-tag');
//                        var alertTag = document.getElementById("alertTag");
//                        var addTag = document.getElementById("addTag_<?//=$i?>//");
//                        if(tag.value.length==0||tag.value.split(",").length<=3){
//                            var split_value = tag.value.split(",");
//                            for(i=1;i<split_value.length;i++){
//                                if(split_value[i-1]==value){
//                                    alertTag.innerHTML="<p style='color:red;margin-top:20px;margin-left: 20px'>不能输入相同的标签</p>";
//                                    var flag = false;
//                                }
//                            }
//                            if(flag!=false){
//                                tag.value = tag.value+value+",";
//                                addTag.style.backgroundColor="transparent";
//                                addTag.style.background = "url('<?php //bloginfo("template_url")?>///img/OK.png') no-repeat scroll right center transparent";
//                            }
//                        }else{
//                            checkTagNum(tag.value);
//                        }
//                    }



<!--    <div id="primary" class="content-area">-->
<!--        <main id="main" class="site-main" role="main">-->
<!---->
<!--            <section class="error-404 not-found">-->
<!--                <header class="page-header">-->
<!--                    <h1 class="page-title">--><?php //_e( 'Oops! That page can&rsquo;t be found.', 'QA' ); ?><!--</h1>-->
<!--                </header><!-- .page-header -->
<!---->
<!--                <div class="page-content">-->
<!--                    <p>--><?php //_e( 'It looks like nothing was found at this location. Maybe try a search?', 'QA' ); ?><!--</p>-->
<!---->
<!--                    --><?php //get_search_form(); ?>
<!--                </div><!-- .page-content -->
<!--            </section><!-- .error-404 -->
<!---->
<!--        </main><!-- .site-main -->
<!---->
<!--        --><?php //get_sidebar( 'content-bottom' ); ?>
<!---->
<!--    </div><!-- .content-area -->