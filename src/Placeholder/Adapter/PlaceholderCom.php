<?php
namespace Xicrow\PhpImage\Placeholder\Adapter;

use Xicrow\PhpImage\Placeholder\AdapterBase;
use Xicrow\PhpImage\Placeholder\Exception\InvalidConfigurationException;
use Xicrow\PhpImage\Placeholder\PlaceholderConfig;

class PlaceholderCom extends AdapterBase
{
	private const ValidFileExtensions = ['gif', 'jpg', 'jpeg', 'png', 'webp'];

	public static function ValidateConfig(PlaceholderConfig $oPlaceholderConfig): void
	{
		if ($oPlaceholderConfig->getWidth() === 0) {
			throw new InvalidConfigurationException('Width must be set');
		}

		if ($oPlaceholderConfig->getBackgroundColor() === null && $oPlaceholderConfig->getTextColor() !== null) {
			throw new InvalidConfigurationException('Background color must be set, if text color is set');
		}

		if ($oPlaceholderConfig->getFileExtension() !== null && !in_array($oPlaceholderConfig->getFileExtension(), self::ValidFileExtensions, true)) {
			throw new InvalidConfigurationException('Invalid file extension given "' . $oPlaceholderConfig->getFileExtension() . '", valid options are: ' . implode(', ', self::ValidFileExtensions));
		}
	}

	public function getUrl(): string
	{
		$arrUrlParts = [
			$this->getCurrentUrlProtocol(),
			'://via.placeholder.com',
			'/' . $this->oPlaceholderConfig->getWidth(),
		];
		if ($this->oPlaceholderConfig->getHeight() !== 0) {
			$arrUrlParts[] = 'x' . $this->oPlaceholderConfig->getHeight();
		}
		if ($this->oPlaceholderConfig->getBackgroundColor() !== null) {
			$arrUrlParts[] = '/' . ltrim($this->oPlaceholderConfig->getBackgroundColor(), '#');
		}
		if ($this->oPlaceholderConfig->getTextColor() !== null) {
			$arrUrlParts[] = '/' . ltrim($this->oPlaceholderConfig->getTextColor(), '#');
		}
		if ($this->oPlaceholderConfig->getFileExtension() !== null) {
			$arrUrlParts[] = '.' . $this->oPlaceholderConfig->getFileExtension();
		}
		if ($this->oPlaceholderConfig->getText() !== null) {
			$arrUrlParts[] = '?text=' . urlencode($this->oPlaceholderConfig->getText());
		}

		return implode('', $arrUrlParts);
	}
}
