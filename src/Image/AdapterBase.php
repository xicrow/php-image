<?php
namespace Xicrow\PhpImage\Image;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\Exception\UnsupportedActionException;

/**
 * Class AdapterBase
 *
 * @package Xicrow\PhpImage\Image
 */
abstract class AdapterBase implements AdapterInterface
{
	/**
	 * @var ActionInterface[]
	 */
	protected array $arrActionQueue = [];

	/**
	 * @inheritDoc
	 */
	public static function GetSupportedActions(): array
	{
		return [];
	}

	/**
	 * @inheritDoc
	 */
	public function addAction(ActionInterface $oAction, bool $bFirst = false): self
	{
		if (!in_array(get_class($oAction), static::GetSupportedActions(), true)) {
			throw new UnsupportedActionException('Action not supported for this adapter: ' . get_class($oAction));
		}

		if ($bFirst) {
			array_unshift($this->arrActionQueue, $oAction);
		} else {
			$this->arrActionQueue[] = $oAction;
		}

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function addActions(array $arrActions, bool $bFirst = false): self
	{
		foreach ($arrActions as $oAction) {
			if (!$oAction instanceof ActionInterface) {
				throw new InvalidArgumentException('List of action must only contain classes implementing the ActionInterface');
			}

			if (!in_array(get_class($oAction), static::GetSupportedActions(), true)) {
				throw new UnsupportedActionException('Action not supported for this adapter: ' . get_class($oAction));
			}
		}

		if ($bFirst) {
			$this->arrActionQueue = array_merge($arrActions, $this->arrActionQueue);
		} else {
			$this->arrActionQueue = array_merge($this->arrActionQueue, $arrActions);
		}

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function removeActionByUID(ActionInterface $oAction): self
	{
		foreach ($this->arrActionQueue as $iActionQueueIndex => $oActionQueueItem) {
			if ($oActionQueueItem->getUID() === $oAction->getUID()) {
				unset($this->arrActionQueue[$iActionQueueIndex]);
			}
		}

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function removeActionByClass(string $strActionClass): self
	{
		foreach ($this->arrActionQueue as $iActionQueueIndex => $oActionQueueItem) {
			if ($oActionQueueItem instanceof $strActionClass) {
				unset($this->arrActionQueue[$iActionQueueIndex]);
			}
		}

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getActionQueue(): array
	{
		return $this->arrActionQueue;
	}

	/**
	 * @inheritDoc
	 */
	public function getActionQueueHash(): string
	{
		$arrActionUIDs = [];
		foreach ($this->arrActionQueue as $oAction) {
			$arrActionUIDs[] = $oAction->getUID();
		}

		return md5(implode('-', $arrActionUIDs));
	}

	/**
	 * Get MIME type for a given file path
	 *
	 * @param string $strFilePath
	 *
	 * @return string
	 */
	protected static function GetMimeType(string $strFilePath): string
	{
		// Default MIME type to return, if not detected
		$strMimeType = self::MimeType_ImagePng;

		$strOperatingSystem = PHP_OS;
		if (stristr($strOperatingSystem, 'WIN')) {
			$strOperatingSystem = 'WIN';
		}

		if (function_exists('mime_content_type')) {
			$strMimeType = mime_content_type($strFilePath);
		}

		// Use PECL fileinfo to determine MIME type
		if (!self::IsValidMimeType($strMimeType)) {
			if (function_exists('finfo_open')) {
				$rFinfo = @finfo_open(FILEINFO_MIME);
				if ($rFinfo !== false) {
					$strMimeType = finfo_file($rFinfo, $strFilePath);
					finfo_close($rFinfo);
				}
			}
		}

		// Try to determine MIME type by using unix file command, this should not be executed on Windows
		if (!self::IsValidMimeType($strMimeType) && $strOperatingSystem != "WIN") {
			if (preg_match('/freebsd|linux/i', $strOperatingSystem)) {
				$strMimeType = trim(@shell_exec('file -bi ' . escapeshellarg($strFilePath)));
			}
		}

		// Use file extension to determine MIME type
		if (!self::IsValidMimeType($strMimeType)) {
			$strFileExtension = pathinfo($strFilePath, PATHINFO_EXTENSION);
			$arrMimeTypes     = [
				'gif'  => self::MimeType_ImageGif,
				'jpg'  => self::MimeType_ImageJpg,
				'jpeg' => self::MimeType_ImageJpg,
				'png'  => self::MimeType_ImagePng,
			];

			if (strlen($strFileExtension) > 0 && array_key_exists($strFileExtension, $arrMimeTypes)) {
				$strMimeType = $arrMimeTypes[$strFileExtension];
			}
		}

		return $strMimeType;
	}

	/**
	 * Check for valid MIME type
	 *
	 * @param string $strMimeType
	 *
	 * @return bool
	 */
	protected static function IsValidMimeType(string $strMimeType): bool
	{
		if (preg_match('/image\/(gif|jpg|jpeg|png)/i', $strMimeType)) {
			return true;
		}

		return false;
	}

	/**
	 * Convert hexadecimal color string to RGB
	 *
	 * @param string $strHex
	 *
	 * @return int[]
	 */
	protected static function Hex2Rgb(string $strHex): array
	{
		$color = str_replace('#', '', $strHex);

		if (strlen($color) == 3) {
			return [
				hexdec(str_repeat(substr($color, 0, 1), 2)),
				hexdec(str_repeat(substr($color, 1, 1), 2)),
				hexdec(str_repeat(substr($color, 2, 1), 2)),
			];
		}

		if (strlen($color) == 6) {
			return [
				hexdec(substr($color, 0, 2)),
				hexdec(substr($color, 2, 2)),
				hexdec(substr($color, 4, 2)),
			];
		}

		throw new InvalidArgumentException('Invalid hexadecimal color given: ' . $strHex);
	}

	/**
	 * Calculate constrained image dimensions
	 *
	 * @param int $iCurrentWidth
	 * @param int $iCurrentHeight
	 * @param int $iMaxWidth
	 * @param int $iMaxHeight
	 *
	 * @return array
	 */
	protected static function ConstrainDimensions(int $iCurrentWidth, int $iCurrentHeight, int $iMaxWidth = 0, int $iMaxHeight = 0): array
	{
		if ($iMaxWidth === 0 && $iMaxHeight === 0) {
			return [
				$iCurrentWidth,
				$iCurrentHeight,
			];
		}

		$fWidthRatio = $fHeightRatio = 1.0;
		$bDidWidth   = $bDidHeight = false;

		if ($iMaxWidth > 0 && $iCurrentWidth > 0 && $iCurrentWidth > $iMaxWidth) {
			$fWidthRatio = $iMaxWidth / $iCurrentWidth;
			$bDidWidth   = true;
		}

		if ($iMaxHeight > 0 && $iCurrentHeight > 0 && $iCurrentHeight > $iMaxHeight) {
			$fHeightRatio = $iMaxHeight / $iCurrentHeight;
			$bDidHeight   = true;
		}

		// Calculate the smaller/larger ratios
		$fSmallerRatio = min($fWidthRatio, $fHeightRatio);
		$fLargerRatio  = max($fWidthRatio, $fHeightRatio);

		if (intval($iCurrentWidth * $fLargerRatio) > $iMaxWidth || intval($iCurrentHeight * $fLargerRatio) > $iMaxHeight) {
			// The larger ratio is too big. It would result in an overflow.
			$fRatio = $fSmallerRatio;
		} else {
			// The larger ratio fits, and is likely to be a more "snug" fit.
			$fRatio = $fLargerRatio;
		}

		$iWidth  = intval($iCurrentWidth * $fRatio);
		$iHeight = intval($iCurrentHeight * $fRatio);

		// Sometimes, due to rounding, we'll end up with a result like this: 465x700 in a 177x177 box is 117x176... a pixel short
		// We also have issues with recursive calls resulting in an ever-changing result. Contraining to the result of a constraint should yield the original result.
		// Thus, we look for dimensions that are one pixel shy of the max value and bump them up
		if ($bDidWidth && $iWidth === $iMaxWidth - 1) {
			$iWidth = $iMaxWidth; // Round it up
		}
		if ($bDidHeight && $iHeight === $iMaxHeight - 1) {
			$iHeight = $iMaxHeight; // Round it up
		}

		return [
			$iWidth,
			$iHeight,
		];
	}
}
