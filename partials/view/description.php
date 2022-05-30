<?php
$description = helsinki_view_description_content();
if ( ! $description ) {
	return;
}
?>
<div class="view-description">
	<?php echo wp_kses_post( $description ); ?>
</div>
