<?php

/**
 * Multiple checkbox customize control class.
 * Original http://justintadlock.com/archives/2015/05/26/multiple-checkbox-customizer-control
 * @since  1.0.0
 * @access public
 */
class Theme_Multi_Checkbox_Customize_Control extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'checkbox-multiple';


	public $sortable = false;

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		$version = wp_get_theme()->get('Version');
		$assets = get_template_directory_uri() . '/customizer/controls/multi-checkbox/';

		wp_enqueue_style(
			'customize-control-checkbox-multiple',
			$assets . 'styles.css',
			array(),
			$version,
			'all'
		);
		
    wp_enqueue_script(
			'customize-control-checkbox-multiple',
			$assets . 'scripts.js',
			array(
				'jquery',
				'jquery-ui-sortable'
			),
			$version,
			true
		);
	}

	/**
	 * Displays the control content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function render_content() {

    if ( empty( $this->choices ) ) {
      return;
    }

    if ( ! empty( $this->label ) ) {
      printf(
        '<span class="customize-control-title">%s</span>',
        esc_html( $this->label )
      );
    }

    if ( ! empty( $this->description ) ) {
      printf(
        '<span class="description customize-control-description">%s</span>',
        esc_html( $this->description )
      );
    }

    $multi_values = ! is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value();
    $li_items = array();
		$sort_handle = $this->sortable ? '<span class="dashicons dashicons-sort"></span>': '';

    foreach ($this->choices as $value => $label) {
      $li_items[] = sprintf(
        '<li><label><input type="checkbox" value="%s" %s>%s</label>%s</li>',
        esc_attr( $value ),
        checked( in_array( $value, $multi_values ), true, false ),
        esc_html( $label ),
				$sort_handle
      );
    }

		$list_classes = array(
			'multi-checkbox-list',
		);

		if ( $this->sortable ) {
			$list_classes[] = 'sortable';
		}

    printf(
      '<ul class="%s">%s</ul>',
			implode(' ', $list_classes),
      implode('', $li_items)
    );

    printf(
      '<input type="hidden" value="%s" %s>',
      esc_attr( implode( ',', $multi_values ) ),
      $this->get_link()
    );
	}
}
