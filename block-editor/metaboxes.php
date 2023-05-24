<?php

function helsinki_block_editor_add_metaboxes() {
	add_meta_box(
		'helsinki-sidebar-settings',
		__( 'Sidebar', 'helsinki-universal' ),
		'helsinki_block_editor_sidebar_metabox',
		'page',
		'normal',
		'default'
	);
}

function metabox_not_sortable($classes) {
    $classes[] = 'not-sortable';
    return $classes;
}
add_filter('postbox_classes_page_helsinki-sidebar-settings', 'metabox_not_sortable');

function helsinki_block_editor_sidebar_metabox() {

	//get the post id
	$post_id = get_the_ID();

	//get the heading and content values
	$heading = get_post_meta( $post_id, 'sidebar_heading', true );
	$content = get_post_meta( $post_id, 'sidebar_content', true );

	wp_nonce_field( 'helsinki_block_editor_sidebar_metabox', 'helsinki_sidebar_settings_nonce')

	?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="sidebar_heading"><?php _e( 'Heading', 'helsinki-universal' ); ?></label>
					</th>
					<td>
						<input type="text" name="sidebar_heading" id="sidebar_heading" value="<?php echo esc_attr( $heading ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="sidebar_content"><?php _e( 'Text', 'helsinki-universal' ); ?></label>
					</th>
					<td>
						<?php
							wp_editor(
								$content,
								'sidebar_content',
								array(
									'textarea_name' => 'sidebar_content',
									'textarea_rows' => 10,
									'media_buttons' => false,
									'quicktags' => false,
									'tinymce' => array(
										'toolbar1' => 'bold,italic,|,link,unlink',
										'toolbar2' => '',
									),
								)
							);
						?>
					</td>
				</tr>
			</tbody>
		</table>
	<?php
}

add_action( 'save_post', 'helsinki_block_editor_save_metaboxes' );
function helsinki_block_editor_save_metaboxes( $post_id ) {

	//check if the nonce is set
	if ( ! isset( $_POST['helsinki_sidebar_settings_nonce'] ) ) {
		return;
	}

	//verify the nonce
	if ( ! wp_verify_nonce( $_POST['helsinki_sidebar_settings_nonce'], 'helsinki_block_editor_sidebar_metabox' ) ) {
		return;
	}

	//check if the user has permission to edit the post
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	//check if the post is a revision
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	//check if the post is an autosave
	if ( wp_is_post_autosave( $post_id ) ) {
		return;
	}

	//save the heading
	if ( isset( $_POST['sidebar_heading'] ) ) {
		update_post_meta( $post_id, 'sidebar_heading', sanitize_text_field( $_POST['sidebar_heading'] ) );
	}

	//save the content
	if ( isset( $_POST['sidebar_content'] ) ) {
		update_post_meta( $post_id, 'sidebar_content', $_POST['sidebar_content'] );
	}

	return $post_id;
}
