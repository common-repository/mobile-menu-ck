<?php
/**
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
Namespace Mobilemenuck;
defined('CK_LOADED') or die;
?>
<link rel="stylesheet" href="<?php echo MOBILEMENUCK_MEDIA_URL ?>/assets/ckframework.css" type="text/css" />
<link rel="stylesheet" href="<?php echo MOBILEMENUCK_MEDIA_URL ?>/assets/admin.css" type="text/css" />

<div style="margin:20px 20px 20px 0">
	<?php CKFof::displayMessages(); ?>
	<form action="<?php echo (MOBILEMENUCK_ADMIN_EDIT_MENU_URL  . '&id=' . (int) $this->item->id); ?>" enctype="multipart/form-data" method="post" name="ckform" id="ckform" class="ckinterface">
		<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
		<input type="hidden" name="task" value="menu.save" />
		<input type="hidden" name="type" value="custom" />
		<?php CKFof::renderToken('mobilemenuck_save_menu'); ?>
		<div>
			<label class="required" for="name">
				<?php echo CKText::_('Name'); ?>
				<span class="star">&nbsp;*</span>
			</label>
			<input type="text" aria-required="true" required="required" size="40" class="required" value="<?php echo $this->item->name ?>" id="name" name="name">

			<input type="button" class="ckbutton ckbutton-primary" name="saveButton" value="<?php echo CKText::_('Save'); ?>" onclick="ckSaveMenu()" />
		</div>
		<hr />
		<h3><?php echo CKText::_('Menu location'); ?></h3>
		<div>
			<label for="menuselector">
				<?php echo CKText::_('CSS selector'); ?>
				<span class="star">&nbsp;*</span>
			</label>
			<input type="text" value="<?php echo $this->item->params->get('selector') ?>" id="selector" name="params[selector]" placeholder="">
			<span class="description"><?php echo CKText::_('You must give a CSS selector to find where your menu is located in the page. Example : #nav'); ?></span>
		</div>
		<h3><?php echo CKText::_('Options'); ?></h3>
		<div>
			<label for="menuselector">
				<?php echo CKText::_('Menu ID'); ?>
			</label>
			<input type="text" value="<?php echo $this->item->params->get('menuid') ?>" id="menuid" name="params[menuid]" placeholder="">
			<span class="description"><?php echo CKText::_('Leave this field blank to let the system generate automatically an ID for your menu'); ?></span>
		</div>
		<div>
			<label for="menuselector">
				<?php echo CKText::_('Menu selector'); ?>
			</label>
			<input type="text" value="<?php echo $this->item->params->get('menuselector') ?>" id="menuselector" name="params[menuselector]" placeholder="ul">
		</div>
		<div>
			<label for="childselector">
				<?php echo CKText::_('Child items selector'); ?>
			</label>
			<input type="text" value="<?php echo $this->item->params->get('childselector') ?>" id="childselector" name="params[childselector]" placeholder="li">
		</div>
		<div>
			<label for="container">
				<?php echo CKText::_('Menu place'); ?>
			</label>
			<?php echo $this->fields->render('select', 'params[container]', $this->item->params->get('container'), 
				array(
				'menucontainer' => CKText::_('Menu container')
				,'body' => CKText::_('Body')
				,'topfixed' => CKText::_('Top fixed')
				)); 
			?>
		</div>
		<div>
			<label for="displaytype">
				<?php echo CKText::_('Display type'); ?>
			</label>
			<?php echo $this->fields->render('select', 'params[displaytype]', $this->item->params->get('displaytype'), 
				array(
				'flat' => CKText::_('Flat')
				,'accordion' => CKText::_('Accordion')
				,'fade' => CKText::_('Fade')
				,'push' => CKText::_('Push')
				)); 
			?>
		</div>
		<div>
			<label for="displayeffect">
				<?php echo CKText::_('Display effect'); ?>
			</label>
			<?php echo $this->fields->render('select', 'params[displayeffect]', $this->item->params->get('displayeffect'), 
				array(
				'normal' => CKText::_('Normal')
				,'slideleft' => CKText::_('Slide left')
				,'slideright' => CKText::_('Slide right')
				,'slideleftover' => CKText::_('Slide left over')
				,'sliderightover' => CKText::_('Slide right over')
				,'topfixed' => CKText::_('Top fixed')
				,'open' => CKText::_('Open')
				)); 
			?>
		</div>
		<div>
			<label for="menuwidth">
				<?php echo CKText::_('Menu width'); ?>
			</label>
			<input type="text" value="<?php echo $this->item->params->get('menuwidth') ?>" id="menuwidth" name="params[menuwidth]" placeholder="300">
		</div>
		<div>
			<label for="resolution">
				<?php echo CKText::_('Resolution for activation'); ?>
			</label>
			<input type="text" value="<?php echo $this->item->params->get('resolution') ?>" id="resolution" name="params[resolution]" placeholder="800">
		</div>
		<?php
		require_once MOBILEMENUCK_PATH . '/helpers/menuhelper.php';
		$stylesList = \Mobilemenuck\Helper::getStylesList();

		$styles = array('0' => CKText::_('None'));
		foreach ($stylesList as $s) {
			$styles[$s->id] = $s->name;
		}
		?>
		<div>
			<label for="state">
				<?php echo CKText::_('Style'); ?>
			</label>
			<?php echo $this->fields->render('select', 'style', $this->item->style, $styles); 
			?>
		</div>
		<div>
			<label for="state">
				<?php echo CKText::_('Enabled'); ?>
			</label>
			<?php echo $this->fields->render('select', 'state', $this->item->state, 
				array(
				'1' => CKText::_('Yes')
				,'0' => CKText::_('No')
				)); 
			?>
		</div>

	</form>
</div>

<script>
function ckSaveMenu() {
	if (document.getElementById('name').value == '') {
		document.getElementById('name').className += ' invalid';
		alert('<?php echo CKText::_('Please give a name') ?>');
		return;
	}

	if (document.getElementById('selector').value == '') {
		document.getElementById('selector').className += ' invalid';
		alert('<?php echo CKText::_('Please give a CSS selector for the menu location') ?>');
		return;
	}

	jQuery('#ckform').submit();
}
</script>