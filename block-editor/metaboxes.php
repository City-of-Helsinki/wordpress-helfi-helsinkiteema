<?php

function helsinki_block_editor_add_metaboxes(): void {
	add_meta_box(
		'helsinki-sidebar-settings',
		__( 'Sidebar', 'helsinki-universal' ),
		'helsinki_block_editor_sidebar_metabox',
		'page',
		'normal',
		'default'
	);
}

add_filter( 'postbox_classes_page_helsinki-sidebar-settings', 'metabox_not_sortable' );
function metabox_not_sortable( array $classes ): array {
    $classes[] = 'not-sortable';

    return $classes;
}

function helsinki_block_editor_sidebar_metabox(): void {
	$post_id = get_the_ID();

	wp_nonce_field( 'helsinki_block_editor_sidebar_metabox', 'helsinki_sidebar_settings_nonce');
	?>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="sidebar_heading">
						<?php esc_html_e( 'Heading', 'helsinki-universal' ); ?>
					</label>
				</th>
				<td>
					<input
						type="text"
						name="sidebar_heading"
						id="sidebar_heading"
						value="<?php echo esc_attr( helsinki_post_sidebar_heading( $post_id ) ); ?>" />
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="sidebar_content">
						<?php esc_html_e( 'Text', 'helsinki-universal' ); ?>
					</label>
				</th>
				<td>
					<span
						class="hki-wp-editor-placeholder"
						data-post-id="<?php echo esc_attr( $post_id ); ?>"></span>
				</td>
			</tr>
		</tbody>
	</table>
	<?php
}

function helsinki_post_sidebar_heading( int $post_id ): string {
	return get_post_meta( $post_id, 'sidebar_heading', true ) ?: '';
}

function helsinki_post_sidebar_content( int $post_id ): string {
	return get_post_meta( $post_id, 'sidebar_content', true ) ?: '';
}

add_action( 'wp_ajax_helsinki_get_wp_editor', 'helsinki_get_wp_editor_ajax_handler' );
function helsinki_get_wp_editor_ajax_handler(): void {
	if ( ! check_ajax_referer( 'helsinki_get_wp_editor_nonce' ) ) {
		die;
	}

	$post_id = ! empty( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : 0;

	echo helsinki_get_wp_editor(
		helsinki_post_sidebar_content( $post_id ),
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

	die;
}

function helsinki_get_wp_editor( string $content, string $editor_id, array $options = array() ): string {
	ob_start();

	wp_editor( $content, $editor_id, $options );

	$temp = ob_get_clean();
	$temp .= \_WP_Editors::enqueue_scripts();
	$temp .= \_WP_Editors::editor_js();

	return $temp;
}

add_action( 'save_post', 'helsinki_block_editor_save_metaboxes' );
function helsinki_block_editor_save_metaboxes( $post_id ) {
	if ( ! isset( $_POST['helsinki_sidebar_settings_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['helsinki_sidebar_settings_nonce'], 'helsinki_block_editor_sidebar_metabox' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( wp_is_post_autosave( $post_id ) ) {
		return;
	}

	if ( isset( $_POST['sidebar_heading'] ) ) {
		update_post_meta( $post_id, 'sidebar_heading', sanitize_text_field( $_POST['sidebar_heading'] ) );
	}

	if ( isset( $_POST['sidebar_content'] ) ) {
		update_post_meta( $post_id, 'sidebar_content', $_POST['sidebar_content'] );
	}

	return $post_id;
}
