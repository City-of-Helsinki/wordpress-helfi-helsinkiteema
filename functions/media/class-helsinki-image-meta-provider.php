<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

final class Helsinki_Image_Meta_Provider
{
	private const PHOTOGRAPHER_META_KEY = '_photographer_text';
	private const PHOTOGRAPHER_FIELD_KEY = 'photographer_text';

	public function attachment_edit_field( array $form_fields, WP_Post $post ): array
	{
		if ( substr( $post->post_mime_type, 0, 5 ) === 'image' ) {
	        $form_fields[self::PHOTOGRAPHER_FIELD_KEY] = array(
	            'label' => __( 'Photographer', 'helsinki-universal' ),
	            'input' => 'text',
	            'value' => \esc_attr( $this->get_photographer( $post->ID ) ),
	        );
	    }

		return $form_fields;
	}

	public function save_attachment_field( array $post, array $attachment ): array
	{
		if ( isset( $attachment[self::PHOTOGRAPHER_FIELD_KEY] ) ) {
			$this->update_photographer(
				$post['ID'],
				$attachment[self::PHOTOGRAPHER_FIELD_KEY]
			);
	    }

		return $post;
	}

	public function get_image_credit( string $credit, int $post_id ): string
	{
		$photographer = $this->get_photographer( $post_id );

		if ( $photographer ) {
			return sprintf(
				__( 'Photo: %s', 'helsinki-universal' ),
				$photographer
			);
		}

		return $credit;
	}

	private function get_photographer( int $post_id ): string
	{
		return \get_post_meta( $post_id, self::PHOTOGRAPHER_META_KEY, true ) ?: '';
	}

	private function update_photographer( int $post_id, string $photographer ): void
	{
		\update_post_meta(
			$post_id,
			self::PHOTOGRAPHER_META_KEY,
			\sanitize_text_field( $photographer )
		);
	}
}
