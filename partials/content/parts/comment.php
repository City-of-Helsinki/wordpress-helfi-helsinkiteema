<?php
	$waiting_moderation = ('0' == $comment->comment_approved) ? true : false;
	$classes = $waiting_moderation ? 'clearfix waiting-moderation' : 'clearfix';
?>

<li <?php comment_class( $classes ); ?> itemscope itemtype="http://schema.org/Comment">

	<article id="comment-<?php comment_ID(); ?>" class="comment__article">

		<header class="comment__article__header clearfix">
			<span class="comment__author" itemprop="author"><?php echo get_comment_author(); ?></span><time class="comment__date" datetime="<?php echo comment_time('c'); ?>" itemprop="datePublished">
				<a class="comment__date__link" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
					<?php comment_date( get_option('date_format') ); ?>
				</a>
			</time>
		</header>

		<?php if ( $waiting_moderation ) : ?>
			<p class="notice"><?php esc_html_e('Your comment is awaiting moderation.', 'helsinki-universal'); ?></p>
		<?php endif; ?>

		<section class="comment__article__content clearfix" itemprop="comment">
      <p class="comment__edit"><?php edit_comment_link( esc_html__( '(Edit comment)', 'helsinki-universal' ),'  ','' ); ?></p>
			<?php comment_text(); ?>
		</section>

    <footer class="comment__article__footer">
  		<p class="comment__reply"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></p>
    </footer>

	</article>
