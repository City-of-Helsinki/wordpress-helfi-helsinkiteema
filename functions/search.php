<?php

function helsinki_search_sidebar() {
	get_sidebar( 'search' );
}

function helsinki_search_title() {
	get_template_part(
		'partials/search/title',
		null,
		array()
	);
}

function helsinki_search_form_title() {
	get_template_part(
		'partials/search/form-title',
		null,
		array()
	);
}
