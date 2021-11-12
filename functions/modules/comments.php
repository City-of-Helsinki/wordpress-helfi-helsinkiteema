<?php
if ( ! function_exists('helsinki_comments') ) {
  function helsinki_comments() {
    comments_template();
  }
}

if ( ! function_exists('helsinki_comment_form') ) {
  function helsinki_comment_form() {
    $post_id       = get_the_ID();
    $commenter     = wp_get_current_commenter();
    $user          = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';

    $args = array(
      'comment_field'        => sprintf(
        '<p class="comment-form-comment">%s %s</p>',
        sprintf(
          '<label for="comment">%s</label>',
          _x( 'Comment', 'noun' )
        ),
        '<textarea id="comment" name="comment" rows="4" maxlength="65525" required="required"></textarea>'
      ),
      'logged_in_as'         => sprintf(
        '<p class="logged-in-as">%s</p>',
        sprintf(
          __( 'Logged in as %1$s. <a href="%2$s">Log out?</a>', 'helsinki-universal' ),
          $user_identity,
          wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
        )
      ),
      'title_reply' => __( 'Leave a comment', 'helsinki-universal' ),
      'title_reply_before'   => '<h2 class="comment-respond__title">',
      'title_reply_after'    => '</h2>',
      'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s button" value="%4$s" />',
      'submit_field'         => '%1$s%2$s',
    );
    comment_form( $args );
  }
}

if ( ! function_exists('helsinki_single_comment') ) {
  function helsinki_single_comment( $comment, $args, $depth ) {
    $child_path = get_stylesheet_directory() . '/partials/content/comment.php';
    if ( file_exists( $child_path ) ) {
      include $child_path;
    } else {
      include get_template_directory() . '/partials/content/comment.php';
    }
  }
}
