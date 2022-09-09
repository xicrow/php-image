<?php
namespace Xicrow\PhpImage\Placeholder;

use Xicrow\PhpImage\ConfigBase;

/**
 * Class PlaceholderConfig
 *
 * @package Xicrow\PhpImage\Placeholder
 */
class PlaceholderConfig extends ConfigBase
{
	protected int     $iWidth             = 0;
	protected int     $iHeight            = 0;
	protected ?string $strText            = null;
	protected ?string $strBackgroundColor = null;
	protected ?string $strTextColor       = null;
	protected ?string $strFileExtension   = null;

	/**
	 * PlaceholderConfig constructor.
	 *
	 * @param int         $iWidth
	 * @param int         $iHeight
	 * @param string|null $strText
	 * @param string|null $strBackgroundColor
	 * @param string|null $strTextColor
	 * @param string|null $strFileExtension
	 */
	public function __construct(
		int     $iWidth = 0,
		int     $iHeight = 0,
		?string $strText = null,
		?string $strBackgroundColor = null,
		?string $strTextColor = null,
		?string $strFileExtension = null
	) {
		$this->iWidth             = $iWidth;
		$this->iHeight            = $iHeight;
		$this->strText            = $strText;
		$this->strBackgroundColor = $strBackgroundColor;
		$this->strTextColor       = $strTextColor;
		$this->strFileExtension   = $strFileExtension;
	}

	/**
	 * @return int
	 */
	public function getWidth(): int
	{
		return $this->iWidth;
	}

	/**
	 * @param int $iWidth
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
	 * @param int $iHeight
	 * @return static
	 */
	public function setHeight(int $iHeight): self
	{
		$oClone          = clone $this;
		$oClone->iHeight = $iHeight;

		return $oClone;
	}

	/**
	 * @return string|null
	 */
	public function getText(): ?string
	{
		return $this->strText;
	}

	/**
	 * @param string|null $strText
	 * @return static
	 */
	public function setText(?string $strText): self
	{
		$oClone          = clone $this;
		$oClone->strText = $strText;

		return $oClone;
	}

	/**
	 * @return string|null
	 */
	public function getBackgroundColor(): ?string
	{
		return $this->strBackgroundColor;
	}

	/**
	 * @param string|null $strBackgroundColor
	 * @return static
	 */
	public function setBackgroundColor(?string $strBackgroundColor): self
	{
		$oClone                     = clone $this;
		$oClone->strBackgroundColor = $strBackgroundColor;

		return $oClone;
	}

	/**
	 * @return string|null
	 */
	public function getTextColor(): ?string
	{
		return $this->strTextColor;
	}

	/**
	 * @param string|null $strTextColor
	 * @return static
	 */
	public function setTextColor(?string $strTextColor): self
	{
		$oClone               = clone $this;
		$oClone->strTextColor = $strTextColor;

		return $oClone;
	}

	/**
	 * @return string|null
	 */
	public function getFileExtension(): ?string
	{
		return $this->strFileExtension;
	}

	/**
	 * @param string|null $strFileExtension
	 * @return static
	 */
	public function setFileExtension(?string $strFileExtension): self
	{
		$oClone                   = clone $this;
		$oClone->strFileExtension = $strFileExtension;

		return $oClone;
	}
}
