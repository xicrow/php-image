<?php
namespace Xicrow\PhpImage\Image;

use Xicrow\PhpImage\ConfigInterface;

/**
 * Interface ActionInterface
 *
 * @package Xicrow\PhpImage\Image
 */
interface ActionInterface extends ConfigInterface
{
	/**
	 * Get unique identifier for this specific action including any configuration or options
	 *
	 * @return string
	 */
	public function getUID(): string;
}
