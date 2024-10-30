<?php
Namespace Mobilemenuck;
/**
 * @name		Mobile Menu CK
 * @package		mobile-menu-ck
 * @copyright	Copyright (C) 2018. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Cedric Keiflin - https://www.ceikay.com
 */
// No direct access.
defined('CK_LOADED') or die;

/**
 * Mobilemenuck model.
 */
class CKModelMenu {

	var $_item = null;

	private $input;

	private $styleTags;

	function __construct() {
		$this->input = new CKInput();
	}

	public function &getData($id = null) {
		global $wpdb;
		if ($this->_item === null) {
			if ($id) {
				$this->_item = new \stdClass();
				$this->_item = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'mobilemenuck_menus WHERE id=' . (int) $id);
				$this->_item->params =  new CKParams(unserialize($this->_item->params));
			} else {
				$this->_item = new \stdClass();
				$this->_item->id = 0;
				$this->_item->name = '';
				$this->_item->state = '1';
				$this->_item->params = new CKParams();
				$this->_item->style = 0;
			}
		}

		return $this->_item;
	}

	public function save($data) {
		global $wpdb;
		$id = (int) $data['id'];
		$table = $wpdb->prefix . 'mobilemenuck_menus';
		$ck_post = array(
			'id' => $id,
			'name' => $data['name'],
			'state' =>  (int)$data['state'],
			'params' => serialize($data['params']),
			'type' => $data['type'],
			'style' => $data['style'],
		);
		$format = $this->getPostFormat();

		// save the post into the database
		// $wpdb->show_errors();
		if ($id === 0) {
			$save = $wpdb->insert( $table, $ck_post, $format );
			$ck_post_id = $wpdb->insert_id;

		} else {
			$where = array( 'id' => $id );
			$save = $wpdb->update( $table, $ck_post, $where, $format );
			$ck_post_id = $id;
		}
		// $wpdb->print_error();

		$return = $ck_post_id;

		return $return;
	}

	public function getPostFormat() {
		$format = array( 
			'%d',
			'%s',
			'%d',
			'%s',
			'%s'
		);

		return $format;
	}

	public function delete($id) {
		global $wpdb;
		$table = $wpdb->prefix . 'mobilemenuck_menus';
		$where = array( 'id' => (int)$id );
		return $wpdb->delete( $table, $where, $where_format = null );
	}

	public function copy($id) {
		global $wpdb;

		$query = 'SELECT * FROM ' . $wpdb->prefix . 'mobilemenuck_menus WHERE id=' . (int) $id;

		$item = $wpdb->get_row($query);
		$format = $this->getPostFormat();
		$post = $this->getPostData(0, $item->name . '-copy', 0, $item->params, $item->type, $item->style);
		return $wpdb->insert( $wpdb->prefix . 'mobilemenuck_menus', $post, $format );
	}

	public function getPostData($id, $name, $state, $params, $type, $style) {
		$post = array(
			'id' => (int) $id,
			'name' => sanitize_text_field($name),
			'state' => $state,
			'params' => $params,
			'type' => $type,
			'style' => $style
		);

		return $post;
	}
}