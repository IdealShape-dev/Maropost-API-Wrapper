<?php
/**
 * Created by PhpStorm.
 * User: betajo01
 * Date: 1/4/17
 * Time: 9:15 AM
 */

namespace Maropost;


class do_not_mail extends maropost {
	public function __construct() {
		parent::__construct();
	}

	//To get a global_unsubscribes
	/**
	 * @return mixed
	 */
	function get_global_unsubscribes() {
		return $this->request( "GET", "global_unsubscribes", null );
	}

	//To add new email address to DNM list
	/**
	 * @param array $list
	 *
	 * @return bool|mixed
	 *
		<global-unsubscribe>
			<email>demo@email.com</email>
		</global-unsubscribe>
	 */
	function post_global_unsubscribes(array $list) {
		//(REQUIRED FIELD) => email
		if ( empty( $list['email']) ) {
			error_log( "428 - Required field: 'email' missing on post_global_unsubscribes method request." );
			return FALSE;
		}
		return $this->request( "POST", "global_unsubscribes", array ('list' => $list['global_unsubscribe'] ));
	}

	//To search a contact in global_unsubscribes by email address
	/**
	 * @param $email
	 *
	 * @return mixed
	 */
	function get_search_global_unsubscribes_by_email ($email) {
		return $this->request( "GET", "global_unsubscribes/email", array ('contact[email]' => $email ));
	}
}