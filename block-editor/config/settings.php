<?php 
/** 
* Change block editor settings 
*/
function helsinki_block_editor_settings ( $settings ) {

  // Disable Openverse media category
	$settings['enableOpenverseMediaCategory'] = false;

  // Disable custom templates
	$settings['supportsTemplateMode'] = false;

	return $settings;
}