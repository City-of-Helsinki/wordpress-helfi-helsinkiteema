function jsCloseInit() {
  var closes = document.querySelectorAll('.js-close');
  if ( closes.length > 0 ) {
    for (var i = 0; i < closes.length; i++) {
      jsCloseHandler(closes[i]);
    }
  }
}
jsCloseInit();

function jsCloseHandler(close) {
  close.addEventListener('click', jsCloseClick);
}

function jsCloseClick(event) {
	event.preventDefault();
	var close = event.currentTarget;

	if ( ! close ) {
		return;
	}
	var target = close.dataset.close ? document.getElementById(close.dataset.close) : close.parentElement,
	toggleController = controllerElement(target);

	if ( close && toggleController ) {
		jsToggleClose(toggleController, target);
	}
}
