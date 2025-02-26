<?php
namespace Xicrow\PhpImage\Image\Action;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\ActionBase;

class FilterBrighten extends ActionBase
{
	protected int $iPercentage;

	/**
	 * @throws InvalidArgumentException
	 */
	protected static function ValidatePercentage(int $iPercentage): void
	{
		if ($iPercentage < 0 || $iPercentage > 100) {
			throw new InvalidArgumentException('Percentage must be within 0 / 100');
		}
	}

	public function __construct(int $iPercentage = 0)
	{
		static::ValidatePercentage($iPercentage);

		$this->iPercentage = $iPercentage;
	}

	public function getPercentage(): int
	{
		return $this->iPercentage;
	}

	public function getPercentageAsFloat(): float
	{
		return $this->iPercentage === 0 ? 0.0 : $this->iPercentage / 100;
	}

	public function setPercentage(int $iPercentage): static
	{
		static::ValidatePercentage($iPercentage);

		$oClone              = clone $this;
		$oClone->iPercentage = $iPercentage;

		return $oClone;
	}
}
