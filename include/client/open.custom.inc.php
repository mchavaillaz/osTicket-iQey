<?php
if (!defined('OSTCLIENTINC')) die('Access Denied!');
$info = array();
if ($thisclient && $thisclient->isValid()) {
    $info = array('name' => $thisclient->getName(),
        'email' => $thisclient->getEmail(),
        'phone' => $thisclient->getPhoneNumber());
}

$info = ($_POST && $errors) ? Format::htmlchars($_POST) : $info;

$form = null;
if (!$info['topicId']) {
    if (array_key_exists('topicId', $_GET) && preg_match('/^\d+$/', $_GET['topicId']) && Topic::lookup($_GET['topicId']))
        $info['topicId'] = intval($_GET['topicId']);
    else
        $info['topicId'] = $cfg->getDefaultTopicId();
}

$forms = array();
if ($info['topicId'] && ($topic = Topic::lookup($info['topicId']))) {
    foreach ($topic->getForms() as $F) {
        if (!$F->hasAnyVisibleFields())
            continue;
        if ($_POST) {
            $F = $F->instanciate();
            $F->isValidForClient();
        }
        $forms[] = $F;
    }
}

// Get the current page context
$pageContext = $myVaccinesUtilities->getCurrentContext($_GET['context']);
?>
<!-- Top bar section -->
<?php
$title = __('Create new request');
$title = __('Create new request');
$text = __('Unable to find an answer to your question in the FAQ?<br>Create your request below.');
require(CLIENTINC_DIR . 'page-header.inc.php');
?>
<!-- Icon section -->
<div class="wrapper">
	<table class="table-center">
		<tr>
			<td>
                <?php
                if ($pageContext == $myVaccinesUtilities::CONTEXT_PUBLIC) {
                    ?>
					<img src="<?php echo ASSETS_PATH; ?>images/icons/new_ticket.png">
                    <?php
                } else {
                    ?>
					<img src="<?php echo ASSETS_PATH; ?>images/icons/new_ticket_blue.png">
                    <?php
                }
                ?>

			</td>
		</tr>
	</table>
</div>
<div class="separator"></div>
<?php
if (!$thankYouText) {
    if (!$thisclient) { ?>
		<!-- Procedure text section -->
		<div class="wrapper">
			<table class="table-center left">
				<tr>
					<td>
						<img src="<?php echo ASSETS_PATH; ?>images/icons/info_<?php echo $pageContext ?>.png">
					</td>
					<td>
						<p>
							<?php echo __('Step 1: Please enter your contact details and choose a topic to allow us a fast processing of your request.'); ?>
						</p>
						<p>
                            <?php echo __('Step 2: Enter you question. You can also attach files to you question.'); ?>
						</p>
						<p>
                            <?php echo __('Step 3: Copy the generated character combination in the input field next to it and submit.'); ?>
						</p>
					</td>
				</tr>
			</table>
			<table class="table-center">
				<tr>
					<td>
						<div class="separator" style="width: 520px"></div>
					</td>
				</tr>
			</table>
		</div>
    <?php } ?>
	<!-- Ticket form -->
	<form id="ticketForm" method="post" action="open.php?context=<?php echo $pageContext; ?>" enctype="multipart/form-data">
        <?php csrf_token(); ?>
		<input type="hidden" name="a" value="open">
		<table class="table-center-open-ticket">
            <?php
            if (!$thisclient) {
                $uform = UserForm::getUserForm()->getForm($_POST);
                if ($_POST) $uform->isValid();
                $uform->render(false);
            } ?>
			<tr>
				<td>
					<span class="required">
						<?php
                        echo __('Topic');
                        ?>
					</span>
					<span class="error">*</span>
					<br>
					<select id="topicId"
							name="topicId"
							class="open-ticket-topic-select"
							onchange="javascript:
	                                var data = $(':input[name]', '#dynamic-form').serialize();
	                                $.ajax(
	                                    'ajax.php/form/help-topic/' + this.value,
	                                    {
	                                        data: data,
	                                        dataType: 'json',
											success: function(json) {
	                                            // Get the result as html
	                                            var contentHTML = json.html;
	                                            // Remove all <tr><td>
	                                            var contentHTMLCleared = contentHTML
	                                            								.replace('<tr>', '')
	                                            								.replace('</tr>', '')
	                                            								.replace('<td>', '')
	                                            								.replace('</td>', '');
												// Add the content html cleared into the #dynamic-form element
												$('#dynamic-form').empty().append(contentHTMLCleared);
												// Remove the placeholder from the <textarea> manually
												$('#dynamic-form textarea').removeAttr('placeholder');
												$(document.head).append(json.media);
												// Show the #captchaTable
												$('#captchaTable').show();
	                                    }
	                                  });">
						<option value="" selected="selected">&mdash;&nbsp;<?php echo __('Select a Help Topic'); ?>&nbsp;&mdash;</option>
                        <?php
                        if ($topics = Topic::getPublicHelpTopics()) {
                            foreach ($topics as $id => $name) {
                                echo sprintf('<option value="%d" %s>%s</option>',
                                    $id,
                                    ($info['topicId'] == $id) ? 'selected="selected"' : '',
                                    $name);
                            }
                        } else { ?>
							<option value="0">
                                <?php echo __('General Inquiry'); ?>
							</option>
                            <?php
                        } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td id="dynamic-form" class="table-center-ticket-description-td" colspan="2">
					<!-- Called in cas of error after post -->
                    <?php foreach ($forms as $form) {
                        // Look for the "Ticket Details" text area
                        foreach ($form->getFields() as $field) {
                            if ($field instanceof ThreadEntryField) {
                                $ticketField = $field;
                                break;
                            }
                        }
                        if ($ticketField) {
                            // Display the "Ticket Details" with the error messages
                            include(CLIENTINC_DIR . 'templates/dynamic-form-ticket-detail.custom.tmpl.php');
                            break;
                        }
                    }
                    ?>
				</td>
			</tr>
            <?php
            if ($cfg && $cfg->isCaptchaEnabled() && (!$thisclient || !$thisclient->isValid())) {
                if ($_POST && $errors && !$errors['captcha'])
                    $errors['captcha'] = __('Please re-enter the text again');
                ?>
				<tr id="captchaTable">
					<td class="table-center-ticket-description-td" colspan="2">
                        <?php echo str_replace(".", "", __('Enter the text shown on the image.')) ?>
						<span class="error">*</span>
						<br>
						<span class="captcha"><img src="captcha.php" border="0" align="left"></span>
						&nbsp;&nbsp;
						<input id="captcha" type="text" name="captcha" size="6" autocomplete="off">
						<span class="error"><?php echo $errors['captcha']; ?></span>
					</td>
				</tr>
                <?php
            } ?>
			<tr>
				<td colspan="2" style="text-align: center;">
					<input type="submit" class="button-primary button-big" value="<?php echo __('Submit'); ?>">
				</td>
			</tr>
			<tr>
				<td>
					<br>
					<br>
					<span class="error">*</span>&nbsp;<?php echo __('Required field'); ?>
				</td>
			</tr>
		</table>
	</form>
    <?php
} else {
    ?>
	<!-- Display the Thank you text -->
	<div class="wrapper">
		<div class="container">
			<div class="column center">
				<table class="table-center">
					<tr>
						<td>
                            <?php
                            echo $thankYouText;
                            // Reset the $thankYouText variable
                            $thankYouText = null;
                            ?>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
    <?php
}
?>
<script type="application/javascript">
    $(document).ready(function () {
        // Show or hide the captcha table if the element #dynamic-form has children
        if ($('#dynamic-form').children().length > 0) {
            $('#captchaTable').show();
        } else {
            $('#captchaTable').hide();
        }

        // Get the <tr> that contains the EAN/GLN input
        var trEanGln = $($(".table-center-open-ticket span:contains('EAN/GLN')")[0])
            .parentsUntil('tr').parent();

        // Get the parameters in the url
        var params = parseQueryString(location.href);

        // Show/Hide manually the EAN/GLN input according to the context (public/professional)
        if (params['context'] == 'public') {
            trEanGln.hide();
        } else {
            trEanGln.show();
        }
    });

    /**
     * Parse all parameters from the url.
     *
     * @returns object with {"param": "value"}
     */
    var parseQueryString = function () {
        // Tools
        var str = window.location.search;
        var objURL = {};

        str.replace(
            new RegExp("([^?=&]+)(=([^&]*))?", "g"),
            function ($0, $1, $2, $3) {
                objURL[$1] = $3;
            }
        );

        return objURL;
    };
</script>
