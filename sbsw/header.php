<?php
/**
 * Smash Balloon Social Wall Header Template
 * If enabled on the "Customize" tab, the social media filter is
 * displayed by this template
 *
 * @version 1.0 Social Wall by Smash Balloon
 *
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
?>

<div class="sb-wall-header">
	<div class="sbsw-filter-bar">
		<div class="sbsw-single-filter sbsw-single-filter-all">
			<a href="javascript:void(0);" data-plugin="all" tabindex="-1"><?php echo SW_Display_Elements::get_icon( 'heart' ); ?> <span><?php _e( 'All', 'social-wall' ); ?></span></a>
		</div>
	<?php foreach ( $plugins_in_feed as $plugin ) : ?>

		<?php if ( $plugin === 'instagram' ) : ?>
		<div class="sbsw-single-filter sbsw-single-filter-<?php echo esc_attr( $plugin  ); ?>">
			<a href="javascript:void(0);" data-plugin="<?php echo esc_attr( $plugin  ); ?>" tabindex="-1"><?php echo SW_Display_Elements::get_icon( $plugin ); ?> <span>Instagram</span></a>
		</div>
		<?php elseif ( $plugin === 'facebook' ) : ?>
		<div class="sbsw-single-filter sbsw-single-filter-<?php echo esc_attr( $plugin  ); ?>">
			<a href="javascript:void(0);" data-plugin="<?php echo esc_attr( $plugin  ); ?>" tabindex="-1"><?php echo SW_Display_Elements::get_icon( $plugin ); ?> <span>Facebook</span></a>
		</div>
		<?php elseif ( $plugin === 'twitter' ) : ?>
		<div class="sbsw-single-filter sbsw-single-filter-<?php echo esc_attr( $plugin  ); ?>">
			<a href="javascript:void(0);" data-plugin="<?php echo esc_attr( $plugin  ); ?>" tabindex="-1"><?php echo SW_Display_Elements::get_icon( $plugin ); ?> <span>Twitter</span></a>
		</div>
		<?php elseif ( $plugin === 'youtube' ) : ?>
		<div class="sbsw-single-filter sbsw-single-filter-<?php echo esc_attr( $plugin  ); ?>">
			<a href="javascript:void(0);" data-plugin="<?php echo esc_attr( $plugin  ); ?>" tabindex="-1"><?php echo SW_Display_Elements::get_icon( $plugin ); ?> <span>YouTube</span></a>
		</div>
		<?php endif; ?>

	<?php endforeach; ?>

	</div>
</div>