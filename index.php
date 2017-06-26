<?php
/*********************************************************************
 * index.php
 *
 * Helpdesk landing page. Please customize it to fit your needs.
 *
 * Peter Rotich <peter@osticket.com>
 * Copyright (c)  2006-2013 osTicket
 * http://www.osticket.com
 *
 * Released under the GNU General Public License WITHOUT ANY WARRANTY.
 * See LICENSE.TXT for details.
 *
 * vim: expandtab sw=4 ts=4 sts=4:
 **********************************************************************/
require('client.inc.php');
require_once INCLUDE_DIR . 'class.page.php';

$section = 'home';
require(CLIENTINC_DIR . 'header.custom.inc.php');
?>
<!-- Top bar section -->
<?php
$title = __('Welcome to the Support Center');
$text = __('Ticket enable');
require(CLIENTINC_DIR . 'page-header.inc.php');
?>
<!-- Search in FAQ form -->
<?php
include CLIENTINC_DIR . 'search-in-faq.inc.php';
?>
<div class="separator"></div>
<?php $BUTTONS = isset($BUTTONS) ? $BUTTONS : true; ?>
<!-- Button section -->
<div class="wrapper">
	<table class="table-center">
		<tr>
            <?php
            // Tools
            $faqUrl = 'kb/index.php';
            $newTicketUrl = 'open.php';
            $iQeySetUpUrl = 'iqey-setup/index.php';

            if ($propertyService->isIQeySetupDownloadPageEnable()) {
                ?>
				<td style="padding-bottom: 15px;">
					<a href="<?php echo $iQeySetUpUrl; ?>">
						<img src="<?php echo ASSETS_PATH; ?>images/icons/iqey_setup.png">
					</a>
				</td>
                <?php
            }
            if ($cfg->isKnowledgebaseEnabled()) {
                ?>
				<td style="padding-bottom: 15px;">
					<a href="<?php echo $faqUrl; ?>">
						<img src="<?php echo ASSETS_PATH; ?>images/icons/faq_blue.png">
					</a>
				</td>
                <?php
            }
            ?>
			<td style="padding-bottom: 15px;">
				<a href="<?php echo $newTicketUrl; ?>">
					<img src="<?php echo ASSETS_PATH; ?>images/icons/new_ticket.png">
				</a>
			</td>
		</tr>
		<tr>
            <?php if ($BUTTONS) { ?>
                <?php
                if ($cfg->getClientRegistrationMode() != 'disabled' || !$cfg->isClientLoginRequired()) {
                    if ($propertyService->isIQeySetupDownloadPageEnable()) {
                        ?>
						<td>
							<a href="<?php echo $iQeySetUpUrl ?>" class="button-secondary button-big">
                                <?php echo __('iQey Setup/Downloads'); ?>
							</a>
						</td>
                        <?php
                    }
                    if ($cfg->isKnowledgebaseEnabled()) {
                        ?>
						<td>
							<a href="<?php echo $faqUrl ?>" class="button-secondary button-big">
                                <?php echo __('FAQ'); ?>
							</a>
						</td>
                        <?php
                    }
                    ?>
					<td>
						<a href="<?php echo $newTicketUrl; ?>" class="button-secondary button-big">
                            <?php echo __('Create new request'); ?>
						</a>
					</td>
                <?php } ?>
            <?php } ?>
		</tr>
	</table>
</div>

<?php require(CLIENTINC_DIR . 'footer.custom.inc.php'); ?>
