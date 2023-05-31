<?php
/**
 * Instagram Feed Footer Template
 * Adds pagination and html for errors and resized images
 *
 * @version 6.0 Instagram Feed Pro by Smash Balloon
 *
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$follow_btn_style   = SB_Instagram_Display_Elements::get_follow_styles( $settings ); // style="background: rgb();color: rgb();"  already escaped
$follow_btn_classes = strpos( $follow_btn_style, 'background' ) !== false ? ' sbi_custom' : '';
$show_follow_button = $settings['showfollow'];
$follow_button_text = __( $settings['followtext'], 'instagram-feed' );

$load_btn_style   = SB_Instagram_Display_Elements::get_load_button_styles( $settings ); // style="background: rgb();color: rgb();"  already escaped
$load_btn_classes = strpos( $load_btn_style, 'background' ) !== false ? ' sbi_custom' : '';
$load_button_text = __( $settings['buttontext'], 'instagram-feed' );

$footer_attributes   = SB_Instagram_Display_Elements::get_footer_attributes( $settings );

?>
<div id="sbi_load" <?php echo $footer_attributes; ?>>

	<?php if ( $use_pagination || sbi_doing_customizer( $settings ) ) : ?>
		<a class="sbi_load_btn" href="javascript:void(0);"<?php echo SB_Instagram_Display_Elements::get_button_data_attributes( $settings ); ?> aria-hidden="true" tabindex="-1">
			<span class=""<?php echo SB_Instagram_Display_Elements::get_button_attribute( $settings ); ?>><?php echo esc_html( $load_button_text ); ?></span>
		</a>
	<?php endif; ?>

	<?php ob_start(); ?>

	<?php if ( ( $first_username && $show_follow_button ) || sbi_doing_customizer( $settings ) ) : ?>
        <a<?php echo SB_Instagram_Display_Elements::get_header_link( $settings, $first_username ) ?> class="sbi_follow_btn_link" target="_blank" rel="nofollow noopener">
            <span<?php echo SB_Instagram_Display_Elements::get_follow_attribute( $settings ); ?>><?php echo esc_html( $follow_button_text ); ?></span>
        </a>
	<?php endif; ?>

	<?php 
      $sbi_follow = ob_get_clean();
      echo apply_filters( 'helsinki_sbi_follow_output', $sbi_follow,)
    ?>


</div>
