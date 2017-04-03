<?php
/**
 * Created by PhpStorm.
 * User: betajo01
 * Date: 1/5/17
 * Time: 1:49 PM
 */

namespace Maropost;


class campaigns extends maropost {
	public function __construct()
	{
		parent::__construct();
	}

	//To get a list of delivered reports
	/**
	 * @param array $campaigns
	 *
	 * @return mixed
	 */
	function get_campaigns_delivered_report_by_id (array $campaigns) {
		return $this->request( "GET", "campaigns/".$campaigns['campaign_id']."/delivered_report", null);
	}

	//To get a list of open reports
	function get_campaigns_opened_report_by_id (array $campaigns) {
		$data = $campaigns['unique'] ? array( "unique" => TRUE ) : NULL;
		return $this->request( "GET", "campaigns/".$campaigns['campaign_id']."/opened_report", $data);
	}

	//To get a list of click reports
	function get_campaigns_click_report_by_id (array $campaigns) {
		$data = $campaigns['unique'] ? array( "unique" => TRUE ) : NULL;
		return $this->request( "GET", "campaigns/".$campaigns['campaign_id']."/click_report", $data);
	}
	//To get a list of campaign clicks
	function get_campaigns_link_report_by_id (array $campaigns) {
		$data = $campaigns['unique'] ? array( "unique" => TRUE ) : NULL;
		return $this->request( "GET", "campaigns/".$campaigns['campaign_id']."/link_report", $data);
	}
	//To get a list of bounce reports
	function get_campaigns_bounce_report_by_id (array $campaigns) {
		return $this->request( "GET", "campaigns/".$campaigns['campaign_id']."/bounce_report", null);
	}
	//To get a list of soft bounce reports
	function get_campaigns_soft_bounce_report_by_id (array $campaigns) {
		return $this->request( "GET", "campaigns/".$campaigns['campaign_id']."/soft_bounce_report", null);
	}
	//To get a list of hard bounce reports
	function get_campaigns_hard_bounce_report_by_id (array $campaigns) {
		return $this->request( "GET", "campaigns/".$campaigns['campaign_id']."/hard_bounce_report", null);
	}
	//To get a list of unsubscribe reports
	function get_campaigns_unsubscribe_report_by_id (array $campaigns) {
		return $this->request( "GET", "campaigns/".$campaigns['campaign_id']."/unsubscribe_report", null);
	}
	//To get a list of complaint reports
	function get_campaigns_complaint_report_by_id (array $campaigns) {
		return $this->request( "GET", "campaigns/".$campaigns['campaign_id']."/complaint_report", null);
	}
	//To get a list of campaigns
	function get_campaigns () {
		return $this->request( "GET", "campaigns", null);
	}
	//To create a campaign
	/**
	 * @param array $campaigns
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
		<list-ids type="array">
			<list-id>15</list-id>
			<list-id>24</list-id>
		</list-ids>
		<suppressed-list-ids type="array">
			<suppressed-list-id>5</suppressed-list-id>
			<suppressed-list-id>70</suppressed-list-id>
		</suppressed-list-ids>
		<segment-ids type="array">
			<segment-id>5</segment-id>
			<segment-id>70</segment-id>
		</segment-ids>
		<suppressed-segment-ids type="array">
			<suppressed-segment-id>5</suppressed-segment-id>
			<suppressed-segment-id>70</suppressed-segment-id>
		</suppressed-segment-ids>
		<status>send</status>
	</campaign>
	 */
	function post_campaign (array $campaigns) {
		return $this->request( "POST", "campaigns", array( "campaign" => $campaigns['campaign'] ));
	}

	//To get a campaign
	function get_campaigns_by_id (array $campaigns) {
		return $this->request( "GET", "campaigns/".$campaigns['campaign_id'], null);
	}

	//To schedule a campaign
	function post_campaign_schedule_draft (array $campaigns) {
		$campaigns['campaign']['status'] = 'draft';
		return $this->request( "POST", "campaigns", array( "campaign" => $campaigns['campaign'] ));
	}
	function post_campaign_schedule_test (array $campaigns) {
		$campaigns['campaign']['status'] = 'test';
		return $this->request( "POST", "campaigns", array( "campaign" => $campaigns['campaign'] ));
	}
	function post_campaign_schedule_priority_send (array $campaigns) {
		$campaigns['campaign']['status'] = 'schedule';
		$campaigns['campaign']['send-at'] = !empty($campaigns['campaign']['send-at']) ? $campaigns['campaign']['send-at']: date('Y-n-d G:i:s', time()+1800);//15 min default if empty;
		return $this->request( "POST", "campaigns", array( "campaign" => $campaigns['campaign'] ));
	}
	function post_campaign_schedule_time_optimized (array $campaigns) {
		$campaigns['campaign']['status'] = 'schedule';
		$campaigns['campaign']['send-at'] = !empty($campaigns['campaign']['send-at']) ? $campaigns['campaign']['send-at']: date('Y-n-d G:i:s', time()+1800);//15 min default if empty;
		$campaigns['campaign']['send-type'] = "best_time";
		return $this->request( "POST", "campaigns", array( "campaign" => $campaigns['campaign'] ));
	}
	function post_campaign_schedule_one_time(array $campaigns) {
		$campaigns['campaign']['status'] = 'schedule';
		$campaigns['campaign']['send-at'] = !empty($campaigns['campaign']['send-at']) ? $campaigns['campaign']['send-at']: date('Y-n-d G:i:s', time()+1800);//15 min default if empty;
		$campaigns['campaign']['send-type'] = "one-time";
		return $this->request( "POST", "campaigns", array( "campaign" => $campaigns['campaign'] ));
	}
	function post_campaign_schedule_daily(array $campaigns) {
		$campaigns['campaign']['status'] = 'recurring';
		$campaigns['campaign']['recurring']['schedule'] = 'daily';
		$campaigns['campaign']['recurring-time']['hour'] = !empty($campaigns['campaign']['recurring-time']['hour']) ?$campaigns['campaign']['recurring-time']['hour']:'6';
		$campaigns['campaign']['recurring-time']['minute'] = !empty($campaigns['campaign']['recurring-time']['minute']) ?$campaigns['campaign']['recurring-time']['minute']:'06';
		return $this->request( "POST", "campaigns", array( "campaign" => $campaigns['campaign'] ));
	}
	function post_campaign_schedule_weekly(array $campaigns) {
		$campaigns['campaign']['status'] = 'recurring';
		$campaigns['campaign']['recurring']['schedule'] = 'weekly';
		$campaigns['campaign']['recurring']['weekday'] = !empty($campaigns['campaign']['recurring']['weekday'] ) ?$campaigns['campaign']['recurring']['weekday'] :'6';
		$campaigns['campaign']['recurring-time']['hour'] = !empty($campaigns['campaign']['recurring-time']['hour']) ?$campaigns['campaign']['recurring-time']['hour']:'6';
		$campaigns['campaign']['recurring-time']['minute'] = !empty($campaigns['campaign']['recurring-time']['minute']) ?$campaigns['campaign']['recurring-time']['minute']:'06';
		return $this->request( "POST", "campaigns", array( "campaign" => $campaigns['campaign'] ));
	}
	function post_campaign_schedule_monthly(array $campaigns) {
		$campaigns['campaign']['status'] = 'recurring';
		$campaigns['campaign']['recurring']['schedule'] = 'monthly';
		$campaigns['campaign']['recurring']['day'] = !empty($campaigns['campaign']['recurring']['day'] ) ?$campaigns['campaign']['recurring']['day'] :'6';
		$campaigns['campaign']['recurring-time']['hour'] = !empty($campaigns['campaign']['recurring-time']['hour']) ?$campaigns['campaign']['recurring-time']['hour']:'6';
		$campaigns['campaign']['recurring-time']['minute'] = !empty($campaigns['campaign']['recurring-time']['minute']) ?$campaigns['campaign']['recurring-time']['minute']:'06';
		return $this->request( "POST", "campaigns", array( "campaign" => $campaigns['campaign'] ));
	}
	function post_campaign_schedule_yearly(array $campaigns) {
		$campaigns['campaign']['status'] = 'recurring';
		$campaigns['campaign']['recurring']['schedule'] = 'yearly';
		$campaigns['campaign']['recurring']['day'] = !empty($campaigns['campaign']['recurring']['day'] ) ?$campaigns['campaign']['recurring']['day'] :'6';
		$campaigns['campaign']['recurring']['month'] = !empty($campaigns['campaign']['recurring']['month'] ) ?$campaigns['campaign']['recurring']['month'] :'6';
		$campaigns['campaign']['recurring-time']['hour'] = !empty($campaigns['campaign']['recurring-time']['hour']) ?$campaigns['campaign']['recurring-time']['hour']:'6';
		$campaigns['campaign']['recurring-time']['minute'] = !empty($campaigns['campaign']['recurring-time']['minute']) ?$campaigns['campaign']['recurring-time']['minute']:'06';
		return $this->request( "POST", "campaigns", array( "campaign" => $campaigns['campaign'] ));
	}
	//To delete a campaign
	function delete_campaign_by_id( array $campaigns  ) {
		return $this->request( "DELETE", "campaigns/".$campaigns['campaign_id'], null);
	}
}