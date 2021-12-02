<div class="navigation__languages">
	<ul class="languages menu">
		<?php
			foreach ( $args['languages'] as $code => $language ) {
				printf(
					'<li class="menu__item"><a href="%s" class="%s" hreflang="%s">%s</a></li>',
					esc_url( $language['url'] ),
					esc_attr( implode(' ', $language['classes']) ),
					esc_attr( $code),
					esc_html( $language['name'] )
				);
			}
		?>
	</ul>
</div>
