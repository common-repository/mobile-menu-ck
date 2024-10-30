<?php
/**
 * @copyright	Copyright (C) since 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
Namespace Mobilemenuck;
// No direct access
defined('CK_LOADED') or die;

/**
 * View to edit
 */
class CKViewStyle extends CKView {

	protected $view = 'style';

	protected $item;

	/**
	 * Display the view
	 */
	public function display($tpl = null) {
		// check if the user has the rights to access this page
		if (! CKFof::userCan('manage')) {
			CKFof::_die();
		}

		$id = $this->input->get('id', 0, 'int');
		$this->item = $this->get('style', 'Data', $id);
		$this->imagespath = MOBILEMENUCK_MEDIA_URL . '/images/interface/';
		$this->interface = new CKInterfaceLight();
		$this->input = new CKInput();

		parent::display($tpl);
	}

	protected function renderPreviewMenu() {
		?>
		<div id="mobilemenuck-preview-mobile-bar" class="mobilemenuck-bar" style="display:block;">
			<span class="mobilemenuck-bar-title">Menu</span>
			<div class="mobilemenuck-bar-button" onclick="jQuery('#mobilemenuck-preview-mobile-bar').hide();jQuery('#mobilemenuck-preview-mobile').show();">&#x2261;</div>
		</div>
		<div id="mobilemenuck-preview-mobile" class="mobilemenuck" style="position: relative !important; z-index: 100000; display: none;">
				<div class="mobilemenuck-topbar">
					<span class="mobilemenuck-title">Menu</span>
					<span class="mobilemenuck-button" onclick="jQuery('#mobilemenuck-preview-mobile').hide();jQuery('#mobilemenuck-preview-mobile-bar').show();">×</span>
				</div>
				<div class="mobilemenuck-item">
					<div class="maximenuck first level1 ">
						<a href="javascript:void(0)">
							<span class="mobiletextck">Lorem</span>
						</a>
					</div>
				</div>
				<div class="mobilemenuck-item">
					<div class="maximenuck parent level1">
						<a href="javascript:void(0)">
							<span class="mobiletextck">Ipsum</span>
						</a>
					</div>
					<div class="mobilemenuck-submenu">
						<div class="mobilemenuck-item">
							<div class="maximenuck parent first level2 ">
								<a href="javascript:void(0)">
									<span class="mobiletextck">Dolor sit</span>
								</a>
							</div>
							<div class="mobilemenuck-submenu">
								<div class="mobilemenuck-item">
									<div class="maximenuck first level3 ">
										<a href="javascript:void(0)">
											<span class="mobiletextck">Consectetur</span>
										</a>
									</div>
								</div>
								<div class="mobilemenuck-item">
									<div class="maximenuck last level3 ">
										<a href="javascript:void(0)">
											<span class="mobiletextck">Adipiscing</span>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="mobilemenuck-item">
							<div class="maximenuck parent level2 ">
								<a href="javascript:void(0)">
									<span class="mobiletextck">Sed maximus</span>
								</a>
							</div>
							<div class="mobilemenuck-submenu">
								<div class="mobilemenuck-item">
									<div class="maximenuck first level3 ">
										<a href="javascript:void(0)">
											<span class="mobiletextck">Vivamus</span>
										</a>
									</div>
								</div>
								<div class="mobilemenuck-item">
									<div class="maximenuck level3 ">
										<a href="javascript:void(0)">
											<span class="mobiletextck">Fusce porta</span>
										</a>
									</div>
								</div>
								<div class="mobilemenuck-item">
									<div class="maximenuck last level3 ">
										<a href="javascript:void(0)">
											<span class="mobiletextck">Pellentesque</span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="mobilemenuck-item">
					<div class="maximenuck parent level1 accordionmobileck">
						<a href="javascript:void(0)">
							<span class="mobiletextck">Maecenas</span>
						</a>
						<div class="mobilemenuck-togglericon" onclick="jQuery(this).parent().toggleClass('open')"></div>
					</div>
					<div class="mobilemenuck-submenu">
						<div class="mobilemenuck-item">
							<div class="maximenuck parent first level2 accordionmobileck">
								<a href="javascript:void(0)">
									<span class="mobiletextck">Vel convallis</span>
								</a>
								<div class="mobilemenuck-togglericon" onclick="jQuery(this).parent().toggleClass('open')"></div>
							</div>
							<div class="mobilemenuck-submenu">
								<div class="mobilemenuck-item">
									<div class="maximenuck first level3 ">
									<a href="javascript:void(0)">
									<span class="mobiletextck">Facilisis</span>
									</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
	}
}