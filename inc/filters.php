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
    'smallest'  => '14',
    'largest'   => '14',
    'unit'      => 'px',
    'separator' => '',
    'number'    => 100,
    'orderby'   => 'count',
    'order'     => 'DESC',
  );
  return array_merge( $default, $edit );
}
add_filter( 'widget_tag_cloud_args', 'helsinki_widget_tag_cloud_args');

function helsinki_widget_recent_posts_args( $instance, $widget_instance, $args ) {

  if ($widget_instance->id_base === 'recent-posts' && $instance['show_date'] === true) {

    add_filter( 'get_the_date', function ( $the_date, $d, $post )
    {
        // Set new date format
        $d = 'd.m.Y H:i';
        // Set new value format to $the_date
        $the_date = mysql2date( $d, $post->post_date );

        return $the_date;
    }, 10, 3 );

  }

  return $instance;
}
add_filter( 'widget_display_callback', 'helsinki_widget_recent_posts_args', 10, 3 );

function helsinki_sidebar_filter_widgets($widget_output, $widget_type) {
	if ($widget_type == 'categories') {
		$widget_output = str_replace('aria-current="page"', 'aria-current="true"', $widget_output); //replace aria attributes
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

function helsinki_sidebar_filter_rss_links($output) {
    return $output
		? helsinki_append_svg_icon_to_elements( $output, 'link-external', 'a', 'rsswidget' )
		: $output;
}

function helsinki_append_svg_icon_to_elements( string $html, string $icon, string $element_selector, string $target_class ): string {
	$dom = helsinki_create_dom_document_from_html( $html );

    $icon = $dom->importNode( helsinki_create_svg_icon_dom_item( $icon ), true );
    $elements = $dom->getElementsByTagName( $element_selector );

    for ($i = 0; $i < $elements->count(); $i++) {
        $element = $elements->item($i);

        if ( $element->getAttribute('class') === $target_class ) {
            $element->appendChild( $icon->cloneNode( true ) );
        }
    }

    return $dom->saveHTML();
}

function helsinki_create_dom_document_from_html( string $html ): DOMDocument {
    $dom = new DOMDocument();
    $dom->encoding = 'utf-8';

    libxml_use_internal_errors(true);

    $dom->loadHTML( helsinki_format_html_entities_utf8( $html ) );

    libxml_clear_errors();

    return $dom;
}

function helsinki_format_html_entities_utf8( string $html ): string {
	return htmlspecialchars_decode(
		mb_convert_encoding(
			htmlentities( $html, ENT_COMPAT, 'utf-8', false ),
			'ISO-8859-1',
			'UTF-8'
		)
	);
}

function helsinki_create_svg_icon_dom_item( string $name ) {
    $domIcon = new DOMDocument();
    $domIcon->encoding = 'utf-8';
    $domIcon->loadXML( helsinki_get_svg_icon( $name ) );

    return $domIcon->getElementsByTagName('svg')->item(0);
}

add_filter( 'helsinki_sidebar_output', 'helsinki_sidebar_filter_rss_links' );
add_filter( 'rss_widget_feed_link', '__return_false' );

function helsinki_filter_category_dropdown_widget($output) {
  $output = str_replace('<select', '<p><span class="hds-text-input__input-wrapper"><select', $output); //wrap select in span
  $output = str_replace('</select>', '</select><span class="select-chevron">' . helsinki_get_svg_icon('angle-down') . '</span></span></p>', $output); //add chevron to category dropdown
  return $output;
}
add_filter('wp_dropdown_cats', 'helsinki_filter_category_dropdown_widget');

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

/**
 * Embed
 */

wp_embed_register_handler(
  'helsinkichannel',
  '#(www\.)?helsinkikanava\.fi/(fi|fi_FI|en|en_US|sv|sv_SE)/web/helsinkikanava/player(/embed)?/((vod)\?assetId=([\d]+))?#i',
  'helsinki_handle_helsinkichannel_embed'
);

function helsinki_handle_helsinkichannel_embed( $matches, $attr, $url, $rawattr ) {
  $embed = sprintf(
          '<iframe src="https://www.helsinkikanava.fi/%1$s/web/helsinkikanava/player/embed/%2$s" width="1000" height="563" scrolling="no" allowfullscreen="true" sandbox="allow-scripts allow-presentation allow-same-origin"></iframe>',
          esc_attr($matches[2]),
          esc_attr($matches[4])
          );

  return apply_filters( 'embed_helsinkichannel', $embed, $matches, $attr, $url, $rawattr );
}

/**
 * Image
 */
function helsinki_image_render( $block_content = '', $block = [] ) {
	if ( empty( $block['blockName'] ) || 'core/image' !== $block['blockName'] ) {
		return $block_content;
	}

	if (function_exists('helsinki_base_image_credit')) {

    if (empty($block['attrs']['id'])) {
      return $block_content;
    }

		$credit = helsinki_base_image_credit($block['attrs']['id']);

    if (!empty($credit)) {
      preg_match_all('/(?<figcaption><figcaption[^\>]*>)(?<content>.*)(<\/figcaption>)/sU', $block_content, $matches);

      if (!empty($matches['figcaption'][0])) {
        $block_content = preg_replace(
          '/(?<figcaption><figcaption[^\>]*>)(?<content>.*)(<\/figcaption>)/sU',
          $matches['figcaption'][0] . $matches['content'][0] . ' ' . $credit . '</figcaption>',
          $block_content,
          1
        );
      } else {
        //if there is no figcaption, create one
        preg_match_all('/(?<figure><figure[^\>]*>)(?<content>.*)(<\/figure>)/sU', $block_content, $matches);
        $block_content = preg_replace(
          '/(?<figure><figure[^\>]*>)(?<content>.*)(<\/figure>)/sU',
          $matches['figure'][0] . $matches['content'][0] . '<figcaption>' . $credit . '</figcaption></figure>',
          $block_content,
          1
        );
      }

    }


	}

	return $block_content;
}
add_filter( 'render_block', 'helsinki_image_render', 10, 2 );

/**
 * Disable lazy loaded image auto sizes added in WP 6.7
 */
add_filter( 'wp_img_tag_add_auto_sizes', '__return_false' );
