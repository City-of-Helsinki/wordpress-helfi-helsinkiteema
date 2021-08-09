<?php
$excerpt = $args['item']->get_description();
$first_image = helsinki_first_image_from_string($excerpt);
if ( $first_image ) {
	$excerpt = str_replace( $first_image, '', $excerpt );
}
?>
<article class="<?php helsinki_entry_classes( 'highlight entry--post' ); ?>">
	<a href="<?php echo esc_url( $args['item']->get_permalink() ); ?>">
		<?php
			echo helsinki_get_entry_image_with_wrap(
				$first_image ? wp_kses_post( $first_image ) : helsinki_entry_image_icon(),
				helsinki_entry_image_classes( $first_image ? false : true )
			);
		?>
		<h3 class="entry__title"><?php echo esc_html( helsinki_trim_title( $args['item']->get_title() ) ); ?></h3>
		<div class="entry__excerpt excerpt size-l show-for-l">
			<?php echo wp_kses_post( $excerpt ); ?>
		</div>
		<div class="entry__meta meta">
			<time class="date" datetime="<?php echo esc_attr( $args['item']->get_date('c') ); ?>">
				<?php echo esc_html( $args['item']->get_date( $args['date_format'] . ' ' . $args['time_format'] ) ); ?>
			</time>
		</div>
		<div class="entry__more">
			<?php helsinki_svg_icon('arrow-right'); ?>
		</div>
	</a>
</article>
