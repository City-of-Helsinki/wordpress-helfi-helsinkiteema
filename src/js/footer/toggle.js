function jsToggleInit() {
  var toggles = document.querySelectorAll('.js-toggle');
  if ( toggles.length > 0 ) {
    for (var i = 0; i < toggles.length; i++) {
      jsToggleHandler(toggles[i]);
    }
  }
}
jsToggleInit();

function jsToggleHandler(toggle) {
  toggle.addEventListener('click', jsToggleClickEvent);
}

function jsToggleClickEvent(event) {
  event.preventDefault();
  var toggle = event.currentTarget;
  if ( null === toggle || undefined === toggle ) {
    return;
  }
  jsToggleClick(toggle);
}

function jsToggleClick(toggle) {
  var toggleTarget = controlledElement(toggle);
  if ( 'false' === toggle.getAttribute('aria-expanded') ) {
    jsToggleOpen(toggle, toggleTarget);
  } else {
    jsToggleClose(toggle, toggleTarget);
  }
}

function jsToggleOpen(toggle, target) {
  closeOtherToggles(toggle);

  if ( isModal(target) ) {
    eventModalOpen(target);
  }
  toggle.setAttribute('aria-expanded', 'true');
  jsToggleSwapText(toggle, 'expanded');
  target.hidden = false;
  target.classList.add('active');

  if (isSearch(target)) {
    setFocus(getHeaderSearchInput());
  }

  if ( ifControlsNoScroll(toggle) ) {
	fixedDocumentBody();
  }
}

function jsToggleClose(toggle, target) {
  if ( isModal(target) ) {
    eventModalClose(target);
  }
  toggle.setAttribute('aria-expanded', 'false');
  target.hidden = true;
  target.classList.remove('active');
  jsToggleSwapText(toggle, 'closed');

  if ( ifControlsNoScroll(toggle) ) {
		scrollableDocumentBody();
  }

  toggle.focus();
}

function jsToggleSwapText(toggle, status) {
	if ( toggle.hasAttribute('data-text') && toggle.hasAttribute('data-text-expanded') ) {
		var text = toggle.querySelector('.text');
		if ( text ) {
			text.textContent = 'expanded' === status ? toggle.getAttribute('data-text-expanded') : toggle.getAttribute('data-text');
		}
	}
  if ( toggle.hasAttribute('data-screen-reader-text') && toggle.hasAttribute('data-screen-reader-text-expanded') ) {
    var screenReaderText = toggle.querySelector('.screen-reader-text');
    if ( screenReaderText ) {
      screenReaderText.textContent = 'expanded' === status ? toggle.getAttribute('data-screen-reader-text-expanded') : toggle.getAttribute('data-screen-reader-text');
    }
  }
}

function ifControlsNoScroll(element) {
	if ( element.classList.contains('js-toggle-no-scroll') ) {
		var breakpoint = element.hasAttribute('data-no-scroll-breakpoint') ? parseInt(element.getAttribute('data-no-scroll-breakpoint'), 10) : 0,
			limit = element.hasAttribute('data-no-scroll-limit') ? element.getAttribute('data-no-scroll-limit') : 'up';
		if (
			('up' === limit && screen.width > breakpoint) ||
			(screen.width < breakpoint)
		) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function fixedDocumentBody() {
	document.body.style.position = 'fixed';
	document.body.style.top = `-${window.scrollY}px`;
}

const scrollY = document.body.style.top;
function scrollableDocumentBody() {
	document.body.style.position = '';
	document.body.style.top = '';
	window.scrollTo(0, parseInt(scrollY || '0') * -1);
}

function closeOtherToggles(current) {
	var openToggles = document.querySelectorAll('.js-toggle[aria-expanded="true"]');
	if ( openToggles.length > 0 ) {
	  for (var i = 0; i < openToggles.length; i++) {
		  if ( current !== openToggles[i] ) {
				jsToggleClick(openToggles[i]);
		  }
	  }
	}
}
