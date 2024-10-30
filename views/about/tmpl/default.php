<?php
/**
 * @name		Mobile Menu CK
 * @copyright	Copyright (C) 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
Namespace Mobilemenuck;
// No direct access to this file
defined('CK_LOADED') or die('Restricted access');
?>
<link rel="stylesheet" href="<?php echo MOBILEMENUCK_MEDIA_URL ?>/assets/admin.css" type="text/css" />
<link rel="stylesheet" href="<?php echo MOBILEMENUCK_MEDIA_URL ?>/assets/ckframework.css" type="text/css" />
<style>
	.ckaboutversion {
		margin: 10px;
		padding: 10px;
		font-size: 20px;
		font-color: #000;
		text-align: center;
	}
	.ckcenter {
		text-align: center;
	}
	.ckabout {
		background: url("https://media.joomlack.fr/images/texture/texture_003.jpg") center center repeat;
		background-size: auto auto;
		color: #fff;
		font-family: verdana;
		font-size: 13px;
		border-radius: 5px;
		box-shadow: #111 0 0 5px;
		background-size: cover;
		position: relative;
		overflow: hidden;
		margin: 20px 10px 20px 10px;
	}
	.ckabout > .inner {
		padding: 20px;
		background: rgba(40,40,40,0.7);
	}
	.ckabout > .inner > * {
		padding: 5px;
	}
	.ckabout a {
		color: orange;
	}
	.ckabout a:hover {
		color: white;
	}
	.ckabout .ckbutton {
		background: rgba(255,255,255, 0.2);
		border-radius: 4px;
		padding: 10px 20px;
		color: #fff;
		text-transform: uppercase;
		font-size: 11px;
	}
	.ckabout .ckbutton:hover {
		background: rgba(255,153,0, 0.3);
		color: orange;
	}
</style>
<div class="ckabout">
	<div class="inner">
		<div class="ckcenter"><img src="<?php echo MOBILEMENUCK_MEDIA_URI ?>/images/logo_mobilemenuck_64.png" /></div>
		<p class="ckcenter">MOBILE MENU CK</p>
		<div class="ckcenter"><?php echo CKText::_('Installed version') . ' : <span class="ckbadge">' . MOBILEMENUCK_VERSION . '</span>'; ?></div>
		<p class="ckcenter"><a href="https://www.ceikay.com" target="_blank">https://www.ceikay.com</a></p>
		<p class="ckcenter"><?php echo CKText::_('Mobile Menu CK allows you to add a mobile version of your menus with ease.'); ?></p>
		<p class="ckcenter"><a class="ckbutton" href="https://www.ceikay.com/documentation/mobile-menu-ck/" target="_blank"><?php echo CKText::_('Read the documentation'); ?></a></p>
	</div>
</div>