function helsinkiGalleryLightbox( config ) {

	'use strict';

	const {strings} = config;

	var currentActive = null;

	/**
	  * Init
	  */
	function initLightboxes( galleries ) {
		if ( galleries.length === 0 ) {
			return;
		}

		for ( let g = 0; g < galleries.length; g++ ) {
			initLightbox( galleries[g] );
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
			event.currentTarget.firstElementChild
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
	function openLightBox( lightbox, clickedImage ) {
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
	}

	function closeLightbox( lightbox ) {
		toggleHidden( lightbox, true );
		toggleActive( lightbox, false );
		toggleAriaExpanded( lightboxCloseButton( lightbox ), false );
		switchActiveImage( lightboxActiveImage( lightbox ), null );
		currentActive = null;
	}

	function switchActiveImage( currentImage, newImage ) {
		if ( currentImage ) {
			toggleActive( currentImage, false );
			toggleHidden( currentImage, true );
		}

		if ( newImage ) {
			toggleActive( newImage, true );
			toggleHidden( newImage, false );
		}
	}

	/**
	  * Elements
	  */
	function galleryFigures( gallery ) {
		return gallery.querySelectorAll( '.blocks-gallery-item figure' );
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
		return galleryItem.closest( '.wp-block-gallery' );
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
		content.append( createNavigation() );
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
		let button = createContainer( 'button', ['lightbox__close', 'button-reset'] );

		// Attributes
		button.id = 'close-' + lightboxId;
		button.type = 'button';
		button.innerHTML = strings.close;

		button.setAttribute( 'aria-controls', lightboxId );
		toggleAriaExpanded( button, false );

		// Events
		button.addEventListener('click', clickCloseButton);

		// Output
		return button;
	}

	function createNavigation() {
		let container = createContainer( 'div', ['lightbox__navigation'] );

		container.append( createNavigationItem( 'prev', strings.prev, clickPrevious ) );
		container.append( createNavigationItem( 'next', strings.next, clickNext ) );

		return container;
	}

	function createNavigationItem( type, text, onClick ) {
		// Element
		let button = createContainer( 'button', ['lightbox__' + type, 'hds-button', 'hds-button--small'] );

		// Attributes
		button.type = 'button';
		button.innerHTML = text;

		// Events
		button.addEventListener('click', onClick);

		// Output
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
		return gallery.querySelector( '.blocks-gallery-item > figure > a' );
	}

	function toggleHidden( element, hidden ) {
		if ( hidden ) {
			element.hidden = true;
		} else {
			element.hidden = false;
		}
	}

	/**
	  * Module
	  */
	return {
		init: initLightboxes,
	};
}

const HelsinkiGalleryLightbox = helsinkiGalleryLightbox({
	strings: {
		close: "Close",
		next: "Next",
		prev: "Previous",
		lightboxTitle: "Gallery images",
	}
});

HelsinkiGalleryLightbox.init(
	document.querySelectorAll( '.wp-block-gallery' )
);
