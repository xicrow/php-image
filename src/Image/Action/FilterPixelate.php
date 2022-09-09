<?php
namespace Xicrow\PhpImage\Image\Action;

use Xicrow\PhpImage\Image\ActionBase;

/**
 * Class FilterPixelate
 *
 * @package Xicrow\PhpImage\Image\Action
 */
class FilterPixelate extends ActionBase
{
	protected int  $iBlockSizeInPixels;
	protected bool $bUseAdvancedPixelation;

	/**
	 * @param int  $iBlockSizeInPixels
	 * @param bool $bUseAdvancedPixelation
	 */
	public function __construct(int $iBlockSizeInPixels = 0, bool $bUseAdvancedPixelation = false)
	{
		$this->iBlockSizeInPixels     = $iBlockSizeInPixels;
		$this->bUseAdvancedPixelation = $bUseAdvancedPixelation;
	}

	/**
	 * @return int
	 */
	public function getBlockSizeInPixels(): int
	{
		return $this->iBlockSizeInPixels;
	}

	/**
	 * @return static
	 */
	public function setBlockSizeInPixels(int $iBlockSizeInPixels): self
	{
		$oClone                     = clone $this;
		$oClone->iBlockSizeInPixels = $iBlockSizeInPixels;

		return $oClone;
	}

	/**
	 * @return bool
	 */
	public function getUseAdvancedPixelation(): bool
	{
		return $this->bUseAdvancedPixelation;
	}

	/**
	 * @return static
	 */
	public function setUseAdvancedPixelation(bool $bUseAdvancedPixelation): self
	{
		$oClone                         = clone $this;
		$oClone->bUseAdvancedPixelation = $bUseAdvancedPixelation;

		return $oClone;
	}
}
