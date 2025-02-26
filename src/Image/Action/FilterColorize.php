<?php
namespace Xicrow\PhpImage\Image\Action;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\ActionBase;

class FilterColorize extends ActionBase
{
	protected int $iRedPercentage;
	protected int $iGreenPercentage;
	protected int $iBluePercentage;

	/**
	 * @throws InvalidArgumentException
	 */
	public static function ValidateRedPercentage(int $iRedPercentage): void
	{
		if ($iRedPercentage < -100 || $iRedPercentage > 100) {
			throw new InvalidArgumentException('Red percentage must be within -100 / 100');
		}
	}

	public static function ValidateGreenPercentage(int $iGreenPercentage): void
	{
		if ($iGreenPercentage < -100 || $iGreenPercentage > 100) {
			throw new InvalidArgumentException('Green percentage must be within -100 / 100');
		}
	}

	public static function ValidateBluePercentage(int $iBluePercentage): void
	{
		if ($iBluePercentage < -100 || $iBluePercentage > 100) {
			throw new InvalidArgumentException('Blue percentage must be within -100 / 100');
		}
	}

	public function __construct(int $iRedPercentage = 0, int $iGreenPercentage = 0, int $iBluePercentage = 0)
	{
		static::ValidateRedPercentage($iRedPercentage);
		static::ValidateGreenPercentage($iGreenPercentage);
		static::ValidateBluePercentage($iBluePercentage);

		$this->iRedPercentage   = $iRedPercentage;
		$this->iGreenPercentage = $iGreenPercentage;
		$this->iBluePercentage  = $iBluePercentage;
	}

	public function getRedPercentage(): int
	{
		return $this->iRedPercentage;
	}

	public function getRedPercentageAsFloat(): float
	{
		return $this->iRedPercentage === 0 ? 0.0 : $this->iRedPercentage / 100;
	}

	public function setRedPercentage(int $iRedPercentage): static
	{
		static::ValidateRedPercentage($iRedPercentage);

		$oClone                 = clone $this;
		$oClone->iRedPercentage = $iRedPercentage;

		return $oClone;
	}

	public function getGreenPercentage(): int
	{
		return $this->iGreenPercentage;
	}

	public function getGreenPercentageAsFloat(): float
	{
		return $this->iGreenPercentage === 0 ? 0.0 : $this->iGreenPercentage / 100;
	}

	public function setGreenPercentage(int $iGreenPercentage): static
	{
		static::ValidateGreenPercentage($iGreenPercentage);

		$oClone                   = clone $this;
		$oClone->iGreenPercentage = $iGreenPercentage;

		return $oClone;
	}

	public function getBluePercentage(): int
	{
		return $this->iBluePercentage;
	}

	public function getBluePercentageAsFloat(): float
	{
		return $this->iBluePercentage === 0 ? 0.0 : $this->iBluePercentage / 100;
	}

	public function setBluePercentage(int $iBluePercentage): static
	{
		static::ValidateBluePercentage($iBluePercentage);

		$oClone                  = clone $this;
		$oClone->iBluePercentage = $iBluePercentage;

		return $oClone;
	}
}
