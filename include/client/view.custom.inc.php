<?php
// Get the current page context
$pageContext = $myVaccinesUtilities->getCurrentContext($_GET['context']);

if (!defined('OSTCLIENTINC') || !$thisclient || !$ticket || !$ticket->checkUserAccess($thisclient)) die('Access Denied!');

$info = ($_POST && $errors) ? Format::htmlchars($_POST) : array();

$dept = $ticket->getDept();

if ($ticket->isClosed() && !$ticket->isReopenable())
    $warn = __('This ticket is marked as closed and cannot be reopened.');

// Making sure we don't leak out internal dept names
if (!$dept || !$dept->isPublic())
    $dept = $cfg->getDefaultDept();

if ($thisclient && $thisclient->isGuest()
    && $cfg->isClientRegistrationEnabled()
) { ?>

	<div id="msg_info">
		<i class="icon-compass icon-2x pull-left"></i>
		<strong><?php echo __('Looking for your other tickets?'); ?></strong><br/>
		<a href="<?php echo ROOT_PATH; ?>login.php?e=<?php
        echo urlencode($thisclient->getEmail());
        ?>" style="text-decoration:underline"><?php echo __('Sign In'); ?></a>
        <?php echo sprintf(__('or %s register for an account %s for the best experience on our help desk.'),
            '<a href="account.php?do=create" style="text-decoration:underline">', '</a>'); ?>
	</div>

<?php } ?>

<!-- Top bar section -->
<?php
$title = __('About your request');
$text = __('On this page you can find the current state of you request.<br>For further questions or to add additional information you can use the form below.');
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
<!-- Ticket information -->
<div class="wrapper">
	<table class="table-center-ticket-thread">
		<thead>
			<tr>
				<td style="text-align: center">
					<h2>
                        <?php echo __('Request information'); ?>
					</h2>
				</td>
			</tr>
		</thead>
		<tbody class="ticket-thread-ticket-info-body">
			<tr>
				<td>
                    <?php
                    echo __('Request status') . ': ' . (($S = $ticket->getStatus()) ? $S->getLocalName() : '');
                    ?>
				</td>
			</tr>
			<tr>
				<td>
                    <?php echo __('Department') . ': ' . (Format::htmlchars($dept instanceof Dept ? $dept->getName() : '')); ?>
				</td>
			</tr>
			<tr>
				<td>
                    <?php echo __('Create date') . ': ' . Format::datetime($ticket->getCreateDate()); ?>
				</td>
			</tr>
		</tbody>
	</table>

</div>
<!-- Ticket message/response -->
<div class="wrapper">
	<table class="table-center-ticket-thread-title">
		<tr>
			<td style="text-align: center;">
				<h2>
                    <?php echo __('About your request'); ?>
				</h2>
			</td>
		</tr>
		<tr>
			<td>
				<div style="display: table-cell; vertical-align: middle">
                    <?php echo __('Newest message at the bottom'); ?>
				</div>
				<div style="display: table-cell; vertical-align: middle">
					<a href="#reply">
						<img src="<?php echo ASSETS_PATH; ?>images/icons/anchor_<?php echo $pageContext ?>.png">
					</a>
				</div>
			</td>
		</tr>
	</table>
	<div class="ticket-thread-discussion-container">
        <?php
        $ticket->getThread()->render(
            array('M', 'R'),
            array('mode' => Thread::MODE_CLIENT,
                'html-id' => 'ticketThread')
        );
        ?>
	</div>
</div>
<!-- Post a reply section -->
<?php
if (!$ticket->isClosed() || $ticket->isReopenable()) { ?>
	<div class="wrapper">
		<form id="reply"
			  action="tickets.php?context=<?php echo $pageContext ?>&id=<?php echo $ticket->getId() . '#reply' ?>"
			  name="reply"
			  method="post"
			  enctype="multipart/form-data">
            <?php csrf_token(); ?>
			<input type="hidden" name="id" value="<?php echo $ticket->getId(); ?>">
			<input type="hidden" name="a" value="reply">
			<table class="table-center-ticket-response">
				<tr>
					<td>
						<h2>
                            <?php echo __('Post a Reply'); ?>
						</h2>
						<span class="error">
							<?php echo $errors['message']; ?>
						</span>
					</td>
				</tr>
				<tr>
					<td>
						<textarea id="message" name="message" class="ticket-response-text-area"></textarea>
					</td>
				</tr>
				<tr>
					<td>
                        <?php
                        if ($messageField->isAttachmentsEnabled()) {
                            print $attachments->render(array('client' => true));
                        }
                        ?>
					</td>
				</tr>
				<tr>
					<td>
                        <?php if ($ticket->isClosed()) { ?>
							<div class="warning-banner">
                                <?php echo __('Request will be reopened on message post'); ?>
							</div>
							<br>
                        <?php } ?>
					</td>
				</tr>
				<tr>
					<td class="table-center-ticket-response-post-reply-td">
						<input type="submit" class="button-primary button-big" value="<?php echo __('Post Reply'); ?>">
					</td>
				</tr>
			</table>
		</form>
	</div>
    <?php
} ?>
<script type="text/javascript">
    <?php
    // Hover support for all inline images
    $urls = array();
    foreach (AttachmentFile::objects()->filter(array(
        'attachments__thread_entry__thread__id' => $ticket->getThreadId(),
        'attachments__inline' => true,
    )) as $file) {
        $urls[strtolower($file->getKey())] = array(
            'download_url' => $file->getDownloadUrl(),
            'filename' => $file->name,
        );
    } ?>
    showImagesInline(<?php echo JsonDataEncoder::encode($urls); ?>);
</script>
