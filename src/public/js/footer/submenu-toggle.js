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

  const isDepthZero = item.classList.contains('menu__depth-0');

  function isOpen() {
    return item.classList.contains('open');
  }

  function isHovered() {
    return item.classList.contains('menu__item--hover');
  }

  function open() {
    item.classList.add('open');
    toggleButton.setAttribute('aria-expanded', 'true');
  }

  function close() {
    item.classList.remove('open');
    toggleButton.setAttribute('aria-expanded', 'false');
  }

  function hoverOpen() {
    item.classList.add('menu__item--hover');
  }

  function hoverClose() {
    item.classList.remove('menu__item--hover');
  }

  return {
    item,
    submenu,
    toggleButton,
    isDepthZero,
    isOpen,
    isHovered,
    open,
    close,
    hoverOpen,
    hoverClose,
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

  function getDescendantControllers(controller) {
    return controllers.filter(candidate =>
      candidate !== controller &&
      controller.item.contains(candidate.item)
    );
  }

  /*
   * Fully reset a branch.
   *
   * Used when another depth-0 branch is opened,
   * or when Escape explicitly closes a branch.
   */
  function resetController(controller) {
    getDescendantControllers(controller).forEach(descendant => {
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
    getDescendantControllers(controller).forEach(descendant => {
      descendant.close();
    });

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
   * Focus leaving an item closes its explicit .open state.
   *
   * Moving focus between descendants of the same menu item
   * does nothing.
   */
  menu.addEventListener('focusout', event => {
    const controller = getClosestController(event.target);

    if (!controller || !controller.isOpen()) {
      return;
    }

    const nextElement = event.relatedTarget;

    if (
      nextElement instanceof Node &&
      controller.item.contains(nextElement)
    ) {
      return;
    }

    closeController(controller);
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
