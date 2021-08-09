<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="100%" height="<?php echo esc_attr($args['height']); ?>">
	<defs>
		<pattern id="koros_storm-<?php echo esc_attr($args['id']); ?>" x="0" y="0" width="<?php echo esc_attr($args['width']); ?>" height="<?php echo esc_attr($args['height']); ?>" patternUnits="userSpaceOnUse">
			<path transform="scale(<?php echo esc_attr($args['scale']); ?>)" d="M20,800V0c-2.3,5.5-8.7,8.1-14.3,5.7C3.1,4.7,1.2,2.6,0,0v800H20z"></path>
		</pattern>
	</defs>
	<rect fill="url(#koros_storm-<?php echo esc_attr($args['id']); ?>)" width="100%" height="<?php echo esc_attr($args['height']); ?>"></rect>
</svg>
