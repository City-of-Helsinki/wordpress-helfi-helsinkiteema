<?php

function helsinki_front_page_default_sections() {
	return apply_filters(
		'helsinki_front_page_default_sections',
		array(
			'content'      => __('Content', 'helsinki-universal'),
			'recent-posts' => __('Recent Posts', 'helsinki-universal'),
			'social'       => __('Social Feeds', 'helsinki-universal'),
			'feed-posts'   => __('Posts Feed', 'helsinki-universal'),
		)
	);
}

function helsinki_customizer_front_page_sections() {
  $out = array(
    'sections' => array(
      'config' => array(
        'title'          => esc_html_x( 'Sections', 'Customizer section title', 'helsinki-universal' ),
        'capability'     => 'edit_theme_options',
      ),
      'section_settings' => array(
        'visible' => helsinki_setting_multicheckbox(
          __( 'Visible sections', 'helsinki-universal' ),
          __( 'Checked sections will be displayed on the front page. Reorder sections with drag and drop. 
		  
		  This feature is being retired. Please use the front page\'s block editor to setup the front page content. Remember to keep the Content-checkbox active.', 'helsinki-universal' ),
          helsinki_front_page_default_sections(),
          true,
          array_keys(helsinki_front_page_default_sections())
        ),
      ),
    ),
  );

  foreach (helsinki_front_page_default_sections() as $key => $title) {
    $out[$key] = array(
      'config' => array(
        'title'           => $title,
        'capability'      => 'edit_theme_options',
        'active_callback' => 'helsinki_customizer_front_page_section_visibility',
      ),
      'section_settings' => array(),
    );

		if ( 'content' !== $key ) {
			$out[$key]['section_settings']['title'] = helsinki_setting_text(
				__( 'Section title', 'helsinki-universal' )
			);
		}

		switch ( $key ) {
			case 'content':
				$out[$key]['config']['description'] = esc_html__( 'Displays front page content set in Dashboard > Pages > {front page}.', 'helsinki-universal' );
				break;

			case 'recent-posts':
				$cateogries = helsinki_customizer_choices_categories();
				$options = array(
					'' => __('All Categories'),
				);
				$out[$key]['section_settings']['category'] = helsinki_setting_select(
					__( 'Category' ),
					'',
					$options + $cateogries,
					''
				);
				$out[$key]['section_settings']['posts_per_page'] = helsinki_setting_select(
					__( 'Post count', 'helsinki-universal' ),
					'',
					helsinki_customizer_choices_post_count(),
					3
				);
				break;

			case 'social':
				$out[$key]['section_settings']['shortcode'] = helsinki_setting_shortcode(
					__( 'Feed shortcode', 'helsinki-universal' ),
					'',
					''
				);
				break;

			case 'feed-posts':
				$out[$key]['section_settings']['feed_url'] = helsinki_setting_url(
					__( 'Feed URL', 'helsinki-universal' ),
					'',
					''
				);
				$out[$key]['section_settings']['feed_lifetime'] = helsinki_setting_number(
					__( 'Feed Cache time', 'helsinki-universal' ),
					__( 'The feed result is cached for 12 hours by default.', 'helsinki-universal' ),
					12,
					array(
						'min' => 0.25,
						'step' => 0.25,
					)
				);
				break;

			default:
				break;
		}

  }

  return $out;
}

function helsinki_customizer_front_page_section_visibility( $section ) {
  $id = substr($section->id, strlen('helsinki_front_page_'));
  $visible = $section->manager->get_setting('helsinki_front_page_sections[visible]')->value();
  return is_array($visible) ? in_array($id, $visible): true;
}
