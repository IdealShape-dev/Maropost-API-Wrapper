<?php
/**
 * Created by PhpStorm.
 * User: betajo01
 * Date: 1/4/17
 * Time: 9:13 AM
 */

namespace Maropost;

class contacts extends maropost {
	public function __construct()
	{
		parent::__construct();
	}

	//To search a contact with email and get all the details of the contact
	/**
	 * @param $email
	 *
	 * @return mixed
	 */
	function get_contact_by_contact_email ($email) {
		return $this->request( "GET", "contacts/email", array("contact[email]"=>$email));
	}

	//To get a list of contacts
	/**
	 * @param array $contact
	 *
	 * @return mixed
	 */
	function get_contact_lists_by_list_id (array $contact) {
		echo "<pre>";
		var_dump($contact);
		echo "</pre>";
		return $this->request( "GET", "lists/".$contact['contact']['list_id']."/contacts", null);
	}

	//Create a contact without using List id
	/**
	 * @param array $contact
	 *
	 * @return bool|mixed
	 */
	function post_new_contact (array $contact) {
		if ( empty( $contact['contact']['email'] ) ) {
			error_log( "428 - Required field: 'email' missing on post_new_contact method request." );
			return FALSE;
		}

		return $this->request( "POST", "contacts", array("contact" => $contact['contact']));
	}

	//Update the contact information without using list id
	/**
	 * @param $contact
	 *
	 * @return mixed
	 */
	function put_update_contact ($contact) {
		return $this->request( "PUT", "contacts/".$contact['contact_id'], array("contact" => $contact['contact']));
	}

	//To get a contact by both list and contact id as a mixed key
	/**
	 * @param array $contact
	 *
	 * @return mixed
	 */
	function get_contact_by_list_and_contact_ids (array $contact) {
		return $this->request( "GET", "lists/".$contact['list_id']."/contacts/".$contact['contact_id'], null);
	}

	//To create a new contact with a list id
	/**
	 * @param array $contact
	 * @param bool $subscribe
	 *
	 * @return bool|mixed
	 */
	function post_new_contact_into_list (array $contact, $subscribe = false) {
		if ( empty( $contact['list_id'] ) ) {
			error_log( "428 - Required field: 'list_id' missing on post_new_contact method request." );
			return FALSE;
		}
		if ( empty( $contact['contact']['email'] ) ) {
			error_log( "428 - Required field: 'email' missing on post_new_contact method request." );
			return FALSE;
		}
		$contact['contact']['subscribe'] = $contact['contact']['subscribe'] ? : $subscribe;
		//$contact['contact']['remove-from-dnm'] = $subscribe ? true : $subscribe;  //remove-from-dnm does not seem to work.
		return $this->request( "POST", "lists/".$contact['list_id']."/contacts", array("contact" => $contact['contact']));
	}

	//To update a contact with using a list id
	/**
	 * @param array $contact
	 *
	<contact>
		<first-name>api</first-name>
		<email>api_2@email.com</email>
		<phone>1234567890</phone>
		<fax>1234567890</fax>
		<last-name>email</last-name>
		<custom-field>
			<custom-field-1 type="boolean">true</custom-field-1>
			<custom-field-2 nil="true"/>
			<custom-field-3>abc123</custom-field-3>
		</custom-field>
		<add-tags type="array">
			<add-tag>tag_name</add-tag>
			<add-tag>tag_name</add-tag>
		</add-tags>
		<remove-tags type="array">
			<remove-tag>tag_name</remove-tag>
			<remove-tag>tag_name</remove-tag>
		</remove-tags>
		<remove-from-dnm type="boolean">false</remove-from-dnm>
		<options>
		<subscribe-list-ids>21,23,44</subscribe-list-ids>
			<unsubscribe-list-ids>23,44,55</unsubscribe-list-ids>
			<unsubscribe-workflow-ids>3443,43434</unsubscribe-workflow-ids>
		</options>
	</contact>
	 * @return mixed
	 */
	function put_update_contact_by_list_and_contact_id (array $contact) {
		return $this->request( "PUT", "lists/".$contact['list_id']."/contacts/".$contact['contact_id'], array("contact" => $contact['contact']));
	}

	//To get a list of opens for a contact
	function get_list_contact_opens (array $contact) {
		return $this->request( "GET", "contacts/".$contact['contact_id']."/open_report", null);
	}

	//To get a list of clicks for a contact
	function get_list_contact_clicks (array $contact) {
		return $this->request( "GET", "contacts/".$contact['contact_id']."/click_report", null);
	}

	//DELETE contact from a list
	function delete_contact_from_list_by_ids (array $contact) {
		return $this->request( "DELETE", "lists/".$contact['list_id']."/contacts/".$contact['contact_id'], null);
	}

	//Delete a contact from multiple lists with ids
	function delete_contact_from_multiple_by_list_ids (array $contact) {
		return $this->request( "DELETE", "contacts/delete_all", array("list_ids"=>implode(",",$contact['contact']['delete_lists'])));
	}

	//Delete a contact from all lists
	function delete_contact_from_all_list_by_email ($email) {
	    return $this->request( "DELETE", "contacts/delete_all", array("contact[email]"=>$email));
	}

	//Unsubscribe a contact from all lists
	function put_unsubscribe_contact_from_all_lists_by_email ($email) {
		return $this->request( "PUT", "contacts/unsubscribe_all", array("contact[email]"=>$email));
	}

	//Subscribe a contact to multiple lists
	function post_subscribe_contact_to_multiple_by_list_ids (array $contact) {
		return $this->request( "POST", "contacts", array("list_ids"=>implode(",",$contact['contact']['delete_lists'])));
	}
}