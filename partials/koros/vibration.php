<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="100%" height="<?php echo esc_attr($args['height']); ?>">
	<defs>
		<pattern id="koros_wave-<?php echo esc_attr($args['id']); ?>" x="0" y="0" width="<?php echo esc_attr($args['width']); ?>" height="<?php echo esc_attr($args['height']); ?>" patternUnits="userSpaceOnUse">
			<polygon transform="scale(<?php echo esc_attr($args['scale']); ?>)" points="0,800 20,800 20,0 9.8,10.1 0,0 "></polygon>
		</pattern>
	</defs>
	<rect fill="url(#koros_wave-<?php echo esc_attr($args['id']); ?>)" width="100%" height="<?php echo esc_attr($args['height']); ?>"></rect>
</svg>
