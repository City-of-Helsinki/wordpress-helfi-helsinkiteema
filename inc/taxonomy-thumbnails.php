<?php

add_action( 'admin_init', 'helsinki_init_taxonomy_thumbnails' );
add_action( 'admin_enqueue_scripts', 'helsinki_wp_enqueue_media_for_taxonomy_thumbnails' );
add_action( 'admin_print_footer_scripts', 'helsinki_taxonomy_thumbnails_scripts' );

function helsinki_init_taxonomy_thumbnails() {
  $taxonomies = apply_filters(
    'helsinki_init_taxonomy_thumbnails',
    array(
			'category',
		)
  );

  if ( $taxonomies && is_array( $taxonomies ) ) {
		foreach ( $taxonomies as $taxonomy ) {
	    add_filter( "manage_edit-{$taxonomy}_columns", 'helsinki_add_featured_image_column' );
	    add_filter( "manage_{$taxonomy}_custom_column", 'helsinki_add_featured_image_column_content', 10, 3 );
	    add_action( "{$taxonomy}_add_form_fields", 'helsinki_add_featured_image_field', 10, 2 );
	    add_action( "created_{$taxonomy}", 'helsinki_save_featured_image_meta', 10, 2 );
	    add_action( "{$taxonomy}_edit_form_fields", 'helsinki_edit_featured_image_field', 10, 2 );
	    add_action( "edited_{$taxonomy}", 'helsinki_update_featured_image_meta', 10, 2 );
	  }
  }
}

function helsinki_add_featured_image_column( $columns ){
  $sorted_cols = array();
  foreach ( $columns as $id => $name ) {
    if ( 'cb' === $id ) {
      $sorted_cols[$id] = $name;
      $sorted_cols['featured_image'] = __( 'Image' );
    } else {
      $sorted_cols[$id] = $name;
    }
  }
  return $sorted_cols;
}

function helsinki_add_featured_image_column_content( $content, $column_name, $term_id ){
  if ( $column_name !== 'featured_image' ){
    return $content;
  }
  $image_id = get_term_meta( absint( $term_id ), 'featured_image', true );
  if ( $image_id ) {
    $src = wp_get_attachment_image_src( $image_id );
    if ( isset( $src[0] ) ) {
      $content .= '<img src="' . esc_url( $src[0] ) .'" width="50" height="50">';
    }
  }
  return $content;
}

function helsinki_add_featured_image_field($taxonomy) {
	wp_nonce_field( 'helsinki_taxonomy_featured_image', 'helsinki_taxonomy_featured_image_nonce', true, true );
  ?>
  <div class="form-field term-group">
    <div id="artcloud-site-core-image-selector">
      <label for="featured_image"><?php esc_html_e('Image'); ?></label>
      <div class="custom-img-container"></div>
      <button id="add_featured_image" class="button" type="button"><?php esc_html_e('Add'); ?></button>
      <button id="delete_featured_image" class="button" type="button"><?php esc_html_e('Delete'); ?></button>
      <input id="featured_image" class="custom-img-id" name="featured_image" type="hidden" value="">
    </div>
  </div>
  <?php
}

function helsinki_save_featured_image_meta( $term_id, $tt_id ){
  if (
		! empty( $_POST['featured_image'] ) &&
		! empty( $_POST['helsinki_taxonomy_featured_image_nonce'] ) &&
		wp_verify_nonce( $_POST['helsinki_taxonomy_featured_image_nonce'], 'helsinki_taxonomy_featured_image' )
	) {
    add_term_meta( $term_id, 'featured_image', absint( $_POST['featured_image'] ), true );
  }
}

function helsinki_edit_featured_image_field( $term, $taxonomy ){
    $upload_link = esc_url( get_upload_iframe_src( 'image', $term->term_id ) );
    $image_id = get_term_meta( $term->term_id, 'featured_image', true );
    $image_id = ($image_id) ? intval($image_id) : '';
    $src = wp_get_attachment_image_src( $image_id );
    $has_img = is_array( $src );
    ?>
    <tr class="form-field term-group-wrap">
      <th scope="row"><label for="featured_image"><?php esc_html_e('Image'); ?></label></th>
      <td>
        <div id="artcloud-site-core-image-selector">
          <div class="custom-img-container">
            <?php if ( $has_img ) : ?>
              <img src="<?php echo esc_url( $src[0] ) ?>" alt="" style="max-width:100%;" />
            <?php endif; ?>
          </div>
          <button id="add_featured_image" class="button" type="button"><?php esc_html_e('Add'); ?></button>
          <button id="delete_featured_image" class="button" type="button"><?php esc_html_e('Delete'); ?></button>
          <input id="featured_image" class="custom-img-id" name="featured_image" type="hidden" value="<?php echo esc_attr( $image_id ); ?>">
        </div>
      </td>
    </tr>
    <?php
}

function helsinki_update_featured_image_meta( $term_id, $tt_id ){
  if ( isset( $_POST['featured_image'] ) ){
    update_term_meta( $term_id, 'featured_image', absint( $_POST['featured_image'] ) );
  }
}

function helsinki_wp_enqueue_media_for_taxonomy_thumbnails() {
	$screen = get_current_screen();
	if ( ! empty( $screen->base ) && ('edit-tags' === $screen->base || 'term' === $screen->base) ) {
		wp_enqueue_media();
	}
}

function helsinki_taxonomy_thumbnails_scripts() {
  $screen = get_current_screen();
	if ( empty( $screen->base ) || ( 'edit-tags' !== $screen->base && 'term' !== $screen->base ) ) {
		return;
	}
  ?>
    <script>
      jQuery(document).ready(function($){
        var frame,
            metaBox = $('#artcloud-site-core-image-selector'),
            addImgLink = metaBox.find('#add_featured_image'),
            delImgLink = metaBox.find( '#delete_featured_image'),
            imgContainer = metaBox.find( '.custom-img-container'),
            imgIdInput = metaBox.find( '.custom-img-id' );

        addImgLink.on( 'click', function( event ){
          event.preventDefault();
          if ( frame ) {
            frame.open();
            return;
          }
          frame = wp.media({
            title: _wpMediaViewsL10n.mediaLibraryTitle,
            button: {
              text: _wpMediaViewsL10n.select,
            },
            multiple: false
          });
          frame.on( 'select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );
            imgIdInput.val( attachment.id );
          });
          frame.open();
        });

        delImgLink.on( 'click', function( event ){
          event.preventDefault();
          imgContainer.html( '' );
          imgIdInput.val( '' );
        });

      });
    </script>
  <?php
}
