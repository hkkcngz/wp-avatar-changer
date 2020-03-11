<?php 
/** 
 * WP Custom Avatar
 * by HC
 */
global
  $current_user;
  $wp_roles;
  $user = wp_get_current_user();
  $user_id = $current_user->ID; 
// Apply filter
add_filter( 'get_avatar' , 'my_custom_avatar' , 2 , 5 );

function my_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {

  if (( isset( $_GET['upload'] ) && $_GET['upload'] == 'user-avatar' )) {

    $user_avatar = esc_attr( $_POST['avatar_url'] );
    $user = true;

    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        $user = get_user_by( 'email', $id_or_email );	
    }

    if ( $user && is_object( $user ) ) {

      if ( $user->data->ID == '2' ) {
          $avatar = $user_avatar;
          $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
      }

    }

    return $avatar;

  }

}