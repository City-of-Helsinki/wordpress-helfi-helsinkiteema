<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form <?php echo $args['form_attributes']; ?>>
    <label for="<?php echo esc_attr( $args['search_input_id'] ); ?>">
		<?php echo esc_html_x( 'Search by keyword', 'label', 'helsinki-universal' ); ?>
	</label>
	<div class="search-field hds-text-input hds-text-input__input-wrapper">
		<input
			id="<?php echo esc_attr( $args['search_input_id'] ); ?>"
			class="hds-text-input__input"
			type="search"
			value="<?php echo get_search_query(); ?>" name="s" />
		<button class="button hds-button" type="submit">
			<?php echo esc_html_x( 'Search', 'search submit', 'helsinki-universal' ); ?>
		</button>
	</div>
</form>
