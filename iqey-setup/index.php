<?php
/**
 * Index page where the iQey setup procedure is described.
 *
 * User: matthieu
 * Date: 14.06.17
 * Time: 16:49
 */

require_once('../client.inc.php');

// Set the active navbar to iqey-setup
$nav->setActiveNav('iqey-setup');

require(CLIENTINC_DIR . 'header.custom.inc.php');
require(CLIENTINC_DIR . 'footer.custom.inc.php');
?>
<!-- Top bar section -->
<?php
$title = __('iQey Setup');
$text = __('This page contains the setup steps for the iQey');
require(CLIENTINC_DIR . 'page-header.inc.php');
?>
<!-- Icon section -->
<div class="wrapper">
	<table class="table-center">
		<tr>
			<td>
				<img src="<?php echo ASSETS_PATH; ?>images/icons/iqey_setup.png">
			</td>
		</tr>
	</table>
</div>
<div class="separator"></div>
<!-- Download section -->
<div class="wrapper">
	<div class="container center">
		<h1>
            <?php echo __('iQey download package') ?>
		</h1>
		<div class="flex-container-iqey-setup">
			<div class="flex-item-iqey-download">
				<img src="<?php echo ASSETS_PATH; ?>images/os_windows.png" style="width: 110px;">
				<br>
				<br>
                <?php
                if ($propertyService->isWindowsDownloadEnable(ConfigSectionEnum::IQEY_SETUP)) {
                    ?>
					<a href="<?php echo $propertyService->getWindowsDownloadUrl(ConfigSectionEnum::IQEY_SETUP, Internationalization::getCurrentLanguage()) ?>"
					   class="button-secondary disabled button-small download-link"
					   target="_blank"
					   for="win">
                        <?php echo __('Download'); ?>
					</a>
                    <?php
                } else {
                    ?>
					<span class="button-secondary disabled button-small">
						<?php echo __('iQey download no available'); ?>
					</span>
                    <?php
                }
                ?>
			</div>
			<div class="flex-item-iqey-download">
				<img src="<?php echo ASSETS_PATH; ?>images/os_mac.jpg" style="width: 97px;">
				<br>
				<br>
                <?php
                if ($propertyService->isMacDownloadEnable(ConfigSectionEnum::IQEY_SETUP)) {
                    ?>
					<a href="<?php echo $propertyService->getMacDownloadUrl(ConfigSectionEnum::IQEY_SETUP, Internationalization::getCurrentLanguage()) ?>"
					   class="button-secondary disabled button-small download-link"
					   target="_blank"
					   for="mac">
                        <?php echo __('Download'); ?>
					</a>
                    <?php
                } else {
                    ?>
					<span class="button-secondary disabled button-small">
						<?php echo __('iQey download no available'); ?>
					</span>
                    <?php
                }
                ?>
			</div>
		</div>
	</div>
</div>
<br>
<!-- Setup section -->
<div class="wrapper">
	<div class="container center">
		<h1>
            <?php echo __('iQey-Setup'); ?>
		</h1>
		<div class="iqey-setup-manual">
            <?php
            echo sprintf(__('iQey-Setup installation manual'), $propertyService->getIQeySetupManualUrl(Internationalization::getCurrentLanguage()));
            ?>
			<br>
			<br>
			<p style="font-style: italic;">
                <?php
                echo __('Supported platform: Windows 7, 8 and 10, macOS 10.12 (Sierra) and higher');
                ?>
			</p>
		</div>
	</div>
</div>
<br>
<br>
<script>
	window.onload = function () {
		var downloadlinks = document.querySelectorAll('.download-link');
		for (i in downloadlinks) {
			if ('undefined' !== typeof downloadlinks[i].getAttribute) {
				if (is_macos()) {
					if (downloadlinks[i].getAttribute("for").includes("mac")) {
						downloadlinks[i].className = "button-secondary button-small download-link";
					}
				}
				else {
					if (downloadlinks[i].getAttribute("for").includes("win")) {
						downloadlinks[i].className = "button-secondary button-small download-link";
					}
				}
			}
		}
	}
</script>

