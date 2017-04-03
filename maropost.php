<?php
	/**
	 * Created by PhpStorm.
	 * User: betajo01
	 * Date: 1/4/17
	 * Time: 8:57 AM
	 */

	/**
	 * http://api.maropost.com/api
	 * Wrapper for communication to the Maropost system via JSON api
	 * You may need to refer to the above page to figure out what post/put body fields are accepted/required.
	 * Sub classes will check for required fields and return false rather then throwing a system error if validation fails.
	 * An error log entry is added for these validation fails describing what the error is, and in which method.
	 * i.e. 428 - Required Field "foo" missing in method bar.
	 * Note: HTTP status code 428 is 'Precondition Required' and is used for validation errors.
	 */

	namespace Maropost;

	class maropost {

		public $page = 1;

		//Connect info
		public $auth_token = "### Token here";
		public $url_api = "http://api.maropost.com/accounts/###/";

		public function __construct( $auth_token = FALSE, $api_url = FALSE ) {
			$this->auth_token = $auth_token ?: $this->auth_token;
			$this->url_api    = $api_url ?: $this->url_api;
		}

		public function request( $action, $endpoint, $dataArray, $options = FALSE ) {
			if ( $this->page > 1 || $options['page'] > 1 ) {
				$dataArray['page'] = $this->page > 1 ? $this->page : $options['page'];
			}

			$auth_token = ! empty( $options['auth_token'] ) ? $options['auth_token'] : $this->auth_token;
			$url_api    = ! empty( $options['url_api'] ) ? $options['url_api'] : $this->url_api;

			$url = $url_api . $endpoint . ".json";
			$ch  = curl_init();

			if ( $action == "GET" ) {
				$newURL = json_encode( $dataArray );
				$newURL = str_replace( "{", "", $newURL );
				$newURL = str_replace( "}", "", $newURL );
				$newURL = str_replace( ":", "=", $newURL );
				$newURL = str_replace( ",", "&", $newURL );
				$newURL = str_replace( '"', "", $newURL );
				$url    = $newURL !== 'null' && ! empty( $newURL ) ? $url . "?" . $newURL : $url;
				echo $url . "<br/>";
				$json = json_encode( array( 'auth_token' => $auth_token ) );
			} else {
				$dataArray['auth_token'] = $auth_token;
				$json                    = json_encode( $dataArray );
			}

			//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			//curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "$action" );
			if ( $action = "POST" ) {
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $json );
			}
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
				'Content-type: application/json',
				'Accept: application/json'
			) );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
			curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
			$output         = curl_exec( $ch );
			$curlinfo       = curl_getinfo( $ch );
			$content_length = $curlinfo["download_content_length"];
			$http_code      = $curlinfo["http_code"];

			//error_log($json);
			//error_log($url);
			//error_log($http_code);
			//error_log($output);
			if ( $output === FALSE ) {
				printf( "cUrl error (#%d): %s<br>\n", curl_errno( $ch ),
					htmlspecialchars( curl_error( $ch ) ) );
			}
			$decoded                = json_decode( $output, TRUE );
			$decoded['http_status'] = $http_code;
			$decoded['http_request_url'] = $http_code;
			$decoded['http_request_json'] = $json;
			curl_close( $ch );

			return $decoded;
		}

		function check_maropost_class_path( $file ) {
			$path = getcwd();
			//error_log('attempting to load '. $path . "/" . $file . ".php" );
			if ( ! file_exists( $path ) ) {
				error_log( $file . ' Class not found in ' . $path );
				die();
			}

			return TRUE;
		}

		function load_maropost_class( $class ) {
			$this->check_maropost_class_path( $class );
			$path = getcwd() . "/";
			$path = $path . $class . ".php";
			include_once( $path );
			$class = "\\Maropost\\" . $class;

			return new $class();
		}

		function campaigns() {
			return $this->load_maropost_class( 'campaigns' );
		}

		function contacts() {
			return $this->load_maropost_class( 'contacts' );
		}

		function content_image() {
			return $this->load_maropost_class( 'content_image' );
		}

		function contents() {
			return $this->load_maropost_class( 'contents' );
		}

		function custom_fields() {
			return $this->load_maropost_class( 'custom_fields' );
		}

		function do_not_mail() {
			return $this->load_maropost_class( 'do_not_mail' );
		}

		function do_not_mail_brands() {
			return $this->load_maropost_class( 'brands_do_not_mail' );
		}

		function journeys() {
			return $this->load_maropost_class( 'journeys' );
		}

		//deprecated by journeys();
		function workflows() {
			return $this->load_maropost_class( 'workflows' );
		}

		function lists() {
			return $this->load_maropost_class( 'lists' );
		}

		function orders() {
			return $this->load_maropost_class( 'orders' );
		}

		function products() {
			return $this->load_maropost_class( 'products' );
		}

		function push_notifications() {
			return $this->load_maropost_class( 'push_notifications' );
		}

		function relational_tables() {
			return $this->load_maropost_class( 'relational_tables' );
		}

		function reports() {
			return $this->load_maropost_class( 'reports' );
		}

		function secure_lists() {
			return $this->load_maropost_class( 'secure_lists' );
		}

		function tags() {
			return $this->load_maropost_class( 'tags' );
		}

		function transactional_emails() {
			return $this->load_maropost_class( 'transactional' );
		}


	}
