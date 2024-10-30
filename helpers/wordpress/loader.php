<?php
/**
 * @copyright	Copyright (C) 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.template-creator.com - https://www.joomlack.fr - https://www.ceikay.com
 */
namespace Mobilemenuck;
// No direct access
defined('CK_LOADED') or die;

class CKLoader
{
	private static function getFileName($file) {
		$f = explode('/', $file);
		$fileName = end($f);
		$f = explode('.', $fileName);
		$ext = end($f);
		$fileName = str_replace('.' . $ext, '', $fileName);

		return $fileName;
	}

	public static function loadScriptDeclaration($js) {
		echo '<script>' . $js . '</script>';
	}

	public static function loadScriptDeclarationInline($js) {
		echo '<script>' . $js . '</script>';
	}

	public static function loadScript($file) {
		wp_enqueue_script( 'mobilemenuck' . self::getFileName($file), $file );
	}

	public static function loadScriptInline($file) {
		echo '<script src="' . $file . '"></script>';
	}

	public static function loadStyleDeclaration($css) {
		echo '<style>' . $css . '</style>';
	}

	public static function loadStyleDeclarationInline($css) {
		echo '<style>' . $css . '</style>';
	}

	public static function loadStylesheet($file) {
		wp_enqueue_style( 'mobilemenuck' . self::getFileName($file), $file );
	}

	public static function loadStylesheetInline($file) {
		echo '<link href="' . $file . '"" rel="stylesheet" />';
	}
}