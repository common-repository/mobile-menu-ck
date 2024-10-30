<?php
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */

defined('CK_LOADED') or die('Restricted access');

$type = $this->input->get('type', '', 'string');
$saveFunc = $this->input->get('saveFunc', '', 'string');
$id = $this->input->get('ckid', '', 'string');
if (! $type) die('No type given. Error.');
?>
<div class="ckleftpanelheader">
	<span class="ckleftpaneltitle"><?php echo CKText::_('Edition') ?>
		<span class="ckleftpanelsubtitle ckleftpanelsubtitleunder">[ <?php echo $type ?> ]</span>
	</span>
	<span class="ckleftpanelheadericon ckclose ckhastip" title="<?php echo CKText::_('Save and Close'); ?>" onclick="<?php echo $saveFunc ?>;ckRenderCss();ckCloseEdition();">×</span>
	<span class="ckleftpanelheadericon cksave ckhastip" title="<?php echo CKText::_('Apply'); ?>" onclick="ckRenderCss();"><span class="fa fa-check"></span></span>
	<span class="ckleftpanelheadericon ckpaste ckhastip" onclick="ckPasteFromClipboard(this)" title="<?php echo CKText::_('Paste styles'); ?>"><span class="fa fa-clipboard"></span></span>
	<span class="ckleftpanelheadericon ckcopy ckhastip" onclick="ckCopyToClipboard(this)" title="<?php echo CKText::_('Copy styles'); ?>"><span class="fa fa-files-o"></span></span>
</div>
<div class="ckinterface">
	<?php
	require_once MOBILEMENUCK_PATH . '/addons/' . $type . '/' . $type . '.php';
	$addonClassName = 'MobilemenuckAddon' . ucfirst($type);
	$addonClass = new $addonClassName();
	$functionName = 'onMobilemenuckLoadItemOptions' . ucfirst($type);
	include_once $addonClass->$functionName();
	?>
</div>