<?php
namespace Xicrow\PhpImage\Image\Action;

use InvalidArgumentException;
use Xicrow\PhpImage\Image\ActionBase;

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
	 * @throws InvalidArgumentException
	 */
	protected static function ValidateTransparency(float $fTransparency): void
	{
		if ($fTransparency < 0 || $fTransparency > 100) {
			throw new InvalidArgumentException('Transparency must be with valid range 0 / 100');
		}
	}

	/**
	 * @throws InvalidArgumentException
	 */
	protected static function ValidateAngle(float $fAngle): void
	{
		if ($fAngle < -360 || $fAngle > 360) {
			throw new InvalidArgumentException('Angle must be with valid range -360 / 360');
		}
	}

	/**
	 * @throws InvalidArgumentException
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

	public function __construct(
		int    $iHorizontalPosition = 0,
		int    $iVerticalPosition = 0,
		string $strFontFile = '',
		int    $iSize = 10,
		float  $fAngle = 0,
		string $strContent = '',
		string $strColor = '#FFFFFF',
		float  $fTransparency = 0.0
	)
	{
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

	public function getVerticalPosition(): int
	{
		return $this->iVerticalPosition;
	}

	public function setVerticalPosition(int $iVerticalPosition): static
	{
		$oClone                    = clone $this;
		$oClone->iVerticalPosition = $iVerticalPosition;

		return $oClone;
	}

	public function getHorizontalPosition(): int
	{
		return $this->iHorizontalPosition;
	}

	public function setHorizontalPosition(int $iHorizontalPosition): static
	{
		$oClone                      = clone $this;
		$oClone->iHorizontalPosition = $iHorizontalPosition;

		return $oClone;
	}

	public function getFontFile(): string
	{
		return $this->strFontFile;
	}

	public function setFontFile(string $strFontFile): static
	{
		static::ValidateFontFile($strFontFile);

		$oClone              = clone $this;
		$oClone->strFontFile = $strFontFile;

		return $oClone;
	}

	public function getSize(): int
	{
		return $this->iSize;
	}

	public function setSize(int $iSize): static
	{
		$oClone        = clone $this;
		$oClone->iSize = $iSize;

		return $oClone;
	}

	public function getAngle(): float
	{
		return $this->fAngle;
	}

	public function setAngle(float $fAngle): static
	{
		static::ValidateAngle($fAngle);

		$oClone         = clone $this;
		$oClone->fAngle = $fAngle;

		return $oClone;
	}

	public function getContent(): string
	{
		return $this->strContent;
	}

	public function setContent(string $strContent): static
	{
		$oClone             = clone $this;
		$oClone->strContent = $strContent;

		return $oClone;
	}

	public function getColor(): string
	{
		return $this->strColor;
	}

	public function setColor(string $strColor): static
	{
		$oClone           = clone $this;
		$oClone->strColor = $strColor;

		return $oClone;
	}

	public function getTransparency(): float
	{
		return $this->fTransparency;
	}

	public function setTransparency(float $fTransparency): static
	{
		static::ValidateTransparency($fTransparency);

		$oClone                = clone $this;
		$oClone->fTransparency = $fTransparency;

		return $oClone;
	}
}
