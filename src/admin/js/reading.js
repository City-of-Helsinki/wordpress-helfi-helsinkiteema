(function( $ ) {

    $(document).ready(function(){
        var section = $('#front-static-pages'),
        staticPage = section.find('input:radio[value="page"]'),
        selects = section.find('select'),
        check_enabled = function(){
            selects.prop( 'disabled', null );
        };
        check_enabled();
        section.find( 'input:radio' ).off();    
        section.find( 'input:radio' ).on( 'change', check_enabled );    
      });
    
    })(jQuery);