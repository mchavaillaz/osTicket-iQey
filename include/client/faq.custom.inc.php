<?php
if (!defined('OSTCLIENTINC') || !$faq || !$faq->isPublished()) die('Access Denied');
$category = $faq->getCategory();
?>
<!-- Top bar section -->
<?php
$title = __('Frequently Asked Questions');
$text = __('This page contains the FAQ.');
require(CLIENTINC_DIR . 'page-header.inc.php');
?>
<!-- Breadcrumbs section -->
<div class="wrapper items">
	<div class="container">
		<div class="column center">
			<div class="breadcrumbs">
				<a href="index.php">
                    <?php echo __('All Categories'); ?>
				</a>
				&raquo;
				<a href="faq.php?cid=<?php echo $category->getId()?>">
                    <?php
                    // Get the full category name after sanitize
                    $categorySanitized = Format::htmlchars($category->getLocalName());

                    // Get the context and the category title from the sanitized string
                    $categoryIcon = $iQeyUtilities->getCategoryIcon($categorySanitized);
                    $categoryTitle = $iQeyUtilities->getCategoryTitle($categorySanitized);

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
			<a href="faq.php?cid=<?php echo $category->getId()?>" class="button-primary button-small">
                <?php
                echo __('Back');
                ?>
			</a>
		</div>
	</div>
</div>
