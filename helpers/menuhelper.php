<?php
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.template-creator.com - https://www.joomlack.fr - https://www.ceikay.com
 */
namespace Mobilemenuck;
// No direct access
defined('CK_LOADED') or die;

class Helper
{

	/**
	 * Render a html message
	 *
	 * @return  string
	 *
	 */
	public static function renderProMessage() {
		$html = '<div><a href="https://www.ceikay.com/plugins/mobile-menu-ck" target="_blank">Not available in the free version</a></div>';
		return $html;
	}

	/**
	 * List the replacement between the tags and the real final CSS rules
	 */
	public static function getCssReplacement() {
		$cssreplacements = Array(
			'[menu-bar]' => ' .mobilemenuck-bar-title'
			,'[menu-bar-button]' => ' .mobilemenuck-bar-button'
			,'[menu]' => '.mobilemenuck'
			,'[menu-topbar]' => ' .mobilemenuck-title'
			,'[menu-topbar-button]' => ' .mobilemenuck-button'
			,'[level1menuitem]' => ' .mobilemenuck-item > .level1'
			,'[level2menuitem]' => ' .mobilemenuck-item > .level2'
			,'[level3menuitem]' => ' .level2 + .mobilemenuck-submenu .mobilemenuck-item > div'
			,'[togglericon]' => ' .mobilemenuck-togglericon:after'
			,'[PRESETS_URI]' => MOBILEMENUCK_MEDIA_URI . '/presets'
		);

		return $cssreplacements;
	}

	/**
	 * Do the replacement between the tags and the real final CSS rules
	 */
	public static function makeCssReplacement(&$css) {
		$cssreplacementlist = self::getCssReplacement();
		foreach ($cssreplacementlist as $tag => $rep) {
			$css = str_replace($tag, $rep, $css);
		}
	}

	/**
	 * Get the name of the style
	 */
	public static function getStyleNameById($id) {
		if (! $id) return '';
		// Create a new query object.
		$db = \JFactory::getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select('a.name');
		$query->from($db->quoteName('#__mobilemenuck_styles') . ' AS a');
		$query->where('(a.state IN (0, 1))');
		$query->where('a.id = ' . (int)$id);

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$result = $db->loadResult();

		return $result;
	}

	/**
	 * Get the name of the style
	 */
	public static function getStyleById($id, $select = '*', $type = 'result') {
		if (! $id) return '';
		// Create a new query
		global $wpdb;
		$query = "SELECT " . $select . " FROM " . $wpdb->prefix . "mobilemenuck_styles WHERE id = " . (int) $id;

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		switch ($type) {
			default:
			case 'result' : 
				$result = $wpdb->get_var($query);
			break;
			case 'object' :
				$result = $wpdb->get_results($query, OBJECT);
			break;
			case 'row' :
				$result = $wpdb->get_row($query, OBJECT);
			break;
		}

		return $result;
	}

	/**
	 * Get the list of all styles
	 */
	public static function getStylesList() {
		$result = self::getStyles('id, name');

		return $result;
	}

	/**
	 * Get the name of the style
	 */
	public static function getStyles($select = '*') {
		$query = "SELECT " . $select . " FROM #__mobilemenuck_styles WHERE state = 1";

		$result = CKFof::dbLoadObjectList($query);

		return $result;
	}

	/**
	 * Look if the pro version is installed
	 * 
	 * @return  boolean
	 */
	public static function checkIsProVersion() {
		return true;
	}
	
	public static function createIdForModule($module) {
//		if ($module->module == 'mod_maximenuck') {
//			$params = new \JRegistry($module->params);
//			if ($params->get('menuid', '') === '' || is_numeric($params->get('menuid', ''))) {
//				$id = 'maximenuck' . $module->id;
//			} else {
//				$menuID = $params->get('menuid', '');
//			}
//		} else {
			$id = 'mobilemenuck-' . $module->id;
//		}
		return $id;
	}

	public static function getLayoutCss() {
//		$overrideSrc = JPATH_ROOT . '/templates/' . $doc->template . '/css/mobilemenuck.css';
//		if (file_exists($overrideSrc)) {
//			$layoutcss = file_get_contents($overrideSrc);
//		} else {
			$layoutcss = file_get_contents(MOBILEMENUCK_PATH . '/assets/default.txt');
//		}

		return $layoutcss;
	}
}