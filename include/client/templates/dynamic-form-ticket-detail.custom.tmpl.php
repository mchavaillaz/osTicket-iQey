<?php
global $thisclient;

if (!$ticketField->isBlockLevel()) { ?>
<label for="<?php echo $ticketField->getFormName(); ?>">
	<span class="<?php if ($ticketField->isRequiredForUsers()) echo 'required'; ?>">
		<?php
        echo Format::htmlchars($ticketField->getLocal('label'));
        if ($ticketField->isRequiredForUsers()) {
            echo '<span class="error">&nbsp;*</span>';
        }
        ?>
	</span>
    <?php
    if ($ticketField->get('hint')) { ?>
		<br/>
		<em style="color:gray;display:inline-block">
            <?php echo Format::viewableImages($ticketField->getLocal('hint')); ?>
		</em>
        <?php
    } ?>
	<br/>
    <?php
    }
    $ticketField->render(array('client' => true));
    ?>
</label>
<?php
foreach ($ticketField->errors() as $e) { ?>
	<div class="error">
        <?php echo $e; ?>
	</div>
<?php }
$ticketField->renderExtras(array('client' => true));
?>
