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

function focusLastChild(element) {
  for (var i = element.childNodes.length - 1; i >= 0; i--) {
    if ( setFocus(element.childNodes[i]) || focusLastChild(element.childNodes[i]) ) {
      console.log(element.childNodes[i]);
      return true;
    }
  }
  return null;
}

function focusToPrevious( element ) {
  var _previousFocusable;
  if ( element.previousElementSibling !== null ) { 
    _previousFocusable = element.previousElementSibling;
  }
  else {
    var _parent = element.parentElement;
    while ( _parent ) {
      if ( _parent.previousElementSibling !== null ) {
        _previousFocusable = _parent.previousElementSibling;
        break;
      }
      _parent = _parent.parentElement;
    }
  }

  while ( _previousFocusable ) {
    if ( focusLastChild(_previousFocusable) === true ) {
      break;
    }
    if ( _previousFocusable.previousElementSibling !== null ) {
      _previousFocusable = _previousFocusable.previousElementSibling;
    }
    else {
      var _parent = _previousFocusable.parentElement;
      while ( _parent ) {
        if ( _parent.previousElementSibling !== null ) {
          _previousFocusable = _parent.previousElementSibling;
          break;
        }
        _parent = _parent.parentElement;
      }
    }
  }
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

function helsinkiGalleryLightbox( config ) {

	'use strict';

	const {strings, icons} = config;

	var currentActive = null;
	var currentClickedElement = null;

	/**
	  * Init
	  */
	function initLightboxes( galleries, singleImages ) {
		if ( galleries.length === 0 && singleImages.length === 0 ) {
			return;
		}

		for ( let g = 0; g < galleries.length; g++ ) {
			initLightbox( galleries[g] );
		}

		for ( let s = 0; s < singleImages.length; s++ ) {
			initLightbox( singleImages[s] );
		}

		document.addEventListener('keydown', closeOnEsc);
	}

	function initLightbox( gallery ) {
		let figures = galleryFigures( gallery );
		if ( figures.length === 0 ) {
			return;
		}

		if ( ! hasImageLinks( gallery ) ) {
			return;
		}

		initGalleryImages( figures );

		let lightbox = createLightbox( gallery, figures );
		lightbox.addEventListener( 'click', clickLightbox );

		gallery.setAttribute( 'data-lightbox-id', lightbox.id );
		gallery.after( lightbox );

		lightboxInitialized( gallery, true );
	}

	function initGalleryImages( figures ) {
		for ( var f = 0; f < figures.length; f++ ) {
			initGalleryImage( figures[f] );
		}
	}

	function initGalleryImage( figure ) {
		let imageLink = figure.querySelector( 'a' );
		if (imageLink)
			imageLink.addEventListener( 'click', clickImage );
	}

	/**
	  * Event listeners
	  */
	function clickImage( event ) {
		event.preventDefault();
		openLightBox(
			currentGalleryLightBox(
				currentGallery( event.currentTarget )
			),
			event.currentTarget.firstElementChild,
			event.currentTarget
		);
	}

	function clickLightbox( event ) {
		if ( event.target === currentActive ) {
			closeLightbox( currentActive );
		}
	}

	function closeOnEsc( event ) {
		if ( ! currentActive ) {
			return;
		}
		event = event || window.event;
		let isEscape = false;
		if ( 'key' in event ) {
			isEscape = ('Escape' === event.key || 'Esc' === event.key);
		} else {
			isEscape = (27 === event.keyCode);
		}
		if ( isEscape ) {
			closeLightbox( currentActive );
		}
	}

	function clickCloseButton( event ) {
		event.preventDefault();
		closeLightbox( event.target.closest('.lightbox') );
	}

	function clickNext( event ) {
		event.preventDefault();

		if ( ! currentActive ) {
			return;
		}

		let currentImage = lightboxActiveImage( currentActive );
		if ( currentImage ) {
			if ( currentImage.nextElementSibling ) {
				switchActiveImage( currentImage, currentImage.nextElementSibling );
			} else {
				switchActiveImage( currentImage, firstLightboxImage( currentActive ) );
			}
		} else {
			switchActiveImage( null, firstLightboxImage( currentActive ) );
		}
	}

	function clickPrevious( event ) {
		event.preventDefault();

		if ( ! currentActive ) {
			return;
		}

		let currentImage = lightboxActiveImage( currentActive );
		if ( currentImage ) {
			if ( currentImage.previousElementSibling ) {
				switchActiveImage( currentImage, currentImage.previousElementSibling );
			} else {
				switchActiveImage( currentImage, lastLightboxImage( currentActive ) );
			}
		} else {
			switchActiveImage( null, lastLightboxImage( currentActive ) );
		}
	}

	/**
	  * Interactions
	  */
	function openLightBox( lightbox, clickedImage, clickedElement ) {
		if ( currentActive && currentActive !== lightbox ) {
			closeLightbox( currentActive );
		}

		let currentActiveImage = lightboxActiveImage( lightbox ),
			targetImage = clickedImage ? lightboxFigure( lightbox, clickedImage.src ) : null;

		switchActiveImage( currentActiveImage, targetImage );
		toggleHidden( lightbox, false );
		toggleActive( lightbox, true );
		toggleAriaExpanded( lightboxCloseButton( lightbox ), true );

		currentActive = lightbox;
		currentClickedElement = clickedElement;
		trapFocus(currentActive);
	}

	function closeLightbox( lightbox ) {
		toggleHidden( lightbox, true );
		toggleActive( lightbox, false );
		toggleAriaExpanded( lightboxCloseButton( lightbox ), false );
		switchActiveImage( lightboxActiveImage( lightbox ), null );
		freeFocus(currentActive, currentClickedElement);
		currentActive = null;
		currentClickedElement = null;
	}

	function switchActiveImage( currentImage, newImage ) {
		if ( currentImage ) {
			toggleActive( currentImage, false );
			toggleHidden( currentImage, true );
		}

		if ( newImage ) {
			toggleActive( newImage, true );
			toggleHidden( newImage, false );

      adjustContainerMaxWidth(
        currentGalleryContent( newImage ),
        newImage.firstElementChild.naturalWidth
      );
		}
	}

	/**
	  * Elements
	  */
	function galleryFigures( gallery ) {
		if (gallery.classList.contains('wp-block-image') || (gallery.classList.contains('wp-caption') && gallery.querySelector('img'))) {
			return [gallery];
		}

		return gallery.querySelectorAll( '.blocks-gallery-item figure, figure .wp-block-image, .gallery-item' );
	}

	function activeLightbox() {
		return document.querySelector( '.lightbox.is-active' );
	}

	function lightboxCloseButton( lightbox ) {
		return lightbox.querySelector( '.lightbox__close' );
	}

	function lightboxActiveImage( lightbox ) {
		return lightbox.querySelector( '.lightbox__images .is-active' );
	}

	function currentGallery( galleryItem ) {
		return galleryItem.closest( '.wp-block-gallery, .gallery' ) ? galleryItem.closest( '.wp-block-gallery, .gallery' ) : galleryItem.closest('figure');
	}

	function currentGalleryContent( galleryItem ) {
		return galleryItem.closest( '.lightbox__content' );
	}

	function currentGalleryLightBox( gallery ) {
		return document.getElementById(
			gallery.getAttribute( 'data-lightbox-id' )
		);
	}

	function firstLightboxImage( lightbox ) {
		return lightbox.querySelector( '.lightbox__images figure' );
	}

	function lastLightboxImage( lightbox ) {
		let figures = lightbox.querySelectorAll( '.lightbox__images figure' );
		return figures[ figures.length - 1 ];
	}

	function lightboxFigure( lightbox, source ) {
		let img = lightbox.querySelector( '.lightbox__images img[src="' + source + '"]' );
		return img ? img.parentElement : null;
	}

	/**
	  * Element creators
	  */
	function createLightbox( gallery, figures ) {
		// Element
		let lightboxWrap = createContainer( 'div', ['lightbox'] );
		let content = createContainer( 'div', ['lightbox__content'] );
		let title = createHeading( 'h2', strings.lightboxTitle );

		// Attributes
		let lightboxId = generateLightboxId( gallery );
		lightboxWrap.id = lightboxId;

		title.id = lightboxId + '-title';
		title.classList.add('screen-reader-text');

		lightboxWrap.setAttribute( 'role', 'dialog' );
		lightboxWrap.setAttribute( 'aria-modal', 'true' );
		lightboxWrap.setAttribute( 'aria-labelledby', title.id );
		toggleHidden( lightboxWrap, true );

		// Children
		content.append( title );
		content.append( createImages( figures ) );
    if ( figures.length > 1 ) {
      content.append( createNavigation() );
      content.classList.add('has-navigation');
    }
		content.append( createCloseButton( lightboxId ) );

		lightboxWrap.append( content );

		// Output
		return lightboxWrap;
	}

	function createContainer( tag, classNames ) {
		let element = document.createElement(tag);
		element.classList.add(...classNames);
		return element;
	}

	function createHeading( level, text ) {
		let heading = document.createElement( level );
		heading.innerHTML = text;
		return heading;
	}

	function createCloseButton( lightboxId ) {
		// Element
		let button = createContainer( 'button', ['lightbox__close', 'button-reset'] ),
        screenReaderText = createContainer( 'span', ['screen-reader-text'] );

		// Attributes
		button.id = 'close-' + lightboxId;
		button.type = 'button';
		screenReaderText.innerHTML = strings.close;

		button.setAttribute( 'aria-controls', lightboxId );
		toggleAriaExpanded( button, false );

		// Events
		button.addEventListener('click', clickCloseButton);

		// Output
    button.append(screenReaderText);
    button.innerHTML += icons.close;
		return button;
	}

	function createNavigation() {
		let container = createContainer( 'div', ['lightbox__navigation'] );

		container.append( createNavigationItem( 'prev', icons.prev, strings.prev, clickPrevious ) );
		container.append( createNavigationItem( 'next', icons.next, strings.next, clickNext ) );

		return container;
	}

	function createNavigationItem( type, icon, text, onClick ) {
		// Element
		let button = createContainer( 'button', ['lightbox__' + type, 'hds-button', 'hds-button--small'] ),
        screenReaderText = createContainer( 'span', ['screen-reader-text'] );

		// Attributes
		button.type = 'button';
		screenReaderText.innerHTML = text;

		// Events
		button.addEventListener('click', onClick);

		// Output
    button.append(screenReaderText);
    button.innerHTML += icon;
		return button;
	}

	function createImages( figures ) {
		let container = createContainer( 'div', ['lightbox__images'] );

		for (var f = 0; f < figures.length; f++) {
			container.append( createImage( figures[f] ) );
		}

		return container;
	}

	function createImage( source ) {
		let figure = document.createElement( 'figure' ),
			sourceImage = source.querySelector( 'img' ),
			sourceCaption = source.querySelector( 'figcaption' );

		figure.append( sourceImage.cloneNode() );
		if ( sourceCaption ) {
			figure.append( sourceCaption.cloneNode(true) );
		}

		toggleHidden( figure, true );

		return figure;
	}

	/**
	  * Element classes
	  */
	function toggleElementClass( element, className, enabled ) {
		if ( enabled ) {
			element.classList.add( className );
		} else {
			element.classList.remove( className );
		}
	}

	function lightboxInitialized( gallery, initialized ) {
		toggleElementClass( gallery, 'has-lightbox', initialized );
	}

	function toggleActive( element, active ) {
		toggleElementClass( element, 'is-active', active );
	}

	/**
	  * Aria
	  */
	function toggleAriaExpanded( element, expanded ) {
		if ( expanded ) {
			element.setAttribute( 'aria-expanded', 'true' );
		} else {
			element.setAttribute( 'aria-expanded', 'false' );
		}
	}

	function isAriaExpanded( element ) {
		return 'true' === element.getAttribute( 'aria-expanded' );
	}

	/**
	  * Helpers
	  */
	function generateLightboxId( gallery ) {
		if ( gallery.id ) {
			return 'lightbox-' + gallery.id;
		}
		return 'lightbox-' + ( Date.now() + gallery.offsetTop + gallery.clientHeight + gallery.childElementCount );
	}

	function hasImageLinks( gallery ) {
		if (gallery.classList.contains('wp-block-image') || (gallery.classList.contains('wp-caption') && gallery.querySelector('img'))) {
			var link = gallery.querySelector( 'a' );
			if (link) {
				var href = link.getAttribute('href');
				var acceptedEndings = ['jpg', 'jpg/', 'png', 'png/', 'webp', 'webp/'];
				for (var i = 0; i < acceptedEndings.length; i++) {
					if (href.endsWith(acceptedEndings[i])) {
						return link;
					}
				}
			}
			return false;
		}

		return gallery.querySelector( '.blocks-gallery-item > figure > a, figure.wp-block-image > a, .gallery-item > .gallery-icon > a' );
	}

	function toggleHidden( element, hidden ) {
		if ( hidden ) {
			element.hidden = true;
		} else {
			element.hidden = false;
		}
	}
	function trapFocus(element) {
		var focusableEls = element.querySelectorAll('a[href]:not([disabled]), button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])');
		var firstFocusableEl = focusableEls[0];  
		var lastFocusableEl = focusableEls[focusableEls.length - 1];
		var KEYCODE_TAB = 9;
	  
		firstFocusableEl.focus();
		element.addEventListener('keydown', element.kd = function(e) {
		  var isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);
	  
		  if (!isTabPressed) { 
			return; 
		  }
	  
		  if ( e.shiftKey ) /* shift + tab */ {
			if (document.activeElement === firstFocusableEl) {
			  lastFocusableEl.focus();
				e.preventDefault();
			  }
			} else /* tab */ {
			if (document.activeElement === lastFocusableEl) {
			  firstFocusableEl.focus();
				e.preventDefault();
			  }
			}
		});
	}
	function freeFocus(element, clickedElement) {
		element.removeEventListener('keydown', element.kd);
		clickedElement.focus();
	}

  function adjustContainerMaxWidth( container, maxWidth ) {
    container.style.maxWidth = maxWidth + 'px';
  }

	/**
	  * Module
	  */
	return {
		init: initLightboxes,
	};
}

const HelsinkiGalleryLightbox = helsinkiGalleryLightbox( helsinkiTheme );

HelsinkiGalleryLightbox.init(
	document.querySelectorAll( '.wp-block-gallery, .gallery' ),
	document.querySelectorAll( ':not(.wp-block-gallery, .gallery) > .wp-block-image, .wp-caption' )
);

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

function helsinkiNotifications() {

  function _init( notifications ) {
    if ( ! notifications ) {
      return;
    }

    var _notices = notifications.querySelectorAll('.notification');
    for (var i = 0; i < _notices.length; i++) {
      var _closeButton = _notices[i].querySelector('.close'),
          _noticeId = _notificationId(_notices[i]);

      if ( _isClosed(_noticeId) ) {
        _notices[i].remove();
      } else {
        _closeButton.addEventListener('click', _closeNotification);
      }
    }
  }

  function _notificationId( element ) {
    return 'helsinki_notification_' + element.id;
  }

  function _isClosed( id ) {
    return 'closed' === sessionStorage.getItem(id);
  }

  function _markClosed( id ) {
    sessionStorage.setItem( id, 'closed' );
  }


  function _closeNotification(event) {
    event.preventDefault();
    var _notice = event.currentTarget.closest('.notification');

    _markClosed(
      _notificationId(_notice)
    );

    focusToPrevious(_notice);

    _notice.remove();
  }

  /**
	  * Module
	  */
	return {
		init: _init,
	};
}

const HelsinkiNotifications = helsinkiNotifications();
HelsinkiNotifications.init(
	document.querySelector( '#main .notifications' )
);

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

(function( $ ) {

$(document).ready(function(){

    var links = $(".table-of-contents a");
  
    links.on("click", function(){
        var target = $($(this).attr("href"));
        target[0].setAttribute('tabindex', -1);
        target[0].focus();
    });

  });

})(jQuery);
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
