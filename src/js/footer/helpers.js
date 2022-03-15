function controlledElement(controller) {
  return document.getElementById(controller.getAttribute('aria-controls'));
}

function controllerElement(element) {
  return element.id ? document.querySelector('[aria-controls="' + element.id + '"]') : null;
}

function jsEvent(name) {
  var event;
  if ( typeof(Event) === 'function' ) {
    event = new Event(name);
  } else {
    event = document.createEvent('Event');
    event.initEvent(name, true, true);
  }
  return event;
}

function forCallbackLoop(items, callback) {
	if ( items && items.length > 0 ) {
		for (var i = 0; i < items.length; i++) {
			callback(items[i], i);
		}
	}
}
