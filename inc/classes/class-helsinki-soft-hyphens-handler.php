<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Helsinki_Soft_Hyphens_Handler
{
	public function aria_hide_soft_hyphens( string $content ): string
	{
		return preg_replace(
			$this->soft_hyphens_pattern(),
			$this->aria_hidden_soft_hyphen(),
			$content
			) ?: $content;
	}

	public function remove_soft_hyphens( string $content ): string
	{
		return preg_replace( $this->soft_hyphens_pattern(), '', $content ) ?: $content;
	}

	protected function soft_hyphens_pattern(): string
	{
		return '/&shy;/';
	}

	protected function aria_hidden_soft_hyphen(): string
	{
		return '<span aria-hidden="true">&shy;</span>';
	}
}
