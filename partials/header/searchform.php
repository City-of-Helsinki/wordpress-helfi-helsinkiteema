<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label for="search-input" class="screen-reader-text">
		<?php echo _x( 'Search for:', 'label', 'helsinki-universal' ); ?>
	</label>
	<div class="search-field hds-text-input hds-text-input__input-wrapper">
		<input id="search-input" class="hds-text-input__input" type="search" placeholder="<?php echo esc_attr_x( 'Search…', 'placeholder', 'helsinki-universal' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
		<button class="button-reset" type="reset">
			<span class="screen-reader-text"><?php echo esc_attr_x( 'Reset', 'reset button', 'helsinki-universal' ); ?></span>
			<?php helsinki_svg_icon('cross-circle-fill'); ?>
		</button>
		<button class="button-reset" type="submit">
			<span class="screen-reader-text"><?php echo esc_attr_x( 'Search', 'verb', 'helsinki-universal' ); ?></span>
			<?php helsinki_svg_icon('search'); ?>
		</button>
	</div>
	<button class="hds-button button button--white button--expanded has-icon has-icon--after" type="submit">
		<?php
			echo esc_attr_x( 'Search', 'verb', 'helsinki-universal' );
			helsinki_svg_icon('search');
		?>
	</button>
</form>
