(function( $ ) {
  $(document).ready(function() {
    $(".meta-box-sortables .not-sortable [class^=handle-order]").remove();
  });

  $(document).ready(function(){
    var $placeholder = $('.hki-wp-editor-placeholder');
    if ( $placeholder ) {
      $.post(
        HelsinkiThemeEditorMetabox.ajax.url,
        {
          action: HelsinkiThemeEditorMetabox.ajax.action,
          _ajax_nonce: HelsinkiThemeEditorMetabox.ajax.nonce,
          post_id: HelsinkiThemeEditorMetabox.post_id,
        },
        function($data) {
          $($placeholder).replaceWith($data);
        }
      );
    }
  });
})(jQuery);
