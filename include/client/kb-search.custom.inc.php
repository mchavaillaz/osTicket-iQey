<?php
// Get the current page context
$pageContext = $myVaccinesUtilities->getCurrentContext($_GET['context']);
?>
<!-- Top bar section -->
<?php
$title = __('Frequently Asked Questions');
$text = __('The FAQ has two categories: For everybody and specifically for professionals.');
require(CLIENTINC_DIR . 'page-header.inc.php');
?>
<!-- Search in FAQ form -->
<?php
include CLIENTINC_DIR . 'search-in-faq.inc.php';
?>
<div class="separator"></div>
<div class="wrapper">
	<div class="container">
		<div class="column center">
			<h1>
                <?php echo __('Search Results'); ?>
			</h1>
            <?php
            if ($faqs->exists(true)) {
                // Filter the FAQs according to the context
                $faqsForContext = $myVaccinesUtilities->getFAQForContext($faqs, $pageContext);
                echo '<div>'
                    . sprintf(
                        __('%d FAQs matched your search criteria.'),
                        count($faqsForContext))
                    . '<ol>';
                foreach ($faqsForContext as $F) {
                    echo sprintf(
                        '<li class="faq-search-result"><a href="faq.php?id=%d&context=%s" class="previewfaq">%s</a></li>',
                        $F->getId(),
                        $pageContext,
                        $F->getLocalQuestion(),
                        $F->getVisibilityDescription());
                }
                echo '</ol></div>';
            } else {
                echo '<strong>' . __('The search did not match any FAQs.') . '</strong>';
            }
            ?>
		</div>
	</div>
</div>
