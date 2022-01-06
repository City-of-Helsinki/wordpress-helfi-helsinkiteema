<div class="table-of-contents">
	<h2 class="table-of-contents__title">
		<?php echo esc_html( $args['title'] ); ?>
	</h2>
	<ul class="table-of-contents__items">
		<?php echo implode( '', $args['items'] ); ?>
	</ul>
	<div class="table-of-contents__decoration">
		<?php helsinki_svg_icon( 'arrow-down' ); ?>
	</div>
</div>
