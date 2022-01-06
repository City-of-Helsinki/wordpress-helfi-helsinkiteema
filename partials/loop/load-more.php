<button
	class="hds-button button js-load-more"
	data-load-more-target=".entries"
	data-load-more="<?php echo htmlspecialchars( json_encode( $args ), ENT_QUOTES, 'UTF-8' ); ?>"
	data-page="2">
	<?php esc_html_e('Show more', 'helsinki-universal'); ?>
</button>
