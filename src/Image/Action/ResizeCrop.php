<?php
namespace Xicrow\PhpImage\Image\Action;

use Xicrow\PhpImage\Image\ActionBase;

class ResizeCrop extends ActionBase
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
	protected string $strVerticalAlignment;
	protected string $strHorizontalAlignment;
	protected string $strBackgroundColor;

	public function __construct(
		int    $iWidth = 0,
		int    $iHeight = 0,
		bool   $bAllowStretching = false,
		string $strVerticalAlignment = self::Vertical_Align_Middle,
		string $strHorizontalAlignment = self::Horizontal_Align_Center,
		string $strBackgroundColor = self::Background_Color_Transparent
	)
	{
		$this->iWidth                 = $iWidth;
		$this->iHeight                = $iHeight;
		$this->bAllowStretching       = $bAllowStretching;
		$this->strVerticalAlignment   = $strVerticalAlignment;
		$this->strHorizontalAlignment = $strHorizontalAlignment;
		$this->strBackgroundColor     = $strBackgroundColor;
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

	public function getAllowStretching(): bool
	{
		return $this->bAllowStretching;
	}

	public function setAllowStretching(bool $bAllowStretching): static
	{
		$oClone                   = clone $this;
		$oClone->bAllowStretching = $bAllowStretching;

		return $oClone;
	}

	public function getVerticalAlignment(): string
	{
		return $this->strVerticalAlignment;
	}

	public function setVerticalAlignment(string $strVerticalAlignment): static
	{
		$oClone                       = clone $this;
		$oClone->strVerticalAlignment = $strVerticalAlignment;

		return $oClone;
	}

	public function getHorizontalAlignment(): string
	{
		return $this->strHorizontalAlignment;
	}

	public function setHorizontalAlignment(string $strHorizontalAlignment): static
	{
		$oClone                         = clone $this;
		$oClone->strHorizontalAlignment = $strHorizontalAlignment;

		return $oClone;
	}

	public function getBackgroundColor(): string
	{
		return $this->strBackgroundColor;
	}

	public function setBackgroundColor(string $strBackgroundColor): static
	{
		$oClone                     = clone $this;
		$oClone->strBackgroundColor = $strBackgroundColor;

		return $oClone;
	}
}
