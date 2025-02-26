<?php
namespace Xicrow\PhpImage\Placeholder;

use Xicrow\PhpImage\Placeholder\Exception\InvalidConfigurationException;

interface AdapterInterface
{
	/**
	 * Validates the given configuration, throwing exceptions on errors
	 *
	 * @throws InvalidConfigurationException
	 */
	public static function ValidateConfig(PlaceholderConfig $oPlaceholderConfig): void;

	/**
	 * Create new instance from given configuration
	 *
	 * @throws InvalidConfigurationException
	 */
	public function __construct(PlaceholderConfig $oPlaceholderConfig);

	/**
	 * Get URL for the placeholder image*
	 */
	public function getUrl(): string;
}
