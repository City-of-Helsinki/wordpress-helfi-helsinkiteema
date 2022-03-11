function jsLoadMoreInit() {
  var loadMores = document.querySelectorAll('.js-load-more');
  if ( loadMores.length > 0 ) {
    for (var i = 0; i < loadMores.length; i++) {
      jsLoadMoreHandler(loadMores[i]);
    }
  }
}
jsLoadMoreInit();

function jsLoadMoreHandler(loadMore) {
  loadMore.addEventListener('click', jsLoadMore);
}

function jsLoadMore(event) {
  event.preventDefault();

  var loadMoreButton = event.currentTarget;

  if ( loadMoreButton.disabled ) {
    return false;
  }
  loadMoreButton.disabled = true;

  var currentGrid = document.querySelector(loadMoreButton.dataset.loadMoreTarget);
  if ( ! currentGrid ) {
    return false;
  }

  var queryData = JSON.parse(loadMoreButton.dataset.loadMore);
  if ( ! queryData ) {
    return false;
  }

  var currentPage = loadMoreButton.dataset.page;

  var data = {
    action: queryData.action,
    nonce: queryData.nonce,
    query: queryData.query,
    page: currentPage,
	type: currentGrid.classList.contains('grid') ? 'grid' : 'default',
	offset: loadMoreButton.getAttribute('data-offset'),
	per_page: loadMoreButton.getAttribute('data-per-page'),
	is_front_page: queryData.is_front_page,
	is_home: queryData.is_home,
  }

  jQuery.post(queryData.endpoint, data, function(response){
    if ( response.success ) {
      currentGrid.insertAdjacentHTML( 'beforeend', response.data.html );
      eventLoadMoreRendered(currentGrid);
      currentPage++;
      loadMoreButton.setAttribute('data-page', currentPage);
      if ( response.data.end ) {
        loadMoreButton.style.display = 'none';
      } else {
        loadMoreButton.disabled = false;
      }
      currentGrid.children[currentGrid.children.length-response.data.count].querySelector('a').focus();
    } else {
      loadMoreButton.style.display = 'none';
    }
  });

}

function eventLoadMoreRendered(element) {
  var event = jsEvent('loadMoreRendered');
  element.dispatchEvent(event);
}
