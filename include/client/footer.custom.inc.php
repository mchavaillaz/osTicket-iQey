<?php
// Tool
$myVaccinesUtilities = new MyVaccinesUtilities();

// Get the current page context
$pageContext = $myVaccinesUtilities->getCurrentContext($_GET['context']);

// Compute the urls used in the footer
$protocol = 'https://';
$aboutPage = '/about.html';
$specialistPage = '/specialist-login.html';
switch (Internationalization::getCurrentLanguage()) {
    case 'en_US':
        $myvaccinesUrl = 'www.myvaccines.ch';
        $myvaccinesUrlFull = $protocol . $myvaccinesUrl . ($pageContext == $myVaccinesUtilities::CONTEXT_PROFESSIONAL? $specialistPage : '');
		$myvaccinesAboutUrlFull = $myvaccinesUrlFull . $aboutPage . '?locale=en_US';
        break;
    case 'fr':
        $myvaccinesUrl = 'www.mesvaccins.ch';
        $myvaccinesUrlFull = $protocol . $myvaccinesUrl . ($pageContext == $myVaccinesUtilities::CONTEXT_PROFESSIONAL? $specialistPage : '');
        $myvaccinesAboutUrlFull = $myvaccinesUrlFull . $aboutPage . '?locale=fr';
        break;
    case 'de':
        $myvaccinesUrl = 'www.meineimpfungen.ch';
        $myvaccinesUrlFull = $protocol . $myvaccinesUrl . ($pageContext == $myVaccinesUtilities::CONTEXT_PROFESSIONAL? $specialistPage : '');
        $myvaccinesAboutUrlFull = $myvaccinesUrlFull . $aboutPage . '?locale=de';
        break;
    case 'it':
        $myvaccinesUrl = 'www.lemievaccinazioni.ch';
        $myvaccinesUrlFull = $protocol . $myvaccinesUrl . ($pageContext == $myVaccinesUtilities::CONTEXT_PROFESSIONAL? $specialistPage : '');
        $myvaccinesAboutUrlFull = $myvaccinesUrlFull . $aboutPage . '?locale=it';
        break;
}
?>
<div class="footer">
	<table class="footer-table">
		<tr>
			<td class="footer-table-sides"></td>
			<td class="footer-table-how-we-are">
				<a href="<?php echo $myvaccinesAboutUrlFull; ?>" target="_blank">
                    <?php echo __('Who we are?') ?>
				</a>
			</td>
			<td>
				<a href="<?php echo $myvaccinesUrlFull; ?>" target="_blank">
                    <?php echo $myvaccinesUrl; ?>
				</a>
			</td>
			<td class="footer-table-sides"></td>
		</tr>
	</table>
</div>
</body>
</html>
