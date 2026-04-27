(({toggle,panel, skipLink}) => {
  if (toggle && panel) {
    const isOpen = () => ('true' === toggle.getAttribute('aria-expanded'));

    const openPanel = () => {
      closeOtherToggles(toggle);

      toggle.setAttribute('aria-expanded', 'true');
      panel.hidden = false;
      panel.classList.add('active');

      document.body.classList.add('mobile-menu-panel-open');
      document.addEventListener('keydown', handleEscPress);
      document.addEventListener('helsinki-theme-toggle-opened', handleToggleOpen);

      return true;
    };

    const closePanel = (focus) => {
      toggle.setAttribute('aria-expanded', 'false');
      panel.hidden = true;
      panel.classList.remove('active');

      document.body.classList.remove('mobile-menu-panel-open');
      document.removeEventListener('keydown', handleEscPress);
      document.removeEventListener('helsinki-theme-toggle-opened', handleToggleOpen);

      if (focus) {
        toggle.focus();
      }

      return true;
    };

    const handleEscPress = event => (('Escape' === event.key && isOpen()) && closePanel(true));
    const handleToggleOpen = event => (isOpen() && closePanel(false));

    toggle.addEventListener('click', event => (isOpen() ? closePanel() : openPanel(true)));

    if (skipLink) {
      skipLink.addEventListener('click', event => (isOpen() && closePanel(false)));
    }

    // container.addEventListener('keydown', event => {
    //   if ('Tab' === event.key) {
    //     let focusElements = _focusElements();
    //
    //     if (event.shiftKey && document.activeElement === focusElements.first()) {
    //       focusElements.last();
    //     } else if (document.activeElement === focusElements.last()) {
    //       focusElements.first();
    //     }
    //   }
    // });

    closePanel();
  }
})({
  toggle: document.getElementById('mobile-panel-toggle'),
  panel: document.getElementById('mobile-panel'),
  skipLink: document.getElementById('skip-to-content'),
});
