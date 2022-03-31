<?php

/**
  * Config
  */
function helsinki_notifications_config() {
	$out = array();

	for ( $i = 1; $i <= helsinki_customizer_notification_count(); $i++ ) {
		$data = helsinki_theme_mod( 'helsinki_notification_notice_' . $i, '' );
		if ( $data ) {
			$out[] = $data;
		}
	}

	return $out;
}

/**
  * Action
  */
function helsinki_notifications() {
	$config = helsinki_notifications_config();

	if ( ! $config ) {
		return;
	}

	$current_langugage = '';
	if ( apply_filters( 'helsinki_polylang_active', false ) ) {
		$current_langugage = pll_current_language( 'slug' );
	}

	ob_start();

	foreach ( $config as $notice ) {

		if ( empty( $notice['enabled'] ) ) {
			continue;
		}

		if (
			$current_langugage &&
			! empty( $notice['lang'] ) &&
			$current_langugage !== $notice['lang']
		) {
			continue;
		}

		helsinki_notification( $notice, $current_langugage );
	}

	$notices = ob_get_clean();

	if ( $notices ) {
		get_template_part(
			'partials/notification/container',
			null,
			array( 'notices' => $notices )
		);
	}
}

/**
  * Elements
  */
function helsinki_notification( array $notice, string $langugage = '' ) {
	$notice = shortcode_atts(
		array(
			'type' => 'info',
			'title' => '',
			'text' => '',
			'link_text' => __( 'Read more', 'helsinki-universal' ),
			'link_url' => '',
			'is_external' => false,
		),
		$notice
	);

	$text = '';
	if ( $notice['title'] ) {
		if ( $langugage ) {
			$notice['title'] = pll__( $notice['title'] );
		}
		$text .= '<strong role="heading">' . esc_html( $notice['title'] ) . '</strong> ';
	}

	if ( $text || $notice['text'] ) {
		if ( $langugage ) {
			$notice['text'] = pll__( $notice['text'] );
		}
		$text = '<p>' . $text . esc_html( $notice['text'] ) . '</p>';
	}

	if ( $notice['link_url'] ) {
		if ( $langugage ) {
			$notice['link_url'] = pll__( $notice['link_url'] );
			$notice['link_text'] = pll__( $notice['link_text'] );
		}

		$text .= sprintf(
			'<a href="%s">%s%s</a>',
			esc_url( $notice['link_url'] ),
			esc_html( $notice['link_text'] ),
			helsinki_get_svg_icon(
				$notice['is_external'] ? 'link-external' : 'arrow-right'
			)
		);
	}

	$icon = array(
		'warning' => 'error-fill',
		'alert' => 'alert-circle-fill',
		'info' => 'info-circle-fill',
	);

	get_template_part(
		'partials/notification/notice',
		null,
		array(
			'id' => md5( $notice['type'] . $text ),
			'type' => $notice['type'],
			'icon' => helsinki_get_svg_icon( $icon[$notice['type']] ),
			'text' => $text,
		)
	);
}
