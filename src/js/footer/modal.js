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
