<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Helsinki_Link_Symbol_Handler
{
	protected string $home_url;
	protected bool $handle_local;

	public function __construct( string $home_url, bool $handle_local )
	{
		$this->home_url = $home_url;
		$this->handle_local = $handle_local;
	}

	public function add_symbols( string $content, string $custom_classes = 'inline-icon' ): string
	{
		$matches = $this->match_content( $content );

		for($i = 0; $i < count($matches[0]); $i++) {
			$link_type = $this->link_type( $matches['href'][$i] );

			if ( $link_type ) {
				$content = str_replace(
					$matches[0][$i],
					$this->build_replacement_link(
						$matches['link'][$i],
						$matches['content'][$i],
						$matches['svginner'][$i],
						$matches['endtag'][$i],
						$matches['svgafter'][$i],
						$link_type,
						$custom_classes
					),
					$content
				);
			}
	    }

		return $content;
	}

	protected function build_replacement_link( $begintag, $content, $svginner, $endtag, $svgafter, $linkType, $custom_classes ): string
	{
	    $extra_attrs = $this->link_extra_attrs( $linkType );
		$icon_callback = $this->link_icon_callback( $linkType );

		if ( empty($svgafter) && empty($svginner) && $icon_callback ) {
			$content .= call_user_func( array( $this, $icon_callback ), $custom_classes );
		}

	    $newBeginTag = str_replace('>', $extra_attrs . '>', $begintag );

	    return sprintf( '%s%s%s%s', $newBeginTag, $content, $endtag, $svgafter );
	}

	protected function link_icon_callback( string $type ): string
	{
		$icon_callback = "{$type}_icon_html";

		return method_exists( $this, $icon_callback ) ? $icon_callback : '';
	}

	protected function link_extra_attrs( string $type ): string
	{
		$extra_attrs = "{$type}_link_extra_attrs";

		return method_exists( $this, $extra_attrs )
			? call_user_func( array( $this, $extra_attrs ) )
			: '';
	}

	protected function match_content( string $content ): array
	{
		preg_match_all(
			'/(?<link>\s*href="(?<href>[^"]*)"[^>]*>)(?<content>(?:(?!<div|<\/a|<\/svg|<img).)*(?<svginner><\/svg>)?)\s*(?<endtag><\/a>)(?<svgafter><svg)?/s',
			$content,
			$matches
		);

		return $matches;
	}

	protected function link_type( string $url ): string
	{
		if ( $this->is_mailto_url( $url ) ) {
			return 'mail';
		} else if ( $this->is_tel_url( $url ) ) {
			return 'phone';
		} else {
			$is_internal = $this->is_internal_url( $url );
			$is_local = $this->is_local_url( $url );

			if ( $this->handle_local && ( $is_internal || $is_local ) ) {
				return 'internal';
			} else if ( ! $is_internal && ! $is_local ) {
				return 'external';
			}
		}

		return '';
	}

	protected function is_mailto_url( string $url ): bool
	{
		return str_starts_with( $url, 'mailto:' );
	}

	protected function is_tel_url( string $url ): bool
	{
		return str_starts_with( $url, 'tel:' );
	}

	protected function is_internal_url( string $url ): bool
	{
		return str_contains( preg_replace('/^https?:\/\//', '', $url ), $this->home_url );
	}

	protected function is_local_url( string $url ): bool
	{
		return str_starts_with( $url, '#' ) || str_starts_with( $url, '/' );
	}

	protected function mail_link_extra_attrs(): string
	{
		return 'data-protocol="mailto"';
	}

	protected function phone_link_extra_attrs(): string
	{
		return 'data-protocol="tel"';
	}

	protected function external_link_extra_attrs(): string
	{
		return 'data-is-external="true"';
	}

	protected function mail_icon_html( string $extra_classes = '' ): string
	{
		return helsinki_get_svg_icon(
			'envelope',
			$extra_classes,
			__('(Link opens default mail program)', 'helsinki-universal')
		);
	}

	protected function phone_icon_html( string $extra_classes = '' ): string
	{
		return helsinki_get_svg_icon(
			'phone',
			$extra_classes,
			__('(Link starts a phone call)', 'helsinki-universal')
		);
	}

	protected function external_icon_html( string $extra_classes = '' ): string
	{
		return helsinki_get_svg_icon(
			'link-external',
			$extra_classes,
			__('(Link leads to external service)', 'helsinki-universal'),
			'img'
		);
	}

	protected function internal_icon_html( string $extra_classes = '' ): string
	{
		return helsinki_get_svg_icon(
			'arrow-right',
			$extra_classes,
			''
		);
	}
}
