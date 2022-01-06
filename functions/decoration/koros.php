<?php

if ( ! function_exists('helsinki_koros_body_class') ) {
	function helsinki_koros_body_class( $classes ) {
		return helsinki_add_body_class_has_n( $classes, 'koros' );
	}
}

if ( ! function_exists('helsinki_koros') ) {
	function helsinki_koros( string $id, bool $flipped = false ) {
		$type = apply_filters(
			'helsinki_koros_type',
			helsinki_koros_type_basic()
		);
		if ( $type ) {
			get_template_part(
				'partials/koros/element',
				null,
				array(
					'id' => $id,
					'type' => $type,
					'flipped' => $flipped,
				)
			);
		}
	}
}

if ( ! function_exists('helsinki_block_koros') ) {
	function helsinki_block_koros( bool $flip = false ) {
		$id = time() . rand(1,100) . rand(1,100);
		ob_start();
		helsinki_koros($id, $flip);
		return ob_get_clean();
	}
}

if ( ! function_exists('helsinki_koros_set_type') ) {
	function helsinki_koros_set_type( string $type ) {
		$function = 'helsinki_koros_type_' . $type;
		if ( function_exists($function) ) {
			add_filter('helsinki_koros_type', $function);
		}
	}
}

if ( ! function_exists('helsinki_koros_type_basic') ) {
	function helsinki_koros_type_basic() {
		return 'basic';
	}
}

if ( ! function_exists('helsinki_koros_type_beat') ) {
	function helsinki_koros_type_beat() {
		return 'beat';
	}
}

if ( ! function_exists('helsinki_koros_type_pulse') ) {
	function helsinki_koros_type_pulse() {
		return 'pulse';
	}
}

if ( ! function_exists('helsinki_koros_type_vibration') ) {
	function helsinki_koros_type_vibration() {
		return 'vibration';
	}
}

if ( ! function_exists('helsinki_koros_type_wave') ) {
	function helsinki_koros_type_wave() {
		return 'wave';
	}
}
