<?php

/**
* @deprecated Please use helsinki_front_page_hero_is_full_width() instead
* @since 4.0.0 Marked deprecated in favor of helsinki_hero_has_background_image()
* @see /functions/hero.php
*/
function helsinki_front_page_hero_is_full_width() {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_hero_has_background_image()' );

	$id = get_option( 'page_on_front', 0 );
	if ( ! $id ) {
		return false;
	}

	return helsinki_hero_has_background_image( $id );
}

/**
* @deprecated Please use helsinki_front_page_hero_image_full_size() instead
* @since 4.0.0 Marked deprecated in favor of helsinki_image_size_full()
* @see /functions/hero.php
*/
function helsinki_front_page_hero_image_full_size() {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_image_size_full()' );
	return helsinki_image_size_full();
}

/**
* @deprecated Please use helsinki_front_page_hero_image_styles() instead
* @since 4.0.0 Marked deprecated in favor of helsinki_hero_image_styles()
* @see /functions/hero.php
*/
function helsinki_front_page_hero_image_styles() {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_hero_image_styles()' );

	helsinki_hero_image_styles();
}

/**
* @deprecated Please use helsinki_front_page_hero_background_image() instead
* @since 4.0.0 Marked deprecated in favor of helsinki_hero_background_image()
* @see /functions/hero.php
*/
function helsinki_front_page_hero_background_image( $styles ) {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_hero_background_image()' );
	return helsinki_hero_background_image( $styles );
}

/**
* @deprecated Please use helsinki_front_page_hero_image() instead
* @since 4.0.0 Marked deprecated in favor of helsinki_hero_image()
* @see /functions/hero.php
*/
function helsinki_front_page_hero_image( $args = array() ) {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_hero_image()' );
	helsinki_hero_image( $args );
}

/**
* @deprecated Please use helsinki_front_page_hero_image_element() instead
* @since 4.0.0 Marked deprecated in favor of helsinki_hero_image_element()
* @see /functions/hero.php
*/
function helsinki_front_page_hero_image_element() {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_hero_image_element()' );
	helsinki_hero_image_element();
}

/**
* @deprecated Please use helsinki_front_page_hero_content() instead
* @since 4.0.0 Marked deprecated in favor of helsinki_hero_content()
* @see /functions/hero.php
*/
function helsinki_front_page_hero_content( $args = array() ) {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_hero_content()' );
	helsinki_hero_content( $args );
}

/**
* @deprecated Please use helsinki_front_page_hero_title() instead
* @since 4.0.0 Marked deprecated in favor of helsinki_hero_title()
* @see /functions/hero.php
*/
function helsinki_front_page_hero_title( $args = array() ) {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_hero_title()' );
	helsinki_hero_title( $args );
}

/**
* @deprecated Please use helsinki_front_page_hero_excerpt() instead
* @since 4.0.0 Marked deprecated in favor of helsinki_hero_excerpt()
* @see /functions/hero.php
*/
function helsinki_front_page_hero_excerpt($args = array()) {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_hero_excerpt()' );
	helsinki_hero_excerpt( $args );
}

/**
* @deprecated Please use helsinki_front_page_hero_cta() instead
* @since 4.0.0 Marked deprecated in favor of helsinki_hero_buttons()
* @see /functions/hero.php
*/
function helsinki_front_page_hero_cta() {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_hero_buttons()' );
	helsinki_hero_buttons();
}

/**
* @deprecated Please use helsinki_front_page_hero_koros() instead
* @since 4.0.0 Marked deprecated in favor of helsinki_hero_koros()
* @see /functions/hero.php
*/
function helsinki_front_page_hero_koros() {
	helsinki_deprecation_notice( __FUNCTION__, 'helsinki_hero_koros()' );
	helsinki_hero_koros();
}
