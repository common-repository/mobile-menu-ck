<?php
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
// Namespace Mobilemenuck;
// No direct access
defined('CK_LOADED') or die;

/**
 * Helper Class.
 */
class MobilemenuckFrontHelper {

	protected static $cssDeclaration;

	protected static $cssSheet = array();

	protected static $compile = null;

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return	JObject
	 * @since	1.6
	 */
	public static function createParamsFromElement($obj) {
		if (is_array($obj) && isset($obj[0]->attr)) {
			$result = new PagebuilderckParams($obj[0]->attr);
		} else {
			$result = new PagebuilderckParams();
		}
		return $result;
	}

	/**
	 * Return the needed url for the source
	 * 
	 * @return string
	 */
	public static function getSource($src) {
		$isLocal = substr($src, 0, 4) == 'http' ? false : true;
		if ($isLocal) $src = JUri::root(true) . '/' . $src;
		return $src;
	}

	/**
	 * Test if there is already a unit, else add the px
	 *
	 * @param string $value
	 * @return string
	 */
	public static function testUnit($value, $defaultunit = "px") {

		if ((stristr($value, 'px')) OR (stristr($value, 'em')) OR (stristr($value, '%')) OR $value == 'auto')
			return $value;

		return $value . $defaultunit;
	}

	/**
	 * Check if we have to compile according to component options
	 */
	private static function doCompile() {
		return true; // TODO à faire
		// if admin, then exit immediately
		if (JFactory::getApplication()->isAdmin()) return false;
		// if in edition mode, then exit immediately
		$input = new CKInput();
		if ($input->get('layout', '', 'cmd') === 'edit') return false;
		// check the option from the component
		if (self::$compile == null) {
//			$params = JComponentHelper::getParams('com_pagebuilderck'); // TODO récup params dans plugin
			self::$compile = $params->get('compile', '0');
		}
		return self::$compile;
	}

	/**
	 * Call the needed JS and CSS files to render in frontend
	 */
	public static function loadFrontendAssets() {
		$params = JComponentHelper::getParams('com_pagebuilderck');
		JHtml::_('jquery.framework');
		$doc = JFactory::getDocument();
//		$doc->addScript(JUri::root(true) . '/media/jui/js/jquery.min.js');
		PagebuilderckFrontHelper::addStyleSheet(JUri::root(true) . '/components/com_pagebuilderck/assets/pagebuilderck.css');
		if ($params->get('loadfontawesome','1')) $doc->addStyleSheet(JUri::root(true) . '/components/com_pagebuilderck/assets/font-awesome.min.css');
		$doc->addScript(JUri::root(true) . '/components/com_pagebuilderck/assets/jquery-uick.js');
		$doc->addScript(JUri::root(true) . '/components/com_pagebuilderck/assets/pagebuilderck.js');
	}

	/**
	 * Manage the css inclusion in the page according to the component options
	 *
	 * @param string $value
	 * @return void
	 */
	public static function addStyleDeclaration($css) {
//		$compile = true; //TODO : tester si admin, ne pas compiler
		if (self::doCompile()) {
			self::$cssDeclaration .= $css;
		} else {
			$doc = JFactory::getDocument();
			$doc->addStyleDeclaration($css);
		}
	}

	/**
	 * Manage the css inclusion in the page according to the component options
	 *
	 * @param string $value
	 * @return void
	 */
	public static function addStylesheet($file) {
		$input = JFactory::getApplication()->input;
//		$compile = true; //TODO : tester si admin, ne pas compiler
		if (self::doCompile()) {
			if (! in_array($file, self::$cssSheet)) self::$cssSheet[] = $file;
		} else {
			$doc = JFactory::getDocument();
			$doc->addStylesheet($file);
		}
	}

	/**
	 * Return the global css styles stored
	 *
	 * @param string $value
	 * @return void
	 */
	public static function loadAllCss() {
		if (! self::doCompile()) return;
		$input = JFactory::getApplication()->input;
		$uri = JFactory::getURI();
		$query = $uri->getPath();
		$query = str_replace(JUri::root(true), '', $query);
		
		$clearPath = preg_replace("/[^a-zA-Z0-9]+/", "", $query);

		$cssContent = '';
		// get the style sheets
		foreach(self::$cssSheet as $sheet) {
			$path = str_replace(JUri::root(true), '', $sheet);
			$tmp = file_get_contents(JPATH_ROOT . $path);
			$cssContent .= $tmp;
		}

		// get the inline styles
		$cssContent .= self::$cssDeclaration;

		if (trim($cssContent)) {
			$file = '/compiled/pagebuilderck_' . $clearPath . '_compiled.css';
			file_put_contents(PAGEBUILDERCK_MEDIA_PATH . $file, $cssContent);
			$doc = JFactory::getDocument();
			$doc->addStyleSheet(PAGEBUILDERCK_MEDIA_URI . $file);
		}
	}

	public static function load_styles() {
//		wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/css/custom-style.css' );
//		wp_add_inline_style( 'custom-style', '.tata {color:red;}' );
//		wp_add_inline_style( 'custom-style', self::$cssDeclaration );
		echo '<style>' . self::$cssDeclaration . '</style>';
	}
}