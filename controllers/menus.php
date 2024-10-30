<?php
Namespace Mobilemenuck;
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
// No direct access.
defined('CK_LOADED') or die;
// require_once MOBILEMENUCK_PATH . '/controller.php';

/**
 * Mobilemenus list controller class.
 */
class CKControllerMenus extends CKController {

	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'menu', $prefix = 'MobilemenuckModel', $config = Array()) {
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}