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
