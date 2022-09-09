<?php
namespace Xicrow\PhpImage\Image\Action;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\ActionBase;

/**
 * Class DrawRectangle
 *
 * @package Xicrow\PhpImage\Image\Action
 */
class DrawRectangle extends ActionBase
{
	protected int    $iHorizontalPosition;
	protected int    $iVerticalPosition;
	protected int    $iWidth;
	protected int    $iHeight;
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
	 * @param int    $iHorizontalPosition
	 * @param int    $iVerticalPosition
	 * @param int    $iWidth
	 * @param int    $iHeight
	 * @param string $strColor
	 * @param float  $fTransparency
	 */
	public function __construct(
		int    $iHorizontalPosition = 0,
		int    $iVerticalPosition = 0,
		int    $iWidth = 10,
		int    $iHeight = 10,
		string $strColor = '#FFFFFF',
		float  $fTransparency = 0.0
	) {
		static::ValidateTransparency($fTransparency);

		$this->iHorizontalPosition = $iHorizontalPosition;
		$this->iVerticalPosition   = $iVerticalPosition;
		$this->iWidth              = $iWidth;
		$this->iHeight             = $iHeight;
		$this->strColor            = $strColor;
		$this->fTransparency       = $fTransparency;
	}

	/**
	 * @return int
	 */
	public function getHorizontalPosition(): int
	{
		return $this->iHorizontalPosition;
	}

	/**
	 * @return static
	 */
	public function setHorizontalPosition(int $iHorizontalPosition): self
	{
		$oClone                      = clone $this;
		$oClone->iHorizontalPosition = $iHorizontalPosition;

		return $oClone;
	}

	/**
	 * @return int
	 */
	public function getVerticalPosition(): int
	{
		return $this->iVerticalPosition;
	}

	/**
	 * @return static
	 */
	public function setVerticalPosition(int $iVerticalPosition): self
	{
		$oClone                    = clone $this;
		$oClone->iVerticalPosition = $iVerticalPosition;

		return $oClone;
	}

	/**
	 * @return int
	 */
	public function getWidth(): int
	{
		return $this->iWidth;
	}

	/**
	 * @return static
	 */
	public function setWidth(int $iWidth): self
	{
		$oClone         = clone $this;
		$oClone->iWidth = $iWidth;

		return $oClone;
	}

	/**
	 * @return int
	 */
	public function getHeight(): int
	{
		return $this->iHeight;
	}

	/**
	 * @return static
	 */
	public function setHeight(int $iHeight): self
	{
		$oClone          = clone $this;
		$oClone->iHeight = $iHeight;

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
