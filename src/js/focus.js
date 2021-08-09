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
