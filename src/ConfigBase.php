<?php
namespace Xicrow\PhpImage;

/**
 * Class ConfigBase
 *
 * @package Xicrow\PhpImage
 */
abstract class ConfigBase implements ConfigInterface
{
	/**
	 * @inheritDoc
	 */
	public static function CreateFromArray(array $arrData): self
	{
		$oInstance = new static();
		foreach ($arrData as $strProperty => $mValue) {
			$oInstance->{$strProperty} = $mValue;
		}

		return $oInstance;
	}

	/**
	 * @inheritDoc
	 */
	public static function CreateFromJson(string $strJson): self
	{
		return static::CreateFromArray(json_decode($strJson, true, 512, JSON_THROW_ON_ERROR));
	}

	/**
	 * @inheritDoc
	 */
	public function toArray(): array
	{
		$arrData = [];
		foreach (get_object_vars($this) as $strProperty => $mValue) {
			if ($mValue === null) {
				continue;
			}

			$arrData[$strProperty] = $mValue;
		}

		return $arrData;
	}

	/**
	 * @inheritDoc
	 */
	public function toJson(): string
	{
		return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
	}
}
