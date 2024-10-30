<?php
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
 
// No direct access
defined('CK_LOADED') or die;

class MobilemenuckViewIcons extends MobilemenuckView {

	protected $view = 'icons';

	/**
	 * Icons view display method
	 * @return void
	 * */
	function display($tpl = null) {
		$tpl = 'default';
		parent::display($tpl);
	}
}
