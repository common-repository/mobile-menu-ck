<?php
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
 Namespace Mobilemenuck;
defined('CK_LOADED') or die;

$uri = MOBILEMENUCK_MEDIA_URL . '/presets/';
$folder_path = MOBILEMENUCK_MEDIA_PATH . '/presets/';
$folders = CKFolder::folders($folder_path);
natsort($folders);

$i = 1;
echo '<div class="clearfix" style="min-height:35px;margin: 0 5px;">';
foreach ($folders as $folder) {
	$theme_title = "";
	if ( file_exists($folder_path . $folder. '/styles.json') ) {
		if ( file_exists($folder_path . '/' . $folder. '/preview.png') ) {
			$theme = $uri . $folder . '/preview.png';
		} else {
			$theme = MOBILEMENUCK_MEDIA_URI . '/images/what.png" width="110" height="110';
			// $theme_title = CKText::_('CK_THEME_PREVIEW_NOT_FOUND');
		}
	} else {
		// $theme = Juri::root(true) . '/administrator/components/com_maximenuck/images/warning.png" width="110" height="110';
		// $theme_title = CKText::_('CK_THEME_CSS_NOT_COMPATIBLE');
		continue;
	}

	echo '<div class="themethumb" data-name="' . $folder . '" onclick="ckLoadPreset(\'' . $folder . '\')">'
		. '<img src="' . $theme . '" style="margin:0;padding:0;" title="' . $theme_title . '" class="hasTip" />'
		. '<div class="themename">' . $folder . '</div>'
		. '</div>';
	$i++;
}
/*foreach ($presets as $preset) {
	$presetName = JFile::stripExt($preset);
	$theme_title = "";
	if ( file_exists($folder_path .$presetName . '.png') ) {
		$theme = JUri::root(true) . $path . $presetName . '.png';
	} else {
		$theme = Juri::root(true) . '/administrator/components/com_mobilemenuck/images/what.png" width="110" height="110';
	}

	echo '<div class="themethumb" data-name="' . $presetName . '" onclick="ckLoadPreset(\'' . $presetName . '\')">'
		. '<div class="themethumbimg">'
		. '<img src="' . $theme . '" style="margin:0;padding:0;" title="' . $theme_title . '" class="hasTip" />'
		. '</div>'
		. '<div class="themename">' . $presetName . '</div>'
		. '</div>';
	$i++;
}*/
echo '</div>';