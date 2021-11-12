<?php
function helsinki_render_widget( string $content, array $classes = array() ) {
  $classes = array_map(function($class){
    if ( is_string($class) ) {
      return sprintf(
        'widget--%s',
        $class
      );
    } else {
      return;
    }
  }, $classes);
  $classes = array_filter($classes);
  $classes[] = 'widget';
  printf(
    '<div class="%s">%s</div>',
    esc_attr(implode(' ', $classes)),
    $content
  );
}

function helsinki_widget_title( string $title ) {
  return $title ? '<h2 class="widget__title">' . esc_html($title) . '</h2>': '';
}

if ( ! function_exists('helsinki_widget_facebook_feed') ) {
  function helsinki_widget_facebook_feed( string $url = '' ) {
    if ( $url ) {
      $url = esc_url($url, array('http', 'https'));
      $params = array(
        'href'                  => $url,
        'tabs'                  => 'timeline',
        'width'                 => '',
        'height'                => '',
        'small-header'          => 'true',
        'adapt-container-width' => 'true',
        'hide-cover'            => 'false',
        'show-facepile'         => 'false',
      );
      $attr = array();
      foreach ($params as $key => $value) {
        $attr[] = sprintf(
          'data-%s="%s"',
          strip_tags($key),
          esc_attr($value)
        );
      }
      helsinki_render_widget(
        sprintf(
          '<div class="fb-page" %1$s><blockquote cite="%2$s" class="fb-xfbml-parse-ignore"><a href="%2$s" target="_blank">Facebook</a></blockquote></div>',
          implode(' ', $attr),
          $url
        ),
        array(
          'social-feed',
          'facebook'
        )
      );
    }
  }
}

if ( ! function_exists('helsinki_widget_twitter_feed') ) {
  function helsinki_widget_twitter_feed( string $url = '' ) {
    if ( $url ) {
      helsinki_render_widget(
        sprintf(
          '<a class="twitter-timeline" data-height="500" data-theme="light" href="%s" target="_blank">Twitter</a>',
          esc_url($url, array('http', 'https'))
        ),
        array(
          'social-feed',
          'twitter'
        )
      );
    }
  }
}

function helsinki_widget_post_list( array $posts = array(), int $current = 0, string $title = '' ) {
  if ( ! $posts ) {
    return;
  }
  $items = array();
  foreach ($posts as $post) {
    $items[] = post_list_item($post, $current);
  }

  helsinki_render_widget(
    helsinki_widget_title($title) . '<ul class="menu menu--vertical">' . implode('', $items) . '</ul>',
    array(
      'widget_nav_menu',
    )
  );
}

function post_list_item( WP_Post $post, int $current_id = 0 ) {
  $class = ($post->ID === $current_id) ? 'menu__item menu__item--active': 'menu__item';
  return sprintf(
    '<li class="%s"><a href="%s">%s</a></li>',
    $class,
    esc_url(get_the_permalink($post)),
    esc_html($post->post_title)
  );
}
