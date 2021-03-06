<?php
/**
 * Index page where the iQey setup procedure is described.
 *
 * User: matthieu
 * Date: 14.06.17
 * Time: 16:49
 */

require_once('../client.inc.php');

// Disable the current active navbar because this page is not public (no option in the navbar should be active)
$nav->setActiveNav('none');

require(CLIENTINC_DIR . 'header.custom.inc.php');
require(CLIENTINC_DIR . 'footer.custom.inc.php');
?>
<!-- Top bar section -->
<?php
$title = __('CDM Smart Card Reader Setup');
$text = __('You can find here the installation files for your Smart Card Reader driver.');
require(CLIENTINC_DIR . 'page-header-aek.inc.php');
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
            <?php echo __('Download the installation files "CDM Smart Card Reader with iQey" for') ?>
		</h1>

		<!-- Windows 86 download logic -->
		<div class="flex-container-iqey-setup">
			<div class="flex-item-iqey-download">
				<img src="<?php echo ASSETS_PATH; ?>images/os_windows.png" style="width: 110px;">
				<br>
				<br>
                <?php
                if ($propertyService->isWindowsDownloadEnable(ConfigSectionEnum::AEK_SETUP)) {
                    ?>
					<span style="padding-right: 3px;">
						<a href="<?php echo $propertyService->getWindowsDownloadUrl(ConfigSectionEnum::AEK_SETUP, Internationalization::getCurrentLanguage()) ?>"
						   class="button-secondary disabled button-small download-link" for="win 32"
						   target="_blank">
                        	<?php echo __('x86'); ?>
						</a>
					</span>
                    <?php
                } else { ?>
					<span style="padding-right: 3px;">
						<span class="button-secondary disabled button-small">
							<?php echo __('iQey download no available'); ?>
						</span>
					</span>

                    <?php
                } ?>

				<!-- Windows 86_64 download logic -->
                <?php
                if ($propertyService->isWindows64DownloadEnable(ConfigSectionEnum::AEK_SETUP)) {
                    ?>
					<span style="padding-right: 3px;">
						<a href="<?php echo $propertyService->getWindows64DownloadUrl(ConfigSectionEnum::AEK_SETUP, Internationalization::getCurrentLanguage()) ?>"
						   class="button-secondary disabled button-small download-link" for="win 64"
						   target="_blank">
                        	<?php echo __('x86_64'); ?>
						</a>
					</span>
                    <?php
                } else { ?>
					<span style="padding-left: 3px;">
						<span class="button-secondary disabled button-small">
							<?php echo __('iQey download no available'); ?>
						</span>
					</span>
                    <?php
                } ?>
			</div>

			<!-- macOS download logic -->
			<div class="flex-item-iqey-download">
				<img src="<?php echo ASSETS_PATH; ?>images/os_mac.jpg" style="width: 97px;">
				<br>
				<br>
                <?php
                if ($propertyService->isMacDownloadEnable(ConfigSectionEnum::AEK_SETUP)) {
                    ?>
					<a href="<?php echo $propertyService->getMacDownloadUrl(ConfigSectionEnum::AEK_SETUP, Internationalization::getCurrentLanguage()) ?>"
					   class="button-secondary disabled button-small download-link" for="mac"
					   target="_blank">
						macOS
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
        <?php
        echo __('This software is available for the Caisse des Médecins members.<br> He is compatible with the readers supported by the Caisse des médecins');
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
					if (get_bits_system_architecture() === 64) {
						if (downloadlinks[i].getAttribute("for").includes("64")) {
							downloadlinks[i].className = "button-secondary button-small download-link";
						}
					} else {
						if (downloadlinks[i].getAttribute("for").includes("32")) {
							downloadlinks[i].className = "button-secondary button-small download-link";
						}
					}
				}
			}
		}
	}
</script>

