<?php
use Xicrow\PhpImage\Placeholder\Adapter\PlaceholderCom;
use Xicrow\PhpImage\Placeholder\Adapter\PlaceholdersDev;
use Xicrow\PhpImage\Placeholder\AdapterInterface;
use Xicrow\PhpImage\Placeholder\PlaceholderConfig;

require_once('../vendor/autoload.php');

ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_errors', 1);
ini_set('html_errors', 1);
ini_set('log_errors', 0);

// Placeholder settings
/** @var PlaceholderConfig[] $arrPlaceholderConfigs */
$arrPlaceholderConfigs = [
	new PlaceholderConfig(350, 150),
	new PlaceholderConfig(350, 150, 'Placeholder'),
	new PlaceholderConfig(350, 150, 'Placeholder', '#CCCCCC', '#333333'),
	new PlaceholderConfig(350, 150, 'Placeholder', '#CCCCCC', '#333333', 'jpg'),
];
/** @var AdapterInterface[]|string[] $arrPlaceholderAdapterClasses */
$arrPlaceholderAdapterClasses = [
	PlaceholderCom::class,
	PlaceholdersDev::class,
];
?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Xicrow/PhpImage - Placeholder demo</title>
		<style>
			body {
				font-family: Verdana, sans-serif;
				font-size: 15px;
			}
			table {
				margin: 5px 0;
				font-size: inherit;
				border-top: 1px solid #CCC;
				border-right: 1px solid #CCC;
				border-collapse: collapse;
			}
			table tr th {
				padding: 5px;
				font-size: inherit;
				text-align: left;
				vertical-align: middle;
				border-bottom: 1px solid #CCC;
				border-left: 1px solid #CCC;
			}
			table tr td {
				padding: 5px;
				font-size: inherit;
				text-align: left;
				vertical-align: middle;
				border-bottom: 1px solid #CCC;
				border-left: 1px solid #CCC;
			}
		</style>
	</head>

	<body>
		<?php
		foreach ($arrPlaceholderAdapterClasses as $strPlaceholderAdapterClass) {
			echo '<div style="margin: 10px; padding: 10px; background: #EEE; border: 1px solid #CCC;">';
			echo '<strong>' . $strPlaceholderAdapterClass . '</strong>';

			foreach ($arrPlaceholderConfigs as $oPlaceholderConfig) {
				try {
					echo '<pre>' . $oPlaceholderConfig->toJson() . '</pre>';

					$oPlaceholderAdapter = new $strPlaceholderAdapterClass($oPlaceholderConfig);

					echo '<pre>' . $oPlaceholderAdapter->getUrl() . '</pre>';
					echo '<img src="' . $oPlaceholderAdapter->getUrl() . '" alt="" />';
				} catch (Throwable $oException) {
					echo '<pre>' . get_class($oException) . '</pre>';
					echo '<pre>' . $oException->getMessage() . '</pre>';
				}
			}

			echo '</div>';
		}
		?>
	</body>
</html>
