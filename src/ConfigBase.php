<?php
namespace Xicrow\PhpImage;

abstract class ConfigBase implements ConfigInterface
{
	public static function CreateFromArray(array $arrData): static
	{
		$oInstance = new static();
		foreach ($arrData as $strProperty => $mValue) {
			$oInstance->{$strProperty} = $mValue;
		}

		return $oInstance;
	}

	public static function CreateFromJson(string $strJson): static
	{
		return static::CreateFromArray(json_decode($strJson, true, 512, JSON_THROW_ON_ERROR));
	}

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

	public function toJson(): string
	{
		return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
	}
}
