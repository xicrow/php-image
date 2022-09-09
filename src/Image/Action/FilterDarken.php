<?php
namespace Xicrow\PhpImage\Image\Action;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\ActionBase;

/**
 * Class FilterDarken
 *
 * @package Xicrow\PhpImage\Image\Action
 */
class FilterDarken extends ActionBase
{
	protected int $iPercentage;

	/**
	 * @param int $iPercentage
	 * @return void
	 */
	protected static function ValidatePercentage(int $iPercentage): void
	{
		if ($iPercentage < 0 || $iPercentage > 100) {
			throw new InvalidArgumentException('Percentage must be within 0 / 100');
		}
	}

	/**
	 * @param int $iPercentage
	 */
	public function __construct(int $iPercentage = 0)
	{
		static::ValidatePercentage($iPercentage);

		$this->iPercentage = $iPercentage;
	}

	/**
	 * @return int
	 */
	public function getPercentage(): int
	{
		return $this->iPercentage;
	}

	/**
	 * @return float
	 */
	public function getPercentageAsFloat(): float
	{
		return $this->iPercentage === 0 ? 0.0 : $this->iPercentage / 100;
	}

	/**
	 * @return static
	 */
	public function setPercentage(int $iPercentage): self
	{
		static::ValidatePercentage($iPercentage);

		$oClone              = clone $this;
		$oClone->iPercentage = $iPercentage;

		return $oClone;
	}
}
