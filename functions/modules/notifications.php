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
		),
		$notice
	);

	if ( $langugage ) {
		$notice = helsinki_notification_translated_texts( $notice );
	}

	$text = '';
	$title = '';
	if ( $notice['title'] ) {
		$title = esc_html( $notice['title'] );
		$text .= '<strong>' . esc_html( $notice['title'] ) . '</strong> ';
	}

	if ( $text || $notice['text'] ) {
		$text = '<p>' . $text . esc_html( $notice['text'] ) . '</p>';
	}

	if ( $notice['link_url'] ) {
		$text .= sprintf(
			'<a href="%s">%s</a>',
			esc_url( $notice['link_url'] ),
			esc_html( $notice['link_text'] )
		);
	}

	$icon = array(
		'warning' => 'error-fill',
		'alert' => 'alert-circle-fill',
		'info' => 'info-circle-fill',
	);

	$type = ! empty( $notice["type"] ) ? $notice["type"] : "info";

	get_template_part(
		'partials/notification/notice',
		null,
		array(
			'id' => md5( $type . $text ),
			'type' => $type,
			'icon' => helsinki_get_svg_icon( $icon[$type] ),
			'text' => helsinki_add_links_symbols( $text ),
			'title' => $title,
		)
	);
}

function helsinki_notification_translated_texts( array $notice ): array {
	$keys = array( 'title', 'text', 'link_text', 'link_url'	);

	if ( apply_filters( 'helsinki_polylang_active', false ) ) {
		foreach ( $keys as $key ) {
			if ( ! empty( $notice[$key] ) ) {
				$notice[$key] = pll__( $notice[$key] );
			}
		}
	}

	return $notice;
}

/**
  * Scripts
  */
function helsinki_notification_scripts() {
	get_template_part(
		'partials/notification/js/notifications.min',
		null,
		array()
	);
}
