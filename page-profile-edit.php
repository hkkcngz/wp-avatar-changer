<?php 

// Şu anda sayfada bulunan her kimse onun bilgilerini çeker //
global
	 $current_user;
	 $wp_roles;
     wp_get_current_user();
     $user_id = $current_user->ID; // Sayfaya o an giriş yapan üyenin ID numarasıdır.
// Şu anda sayfada bulunan her kimse onun bilgilerini çeker //
  
// My Avatar Changer by HC
if ( 
	isset( $_POST['my_avatar_upload_nonce'] ) 
	&& wp_verify_nonce( $_POST['my_avatar_upload_nonce'], 'my_avatar_upload' )
) {
	// The nonce was valid and the user has the capabilities, it is safe to continue.

	// These files need to be included as dependencies when on the front end.
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );
	
	// Let WordPress handle the upload.
	$attachment_id = media_handle_upload( 'my_avatar_upload', 0 );
	
	//Uploaded Infos
	$image_attributes = wp_get_attachment_image_src( $attachment_id );
	

	if ( is_wp_error( $attachment_id ) ) {
		echo "Resim yüklenirken bir hata oluştu.";
	} else {
		// User Avatar Changer
		update_user_meta( $user_id, 'userAvatar', $image_attributes[0] );

		$successmsg = "Profil Resmi Başarılı Bir Şekilde Değiştirildi!";
	}
} else {
	// The security check failed, maybe show the user an error.
}
$userAvatar = get_user_meta($user_id,'userAvatar',true);

get_header(); ?>

<?php if ( !is_user_logged_in() ) : ?>
    <p class="warning">If you want to change any information, firstly you need to log in.</p><!-- .warning -->
<?php else : ?>
    <h2>Profile Edit Form</h2>
    <!-- Content -->

    <?php $authorFoto = get_the_author_meta('image', $user_id);
        if ( count($error) > 0 ) echo '<p class="error">' . implode("<br />", $error) . '</p>'; ?>
    
    <?php if($userAvatar) { ?>
        <img src="<?php echo esc_url( $userAvatar ); ?>" style="width: 200px; height: 200px; object-fit: cover;" />
    <?php } else { ?>
        <img src="<?php bloginfo('template_directory'); ?>/images/default-user-image.jpg" alt="default avatar" class="img-thumbnail" style="width: 150px;height: 150px;object-fit: cover;" />
        <br>
    <?php } ?>
    <hr />
    <a title="See The Profile" href="<?php bloginfo('url'); echo '/yazar/' . $current_user->user_login . "\n"; ?>" class="button special small">See The Profile</a> <a href="<?php echo wp_logout_url('index.php'); ?>" class="button special small">Quit</a>
    <hr />
    <form id="featured_upload" method="post" action="#" enctype="multipart/form-data" action="<?php bloginfo('url'); ?>/login/?upload=user-avatar">
        
        <fieldset class="border p-4 text-center">
        <legend style="padding: 0 10px;width: auto;">Profile Avatar Changer</legend>

        <?php if ( $image_attributes ) { 
            echo $successmsg;    
        ?>
            <img src="<?php echo $image_attributes[0]; ?>" width="<?php echo $image_attributes[1]; ?>" height="<?php echo $image_attributes[2]; ?>" class="img-thumbnail" style="width: 150px;height: 150px;object-fit: cover;" />
        <?php } ?>

        <?php if($userAvatar) { ?>
            <img src="<?php echo esc_url( $userAvatar ); ?>" style="width: 200px; height: 200px; object-fit: cover;" />
        <?php } else { ?>
            <img src="<?php bloginfo('template_directory'); ?>/images/default-user-image.jpg" alt="varsayılan avatar" class="img-thumbnail" style="width: 150px;height: 150px;object-fit: cover;" />
        <?php } ?>

        <div class="form-group px-4">
            <label for="my_avatar_upload">Select a Profile Photo</label>
            <input type="file" class="form-control-file" name="my_avatar_upload" id="my_avatar_upload" multiple="false">
        </div>

        <input type="hidden" name="avatar_url" id="avatar_url" value="<?php echo $image_attributes[0]; ?>" />
        <?php wp_nonce_field( 'my_avatar_upload', 'my_avatar_upload_nonce' ); ?>
        <button type="submit" id="submit_my_avatar_upload" name="submit_my_avatar_upload">Update Avatar</button>
        </fieldset>
    </form>
<?php endif; ?>