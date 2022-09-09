<?php
namespace Xicrow\PhpImage\Placeholder;

/**
 * Class AdapterBase
 *
 * @package Xicrow\PhpImage\Placeholder
 */
abstract class AdapterBase implements AdapterInterface
{
	protected PlaceholderConfig $oPlaceholderConfig;

	/**
	 * @inheritDoc
	 */
	public static function ValidateConfig(PlaceholderConfig $oPlaceholderConfig): void
	{
	}

	/**
	 * @inheritDoc
	 */
	public function __construct(PlaceholderConfig $oPlaceholderConfig)
	{
		static::ValidateConfig($oPlaceholderConfig);

		$this->oPlaceholderConfig = $oPlaceholderConfig;
	}

	/**
	 * Utility method to get current URL protocol
	 *
	 * @return string
	 */
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
