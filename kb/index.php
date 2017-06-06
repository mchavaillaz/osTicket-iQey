<?php
/*********************************************************************
 * index.php
 *
 * Knowledgebase Index.
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
require('kb.inc.php');
require_once(INCLUDE_DIR . 'MyVaccinesUtilities.php');

// Tool
$myVaccinesUtilities = new MyVaccinesUtilities();

require_once(INCLUDE_DIR . 'class.category.php');
require(CLIENTINC_DIR . 'header.custom.inc.php');
require(CLIENTINC_DIR . 'knowledgebase.inc.php');
require(CLIENTINC_DIR . 'footer.custom.inc.php');
?>
