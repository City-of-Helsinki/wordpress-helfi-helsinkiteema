function helsinkiNotifications() {

  function _init( notifications ) {
    if ( ! notifications ) {
      return;
    }

    var _notices = notifications.querySelectorAll('.hds-notification');
    for (var i = 0; i < _notices.length; i++) {
      var _closeButton = _notices[i].querySelector('.hds-notification__close-button'),
          _noticeId = _notificationId(_notices[i]);

      if ( _isClosed(_noticeId) ) {
        _notices[i].remove();
      } else {
        _closeButton.addEventListener('click', _closeNotification);
      }
    }
  }

  function _notificationId( element ) {
    return 'helsinki_notification_' + element.id;
  }

  function _isClosed( id ) {
    return 'closed' === localStorage.getItem(id);
  }

  function _markClosed( id ) {
    localStorage.setItem( id, 'closed' );
  }

  function _closeNotification(event) {
    event.preventDefault();
    var _notice = event.currentTarget.closest('.hds-notification');

    _markClosed(
      _notificationId(_notice)
    );

    focusToPrevious(_notice);

    _notice.remove();
  }

	return {
		init: _init,
	};
}

const HelsinkiNotifications = helsinkiNotifications();
HelsinkiNotifications.init(
	document.querySelector( '#main .notifications' )
);
