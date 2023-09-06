<?php
/**
 * Smash Balloon Social Wall Feed Template
 * Adds main HTML that contains all elements of the feed
 *
 * @version 1.0 Social Wall by Smash Balloon
 *
 */
// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$settings = helsinki_sbsw_override_feed_settings($settings);
$feed_style_att = SW_Display_Elements::get_feed_style( $settings );
$colsmobile_setting = $settings['colsmobile'];
$cols_setting = $settings['cols'];

$theme_class = $settings['theme'] === 'dark' ? ' sbsw-dark' : '';
$list_class = $settings['layout'] === 'list' ? ' sbsw-list-layout' : '';
$bg_class = empty( str_replace( '#', '', $settings['background'] ) ) ? '' : ' sbsw-custom-bg';

do_action( 'sbsw_before_feed', $posts, $settings );
?>
<div id="sb-wall-<?php echo esc_attr( preg_replace( "/[^A-Za-z0-9 ]/", '', $feed_id ) ); ?>" class="sb-wall sbsw-mobcol-<?php echo esc_attr( $colsmobile_setting ); ?><?php echo esc_attr( $list_class . $bg_class ); ?> sbsw-col-<?php echo esc_attr( $cols_setting ); ?><?php echo esc_attr( $theme_class ); ?> cff-light" data-feedid="<?php echo esc_attr( $feed_id ); ?>" data-shortcode-atts="<?php echo esc_attr( $shortcode_atts ); ?>" <?php echo $feed_atts . $feed_style_att; ?> aria-hidden="true" tabindex="-1">
    <?php echo $maybe_feed_notice; ?>

	<?php if ( $settings['showfilter'] ) : ?>
		<?php include sbsw_get_feed_template_part( 'header', $settings ); ?>
	<?php endif; ?>

    <div class="sb-wall-items-wrap-outer-wrap">
        <div class="sb-wall-items-wrap sbsw-items-wrap-all sbsw-items-wrap-visible sbsw-items-wrap-current">
			<?php
			$this->posts_loop( $posts, $account_data, $settings );
			?>
        </div>
    </div>

	<?php include sbsw_get_feed_template_part( 'footer', $settings ); ?>

	<?php 
		$resized_image_data = sbsw_json_encode(sbsw_get_resize_data_for_post_set( $this->image_ids_post_set, $feed_id )); 
		$resized_image_data = str_replace('"{','{', $resized_image_data);
		$resized_image_data = str_replace('}"','}', $resized_image_data);
	?>

	<span class="sbsw-resized-image-data" data-feedid="<?php echo esc_attr( $feed_id ); ?>" data-resized="<?php echo esc_attr( $resized_image_data  ); ?>"></span>

    <?php do_action( 'sbsw_before_feed_end', $this, '' ); ?>
</div>

<?php do_action( 'sbsw_after_feed', $posts, $settings );?>