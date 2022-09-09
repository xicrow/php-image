<?php
namespace Xicrow\PhpImage;

use JsonException;

/**
 * Class ConfigBase
 *
 * @package Xicrow\PhpImage
 */
interface ConfigInterface
{
	/**
	 * Create new instance from array data
	 *
	 * @param array $arrData
	 * @return static
	 */
	public static function CreateFromArray(array $arrData): self;

	/**
	 * Create new instance from JSON data
	 *
	 * @param string $strJson
	 * @return static
	 * @throws JsonException
	 */
	public static function CreateFromJson(string $strJson): self;

	/**
	 * Get configuration as array
	 *
	 * @return array
	 */
	public function toArray(): array;

	/**
	 * Get configuration as JSON
	 *
	 * @return string
	 * @throws JsonException
	 */
	public function toJson(): string;
}
