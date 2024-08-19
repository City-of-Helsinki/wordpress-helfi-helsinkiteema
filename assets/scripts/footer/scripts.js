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
		if (imageLink && imageLink.querySelector( 'img' ))
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
			if (link && link.querySelector( 'img' )) {
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

(function(){

  const headerSearch = HeaderSearch(getHeaderSearchElements());
  if ( headerSearch ) {
    return headerSearch.init();
  }

  function HeaderSearch(elements) {
    if ( ! elements ) {
      return;
    }

    var _initialized = false;
    var _isOpen = false;
    var _isInFocus = false;

    function _init() {
      if (! _initialized) {
        _isOpen = _toggleIsExpanded();

        elements.toggle.addEventListener('click', _handleToggleClick);
        elements.toggle.addEventListener('focusin', _handleFocusIn);
        elements.toggle.addEventListener('focusout', _handleFocusOut);

        _initialized = true;
      }
    }

    function _handleToggleClick(event) {
      _toggleIsExpanded() ? _closeSearch() : _openSearch();
    }

    function _handleOffClick(event) {
      _isOffClick(event) && _closeSearch();
    }

    function _handleKeyup(event) {
      _escKeyPressed(event) && _closeSearch();
    }

    function _handleFocusIn(event) {
      _isInFocus = true;
    }

    function _handleFocusOut(event) {
      _isFocusOut(event) && _closeSearch();
    }

    function _openSearch() {
      document.addEventListener('click', _handleOffClick);
      document.addEventListener('keyup', _handleKeyup);

      elements.form.addEventListener('focusin', _handleFocusIn);
      elements.form.addEventListener('focusout', _handleFocusOut);

      elements.toggle.setAttribute('aria-label', _toggleCloseText());

      _isOpen = true;
    }

    function _closeSearch() {
      if (_isOpen) {
        elements.toggle.setAttribute('aria-label', _toggleOpenText());

        _isOpen = false;

        document.removeEventListener('click', _handleOffClick);
        document.removeEventListener('keyup', _handleKeyup);

        elements.form.removeEventListener('focusin', _handleFocusIn);
        elements.form.removeEventListener('focusout', _handleFocusOut);

        jsToggleClose(elements.toggle, elements.container);

        _isInFocus = false;
      }
    }

    function _toggleIsExpanded() {
      return elements.toggle.getAttribute('aria-expanded') === 'true';
    }

    function _toggleCloseText() {
      return elements.toggle.dataset.textExpanded.concat(' ', elements.toggle.dataset.text.toLowerCase());
    }

    function _toggleOpenText() {
      return elements.toggle.dataset.text;
    }

    function _escKeyPressed(event) {
      return event.key === 'Escape' || (event.keyCode && event.keyCode === 27);
    }

    function _isOffClick(event) {
      return ! _elementIsOrContains(elements.container, event.target)
          && ! _elementIsOrContains(elements.form, event.target)
          && !_elementIsOrContains(elements.toggle, event.target);
    }

    function _isFocusOut(event) {
      return event.relatedTarget
          && _isInFocus
          && ! _elementIsOrContains(elements.form, event.relatedTarget)
          && ! _elementIsOrContains(elements.toggle, event.relatedTarget);
    }

    function _elementIsOrContains(compare, to) {
      return compare.isEqualNode(to) || compare.contains(to);
    }

    return {
      init: _init,
    }
  }

  function getHeaderSearchElements() {
    let _container = document.getElementById('header-search');
    if ( ! _container ) {
      return;
    }

    let _toggle = document.getElementById(_container.getAttribute('aria-labelledby'));
    let _form = _container.querySelector('.search-form');
    if ( ! _toggle || ! _form ) {
      return;
    }

    return {
      container: _container,
      toggle: _toggle,
      form: _form,
    }
  }
})();

function isSearch( target ) {
    return target.id === 'header-search';
}

function getHeaderSearchInput() {
    return document.getElementById('search-input');
}

jsSidebarNavInit();

function jsSidebarNavInit() {
  var sidebarNav = document.querySelector('.sidebar-navigation');
  var sidebarNavToggle = document.querySelectorAll(
    '.js-sidebarnavigation-toggle'
  );

  if (!sidebarNav || !sidebarNavToggle) {
    return;
  }

  forCallbackLoop(sidebarNavToggle, function (sidebarMenuToggle) {
    sidebarMenuToggle.addEventListener('touchstart', function (event) {
      jsSidebarMenuToggle(event, sidebarMenuToggle);
    });
    sidebarMenuToggle.addEventListener('click', function (event) {
      jsSidebarMenuToggle(event, sidebarMenuToggle);
    });
  });

  forCallbackLoop(sidebarNavToggle, function (sidebarMenuToggle) {
    var menuItem = sidebarMenuToggle.closest('.menu__item');
    console.log(menuItem);
    if (
      menuItem.classList.contains('current-menu-item') ||
      menuItem.classList.contains('current-menu-ancestor') ||
      menuItem.classList.contains('current_page_ancestor') ||
      menuItem.classList.contains('current_page_parent')
    ) {
      openSidebarMenu(sidebarMenuToggle);
    }
  });
}

function jsSidebarMenuToggle(event, currentToggle) {
  event.preventDefault();

  var thisMenuItem = currentToggle.closest('.menu__item'),
    thisMenu = thisMenuItem.parentElement;

  forCallbackLoop(
    thisMenu.querySelectorAll('.menu__item.open'),
    function (openMenuItem) {
      if (thisMenuItem !== openMenuItem) {
        closeSidebarMenu(
          openMenuItem.querySelector('.js-sidebarnavigation-toggle')
        );
      }
    }
  );

  if (isMenuItemOpen(thisMenuItem)) {
    closeSidebarMenu(currentToggle);
  } else {
    openSidebarMenu(currentToggle);
  }
}

function closeSidebarMenu(element) {
  if (!element) {
    return;
  }
  element.closest('.menu__item').classList.remove('open');
  element.setAttribute('aria-expanded', 'false');
}

function openSidebarMenu(element) {
  if (!element) {
    return;
  }
  element.closest('.menu__item').classList.add('open');
  element.setAttribute('aria-expanded', 'true');
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
