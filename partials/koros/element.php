<?php
$classes = array(
	'hds-koros',
	'hds-koros--' . $args['type'],
);

if ( ! empty($args['flipped']) ) {
	$classes[] = 'hds-koros--flip-horizontal';
}
?>
<div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<?php
		get_template_part(
			'partials/koros/' . $args['type'],
			null,
			array(
				'id' => $args['id'],
				'height' => 42, //85
				'width' => 53, // 106
				'scale' => 2.65, // 5.3
			)
		);
	?>
</div>
