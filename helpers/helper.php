<?php
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */

Namespace Mobilemenuck;
// No direct access
defined('CK_LOADED') or die;
/**
 * Mobilemenuck helper.
 */
class MobilemenuckHelper {

	static $keepMessages = false;

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

	/*
	 * Load the JS and CSS files needed to use CKBox
	 *
	 * Return void
	 */
	public static function loadCkbox() {
		?>
		<link rel="stylesheet" href="<?php echo MOBILEMENUCK_MEDIA_URL ?>/assets/ckbox.css" type="text/css" />
		<script type="text/javascript" src="<?php echo MOBILEMENUCK_MEDIA_URL ?>/assets/ckbox.js" type="text/css"></script>
		<?php
	}

	/*
	 * Load the JS and CSS files needed to use CKBox
	 *
	 * Return void
	 */
	public static function loadCKFramework() {
		$doc = JFactory::getDocument();
		$doc->addScript(JUri::root(true) . '/media/jui/js/jquery.min.js');
		$doc->addStyleSheet(MOBILEMENUCK_MEDIA_URL . '/assets/ckframework.css');
	}

	/*
	 * Load the JS and CSS files needed to use CKBox
	 *
	 * Return void
	 */
	public static function loadInlineCKFramework() {
	?>
		<link rel="stylesheet" href="<?php echo MOBILEMENUCK_MEDIA_URL ?>/assets/ckframework.css" type="text/css" />
	<?php
	}

	/*
	 * Replace the variables to store the file
	 * 
	 * @return string, the json encoded item
	 */
	public static function getExportFile($item) {
		$item->htmlcode = str_replace(MOBILEMENUCK_URI_ROOT, "|CKURIROOT|", $item->htmlcode);
		$exportfiletext = json_encode($item);

		return $exportfiletext;
	}

	/**
	 * Give the file directly for download in the browser
	 * 
	 * @param type $file
	 */
	public static function pushFileForDownload($filepath) {
		$filepath = MOBILEMENUCK_PATH . $filepath;
		$filename = basename($filepath);
		header('Content-type: application/zip');
		header("Content-Disposition: attachment; filename=$filename");                             
		header("Content-Length: " . filesize($filepath));

		readfile($filepath);

		exit();
	}

	/**
	 * Utility function to map an array to a stdClass object.
	 *
	 * @param   array    $array      The array to map.
	 * @param   string   $class      Name of the class to create
	 * @param   boolean  $recursive  Convert also any array inside the main array
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public static function toObject(array $array, $class = 'stdClass', $recursive = true)
	{
		$obj = new $class;

		foreach ($array as $k => $v)
		{
			if ($recursive && is_array($v))
			{
				$obj->$k = static::toObject($v, $class);
			}
			else
			{
				$obj->$k = $v;
			}
		}

		return $obj;
	}

	public static function getToken($name = 'mobilemenuck') {
		return wp_create_nonce($name);
	}

	public static function checkToken($token = 'mobilemenuck_save') {
		if (! wp_verify_nonce($_REQUEST['_wpnonce'], $token)) {
			$msg = CKText::_('Invalid token');
			exit($msg);
		}
	}

	/**
	 * Check the token for security reason
	 * @return boolean
	 */
	public static function checkAjaxToken() {
		if (! isset($_REQUEST['CKTOKEN']) || ! wp_verify_nonce($_REQUEST['CKTOKEN'], 'mobilemenuck')) {
			$msg = CKText::_('Invalid Token');
			echo '{"status": "0", "message": "' . $msg . '"}';
			exit();
		}
		return true;
	}

	public static function redirect($url, $msg = '', $type = '') {
		if ($msg) {
			self::enqueueMessage($msg, $type);
		}
		// If the headers have been sent, then we cannot send an additional location header
		// so we will output a javascript redirect statement.
		if (headers_sent())
		{
			self::$keepMessages = true;
			echo "<script>document.location.href='" . str_replace("'", '&apos;', $url) . "';</script>\n";
		}
		else
		{
			self::$keepMessages = true;
			// All other browsers, use the more efficient HTTP header method
			header('HTTP/1.1 303 See other');
			header('Location: ' . $url);
			header('Content-Type: text/html; charset=UTF-8');
		}
	}

	public static function enqueueMessage($msg, $type = 'message') {
		// add the information message
		$transient[] = Array("text" => CKText::_($msg), "type" => $type);
		set_transient( 'mobilemenuck_message', $transient, 60 );
	}

	public static function displayMessages() {
		// manage the information messages
		if ($messages = get_transient( 'mobilemenuck_message' )) {
			if (! empty($messages)) {
				foreach ($messages as $message) {
					if (is_array($message)) {
						$type = $message["type"] == 'error' ? 'danger': ($message["type"] == 'success' ? 'success' : 'info');
						echo '<div class="ckalert ckalert-' . $type . '">' . $message["text"] . '<div class="ckclose" onclick="jQuery(this).parent().remove()">×</div></div>';
					} else {
						echo '<div class="ckalert ckalert-warning">' . $message . '<div class="ckclose" onclick="jQuery(this).parent().remove()">×</div></div>';
					}
				}
			}
			if (self::$keepMessages == false) delete_transient( 'mobilemenuck_message' );
		}
	}

	public static function copyright() {
		$html = array();
		$html[] = '<hr style="margin:10px 0;clear:both;" />';
		$html[] = '<div class="ckpoweredby"><a href="https://www.ceikay.com" target="_blank">https://www.ceikay.com</a></div>';
		$html[] = '<div class="ckproversioninfo"><div class="ckproversioninfo-title"><a href="' . MOBILEMENUCK_WEBSITE . '" target="_blank">' . __('Get the Pro version', 'mobile-menu-ck') . '</a></div>
		<div class="ckproversioninfo-content">
<p>PHP / JS features</p>
<p>Drag’n drop interface</p>
<p>Default theme</p>
<p>CSS Override</p>
<p>Forum support</p>
<p>Styling / Design interface</p>
<p>Themes included</p>
<p>Custom menu creation</p>
<p>Merging feature</p>
<p>Use on multiple domains</p>
<p>1 Year updates</p>
<div class="ckproversioninfo-button"><a href="' . MOBILEMENUCK_WEBSITE . '" target="_blank">' . __('Get the Pro version', 'mobile-menu-ck') . '</a></div>
		</div>';
		
		return implode($html);
	}
}
