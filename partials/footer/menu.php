<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<nav id="footer-menu-nav" class="footer__navigation" aria-labelledby="footer-menu-nav-label">
	<span id="footer-menu-nav-label" class="screen-reader-text">
		<?php echo esc_html_x( 'Quick links', 'Footer menu nav label', 'helsinki-universal' ); ?>
	</span>
	<?php echo helsinki_menu( 'footer_menu' ); ?>
</nav>
