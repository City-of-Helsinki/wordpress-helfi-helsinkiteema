<div class="share-links">
	<h2 class="title"><?php esc_html_e('Share this on', 'helsinki-universal'); ?>:</h2>
	<ul class="menu">
	<?php
		foreach ($args as $link) {
			echo '<li class="menu__item">' . $link . '</li>';
		}
	?>
	</ul>
</div>
