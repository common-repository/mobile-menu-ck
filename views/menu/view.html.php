<?php
/**
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
Namespace Mobilemenuck;
// No direct access
defined('CK_LOADED') or die;

class CKViewMenu extends CKView {

	protected $view = 'menu';

	protected $item;

	/**
	 * Display the view
	 */
	public function display($tpl = null) {
		// check if the user has the rights to access this page
		if (! CKFof::userCan('manage')) {
			CKFof::_die();
		}

		$id = $this->input->get('id', 0, 'int');
		$this->item = $this->get('menu', 'Data', $id);
		$this->imagespath = MOBILEMENUCK_MEDIA_URL . '/images/interface/';
		$this->fields = new CKFields();
		$this->fields->load_assets_files();
		$this->input = new CKInput();

		parent::display($tpl);
	}
}