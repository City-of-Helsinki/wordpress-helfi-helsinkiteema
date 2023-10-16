function setFocus(element) {
  try {
    element.focus();
  }
    catch (error) {
  }
  return (document.activeElement === element);
}

function firstFocusableChild(element) {
  var firstMenuItem = element.querySelector('.menu li a');
  if ( firstMenuItem ) {
    return firstMenuItem;
  }
  var firstInput = element.querySelector('input');
  if ( firstInput ) {
    return firstInput;
  }
  return element.firstElementChild;
}

function lastFocusableChild(element) {
  return element.lastElementChild;
}

function focusFirstChild(element) {
  for (var i = 0; i < element.childNodes.length; i++) {
    if ( setFocus(element.childNodes[i]) || focusFirstChild(element.childNodes[i]) ) {
      return true;
    }
  }
  return null;
}

function focusLastChild(element) {
  for (var i = element.childNodes.length - 1; i >= 0; i--) {
    if ( setFocus(element.childNodes[i]) || focusLastChild(element.childNodes[i]) ) {
      return true;
    }
  }
  return null;
}

function focusToPrevious( element ) {
  var _previousFocusable;
  if ( element.previousElementSibling !== null ) { 
    _previousFocusable = element.previousElementSibling;
  }
  else {
    var _parent = element.parentElement;
    while ( _parent ) {
      if ( _parent.previousElementSibling !== null ) {
        _previousFocusable = _parent.previousElementSibling;
        break;
      }
      _parent = _parent.parentElement;
    }
  }

  while ( _previousFocusable ) {
    if ( focusLastChild(_previousFocusable) === true ) {
      break;
    }
    if ( _previousFocusable.previousElementSibling !== null ) {
      _previousFocusable = _previousFocusable.previousElementSibling;
    }
    else {
      var _parent = _previousFocusable.parentElement;
      while ( _parent ) {
        if ( _parent.previousElementSibling !== null ) {
          _previousFocusable = _parent.previousElementSibling;
          break;
        }
        _parent = _parent.parentElement;
      }
    }
  }
}
