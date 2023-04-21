(function( wp ) {

    //write a script that hides/shows an element based on the current page template
    //if the current page template is default then show the element
    //if the current page template is not default then hide the element
    //element visibility should be toggled on page template change
    //element visibility should be toggled on page load

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
