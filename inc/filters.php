<?php

/**
  * Clean up the archive title
  */
function helsinki_get_the_archive_title_prefix( $prefix ) {
  return '<span class="prefix">' . $prefix . '</span>';
}
add_filter( 'get_the_archive_title_prefix', 'helsinki_get_the_archive_title_prefix' );

/**
  * Format view description
  */
add_filter( 'helsinki_view_description', 'do_blocks', 9 );
add_filter( 'helsinki_view_description', 'wptexturize' );
add_filter( 'helsinki_view_description', 'convert_smilies', 20 );
add_filter( 'helsinki_view_description', 'wpautop' );
add_filter( 'helsinki_view_description', 'shortcode_unautop' );
add_filter( 'helsinki_view_description', 'prepend_attachment' );
add_filter( 'helsinki_view_description', 'wp_filter_content_tags' );
add_filter( 'helsinki_view_description', 'do_shortcode', 11 ); // AFTER wpautop().
add_filter( 'helsinki_view_description', 'capital_P_dangit', 11 );

/**
  * Excerpts
  */
function helsinki_excerpt_more_html() {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'helsinki_excerpt_more_html' );

function helsinki_excerpt_character_length( $text, $raw_excerpt ) {
  $max_length = apply_filters( 'helsinki_excerpt_character_length', null );
  if ($max_length != null) {
    return substr(
      $raw_excerpt,
      0,
      $max_length
    );
  }
  else {
    return $raw_excerpt;
  }
}
add_filter( 'wp_trim_excerpt', 'helsinki_excerpt_character_length', 999, 2 );

/**
  * Comment Form
  */
function helsinki_comment_form_default_fields( $fields ) {
  unset( $fields['url'] );
  return $fields;
}
add_filter('comment_form_default_fields', 'helsinki_comment_form_default_fields');

/**
  * Widgets
  */
function helsinki_widget_tag_cloud_args( $default ) {
  $edit = array(
    'smallest'  => '13',
    'largest'   => '13',
    'unit'      => 'px',
    'separator' => '',
    'number'    => 100,
    'orderby'   => 'count',
    'order'     => 'DESC',
  );
  return array_merge( $default, $edit );
}
add_filter( 'widget_tag_cloud_args', 'helsinki_widget_tag_cloud_args');

function helsinki_sidebar_filter_widgets($widget_output, $widget_type) {
	if ($widget_type == 'categories') {
		$widget_output = str_replace('aria-current="page"', 'aria-current="true"', $widget_output);
	}
  else if ($widget_type == 'tag_cloud') {
    $tag = get_queried_object();
    if ($tag != null && $tag instanceof WP_TERM) {
      $tag_id = $tag->term_id;
      $occurence;
      preg_match('/class="tag-cloud-link tag-link-'.$tag_id.'/', $widget_output, $occurence, PREG_OFFSET_CAPTURE);
      if (count($occurence) > 0) {
        $widget_output = substr_replace($widget_output, 'aria-current="true"', $occurence[0][1], 0);
        $widget_output = str_replace('tag-link-'.$tag_id, 'tag-link-'.$tag_id.' current_tag', $widget_output);
      }
    }
  }
	return $widget_output;
}
add_filter( 'widget_output', 'helsinki_sidebar_filter_widgets', 10, 4 );

/**
  * Page Templates
  */
function helsinki_basic_page_template_name( $label, $context ) {
	return _x( 'Basic page', 'default page template name', 'helsinki-universal' );
}
add_filter( 'default_page_template_title', 'helsinki_basic_page_template_name', 10, 2 );


/**
  * Password
  */
  function helsinki_password_protected_page_form() {
    global $post;
  
    $loginurl = site_url() . '/wp-login.php?action=postpass';
    $label = 'pwbox-' . ( ! empty( $post->ID ) ? $post->ID : rand() );
  
    ob_start();
    ?>
    <form action="<?php echo esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); ?>" class="post-password-form" method="post">
        <p><?php  _e( 'This content is password protected. To view it please enter your password below:' ); ?></p>
        <div class="hds-text-input">
          <label class="hds-text-input__label" for="<?php echo $label; ?>"><?php _e( 'Password:' ) ?></label>
          <div class="hds-text-input__input-wrapper">
            <input class="hds-text-input__input" name="post_password" id="<?php echo $label; ?>" type="password" size="20" />
          </div>
        </div>
        <input class="hds-button button" type="submit" name="Submit" value="<?php echo esc_attr_x( 'Enter', 'post password form' ) ?>" />
    </form>
        
  
    <?php
    return ob_get_clean();
}   
add_filter( 'the_password_form', 'helsinki_password_protected_page_form', 10 );