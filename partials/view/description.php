<?php
$description = apply_filters(
	'helsinki_view_description',
	get_the_archive_description()
);
if ( ! $description ) {
	return;
}
?>
<div class="view-description">
	<?php echo wp_kses_post( $description ); ?>
</div>
