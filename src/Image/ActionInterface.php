<?php
namespace Xicrow\PhpImage\Image;

use Xicrow\PhpImage\ConfigInterface;

interface ActionInterface extends ConfigInterface
{
	public function getUID(): string;
}
