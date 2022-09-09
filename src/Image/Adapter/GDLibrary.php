<?php
namespace Xicrow\PhpImage\Image\Adapter;

use RuntimeException;
use Xicrow\PhpImage\Image\Action\FilterBrighten;
use Xicrow\PhpImage\Image\Action\FilterColorize;
use Xicrow\PhpImage\Image\Action\FilterContrast;
use Xicrow\PhpImage\Image\Action\FilterDarken;
use Xicrow\PhpImage\Image\Action\FilterEdgeDetect;
use Xicrow\PhpImage\Image\Action\FilterEmboss;
use Xicrow\PhpImage\Image\Action\FilterGaussianBlur;
use Xicrow\PhpImage\Image\Action\FilterGreyScale;
use Xicrow\PhpImage\Image\Action\FilterInvert;
use Xicrow\PhpImage\Image\Action\FilterMeanRemoval;
use Xicrow\PhpImage\Image\Action\FilterPixelate;
use Xicrow\PhpImage\Image\Action\FilterScatter;
use Xicrow\PhpImage\Image\Action\FilterSelectiveBlur;
use Xicrow\PhpImage\Image\Action\FilterSharpen;
use Xicrow\PhpImage\Image\Action\FilterSmooth;
use Xicrow\PhpImage\Image\Action\DrawLine;
use Xicrow\PhpImage\Image\Action\DrawRectangle;
use Xicrow\PhpImage\Image\Action\DrawText;
use Xicrow\PhpImage\Image\Action\ResizeCrop;
use Xicrow\PhpImage\Image\Action\ResizeFit;
use Xicrow\PhpImage\Image\AdapterBase;

/**
 * Class GDLibrary
 *
 * @package Xicrow\PhpImage\Image\Adapter
 */
class GDLibrary extends AdapterBase
{
	/**
	 * Resource for original image
	 *
	 * @var null|resource
	 */
	protected $rOriginal = null;

	/**
	 * Resource for current modified image
	 *
	 * @var null|resource
	 */
	protected $rCurrent = null;

	/**
	 * Image URL
	 *
	 * @var string
	 */
	protected string $strImagePath;

	/**
	 * MIME type of the image
	 *
	 * @var null|string
	 */
	protected ?string $strMimeType = null;

	/**
	 * @inheritDoc
	 */
	public static function GetSupportedActions(): array
	{
		return [
			FilterBrighten::class,
			FilterColorize::class,
			FilterContrast::class,
			FilterDarken::class,
			FilterEdgeDetect::class,
			FilterEmboss::class,
			FilterGaussianBlur::class,
			FilterGreyScale::class,
			FilterInvert::class,
			FilterMeanRemoval::class,
			FilterPixelate::class,
			FilterScatter::class,
			FilterSelectiveBlur::class,
			FilterSharpen::class,
			FilterSmooth::class,

			DrawLine::class,
			DrawRectangle::class,
			DrawText::class,

			ResizeCrop::class,
			ResizeFit::class,
		];
	}

	/**
	 * @inheritDoc
	 */
	public function __construct(string $strImagePath)
	{
		if (!function_exists('imagecreatetruecolor')) {
			// @todo Throw more specific exception
			throw new RuntimeException('GD library not available, "imagecreatetruecolor" function does not exist');
		}

		$this->strImagePath = $strImagePath;
		$this->strMimeType  = self::GetMimeType($strImagePath);
	}

	/**
	 * @inheritDoc
	 */
	public function save(string $strFilePath, int $iQuality): bool
	{
		switch ($this->strMimeType) {
			case self::MimeType_ImageGif:
				$this->rOriginal = imagecreatefromgif($this->strImagePath);
			break;

			case self::MimeType_ImageJpg:
				@ini_set('gd.jpeg_ignore_warning', 1);
				$this->rOriginal = imagecreatefromjpeg($this->strImagePath);
			break;

			case self::MimeType_ImagePng:
				$this->rOriginal = imagecreatefrompng($this->strImagePath);
			break;

			default:
				throw new RuntimeException('MIME type not supported: ' . $this->strMimeType);
		}

		$this->rCurrent = $this->rOriginal;

		foreach ($this->getActionQueue() as $oAction) {
			switch (true) {
				// Draw
				case $oAction instanceof DrawLine:
					$this->processDrawLine($oAction);
				break;
				case $oAction instanceof DrawRectangle:
					$this->processDrawRectangle($oAction);
				break;
				case $oAction instanceof DrawText:
					$this->processDrawText($oAction);
				break;

				// Filters
				case $oAction instanceof FilterBrighten:
					$this->processFilterBrighten($oAction);
				break;

				case $oAction instanceof FilterColorize:
					$this->processFilterColorize($oAction);
				break;

				case $oAction instanceof FilterContrast:
					$this->processFilterContrast($oAction);
				break;

				case $oAction instanceof FilterDarken:
					$this->processFilterDarken($oAction);
				break;

				case $oAction instanceof FilterEdgeDetect:
					$this->processFilterEdgeDetect($oAction);
				break;

				case $oAction instanceof FilterEmboss:
					$this->processFilterEmboss($oAction);
				break;

				case $oAction instanceof FilterGaussianBlur:
					$this->processFilterGaussianBlur($oAction);
				break;

				case $oAction instanceof FilterGreyScale:
					$this->processFilterGreyScale($oAction);
				break;

				case $oAction instanceof FilterInvert:
					$this->processFilterInvertColors($oAction);
				break;

				case $oAction instanceof FilterMeanRemoval:
					$this->processFilterMeanRemoval($oAction);
				break;

				case $oAction instanceof FilterPixelate:
					$this->processFilterPixelate($oAction);
				break;

				case $oAction instanceof FilterScatter:
					$this->processFilterScatter($oAction);
				break;

				case $oAction instanceof FilterSelectiveBlur:
					$this->processFilterSelectiveBlur($oAction);
				break;

				case $oAction instanceof FilterSharpen:
					$this->processFilterSharpen($oAction);
				break;

				case $oAction instanceof FilterSmooth:
					$this->processFilterSmooth($oAction);
				break;

				// Resize
				case $oAction instanceof ResizeCrop:
					$this->processResizeCrop($oAction);
				break;
				case $oAction instanceof ResizeFit:
					$this->processResizeFit($oAction);
				break;
			}
		}

		$strFolderPath = dirname($strFilePath);
		if (!file_exists($strFolderPath)) {
			mkdir($strFolderPath, 0755, true);
		}

		switch ($this->strMimeType) {
			case self::MimeType_ImagePng:
				return imagepng($this->rCurrent, $strFilePath, 9);

			default:
				return imagejpeg($this->rCurrent, $strFilePath, $iQuality);
		}
	}

	/**
	 * @param FilterBrighten $oAction
	 * @return void
	 */
	protected function processFilterBrighten(FilterBrighten $oAction): void
	{
		$iLevel = 255 * $oAction->getPercentageAsFloat();

		imagefilter($this->rCurrent, IMG_FILTER_BRIGHTNESS, $iLevel);
	}

	/**
	 * @param FilterColorize $oAction
	 * @return void
	 */
	protected function processFilterColorize(FilterColorize $oAction): void
	{
		$iRedLevel   = 255 * $oAction->getRedPercentageAsFloat();
		$iGreenLevel = 255 * $oAction->getGreenPercentageAsFloat();
		$iBlueLevel  = 255 * $oAction->getBluePercentageAsFloat();

		imagefilter($this->rCurrent, IMG_FILTER_COLORIZE, $iRedLevel, $iGreenLevel, $iBlueLevel);
	}

	/**
	 * @param FilterContrast $oAction
	 * @return void
	 */
	protected function processFilterContrast(FilterContrast $oAction): void
	{
		$iLevel = $oAction->getPercentage() * -1;

		imagefilter($this->rCurrent, IMG_FILTER_CONTRAST, $iLevel);
	}

	/**
	 * @param FilterDarken $oAction
	 * @return void
	 */
	protected function processFilterDarken(FilterDarken $oAction): void
	{
		$iLevel = -255 * $oAction->getPercentageAsFloat();

		imagefilter($this->rCurrent, IMG_FILTER_BRIGHTNESS, $iLevel);
	}

	/**
	 * @param FilterEdgeDetect $oAction
	 * @return void
	 */
	protected function processFilterEdgeDetect(FilterEdgeDetect $oAction): void
	{
		imagefilter($this->rCurrent, IMG_FILTER_EDGEDETECT);
	}

	/**
	 * @param FilterEmboss $oAction
	 * @return void
	 */
	protected function processFilterEmboss(FilterEmboss $oAction): void
	{
		imagefilter($this->rCurrent, IMG_FILTER_EMBOSS);
	}

	/**
	 * @param FilterGaussianBlur $oAction
	 * @return void
	 */
	protected function processFilterGaussianBlur(FilterGaussianBlur $oAction): void
	{
		imagefilter($this->rCurrent, IMG_FILTER_GAUSSIAN_BLUR);
	}

	/**
	 * @param FilterGreyScale $oAction
	 * @return void
	 */
	protected function processFilterGreyScale(FilterGreyScale $oAction): void
	{
		imagefilter($this->rCurrent, IMG_FILTER_GRAYSCALE);
	}

	/**
	 * @param FilterInvert $oAction
	 * @return void
	 */
	protected function processFilterInvertColors(FilterInvert $oAction): void
	{
		imagefilter($this->rCurrent, IMG_FILTER_NEGATE);
	}

	/**
	 * @param FilterMeanRemoval $oAction
	 * @return void
	 */
	protected function processFilterMeanRemoval(FilterMeanRemoval $oAction): void
	{
		imagefilter($this->rCurrent, IMG_FILTER_MEAN_REMOVAL);
	}

	/**
	 * @param FilterPixelate $oAction
	 * @return void
	 */
	protected function processFilterPixelate(FilterPixelate $oAction): void
	{
		imagefilter($this->rCurrent, IMG_FILTER_PIXELATE, $oAction->getBlockSizeInPixels(), $oAction->getUseAdvancedPixelation());
	}

	/**
	 * @param FilterScatter $oAction
	 * @return void
	 */
	protected function processFilterScatter(FilterScatter $oAction): void
	{
		imagefilter($this->rCurrent, IMG_FILTER_SCATTER, $oAction->getSubstractionLevel(), $oAction->getAdditionLevel());
	}

	/**
	 * @param FilterSelectiveBlur $oAction
	 * @return void
	 */
	protected function processFilterSelectiveBlur(FilterSelectiveBlur $oAction): void
	{
		imagefilter($this->rCurrent, IMG_FILTER_SELECTIVE_BLUR);
	}

	/**
	 * @param FilterSharpen $oAction
	 * @return void
	 */
	protected function processFilterSharpen(FilterSharpen $oAction): void
	{
		$iLevel = -10 * $oAction->getPercentageAsFloat();

		imagefilter($this->rCurrent, IMG_FILTER_SMOOTH, $iLevel);
	}

	/**
	 * @param FilterSmooth $oAction
	 * @return void
	 */
	protected function processFilterSmooth(FilterSmooth $oAction): void
	{
		$iLevel = 10 * $oAction->getPercentageAsFloat();

		imagefilter($this->rCurrent, IMG_FILTER_SMOOTH, $iLevel);
	}

	/**
	 * @param DrawLine $oAction
	 * @return void
	 */
	protected function processDrawLine(DrawLine $oAction): void
	{
		if ($oAction->getTransparency() > 0) {
			imagealphablending($this->rCurrent, true);
		}

		imageline(
			$this->rCurrent,
			$oAction->getStartHorizontalPosition(),
			$oAction->getStartVerticalPosition(),
			$oAction->getEndHorizontalPosition(),
			$oAction->getEndVerticalPosition(),
			$this->getColorIdentifierFromHex($oAction->getColor(), $oAction->getTransparency())
		);

		if ($oAction->getTransparency() > 0) {
			imagealphablending($this->rCurrent, false);
		}
	}

	/**
	 * @param DrawRectangle $oAction
	 * @return void
	 */
	protected function processDrawRectangle(DrawRectangle $oAction): void
	{
		if ($oAction->getTransparency() > 0) {
			imagealphablending($this->rCurrent, true);
		}

		imagefilledrectangle(
			$this->rCurrent,
			$oAction->getHorizontalPosition(),
			$oAction->getVerticalPosition(),
			$oAction->getHorizontalPosition() + $oAction->getWidth(),
			$oAction->getVerticalPosition() + $oAction->getHeight(),
			$this->getColorIdentifierFromHex($oAction->getColor(), $oAction->getTransparency())
		);

		if ($oAction->getTransparency() > 0) {
			imagealphablending($this->rCurrent, false);
		}
	}

	/**
	 * @param DrawText $oAction
	 * @return void
	 */
	protected function processDrawText(DrawText $oAction): void
	{
		if ($oAction->getContent() === '') {
			return;
		}

		if ($oAction->getTransparency() > 0) {
			imagealphablending($this->rCurrent, true);
		}

		imagettftext(
			$this->rCurrent,
			$oAction->getSize(),
			$oAction->getAngle(),
			$oAction->getHorizontalPosition(),
			$oAction->getVerticalPosition(),
			$this->getColorIdentifierFromHex($oAction->getColor(), $oAction->getTransparency()),
			$oAction->getFontFile(),
			$oAction->getContent()
		);

		if ($oAction->getTransparency() > 0) {
			imagealphablending($this->rCurrent, false);
		}
	}

	/**
	 * @param ResizeCrop $oAction
	 * @return void
	 */
	protected function processResizeCrop(ResizeCrop $oAction): void
	{
		// Get current width and height
		$iCurrentWidth  = imagesx($this->rCurrent);
		$iCurrentHeight = imagesy($this->rCurrent);

		// Check for missing dimensions
		if ($oAction->getWidth() > 0 && $oAction->getHeight() <= 0) {
			$oAction = $oAction->setHeight($iCurrentHeight * ($oAction->getWidth() / $iCurrentWidth));
		} elseif ($oAction->getHeight() > 0 && $oAction->getWidth() <= 0) {
			$oAction = $oAction->setWidth($iCurrentWidth * ($oAction->getHeight() / $iCurrentHeight));
		} elseif ($oAction->getWidth() <= 0 && $oAction->getHeight() <= 0) {
			$oAction = $oAction->setWidth($iCurrentWidth);
			$oAction = $oAction->setHeight($iCurrentHeight);
		}

		// Canvas options
		$iCanvasWidth  = $oAction->getWidth();
		$iCanvasHeight = $oAction->getHeight();

		if ($iCurrentWidth === $iCanvasWidth && $iCurrentHeight === $iCanvasHeight) {
			return;
		}

		// Options for imagecopyresampled()
		$dstW = $oAction->getWidth();
		$dstH = $oAction->getHeight();
		$dstX = 0;
		$dstY = 0;
		$srcW = $iCurrentWidth;
		$srcH = $iCurrentHeight;
		$srcX = 0;
		$srcY = 0;

		// Compare width and height
		$fCompareWidth  = $iCurrentWidth / $oAction->getWidth();
		$fCompareHeight = $iCurrentHeight / $oAction->getHeight();

		// Calculate width or height of source
		if ($fCompareWidth > $fCompareHeight) {
			$srcW = round(($iCurrentWidth / $fCompareWidth * $fCompareHeight));
		} elseif ($fCompareHeight > $fCompareWidth) {
			$srcH = round(($iCurrentHeight / $fCompareHeight * $fCompareWidth));
		}

		$bIsUnderSized = false;
		if (!$oAction->getAllowStretching() && ($dstW > $srcW || $dstH > $srcH)) {
			$bIsUnderSized = true;
		}

		if ($bIsUnderSized) {
			$srcW = $iCurrentWidth;
			$srcH = $iCurrentHeight;
			$dstW = $srcW;
			$dstH = $srcH;
		}

		// Calculate destination X and Y coordinates
		switch ($oAction->getHorizontalAlignment()) {
			case ResizeCrop::Horizontal_Align_Left:
			break;

			case ResizeCrop::Horizontal_Align_Center:
				if (!$bIsUnderSized) {
					$srcX = (($iCurrentWidth - $srcW) / 2);
				} else {
					$dstX = (($oAction->getWidth() - $srcW) / 2);
				}
			break;

			case ResizeCrop::Horizontal_Align_Right:
				if (!$bIsUnderSized) {
					$srcX = ($iCurrentWidth - $srcW);
				} else {
					$dstX = ($oAction->getWidth() - $srcW);
				}
			break;

			default:
				// @todo Throw more specific exception
				throw new RuntimeException('Unknown horizontal alignment: ' . $oAction->getHorizontalAlignment());
		}

		switch ($oAction->getVerticalAlignment()) {
			case ResizeCrop::Vertical_Align_Top:
			break;

			case ResizeCrop::Vertical_Align_Middle:
				if (!$bIsUnderSized) {
					$srcY = (($iCurrentHeight - $srcH) / 2);
				} else {
					$dstY = (($oAction->getHeight() - $srcH) / 2);
				}
			break;

			case ResizeCrop::Vertical_Align_Bottom:
				if (!$bIsUnderSized) {
					$srcY = ($iCurrentHeight - $srcH);
				} else {
					$dstY = ($oAction->getHeight() - $srcH);
				}
			break;

			default:
				// @todo Throw more specific exception
				throw new RuntimeException('Unknown vertical alignment: ' . $oAction->getVerticalAlignment());
		}

		// Get image background color setting
		$strBackground = ResizeCrop::Background_Color_Transparent;
		if ($oAction->getBackgroundColor() !== '') {
			$strBackground = $oAction->getBackgroundColor();
		}

		if ($strBackground !== ResizeCrop::Background_Color_Transparent && (strlen($strBackground) !== 7 || substr($strBackground, 0, 1) !== '#')) {
			$strBackground = ResizeCrop::Background_Color_Transparent;
		}

		// Create canvas
		$rTemp = imagecreatetruecolor($iCanvasWidth, $iCanvasHeight);

		// Transparent or solid background color
		if ($strBackground == ResizeCrop::Background_Color_Transparent) {
			// Create a new transparent color for image
			if ($this->strMimeType === self::MimeType_ImagePng) {
				// Disable blending mode for the image
				imagealphablending($rTemp, false);

				// Set transparent color
				$iColorIdentifier = $this->getColorIdentifierFromRGB(255, 255, 255, 100);
			} else {
				// Set color
				$iColorIdentifier = $this->getColorIdentifierFromRGB(255, 255, 255);
			}

			// Completely fill the background of the new image with allocated color.
			imagefill($rTemp, 0, 0, $iColorIdentifier);

			if ($this->strMimeType === self::MimeType_ImagePng) {
				// Restore transparency blending
				imagesavealpha($rTemp, true);
			}
		} else {
			// Create a new transparent color for image
			$iColorIdentifier = $this->getColorIdentifierFromHex($strBackground);

			// Completely fill the background of the new image with allocated color.
			imagefill($rTemp, 0, 0, $iColorIdentifier);
		}

		// Copy and resize part of the image with resampling
		imagecopyresampled($rTemp, $this->rCurrent, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH);

		$this->rCurrent = $rTemp;
	}

	/**
	 * @param ResizeFit $oAction
	 * @return void
	 */
	protected function processResizeFit(ResizeFit $oAction): void
	{
		// Get current width and height
		$iCurrentWidth  = imagesx($this->rCurrent);
		$iCurrentHeight = imagesy($this->rCurrent);

		// Check for missing dimensions
		if ($oAction->getWidth() > 0 && $oAction->getHeight() <= 0) {
			$oAction = $oAction->setHeight($iCurrentHeight * ($oAction->getWidth() / $iCurrentWidth));
		} elseif ($oAction->getHeight() > 0 && $oAction->getWidth() <= 0) {
			$oAction = $oAction->setWidth($iCurrentWidth * ($oAction->getHeight() / $iCurrentHeight));
		} elseif ($oAction->getWidth() <= 0 && $oAction->getHeight() <= 0) {
			$oAction = $oAction->setWidth($iCurrentWidth);
			$oAction = $oAction->setHeight($iCurrentHeight);
		}

		// Canvas options
		$iCanvasWidth  = $oAction->getWidth();
		$iCanvasHeight = $oAction->getHeight();

		if ($iCurrentWidth === $iCanvasWidth && $iCurrentHeight === $iCanvasHeight) {
			return;
		}

		// Calculate multiplier for current size if stretching is allowed, and image is smaller than requested
		$iCurrentMultiplier = 1;
		if ($oAction->getAllowStretching() && ($iCanvasWidth > $iCurrentWidth || $iCanvasHeight > $iCurrentHeight)) {
			// Calculate required multiplier level
			if (ceil($iCanvasWidth / $iCurrentWidth) > $iCurrentMultiplier) {
				$iCurrentMultiplier = ceil($iCanvasWidth / $iCurrentWidth);
			}
			if (ceil($iCanvasHeight / $iCurrentHeight) > $iCurrentMultiplier) {
				$iCurrentMultiplier = ceil($iCanvasHeight / $iCurrentHeight);
			}
		}

		// Get constrained image dimensions
		[$iFitWidth, $iFitHeight] = static::ConstrainDimensions(
			$iCurrentWidth * $iCurrentMultiplier,
			$iCurrentHeight * $iCurrentMultiplier,
			$iCanvasWidth,
			$iCanvasHeight
		);

		// If trim is enabled, adjust width and height to image dimensions
		if ($oAction->getTrim()) {
			$iCanvasWidth  = $iFitWidth;
			$iCanvasHeight = $iFitHeight;
		}

		// Options for imagecopyresampled()
		$dstW = $iFitWidth; #$oAction->getWidth();
		$dstH = $iFitHeight;#$oAction->getHeight();
		$dstX = 0;
		$dstY = 0;
		$srcW = $iCurrentWidth;
		$srcH = $iCurrentHeight;
		$srcX = 0;
		$srcY = 0;

		// Calculate destination X and Y coordinates
		switch ($oAction->getHorizontalAlignment()) {
			case ResizeFit::Horizontal_Align_Left:
			break;
			case ResizeFit::Horizontal_Align_Center:
				$dstX = ($iCanvasWidth - $dstW) / 2;
			break;
			case ResizeFit::Horizontal_Align_Right:
				$dstX = $iCanvasWidth - $dstW;
			break;
			default:
				// @todo Throw more specific exception
				throw new RuntimeException('Unknown horizontal alignment: ' . $oAction->getHorizontalAlignment());
		}
		switch ($oAction->getVerticalAlignment()) {
			case ResizeFit::Vertical_Align_Top:
			break;
			case ResizeFit::Vertical_Align_Middle:
				$dstY = (($iCanvasHeight - $dstH) / 2);
			break;
			case ResizeFit::Vertical_Align_Bottom:
				$dstY = ($iCanvasHeight - $dstH);
			break;
			default:
				// @todo Throw more specific exception
				throw new RuntimeException('Unknown vertical alignment: ' . $oAction->getVerticalAlignment());
		}

		// Get image background color setting
		$strBackground = ResizeFit::Background_Color_Transparent;
		if ($oAction->getBackgroundColor() !== '') {
			$strBackground = $oAction->getBackgroundColor();
		}

		if ($strBackground !== ResizeFit::Background_Color_Transparent && (strlen($strBackground) !== 7 || substr($strBackground, 0, 1) !== '#')) {
			$strBackground = ResizeFit::Background_Color_Transparent;
		}

		// Create canvas
		$rTemp = imagecreatetruecolor($iCanvasWidth, $iCanvasHeight);

		// Transparent or solid background color
		if ($strBackground == ResizeFit::Background_Color_Transparent) {
			// Create a new transparent color for image
			if ($this->strMimeType === self::MimeType_ImagePng) {
				// Disable blending mode for the image
				imagealphablending($rTemp, false);

				// Set transparent color
				$iColorIdentifier = $this->getColorIdentifierFromRGB(255, 255, 255, 100);
			} else {
				// Set color
				$iColorIdentifier = $this->getColorIdentifierFromRGB(255, 255, 255);
			}

			// Completely fill the background of the new image with allocated color.
			imagefill($rTemp, 0, 0, $iColorIdentifier);

			if ($this->strMimeType === self::MimeType_ImagePng) {
				// Restore transparency blending
				imagesavealpha($rTemp, true);
			}
		} else {
			// Create a new transparent color for image
			$iColorIdentifier = $this->getColorIdentifierFromHex($strBackground);

			// Completely fill the background of the new image with allocated color.
			imagefill($rTemp, 0, 0, $iColorIdentifier);
		}

		// Copy and resize part of the image with resampling
		imagecopyresampled($rTemp, $this->rCurrent, $dstX, $dstY, $srcX, $srcY, $dstW, $dstH, $srcW, $srcH);

		$this->rCurrent = $rTemp;
	}

	/**
	 * Get color identifier from red-green-blue color
	 *
	 * @param int   $iRed
	 * @param int   $iGreen
	 * @param int   $iBlue
	 * @param float $fAlpha Transparency level in percent (0 for opaque, 100 for transparent)
	 * @return int
	 */
	private function getColorIdentifierFromRGB(int $iRed, int $iGreen, int $iBlue, float $fAlpha = 0.0): int
	{
		if ($fAlpha > 0 && $fAlpha <= 100) {
			return imagecolorallocatealpha($this->rCurrent, $iRed, $iGreen, $iBlue, 127 * ($fAlpha / 100));
		}

		return imagecolorallocate($this->rCurrent, $iRed, $iGreen, $iBlue);
	}

	/**
	 * Get color identifier from hexadecimal color
	 *
	 * @param string $strHexColor
	 * @param float  $fTransparency Transparency level in percent (0 for opaque, 100 for transparent)
	 * @return int
	 */
	private function getColorIdentifierFromHex(string $strHexColor, float $fTransparency = 0.0): int
	{
		$arrColorRgb = self::Hex2Rgb($strHexColor);

		return $this->getColorIdentifierFromRGB($arrColorRgb[0], $arrColorRgb[1], $arrColorRgb[2], $fTransparency);
	}
}
