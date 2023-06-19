<?php
/**
 * Smash Balloon Social Wall Footer Template
 * Adds the HTML for the "Load More" button
 *
 * @version 1.0 Social Wall by Smash Balloon
 *
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$load_button_text = __( $settings['buttontext'], 'social-wall' );
?>
<div class="sb-wall-footer">
	<?php if ( $use_pagination ) : ?>
        <a class="sb-wall-load-btn" href="javascript:void(0);" tabindex="-1">
            <span class="sb-wall-btn-text"><?php echo esc_html( $load_button_text ); ?></span>
        </a>
	<?php endif; ?>
</div>