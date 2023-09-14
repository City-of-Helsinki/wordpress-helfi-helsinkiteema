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
