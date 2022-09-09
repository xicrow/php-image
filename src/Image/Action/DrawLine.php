<?php
namespace Xicrow\PhpImage\Image\Action;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\ActionBase;

/**
 * Class DrawLine
 *
 * @package Xicrow\PhpImage\Image\Action
 */
class DrawLine extends ActionBase
{
	protected int    $iStartHorizontalPosition;
	protected int    $iStartVerticalPosition;
	protected int    $iEndHorizontalPosition;
	protected int    $iEndVerticalPosition;
	protected string $strColor;
	protected float  $fTransparency;

	/**
	 * @param float $fTransparency
	 * @return void
	 */
	protected static function ValidateTransparency(float $fTransparency): void
	{
		if ($fTransparency < 0 || $fTransparency > 100) {
			throw new InvalidArgumentException('Transparency must be with valid range 0 / 100');
		}
	}

	/**
	 * @param int    $iStartHorizontalPosition
	 * @param int    $iStartVerticalPosition
	 * @param int    $iEndHorizontalPosition
	 * @param int    $iEndVerticalPosition
	 * @param string $strColor
	 * @param float  $fTransparency
	 */
	public function __construct(
		int    $iStartHorizontalPosition = 0,
		int    $iStartVerticalPosition = 0,
		int    $iEndHorizontalPosition = 0,
		int    $iEndVerticalPosition = 0,
		string $strColor = '#FFFFFF',
		float  $fTransparency = 0.0
	) {
		static::ValidateTransparency($fTransparency);

		$this->iStartHorizontalPosition = $iStartHorizontalPosition;
		$this->iStartVerticalPosition   = $iStartVerticalPosition;
		$this->iEndHorizontalPosition   = $iEndHorizontalPosition;
		$this->iEndVerticalPosition     = $iEndVerticalPosition;
		$this->strColor                 = $strColor;
		$this->fTransparency            = $fTransparency;
	}

	/**
	 * @return int
	 */
	public function getStartVerticalPosition(): int
	{
		return $this->iStartVerticalPosition;
	}

	/**
	 * @return static
	 */
	public function setStartVerticalPosition(int $iStartVerticalPosition): self
	{
		$oClone                         = clone $this;
		$oClone->iStartVerticalPosition = $iStartVerticalPosition;

		return $oClone;
	}

	/**
	 * @return int
	 */
	public function getStartHorizontalPosition(): int
	{
		return $this->iStartHorizontalPosition;
	}

	/**
	 * @return static
	 */
	public function setStartHorizontalPosition(int $iStartHorizontalPosition): self
	{
		$oClone                           = clone $this;
		$oClone->iStartHorizontalPosition = $iStartHorizontalPosition;

		return $oClone;
	}

	/**
	 * @return int
	 */
	public function getEndVerticalPosition(): int
	{
		return $this->iEndVerticalPosition;
	}

	/**
	 * @return static
	 */
	public function setEndVerticalPosition(int $iEndVerticalPosition): self
	{
		$oClone                       = clone $this;
		$oClone->iEndVerticalPosition = $iEndVerticalPosition;

		return $oClone;
	}

	/**
	 * @return int
	 */
	public function getEndHorizontalPosition(): int
	{
		return $this->iEndHorizontalPosition;
	}

	/**
	 * @return static
	 */
	public function setEndHorizontalPosition(int $iEndHorizontalPosition): self
	{
		$oClone                         = clone $this;
		$oClone->iEndHorizontalPosition = $iEndHorizontalPosition;

		return $oClone;
	}

	/**
	 * @return string
	 */
	public function getColor(): string
	{
		return $this->strColor;
	}

	/**
	 * @return static
	 */
	public function setColor(string $strColor): self
	{
		$oClone           = clone $this;
		$oClone->strColor = $strColor;

		return $oClone;
	}

	/**
	 * @return float
	 */
	public function getTransparency(): float
	{
		return $this->fTransparency;
	}

	/**
	 * @return static
	 */
	public function setTransparency(float $fTransparency): self
	{
		static::ValidateTransparency($fTransparency);

		$oClone                = clone $this;
		$oClone->fTransparency = $fTransparency;

		return $oClone;
	}
}
