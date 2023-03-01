<div class="navigation__languages">
	<ul class="languages menu">
		<?php
			global $l10n;
			foreach ( $args['languages'] as $code => $language ) {
				printf(
					'<li class="menu__item"><a href="%s" class="%s" hreflang="%s" lang="%s" %s>%s</a></li>',
					esc_url( $language['url'] ),
					esc_attr( implode(' ', $language['classes']) ),
					esc_attr( $code),
					esc_attr( $code),
					esc_attr((in_array('current-lang', $language['classes']) ? 'aria-current=true' : '')),
					esc_html( $language['name'] )
				);
			}
		?>
	</ul>
</div>
