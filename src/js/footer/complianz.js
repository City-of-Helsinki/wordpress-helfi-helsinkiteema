(() => {
  window.addEventListener('load', _adjustFooterBottomMargin);
  document.addEventListener('cmplz_banner_status', _handleCookieBannerStatus);

  const _bodyClass = 'helsinki-cookiebanner-visible';
  const _footerResizer = _debounce(_adjustFooterBottomMargin, 500);
  const _footer = document.querySelector('.layout-wrap #footer');
  const _banner = document.querySelector('#cmplz-cookiebanner-container .cmplz-cookiebanner');

  function _handleCookieBannerStatus(event) {
    _toggleCookieBannerBodyClass(_isCookieBannerVisible(event));
  }

  function _isCookieBannerVisible(event) {
    return event.detail && 'show' === event.detail;
  }

  function _toggleCookieBannerBodyClass(visible) {
    if (visible) {
      document.body.classList.add(_bodyClass);
      window.addEventListener('resize', _footerResizer);
      _adjustFooterBottomMargin();
    } else {
      document.body.classList.remove(_bodyClass);
      window.removeEventListener('resize', _footerResizer);
      _adjustFooterBottomMargin();
    }
  }

  function _adjustFooterBottomMargin() {
    if (_footer) {
      _footer.style.marginBottom = _cookieBannerHeight();
    }
  }

  function _cookieBannerHeight() {
    return (_banner) ? _banner.offsetHeight + 'px' : 0;
  }

  function _debounce(func, time = 100){
    var timer;
    return (event) => {
      if(timer) clearTimeout(timer);
      timer = setTimeout(func, time, event);
    };
  }
})();
