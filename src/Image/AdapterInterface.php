<?php
namespace Xicrow\PhpImage\Image;

use Xicrow\PhpImage\Image\Exception\UnsupportedActionException;

interface AdapterInterface
{
	public const MimeType_ImageGif = 'image/gif';
	public const MimeType_ImageJpg = 'image/jpeg';
	public const MimeType_ImagePng = 'image/png';

	/**
	 * @phpstan-return class-string<ActionInterface>[]
	 */
	public static function GetSupportedActions(): array;

	public function __construct(string $strImagePath);

	/**
	 * @throws UnsupportedActionException If the given action is not supported by the current adapter
	 */
	public function addAction(ActionInterface $oAction, bool $bFirst = false): static;

	/**
	 * @phpstan-param ActionInterface[] $arrActions
	 *
	 * @throws UnsupportedActionException If the given action is not supported by the current adapter
	 */
	public function addActions(array $arrActions, bool $bFirst = false): static;

	public function removeActionByUID(ActionInterface $oAction): static;

	/**
	 * @phpstan-param class-string<ActionInterface> $strActionClass
	 */
	public function removeActionByClass(string $strActionClass): static;

	/**
	 * @phpstan-return ActionInterface[]
	 */
	public function getActionQueue(): array;

	public function getActionQueueHash(): string;

	public function save(string $strFilePath, int $iQuality): bool;
}
