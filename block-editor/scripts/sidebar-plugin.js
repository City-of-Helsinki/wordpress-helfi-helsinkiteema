( function( wp ) {
	var registerPlugin = wp.plugins.registerPlugin;
	var PluginSidebar = wp.editPost.PluginSidebar;
	var element = wp.element.createElement;
	var compose = wp.compose.compose;
	var { withSelect, withDispatch, subscribe, select } = wp.data;
	var { Panel, PanelBody, PanelRow, TextControl, ToggleControl, SelectControl } = wp.components;

	const textField = function( props ) {
		return element( TextControl, {
				label: props.fieldLabel,
				type: props.fieldType,
				value: props.metaFieldValue,
				onChange: function( content ) {
						props.setMetaFieldValue( content );
				},
		});
	}

	const toggleField = function( props ) {
		return element( ToggleControl, {
			label: props.fieldLabel,
			checked: props.metaFieldValue ? true : false,
			onChange: function(toggled) {
				props.setMetaFieldValue( toggled ? true : false );
			}
		});
	}

  var displayHeroStyles = hasHeroStyles();
  subscribe(function(){
    displayHeroStyles = hasHeroStyles();
  });

	const heroDisplayToggle = function( props ) {
		return element( ToggleControl, {
			label: props.fieldLabel,
			checked: props.metaFieldValue ? true : false,
			onChange: function(toggled) {
				props.setMetaFieldValue( toggled ? true : false );
			},
      disabled: displayHeroStyles === true,
		});
	}

  const heroStyleSelect = function( props ) {

    const selectOptions = createSelectOptions(
      HelsinkiUniversalSidebar.heroStyleOptions
    );

    return element( SelectControl, {
			label: props.fieldLabel,
			value: props.metaFieldValue,
      options: selectOptions.filter(function(option){
        return displayHeroStyles;
      }),
			onChange: function(selected) {
				props.setMetaFieldValue( selected );
			}
		});
  }

  function hasHeroStyles() {
    var template = select( 'core/editor' ).getEditedPostAttribute( 'template' );
    return HelsinkiUniversalSidebar.isFrontPage || 'template/landing-page.php' === template;
  }

  function createSelectOptions( data ) {
    var optionObjects = [];

    for ( var key in data ) {
      optionObjects.push({
        label: data[key],
        value: key,
      });
    }

    return optionObjects;
  }

	function metaCompose( elementCallback ) {
		return compose(
        withDispatch( function( dataDispatch, props ) {
            return {
                setMetaFieldValue: function( value ) {
                    dataDispatch( 'core/editor' ).editPost(
                        { meta: { [ props.fieldName ]: value } }
                    );
                }
            }
        } ),
        withSelect( function( dataSelect, props ) {
            return {
                metaFieldValue: dataSelect( 'core/editor' )
                    .getEditedPostAttribute( 'meta' )
                    [ props.fieldName ],
            }
        } )
    )( elementCallback );
	}

	const TextMetaField = metaCompose( textField ),
        ToggleMetaField = metaCompose( toggleField ),
        HeroDisplayMetaField = metaCompose( heroDisplayToggle ),
        HeroStyleMetaField = metaCompose( heroStyleSelect );

	const logoIcon = element('svg', { height: 24, viewBox: '0 0 78 36', }, element( 'path', {
			d: 'M75.753 2.251v20.7c0 3.95-3.275 7.178-7.31 7.178h-22.26c-2.674 0-5.205.96-7.183 2.739a10.749 10.749 0 00-7.183-2.74H9.509c-4.003 0-7.247-3.21-7.247-7.177V2.25h73.491zM40.187 34.835a8.47 8.47 0 016.012-2.471h22.245c5.268 0 9.556-4.219 9.556-9.413V0H0v22.935c0 5.194 4.256 9.413 9.509 9.413h22.308c2.263 0 4.398.882 6.012 2.471L39.016 36l1.17-1.165z M67.522 11.676c0 .681-.556 1.177-1.255 1.177-.7 0-1.255-.496-1.255-1.177 0-.682.556-1.178 1.255-1.178.7-.03 1.255.465 1.255 1.178zm-2.352 9.622h2.178v-7.546H65.17v7.546zm-3.909-4.556l2.845 4.556h-2.368l-1.907-3.022-1.033 1.271v1.75h-2.161V10.453h2.16v5.004c0 .93-.11 1.86-.11 1.86h.047s.509-.821.938-1.41l1.653-2.154h2.542l-2.606 2.99zm-6.817-.278c0-1.875-.938-2.898-2.432-2.898-1.271 0-1.939.728-2.32 1.426h-.048l.112-1.24h-2.162v7.546h2.162V16.82c0-.868.524-1.472 1.335-1.472.81 0 1.16.527 1.16 1.534v4.416h2.177l.016-4.834zm-8.931-4.788c0 .681-.557 1.177-1.256 1.177-.7 0-1.255-.496-1.255-1.177 0-.682.556-1.178 1.255-1.178.715-.03 1.256.465 1.256 1.178zm-2.352 9.622h2.177v-7.546H43.16v7.546zm-3.75-2.107c0-.605-.859-.729-1.86-1.008-1.16-.294-2.622-.867-2.622-2.308 0-1.426 1.398-2.324 3.051-2.324 1.541 0 2.956.712 3.544 1.72l-1.86 1.022c-.19-.666-.762-1.193-1.62-1.193-.557 0-1.018.232-1.018.682 0 .573 1.018.635 2.162.991 1.208.372 2.32.915 2.32 2.294 0 1.518-1.446 2.417-3.115 2.417-1.811 0-3.242-.744-3.877-1.952l1.89-1.039c.24.822.922 1.441 1.955 1.441.62 0 1.05-.248 1.05-.743zm-6.882-8.677h-2.177v8.692c0 .775.175 1.348.509 1.705.35.356.89.526 1.636.526.255 0 .525-.03.78-.077.27-.062.476-.14.65-.233l.191-1.425a2.07 2.07 0 01-.46.124c-.128.03-.287.03-.461.03-.286 0-.414-.077-.509-.216-.111-.14-.159-.387-.159-.744v-8.382zm-7.246 4.57c-.795 0-1.446.558-1.621 1.581h3.05c.017-.899-.587-1.58-1.43-1.58zm3.353 3.007H23.63c.095 1.224.794 1.828 1.7 1.828.81 0 1.367-.527 1.494-1.24l1.828 1.007c-.54.961-1.7 1.798-3.322 1.798-2.16 0-3.75-1.472-3.75-3.951 0-2.464 1.62-3.951 3.703-3.951 2.081 0 3.464 1.44 3.464 3.486-.016.604-.111 1.023-.111 1.023zm-11.077 3.207h2.257V10.916h-2.257v4.107h-4.243v-4.091H11.06v10.366h2.256v-4.292h4.243v4.292z'
		} ) );

  /**
    * Meta config
    */
  const metaConfig = [
    {
      condition: true,
      title: 'Hero - Layout',
      rows: [
        {
          condition: true,
          type: HeroStyleMetaField,
          config: {
            fieldLabel: 'Style',
            fieldName: 'hero_layout_style',
          }
        },
        {
          condition: true,
          type: HeroDisplayMetaField,
          config: { fieldLabel: 'Disable Hero', fieldName: 'disable_page_hero' }
        },
      ]
    },
    {
      condition: true,
      title: 'Hero - Buttons',
      rows: [
        {
          condition: true,
          type: TextMetaField,
          config: { fieldLabel: 'Button 1 url', fieldType: 'url', fieldName: 'hero_cta_url' }
        },
        {
          condition: true,
          type: TextMetaField,
          config: { fieldLabel: 'Button 1 text', fieldType: 'url', fieldName: 'hero_cta_text' }
        },
        {
          condition: true,
          type: TextMetaField,
          config: { fieldLabel: 'Button 2 url', fieldType: 'url', fieldName: 'hero_cta_2_url' }
        },
        {
          condition: true,
          type: TextMetaField,
          config: { fieldLabel: 'Button 2 text', fieldType: 'url', fieldName: 'hero_cta_2_text' }
        },
      ],
    },
    {
      condition: ! HelsinkiUniversalSidebar.isFrontPage,
      title: 'Featured Image',
      rows: [
        {
          condition: true,
          type: ToggleMetaField,
          config: { fieldLabel: 'Hide', fieldName: 'hide_featured_image' }
        },
      ]
    },
    {
      condition: ! HelsinkiUniversalSidebar.isFrontPage,
      title: 'Table of Contents',
      rows: [
        {
          condition: true,
          type: ToggleMetaField,
          config: { fieldLabel: 'Enabled', fieldName: 'table_of_contents_enabled' }
        },
      ]
    }
  ];

  function createMetaControls( config ) {
    var elements = [];

    for (var c = 0; c < config.length; c++) {
      if ( ! config[c].condition ) {
        continue;
      }

      var rows = [];
      for (var r = 0; r < config[c].rows.length; r++) {
        if ( ! config[c].rows[r].condition ) {
          continue;
        }

        rows.push(
          element( config[c].rows[r].type, config[c].rows[r].config )
        );
      }

      if ( rows.length > 0 ) {
        elements.push(
          element( PanelBody, { title: config[c].title, initialOpen: false }, rows )
        );
      }
    }

    return elements;
  }

  registerPlugin( 'helsinki-sidebar-plugin', {
      render: function() {
          return element( PluginSidebar,
              {name: 'helsinki-sidebar-plugin', icon: logoIcon, title: 'Helsinki'},
							createMetaControls( metaConfig )
          );
      }
  } );
} )( window.wp );
