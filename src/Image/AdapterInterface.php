<?php
namespace Xicrow\PhpImage\Image;

use Xicrow\PhpImage\Image\Exception\UnsupportedActionException;

/**
 * Interface AdapterInterface
 *
 * @package Xicrow\PhpImage\Image
 */
interface AdapterInterface
{
	public const MimeType_ImageGif = 'image/gif';
	public const MimeType_ImageJpg = 'image/jpeg';
	public const MimeType_ImagePng = 'image/png';

	/**
	 * Get list of supported actions
	 *
	 * @return string[]|ActionInterface[]
	 */
	public static function GetSupportedActions(): array;

	/**
	 * Constructor
	 *
	 * @param string $strImagePath
	 */
	public function __construct(string $strImagePath);

	/**
	 * Add a new action to the queue
	 *
	 * @param ActionInterface $oAction
	 * @param bool            $bFirst
	 * @return static
	 * @throws UnsupportedActionException If the given action is not supported by the current adapter
	 */
	public function addAction(ActionInterface $oAction, bool $bFirst = false): self;

	/**
	 * Add a list of actions to the queue
	 *
	 * @param ActionInterface[] $arrActions
	 * @param bool              $bFirst
	 * @return static
	 * @throws UnsupportedActionException If the given action is not supported by the current adapter
	 */
	public function addActions(array $arrActions, bool $bFirst = false): self;

	/**
	 * Remove actions from the queue, based on the given action UID
	 *
	 * @param ActionInterface $oAction
	 * @return static
	 */
	public function removeActionByUID(ActionInterface $oAction): self;

	/**
	 * Remove actions from the queue, based on the given action class name
	 *
	 * @param string|ActionInterface $strActionClass
	 * @return $this
	 */
	public function removeActionByClass(string $strActionClass): self;

	/**
	 * Get action queue
	 *
	 * @return ActionInterface[]
	 */
	public function getActionQueue(): array;

	/**
	 * Get hash of entire action queue
	 *
	 * @return string
	 */
	public function getActionQueueHash(): string;

	/**
	 * Process the action queue and save the image
	 *
	 * @param string $strFilePath
	 * @param int    $iQuality
	 * @return bool
	 */
	public function save(string $strFilePath, int $iQuality): bool;
}
