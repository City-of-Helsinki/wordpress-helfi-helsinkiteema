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
}
jsMenuInit();

function jsSubmenuToggle(event, currentToggle) {
	event.preventDefault();

	var thisMenuItem = currentToggle.parentElement,
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

function isMenuItemOpen(menuItem) {
	return menuItem.classList.contains('open');
}

function closeSubmenu(element) {
	if ( ! element ) {
		return;
	}
  element.parentElement.classList.remove('open');
  element.setAttribute('aria-expanded', "false");
}

function openSubmenu(element) {
	if ( ! element ) {
		return;
	}
  element.parentElement.classList.add('open');
  element.setAttribute('aria-expanded', "true");
}
