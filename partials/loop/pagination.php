<?php
global $paged;
global $wp_query;

if ( empty( $paged ) ) {
  $paged = 1;
}

$anchor = '';

//if $args is set
if ( isset( $args['max_num_pages'] ) ) {
  $pages = $args['max_num_pages'] ? (int) $args['max_num_pages'] : 1;
  $anchor = isset( $args['anchor'] ) ? '#'.$args['anchor'] : '';
}
else {
  $pages = $wp_query->max_num_pages ? (int) $wp_query->max_num_pages : 1;
}

$range = 2;
$showitems = ($range * 2) + 1;

if ( $pages < 2 ) {
  return;
}
?>
<div class="hds-pagination-container">
  <nav class="hds-pagination" role="navigation" aria-label="<?php esc_html_e( 'Page navigation', 'helsinki-universal' ); ?>" data-next="<?php esc_html_e( 'Next', 'helsinki-universal' ); ?>">

    <?php if ( $paged > 1 ) : ?>
      <a class="previous hds-button hds-button--supplementary hds-pagination__button-prev" href="<?php echo esc_url( get_pagenum_link( $paged - 1 ) . $anchor ); ?>" aria-label="<?php esc_html_e( 'Previous page', 'helsinki-universal' ); ?>"><span><?php echo helsinki_get_svg_icon('angle-left', 'inline-icon'); ?></span><span class="hds-button__label"><?php esc_html_e( 'Previous', 'helsinki-universal' ); ?></span></a>
    <?php endif; ?>

    <ul class="hds-pagination__pages">

    <?php if ( $paged >= $showitems -1 ) : ?>
      <li><a href="<?php echo esc_url( get_pagenum_link( 1 ) . $anchor ); ?>" class="hds-pagination__item-link" aria-label="<?php esc_html_e( 'First page', 'helsinki-universal' ); ?>"><span><?php esc_html_e(1); ?></span></a></li>
      <li><span class="hds-pagination__item-ellipsis">...</span></li>
      <?php endif; ?>

      <?php
        for ( $i = 1; $i <= $pages; $i++ ) {
          if ( 1 !== $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
            if ( $paged === $i ) {
              printf(
                '<li class="current" aria-label="%s" aria-current="true"><a class="hds-pagination__item-link hds-pagination__item-link--active" href="#"><span>%d</span></a></li>',
                sprintf( esc_attr__( 'Currently on page %d', 'helsinki-universal' ), $i ),
                esc_attr( $i )
              );

            } else {
              printf(
                '<li><a href="%s" class="hds-pagination__item-link" aria-label="%s"><span>%d</span></a></li>',
                esc_url( get_pagenum_link( $i ) . $anchor ),
                sprintf( esc_attr__( 'Page %d', 'helsinki-universal' ), $i ),
                esc_attr( $i )
              );
            }
          }
        }
      ?>

    <?php if ( $paged < $pages - $range ) : ?>
      <li><span class="hds-pagination__item-ellipsis">...</span></li>
      <li><a href="<?php echo esc_url( get_pagenum_link( $pages ) . $anchor ); ?>" class="hds-pagination__item-link" aria-label="<?php esc_html_e( 'Last page', 'helsinki-universal' ); ?>"><span><?php esc_html_e($pages); ?></span></a></li>
    <?php endif; ?>

    </ul>

    <?php if ( $paged < $pages ) : ?>
      <a class="next hds-button hds-button--supplementary hds-pagination__button-next" href="<?php echo esc_url( get_pagenum_link( $paged + 1 ) . $anchor ); ?>"  aria-label="<?php esc_html_e( 'Next page', 'helsinki-universal' ); ?>"><span class="hds-button__label"><?php esc_html_e( 'Next', 'helsinki-universal' ); ?></span><span><?php echo helsinki_get_svg_icon('angle-right', 'inline-icon'); ?></span></a>
    <?php endif; ?>

  </nav>
</div>