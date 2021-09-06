<?php

function helsinki_theme_mods() {
	$mods = get_theme_mods();
	return $mods ?: array();
}

function helsinki_theme_mod( string $type, string $key = '', $default = null ) {
  $mod = get_theme_mod( $type, $default );
  if ( $key ) {
    return isset($mod[$key]) ? $mod[$key]: $default;
  } else {
    return $mod;
  }
}

function helsinki_theme_mod_is_enabled( string $key, array $mods = array() ) {
	return helsinki_theme_mod_is(
		$mods,
		$key,
		'enabled',
		true
	);
}

function helsinki_theme_mod_is( array $mods, string $type, string $key = '', $value = null ) {
	if ( $key ) {
		return isset($mods[$type][$key]) && $mods[$type][$key] === $value;
	} else {
		return isset($mods[$type]) && $mods[$type] === $value;
	}
}

function helsinki_theme_mod_value( array $mods, string $type, string $key = '' ) {
	if ( $key ) {
		return $mods[$type][$key] ?? '';
	} else {
		return $mods[$type] ?? '';
	}
}

// https://stackoverflow.com/a/31934345
function helsinki_hex_to_rgb( string $hex = '', $alpha = false ) {
  $hex      = str_replace('#', '', $hex);
  $length   = strlen($hex);
  $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
  $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
  $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
  if ( $alpha ) {
    $rgb['a'] = $alpha;
  }
  return $rgb;
}
