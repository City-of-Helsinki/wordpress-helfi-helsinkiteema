<?php

/**
  * Social Media SDKs
  */
function helsinki_facebook_sdk() {
  echo '<script async defer crossorigin="anonymous" src="https://connect.facebook.net/fi_FI/sdk.js#xfbml=1&version=v9.0" nonce="xSuyhD2h"></script>';
}

function helsinki_twitter_sdk() {
  echo '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
}

/**
  * Social Media profiles
  *
  * Site core plugin integration
  *
  */
function helsinki_social_media_profile_urls() {
  if ( function_exists('\ArtCloud\Site\Core\Settings\SocialMedia\get_social_media_profiles') ) {
    return \ArtCloud\Site\Core\Settings\SocialMedia\get_social_media_profiles();
  } else {
    return array();
  }
}

if ( ! function_exists('helsinki_social_media_profile_url') ) {
  function helsinki_social_media_profile_url(string $profile) {
    $profiles = helsinki_social_media_profile_urls();
    return ! empty( $profiles['links'][$profile] ) ? $profiles['links'][$profile] : '';
  }
}

/**
  * Social Media Share
  */
if ( ! function_exists('helsinki_social_share_medias') ) {
	function helsinki_social_share_medias() {
		$default = helsinki_default_social_share_medias();
		$enabled = array();

		foreach ($default as $media => $config) {
			if ( apply_filters( 'helsinki_social_share_media_' . $media . '_enabled', false ) ) {
				$enabled[$media] = $config;
			}
		}

		return apply_filters('helsinki_social_share_medias', $enabled);
	}
}

if ( ! function_exists('helsinki_default_social_share_medias') ) {
	function helsinki_default_social_share_medias() {
		return array(
			'facebook' => array(
				'url'   => 'https://www.facebook.com/sharer.php?s=100&amp;u=%1$s&amp;title=%2$s',
				'text'  => __( 'Facebook', 'helsinki-universal' ),
				'title' => __( 'Share on Facebook', 'helsinki-universal' ),
			),
			'twitter'  => array(
				'url'   => 'https://twitter.com/intent/tweet?text=%2$s&amp;url=%1$s',
				'text'  => __( 'Twitter', 'helsinki-universal' ),
				'title' => __( 'Share on Twitter', 'helsinki-universal' ),
			),
			'linkedin' => array(
        		'url' => 'https://www.linkedin.com/sharing/share-offsite/?url=%1$s',
				'text'  => __( 'LinkedIn', 'helsinki-universal' ),
				'title' => __( 'Share on LinkedIn', 'helsinki-universal' ),
			),
		);
	}
}

if ( ! function_exists('helsinki_social_share_links') ) {
  function helsinki_social_share_links() {
    $medias = helsinki_social_share_medias();
    if ( ! $medias || ! is_array( $medias ) ) {
      return;
    }

	global $wp;
	$home = get_home_url();
	$title = helsinki_view_title();
	$permalink = home_url( $wp->request );
	$onclick = "javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;";
	$out = array();

    foreach ($medias as $key => $settings) {
      $out[] = sprintf(
        '<a class="share-link share-link--%1$s" href="%2$s" onclick="%3$s" title="%6$s">
					<span class="screen-reader-text">%5$s</span>
					%4$s
				</a>',
        esc_attr($key),
        esc_url(sprintf(
          $settings['url'],
          urlencode($permalink),
          urlencode($title),
          urlencode($home)
        )),
        $onclick,
        helsinki_get_svg_icon($key),
        esc_html($settings['title']),
        esc_html($settings['text'])
      );
    }

    return $out;
  }
}
