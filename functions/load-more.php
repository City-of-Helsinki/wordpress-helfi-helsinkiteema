<?php

function helsinki_ajax_load_more_args( WP_Query $wp_query ) {
  return array(
    'query'    => $wp_query->query,
    'nonce'    => wp_create_nonce('load_more'),
    'action'   => 'helsinki_ajax_load_more',
    'endpoint' => admin_url('admin-ajax.php'),
		'is_front_page' => is_front_page(),
		'is_home' => is_home(),
  );
}

function helsinki_ajax_load_more() {

	if ( empty($_POST['nonce']) || ! wp_verify_nonce( $_POST['nonce'], 'load_more' ) ) {
		wp_send_json_error();
	}

	if ( empty($_POST['query']) || ! is_array($_POST['query']) ) {
		wp_send_json_error();
	}

	$args = helsinki_esc_query_args($_POST['query']);
	$args['paged'] = esc_attr( $_POST['page'] );

	$offset = $_POST['offset'] ?? '';
	$per_page = $_POST['per_page'] ?? '';

	if ( $offset && $per_page ) {
		$paged = $args['paged'];
		unset($args['paged']);

		$args['posts_per_page'] = $per_page;
		$args['offset'] = $offset + ( ($paged - 1) * $per_page - $per_page );
	}

	$loop = new WP_Query($args);

	$type = $_POST['type'] ?? '';

	$html = '';
	if ( $loop->have_posts() ) {
		ob_start();
		while( $loop->have_posts() ) {
			$loop->the_post();
			if ( 'grid' === $type ) {
				helsinki_grid_entry();
			} else {
				helsinki_entry();
			}
		}
		wp_reset_postdata();
		$html = ob_get_clean();
	}

	if ( $html ) {
		$end = $loop->max_num_pages == $args['paged'];
		wp_send_json_success( array('html' => $html, 'count' => $loop->post_count, 'end' => $end) );
	} else {
		wp_send_json_error();
	}
}
add_action( 'wp_ajax_helsinki_ajax_load_more', 'helsinki_ajax_load_more' );
add_action( 'wp_ajax_nopriv_helsinki_ajax_load_more', 'helsinki_ajax_load_more' );

function helsinki_esc_query_args( array $args = array() ) {
  $out = array();
  foreach ($args as $key => $value) {
    if ( is_array($value) ) {
      $out[$key] = helsinki_esc_query_args($value);
    } else {
      $out[$key] = sanitize_text_field($value);
    }
  }
  return $out;
}
