<?php

function helsinki_add_image_attachment_fields_to_edit( $form_fields, $post ) {
		
	// Re-order the "Caption" field by removing it and re-adding it later
	//$caption_field = $form_fields['post_excerpt'];
	//unset($form_fields['post_excerpt']);
	
	// Re-order the "File URL" field
	//$image_url_field = $form_fields['image_url'];
	//unset($form_fields['image_url']);
	
	// Add Caption before Credit field 
	//$form_fields['post_excerpt'] = $caption_field;
	
	// Add a Photographer field
	$form_fields["photographer_text"] = array(
		"label" => __("Photographer", "helsinki-universal"),
		"input" => "text",
		"value" => esc_attr( get_post_meta($post->ID, "_photographer_text", true) ),
	);
		
	// Add Caption before Credit field 
	//$form_fields['image_url'] = $image_url_field;
	
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