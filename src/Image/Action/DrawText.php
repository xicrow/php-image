<?php
namespace Xicrow\PhpImage\Image\Action;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\ActionBase;

/**
 * Class DrawText
 *
 * @package Xicrow\PhpImage\Image\Action
 */
class DrawText extends ActionBase
{
	protected const ValidFontMimeTypes = ['font/ttf', 'font/truetype', 'font/sfnt'];

	protected int    $iHorizontalPosition;
	protected int    $iVerticalPosition;
	protected string $strFontFile;
	protected int    $iSize;
	protected float  $fAngle;
	protected string $strContent;
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
	 * @param float $fAngle
	 * @return void
	 */
	protected static function ValidateAngle(float $fAngle): void
	{
		if ($fAngle < -360 || $fAngle > 360) {
			throw new InvalidArgumentException('Angle must be with valid range -360 / 360');
		}
	}

	/**
	 * @param string $strFontFile
	 * @return void
	 */
	protected static function ValidateFontFile(string $strFontFile): void
	{
		if (!file_exists($strFontFile)) {
			throw new InvalidArgumentException('Font file does not exist');
		}

		$strMimeType = mime_content_type($strFontFile);
		if (!in_array($strMimeType, static::ValidFontMimeTypes, true)) {
			throw new InvalidArgumentException('Font file is not a valid TrueTypeFont: ' . $strMimeType);
		}
	}

	/**
	 * @param int    $iHorizontalPosition
	 * @param int    $iVerticalPosition
	 * @param string $strFontFile
	 * @param int    $iSize
	 * @param float  $fAngle
	 * @param string $strContent
	 * @param string $strColor
	 * @param float  $fTransparency
	 */
	public function __construct(
		int    $iHorizontalPosition = 0,
		int    $iVerticalPosition = 0,
		string $strFontFile = '',
		int    $iSize = 10,
		float  $fAngle = 0,
		string $strContent = '',
		string $strColor = '#FFFFFF',
		float  $fTransparency = 0.0
	) {
		static::ValidateFontFile($strFontFile);
		static::ValidateAngle($fAngle);
		static::ValidateTransparency($fTransparency);

		$this->iHorizontalPosition = $iHorizontalPosition;
		$this->iVerticalPosition   = $iVerticalPosition;
		$this->strFontFile         = $strFontFile;
		$this->iSize               = $iSize;
		$this->fAngle              = $fAngle;
		$this->strContent          = $strContent;
		$this->strColor            = $strColor;
		$this->fTransparency       = $fTransparency;
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
	 * @return string
	 */
	public function getFontFile(): string
	{
		return $this->strFontFile;
	}

	/**
	 * @return static
	 */
	public function setFontFile(string $strFontFile): self
	{
		static::ValidateFontFile($strFontFile);

		$oClone              = clone $this;
		$oClone->strFontFile = $strFontFile;

		return $oClone;
	}

	/**
	 * @return int
	 */
	public function getSize(): int
	{
		return $this->iSize;
	}

	/**
	 * @return static
	 */
	public function setSize(int $iSize): self
	{
		$oClone        = clone $this;
		$oClone->iSize = $iSize;

		return $oClone;
	}

	/**
	 * @return float
	 */
	public function getAngle(): float
	{
		return $this->fAngle;
	}

	/**
	 * @return static
	 */
	public function setAngle(float $fAngle): self
	{
		static::ValidateAngle($fAngle);

		$oClone         = clone $this;
		$oClone->fAngle = $fAngle;

		return $oClone;
	}

	/**
	 * @return string
	 */
	public function getContent(): string
	{
		return $this->strContent;
	}

	/**
	 * @return static
	 */
	public function setContent(string $strContent): self
	{
		$oClone             = clone $this;
		$oClone->strContent = $strContent;

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
