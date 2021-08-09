<?php
$placeholder = helsinki_theme_mod('helsinki_blog_filter', 'placeholder', __('Select category', 'helsinki-universal'));
$categories = helsinki_theme_mod('helsinki_blog_filter', 'categories', array());
if ( ! $categories ) {
	return;
}
$links = array();
foreach ($categories as $category_id) {
	$term = get_term($category_id, 'category');
	if ( ! $term || is_wp_error( $term ) ) {
		continue;
	}
	$links[$category_id] = sprintf(
		'<a href="%s">%s</a>',
		esc_url(add_query_arg( 'cat', $category_id, get_term_link($term) )),
		esc_html($term->name)
	);
}
?>
<div class="filters">
	<div class="dropdown">
		<span class="screen-reader-text">
			<?php esc_html_e('Show posts from a category', 'helsinki-universal'); ?>
		</span>
		<button id="category-filter" class="button-reset dropdown-trigger has-icon has-icon--after js-toggle" aria-haspopup="true" aria-controls="category-filter-menu" aria-expanded="false">
			<span class="current"><?php echo esc_html( $placeholder ); ?></span>
			<?php helsinki_svg_icon('arrow-down'); ?>
		</button>
		<div id="category-filter-menu" class="dropdown-content" aria-labelledby="category-filter" role="region">
			<?php echo implode('', $links); ?>
		</div>
	</div>
</div>
