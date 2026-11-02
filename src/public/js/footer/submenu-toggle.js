function createSubmenuController(item) {
  const toggleButton = item.querySelector(
    ':scope > .link-wrap > .js-submenu-toggle'
  );

  const submenu = item.querySelector(
    ':scope > .menu--sub'
  );

  if (!toggleButton || !submenu) {
    return null;
  }

  return {
    item,
    toggleButton,
    submenu,

    isDepthZero: item.classList.contains('menu__depth-0'),

    isOpen() {
      return item.classList.contains('open');
    },

    isHovered() {
      return item.classList.contains('menu__item--hover');
    },

    open() {
      item.classList.add('open');
      toggleButton.setAttribute('aria-expanded', 'true');
    },

    close() {
      item.classList.remove('open');
      toggleButton.setAttribute('aria-expanded', 'false');
    },

    hoverOpen() {
      item.classList.add('menu__item--hover');
    },

    hoverClose() {
      item.classList.remove('menu__item--hover');
    },
  };
}


function initMenu(menu) {
  if (!menu) {
    return;
  }

  const controllers = Array.from(
    menu.querySelectorAll('.menu__item--parent.has-toggle')
  )
    .map(createSubmenuController)
    .filter(Boolean);

  // Precompute descendant controllers here.
  controllers.forEach(controller => {
    controller.descendants = controllers.filter(candidate =>
      candidate !== controller &&
      controller.item.contains(candidate.item)
    );
  });

  const controllerByItem = new Map(
    controllers.map(controller => [
      controller.item,
      controller,
    ])
  );

  function getController(item) {
    return controllerByItem.get(item) || null;
  }

  function getClosestController(element) {
    if (!(element instanceof Element)) {
      return null;
    }

    const item = element.closest(
      '.menu__item--parent.has-toggle'
    );

    if (!item || !menu.contains(item)) {
      return null;
    }

    return getController(item);
  }

  /*
   * Fully reset a branch.
   *
   * Used when another depth-0 branch is opened,
   * or when Escape explicitly closes a branch.
   */
  function resetController(controller) {
    controller.descendants.forEach(descendant => {
      descendant.close();
      descendant.hoverClose();
    });

    controller.close();
    controller.hoverClose();
  }

  /*
   * Close explicit click-open state only.
   *
   * Hover state is deliberately left alone.
   */
  function closeController(controller) {
    controller.descendants.forEach(descendant => descendant.close());
    controller.close();
  }

  function closeOtherDepthZeroControllers(currentController) {
    controllers.forEach(controller => {
      if (
        controller !== currentController &&
        controller.isDepthZero &&
        (controller.isOpen() || controller.isHovered())
      ) {
        resetController(controller);
      }
    });
  }

  function openController(controller) {
    if (controller.isDepthZero) {
      closeOtherDepthZeroControllers(controller);
    }

    controller.open();
  }

  function hoverOpenController(controller) {
    if (controller.isDepthZero) {
      closeOtherDepthZeroControllers(controller);
    }

    controller.hoverOpen();
  }


  /*
   * Click
   *
   * .open represents explicit click/toggle state.
   */
  menu.addEventListener('click', event => {
    if (!(event.target instanceof Element)) {
      return;
    }

    const toggleButton = event.target.closest(
      '.js-submenu-toggle'
    );

    if (!toggleButton || !menu.contains(toggleButton)) {
      return;
    }

    const controller = getClosestController(toggleButton);

    if (!controller) {
      return;
    }

    event.preventDefault();

    if (controller.isOpen()) {
      closeController(controller);
    } else {
      openController(controller);
    }
  });


  /*
   * Hover
   *
   * These listeners are attached directly because mouseenter /
   * mouseleave do not bubble, which makes nested menu behaviour
   * much easier to reason about.
   */
  controllers.forEach(controller => {
    controller.item.addEventListener('mouseenter', () => {
      hoverOpenController(controller);
    });

    controller.item.addEventListener('mouseleave', () => {
      controller.hoverClose();
    });
  });


  /*
   * Focus leaving a controller's active toggle/submenu scope
   * fully resets that submenu branch.
   *
   * Focus moving within the same submenu keeps it open.
   */
   menu.addEventListener('focusout', event => {
     const nextElement = event.relatedTarget;

     controllers.forEach(controller => {
       const focusWasOnToggle =
         event.target === controller.toggleButton;

       const focusWasInSubmenu =
         controller.submenu.contains(event.target);

       if (!focusWasOnToggle && !focusWasInSubmenu) {
         return;
       }

       const focusMovesIntoSubmenu =
         nextElement instanceof Node &&
         controller.submenu.contains(nextElement);

       /*
        * Toggle -> submenu
        *
        * Normal forward Tab into the opened submenu.
        * Keep it open.
        */
       if (focusWasOnToggle && focusMovesIntoSubmenu) {
         return;
       }

       /*
        * Submenu -> somewhere else inside the same submenu
        *
        * Keep it open.
        */
       if (focusWasInSubmenu && focusMovesIntoSubmenu) {
         return;
       }

       /*
        * Everything else means focus left this controller's
        * active submenu scope.
        *
        * Examples:
        *
        * submenu -> own toggle
        * submenu -> sibling item
        * submenu -> parent level
        * toggle  -> preceding link/item
        * toggle  -> outside menu
        */
       resetController(controller);
     });
   });


  /*
   * Escape closes the closest currently active submenu.
   *
   * Both .open and .menu__item--hover are removed so Escape
   * always visibly closes the submenu.
   */
  menu.addEventListener('keydown', event => {
    if (event.key !== 'Escape') {
      return;
    }

    const activeElement = document.activeElement;

    if (!(activeElement instanceof Element)) {
      return;
    }

    const item = activeElement.closest(
      '.menu__item--parent.has-toggle.open, ' +
      '.menu__item--parent.has-toggle.menu__item--hover'
    );

    if (!item || !menu.contains(item)) {
      return;
    }

    const controller = getController(item);

    if (!controller) {
      return;
    }

    event.preventDefault();
    event.stopPropagation();

    resetController(controller);
    controller.toggleButton.focus();
  });
}

[
  document.getElementById('main-menu'),
  document.getElementById('mobile-main-menu'),
].forEach(initMenu);
