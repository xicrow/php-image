<?php
namespace Xicrow\PhpImage\Image\Action;

use Xicrow\PhpImage\Image\ActionBase;

class FilterPixelate extends ActionBase
{
	protected int  $iBlockSizeInPixels;
	protected bool $bUseAdvancedPixelation;

	public function __construct(int $iBlockSizeInPixels = 0, bool $bUseAdvancedPixelation = false)
	{
		$this->iBlockSizeInPixels     = $iBlockSizeInPixels;
		$this->bUseAdvancedPixelation = $bUseAdvancedPixelation;
	}

	public function getBlockSizeInPixels(): int
	{
		return $this->iBlockSizeInPixels;
	}

	public function setBlockSizeInPixels(int $iBlockSizeInPixels): static
	{
		$oClone                     = clone $this;
		$oClone->iBlockSizeInPixels = $iBlockSizeInPixels;

		return $oClone;
	}

	public function getUseAdvancedPixelation(): bool
	{
		return $this->bUseAdvancedPixelation;
	}

	public function setUseAdvancedPixelation(bool $bUseAdvancedPixelation): static
	{
		$oClone                         = clone $this;
		$oClone->bUseAdvancedPixelation = $bUseAdvancedPixelation;

		return $oClone;
	}
}
