<?php

function helsinki_add_image_attachment_fields_to_edit( $form_fields, $post ) {
		
    //if post mime type starts with "image"
    if ( substr( $post->post_mime_type, 0, 5 ) == 'image' ) {
        $form_fields["photographer_text"] = array(
            "label" => __("Photographer", "helsinki-universal"),
            "input" => "text",
            "value" => esc_attr( get_post_meta($post->ID, "_photographer_text", true) ),
        );
    }
			
	return $form_fields;
}
add_filter("attachment_fields_to_edit", "helsinki_add_image_attachment_fields_to_edit", null, 2);

function helsinki_add_image_attachment_fields_to_save( $post, $attachment ) {
	if ( isset( $attachment['photographer_text'] ) ) {
		update_post_meta( $post['ID'], '_photographer_text', esc_attr($attachment['photographer_text']) );
    }
	return $post;
}
add_filter("attachment_fields_to_save", "helsinki_add_image_attachment_fields_to_save", null , 2);

function helsinki_base_image_credit( $post_ID = null ) {

    $attachment_fields = get_post_custom( $post_ID );

    $credit_text = ( isset($attachment_fields['_photographer_text'][0]) && !empty($attachment_fields['_photographer_text'][0]) ) ? esc_attr($attachment_fields['_photographer_text'][0]) : '';
    
    $credit = ( $credit_text ) ? sprintf(__("Photo: %s", 'helsinki-universal'), $credit_text) : false;

    return $credit;

}