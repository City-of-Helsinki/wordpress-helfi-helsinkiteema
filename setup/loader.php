<?php

/**
 * Include theme files
 */
function helsinki_load_files() {
	helsinki_include_files(
		helsinki_files()
	);
}

function helsinki_files()
{
	$files = [
	  'customizer' => [
			'config' => [
				'blog',
				'choices',
				'footer',
				'front-page',
				'general',
				'header',
				'settings',
				'sidebar',
			],
			'config',
			'functions',
			'init',
			'css',
		],
		'block-editor' => [
			'config' => [
				'meta',
			],
			'functions',
			'init',
		],
	  'inc' => [
			'filters',
			'walkers',
			'taxonomy-thumbnails'
	  ],
		'setup' => [
			'config' => [
				'colors',
			],
			'theme',
			'site',
			'templates',
			'assets',
		],
	  'functions'  => [
		    'content' => [
				'call-to-action',
				'table-of-contents',
				'related',
			],
		    'decoration' => [
				'koros',
				'svg',
			],
		    'layout' => [
				'front-page',
				'header',
				'footer',
				'sidebar',
			],
		    'modules' => [
				'load-more',
				'menu',
				'search',
				'social',
				'widgets',
			],
			'classes',
			'comments',
			'content',
			'entry',
			'misc',
		],
		'integrations' => [],
	];

	if ( class_exists('Polylang') ) {
		$files['integrations'][] = 'polylang';
		add_filter('helsinki_polylang_active', '__return_true');
	}

	if ( class_exists('COMPLIANZ') ) {
		$files['integrations'][] = 'complianz';
		add_filter('helsinki_complianz_active', '__return_true');
	}

	return $files;
}

function helsinki_include_files(array $dir_files, string $subdir = '')
{
    $path = get_template_directory();
    foreach ($dir_files as $dir => $file_or_files) {
        if ( is_array($file_or_files) ) {
            foreach ($file_or_files as $index => $file_or_subdir) {
                if ( is_array($file_or_subdir) ) {
					$dir = $subdir ? $subdir : $dir;
                    helsinki_include_files(
						$file_or_subdir,
						$dir . DIRECTORY_SEPARATOR . $index
					);
                } else {
                    helsinki_include_file($path, $dir, $file_or_subdir);
                }
            }
        } else {
			helsinki_include_file(
				$path,
				$subdir ? $subdir : $dir,
				$file_or_files
			);
        }
    }
}

function helsinki_include_file(string $path, string $dir, string $filename)
{
    $file = helsinki_build_file_path($path, $dir, $filename . '.php');
    if (file_exists($file)) {
        include $file;
    }
}

function helsinki_build_file_path(...$segments)
{
    return implode(DIRECTORY_SEPARATOR, $segments);
}
