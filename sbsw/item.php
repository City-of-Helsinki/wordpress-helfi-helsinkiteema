<?php
/**
 * Smash Balloon Social Wall Item Template
 * Adds an image, link, and other data for each post in the feed
 *
 * @version 1.0 Social Wall by Smash Balloon
 *
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$plugin = SW_Parse::get_plugin( $post );
$item_classes = SW_Display_Elements::get_item_classes( $settings, $post );

/* Style attributes */
$sb_item_style = SW_Display_Elements::get_sb_items_style( $settings );
$sb_inner_item_style = SW_Display_Elements::get_sb_inner_item_style( $settings );
$item_header_style = SW_Display_Elements::get_item_header_style( $settings );

/* Header and identity */
$post_id = SW_Parse::get_post_id( $post, $plugin );
$user_name = SW_Parse::get_username( $post, $plugin );
$full_name = SW_Parse::get_full_name( $account_data, $post, $plugin );
$identity = SW_Display_Elements::get_identity_text( $account_data, $post, $plugin );
$escaped_before_identity_html = SW_Display_Elements::get_escaped_before_identity_html( $account_data, $post, $plugin );

$item_permalink = SW_Parse::get_post_permalink( $post, $plugin );
$account_link = SW_Parse::get_account_link( $account_data, $post, $plugin );
$sm_icon = SW_Display_Elements::get_icon( $plugin );
$follow_button_text = SW_Display_Elements::get_follow_button_text( $plugin, $settings );

$avatar = SW_Parse::get_avatar( $account_data, $post, $plugin );
$avatar_class = SW_Display_Elements::get_avatar_class( $avatar );

$formatted_date = SW_Display_Elements::display_date( $post, $plugin, $settings );
$date_class = empty( $formatted_date ) ? ' sbsw-no-date' : '';

/* Media and light box */
$available_images_attribute = SW_Display_Elements::get_available_images_attribute( $account_data, $post, $plugin, $misc_data);
$lightbox_image = SW_Parse::get_media_thumbnail( $post, $settings, $plugin );
$lightbox_attribute = SW_Display_Elements::get_lightbox_attributes( $account_data, $post, $plugin );

$media_type = SW_Parse::get_media_type( $post, $plugin );
$maybe_play_button_html = SW_Display_Elements::maybe_play_button_html( $media_type );
$media_html = SW_Display_Elements::get_media_html( $post, $settings, $plugin );
$post_elements = isset( $settings['postElements'] ) ? $settings['postElements'] : array();
/* Text and bottom content */
$description = SW_Parse::get_description( $post, $plugin );
$escaped_post_bottom_content = SW_Display_Elements::get_escaped_bottom_content( $post, $plugin, $settings );

/* Stats and Share */
$footer_class = empty( $media_html ) ? ' sbsw-no-media' : '';
$escaped_stats_html = SW_Display_Elements::get_escaped_stats_html( $account_data, $post, $misc_data, $plugin, $settings );
$escaped_share_html = SW_Display_Elements::get_escaped_share_content( $account_data, $post, $plugin );
?>
<div class="sbsw-item sbsw-<?php echo esc_attr( $plugin ); ?>-item<?php echo esc_attr( $item_classes ); ?>" id="sbsw-<?php echo esc_attr( $post_id ); ?>"<?php echo $sb_item_style; ?>>
    <div class="sbsw-item-inner"<?php echo $sb_inner_item_style; ?>>

        <div class="sbsw-follow">
            <a href="<?php echo esc_url( $account_link ); ?>" target="_blank" rel="nofollow noopener" tabindex="-1">
                <?php
                echo $sm_icon;
                echo esc_html( $follow_button_text );
                ?>
            </a>
        </div>

        <div class="sbsw-item-header<?php echo esc_attr( $avatar_class . $date_class ); ?>"<?php echo $item_header_style; ?>>
            <div class="sbsw-identity sbsw-clear">
                <div class="sbsw-icon">
                    <a href="<?php echo esc_url( $item_permalink ); ?>" target="_blank" rel="noopener noreferrer nofollow" tabindex="-1">
                        <?php echo $sm_icon; ?>
                    </a>
                </div>
                <?php echo $escaped_before_identity_html; ?>
                <a href="<?php echo esc_url( $account_link ); ?>" target="_blank" rel="noopener noreferrer nofollow" tabindex="-1"> 
                    <?php if ( ! empty( $avatar ) && in_array('avatar', $post_elements) ) : ?>
                    <div class="sbsw-item-avatar">
                        <img src="<?php echo esc_url( $avatar ); ?>" alt="<?php echo sprintf( __( 'Account avatar for %s', 'social-wall' ), esc_attr( $identity ) ); ?>">
                    </div>
                    <?php endif; ?>

                    <div class="sbsw-author">
                        <div class="sbsw-author-name">
                            <?php if ( in_array('username', $post_elements ) ) : ?>
                                <p><?php echo $identity; ?></p>
                            <?php endif; ?>
                        </div>
                        <?php if ( SW_Parse::get_timestamp( $post, $plugin ) !== 0 &&
                            ! empty( $formatted_date ) && in_array('date', $post_elements) ) : ?>
                        <div class="sbsw-date">
                            <p><?php echo esc_html( $formatted_date ); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </a>
            </div>
        </div>

        <?php if ( ! empty( $media_html ) && in_array('media', $post_elements) ) : ?>
        <div class="sbsw-item-media"<?php echo $available_images_attribute; ?>>
            <?php echo $maybe_play_button_html; ?>
            <?php echo $media_html; ?>
            <a href="<?php echo esc_attr( $lightbox_image ); ?>" class="sbsw-lightbox-hover"<?php echo $lightbox_attribute; ?> tabindex="-1"><span class="sbsw-screenreader"><?php echo esc_html( sprintf( __( 'Lightbox link for post with description %s', 'social-wall' ), sbsw_maybe_shorten_text( $description, 50 ) ) ); ?></span></a>
        </div>
        <?php endif; ?>

	    <?php if ( ! empty( $escaped_post_bottom_content ) && in_array('text', $post_elements) ) : ?>
            <div class="sbsw-item-bottom-content">
                <?php echo $escaped_post_bottom_content; ?>
            </div>
        <?php endif; ?>
        
        <div class="sbsw-item-footer<?php echo esc_attr( $footer_class ); ?>">
            <div class="sbsw-item-bottom">
                <?php if ( in_array('summary', $post_elements) ) : ?>
                    <div class="sbsw-item-stats">
                        <?php echo $escaped_stats_html; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>