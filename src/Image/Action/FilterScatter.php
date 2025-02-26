<?php
namespace Xicrow\PhpImage\Image\Action;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\ActionBase;

class FilterScatter extends ActionBase
{
	protected int $iSubtractionLevel;
	protected int $iAdditionLevel;

	/**
	 * @throws InvalidArgumentException
	 */
	public function __construct(int $iSubtractionLevel = 0, int $iAdditionLevel = 0)
	{
		if ($iSubtractionLevel >= $iAdditionLevel) {
			throw new InvalidArgumentException('Subtraction level must not be higher than or equal to addition level');
		}

		$this->iSubtractionLevel = $iSubtractionLevel;
		$this->iAdditionLevel    = $iAdditionLevel;
	}

	/**
	 * @return int
	 */
	public function getSubtractionLevel(): int
	{
		return $this->iSubtractionLevel;
	}

	/**
	 * @throws InvalidArgumentException
	 */
	public function setSubtractionLevel(int $iSubtractionLevel): static
	{
		if ($iSubtractionLevel >= $this->iAdditionLevel) {
			throw new InvalidArgumentException('Subtraction level must not be higher than or equal to addition level');
		}

		$oClone                    = clone $this;
		$oClone->iSubtractionLevel = $iSubtractionLevel;

		return $oClone;
	}

	public function getAdditionLevel(): int
	{
		return $this->iAdditionLevel;
	}

	public function setAdditionLevel(int $iAdditionLevel): static
	{
		if ($this->iSubtractionLevel >= $iAdditionLevel) {
			throw new InvalidArgumentException('Subtraction level must not be higher than or equal to addition level');
		}

		$oClone                 = clone $this;
		$oClone->iAdditionLevel = $iAdditionLevel;

		return $oClone;
	}
}
