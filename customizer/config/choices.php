<?php

function helsinki_customizer_choices_categories() {
  $terms = get_terms( array(
    'taxonomy'   => 'category',
    'hide_empty' => false,
    'fields'     => 'id=>name',
		'orderby'		=> 'name',
		'order'			=> 'ASC',
  ) );
  return ( $terms && ! is_wp_error( $terms ) ) ? $terms : array();
}



function helsinki_customizer_choices_style_schemes(string $name = '') {
	$data = apply_filters(
		'helsinki_customizer_choices_style_schemes',
		array(
			'' => __('Default', 'helsinki-universal'),
			'coat-of-arms' => __('Coat of Arms', 'helsinki-universal'),
			'gold' => __('Gold', 'helsinki-universal'),
			'silver' => __('Silver', 'helsinki-universal'),
			'brick' => __('Brick', 'helsinki-universal'),
			'bus' => __('Bus', 'helsinki-universal'),
			'copper' => __('Copper', 'helsinki-universal'),
			'engel' => __('Engel', 'helsinki-universal'),
			'fog' => __('Fog', 'helsinki-universal'),
			'metro' => __('Metro', 'helsinki-universal'),
			'summer' => __('Summer', 'helsinki-universal'),
			'suomenlinna' => __('Suomenlinna', 'helsinki-universal'),
			'tram' => __('Tram', 'helsinki-universal'),
		)
	);
	return $name ? $data[$name] ?? '' : $data;
}

function helsinki_customizer_choices_koros() {
	return array(
		'basic'     => _x('Basic', 'Koros motif', 'helsinki-universal'),
		'beat'      => _x('Beat', 'Koros motif', 'helsinki-universal'),
		'pulse'     => _x('Pulse', 'Koros motif', 'helsinki-universal'),
		'vibration' => _x('Vibration', 'Koros motif', 'helsinki-universal'),
		'wave'      => _x('Wave', 'Koros motif', 'helsinki-universal'),
	);
}

function helsinki_customizer_choices_placeholder_icon() {
	return array(
		'abstract-3'=> _x('Abstract', 'Placeholder icon', 'helsinki-universal') . ' 3',
		'abstract-4'=> _x('Abstract', 'Placeholder icon', 'helsinki-universal') . ' 4',
		'abstract-5'=> _x('Abstract', 'Placeholder icon', 'helsinki-universal') . ' 5',
		'abstract-6'=> _x('Abstract', 'Placeholder icon', 'helsinki-universal') . ' 6',
		'abstract-7'=> _x('Abstract', 'Placeholder icon', 'helsinki-universal') . ' 7',
		'abstract-8'=> _x('Abstract', 'Placeholder icon', 'helsinki-universal') . ' 8',
	);
}

function helsinki_customizer_choices_social_share() {
	return array(
		'facebook' => __('Facebook', 'helsinki-universal'),
		'twitter' => __('Twitter', 'helsinki-universal'),
		'linkedin' => __('LinkedIn', 'helsinki-universal'),
	);
}

function helsinki_customizer_choices_post_count() {
	return array(
		3 => 3,
		6 => 6,
	);
}
