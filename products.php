<?php
	/**
	 * Created by PhpStorm.
	 * User: betajo01
	 * Date: 1/4/17
	 * Time: 9:20 AM
	 */

	namespace Maropost;


	class products extends maropost {
		public function __construct()
		{
			parent::__construct();
		}

		function get_products( ) {
			return $this->request( "GET", "products", null);
		}

		function get_product_by_maripost_id( $product_id ) {
			return $this->request( "GET", "products/".$product_id, null);
		}

		function get_product_by_item_id( $item_id ) {
			$listing = $this->get_products();
			//write_log($listing);
			$retVal = false;
			if($listing['http_status'] == 200 && count($listing) >= 1) {
				foreach($listing as $product) {

					if($product['item_id'] == $item_id) {
						$retVal =  $product;
						//write_log("found $item_id");
						break;
					}
				}
			}
			return $retVal;
		}

		function post_new_product( array $product) {
			if ( empty( $product['product']['item_id'] ) ) {
				error_log( "428 - Required field: 'item_id' missing on post_new_product method request." );
				return FALSE;
			}
			return $this->request( "POST", "products", $product);
		}

		function put_update_product(  array $products) {
			if ( empty( $products['id'] ) ) {
				error_log( "428 - Required field: Maropost specific 'id' missing on put_update_product method request." );
				return FALSE;
			}
			return $this->request( "PUT", "products/".$products['id'], $products['product']);
		}

		function delete_product( $product_id ) {
			return $this->request( "DELETE", "products/".$product_id, null);
		}
	}