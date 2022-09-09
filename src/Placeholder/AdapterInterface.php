<?php
namespace Xicrow\PhpImage\Placeholder;

use Xicrow\PhpImage\Placeholder\Exception\InvalidConfigurationException;

/**
 * Interface AdapterInterface
 *
 * @package Xicrow\PhpImage\Placeholder
 */
interface AdapterInterface
{
	/**
	 * Validates the given configuration, throwing exceptions on errors
	 *
	 * @param PlaceholderConfig $oPlaceholderConfig
	 * @throws InvalidConfigurationException
	 */
	public static function ValidateConfig(PlaceholderConfig $oPlaceholderConfig): void;

	/**
	 * Create new instance from given configuration
	 *
	 * @param PlaceholderConfig $oPlaceholderConfig
	 * @throws InvalidConfigurationException
	 */
	public function __construct(PlaceholderConfig $oPlaceholderConfig);

	/**
	 * Get URL for the placeholder image
	 *
	 * @return string
	 */
	public function getUrl(): string;
}
