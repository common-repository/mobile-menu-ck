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

class Menu
{
	/**
	 * Create the menu, call JS and CSS
	 *
	 * @return  string the mobile menu ID
	 *
	 */
	public static function load($selector, $options = array(), $inline = false) {
		require_once(MOBILEMENUCK_PLATFORM . '/loader.php');
		require_once('Mobile_Detect.php');

		// create a unique ID for the menu
		$menuid = 'mobilemenuck-' . (int) (microtime(true) * 100);

		$defaults = self::getDefaultOptions();
		$defaults['menuid'] = $menuid; // unique text identifier

		$options = array_merge($defaults, $options);

		// set the text for the menu bar
		switch ($options['showmobilemenutext']) {
			case 'none':
				$options['mobilemenutext'] = '&nbsp;';
				break;
			case 'default':
			default:
				$options['mobilemenutext'] = CKText::_('Menu');
				break;
			case 'custom':
				$options['mobilemenutext'] = addslashes($options['mobilemenutext']);
				break;
		}

		$file = MOBILEMENUCK_PLUGIN_MEDIA_URI . '/assets/mobilemenuck.js';
		$js = "jQuery(document).ready(function(){"
					. " new MobileMenuCK(jQuery('" . $selector . "'), {";
					foreach ($options as $name => $value) {
						$js .= $name . " : '" . $value . "',";
					}
			$js .= "});"
			. " });";
		$css = self::getMediaQueries($selector, $options);
		if ($inline) {
			CKLoader::loadScriptInline($file);
			CKLoader::loadScriptDeclarationInline($js);
			CKLoader::loadStyleDeclarationInline($css);
		} else {
			CKLoader::loadScript($file);
			CKLoader::loadScriptDeclaration($js);
			CKLoader::loadStyleDeclaration($css);
		}

		return $menuid;
	}

	public static function getDefaultOptions() {
		$defaults = [
//			'menuid' => $menuid											// unique text identifier
			'menubarbuttoncontent' => '&#x2261;'						// character to put in the button
			,'topbarbuttoncontent' => '×'								// character to put in the button
			,'showmobilemenutext' => 'default'							// default, custom, none
			,'mobilemenutext' => CKText::_('Menu')						// text to use if showmobilemenutext = custom
			,'container' => 'body'										// body, topfixed, menu
			,'detectiontype' => 'resolution'							// resolution, phone, tablet
			,'resolution' => '640'										// value in px
			,'usemodules' => '0'										// 0, 1
			,'useimages' => '0'											// 0, 1
			,'showlogo' => '1'											// 0 (no), 1 (yes), 2 (in menu bar), 3 (in top bar)
			,'showdesc' => '0'											// 0, 1
			,'displaytype' => 'accordion'								// flat, accordion, fade, push
			,'displayeffect' => 'normal'								// normal, slideleft, slideright, slideleftover, sliderightover, topfixed, open
			,'menuwidth' => '300'										// value in px
			,'openedonactiveitem' => '0'								// 0, 1
			,'mobilebackbuttontext' => CKText::_('Back')				// text
			,'menuselector' => 'ul'										// text
			,'uriroot' => site_url()									// base uri of the website
		];

		return $defaults;
	}

	/**
	 * Search for the CSS styles from default theme, or in the template
	 *
	 * @return  void
	 *
	 */
	public static function loadTheme($id, $inline = false, $themeid = null) {
		require_once(MOBILEMENUCK_PLATFORM . '/loader.php');

		$layoutcss = '';
		if ((int) $themeid) {
			$layoutcss = Helper::getStyleById($themeid, $select = 'layoutcss', $type = 'result');
		}
		// if we don't have a layout according to the ID, then use the default one
		if (!(int) $themeid || ! $layoutcss){
			$layoutcss = Helper::getLayoutCss();
		}
		Helper::makeCssReplacement($layoutcss);
		$css = str_replace('|ID|', '[data-id="' . $id . '"]', $layoutcss);

		if ($inline) {
			CKLoader::loadStyleDeclarationInline($css);
		} else {
			CKLoader::loadStyleDeclaration($css);
		}
	}

	/**
	 * Set the mediaqueries to hide - show the module and mobile bar
	 *
	 * @return  string - the css to load in the page
	 *
	 */
	private static function getMediaQueries($selector, $options) {
		$detect_type = $options['detectiontype'];
		$detect = new Mobile_Detect;
		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
		$bodypadding = ($options['container'] == 'body' || $options['container'] == 'topfixed') ? 'body { padding-top: 40px !important; }' : '';
		if ($detect_type == 'resolution') {
			$css = "#" . $options['menuid'] . "-mobile-bar { display: none; }
	@media only screen and (max-width:" . str_replace('px', '', $options['resolution']) . "px){
	" . $selector . " { display: none !important; }
	#" . $options['menuid'] . "-mobile-bar { display: block; }
	.mobilemenuck-hide {display: none !important;}
    " . $bodypadding . " }";
		} elseif (($detect_type == 'tablet' && $detect->isMobile()) || ($detect_type == 'phone' && $detect->isMobile() && !$detect->isTablet())) {
			$css = $selector . " { display: none !important; }
	#" . $options['menuid'] . "-mobile-bar { display: block; }
	.mobilemenuck-hide {display: none !important;}
    " . $bodypadding;
		} else {
			$css = '';
		}

		return $css;
	}

	/**
	 * Determines what to use as character
	 *
	 * @return  string - the html value
	 *
	 */
	static function getButtonContent($value, $styleParams) {
		switch ($value) {
			case 'hamburger':
				$content = '&#x2261;';
				break;
			case 'close':
				$content = '×';
				break;
			case 'custom' :
				$content = $styleParams->menubarbuttoncontentcustomtext;
				break;
			default :
			case 'none':
				$content = '';
				break;
		}
		return $content;
	}
}