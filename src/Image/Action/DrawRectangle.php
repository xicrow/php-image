<?php
namespace Xicrow\PhpImage\Image\Action;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\ActionBase;

class DrawRectangle extends ActionBase
{
	protected int    $iHorizontalPosition;
	protected int    $iVerticalPosition;
	protected int    $iWidth;
	protected int    $iHeight;
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
		int    $iHorizontalPosition = 0,
		int    $iVerticalPosition = 0,
		int    $iWidth = 10,
		int    $iHeight = 10,
		string $strColor = '#FFFFFF',
		float  $fTransparency = 0.0
	)
	{
		static::ValidateTransparency($fTransparency);

		$this->iHorizontalPosition = $iHorizontalPosition;
		$this->iVerticalPosition   = $iVerticalPosition;
		$this->iWidth              = $iWidth;
		$this->iHeight             = $iHeight;
		$this->strColor            = $strColor;
		$this->fTransparency       = $fTransparency;
	}

	public function getHorizontalPosition(): int
	{
		return $this->iHorizontalPosition;
	}

	public function setHorizontalPosition(int $iHorizontalPosition): static
	{
		$oClone                      = clone $this;
		$oClone->iHorizontalPosition = $iHorizontalPosition;

		return $oClone;
	}

	public function getVerticalPosition(): int
	{
		return $this->iVerticalPosition;
	}

	public function setVerticalPosition(int $iVerticalPosition): static
	{
		$oClone                    = clone $this;
		$oClone->iVerticalPosition = $iVerticalPosition;

		return $oClone;
	}

	public function getWidth(): int
	{
		return $this->iWidth;
	}

	public function setWidth(int $iWidth): static
	{
		$oClone         = clone $this;
		$oClone->iWidth = $iWidth;

		return $oClone;
	}

	public function getHeight(): int
	{
		return $this->iHeight;
	}

	public function setHeight(int $iHeight): static
	{
		$oClone          = clone $this;
		$oClone->iHeight = $iHeight;

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
