<?php
/**
 * Created by PhpStorm.
 * User: betajo01
 * Date: 1/4/17
 * Time: 9:20 AM
 */

namespace Maropost;


class transactional extends maropost  {
	function get_transactional_campaigns(  ) {
		return $this->request( "GET", "transactional_campaigns", null );
	}

	/**
	 * To create a transactional campaign
	 * @param array $transactional_campaigns
	 *
	 * @return mixed
	 *
	<campaign>
		<name>Campaign Final</name>
		<subject>Testing</subject>
		<preheader>Preheader Testing</preheader>
		<from-name>Test</from-name>
		<from-email>test@gmail.com</from-email>
		<reply-to>test@gmail.com</reply-to>
		<content-id>162</content-id>
		<email-preview-link type="boolean">true</email-preview-link>
		<address>Canada </address>
		<language>en</language>
	</campaign>
	 */
	function post_transactional_campaigns( array $transactional_campaigns ) {
		return $this->request( "POST", 'transactional_campaigns', array("campaign" => $transactional_campaigns["transactional_campaigns"]) );
	}

	/**
	 * @param array $transactional_campaigns
	 * http://api.maropost.com/api#trans_campaign_api -- many different versions of this.
	 *
	<email>
		<campaign-id type="integer">9298</campaign-id>
		<contact>
			<email>test@maropost.com</email>
			<first-name>Test</first-name>
			<last-name>Test2</last-name>
			<custom-field>
			<city>Canada</city>
			</custom-field>
		</contact>
	</email>
	 * @return bool|mixed
	 */
	function post_transactional_emails( array $transactional_campaigns ) {
		if ( empty( $transactional_campaigns["transactional_emails"]['campaign-id'] ) ) {
			error_log( "428 - Required field: 'campaign-id' missing on post_transactional_emails method request." );
			return FALSE;
		}
		if ( empty( $transactional_campaigns["transactional_emails"]['contact']['email'] ) ) {
			error_log( "428 - Required field: 'email' missing on post_transactional_emails method request." );
			return FALSE;
		}
		return $this->request( "POST", 'emails/deliver', array("email" => $transactional_campaigns["transactional_emails"]) );
	}
}