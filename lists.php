<?php
	/**
	 * Created by PhpStorm.
	 * User: betajo01
	 * Date: 1/4/17
	 * Time: 9:15 AM
	 */

	namespace Maropost;


	class lists extends maropost {
		public function __construct() {
			parent::__construct();
		}

		//To get a list of lists
		/**
		 * @param bool $no_count
		 *
		 * @return mixed
		 */
		function get_lists( $no_count = FALSE ) {
			$data = $no_count ? array( "no_counts" => TRUE ) : NULL;
			return $this->request( "GET", "lists", $data );
		}

		//To create a new list
		/**
		 * @param array $list
		 *
		 * @return bool|mixed
		 */
		function post_new_list( array $list ) {
			//(REQUIRED FIELD) => name, address, language
			if ( empty( $list['list']['name'] ) ) {
				error_log( "428 - Required field: 'name' missing on post_new_list method request." );
				return FALSE;
			}
			if ( empty( $list['list']['address'] ) ) {
				error_log( "428 - Required field: 'address' missing on post_new_list method request." );
				return FALSE;
			}
			if ( empty( $list['list']['language'] ) ) {
				error_log( "428 - Required field: 'language' missing on post_new_list method request." );
				return FALSE;
			}
			return $this->request( "POST", "lists", array ('list' => $list['list'] ));
		}
		//To get a list
		/**
		 * @param array $list
		 *
		 * @return bool|mixed
		 */
		function get_list_by_id( array $list  ) {
			if ( empty( $list['list_id']) ) {
				error_log( "428 - Required field: 'list_id' missing on get_list_by_id method request." );
				return FALSE;
			}

			return $this->request( "GET", "lists/".$list['list_id'], null );
		}
		//To update a list
		/**
		 * @param array $list
		 *
		 * @return bool|mixed
		 */
		function put_update_list_by_id( array $list  ) {
			if ( empty( $list['list_id']) ) {
				error_log( "428 - Required field: 'list_id' missing on put_update_list_by_id method request." );
				return FALSE;
			}

			return $this->request( "PUT", "lists/".$list['list_id'], array ('list' => $list['list'] ));
		}

		//To ftp import a list
		/**
		 * @param array $list
		 *
		 * @return bool|mixed
		 * Example as XML Structure for readability (we use JSON):
			<list>
				<ftp-file>customer.csv</ftp-file>
				<delimiter>Comma</delimiter>
				<mappings>
					<email>email</email>
					<first-name>firstname</first-name>
					<phone>phonenumber</phone>
					<city>city</city>
					<sex>gender</sex>
				</mappings>
				<subscribed>status</subscribed>
				<import-options>
					<import-new-contacts>yes</import-new-contacts>
					<update-contacts>yes</update-contacts>
					<disable-workflows>no</disable-workflows>
				</import-options>
			</list>
		 */
		function put_ftp_import_list_by_id( array $list  ) {
			if ( empty( $list['list_id']) ) {
				error_log( "428 - Required field: 'list_id' missing on put_ftp_import_list_by_id method request." );
				return FALSE;
			}

			return $this->request( "PUT", "lists/".$list['list_id']."/ftp_import", array ('list' => $list['list'] ));
		}

		//Delete a list
		function delete_list_by_id( array $list  ) {
			return $this->request( "DELETE", "lists/".$list['list_id'], null);
		}
	}