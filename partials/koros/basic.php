<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="100%" height="<?php echo esc_attr($args['height']); ?>">
	<defs>
		<pattern id="koros_basic-<?php echo esc_attr($args['id']); ?>" x="0" y="0" width="<?php echo esc_attr($args['width']); ?>" height="<?php echo esc_attr($args['height']); ?>" patternUnits="userSpaceOnUse">
			<path transform="scale(<?php echo esc_attr($args['scale']); ?>)" d="M0,800h20V0c-4.9,0-5,2.6-9.9,2.6S5,0,0,0V800z"></path>
		</pattern>
	</defs>
	<rect fill="url(#koros_basic-<?php echo esc_attr($args['id']); ?>)" width="100%" height="<?php echo esc_attr($args['height']); ?>"></rect>
</svg>
