<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$search_form_id = '';
$search_input_id = 'search-input';

if ( ! empty( $args['id'] ) ) {
	$search_form_id = sprintf( 'id="%s-search-form"', esc_attr( $args['id'] ) );
	$search_input_id = sprintf( '%s-%s', $args['id'], $search_input_id );
}
?>
<form <?php echo $search_form_id; ?>
	class="search-form"
	role="search"
	method="get"
	action="<?php echo home_url( '/' ); ?>">
    <label for="<?php echo esc_attr( $search_input_id ); ?>">
		<?php echo esc_html_x( 'Search by keyword', 'label', 'helsinki-universal' ); ?>
	</label>
	<div class="search-field hds-text-input hds-text-input__input-wrapper">
		<input
			id="<?php echo esc_attr( $search_input_id ); ?>"
			class="hds-text-input__input"
			type="search"
			value="<?php echo get_search_query(); ?>" name="s" />
		<button class="button hds-button" type="submit">
			<?php echo esc_html_x( 'Search', 'search submit', 'helsinki-universal' ); ?>
		</button>
	</div>
</form>
