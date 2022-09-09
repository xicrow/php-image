<?php
namespace Xicrow\PhpImage\Image;

use JsonException;
use Xicrow\PhpImage\ConfigBase;

/**
 * Class ActionBase
 *
 * @package Xicrow\PhpImage\Image
 */
abstract class ActionBase extends ConfigBase implements ActionInterface
{
	/**
	 * @inheritDoc
	 * @throws JsonException
	 */
	public function getUID(): string
	{
		return static::class . '(' . $this->toJson() . ')';
	}
}
