<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Helsinki_Soft_Hyphens_Handler
{
	public function handle( string $content ): string
	{
		return $this->aria_hide_soft_hyphens( $content );
	}

	protected function aria_hide_soft_hyphens( string $content ): string
	{
		return preg_replace(
			$this->soft_hyphens_pattern(),
			$this->aria_hidden_soft_hyphen(),
			$content
			) ?: $content;
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
