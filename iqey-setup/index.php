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
<!-- Setup section -->
<div class="wrapper">
	<div class="container">
		Setup section
	</div>
</div>
<!-- Download section -->
<div class="wrapper">
	<div class="container">
		Download section
	</div>
</div>
