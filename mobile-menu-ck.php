<?php
/**
 * Plugin Name: Mobile Menu CK
 * Plugin URI: https://www.ceikay.com/plugins/mobile-menu-ck
 * Version: 1.0.2
 * Description: Mobile Menu CK is the perfect solution to create your mobile menus.
 * Author: Cédric KEIFLIN
 * Author URI: https://www.ceikay.com
 * License: GPL2
 * Text Domain: mobile-menu-ck
 * Domain Path: /language
 */

Namespace Mobilemenuck;

defined('ABSPATH') or die;

if (! defined('CK_LOADED')) define('CK_LOADED', 1);
if (! defined('MOBILEMENUCK_PLATFORM')) define('MOBILEMENUCK_PLATFORM', 'wordpress');
if (! defined('MOBILEMENUCK_PATH')) define('MOBILEMENUCK_PATH', dirname(__FILE__));
if (! defined('MOBILEMENUCK_MEDIA_PATH')) define('MOBILEMENUCK_MEDIA_PATH', MOBILEMENUCK_PATH);
if (! defined('MOBILEMENUCK_PROJECTS_PATH')) define('MOBILEMENUCK_PROJECTS_PATH', MOBILEMENUCK_PATH . '/projects');
if (! defined('MOBILEMENUCK_ADMIN_EDIT_MENU_URL')) define('MOBILEMENUCK_ADMIN_EDIT_MENU_URL', admin_url('', 'relative') . 'admin.php?page=mobilemenuck_edit_menu');
if (! defined('MOBILEMENUCK_ADMIN_EDIT_STYLE_URL')) define('MOBILEMENUCK_ADMIN_EDIT_STYLE_URL', admin_url('', 'relative') . 'admin.php?page=mobilemenuck_edit_style');
if (! defined('MOBILEMENUCK_ADMIN_GENERAL_URL')) define('MOBILEMENUCK_ADMIN_GENERAL_URL', admin_url('', 'relative') . 'admin.php?page=mobilemenuck_general');
if (! defined('MOBILEMENUCK_MEDIA_URL')) define('MOBILEMENUCK_MEDIA_URL', plugins_url('', __FILE__));
if (! defined('MOBILEMENUCK_MEDIA_URI')) define('MOBILEMENUCK_MEDIA_URI', MOBILEMENUCK_MEDIA_URL);
if (! defined('MOBILEMENUCK_PLUGIN_MEDIA_URI')) define('MOBILEMENUCK_PLUGIN_MEDIA_URI', MOBILEMENUCK_MEDIA_URL);
if (! defined('MOBILEMENUCK_PLUGIN_URL')) define('MOBILEMENUCK_PLUGIN_URL', MOBILEMENUCK_MEDIA_URL);
if (! defined('MOBILEMENUCK_URL')) define('MOBILEMENUCK_URL', MOBILEMENUCK_MEDIA_URL);
if (! defined('MOBILEMENUCK_THEMES_PATH')) define('MOBILEMENUCK_THEMES_PATH', ABSPATH . '/wp-content/themes');
if (! defined('MOBILEMENUCK_SITE_ROOT')) define('MOBILEMENUCK_SITE_ROOT', ABSPATH);
if (! defined('MOBILEMENUCK_URI_ROOT')) define('MOBILEMENUCK_URI_ROOT', site_url());
if (! defined('MOBILEMENUCK_URI_BASE')) define('MOBILEMENUCK_URI_BASE', admin_url('', 'relative'));
if (! defined('MOBILEMENUCK_WEBSITE')) define('MOBILEMENUCK_WEBSITE', 'http://www.ceikay.com/plugins/mobile-menu-ck/');
// global vars
if (! defined('CEIKAY_MEDIA_URL')) define('CEIKAY_MEDIA_URL', 'https://media.ceikay.com');

class Mobilemenuck {

	private static $instance;

	private $input;

	private $styles;

	static function getInstance() { 
		if (!isset(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function init() {
		require_once MOBILEMENUCK_PATH . '/helpers/cktext.php';
		require_once MOBILEMENUCK_PATH . '/helpers/menuhelper.php';
		require_once MOBILEMENUCK_PATH . '/helpers/menu.php';
		require_once MOBILEMENUCK_PATH . '/helpers/function.php';

		// register the mobilemenu to call it
		add_shortcode('mobilemenuck', array($this, 'load_mobilemenu'));

		// load the translation
		add_action('plugins_loaded', array($this, 'load_textdomain'));

		// load the menus
		add_action('wp_footer', array($this, 'load_mobilemenus'));

		// load jquery in admin
		add_action('admin_enqueue_scripts', array($this, 'load_jquery'));

		if (is_admin()) {

		}
	}

	/**
	 * Create menu links in the admin
	 */
	public function admin_menu() {
		$update_status = get_transient('mobilemenuck_udpate_status') ? get_transient('mobilemenuck_udpate_status') : '';
		add_menu_page('Mobile Menu CK', 'Mobile Menu CK', 'edit_plugins', 'mobilemenuck_general', array($this, 'render_general'), MOBILEMENUCK_PLUGIN_URL . '/images/admin_menu.png');
		add_submenu_page('mobilemenuck_general', __('Mobile Menu CK'), __('All menus'), 'edit_plugins', 'mobilemenuck_general', array($this, 'render_general'));
		add_submenu_page('mobilemenuck_general', __('Mobile Menu CK'), __('All styles'), 'edit_plugins', 'mobilemenuck_styles', array($this, 'render_styles'));
		// add_submenu_page('mobilemenuck_general', __('Mobile Menu CK'), __('Help'), 'edit_plugins', 'mobilemenuck_help', array($this, 'render_help'));
//		add_submenu_page('mobilemenuck_general', __('Mobile Menu CK'), __('About'), 'edit_plugins', 'mobilemenuck_about', array($this, 'render_about'));
		add_submenu_page('mobilemenuck_general', __('Edit'), __('Add new menu'), 'edit_plugins', 'mobilemenuck_edit_menu', array($this, 'render_edit_menu'));
		add_submenu_page('mobilemenuck_general', __('Edit'), __('Add new style'), 'edit_plugins', 'mobilemenuck_edit_style', array($this, 'render_edit_style'));
	}

	public function callHelpers() {
		// include the classes
		require_once MOBILEMENUCK_PATH . '/helpers/ckfof.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckfilterinput.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckparams.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckinput.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckpath.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckfile.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckfolder.php';
		require_once MOBILEMENUCK_PATH . '/helpers/cktext.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckfields.php';
		require_once MOBILEMENUCK_PATH . '/helpers/helper.php';
		// require_once MOBILEMENUCK_PATH . '/helpers/helperfront.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckinterfacelight.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckstyles.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckcontroller.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckmodel.php';
	}

	public function render_page($view, $layout = 'default') {

		$this->callHelpers();

		$this->input = new CKInput();
		$tasks = $this->input->get('task', '', 'cmd');
		if ($tasks) {
			$tasks = explode('.', $tasks);
			if (count($tasks) == 2) {
				$controllerName = $tasks[0];
				$controllerClassName = '\Mobilemenuck\CKController' . ucfirst($tasks[0]);
				$task = $tasks[1];
				require_once MOBILEMENUCK_PATH . '/controllers/' . $controllerName . '.php';
				$controller = new $controllerClassName();
				$controller->$task();
			} else {
				$task = $tasks[0];
				// require_once MOBILEMENUCK_PATH . '/helpers/ckcontroller.php';
				$controller = new CKController();
				$controller->$task();
			}
		}

		// load the view
		$layout = $this->input->get('layout', $layout, 'cmd');
		$view = $this->input->get('view', $view, 'cmd');
		require_once MOBILEMENUCK_PATH . '/helpers/ckview.php';
		require_once MOBILEMENUCK_PATH . '/views/' . $view . '/view.html.php';
		$className = '\Mobilemenuck\CKView' . ucfirst($view);
		$classInstance = new $className();
		$classInstance->display($layout);
	}

	function render_general() {
		$this->render_page('menus');
	}

	function render_styles() {
		$this->render_page('styles');
	}

	function render_help() {
		$this->render_page('help');
	}

	function render_about() {
		$this->render_page('about');
	}

	function render_edit_menu() {
		$this->render_page('menu', 'edit');
	}

	function render_edit_style() {
		$this->render_page('style', 'edit');
	}

	function load_mobilemenu($attr) { return; // TODO : à maj
		if ( isset($attr['id']) ) {
			$id = (int) $attr['id'];
			$this->callHelpers();
			// load css files in the page
			add_action( 'wp_footer', array('MobilemenuckFrontHelper', 'load_styles') );
			require_once MOBILEMENUCK_PATH . '/models/menu.php';
			$model = new MobilemenuckModelMenu();
			return $model->renderItem($id)->htmlcode;
		}
		return null;
	}

	function replace_mobilemenu($matches) {
		if (! isset($matches[1]) || empty($matches[1])) return null;
		$attr = array("id" => (int)$matches[1]);
		return $this->load_mobilemenu($attr);
	}

	function load_textdomain() {
		load_plugin_textdomain( 'mobile-menu-ck', false, dirname( plugin_basename( __FILE__ ) ) . '/language/'  );
	}

	function load_jquery() {
		wp_enqueue_script('jquery');
		// for the media manager
		wp_enqueue_media();
		// wp_enqueue_script('ck-media', MOBILEMENUCK_MEDIA_URL . '/assets/fields/media.js', array('jquery'));
	}

	function load_mobilemenus() {

		require_once MOBILEMENUCK_PATH . '/helpers/ckfof.php';
		require_once MOBILEMENUCK_PATH . '/helpers/cktext.php';
		require_once MOBILEMENUCK_PATH . '/helpers/ckparams.php';
		require_once(MOBILEMENUCK_PATH . '/helpers/' . MOBILEMENUCK_PLATFORM . '/loader.php');
		require_once MOBILEMENUCK_PATH . '/helpers/menu.php';
		require_once MOBILEMENUCK_PATH . '/helpers/menuhelper.php';

		// load the active menus
		$query = "SELECT * FROM #__mobilemenuck_menus WHERE state = 1";
		$menus = CKFof::dbLoadObjectList($query);

		foreach ($menus as $menu) {
			if ($menu->params) {
				$params = new CKParams(unserialize($menu->params));
			} else {
				$params = new CKParams();
			}

			// if no selector given, continue because the menu can not work 
			if (! $params->get('selector', '')) continue;

			$styleid = $menu->style;
			$id = 'mobilemenuck-' . $menu->id;

			if ($styleid) {
				$styles = \Mobilemenuck\Helper::getStyleById($styleid, 'params,layoutcss,state', 'row');
				if ($styles->state == '1') {
					$layoutcss = $styles->layoutcss;
					\Mobilemenuck\Helper::makeCssReplacement($layoutcss);

					$layoutcss = str_replace('|ID|', '[data-id="' . $id . '"]', $layoutcss);

					$this->styles[$id] = $layoutcss;
				}
			} else {
				$layoutcss = file_get_contents(MOBILEMENUCK_PATH . '/assets/default.txt');
				\Mobilemenuck\Helper::makeCssReplacement($layoutcss);
				$layoutcss = str_replace('|ID|', '[data-id="' . $id . '"]', $layoutcss);
				$this->styles[$id] = $layoutcss;
			}

			// create a unique ID for the menu
			// $menuid = 'mobilemenuck-' . (int) (microtime(true) * 100);
			$menubarbuttoncontent = '&#x2261;';
			$topbarbuttoncontent = '×';
			if ($styleid) {
				$styleParams = json_decode($styles->params);

				$menubarbuttoncontent = \Mobilemenuck\Menu::getButtonContent($styleParams->menubarbuttoncontent, $styleParams);
				$topbarbuttoncontent = \Mobilemenuck\Menu::getButtonContent($styleParams->topbarbuttoncontent, $styleParams);
			}

			\Mobilemenuck\Menu::load($params->get('selector', ''), 
				array(
					'menuid' => $id
					,'menubarbuttoncontent' => $menubarbuttoncontent
					,'topbarbuttoncontent' => $topbarbuttoncontent
					,'showmobilemenutext' => $params->get('showmobilemenutext', 'default', true)
					,'mobilemenutext' => CKText::_($params->get('mobilemenutext', 'Menu'))
					,'container' => $params->get('container', 'body', true)
					,'detectiontype' => $params->get('detectiontype', 'resolution')
					,'resolution' => $params->get('resolution', '800', true)
					,'usemodules' => $params->get('usemodules', '0', true)
					,'useimages' => $params->get('useimages', '0', true)
					,'showlogo' => $params->get('showlogo', '1', true)
					,'showdesc' => $params->get('showdesc', '0', true)
					,'displaytype' => $params->get('displaytype', 'accordion', true)
					,'displayeffect' => $params->get('displayeffect', 'normal', true)
					,'menuwidth' => $params->get('menuwidth', '300', true)
					,'openedonactiveitem' => $params->get('openedonactiveitem', '0', true)
					,'mobilebackbuttontext' => CKText::_($params->get('mobilebackbuttontext', 'Back'))
					,'menuselector' => $params->get('menuselector', 'ul', true)
					// ,'merge' => $merge
					// ,'mergeorder' => $mergeorder
				)
			);
		}

		if (! empty($this->styles)) {
			foreach ($this->styles as $style) {
				\Mobilemenuck\CKLoader::loadStyleDeclaration($style);
			}
		}
	}
}

// get the template creator class
$Mobilemenuck = Mobilemenuck::getInstance();
$Mobilemenuck->init();

add_action('admin_menu', array($Mobilemenuck, 'admin_menu'), 20);


// if we go into the edition interface, we redirect and kill
if ( isset($_REQUEST['page']) 
		&& $_REQUEST['page'] === 'mobilemenuck_edit_style'
		&& isset($_REQUEST['task']) && substr($_REQUEST['task'], 0, 10) === 'style.ajax'
		) {
		add_action('admin_init', '\Mobilemenuck\mobilemenuck_edition_init', 20);
}

function mobilemenuck_edition_init() {
	// get the template creator class
	$Mobilemenuck = Mobilemenuck::getInstance();
	$Mobilemenuck->render_page('style');
	die();
}


// to create and manage the database
require_once(MOBILEMENUCK_PATH . '/helpers/sql.php');
register_activation_hook( __FILE__, 'mobilemenuck_sql_install' );
