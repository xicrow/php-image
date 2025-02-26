<?php
namespace Xicrow\PhpImage\Image\Action;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\ActionBase;

class DrawLine extends ActionBase
{
	protected int    $iStartHorizontalPosition;
	protected int    $iStartVerticalPosition;
	protected int    $iEndHorizontalPosition;
	protected int    $iEndVerticalPosition;
	protected string $strColor;
	protected float  $fTransparency;

	/**
	 * @throws InvalidArgumentException
	 */
	protected static function ValidateTransparency(float $fTransparency): void
	{
		if ($fTransparency < 0 || $fTransparency > 100) {
			throw new InvalidArgumentException('Transparency must be with valid range 0 / 100');
		}
	}

	public function __construct(
		int    $iStartHorizontalPosition = 0,
		int    $iStartVerticalPosition = 0,
		int    $iEndHorizontalPosition = 0,
		int    $iEndVerticalPosition = 0,
		string $strColor = '#FFFFFF',
		float  $fTransparency = 0.0
	)
	{
		static::ValidateTransparency($fTransparency);

		$this->iStartHorizontalPosition = $iStartHorizontalPosition;
		$this->iStartVerticalPosition   = $iStartVerticalPosition;
		$this->iEndHorizontalPosition   = $iEndHorizontalPosition;
		$this->iEndVerticalPosition     = $iEndVerticalPosition;
		$this->strColor                 = $strColor;
		$this->fTransparency            = $fTransparency;
	}

	public function getStartVerticalPosition(): int
	{
		return $this->iStartVerticalPosition;
	}

	public function setStartVerticalPosition(int $iStartVerticalPosition): static
	{
		$oClone                         = clone $this;
		$oClone->iStartVerticalPosition = $iStartVerticalPosition;

		return $oClone;
	}

	public function getStartHorizontalPosition(): int
	{
		return $this->iStartHorizontalPosition;
	}

	public function setStartHorizontalPosition(int $iStartHorizontalPosition): static
	{
		$oClone                           = clone $this;
		$oClone->iStartHorizontalPosition = $iStartHorizontalPosition;

		return $oClone;
	}

	public function getEndVerticalPosition(): int
	{
		return $this->iEndVerticalPosition;
	}

	public function setEndVerticalPosition(int $iEndVerticalPosition): static
	{
		$oClone                       = clone $this;
		$oClone->iEndVerticalPosition = $iEndVerticalPosition;

		return $oClone;
	}

	public function getEndHorizontalPosition(): int
	{
		return $this->iEndHorizontalPosition;
	}

	public function setEndHorizontalPosition(int $iEndHorizontalPosition): static
	{
		$oClone                         = clone $this;
		$oClone->iEndHorizontalPosition = $iEndHorizontalPosition;

		return $oClone;
	}

	public function getColor(): string
	{
		return $this->strColor;
	}

	public function setColor(string $strColor): static
	{
		$oClone           = clone $this;
		$oClone->strColor = $strColor;

		return $oClone;
	}

	public function getTransparency(): float
	{
		return $this->fTransparency;
	}

	public function setTransparency(float $fTransparency): static
	{
		static::ValidateTransparency($fTransparency);

		$oClone                = clone $this;
		$oClone->fTransparency = $fTransparency;

		return $oClone;
	}
}
