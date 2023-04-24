(function( wp ) {

    //get the current page template
    var currentTemplate = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'template' );

    //get the element to hide/show
    var element = document.getElementById( 'helsinki-sidebar-settings' );

    if ( currentTemplate !== 'template/landing-page.php' && currentTemplate !== 'template/no-sidebar.php' ) {
        element.style.display = 'block';
    }
    else {
        element.style.display = 'none';
    }

    //element visibility should be toggled on page template change
    wp.data.subscribe( function() {
        var currentTemplate = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'template' );
        if ( currentTemplate !== 'template/landing-page.php' && currentTemplate !== 'template/no-sidebar.php' ) {
            element.style.display = 'block';
        }
        else {
            element.style.display = 'none';
        }
    } );


} )( window.wp );
