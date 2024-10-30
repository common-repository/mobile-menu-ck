<?php
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */

defined('CK_LOADED') or die('Restricted access');

$type = $this->input->get('type', '', 'string');
if (! $type) die('No type given. Error.');

require_once MOBILEMENUCK_PATH . '/addons/' . $type . '/' . $type . '.php';
$addonClassName = 'MobilemenuckAddon' . ucfirst($type);
$addonClass = new $addonClassName();
$functionName = 'onMobilemenuckLoadItemContent' . ucfirst($type);
$addonClass->$functionName();