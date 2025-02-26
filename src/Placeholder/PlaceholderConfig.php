<?php
namespace Xicrow\PhpImage\Placeholder;

use Xicrow\PhpImage\ConfigBase;

class PlaceholderConfig extends ConfigBase
{
	protected int         $iWidth             = 0;
	protected int         $iHeight            = 0;
	protected string|null $strText            = null;
	protected string|null $strBackgroundColor = null;
	protected string|null $strTextColor       = null;
	protected string|null $strFileExtension   = null;

	public function __construct(
		int         $iWidth = 0,
		int         $iHeight = 0,
		string|null $strText = null,
		string|null $strBackgroundColor = null,
		string|null $strTextColor = null,
		string|null $strFileExtension = null
	)
	{
		$this->iWidth             = $iWidth;
		$this->iHeight            = $iHeight;
		$this->strText            = $strText;
		$this->strBackgroundColor = $strBackgroundColor;
		$this->strTextColor       = $strTextColor;
		$this->strFileExtension   = $strFileExtension;
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

	public function getText(): string|null
	{
		return $this->strText;
	}

	public function setText(string|null $strText): static
	{
		$oClone          = clone $this;
		$oClone->strText = $strText;

		return $oClone;
	}

	public function getBackgroundColor(): string|null
	{
		return $this->strBackgroundColor;
	}

	public function setBackgroundColor(string|null $strBackgroundColor): static
	{
		$oClone                     = clone $this;
		$oClone->strBackgroundColor = $strBackgroundColor;

		return $oClone;
	}

	public function getTextColor(): string|null
	{
		return $this->strTextColor;
	}

	public function setTextColor(string|null $strTextColor): static
	{
		$oClone               = clone $this;
		$oClone->strTextColor = $strTextColor;

		return $oClone;
	}

	public function getFileExtension(): string|null
	{
		return $this->strFileExtension;
	}

	public function setFileExtension(string|null $strFileExtension): static
	{
		$oClone                   = clone $this;
		$oClone->strFileExtension = $strFileExtension;

		return $oClone;
	}
}
