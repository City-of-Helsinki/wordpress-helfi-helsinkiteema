function jsScrollInit() {
  var scrolls = document.querySelectorAll('.js-scroll');
  if ( scrolls.length > 0 ) {
    for (var i = 0; i < scrolls.length; i++) {
      jsScrollHandler(scrolls[i]);
    }
  }
}
jsScrollInit();

function jsScrollHandler(scroll) {
  if ( scroll.classList.contains('top') ) {
    scroll.addEventListener('click', jsScrollTop);
  }
}

function jsScrollTop(event) {
  event.preventDefault();
  window.scroll(0,0);
}
