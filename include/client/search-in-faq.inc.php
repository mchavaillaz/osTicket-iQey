<div class="wrapper items">
	<div class="container search">
        <?php
        if ($cfg && $cfg->isKnowledgebaseEnabled()) { ?>
			<form method="get" action="<?php echo ROOT_PATH; ?>kb/faq.php">
				<input type="hidden" name="a" value="search"/>
				<input type="hidden" name="context" value="<?php echo $pageContext; ?>">
				<table class="faq-table-search">
					<tr>
						<td>
							<input type="text" name="q" class="faq-search-field" placeholder="<?php echo __('Search in the FAQ'); ?>"/>
						</td>
						<td>
							<button type="submit" class="button-primary button-big"><?php echo __('Search'); ?></button>
						</td>
					</tr>
				</table>
			</form>
        <?php } ?>
	</div>
</div>
