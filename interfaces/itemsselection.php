<?php
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */

// No direct access to this file
defined('CK_LOADED') or die('Restricted access');

?>
<div id="ckitemselection">
	<h3><?php echo CKText::_('List of items') ?></h3>
	<small><?php echo CKText::_('Choose an item and click on it to create a new shorcode') ?></small>
	<div>
		<div class="mobilemenuck-item" onclick="ckCreateMobilemenu('text')">
			<div class="mobilemenuck-item-title">
				<?php echo CKText::_('Text') ?>
			</div>
		</div>
	</div>
</div>