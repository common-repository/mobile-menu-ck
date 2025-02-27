<?php
/**
 * @name		Mobile Menu CK
 * @package		com_mobilemenuck
 * @copyright	Copyright (C) 2017. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - http://www.template-creator.com - http://www.joomlack.fr
 */
 
defined('CK_LOADED') or die;
?>
<div class="" id="ckimportpopup" style="padding:10px;display:none;">
	<div class=""><h1><?php echo CKText::_('CK_IMPORT'); ?></h1></div>
		<br />
		<form id="importpage" name="importpage" method="post" enctype="multipart/form-data">
			<div>
				<fieldset>
					<table class="table table-striped">
						<tr>
							<td width="110" class="key">
								<label for="title">
									<?php echo CKText::_('CK_CHOOSE_FILE_MMCK'); ?>:
								</label>
							</td>
							<td>
								<input class="inputbox" type="file" name="file" id="file" size="60" />
								<input type="submit" name="submitfile" class="inputbox btn" value="<?php echo CKText::_('CK_INSTALL'); ?>" />
							</td>
						</tr>
					</table>
				</fieldset>
			</div>
			<?php echo JHtml::_('form.token'); ?>
			<input type="hidden" name="task" value="uploadParamsFile" />
		</form>
</div>
<div id="ckexportpopup" class="" style="position:relative;display:none;">
	<div style="padding: 10px;">
		<div class="ckexportmodalcontent">
			<div class="" id="">
				<div class=""><h1><?php echo CKText::_('CK_EXPORT'); ?></h1></div>
					<div id="ckexportpagedownload" style="border-top: 1px solid #ddd;padding: 0.75em;text-align: center;">

					</div>
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).ready(function() {
		jQuery("form#importpage").on('submit', function(e) { 
			e.preventDefault();
			var form = document.forms.namedItem('importpage');
			var formData = new FormData(form);
			ckUploadParamsFile(formData);
			return false;
		});
	});
</script>