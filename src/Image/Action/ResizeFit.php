<?php
namespace Xicrow\PhpImage\Image\Action;

use Xicrow\PhpImage\Image\ActionBase;

/**
 * Class ResizeFit
 *
 * @package Xicrow\PhpImage\Image\Action
 */
class ResizeFit extends ActionBase
{
	public const Vertical_Align_Top    = 'top';
	public const Vertical_Align_Middle = 'middle';
	public const Vertical_Align_Bottom = 'bottom';

	public const Horizontal_Align_Left   = 'left';
	public const Horizontal_Align_Center = 'center';
	public const Horizontal_Align_Right  = 'right';

	public const Background_Color_Transparent = 'transparent';

	protected int    $iWidth;
	protected int    $iHeight;
	protected bool   $bAllowStretching;
	protected bool   $bTrim;
	protected string $strVerticalAlignment;
	protected string $strHorizontalAlignment;
	protected string $strBackgroundColor;

	/**
	 * @param int    $iWidth
	 * @param int    $iHeight
	 * @param bool   $bAllowStretching
	 * @param bool   $bTrim
	 * @param string $strVerticalAlignment
	 * @param string $strHorizontalAlignment
	 * @param string $strBackgroundColor
	 */
	public function __construct(
		int    $iWidth = 0,
		int    $iHeight = 0,
		bool   $bAllowStretching = false,
		bool   $bTrim = false,
		string $strVerticalAlignment = self::Vertical_Align_Middle,
		string $strHorizontalAlignment = self::Horizontal_Align_Center,
		string $strBackgroundColor = self::Background_Color_Transparent
	) {
		$this->iWidth                 = $iWidth;
		$this->iHeight                = $iHeight;
		$this->bAllowStretching       = $bAllowStretching;
		$this->bTrim                  = $bTrim;
		$this->strVerticalAlignment   = $strVerticalAlignment;
		$this->strHorizontalAlignment = $strHorizontalAlignment;
		$this->strBackgroundColor     = $strBackgroundColor;
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
	 * @return bool
	 */
	public function getAllowStretching(): bool
	{
		return $this->bAllowStretching;
	}

	/**
	 * @return static
	 */
	public function setAllowStretching(bool $bAllowStretching): self
	{
		$oClone                   = clone $this;
		$oClone->bAllowStretching = $bAllowStretching;

		return $oClone;
	}

	/**
	 * @return bool
	 */
	public function getTrim(): bool
	{
		return $this->bTrim;
	}

	/**
	 * @return static
	 */
	public function setTrim(bool $bTrim): self
	{
		$oClone        = clone $this;
		$oClone->bTrim = $bTrim;

		return $oClone;
	}

	/**
	 * @return string
	 */
	public function getVerticalAlignment(): string
	{
		return $this->strVerticalAlignment;
	}

	/**
	 * @return static
	 */
	public function setVerticalAlignment(string $strVerticalAlignment): self
	{
		$oClone                       = clone $this;
		$oClone->strVerticalAlignment = $strVerticalAlignment;

		return $oClone;
	}

	/**
	 * @return string
	 */
	public function getHorizontalAlignment(): string
	{
		return $this->strHorizontalAlignment;
	}

	/**
	 * @return static
	 */
	public function setHorizontalAlignment(string $strHorizontalAlignment): self
	{
		$oClone                         = clone $this;
		$oClone->strHorizontalAlignment = $strHorizontalAlignment;

		return $oClone;
	}

	/**
	 * @return string
	 */
	public function getBackgroundColor(): string
	{
		return $this->strBackgroundColor;
	}

	/**
	 * @return static
	 */
	public function setBackgroundColor(string $strBackgroundColor): self
	{
		$oClone                     = clone $this;
		$oClone->strBackgroundColor = $strBackgroundColor;

		return $oClone;
	}
}
