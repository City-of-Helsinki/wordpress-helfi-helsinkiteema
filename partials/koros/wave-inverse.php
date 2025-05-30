<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="100%" height="<?php echo esc_attr($args['height']); ?>">
	<defs>
		<pattern id="koros_storm-<?php echo esc_attr($args['id']); ?>" x="0" y="0" width="<?php echo esc_attr($args['width']); ?>" height="<?php echo esc_attr($args['height']); ?>" patternUnits="userSpaceOnUse">
			<path transform="scale(<?php echo esc_attr($args['scale']); ?>)" d="M0,0 C1.2,2.6 3.1,4.7 5.7,5.7 11.3,8.1 17.7,5.5 20,0 Z"></path>
		</pattern>
	</defs>
	<rect fill="url(#koros_storm-<?php echo esc_attr($args['id']); ?>)" width="100%" height="<?php echo esc_attr($args['height']); ?>"></rect>
</svg>
