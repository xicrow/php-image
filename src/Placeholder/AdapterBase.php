<?php
namespace Xicrow\PhpImage\Placeholder;

abstract class AdapterBase implements AdapterInterface
{
	protected PlaceholderConfig $oPlaceholderConfig;

	public static function ValidateConfig(PlaceholderConfig $oPlaceholderConfig): void
	{
	}

	public function __construct(PlaceholderConfig $oPlaceholderConfig)
	{
		static::ValidateConfig($oPlaceholderConfig);

		$this->oPlaceholderConfig = $oPlaceholderConfig;
	}

	protected function getCurrentUrlProtocol(): string
	{
		$protocol = 'http';
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
			$protocol = 'https';
		} elseif (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on') {
			$protocol = 'https';
		} elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
			$protocol = 'https';
		}

		return $protocol;
	}
}
