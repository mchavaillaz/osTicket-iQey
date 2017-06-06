<?php
global $thisclient;
$cpt = 0;
$ticketMessage;
foreach ($form->getFields() as $field) {
    if (isset($options['mode']) && $options['mode'] == 'create') {
        if (!$field->isVisibleToUsers() && !$field->isRequiredForUsers())
            continue;
    } elseif (!$field->isVisibleToUsers() && !$field->isEditableToUsers()) {
        continue;
    }

    if ($cpt % 2 == 0) {
        echo '<tr>';
    }
    ?>
    <td>
        <?php if (!$field->isBlockLevel()) { ?>
        <label for="<?php echo $field->getFormName(); ?>">
                <span class="<?php if ($field->isRequiredForUsers()) echo 'required'; ?>">
                <?php
                echo Format::htmlchars($field->getLocal('label'));
                if ($field->isRequiredForUsers()) {
                    echo '<span class="error">&nbsp;*</span>';
                }
                ?>
                </span>
            <?php
            if ($field->get('hint')) { ?>
                <br/>
                <em style="color:gray;display:inline-block">
                    <?php echo Format::viewableImages($field->getLocal('hint')); ?>
                </em>
                <?php
            } ?>
            <br/>
            <?php
            }
            $field->render(array('client' => true));
            ?>
        </label>
        <?php
        foreach ($field->errors() as $e) { ?>
            <div class="error">
                <?php echo $e; ?>
            </div>
        <?php }
        $field->renderExtras(array('client' => true));
        ?>
    </td>
    <?php
    if ($cpt % 2 != 0) {
        echo '</tr>';
    }
    $cpt++;
}
?>
