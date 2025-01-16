<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<nav id="mobile-menu" class="navigation__menu" aria-labelledby="mobile-menu-nav-label">
	<span id="mobile-menu-nav-label" class="screen-reader-text">
		<?php echo esc_html_x( 'Navigation menu', 'Label - Nav - Mobile menu', 'helsinki-universal' ); ?>
	</span>
	<?php echo helsinki_menu('mobile_main_menu'); ?>
</nav>
