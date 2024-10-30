<?php
Namespace Mobilemenuck;
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */

defined('CK_LOADED') or die;
// require_once MOBILEMENUCK_PATH . '/controller.php';

class CKControllerStyle extends CKController {

	protected $view = 'style';

	function __construct() {
		parent::__construct();
	}

	public function edit() {
		$editIds = $this->input->get('cid', null, 'array');
		if (count($editIds)) {
			$editId = (int) $editIds[0];
		} else {
			$editId = (int) $this->input->get('id', null, 'int');
		}

		// Redirect to the edit screen.
		MobilemenuckHelper::redirect(MOBILEMENUCK_ADMIN_EDIT_STYLE_URL . '&view=' . $this->view . '&layout=edit&id=' . $editId);
	}

	/*
	 * Generate the CSS styles from the settings
	 */
	public function ajaxRenderCss() {
		// security check
		if (! MobilemenuckHelper::checkAjaxToken()) {
			exit();
		}

		$fields = stripslashes($this->input->get('fields', '', 'raw'));
		$fields = json_decode($fields);
		$customstyles = stripslashes( $this->input->get('customstyles', '', 'string'));
		$customstyles = json_decode($customstyles);
		$customcss = $this->input->get('customcss', '', 'html');

		$css = $this->renderCss($fields, $customstyles);
		$css .= $customcss;

		echo $css;
		exit();
	}

	/*
	 * Render the CSS from the settings
	 */
	public function renderCss($fields, $customstyles) {
		require_once MOBILEMENUCK_PATH . '/helpers/ckstyles.php';
		$ckstyles = new CKStyles();
		$css = $this->getDefaultCss($fields);
		$css .= $ckstyles->create($fields, $customstyles);

		return $css;
	}

	/*
	 * Render the CSS from the settings
	 */
	public function getDefaultCss($fields) {
		$css = '';
		$css .= "/* Mobile Menu CK - https://www.ceikay.com */\n";
		$css .= "/* Automatic styles */\n\n";

		// styles for the collapsing bar
		$css .= ".mobilemenuck-bar {display:none;position:relative;left:0;top:0;right:0;z-index:100;}\n";
		$css .= ".mobilemenuck-bar-title {display: block;}\n";
		$css .= ".mobilemenuck-bar-button {cursor:pointer;box-sizing: border-box;position:absolute; top: 0; right: 0;line-height:0.8em;font-family:Segoe UI;text-align: center;}\n";

		// styles for the menu
		$css .= ".mobilemenuck * {box-sizing: border-box;}\n";
		$css .= ".mobilemenuck {box-sizing: border-box;width: 100%;}\n";
		$css .= ".mobilemenuck-topbar {position:relative;}\n";
		$css .= ".mobilemenuck-title {display: block;}\n";
		$css .= ".mobilemenuck-button {cursor:pointer;box-sizing: border-box;position:absolute; top: 0; right: 0;line-height:0.8em;font-family:Segoe UI;text-align: center;}\n";
		// for the links
		$css .= ".mobilemenuck a {display:block;}\n";
		$css .= ".mobilemenuck a:hover {text-decoration: none;}\n";

		// styles for the menu items
		$css .= ".mobilemenuck .mobilemenuck-item > div {position:relative;}\n";
		// $css .= ".mobilemenuck div.level1 > a {" . implode($styles_css->level1menuitem) . "}";
		// $css .= ".mobilemenuck div.level2 > a {" . implode($styles_css->level2menuitem) . "}";
		// $css .= ".mobilemenuck div.level2 + .mobilemenuck-submenu div.mobilemenuck-item a {" . implode($styles_css->level3menuitem) . "}";

		// styles for the accordion icons
		$css .= "/* for accordion */\n";
		// $css .= ".mobilemenuck .mobilemenuck-togglericon:after {cursor:pointer;text-align:center;}\n";
		if (isset($fields->togglericoncontentclosed)) {
			$togglericonclosed = $fields->togglericoncontentclosed == 'custom' ? $fields->togglericoncontentclosedcustomtext : $fields->togglericoncontentclosed;
		} else {
			$togglericonclosed = '+';
		}
		if (isset($fields->togglericoncontentopened)) {
			$togglericonopened = $fields->togglericoncontentopened == 'custom' ? $fields->togglericoncontentopenedcustomtext : $fields->togglericoncontentopened;
		} else {
			$togglericonopened = '-';
		}
		$css .= ".mobilemenuck-togglericon:after {cursor:pointer;text-align:center;display:block;position: absolute;right: 0;top: 0;content:\"" . $togglericonclosed . "\";}\n";
		$css .= ".mobilemenuck .open .mobilemenuck-togglericon:after {content:\"" . $togglericonopened . "\";}\n";

		// add google font
		// $css .= "\n\n/* Google Font stylesheets */\n\n";
		// $css .= implode("\n", $gfontcalls);
		// replace the path for correct image rendering
		// $customcss = $this->input->get('customcss', '', 'raw');
		// if ($this->input->get('action')) {
			// $customcss = str_replace('../..', JUri::root(true) . '/plugins/system/maximenuckmobile', $customcss);
		// }
		// $css .= "\n\n/* Custom CSS generated from the plugin options */\n\n";
		// $css .= $customcss;

		return $css;
	}

	/*
	 * Generate the CSS styles from the settings
	 */
	public function ajaxSaveStyles() {
		// security check
		if (! MobilemenuckHelper::checkAjaxToken()) {
			exit();
		}

		// Get the data.
		// $data = $this->input->getArray($_POST);
		$id = $this->input->get('id', 0, 'int');
		$name = $this->input->get('name', '', 'string');
		if (! $name) $name = 'style' . $id;
		$layoutcss = trim($this->input->get('layoutcss', '', 'html'));
		$fields = $this->input->get('fields', '', 'raw');
		$fields = stripslashes($this->input->get('fields', '', 'raw'));

		if (! $name) $name = 'style' . $id;
		$data['id'] = $id;
		$data['name'] = $name;
		$data['state'] = 1;
		$data['params'] = $fields;
		$data['layoutcss'] = $layoutcss;

		$model = $this->getModel('style');
		$id = $model->save($data);

		if (! $id) {
			echo "{'result': '0', 'id': '" . $id . "', 'message': 'Error : Can not save the Styles !'}";
			die;
		}
		echo '{"result": "1", "id": "' . $id . '", "message": "Styles saved successfully"}';
		exit();
	}

	/**
	 * Ajax method to read the fields values from the selected preset
	 *
	 * @return  json - 
	 *
	 */
	function ajaxLoadPresetFields() {
		// security check
		if (! MobilemenuckHelper::checkAjaxToken()) {
			exit();
		}

		$preset = $this->input->get('preset', '', 'string');
		$folder_path = MOBILEMENUCK_MEDIA_PATH . '/presets/';
		$fields = '{}';

		if ( file_exists($folder_path . $preset. '/styles.json') ) {
			$fields = @file_get_contents($folder_path . $preset. '/styles.json');
			$fields = str_replace("\n", "", $fields);
		} else {
			echo '{"result" : 0, "message" : "File Not found : '.$folder_path . $preset. '/styles.json'.'"}';
			exit();
		}

		echo '{"result" : 1, "fields" : "'.$fields.'", "customcss" : ""}';
		exit();
	}

	/**
	 * Ajax method to read the custom css from the selected preset
	 *
	 * @return  string - the custom CSS on success, error message on failure
	 *
	 */
	function ajaxLoadPresetCustomcss() {
		// security check
		if (! MobilemenuckHelper::checkAjaxToken()) {
			exit();
		}

		$preset = $this->input->get('folder', '', 'string');
		$folder_path = MOBILEMENUCK_MEDIA_PATH . '/presets/';

		// load the custom css
		$customcss = '';
		if ( file_exists($folder_path . $preset. '/custom.css') ) {
			$customcss = @file_get_contents($folder_path . $preset. '/custom.css');
		} else {
			echo '|ERROR| File Not found : '.$folder_path . $preset. '/custom.css';
			exit();
		}

		echo $customcss;
		exit();
	}
}