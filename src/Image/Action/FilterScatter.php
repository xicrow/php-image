<?php
namespace Xicrow\PhpImage\Image\Action;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\ActionBase;

/**
 * Class FilterScatter
 *
 * @package Xicrow\PhpImage\Image\Action
 */
class FilterScatter extends ActionBase
{
	protected int $iSubstractionLevel;
	protected int $iAdditionLevel;

	/**
	 * @param int $iSubstractionLevel
	 * @param int $iAdditionLevel
	 */
	public function __construct(int $iSubstractionLevel = 0, int $iAdditionLevel = 0)
	{
		if ($iSubstractionLevel >= $iAdditionLevel) {
			throw new InvalidArgumentException('Substraction level must not be higher than or equal to addition level');
		}

		$this->iSubstractionLevel = $iSubstractionLevel;
		$this->iAdditionLevel     = $iAdditionLevel;
	}

	/**
	 * @return int
	 */
	public function getSubstractionLevel(): int
	{
		return $this->iSubstractionLevel;
	}

	/**
	 * @return static
	 */
	public function setSubstractionLevel(int $iSubstractionLevel): self
	{
		if ($iSubstractionLevel >= $this->iAdditionLevel) {
			throw new InvalidArgumentException('Substraction level must not be higher than or equal to addition level');
		}

		$oClone                     = clone $this;
		$oClone->iSubstractionLevel = $iSubstractionLevel;

		return $oClone;
	}

	/**
	 * @return int
	 */
	public function getAdditionLevel(): int
	{
		return $this->iAdditionLevel;
	}

	/**
	 * @return static
	 */
	public function setAdditionLevel(int $iAdditionLevel): self
	{
		if ($this->iSubstractionLevel >= $iAdditionLevel) {
			throw new InvalidArgumentException('Substraction level must not be higher than or equal to addition level');
		}

		$oClone                 = clone $this;
		$oClone->iAdditionLevel = $iAdditionLevel;

		return $oClone;
	}
}
