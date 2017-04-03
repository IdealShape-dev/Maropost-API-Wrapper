<?php
	/**
	 * Created by PhpStorm.
	 * User: betajo01
	 * Date: 1/13/17
	 * Time: 9:54 AM
	 */

	namespace Maropost;
//most order id parameters refer to original order id.

	class orders extends maropost {
		function get_order_by_id( array $order ) {
			if ( empty( $order['order_id'] ) && empty( $order['where[id]'] ) ) {
				error_log( "428 - Required field: 'order_id' and 'where[id]' missing on get_order_by_id method request. You need at least one of them." );

				return FALSE;
			}
			$url       = "orders";
			$dataArray = NULL;
			$url       = $url . "/" . $order['order_id'];
			if ( ! empty( $order['where[id]'] ) ) {
				$dataArray = array( "where[id]" => $order['where[id]'] );
				$url       = "orders/find";
			}

			return $this->request( "GET", $url, $dataArray );
		}

		function post_new_order( array $order ) {
			//(REQUIRED FIELD) => name, address, language
			//(REQUIRED FIELD) => email, order_date, order_status, original_order_id, order_items
			if (
			empty( $order['order']['contact']['email'] )
			) {
				error_log( "428 - Required field 'email' on post_new_order method request are missing in post_new_order." );

				return FALSE;
			}
			if (

			empty( $order['order']['original_order_id'] )
			) {
				error_log( "428 - Required field 'original_order_id' on post_new_order method request are missing in post_new_order." );

				return FALSE;
			}
			if (

			empty( $order['order']['order_items'] )
			) {
				error_log( "428 - Required field 'order_items' on post_new_order method request are missing in post_new_order." );

				return FALSE;
			}

			//write_log('sending this order date to maropost from mb_maropost_save_order()');
			//write_log($order['order']['order_date']);

			$order['order']['order_date']   = empty( $order['order']['order_date'] ) ?: date( "d M Y", time() );
			$order['order']['order_status'] = empty( $order['order']['order_status'] ) ?: "Pending";
			$this_order                     = array( 'order' => $order['order'] );
			if ( ! empty( $order['unique'] ) ) {
				$this_order['unique'] = TRUE;
			}

			return $this->request( "POST", "orders", $this_order );
		}

		function put_update_order( array $order ) {
			//write_log($order);
			if ( empty( $order['order_id'] ) && empty( $order['where[id]'] ) ) {
				error_log( "428 - Required field: 'order_id' and 'where[id]' missing on put_update_order method request. You need at least one of them." );

				return FALSE;
			}
			$url        = "orders";
			$url        = $url . "/" . $order['order_id'];
			$this_order = $order['order'] ;
			if ( ! empty( $order['where[id]'] ) ) {
				$this_order["where[id]"] = $order['where[id]'];
				$url                     = "orders/find";
			}

			return $this->request( "PUT", $url, $this_order );
		}

		function delete_entire_order( array $order ) {
			if ( !empty($order['delete_order_id']) ) {
				error_log( "428 - Required field: 'delete_order_id' missing on delete_entire_order method request." );
				return FALSE;
			}
			$url       = "orders";
			$dataArray = NULL;
			$url       = $url . "/" . $order['delete_order_id'];
//              (Delete complete eCommerce order if the order is cancelled or returned using unique original order id.)
			if ( ! empty( $order['where[id]'] ) ) {
//				(Delete complete eCommerce order if the order is cancelled or returned using maropost order id.)					$dataArray = array( "where[id]" => $order['where[id]'] );
				$dataArray = array( "where[id]" => $order['where[id]'] );
				$url       = "orders/find";
			}
			return $this->request( "DELETE", $url, $dataArray );
		}

		function delete_products_from_order( array $order  ) {
			if ( !empty($order['delete_order_id']) ) {
				error_log( "428 - Required field: 'delete_order_id' missing on delete_products_from_order method request." );
				return FALSE;
			}
			if ( !empty($order['delete_products']) ) {
				error_log( "428 - Required field: 'delete_products' missing on delete_products_from_order method request." );
				return FALSE;
			}
			$url       = "orders";
			$dataArray = array ("product_ids" => implode( ',', $order['delete_products']));
			$url       = $url . "/" . $order['delete_order_id'];
//              (Delete complete eCommerce order if the order is cancelled or returned using unique original order id.)
			if ( ! empty( $order['where[id]'] ) ) {
//				(Delete complete eCommerce order if the order is cancelled or returned using maropost order id.)					$dataArray = array( "where[id]" => $order['where[id]'] );
				$dataArray["where[id]"] = $order['where[id]'];
				$url       = "orders/find";
			}

			return $this->request( "DELETE", $url, $dataArray );
		}
	}