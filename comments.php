<?php
if ( post_password_required() ) {
  return;
}

$comments_open = comments_open();
$comments_count = get_comments_number();
if ( ! $comments_open && ! $comments_count ) {
  return;
}

$paginate_comments = get_comment_pages_count() > 1 && get_option( 'page_comments' );
?>

<section id="comments">

  <?php helsinki_heading( 1, __( 'Comments', 'helsinki-universal' ), '', array('container__heading') ); ?>

  <?php if ( have_comments() ) : ?>

    <ol class="comments-list">
      <?php
        wp_list_comments( array(
          'callback'    => 'helsinki_single_comment',
          'type'        => 'comment',
          'avatar_size' => 0,
          'style'       => 'ol',
        ) );
      ?>
    </ol>

    <?php if ( $paginate_comments ) : ?>
      <nav class="next-prev-post clearfix" role="navigation">
        <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'helsinki-universal' ); ?></h2>
        <div class="prev"><?php previous_comments_link( __( '&amp;larr; Older Comments', 'helsinki-universal' ) ); ?></div>
        <div class="next"><?php next_comments_link( __( 'Newer Comments &amp;rarr;', 'helsinki-universal' ) ); ?></div>
      </nav>
    <?php endif; ?>

    <?php if ( ! $comments_open && $comments_count ) : ?>
      <p class="comments-closed"><?php _e( 'Comments are closed.' , 'helsinki-universal' ); ?></p>
    <?php endif; ?>

  <?php endif; ?>

  <?php helsinki_comment_form(); ?>

</section>
