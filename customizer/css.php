<?php
function helsinki_customizer_inline_styles() {
  $styles = array();

  $css = '';
  foreach ( $styles as $style ) {
    $properties = '';

    foreach ($style['properties'] as $property => $value) {
      if ( $value ) {
        $format = ('background-image' === $property) ? '%s: url(%s); ': '%s:%s; ';
        $properties .= sprintf(
          $format,
          $property,
          $value
        );
      }
    }

    if ( $properties ) {
      $media_query = (! empty($style['media']) && is_array($style['media'])) ? helsinki_customizer_media_query($style['media']): '';

      // TODO: Group multiple media queries
      if ( $media_query ) {
        $css .= sprintf(
          '%s {%s {%s}} ',
          $media_query,
          $style['selector'],
          $properties
        );
      } else {
        $css .= sprintf(
          '%s {%s} ',
          $style['selector'],
          $properties
        );
      }
    }
  }

  return $css;
}

function helsinki_customizer_media_query( $data = null ) {
  $rules = array_filter(array(
    ! empty($data['type']) ? esc_attr($data['type']) : '',
    ! empty($data['min']) ? '(min-width: ' . esc_attr($data['min']) . ')' : '',
    ! empty($data['max']) ? '(max-width: ' . esc_attr($data['max']) . ')' : '',
  ));
  if ( $rules ) {
    return sprintf(
      '@media %s',
      implode(' and ', $rules)
    );
  } else {
    return '';
  }
}
