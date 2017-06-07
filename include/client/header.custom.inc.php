<?php
// Get the current page context
$pageContext = $myVaccinesUtilities->getCurrentContext($_GET['context']);

$title = ($cfg && is_object($cfg) && $cfg->getTitle())
    ? $cfg->getTitle() : 'osTicket :: ' . __('Support Ticket System');
$signin_url = ROOT_PATH . "login.php"
    . ($thisclient ? "?e=" . urlencode($thisclient->getEmail()) : "");
$signout_url = ROOT_PATH . "logout.php?auth=" . $ost->getLinkToken() . '&context=' . $pageContext;

header("Content-Type: text/html; charset=UTF-8");
if (($lang = Internationalization::getCurrentLanguage())) {
    $langs = array_unique(array($lang, $cfg->getPrimaryLanguage()));
    $langs = Internationalization::rfc1766($langs);
    header("Content-Language: " . implode(', ', $langs));
}
?>
<!DOCTYPE html>
<html<?php
if ($lang
    && ($info = Internationalization::getLanguageInfo($lang))
    && (@$info['direction'] == 'rtl')
)
    echo ' dir="rtl" class="rtl"';
if ($lang) {
    echo ' lang="' . $lang . '"';
}
?>>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="description" content="customer support platform">
		<meta name="keywords" content="osTicket, Customer support system, support ticket system">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo Format::htmlchars($title); ?></title>

		<link type="text/css" rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/iqey.css">

		<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.10.3.custom.min.js"></script>
		<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/osticket.js"></script>
		<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js"></script>
		<script type="text/javascript" src="<?php echo ROOT_PATH; ?>scp/js/bootstrap-typeahead.js"></script>
		<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js"></script>
		<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-plugins.js"></script>
		<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js"></script>
		<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/select2.min.js"></script>
		<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/fabric.min.js"></script>
		<script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/custom-functions.js"></script>

        <?php
        if ($ost && ($headers = $ost->getExtraHeaders())) {
            echo "\n\t" . implode("\n\t", $headers) . "\n";
        }

        // Offer alternate links for search engines
        // @see https://support.google.com/webmasters/answer/189077?hl=en
        if (($all_langs = Internationalization::getConfiguredSystemLanguages())
            && (count($all_langs) > 1)
        ) {
            $langs = Internationalization::rfc1766(array_keys($all_langs));
            $qs = array();
            parse_str($_SERVER['QUERY_STRING'], $qs);
            foreach ($langs as $L) {
                $qs['lang'] = $L; ?>
				<link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>?<?php
                echo http_build_query($qs); ?>" hreflang="<?php echo $L; ?>"/>
                <?php
            } ?>
			<link rel="alternate" href="//<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
				  hreflang="x-default"/>
            <?php
        }
        ?>
	</head>
	<body>
		<!-- The languages -->
		<div class="wrapper">
			<div class="container">
				<div class="languages-bar">
					<div class="languages">
                        <?php
                        if (($all_langs = Internationalization::getConfiguredSystemLanguages()) && (count($all_langs) > 1)) {
                            $qs = array();
                            parse_str($_SERVER['QUERY_STRING'], $qs);
                            $cpt = 0;
                            foreach ($all_langs as $code => $info) {
                                $cpt++;
                                list($lang, $locale) = explode('_', $code);
                                $qs['lang'] = $code;
                                // Remove the next IF line when we have all languages
                                if ($code != 'en_US' && $code != 'it') {
                                    ?>
									<a class="<?php
                                    if ($code == Internationalization::getCurrentLanguage()) {
                                        echo 'selected';
                                    }
                                    ?>"
									   href="?<?php echo http_build_query($qs); ?>">
                                        <?php
                                        if ($code == 'en_US') {
                                            echo 'EN';
                                        } else {
                                            echo strtoupper($code);
                                        }
                                        ?>
									</a>
                                    <?php
                                    // Activate the next IF line when we have all languages
//                                    if ($cpt < count($all_langs)) {
                                    if ($cpt <= 2) {
                                        echo '&nbsp;|&nbsp;';
                                    }
                                    ?>
                                <?php }
                            }
                        } ?>
                        <?php
                        if ($thisclient && $thisclient->isValid() && $thisclient->isGuest()) {
                            ?>
							<br>
							<a href="<?php echo $signout_url; ?>">
                                <?php echo __('Sign Out'); ?>
							</a>
                            <?php
                        } ?>
					</div>
				</div>
				<div class="titleBar">
					<table style="width:100%;">
						<tr>
							<td valign="top" style="text-align:center; border-right:1px solid #eee; width: 190px; padding: 10px 10px 10px 0">
								<a href="<?php echo ROOT_PATH . 'index.php' ?>">
									<img src="<?php echo ASSETS_PATH; ?>images/iqey_logo.jpg" width="179" height="65" alt="iqey">
								</a>
							</td>
							<td>

							</td>
						</tr>
					</table>
				</div>
				<br>
				<div class="clear"></div>
			</div>
		</div>
		<!-- The navigation bar -->
		<div class="wrapper items">
			<div class="container">
                <?php
                if ($nav && ($navs = $nav->getNavLinks()) && is_array($navs)) {
                    foreach ($navs as $name => $nav) {
                        if ($name != 'status') {
                            if ($name == 'tickets') {
                                $contextParam = '&context=';
                            } else {
                                $contextParam = '?context=';
                            }
                            echo sprintf('<div class="%s"><a href="%s">%s</a></div>',
                                $nav['active'] ? 'item on' : 'item',
                                (ROOT_PATH . $nav['href']) . $contextParam . $pageContext,
                                $nav['desc']);
                        }
                    }
                } ?>
			</div>
			<div class="clear"></div>
		</div>
