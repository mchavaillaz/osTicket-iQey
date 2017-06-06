<?php
// Get the current page context
$pageContext = $myVaccinesUtilities->getCurrentContext($_GET['context']);

if (!defined('OSTCLIENTINC') || !$faq || !$faq->isPublished()) die('Access Denied');
$category = $faq->getCategory();
?>
<!-- Top bar section -->
<?php
$title = __('Frequently Asked Questions');
$text = __('The FAQ has two categories: For everybody and specifically for professionals.');
require(CLIENTINC_DIR . 'page-header.inc.php');
?>
<!-- Breadcrumbs section -->
<div class="wrapper items">
	<div class="container">
		<div class="column center">
			<div class="breadcrumbs">
				<a href="index.php<?php echo '?context=' . $pageContext; ?>">
                    <?php echo __('All Categories'); ?>
				</a>
				&raquo;
				<a href="faq.php?cid=<?php echo $category->getId() . '&context=' . $pageContext ?>">
                    <?php
                    // Get the full category name after sanitize
                    $categorySanitized = Format::htmlchars($category->getLocalName());

                    // Get the context and the category title from the sanitized string
                    $categoryContext = $myVaccinesUtilities->getCategoryContext($categorySanitized);
                    $categoryIcon = $myVaccinesUtilities->getCategoryIcon($categorySanitized);
                    $categoryTitle = $myVaccinesUtilities->getCategoryTitle($categorySanitized);

                    // Display the category title
                    echo $categoryTitle;
                    ?>
				</a>
				&raquo;
				<strong>
                    <?php echo $faq->getLocalQuestion(); ?>
				</strong>
			</div>
		</div>
	</div>
</div>
<div class="separator"></div>
<!-- Topic of the category -->
<div class="wrapper">
	<div class="container">
		<div class="column center">
			<h1>
                <?php echo $faq->getLocalQuestion(); ?>
			</h1>
            <?php echo $faq->getLocalAnswerWithImages(); ?>
			<br>
			<br>
			<a href="faq.php?cid=<?php echo $category->getId() . '&context=' . $pageContext ?>" class="button-primary button-small">
                <?php
                echo __('Back');
                ?>
			</a>
		</div>
	</div>
</div>
