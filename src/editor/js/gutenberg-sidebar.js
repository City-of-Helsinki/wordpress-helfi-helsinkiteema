(function( wp, element ) {
  if ( wp && element ) {

    function toggleMetaboxDisplay() {
      var currentTemplate = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'template' );

      if ( currentTemplate !== 'template/landing-page.php' && currentTemplate !== 'template/no-sidebar.php' ) {
        element.style.display = 'block';
      } else {
        element.style.display = 'none';
      }
    }

    toggleMetaboxDisplay();

    //element visibility should be toggled on page template change
    wp.data.subscribe( () => toggleMetaboxDisplay() );
  }
} )( window.wp, document.getElementById( 'helsinki-sidebar-settings' ) );
