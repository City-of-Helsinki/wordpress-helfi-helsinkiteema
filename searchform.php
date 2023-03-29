<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label for="search-input" class="screen-reader-text">
		<?php echo _x( 'Search for:', 'label', 'helsinki-universal' ); ?>
	</label>
	<div class="search-field hds-text-input hds-text-input__input-wrapper">
		<input id="search-input" class="hds-text-input__input" type="search" placeholder="<?php echo esc_attr_x( 'Search…', 'placeholder', 'helsinki-universal' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		<button class="button-reset" type="submit">
			<span class="screen-reader-text"><?php echo esc_attr_x( 'Search', 'submit button', 'helsinki-universal' ); ?></span>
			<?php helsinki_svg_icon('search'); ?>
		</button>
	</div>
</form>
