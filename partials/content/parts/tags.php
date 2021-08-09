<section class="content__tags tags">

	<div class="hds-container">
		<h2><?php esc_html_e('Tags'); ?></h2>
		<div class="tagcloud">
			<?php foreach (get_the_tags() as $index => $tag) :
				$classes = array(
					'tag-cloud-link',
					'tag-link-' . $tag->term_id,
					'tag-link-position-' . ($index + 1)
				);
				?>
				<a class="<?php echo esc_attr( implode(' ', $classes) ); ?>" href="<?php echo esc_url( get_term_link( $tag, 'post_tag') ); ?>" rel="tag">
					<?php echo esc_html( $tag->name ); ?>
				</a>
			<?php endforeach; ?>
		</ul>
	</div>

</section>
