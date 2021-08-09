<div class="content__body">
	<?php
		if ( post_password_required() ) {
			echo get_the_password_form();
		} else {
			the_content();
		}
	?>
</div>
