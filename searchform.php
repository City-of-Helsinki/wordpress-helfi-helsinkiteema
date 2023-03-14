<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label for="search-input">
		<?php echo _x( 'Search by keyword', 'label', 'helsinki-universal' ); ?>
	</label>
	<div class="search-field hds-text-input hds-text-input__input-wrapper">
		<input id="search-input" class="hds-text-input__input" type="search" value="<?php echo get_search_query(); ?>" name="s" />
		<button class="button hds-button" type="submit"><?php _ex( 'Search', 'search submit', 'helsinki-universal' ); ?></button>
	</div>
</form>
