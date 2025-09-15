<?php
$classes = array(
	'hds-koros',
	'hds-koros--' . $args['type'],
);

if ( $args['name'] ) {
	$classes[] = sprintf( 'hds-koros--%s-%s', $args['type'], $args['name'] );
}

if ( ! empty($args['flipped']) ) {
	$classes[] = 'hds-koros--flip-horizontal';
}
?>
<div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
	<?php
		get_template_part(
			'partials/koros/' . $args['type'],
			$args['name'],
			array(
				'id' => $args['id'],
				'height' => 42, //85
				'width' => 53, // 106
				'scale' => 2.65, // 5.3
			)
		);
	?>
</div>
