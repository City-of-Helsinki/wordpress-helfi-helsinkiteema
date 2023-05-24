<div class="hds-container">
	<h2 class="search-results-title view-subtitle">
		<?php echo esc_html__('Search results', 'helsinki-universal'); ?>
		<?php if(get_search_query()) {
			echo 	' "' . get_search_query() . '"';
		} ?>
	</h2>
</div>
