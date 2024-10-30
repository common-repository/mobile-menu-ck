<?php
// Namespace Mobilemenuck;

class CKLicenseKey
{
	public static function key_manager($plugin) {
		// add_option to store
		$key = get_option('license_key_' . $plugin);
		ob_start();
		$jsFuncName = str_replace('-', '_', $plugin);
		?>
		<script>
		function ck_submit_license_key_<?php echo $jsFuncName ?>() {
			if (! document.getElementById('license_key_<?php echo $plugin ?>').value) {
				alert('<?php _e('Please fill the license number', $plugin) ?>');
				return;
			}
			var data = {
				action: 'save_license_key',
				// plugin: '<?php echo $plugin ?>',
				_wpnonce: '<?php echo wp_create_nonce('save_license_key_' . $plugin); ?>',
				key: document.getElementById('license_key_<?php echo $plugin ?>').value
			};
			jQuery.post(ajaxurl, data, function(response) {
				console.log(response);
			});
		}
		</script>
		<a href="javascript:void(0)" onclick="var a=document.getElementById('license_key_<?php echo $plugin ?>_wrap');var adisplay=a.style.display=='block'?'none':'block';a.style.display=adisplay;"><?php _e('Manage the license key', $plugin) ?></a>
		<div id="license_key_<?php echo $plugin ?>_wrap" style="display:none;">
				<input type="text" id="license_key_<?php echo $plugin ?>" placeholder="<?php _e('License key number', $plugin) ?>" value="<?php echo $key ?>"/>
				<a class="button" href="javascript:void(0)" onclick="ck_submit_license_key_<?php echo $jsFuncName ?>()"><?php _e('Save', $plugin) ?></a>
			<div><a href="https://www.ceikay.com/documentation/miscellaneous/how-to-use-your-license-code/" target="_blank"><?php _e('Read the documentation', $plugin) ?></a></div>
		</div>
		<?php
		$output = ob_get_clean();

		return $output;
	}

	public static function save_license($plugin) {
		if (! isset($_POST['_wpnonce']) || ! isset($_POST['key'])) wp_die('Access denied.');

		$wpnonce = $_POST['_wpnonce'];
		$key = $_POST['key'];

		if (! wp_verify_nonce($_POST['_wpnonce'], 'save_license_key_' . $plugin)) {
			wp_die('Wrong token.');
		}
		update_option('license_key_' . $plugin, $key);
		exit;
	}
}



