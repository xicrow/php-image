<?php
namespace Xicrow\PhpImage\Placeholder\Adapter;

use Xicrow\PhpImage\Placeholder\AdapterBase;

/**
 * Class PlaceholdersDev
 *
 * @package Xicrow\PhpImage\Placeholder\Adapter
 */
class PlaceholdersDev extends AdapterBase
{
	/**
	 * @inheritDoc
	 */
	public function getUrl(): string
	{
		$strUrl = $this->getCurrentUrlProtocol() . '://images.placeholders.dev/';
		if ($this->oPlaceholderConfig->getFileExtension() !== null) {
			$strUrl .= 'image.' . $this->oPlaceholderConfig->getFileExtension();
		}

		$arrQueryStringParts = [];
		if ($this->oPlaceholderConfig->getWidth() !== 0) {
			$arrQueryStringParts[] = 'width=' . $this->oPlaceholderConfig->getWidth();
		}
		if ($this->oPlaceholderConfig->getHeight() !== 0) {
			$arrQueryStringParts[] = 'height=' . $this->oPlaceholderConfig->getHeight();
		}
		if ($this->oPlaceholderConfig->getBackgroundColor() !== null) {
			$arrQueryStringParts[] = 'bgColor=' . urlencode($this->oPlaceholderConfig->getBackgroundColor());
		}
		if ($this->oPlaceholderConfig->getTextColor() !== null) {
			$arrQueryStringParts[] = 'textColor=' . urlencode($this->oPlaceholderConfig->getTextColor());
		}
		if ($this->oPlaceholderConfig->getText() !== null) {
			$arrQueryStringParts[] = 'text=' . urlencode($this->oPlaceholderConfig->getText());
		}

		if (count($arrQueryStringParts)) {
			$strUrl .= '?' . implode('&', $arrQueryStringParts);
		}

		return $strUrl;
	}
}
