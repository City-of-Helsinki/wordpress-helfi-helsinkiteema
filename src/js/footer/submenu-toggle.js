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
