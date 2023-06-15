<?php

/**
  * Configuration
  */
function helsinki_hero_layout_style_meta( int $id ) {
	return get_post_meta( $id, 'hero_layout_style', true );
}

function helsinki_legacy_hero_layout_full_meta( int $id ) {
	if (
		! helsinki_hero_layout_style_meta( $id ) &&
		get_post_meta( $id, 'hero_layout_full', true )
	) {
		return true;
	}
	return false;
}

function helsinki_disable_page_hero_meta( int $id ) {
	return get_post_meta( $id, 'disable_page_hero', true );
}

function helsinki_hero_is_disabled( int $id = 0 ) {
	if ( ! $id ) {
		$id = get_queried_object_id();
	}
	return helsinki_disable_page_hero_meta( $id ) ? true : false;
}

function helsinki_hero_has_background_image( int $id = 0 ) {
	if ( ! $id ) {
		$id = get_the_ID();
	}

	$legacy = helsinki_legacy_hero_layout_full_meta( $id );
	if ( $legacy ) {
		return true;
	}

	return 'background-image' === helsinki_hero_layout_style_meta( $id );
}

function helsinki_hero_has_diagonal( int $id = 0 ) {
	if ( ! $id ) {
		$id = get_the_ID();
	}
	return 'diagonal' === helsinki_hero_layout_style_meta( $id );
}

function helsinki_hero_has_image_below( int $id = 0 ) {
	if ( ! $id ) {
		$id = get_the_ID();
	}
	return 'image-below' === helsinki_hero_layout_style_meta( $id );
}

function helsinki_hero_layout_style( int $id = 0 ) {
	if ( ! $id ) {
		$id = get_the_ID();
	}

	$style = '';

	if ( helsinki_id_is_front_page( $id ) || helsinki_is_landing_page() ) {
		$layout = helsinki_hero_layout_style_meta( $id );
		if ( $layout ) {
			$style = $layout;
		}

		$legacy = helsinki_legacy_hero_layout_full_meta( $id );
		if ( $legacy ) {
			$style = 'background-image';
		}

		if ( ! $style ) {
			$style = apply_filters( 'helsinki_hero_layout_style_default', 'image-left' );
		}
	} else if ( is_page() ) {
		$style = 'default-style';
	}

	if ( $style ) {
		$style = 'has-' . $style;
	}

	return apply_filters( 'helsinki_hero_layout_style', $style, $id );
}

function helsinki_hero_thumbnail_has_caption( int $id = 0 ) {
	if ( ! $id ) {
		$id = get_the_ID();
	}
	return helsinki_base_image_credit( get_post_thumbnail_id( $id ) ) ? true : false;
}

/**
  * Styles
  */
function helsinki_hero_styles() {
	$styles = helsinki_element_styles(
		apply_filters( 'helsinki_hero_styles', array() )
	);

	if ( $styles ) {
		echo $styles;
	}
}

function helsinki_hero_image_styles() {
	$styles = helsinki_element_styles(
		apply_filters( 'helsinki_hero_image_styles', array() ),
		true
	);

	if ( $styles ) {
		echo $styles;
	}
}

function helsinki_hero_image_mobile_styles() {
	$styles = helsinki_element_styles(
		apply_filters( 'helsinki_hero_image_mobile_styles', array() ),
		true
	);

	if ( $styles ) {
		echo $styles;
	}
}

function helsinki_hero_background_image( $styles ) {
	$url = get_the_post_thumbnail_url(
		get_the_ID(),
		helsinki_image_size_full()
	);

	if ( $url ) {
		$styles = array_merge(
			$styles,
			array(
				'background-image' => 'url(' . $url . ')',
				'background-position' => 'center',
				'background-size' => 'cover',
			)
		);
	}

	return $styles;
}

/**
  * Classes
  */
function helsinki_hero_body_class( array $classes ) {
	return helsinki_add_body_class_has_n( $classes, 'hero' );
}

function helsinki_hero_classes( string $default = '' ) {
	$classes = array(
		$default,
		helsinki_hero_layout_style()
	);

	if ( apply_filters( 'helsinki_hero_class_thumbnail', false ) ) {
		$classes[] = 'has-thumbnail';
	}

	if ( apply_filters( 'helsinki_hero_class_thumbnail_caption', false ) ) {
		$classes[] = 'has-thumbnail-caption';
	}

	if ( apply_filters( 'helsinki_hero_class_excerpt', false ) ) {
		$classes[] = 'has-excerpt';
	}

	if ( apply_filters( 'helsinki_hero_class_koros', false ) ) {
		$classes[] = 'has-koros';
	}

	if ( apply_filters( 'helsinki_hero_class_call_to_action', false ) ) {
		$classes[] = 'has-call-to-action';
	}

	if ( apply_filters( 'helsinki_hero_class_full_width', false ) ) {
		$classes[] = 'is-full-width';
	}

	helsinki_element_classes( 'hero', $classes );
}

function helsinki_hero_container_classes( string $default = '' ) {
	$classes = array(
		$default,
		'hds-container',
		'flex-container',
		'flex-container--align-center',
	);

	if ( apply_filters( 'helsinki_hero_container_class_content_reverse', false ) ) {
		$classes[] = 'flex-container--row-reverse';
	}

	helsinki_element_classes(
		'hero_container',
		$classes
  );
}

/**
  * Elements
  */
function helsinki_hero() {
	$name = apply_filters( 'helsinki_hero_name', null );
	$args = apply_filters( 'helsinki_hero_args', array(), $name );
	get_template_part( 'partials/hero/hero', $name, $args );
}

function helsinki_hero_image( array $args = array() ) {
	$name = apply_filters( 'helsinki_hero_image_name', null );
	$args = apply_filters( 'helsinki_hero_image_args', $args, $name );
	get_template_part( 'partials/hero/parts/image', $name, $args );
}

function helsinki_hero_image_element() {
	echo helsinki_image_with_wrap(
		get_the_post_thumbnail( null, apply_filters( 'helsinki_hero_image_size', 'large' ) ),
		! helsinki_hero_has_background_image()
	);
}

function helsinki_hero_image_caption() {
	//get post thumbnail id
	$credit = helsinki_base_image_credit(get_post_thumbnail_id(get_the_ID()));

	//output figcaption if credit exists
	if ($credit) {
		echo '<figcaption class="wp-caption-text hero__thumbnail_caption">' . $credit . '</figcaption>';
	}
}

function helsinki_hero_image_mobile( array $args = array() ) {
	$name = apply_filters( 'helsinki_hero_image_name', null );
	$args = apply_filters( 'helsinki_hero_image_args', $args, $name );
	get_template_part( 'partials/hero/parts/mobile-image', $name, $args );
}

function helsinki_hero_image_mobile_element() {
	echo helsinki_image_with_wrap(
		get_the_post_thumbnail( null, apply_filters( 'helsinki_hero_image_size', 'medium' ) ),
		true
	);
}

function helsinki_hero_content( array $args = array() ) {
	$name = apply_filters( 'helsinki_hero_content_name', null );
	$args = apply_filters( 'helsinki_hero_content_args', $args, $name );
	get_template_part( 'partials/hero/parts/content', $name, $args );
}

function helsinki_hero_title( array $args = array() ) {
	$name = apply_filters( 'helsinki_hero_title_name', null );
	$args = apply_filters( 'helsinki_hero_title_args', $args, $name );
	get_template_part( 'partials/hero/parts/title', $name, $args );
}

function helsinki_hero_excerpt( array $args = array() ) {
	$name = apply_filters( 'helsinki_hero_excerpt_name', null );
	$args = apply_filters( 'helsinki_hero_excerpt_args', $args, $name );
	get_template_part( 'partials/hero/parts/excerpt', $name, $args );
}

function helsinki_hero_buttons() {
	helsinki_content_article_call_to_action();
}

function helsinki_hero_koros( array $args = array() ) {
	helsinki_koros(
		'page_hero',
		apply_filters( 'helsinki_hero_koros_flipped', true )
	);
}

function helsinki_hero_koros_mobile( array $args = array() ) {
	helsinki_koros(
		'page_hero_mobile',
		apply_filters( 'helsinki_hero_koros_mobile_flipped', true )
	);
}

function helsinki_hero_overlay_diagonal() {
	get_template_part( 'partials/hero/overlay/diagonal' );
}

function helsinki_hero_decoration_arrow() {
	get_template_part( 'partials/hero/decoration/arrow' );
}

/**
  * Template actions
  */
function helsinki_hero_actions() {

	add_filter( 'helsinki_hero_class_koros', '__return_true' );
	add_action( 'helsinki_hero_after', 'helsinki_hero_koros', 10 );

	add_action( 'helsinki_hero', 'helsinki_hero_content', 10 );

	if ( has_post_thumbnail() ) {
		add_filter( 'helsinki_hero_class_thumbnail', '__return_true' );

		if ( helsinki_hero_has_background_image() ) {
			add_filter( 'helsinki_hero_class_full_width', '__return_true' );

			remove_action( 'helsinki_hero_after', 'helsinki_hero_koros', 10 );
			add_action( 'helsinki_hero_after', 'helsinki_hero_koros_mobile', 10 );

			add_action( 'helsinki_hero_before', 'helsinki_hero_image', 20 );
			add_action( 'helsinki_hero_after', 'helsinki_hero_decoration_arrow', 30 );
			add_action( 'helsinki_hero_after', 'helsinki_hero_image_mobile', 20 );

			add_action( 'helsinki_hero_image', 'helsinki_hero_koros' );
			add_action( 'helsinki_hero_image', 'helsinki_hero_image_caption', 11 );
			add_action( 'helsinki_hero_image_size', 'helsinki_image_size_full' );
			
			add_action( 'helsinki_hero_mobile_image', 'helsinki_hero_image_mobile_element', 10 );
			add_action( 'helsinki_hero_mobile_image', 'helsinki_hero_image_caption', 11 );

			add_filter( 'helsinki_hero_image_styles', 'helsinki_hero_background_image' );

			add_filter( 'helsinki_hero_koros_flipped', '__return_false' );
		} else if ( helsinki_hero_has_image_below() ) {
			add_filter( 'helsinki_hero_class_full_width', '__return_true' );

			add_action( 'helsinki_hero_after', 'helsinki_hero_decoration_arrow', 30 );
			add_action( 'helsinki_hero_after', 'helsinki_hero_image', 20 );
			add_action( 'helsinki_hero_image', 'helsinki_hero_image_element', 10 );
			add_action( 'helsinki_hero_image', 'helsinki_hero_image_caption', 11 );
		} else {
			if ( ! helsinki_hero_has_diagonal() ) {
				add_action( 'helsinki_hero', 'helsinki_hero_image', 20 );
			} else {
				add_action( 'helsinki_hero_after', 'helsinki_hero_overlay_diagonal', 5 );
				remove_action( 'helsinki_hero_after', 'helsinki_hero_koros', 10 );
			}
				
			add_action( 'helsinki_hero_after', 'helsinki_hero_decoration_arrow', 30 );
			add_action( 'helsinki_hero_after', 'helsinki_hero_image_mobile', 20 );
			add_action( 'helsinki_hero_image', 'helsinki_hero_image_element', 10 );
			add_action( 'helsinki_hero_mobile_image', 'helsinki_hero_image_mobile_element', 10 );	
			add_action( 'helsinki_hero_mobile_image', 'helsinki_hero_image_caption', 11 );
		}

	}

	add_action( 'helsinki_hero_content', 'helsinki_hero_title', 10 );

	if ( has_excerpt() ) {
		add_filter( 'helsinki_hero_class_excerpt', '__return_true' );
		add_action( 'helsinki_hero_content', 'helsinki_hero_excerpt', 20 );
	}

	if ( helsinki_hero_thumbnail_has_caption() ) {
		add_filter( 'helsinki_hero_class_thumbnail_caption', '__return_true' );
	}

	if ( helsinki_content_article_has_call_to_action() ) {
		add_filter( 'helsinki_hero_class_call_to_action', '__return_true' );
		add_action( 'helsinki_hero_content', 'helsinki_hero_buttons', 30 );
	}

}
