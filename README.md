# Helsinkiteema
General purpose WordPress theme for Helsinki. Can be used either as a main or a parent theme.

The theme aims to follow the [Helsinki Design System](https://hds.hel.fi/) guidelines and the general Helsinki style, but some differences are possible and should be expected.

Originally designed to be installed with [Composer](https://getcomposer.org/) along [WP Starter](https://wecodemore.github.io/wpstarter/).

## Dependencies

### Required
- [Helsinki WordPress plugin](https://github.com/City-of-Helsinki/wordpress-helfi-hds-wp)

### Recommended
- [Polylang](https://wordpress.org/plugins/polylang/)

### Optional
- [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) (breadcrumbs support)

## Theme setup
Theme general bootstrapping and loading order can be seen in `functions.php`. Further setup actions and filters are defined in files found at `/setup`.  Action and filter callbacks, and template functions are defined in files located in `/functions`.

Template files, theme partials, and callbacks provide various actions and hooks for modifying and extending the theme behaviour, style and layout.

## Customizer
The theme provides various style and layout related settings in the Customizer.

Customizer settings config files are stored at `/customizer/config` and setup is handled in `/customizer/init.php`.  Config files provide filters for modifying and extending the setup.

## Development

### Assets
(S)CSS and JS source files are stored in `/src`. Asset complitation is done with [Gulp](https://gulpjs.com/) and the processed files can be found in `/assets`.

Install dependencies with `npm install`. Build assets with `gulp scripts` and `gulp styles` or watch changes with `gulp watch`.

## Collaboration
Raise [issues](https://github.com/City-of-Helsinki/wordpress-helfi-hds-wp/issues) for found bugs or development ideas. Feel free to send [pull requests](https://github.com/City-of-Helsinki/wordpress-helfi-hds-wp/pulls) for bugfixes and new or improved features.
