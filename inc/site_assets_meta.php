<?php
function site_assets_meta_box() {
	$post_type = array(get_post_types());
	$post_type = array_shift($post_type);
	unset($post_type['revision']);
	unset($post_type['attachment']);
	unset($post_type['nav_menu_item']);
	unset($post_type['incsub_event']);
	//$posttypes = implode(',',$post_type);
	foreach($post_type AS $post){
		add_meta_box('site_assets', __( 'Site Assets', 'site_assets' ), 'site_assets_box', $post);
	}
}
add_action( 'add_meta_boxes', 'site_assets_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function site_assets_box( $post ) {

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'myplugin_meta_box', 'myplugin_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	$value = get_post_meta( $post->ID, '_site_assets_urls', true );
	if($value!=""){
		$value = json_decode($value);
		$value = implode("\n", $value);
	}
	else{
		$value = "";
	}

	echo '
	<label for="site_assets_url" class="sa_bold">'; echo _e( 'Enter Your Asset URL(s)', 'site_assets_url' ); echo '</label><br />
	<div id="site_assets_note">- One URL per line<br />-Append with a pipe for an alternate title</div>
	<textarea id="site_assets_url" placeholder="http://www.site.com/assets.zip|Alternate Title" name="site_assets_url" style="width:80%" />'.$value.'</textarea>	

	<script type="text/javascript">
	jQuery(function($) {
		$("#site_assets_url").autosize();
	});
	</script>
	';
}

function site_assets_save( $post_id ) {
	if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_meta_box' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	if ( ! isset( $_POST['site_assets_url'] ) ) {
		return;
	}

	$site_assets_urls = sanitize_text_field( $_POST['site_assets_url'] );
	$sar = explode("\n", str_replace("\r", "", $_POST['site_assets_url'] ));
	$urls = array();
	foreach($sar AS $url){
		$urls[] = trim(sanitize_text_field($url));
	}
	$urls = json_encode($urls);
	update_post_meta( $post_id, '_site_assets_urls', $urls );
}
add_action( 'save_post', 'site_assets_save' );