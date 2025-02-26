<?php
namespace Xicrow\PhpImage;

use JsonException;

interface ConfigInterface
{
	public static function CreateFromArray(array $arrData): static;

	/**
	 * @throws JsonException
	 */
	public static function CreateFromJson(string $strJson): static;

	public function toArray(): array;

	/**
	 * @throws JsonException
	 */
	public function toJson(): string;
}
