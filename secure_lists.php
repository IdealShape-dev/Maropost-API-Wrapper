<?php
/**
 * Created by PhpStorm.
 * User: betajo01
 * Date: 1/4/17
 * Time: 9:15 AM
 */

namespace Maropost;


class secure_lists extends maropost {
	public function __construct() {
		parent::__construct();
	}

	//To get a list of lists
	function get_list_of_secure_lists( $no_count = FALSE ) {
		$data = $no_count ? array( "no_counts" => TRUE ) : NULL;
		return $this->request( "GET", "secure_lists", $data );
	}
	//To create a new list
	function post_new_secure_list( array $list ) {
		//(REQUIRED FIELD) => NONE - But we will check for name anyway
		if ( empty( $list['list']['name'] ) ) {
			error_log( "428 - Required field: 'name' missing on post_new_secure_list method request." );
			return FALSE;
		}

		return $this->request( "POST", "secure_lists", array ('list' => $list['secure_list'] ));
	}
	//To get a list
	function get_secure_list_by_id( array $list  ) {
		if ( empty( $list['list_id']) ) {
			error_log( "428 - Required field: 'list_id' missing on get_secure_list_by_id method request." );
			return FALSE;
		}

		return $this->request( "GET", "secure_lists/".$list['list_id'], null );
	}
	//To update a list
	//To get a list
	function put_update_secure_list_by_id( array $list  ) {
		if ( empty( $list['list_id']) ) {
			error_log( "428 - Required field: 'list_id' missing on put_update_secure_list_by_id method request." );
			return FALSE;
		}

		return $this->request( "PUT", "secure_lists/".$list['list_id'], array ('list' => $list['secure_list'] ));
	}

	//To ftp import a list
	function put_ftp_import_secure_list_by_id( array $list  ) {
		if ( empty( $list['list_id']) ) {
			error_log( "428 - Required field: 'list_id' missing on put_ftp_import_secure_list_by_id method request." );
			return FALSE;
		}

		return $this->request( "PUT", "secure_lists/".$list['list_id']."/import", array ('list' => $list['secure_list'] ));
	}

	//Delete a list
	function delete_secure_list_by_id( array $list  ) {
		return $this->request( "DELETE", "secure_lists/".$list['list_id'], null);
	}
}