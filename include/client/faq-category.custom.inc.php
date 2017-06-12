<?php
if (!defined('OSTCLIENTINC') || !$category || !$category->isPublic()) die('Access Denied');
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
				<a href="index.php">
                    <?php echo __('All Categories'); ?>
				</a>
				&raquo;
				<strong>
                    <?php
                    // Get the full category name after sanitize
                    $categorySanitized = Format::htmlchars($category->getLocalName());

                    // Get the context and the category title from the sanitized string
                    $categoryIcon = $myVaccinesUtilities->getCategoryIcon($categorySanitized);
                    $categoryTitle = $myVaccinesUtilities->getCategoryTitle($categorySanitized);

                    // Display the category title
                    echo $categoryTitle;
                    ?>
				</strong>
			</div>
		</div>
	</div>
</div>
<div class="separator"></div>
<!-- List all topics of the category -->
<div class="wrapper">
	<div class="container">
		<div class="column center">
			<h1>
                <?php echo $categoryTitle; ?>
			</h1>
            <?php
            $faqs = FAQ::objects()
                ->filter(array('category' => $category))
                ->exclude(array('ispublished' => FAQ::VISIBILITY_PRIVATE))
                ->annotate(array('has_attachments' => SqlAggregate::COUNT(SqlCase::N()
                    ->when(array('attachments__inline' => 0), 1)
                    ->otherwise(null)
                )))
                ->order_by('-ispublished', 'question');

            if ($faqs->exists(true)) {
                echo '<div id="faq"><ol>';
                foreach ($faqs as $F) {
                    $attachments = $F->has_attachments ? '<span class="Icon file"></span>' : '';
                    echo sprintf('<li class="faq-category-link"><a href="faq.php?id=%d" style="color: black;">%s</a></li>',
                        $F->getId(),
                        Format::htmlchars($F->getLocalQuestion()));
                }
                echo '</ol></div>';
            } else {
                echo '<strong>' . __('This category does not have any FAQs.') . '<a href="index.php">' . __('Back To Index') . '</a></strong>';
            }
            ?>
			<br>
			<br>
			<a href="index.php" class="button-primary button-small">
                <?php
                echo __('Back');
                ?>
			</a>
		</div>
	</div>
</div>
