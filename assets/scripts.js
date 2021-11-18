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

function setFocus(element) {
  try {
    element.focus();
  }
    catch (error) {
  }
  return (document.activeElement === element);
}

function firstFocusableChild(element) {
  var firstMenuItem = element.querySelector('.menu li a');
  if ( firstMenuItem ) {
    return firstMenuItem;
  }
  var firstInput = element.querySelector('input');
  if ( firstInput ) {
    return firstInput;
  }
  return element.firstElementChild;
}

function lastFocusableChild(element) {
  return element.lastElementChild;
}

function focusFirstChild(element) {
  for (var i = 0; i < element.childNodes.length; i++) {
    if ( setFocus(element.childNodes[i]) || focusFirstChild(element.childNodes[i]) ) {
      return true;
    }
  }
  return null;
}

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

const jsModal = {
  currentModal: null,
  currentTrigger: null,
  firstFocusable: null,
  lastFocusable: null,
}

function jsInitModal() {
  var modals = document.querySelectorAll('.js-modal');
  if ( modals.length > 0 ) {
    document.addEventListener('keydown', jsCloseModalOnEsc);
    for (var i = 0; i < modals.length; i++) {
      jsModalHandler(modals[i]);
    }
  }
}
jsInitModal();

function jsModalHandler(modal) {
  modal.addEventListener('modalOpen', jsModalOpened);
  modal.addEventListener('modalClose', jsModalClosed);
}

function jsModalTrapFocus(event) {
  var isTabPressed = ('Tab' === event.key || 9 === event.keyCode);
  if ( ! isTabPressed ) {
    return;
  }
  if ( event.shiftKey ) /* shift + tab */ {
    if (document.activeElement === jsModal.firstFocusable) {
      jsModal.lastFocusable.focus();
      event.preventDefault();
    }
  } else /* tab */ {
    if (document.activeElement === jsModal.lastFocusable) {
      jsModal.firstFocusable.focus();
      event.preventDefault();
    }
  }
}

function jsModalOpened(event) {
  jsModal.currentModal   = event.currentTarget;
  jsModal.currentTrigger = controllerElement(event.currentTarget);
  jsModal.firstFocusable = firstFocusableChild(jsModal.currentModal);
  jsModal.lastFocusable  = lastFocusableChild(jsModal.currentModal);
  jsModal.currentModal.addEventListener('keydown', jsModalTrapFocus);
}

function jsModalClosed(event) {
  jsModal.currentModal.removeEventListener('keydown', jsModalTrapFocus)
  setFocus(jsModal.currentTrigger);
  jsModal.currentModal   = null;
  jsModal.currentTrigger = null;
  jsModal.firstFocusable = null;
  jsModal.lastFocusable  = null;
}

function jsCloseModal(modal) {
  var toggleController = controllerElement(modal);
  if ( toggleController ) {
    jsToggleClose(toggleController, modal);
  } else {
    modal.classList.remove('active');
  }
}

function jsCloseModalOnEsc(event) {
  event = event || window.event;
  var isEscape = false;
  if ('key' in event) {
    isEscape = ('Escape' === event.key || 'Esc' === event.key);
  } else {
    isEscape = (27 === event.keyCode);
  }
  if (isEscape) {
    jsCloseActiveModals();
  }
}

function jsCloseActiveModals() {
  var activeModals = document.querySelectorAll('.modal.active');
  if ( activeModals.length > 0 ) {
    for (var i = 0; i < activeModals.length; i++) {
      jsCloseModal(activeModals[i]);
    }
  }
}

function isModal(target) {
  return target.classList.contains('modal');
}

function eventModalOpen(modal) {
  var event = jsEvent('modalOpen');
  modal.dispatchEvent(event);
}

function eventModalClose(modal) {
  var event = jsEvent('modalClose');
  modal.dispatchEvent(event);
}

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

jsMenuInit();

function jsMenuInit() {
	forCallbackLoop(
		document.querySelectorAll('.js-submenu-toggle'),
		function( submenuToggle ) {
			submenuToggle.addEventListener('touchstart', function(event){
				jsSubmenuToggle(event, submenuToggle);
			});
			submenuToggle.addEventListener('click', function(event){
				jsSubmenuToggle(event, submenuToggle);
			});
		}
	);

  forCallbackLoop(
		document.querySelectorAll('#main-menu .menu__item--parent > .link-wrap > a'),
		function( menuLink ) {
      var menuItem = menuLink.closest('.menu__item--parent');

			menuLink.addEventListener('mouseover', function(event){
				toggleMouseHoverClass(menuItem, true);
			});

			menuItem.addEventListener('mouseleave', function(event){
				toggleMouseHoverClass(menuItem, false);
			});
		}
	);

  document.addEventListener('click', closeAllSubmenus);
}

function jsSubmenuToggle(event, currentToggle) {
	event.preventDefault();

	var thisMenuItem = currentToggle.closest('.menu__item'),
			thisMenu = thisMenuItem.parentElement;

	forCallbackLoop(
		thisMenu.querySelectorAll('.menu__item.open'),
		function( openMenuItem ) {
			if ( thisMenuItem !== openMenuItem ) {
				closeSubmenu(
					openMenuItem.querySelector('.js-submenu-toggle')
				);
			}
		}
	);

	if ( isMenuItemOpen(thisMenuItem) ) {
		closeSubmenu(currentToggle);
	} else {
		openSubmenu(currentToggle);
	}
}

function closeAllSubmenus(event) {
  var mainMenu = document.getElementById('main-menu');
  if ( mainMenu.contains(event.target) ) {
    return;
  }

  forCallbackLoop(
		mainMenu.querySelectorAll('.menu__item.open'),
		function( openMenuItem ) {
      closeSubmenu(
        openMenuItem.querySelector('.js-submenu-toggle')
      );
		}
	);
}

function isMenuItemOpen(menuItem) {
	return menuItem.classList.contains('open');
}

function closeSubmenu(element) {
	if ( ! element ) {
		return;
	}
  element.closest('.menu__item').classList.remove('open');
  element.setAttribute('aria-expanded', "false");
}

function openSubmenu(element) {
	if ( ! element ) {
		return;
	}
  element.closest('.menu__item').classList.add('open');
  element.setAttribute('aria-expanded', "true");
}

function toggleMouseHoverClass(element, enabled) {
  if ( enabled ) {
    element.classList.add('menu__item--hover');
  } else {
    element.classList.remove('menu__item--hover');
  }
}

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
