jQuery( document ).ready( function() {

  initMultiCheckboxes();

  initSortableList();

} );

function initMultiCheckboxes() {
  var elements = document.querySelectorAll('.customize-control-checkbox-multiple input[type="checkbox"]');
  if ( elements.length > 0 ) {
    watchMultiCheckboxes(elements);
  }
}

function watchMultiCheckboxes( elements ) {
  for (var i = 0; i < elements.length; i++) {
    elements[i].addEventListener('change', function(event) {
      updateMultiCheckboxInput(this);
    });
  }
}

function initSortableList() {
  var elements = document.querySelectorAll('.customize-control-checkbox-multiple ul.sortable');
  if ( elements.length > 0 ) {
    for (var i = 0; i < elements.length; i++) {
      sortableList(elements[i]);
    }
  }
}

function sortableList( element ) {
  jQuery(element).sortable();
  jQuery(element).disableSelection();
  jQuery(element).on("sortupdate", function( event, ui ) {
    updateMultiCheckboxInput(event.target);
  });
}

function updateMultiCheckboxInput( eventSource ) {
  var parent      = eventSource.closest('.customize-control'),
      hiddenInput = parent.querySelector('input[type="hidden"]'),
      checked     = parent.querySelectorAll('input[type="checkbox"]:checked'),
      values      = [];
  if ( checked.length > 0 ) {
    for (var i = 0; i < checked.length; i++) {
      values.push(checked[i].value);
    }
  }
  hiddenInput.value = values.join(',');
  jQuery(hiddenInput).trigger('change');
}
