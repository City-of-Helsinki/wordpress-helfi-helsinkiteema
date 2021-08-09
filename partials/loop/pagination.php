<?php
global $paged;
global $wp_query;

if ( empty( $paged ) ) {
  $paged = 1;
}

$pages = $wp_query->max_num_pages ? (int) $wp_query->max_num_pages : 1;
$range = 2;
$showitems = ($range * 2) + 1;

if ( $pages < 2 ) {
  return;
}
?>
<nav class="pagination" role="navigation" aria-label="<?php esc_html_e( 'Page navigation', 'helsinki-universal' ); ?>" itemscope itemtype="http://schema.org/SiteNavigationElement">
  <ul>

    <?php if ( $paged >= $showitems -1 ) : ?>
      <li class="first"><a href="<?php echo esc_url( get_pagenum_link( 1 ) ); ?>" aria-label="<?php esc_html_e( 'First page', 'helsinki-universal' ); ?>"><span><?php esc_html_e( 'First', 'helsinki-universal' ); ?></span></a></li>
    <?php endif; ?>

    <?php if ( $paged >= $showitems -1 ) : ?>
      <li class="previous"><a href="<?php echo esc_url( get_pagenum_link( $paged - 1 ) ); ?>" aria-label="<?php esc_html_e( 'Previous page', 'helsinki-universal' ); ?>"><span><?php esc_html_e( 'Previous', 'helsinki-universal' ); ?></span></a></li>
    <?php endif; ?>

    <?php
      for ( $i = 1; $i <= $pages; $i++ ) {
  			if ( 1 !== $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
  				if ( $paged === $i ) {
            printf(
              '<li class="current" aria-label="%s" aria-current="true"><span>%d</span></li>',
              sprintf( esc_attr__( 'Currently on page %d', 'helsinki-universal' ), $i ),
              esc_attr( $i )
            );

  				} else {
            printf(
              '<li><a href="%s" aria-label="%s"><span>%d</span></a></li>',
              esc_url( get_pagenum_link( $i ) ),
              sprintf( esc_attr__( 'Page %d', 'helsinki-universal' ), $i ),
              esc_attr( $i )
            );
  				}
  			}
  		}
    ?>

    <?php if ( $paged < $pages - $range ) : ?>
      <li class="next"><a href="<?php echo esc_url( get_pagenum_link( $paged + 1 ) ); ?>"  aria-label="<?php esc_html_e( 'Next page', 'helsinki-universal' ); ?>"><span><?php esc_html_e( 'Next', 'helsinki-universal' ); ?></span></a></li>
    <?php endif; ?>

    <?php if ( $paged < $pages - $range ) : ?>
      <li class="last"><a href="<?php echo esc_url( get_pagenum_link( $pages ) ); ?>" aria-label="<?php esc_html_e( 'Last page', 'helsinki-universal' ); ?>"><span><?php esc_html_e( 'Last', 'helsinki-universal' ); ?></span></a></li>
    <?php endif; ?>

  </ul>
</nav>
