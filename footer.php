			<?php

				/**
				 * Hook: helsinki_main_bottom
				 *
				 */
				do_action( 'helsinki_main_bottom' );

				?>

			</main>

			<?php

				/**
				 * Hook: helsinki_footer_before
				 *
				 */
				do_action( 'helsinki_footer_before' );

			?>

			<?php ob_start(); ?>
			<footer id="footer" class="<?php helsinki_footer_classes(); ?>" role="contentinfo">

				<?php

					/**
					 * Hook: helsinki_footer
					 *
					 */
					do_action( 'helsinki_footer' );

				?>

			</footer>

			<?php

				/**
				 * Hook: helsinki_footer_after
				 *
				 */
				do_action( 'helsinki_footer_after' );

			?>

			<?php echo apply_filters( 'helsinki_footer_output', ob_get_clean() ); ?>

		</div> <!-- .layout-wrap -->

	<?php wp_footer(); ?>

	</body>
</html>
