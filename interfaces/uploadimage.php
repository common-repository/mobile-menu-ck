<?php
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */

// No direct access
defined('CK_LOADED') or die;


$input = new CKInput();
$file = $input->files->get('file', '', 'array');

if (!is_array($file)) {
	$msg = CKText::_('Error : No file received');
	echo '{"error" : "' . $msg . '"}';
	exit;
}

$filename = CKFile::makeSafe($file['name']);

// check the file extension // TODO recup preg_match de local dev
// if (CKFile::getExt($filename) != 'jpg') {
	// $msg = CKText::_('CK_NOT_JPG_FILE');
	// echo '{"error" : "'  $msg  '"}';
	// exit;
// }

//Set up the source and destination of the file
$src = $file['tmp_name'];

// check if the file exists
if (!$src || !CKFile::exists($src)) {
	$msg = CKText::_('Error : File does not exists');
	echo '{"error" : "' . $msg . '"}';
	exit;
}

// These files need to be included as dependencies when on the front end.
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

$attachment_id = media_handle_upload( 'file', $input->get('post_id') );
$upload_dir = wp_upload_dir();

if ( is_wp_error( $attachment_id ) ) {
	// There was an error uploading the image.
	$msg = CKText::_('Error : Unable to write the file');
	echo '{"error" : "' . $msg . '"}';
} else {
	// The image was uploaded successfully!
	echo '{"img" : "' . $upload_dir['url'] . '/' . $filename . '","datasrc" : "' . str_replace(home_url(), '', $upload_dir['url']) . '/' . $filename . '","title" : "' . $filename . '","id" : "' . $attachment_id . '"}';
}

exit;
