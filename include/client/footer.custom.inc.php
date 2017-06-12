<?php
// Compute the urls used in the footer
switch (Internationalization::getCurrentLanguage()) {
    case 'fr':
        $iqeyUrl = 'https://www.iqey.ch/fr/';
        break;
    case 'de':
        $iqeyUrl = 'https://www.iqey.ch/de/';
        break;
}
?>
<div class="footer">
	<table class="footer-table">
		<tr>
			<td style="text-align: center">
				<a href="<?php echo $iqeyUrl; ?>" target="_blank">
					www.iqey.ch
				</a>
			</td>
		</tr>
	</table>
</div>
</body>
</html>
