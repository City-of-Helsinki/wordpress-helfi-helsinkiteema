<section class="notifications">
	<div class="hds-container">
		<?php
			foreach ( $args['notifications'] as $notification ) {
				echo $notification->render();
			}
		?>
	</div>

	<script type="text/javascript">
		<?php do_action( 'helsinki_notification_scripts' ); ?>
	</script>
</section>
