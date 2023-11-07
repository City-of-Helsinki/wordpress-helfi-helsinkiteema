<div class="rns-container">
    <div class="hds-container">
        <div class="rns"></div>
    </div>

    <script type="text/javascript">
        (function() {

            var reactionPlugin = null;

            function helsinkiInitRns(element, canonicalUrl) {
                reactionPlugin = element;

                var reactions = reactionPlugin.getElementsByClassName('rns-reaction-button');

                for (var i = 0; i < reactions.length; i++) {

                    var reaction = reactions[i];
                    reaction.innerHTML = reaction.innerHTML + facesArray[i];

                    reaction.addEventListener('click', function(e) {
                        helsinkiReactionRns();
                    });
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

                    var inputWrapper = document.createElement('span');
                    inputWrapper.classList.add('rns-textarea-wrapper', 'hds-text-input__input-wrapper');
                    inputWrapper.appendChild(label);
                    inputWrapper.appendChild(input);
                    inputGroup.appendChild(inputWrapper);

                    var submit = reactionPlugin.getElementsByClassName('rns-form-submit')[0];
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

            var facesArray = [helsinkiTheme.icons.faceSmile, helsinkiTheme.icons.faceNeutral, helsinkiTheme.icons.faceSad];

            window.rnsData = {
                apiKey: '<?php echo $args['apiKey']; ?>',
                title: '<?php echo $args['title']; ?>',
                postId: '<?php echo $args['category'] . '-' . $args['postId']; ?>',
                categories: ['wordpress', '<?php echo $args['category']; ?>'],
                disableFonts: <?php echo $args['disableFonts'] ? 'true' : 'false'; ?>,
                initCallback: (element, canonicalUrl) => helsinkiInitRns(element, canonicalUrl),
            };

            var s = document.createElement('script');
            s.src = 'https://cdn.reactandshare.com/plugin/rns.js';

            document.body.appendChild(s);

        }());

    </script>
</div>