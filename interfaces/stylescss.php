<?php
/**
 * @name		Mobile Menu CK
 * @package		mobile-menu-ck
 * @copyright	Copyright (C) 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
// No direct access to this file
defined('CK_LOADED') or die('Restricted access');

$objclass = $this->input->get('objclass', '');
$objid = $this->input->get('ckobjid', '');
$expertmode = $this->input->get('expertmode', false);
$saveFunc = $this->input->get('savefunc', '', 'cmd');
$saveFunc = $saveFunc ? $saveFunc . '()' : '';

$showheight = (stristr($objclass, 'mainbanner') OR stristr($objclass, 'bannerlogo') OR stristr($objclass, 'horizmenu')) ? true : false;
$showwidth = ((stristr($objclass, 'wrapper') OR stristr($objclass, 'bannerlogo') OR stristr($objclass, 'banner') OR stristr($objclass, 'column')) AND !stristr($objclass, 'content')) ? true : false;
$isContent = (stristr($objclass, 'content') OR stristr($objclass, 'bannerlogodesc')) ? true : false;
$isBody = stristr($objclass, 'body') ? true : false;
$isWrapper = stristr($objclass, 'wrapper') ? true : false;
$isContainer = (stristr($objclass, 'body') OR stristr($objclass, 'wrapper') OR stristr($objclass, 'mainbanner') OR stristr($objclass, 'bannerlogo') OR stristr($objclass, 'flexiblemodules') OR stristr($objclass, 'maincontent') OR stristr($objclass, 'content') OR stristr($objclass, 'ckrow') OR ( stristr($objclass, 'center') && !stristr($objclass, 'centertop') && !stristr($objclass, 'centerbottom') )) ? true : false;
$isColumn = (stristr($objclass, 'column1') OR stristr($objclass, 'column2')) ? true : false;
$isLogo = (stristr($objclass, 'bannerlogo')) ? true : false;
$isCustomStyle = false;
$isFavorite = (stristr($objclass, 'ckmyfavorite')) ? true : false;
$isModulesContainer = stristr($objclass, 'flexiblemodules') ? true : false;
$isMaincontentContainer = stristr($objclass, 'maincontent') ? true : false;
$isSingleModule = (stristr($objclass, 'singlemodule') || (stristr($objclass, 'flexiblemodule') && !stristr($objclass, 'flexiblemodules'))) ? true : false;
$isHoriznav = (stristr($objclass, 'horiznav') || stristr($objclass, 'bannermenu')) ? true : false;
$isRow = (stristr($objclass, 'rowck')) ? true : false;
$this->interface = new CKInterface();
?>
<div class="ckleftpanelheader">
	<span class="ckleftpaneltitle"><?php echo CKText::_('Edition') ?>
		
	</span>
	<span class="ckleftpanelheadericon ckclose ckhastip" title="<?php echo CKText::_('Save and Close'); ?>" onclick="<?php echo $saveFunc ?>;ckRenderCss();ckCloseEdition();">×</span>
	<span class="ckleftpanelheadericon cksave ckhastip" title="<?php echo CKText::_('Apply'); ?>" onclick="ckRenderCss();"><span class="fa fa-check"></span></span>
	<?php if (! $isFavorite) { ?>
	<span class="ckleftpanelheadericon ckpaste ckhastip" onclick="ckPasteFromClipboard(this)" title="<?php echo CKText::_('Paste styles'); ?>"><span class="fa fa-clipboard"></span></span>
	<span class="ckleftpanelheadericon ckcopy ckhastip" onclick="ckCopyToClipboard(this)" title="<?php echo CKText::_('Copy styles'); ?>"><span class="fa fa-files-o"></span></span>
	<?php } ?>
</div>
<div id="ckelementscontainer" class="ckinterface">
		<?php
		$ckinterfacetablinktext = $isWrapper ? CKText::_('Wrapper styles') : CKText::_('Block styles');
		$blocinfos = $isWrapper ? CKText::_('CK_WRAPPER_INFOS') : CKText::_('CK_BLOC_INFOS');
		$blocdesc = $isWrapper ? CKText::_('CK_WRAPPER_DESC') : CKText::_('CK_BLOC_DESC');
		?>
		<div class="ckclr"></div>
		<div id="elementscontent">
			<?php if ($isWrapper || ($isRow && $expertmode == 'true')) { ?>
			<div class="ckinterfacetablink" tab="tab_bodystyles"><?php echo CKText::_('Body styles'); ?></div>
			<div class="ckinterfacetab ckproperty" id="tab_bodystyles">
				<?php echo $this->interface->createBlocStyles('body', 'wrapper', $expertmode) ?>
				<div class="ckclr"></div>
			</div>
			<?php } ?>
			<div class="ckinterfacetablink" tab="tab_blocstyles"><?php echo $ckinterfacetablinktext; ?></div>
			<div class="ckinterfacetab ckproperty" id="tab_blocstyles">
				<?php echo $this->interface->createBlocStyles('bloc', $objclass, $expertmode) ?>
				<div class="ckclr"></div>
			</div>
			<?php if (! $isFavorite) { ?>
			<div class="ckinterfacetablink" tab="tab_animations"><?php echo CKText::_('CK_ANIMATIONS'); ?></div>
			<div class="ckinterfacetab ckproperty" id="tab_animations">
				<?php echo $this->interface->createAnimations('bloc') ?>
				<div class="ckclr"></div>
			</div>
			<div class="ckinterfacetablink" tab="tab_videobgstyles"><?php echo CKText::_('CK_VIDEO_BACKGROUND_STYLES'); ?></div>
			<div class="ckinterfacetab ckproperty" id="tab_videobgstyles">
				<?php echo $this->interface->createVideobgStyles() ?>
				<div class="ckclr"></div>
			</div>
			<?php /*<div class="ckinterfacetablink" tab="tab_overlaystyles"><?php echo CKText::_('CK_OVERLAY_STYLES'); ?></div>
			<div class="ckinterfacetab ckproperty" id="tab_overlaystyles">
				<?php echo $this->interface->createOverlayStyles() ?>
				<div class="ckclr"></div>
			</div> */ ?>
			<?php } ?>
			<?php if ($isRow) { ?>
			<div class="ckinterfacetablink" tab="tab_divider"><?php echo CKText::_('CK_DIVIDER'); ?></div>
			<div class="ckinterfacetab ckproperty" id="tab_divider">
				<?php echo $this->interface->createDivider() ?>
				<div class="ckclr"></div>
			</div>
			<?php } ?>
		</div>
</div>
<div class="ckclr"></div>
<script language="javascript" type="text/javascript">
	ckInitOptionsTabs();
	ckInitColorPickers();
	ckInitModalPopup();
	ckInitOptionsAccordions();
</script>