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
