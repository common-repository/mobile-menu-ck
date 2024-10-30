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

class CKControllerMenu extends CKController {

	protected $view = 'menu';

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
		MobilemenuckHelper::redirect(MOBILEMENUCK_ADMIN_EDIT_MENU_URL . '&view=menu&layout=edit&id=' . $editId);
	}

	public function copy() {
		$editIds = $this->input->get('cid', null, 'array');
		if (count($editIds)) {
			$id = (int) $editIds[0];
		} else {
			$id = (int) $this->input->get('id', null, 'int');
		}
		$model = $this->getModel('menu');
		if ($model->copy($id)) {
			MobilemenuckHelper::enqueueMessage('Item copied with success');
		} else {
			MobilemenuckHelper::enqueueMessage('Error : Item not copied');
		}

		// Redirect to the edit screen.
//		MobilemenuckHelper::redirect(MOBILEMENUCK_ADMIN_GENERAL_URL);
	}

	public function delete() {
		$editIds = $this->input->get('cid', null, 'array');
		if (count($editIds)) {
			$id = (int) $editIds[0];
		} else {
			$id = (int) $this->input->get('id', null, 'int');
		}
		$model = $this->getModel('menu');
		if ($model->delete($id)) {
			MobilemenuckHelper::enqueueMessage('Item deleted with success');
		} else {
			MobilemenuckHelper::enqueueMessage('Error : Item not deleted');
		}

		// Redirect to the edit screen.
//		MobilemenuckHelper::redirect(MOBILEMENUCK_ADMIN_GENERAL_URL);
	}

	public function save() {
		MobilemenuckHelper::checkToken('mobilemenuck_save_menu');

		// Get the data.
		$data = $this->input->getArray($_POST);

		$model = $this->getModel('menu');
		$id = $model->save($data);

//		 $wpdb->print_error();
		if (
				$id === false || $id === 0
			) {
				$msg = CKText::_('Error : Menu not saved.');;
			} else {
				$msg = CKText::_('Menu saved !');
			}

		// add the information message
		MobilemenuckHelper::enqueueMessage($msg);

		// redirect to the edition page
		MobilemenuckHelper::redirect(MOBILEMENUCK_ADMIN_EDIT_MENU_URL . '&id=' . (int) $id);
	}

	function cancel() {
		MobilemenuckHelper::redirect(MOBILEMENUCK_ADMIN_GENERAL_URL);
	}

	function download() {
		$filepath = $this->input->get('filepath', '', 'string');
		MobilemenuckHelper::pushFileForDownload($filepath);
	}
}