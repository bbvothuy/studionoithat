<?php namespace GoCart\Controller;
/**
 * AdminReports Class
 *
 * @package     GoCart
 * @subpackage  Controllers
 * @category    AdminReports
 * @author      Clear Sky Designs
 * @link        http://gocartdv.com
 */

class AdminReports extends Admin {

    var $customer_id = false;

    function __construct()
    {
        parent::__construct();
        \CI::auth()->check_access('Admin', true);
        \CI::load()->model(['Orders', 'Search']);
        \CI::load()->helper(array('formatting'));
        \CI::lang()->load('reports');
    }

    function index()
    {
		$data['zones'] = \CI::Locations()->get_zones_menu(230);
        $data['page_title'] = lang('reports');
        $data['years'] = \CI::Orders()->getSalesYears();
        $this->view('reports', $data);
    }

    function best_sellers()
    {			
		if(\CI::input()->post('type_report') == 'detail-report'){
			$this->sale_report_detail();
		}else{
			$start = \CI::input()->post('start');
			$end = \CI::input()->post('end');
			$data['best_sellers'] = \CI::Orders()->getBestSellers($start, $end);

			$this->partial('reports/best_sellers', $data);
		}        
    }

    function sales()
    {
        $data['year'] = \CI::input()->post('year');
        $data['orders'] = \CI::Orders()->getGrossMonthlySales($data['year']);

        $this->partial('reports/sales', $data);
    }
	
	function sale_report_detail(){
		$key_search 	= \CI::input()->post('key_search');
		$start 			= \CI::input()->post('sellers_start_alt');
        $end 			= \CI::input()->post('sellers_end_alt');
		$status 		= \CI::input()->post('status');
		$zone 			= \CI::input()->post('zone');
		$province 		= \CI::input()->post('country_zone');
		//$customer_name 	= \CI::input()->post('customer_name');
		//$phone 			= \CI::input()->post('phone');
		//$email 			= \CI::input()->post('email');
		$type_search 		= \CI::input()->post('type_search');
		$group_by 			= \CI::input()->post('group_by');
		$condition = array(
			'start' 	=> $start,
			'end' 		=> $end,
			'status' 	=> $status,
			'zone' 		=> $zone,
			'country_zone' 	=> $province,
			'type_search' 	=> $type_search,
			'key_search'	=> trim($key_search),
			'group_by'		=> $group_by
		);
        $data['report_details'] = \CI::Orders()->sale_report_detail($condition);
		$data['condition'] = $condition;
		//echo \CI::db()->last_query();
		//print_r($data['best_sellers']);
		//exit;
        $this->partial('reports/filter_detail', $data);
		
	}
}
