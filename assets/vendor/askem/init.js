(({apiKey,title,postId,category,disableFonts}, container) => {
  var reactionPlugin = null;

  const facesArray = [
    helsinkiTheme.icons.faceSmile,
    helsinkiTheme.icons.faceNeutral,
    helsinkiTheme.icons.faceSad,
  ];

  function helsinkiInitRns(element, canonicalUrl) {
    reactionPlugin = element;

    var reactions = reactionPlugin.getElementsByClassName('rns-reaction-button');

    for (var i = 0; i < reactions.length; i++) {
      var reaction = reactions[i];
      reaction.classList.add('hds-button', 'hds-button--secondary');

      reaction.innerHTML = reaction.innerHTML + facesArray[i];

      reaction.addEventListener('click', (e) => helsinkiReactionRns());
    }
  }

  //proper way would be to use reactionCallback, but the input area is not instantiated before it runs!
  function helsinkiReactionRns() {
    var inputGroup = reactionPlugin.getElementsByClassName('rns-input')[0];
    var shareGroup = reactionPlugin.getElementsByClassName('rns-shares')[0];

    if (inputGroup) {
      if (inputGroup.classList.contains('rns-helsinki-parsed')) {
        return;
      }

      var label = inputGroup.getElementsByClassName('rns-input-label')[0];
      var input = inputGroup.getElementsByClassName('rns-input-field')[0];
      input.classList.add('hds-text-input__input');

      var hdsTextInput = document.createElement('div');
      hdsTextInput.classList.add('hds-text-input');

      var inputWrapper = document.createElement('div');
      inputWrapper.classList.add('rns-textarea-wrapper', 'hds-text-input__input-wrapper');
      inputWrapper.appendChild(label);
      inputWrapper.appendChild(input);
      hdsTextInput.appendChild(inputWrapper);
      inputGroup.appendChild(hdsTextInput);

      var submit = reactionPlugin.getElementsByClassName('rns-form-submit')[0];
      submit.classList.add('hds-button');

      submit.innerHTML = submit.innerHTML + helsinkiTheme.icons.arrowRight;

      inputGroup.classList.add('rns-helsinki-parsed');
    }

    if (shareGroup) {
      if (shareGroup.classList.contains('rns-helsinki-parsed')) {
        return;
      }

      var icons = shareGroup.getElementsByClassName('rns-icon');
      var whatsapp = shareGroup.getElementsByClassName('rns-share-whatsapp')[0].firstChild;
      var facebook = shareGroup.getElementsByClassName('rns-share-facebook')[0].firstChild;
      var twitter = shareGroup.getElementsByClassName('rns-share-twitter')[0].firstChild;
      var email = shareGroup.getElementsByClassName('rns-share-email')[0].firstChild;

      //delete each icon element
      for (var i = icons.length - 1; i >= 0; i--) {
        icons[i].remove();
      }

      if (whatsapp) {
        whatsapp.innerHTML = helsinkiTheme.icons.whatsapp + whatsapp.innerHTML;
      }

      if (facebook) {
        facebook.innerHTML = helsinkiTheme.icons.facebook + facebook.innerHTML;
      }

      if (twitter) {
        twitter.innerHTML = helsinkiTheme.icons.twitter + twitter.innerHTML;
      }

      if (email) {
        email.innerHTML = helsinkiTheme.icons.email + email.innerHTML;
      }

      shareGroup.classList.add('rns-helsinki-parsed');
    }
  }

  function dispatchFeedbackEvent(name, details) {
    window.dispatchEvent(
      new CustomEvent('helsinki-feedback-buttons-' + name, {detail: details})
    );
  }

  function HelsinkiFeedbackButtons({container, script, key, data}) {
    var _loaded = false;
    const _loadConditions = [];

    const _shouldLoad = () => {
      for (let i = 0; i < _loadConditions.length; i++) {
        if (! _loadConditions[i]({container, script})) {
          return false;
        }
      }

      return true;
    };

    const _addLoadCondition = (condition) => {
      if (typeof condition === 'function') {
        _loadConditions.push(condition);
      }
    }

    const _load = () => {
      if (! _loaded) {
        window[key] = data;

        document.body.appendChild((() => {
          var s = document.createElement('script');
          s.src = script;

          return s;
        })());

        _loaded = true;

        dispatchFeedbackEvent('loaded', {
          container,
          script,
        });
      }
    };

    return {
      init: () => {
        dispatchFeedbackEvent('initializing', {
          addLoadCondition: _addLoadCondition,
        });

        if (_shouldLoad()) {
          _load();
        }

        dispatchFeedbackEvent('ready', {
          container,
          script,
          load: _load,
        });
      },
    };
  };

  if (container) {
    window.addEventListener('load', (event) => {
      HelsinkiFeedbackButtons({
        container,
        script: 'https://cdn.reactandshare.com/plugin/rns.js',
        key: 'rnsData',
        data: {
          apiKey,
          title,
          postId: `${category} - ${postId}`,
          categories: ['wordpress', category],
          disableFonts: !! disableFonts,
          initCallback: (element, canonicalUrl) => helsinkiInitRns(element, canonicalUrl),
        },
      }).init();
    });
  }
})(HelsinkiThemeAskem || {}, document.querySelector('.rns-container'));
