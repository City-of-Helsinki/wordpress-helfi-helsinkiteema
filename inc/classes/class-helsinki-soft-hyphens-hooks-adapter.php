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

	public function aria_hide_soft_hyphens( string $content ): string
	{
		return $this->handler->aria_hide_soft_hyphens( $content );
	}

	public function remove_soft_hyphens( string $content ): string
	{
		return $this->handler->remove_soft_hyphens( $content );
	}
}
