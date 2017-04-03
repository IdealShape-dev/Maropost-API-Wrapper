<?php
/**
 * Created by PhpStorm.
 * User: betajo01
 * Date: 1/4/17
 * Time: 9:20 AM
 */

namespace Maropost;


class brands_do_not_mail extends maropost {
	public function __construct() {
		parent::__construct();
	}

	//To get a global_unsubscribes
	/**
	 * @return mixed
	 */
	function get_brand_unsubscribes() {
		return $this->request( "GET", "brand_unsubscribes", null );
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
	function post_brand_unsubscribes(array $list) {
		//(REQUIRED FIELD) => email
		if ( empty( $list['email']) ) {
			error_log( "428 - Required field: 'email' missing on post_brand_unsubscribes method request." );
			return FALSE;
		}
		return $this->request( "POST", "brand_unsubscribes", array ('list' => $list['global_unsubscribe'] ));
	}

	//To search a contact in brand_unsubscribes by email address
	/**
	 * @param $email
	 *
	 * @return mixed
	 */
	function get_search_brand_unsubscribes_by_email ($email, $brand = false) {
		$data =  array ('contact[email]' => $email );
		if($brand) {
			$data['brand'] = $brand;
		}
		return $this->request( "GET", "brand_unsubscribes/email",$data);
	}

	//Delete a contact from Brands Do Not Mail List for all Brands using email address
	/**
	 * @param $email
	 * @param bool || string $brand
	 *
	 * @return mixed
	 */
	function delete_contact_from_brand_unsubscribes_by_email ($email, $brand = false) {
		$data =  array ('contact[email]' => $email );
		if($brand) {
			$data['brand'] = $brand;
		}
		return $this->request( "GET", "brand_unsubscribes/email",$data);
	}
}