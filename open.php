<?php
/*********************************************************************
 * open.php
 *
 * New tickets handle.
 *
 * Peter Rotich <peter@osticket.com>
 * Copyright (c)  2006-2013 osTicket
 * http://www.osticket.com
 *
 * Released under the GNU General Public License WITHOUT ANY WARRANTY.
 * See LICENSE.TXT for details.
 *
 * vim: expandtab sw=4 ts=4 sts=4:
 **********************************************************************/
require('client.inc.php');
require_once(INCLUDE_DIR . 'MyVaccinesUtilities.php');

// Tool
$myVaccinesUtilities = new MyVaccinesUtilities();

define('SOURCE', 'Web'); //Ticket source.
$ticket = null;
$errors = array();
if ($_POST) {
    $vars = $_POST;
    $vars['deptId'] = $vars['emailId'] = 0; //Just Making sure we don't accept crap...only topicId is expected.
    if ($thisclient) {
        $vars['uid'] = $thisclient->getId();
    } elseif ($cfg->isCaptchaEnabled()) {
        if (!$_POST['captcha'])
            $errors['captcha'] = __('Enter text shown on the image');
        elseif (strcmp($_SESSION['captcha'], md5(strtoupper($_POST['captcha']))))
            $errors['captcha'] = __('Invalid - try again!');
    }

    $tform = TicketForm::objects()->one()->getForm($vars);
    $messageField = $tform->getField('message');
    $attachments = $messageField->getWidget()->getAttachments();
    if (!$errors && $messageField->isAttachmentsEnabled())
        $vars['cannedattachments'] = $attachments->getClean();

    // Drop the draft.. If there are validation errors, the content
    // submitted will be displayed back to the user
    Draft::deleteForNamespace('ticket.client.' . substr(session_id(), -12));
    //Ticket::create...checks for errors..
    if (($ticket = Ticket::create($vars, $errors, SOURCE))) {
        $msg = __('Support ticket request created');
        // Drop session-backed form data
        unset($_SESSION[':form-data']);
        //Logged in...simply view the newly created ticket.
        if ($thisclient && $thisclient->isValid()) {
            session_write_close();
            session_regenerate_id();
            @header('Location: tickets.php?id=' . $ticket->getId());
        }
    } else {
        $errors['err'] = $errors['err'] ?: sprintf('%s %s',
            __('Unable to create a ticket.'),
            __('Correct any errors below and try again.'));
    }
}

//page
$nav->setActiveNav('new');
if ($cfg->isClientLoginRequired()) {
    if ($cfg->getClientRegistrationMode() == 'disabled') {
        Http::redirect('view.php');
    } elseif (!$thisclient) {
        require_once 'secure.inc.php';
    } elseif ($thisclient->isGuest()) {
        require_once 'login.php';
        exit();
    }
}

require(CLIENTINC_DIR . 'header.custom.inc.php');

// Tool that contains the HTML code of the "Thank you page"
$thankYouText = null;

// Check if a ticket has been posted
if ($ticket && ((($topic = $ticket->getTopic()) && ($page = $topic->getPage())) || ($page = $cfg->getThankYouPage()))) {
    $thankYouText = $ticket->replaceVars($page->getLocalBody());
}
require(CLIENTINC_DIR . 'open.custom.inc.php');
require(CLIENTINC_DIR . 'footer.custom.inc.php');
?>
