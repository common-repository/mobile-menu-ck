<?php
Namespace Mobilemenuck;
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
// No direct access
defined('CK_LOADED') or die;
require_once MOBILEMENUCK_PATH . '/controller.php';

class CKControllerInterface extends CKController {

	/**
	 * Load the needed interface
	 * 
	 * @return void
	 */
	public function load() {
		// security check
		MobilemenuckHelper::checkAjaxToken();

		$input = new CKInput();
		$layout = $input->get('layout', '', 'cmd');
		if (! $layout) return;

		$this->input = new CKInput();
		$this->interface = new CKInterface();
		$this->imagespath = MOBILEMENUCK_MEDIA_URL . '/images/interface/';

		require_once(MOBILEMENUCK_PATH . '/interfaces/' . $layout . '.php');
		exit;
	}
}