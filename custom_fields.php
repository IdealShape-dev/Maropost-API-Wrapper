<?php
/**
 * Created by PhpStorm.
 * User: betajo01
 * Date: 1/4/17
 * Time: 9:14 AM
 */

namespace Maropost;


class custom_fields extends maropost {
	public function __construct()
	{
		parent::__construct();
	}

	//To get a list of custom field definitions
	function get_list_of_custom_fields () {
		return $this->request( "GET", "custom_fields", null);
	}

	//To get a custom field definition
	function get_custom_field_by_id (array $custom_field) {
		return $this->request( "GET", "custom_fields/".$custom_field['field_id'], null);
	}

	//To create a new custom field definition
	function post_new_custom_field (array $custom_field) {
		//(REQUIRED FIELD) => name, field_type
		if ( empty( $custom_field['custom_field']['name'] ) ) {
			error_log( "428 - Required field: 'name' missing on post_new_custom_field method request." );
			return FALSE;
		}
		if ( empty( $custom_field['custom_field']['field_type'] ) ) {
			error_log( "428 - Required field: 'field_type' missing on post_new_custom_field method request." );
			return FALSE;
		}
		if ( empty( $custom_field['custom_field']['default_value'] ) ) {
			$custom_field['custom_field']['default_value'] = 0;
		}
		return $this->request( "POST", "custom_fields", array('custom_field'=>$custom_field['custom_field']));
	}

	//To update a custom field definition
	function put_update_custom_field_by_id (array $custom_field) {
		return $this->request( "PUT", "custom_fields/".$custom_field['field_id'], array('custom_field'=>$custom_field['custom_field']));
	}

	//to delete a custom field definition
	function delete_custom_field_by_id (array $custom_field) {
		return $this->request( "DELETE", "custom_fields/".$custom_field['field_id'], null);
	}
}