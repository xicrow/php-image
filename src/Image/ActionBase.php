<?php
namespace Xicrow\PhpImage\Image;

use JsonException;
use Xicrow\PhpImage\ConfigBase;

abstract class ActionBase extends ConfigBase implements ActionInterface
{
	/**
	 * @throws JsonException
	 */
	public function getUID(): string
	{
		return static::class . '(' . $this->toJson() . ')';
	}
}
