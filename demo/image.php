<?php
use Xicrow\PhpImage\Image\Action\FilterBrighten;
use Xicrow\PhpImage\Image\Action\FilterColorize;
use Xicrow\PhpImage\Image\Action\FilterDarken;
use Xicrow\PhpImage\Image\Action\FilterGaussianBlur;
use Xicrow\PhpImage\Image\Action\FilterGreyScale;
use Xicrow\PhpImage\Image\Action\FilterPixelate;
use Xicrow\PhpImage\Image\Action\DrawLine;
use Xicrow\PhpImage\Image\Action\DrawRectangle;
use Xicrow\PhpImage\Image\Action\DrawText;
use Xicrow\PhpImage\Image\Action\ResizeCrop;
use Xicrow\PhpImage\Image\Action\ResizeFit;
use Xicrow\PhpImage\Image\ActionInterface;
use Xicrow\PhpImage\Image\Adapter\GDLibrary;
use Xicrow\PhpImage\Image\AdapterInterface;
use Xicrow\PhpImage\Image\Exception\UnsupportedActionException;

require_once('../vendor/autoload.php');

ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 1);
ini_set('html_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'errors.log');

// Set memory and time limit, since image handling can get heavy...
ini_set('memory_limit', '1G');
set_time_limit(300);

// Always regenerate images ?
$bAlwaysRegenerate = false;

// Get list of images to work with from the images folder
$arrImages = [];
$oRDI      = new RecursiveDirectoryIterator('./webroot/images', FilesystemIterator::SKIP_DOTS);
$oRII      = new RecursiveIteratorIterator($oRDI);
foreach ($oRII as $oSplFileInfo) {
	/** @var SplFileInfo $oSplFileInfo */

	if (!$oSplFileInfo->isFile()) {
		continue;
	}

	if ($oSplFileInfo->getFilename() === 'empty') {
		continue;
	}

	$arrImages[] = str_replace([__DIR__, DIRECTORY_SEPARATOR], ['.', '/'], $oSplFileInfo->getRealPath());
}
usort($arrImages, static function (string $strPathA, string $strPathB): int {
	$iPathASeparators = substr_count($strPathA, '/');
	$iPathBSeparators = substr_count($strPathB, '/');

	if ($iPathASeparators > $iPathBSeparators) {
		return -1;
	}

	if ($iPathASeparators < $iPathBSeparators) {
		return 1;
	}

	return strcasecmp($strPathA, $strPathB);
});

/**
 * Adapters
 *
 * @var AdapterInterface[]|string[] $arrAdapterClasses
 */
$arrAdapterClasses = [
	GDLibrary::class,
];

/**
 * Sample transformations
 *
 * @var ActionInterface[][] $arrTransformations
 */
$arrTransformations = [
	// Simple filters
	'FilterBrighten'      => [new FilterBrighten(50)],
	'FilterDarken'        => [new FilterDarken(50)],
	'FilterGreyScale'     => [new FilterGreyScale()],
	'FilterColorizeRed'   => [new FilterColorize(50)],
	'FilterColorizeGreen' => [new FilterColorize(0, 50)],
	'FilterColorizeBlue'  => [new FilterColorize(0, 0, 50)],
	'FilterPixelate'      => [new FilterPixelate(10)],
	// Simple resizing
	'ResizeCrop'          => [new ResizeCrop(250, 250, true)],
	'ResizeFit'           => [new ResizeFit(250, 250, true, false)],
	// Multiple actions
	// "Badge"
	'Badge'               => [
		new ResizeCrop(250, 250, true, ResizeCrop::Vertical_Align_Top),
		new DrawRectangle(0, 0, 250, 40, '#FFFFFF', 50),
		new DrawText(100, 25, __DIR__ . '/webroot/fonts/arial.ttf', 15, 0, 'Badge', '#333333', 10),
	],
	// "Frame"
	'Frame'               => static function (): array {
		$iImageWidth       = 250;
		$iImageHeight      = 250;
		$iFrameWidth       = 10;
		$strRectangleColor = '#FFF';
		$iRectangleOpacity = 50;
		$strLineColor      = '#FFF';
		$iLineOpacity      = 50;

		return [
			new ResizeCrop($iImageWidth, $iImageHeight, true, ResizeCrop::Vertical_Align_Middle, ResizeCrop::Horizontal_Align_Center),
			new DrawRectangle(0, 0, $iImageWidth, $iFrameWidth, $strRectangleColor, $iRectangleOpacity),
			new DrawRectangle($iImageWidth - $iFrameWidth, $iFrameWidth + 1, $iFrameWidth, $iImageHeight - $iFrameWidth - $iFrameWidth - 2, $strRectangleColor, $iRectangleOpacity),
			new DrawRectangle(0, $iImageHeight - $iFrameWidth, $iImageWidth, $iFrameWidth, $strRectangleColor, $iRectangleOpacity),
			new DrawRectangle(0, $iFrameWidth + 1, $iFrameWidth, $iImageHeight - $iFrameWidth - $iFrameWidth - 2, $strRectangleColor, $iRectangleOpacity),
			new DrawLine($iFrameWidth, $iFrameWidth, $iImageWidth - $iFrameWidth, $iFrameWidth, $strLineColor, $iLineOpacity),
			new DrawLine($iImageWidth - $iFrameWidth, $iFrameWidth, $iImageWidth - $iFrameWidth, $iImageHeight - $iFrameWidth, $strLineColor, $iLineOpacity),
			new DrawLine($iImageWidth - $iFrameWidth, $iImageHeight - $iFrameWidth, $iFrameWidth, $iImageHeight - $iFrameWidth, $strLineColor, $iLineOpacity),
			new DrawLine($iFrameWidth, $iImageHeight - $iFrameWidth, $iFrameWidth, $iFrameWidth, $strLineColor, $iLineOpacity),
		];
	},
	// "Blurry"
	'Blurry'              => static function (): array {
		$iMultiplier = 50;

		$arrActions = [
			new ResizeCrop(250, 250, true),
			new FilterPixelate(5, true),
		];
		for ($iLoop = 1; $iLoop <= $iMultiplier; $iLoop++) {
			$arrActions[] = new FilterGaussianBlur();
		}

		return $arrActions;
	},
];
?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Xicrow/PhpImage - Image demo</title>
		<style>
			body {
				margin: 0;
				padding: 0;
				font-family: Verdana, sans-serif;
				font-size: 15px;
			}
			pre {
				margin: 0 0 10px 0;
			}
			.image-container {
				margin: 0 0 50px 0;
				background: #EEE;
			}
			.image-with-details {
				padding: 10px;
				border-top: 1px solid #CCC;
				display: grid;
				grid-template-columns: 250px 1fr;
				grid-column-gap: 10px;
			}
			.image-with-details img {
				max-width: 250px;
				height: auto;
			}
			.main-image {
				background-color: #DDD;
				border-top: 0;
			}
		</style>
	</head>

	<body>
		<?php
		foreach ($arrAdapterClasses as $strAdapterClass) {
			foreach ($arrImages as $strImagePath) {
				echo '<div class="image-container">';

				try {
					if (substr($strImagePath, 0, 4) === 'http') {
						throw new RuntimeException('Remote images not supported: ' . $strImagePath);
					}

					$arrImageSize = getimagesize($strImagePath);
					$strImageMime = mime_content_type($strImagePath);
					$iImageSize   = filesize($strImagePath);
					$strImageInfo = implode(' - ', [
						'MIME type: ' . $strImageMime,
						$arrImageSize[0] . 'x' . $arrImageSize[1] . 'px',
						number_format($iImageSize) . ' bytes',
					]);

					echo <<<HTML
					<div class="image-with-details main-image">
					<img src="{$strImagePath}" alt="" />
					<pre>
					Image   : <a href="{$strImagePath}">{$strImagePath}</a>
					Details : {$strImageInfo}
					</pre>
					</div>
					HTML;

					foreach ($arrTransformations as $strTransformationName => $arrTransformationActions) {
						if (is_callable($arrTransformationActions)) {
							$arrTransformationActions = $arrTransformationActions();
						}

						if (count($arrTransformationActions) === 0) {
							continue;
						}

						$oAdapter = new $strAdapterClass($strImagePath);

						try {
							$oAdapter->addActions($arrTransformationActions);
						} catch (UnsupportedActionException $oException) {
							$strExceptionClass = get_class($oException);

							echo '<div class="image-with-details">';
							echo '<div></div>';
							echo '<div>';
							echo '<strong>' . $strTransformationName . '</strong><br />';
							echo '<strong>Exception caught</strong>';
							echo '<pre>';
							echo 'Class  : ' . get_class($oException) . "\n";
							echo 'Message: ' . $oException->getMessage() . "\n";
							echo 'File   : ' . $oException->getFile() . ':' . $oException->getLine() . "\n";
							echo '</pre>';
							echo '</div>';
							echo '</div>';

							continue;
						}

						$strImageFolderName         = pathinfo($strImagePath, PATHINFO_DIRNAME);
						$strImageFileName           = pathinfo($strImagePath, PATHINFO_FILENAME);
						$strImageFileExtension      = pathinfo($strImagePath, PATHINFO_EXTENSION);
						$arrProcessedImagePathParts = [
							'./webroot/processed/',
							str_replace('./webroot/images/', '', $strImageFolderName),
							'/' . $strImageFileName,
							'-' . $oAdapter->getActionQueueHash(),
							'.' . $strImageFileExtension,
						];
						$strProcessedImagePath      = implode('', $arrProcessedImagePathParts);

						$strDebugOutput = '';
						if ($bAlwaysRegenerate || !file_exists($strProcessedImagePath)) {
							ob_start();
							$oAdapter->save($strProcessedImagePath, 90);
							$strDebugOutput = ob_get_clean();
						}

						$strProcessedImageUrl = $strProcessedImagePath . '?time=' . filemtime($strProcessedImagePath);

						$arrProcessedImageSize = getimagesize($strProcessedImagePath);
						$strProcessedImageMime = mime_content_type($strProcessedImagePath);
						$iProcessedImageSize   = filesize($strProcessedImagePath);
						$strProcessedImageInfo = implode(' - ', [
							'MIME type: ' . $strProcessedImageMime,
							$arrProcessedImageSize[0] . 'x' . $arrProcessedImageSize[1] . 'px',
							number_format($iProcessedImageSize) . ' bytes',
							round((1 - ($iProcessedImageSize / $iImageSize)) * 100, 2) . '% reduction',
						]);

						$strTransformationActionsJson = '';
						foreach ($arrTransformationActions as $oAction) {
							$strTransformationActionsJson .= "\n" . get_class($oAction) . ': ' . $oAction->toJson();
						}
						$strTransformationActionsJson = trim($strTransformationActionsJson);

						echo <<<HTML
						<div class="image-with-details">
						<div>
							<img src="{$strProcessedImageUrl}" alt="" />
						</div>
						<div>
							<strong>{$strTransformationName}</strong>
						<pre>
						Image   : <a href="{$strProcessedImageUrl}">{$strProcessedImageUrl}</a>
						Details : {$strProcessedImageInfo}
						
						Actions:
						{$strTransformationActionsJson}
						{$strDebugOutput}
						</pre>
							</div>
						</div>
						HTML;
					}
				} catch (Throwable $oException) {
					echo '<div class="image-with-details">';
					echo '<div></div>';
					echo '<div>';
					echo '<strong>' . $strTransformationName . '</strong><br />';
					echo '<strong>Exception caught</strong>';
					echo '<pre>';
					echo 'Class  : ' . get_class($oException) . "\n";
					echo 'Message: ' . $oException->getMessage() . "\n";
					echo 'File   : ' . $oException->getFile() . ':' . $oException->getLine() . "\n";
					echo '</pre>';
					echo '</div>';
					echo '</div>';
				}

				echo '</div>';
			}
		}
		?>
	</body>
</html>
