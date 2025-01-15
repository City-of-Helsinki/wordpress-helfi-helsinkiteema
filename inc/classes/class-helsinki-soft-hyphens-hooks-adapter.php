<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

class Helsinki_Soft_Hyphens_Hooks_Adapter
{
	private Helsinki_Soft_Hyphens_Handler $handler;

	public function __construct( Helsinki_Soft_Hyphens_Handler $handler )
	{
		$this->handler = $handler;
	}

	public function handle_content( string $content ): string
	{
		return $this->handler->handle( $content );
	}
}
