<?php
// Tool
$myVaccinesUtilities = new MyVaccinesUtilities();

// Get the current page context
$pageContext = $myVaccinesUtilities->getCurrentContext($_GET['context']);
?>
<!-- Top bar section -->
<?php
$title = __('Frequently Asked Questions');
$text = __('The FAQ has two categories: For everybody and specifically for professionals.');
require(CLIENTINC_DIR . 'page-header.inc.php');
?>
<div class="wrapper">
	<table class="table-center">
		<tr>
			<td>
				<img class="<?php echo ($pageContext == $myVaccinesUtilities::CONTEXT_PUBLIC) ? "" : "item-hidden"; ?>"
					 src="<?php echo ASSETS_PATH; ?>images/icons/faq_green.png">
				<img class="<?php echo ($pageContext == $myVaccinesUtilities::CONTEXT_PROFESSIONAL) ? "" : "item-hidden"; ?>"
					 src="<?php echo ASSETS_PATH; ?>images/icons/faq_blue.png">
			</td>
		</tr>
	</table>
</div>
<!-- Switch FAQ context For Everybody/For Professional -->
<div class="wrapper">
	<div class="container">
        <?php
        $categories = Category::objects()
            ->exclude(Q::any(array(
                'ispublic' => Category::VISIBILITY_PRIVATE,
                'faqs__ispublished' => FAQ::VISIBILITY_PRIVATE,
            )))
            ->annotate(array('faq_count' => SqlAggregate::COUNT('faqs')))
            ->filter(array('faq_count__gt' => 0));
        if ($categories->exists(true)) {
            ?>
			<table class="faq-table-tab">
				<tr>
					<td onclick="publicFAQChoice();"
						class="faq-tab <?php echo($pageContext === $myVaccinesUtilities::CONTEXT_PUBLIC ? "faq-public-choice-active" : "faq-choice-inactive") ?>">
                        <?php echo __('For everybody'); ?>
					</td>
					<td onclick="professionalFAQChoice();"
						class="faq-tab <?php echo($pageContext === $myVaccinesUtilities::CONTEXT_PROFESSIONAL ? "faq-professional-choice-active" : "faq-choice-inactive") ?>">
                        <?php echo __('For professionals'); ?>
					</td>
				</tr>
			</table>
            <?php
        } else {
            echo __('NO FAQs found');
        }
        ?>
	</div>
</div>
<!-- Search in FAQ form -->
<?php
include CLIENTINC_DIR . 'search-in-faq.inc.php';
?>
<div class="separator"></div>
<!-- FAQ categories -->
<div class="wrapper">
	<div class="container">
		<div class="column center">
            <?php
            $categoryPublic = $myVaccinesUtilities->getCategoriesForContext($categories, $myVaccinesUtilities::CONTEXT_PUBLIC);
            $categoryProfessional = $myVaccinesUtilities->getCategoriesForContext($categories, $myVaccinesUtilities::CONTEXT_PROFESSIONAL);
            ?>
			<!-- Create FAQ tables for all available categories -->
            <?php
            foreach ($myVaccinesUtilities->getAllowedContextArray() as $currentContext) {
                ?>
				<table
						id="<?php echo $currentContext . 'Categories' ?>"
						cellpadding="15"
						width="100%"
						class="<?php echo ($currentContext == $pageContext) ? "" : "item-hidden"; ?>">
                    <?php
                    $cpt = 0;
                    // Get the correct array for the current context
                    $currentCategory = ($currentContext == $myVaccinesUtilities::CONTEXT_PUBLIC ? $categoryPublic : $categoryProfessional);

                    // Loop over all categories
                    foreach ($currentCategory as $category) {
                        // Get the category data we need
                        $categoryId = $category['id'];
                        $categoryIcon = $category['icon'];
                        $categoryTitle = $category['title'];
                        $categoryTopicAmount = $category['amountTopic'];

                        // Begin of <tr>
                        if ($cpt % 2 == 0) {
                            echo '<tr>';
                        }
                        ?>
						<td class="faq-table-td">
							<img src="<?php echo ASSETS_PATH; ?>images/icons/<?php echo $categoryIcon . '.png' ?>">
						</td>
						<td>
                            <span class="faq-category-title">
								<?php
                                echo $categoryTitle . ' [' . $categoryTopicAmount . ']';
                                ?>
                            </span>
							<br>
							<br>
							<a href="faq.php?cid=<?php echo $categoryId . '&context=' . $pageContext ?>"
							   class="button-secondary button-small">
                                <?php echo __('Enter'); ?>
							</a>
						</td>
                        <?php
                        // End of <tr>
                        if ($cpt % 2 != 0) {
                            echo '</tr>';
                        }
                        $cpt++;
                    } ?>
				</table>
                <?php
            }
            ?>
		</div>
	</div>
</div>

